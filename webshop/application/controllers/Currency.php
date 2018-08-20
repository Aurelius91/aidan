<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency extends CI_Controller
{
	private $_setting;
	private $_user;
	private $_acl;
	private $_has_image;

	public function __construct()
	{
		parent:: __construct();

		$user_id = $this->session->userdata('user_id');

		if ($user_id > 0)
		{
			$this->_user = $this->core_model->get('user', $user_id);
			$this->_setting = $this->setting_model->load();
			$this->_acl = $this->cms_function->generate_acl($this->_user->id);

			$this->_user->address = $this->cms_function->trim_text($this->_user->address);
			$this->_setting->company_address = $this->cms_function->trim_text($this->_setting->company_address);
			$this->_user->image_name = $this->cms_function->generate_image('user', $this->_user->id);

			$this->_has_image = 0;
		}
		else
		{
			redirect(base_url() . 'login/');
		}
	}




	public function add()
	{
		$acl = $this->_acl;

		if (!isset($acl['currency']) || $acl['currency']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Currency';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('currency_add', $arr_data);
	}

	public function edit($currency_id = 0)
	{
		$acl = $this->_acl;

		if ($currency_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['currency']) || $acl['currency']->edit <= 0)
		{
			redirect(base_url());
		}

		$currency = $this->core_model->get('currency', $currency_id);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Currency';
		$arr_data['currency'] = $currency;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('currency_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['currency']) || $acl['currency']->list <= 0)
		{
			redirect(base_url());
		}

		$query = ($query != '') ? base64_decode($query) : '';

		if ($query != '')
		{
			$this->db->like('name', $query);
		}

		if ($filter == 'all')
		{
			$this->db->like('name', $query);
		}
		else
		{
			$this->db->like($filter, $query);
		}

		$this->db->limit($this->_setting->setting__limit_page, ($page - 1) * $this->_setting->setting__limit_page);
		$this->db->order_by("name");
		$arr_currency = $this->core_model->get('currency');

		foreach ($arr_currency as $currency)
		{
			$currency->currency_exchange = number_format($currency->currency_exchange, 0, '.', ',');
			$currency->currency_real = number_format($currency->currency_real, 0, '.', ',');
		}

		if ($query != '')
		{
			$this->db->like('name', $query);
		}

		if ($filter == 'all')
		{
			$this->db->like('name', $query);
		}
		else
		{
			$this->db->like($filter, $query);
		}

		$count_currency = $this->core_model->count('currency');
		$count_page = ceil($count_currency / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Currency';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_currency'] = $arr_currency;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('currency', $arr_data);
	}




	public function ajax_add()
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['currency']) || $acl['currency']->add <= 0)
			{
				throw new Exception('You have no access to add currency. Please contact your administrator.');
			}

			$currency_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$currency_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$this->_validate_add($currency_record);

			$currency_id = $this->core_model->insert('currency', $currency_record);
			$currency_record['id'] = $currency_id;
			$currency_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($currency_record['id'], 'add', $currency_record, array(), 'currency');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('currency_id' => $currency_id));
			}

			$this->db->trans_complete();
		}
		catch (Exception $e)
		{
			$json['message'] = $e->getMessage();
			$json['status'] = 'error';

			if ($json['message'] == '')
			{
				$json['message'] = 'Server error.';
			}
		}

		echo json_encode($json);
	}

	public function ajax_change_status($currency_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($currency_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['currency']) || $acl['currency']->edit <= 0)
			{
				throw new Exception('You have no access to edit currency. Please contact your administrator.');
			}

			$old_currency = $this->core_model->get('currency', $currency_id);

			$old_currency_record = array();

			foreach ($old_currency as $key => $value)
			{
				$old_currency_record[$key] = $value;
			}

			$currency_record = array();

			foreach ($_POST as $k => $v)
			{
				$currency_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('currency', $currency_id, $currency_record);
			$currency_record['id'] = $currency_id;
			$currency_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log('status', $currency_record, $old_currency_record, 'currency');

			$this->db->trans_complete();
		}
		catch (Exception $e)
		{
			$json['message'] = $e->getMessage();
			$json['status'] = 'error';

			if ($json['message'] == '')
			{
				$json['message'] = 'Server error.';
			}
		}

		echo json_encode($json);
	}

	public function ajax_delete($currency_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($currency_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['currency']) || $acl['currency']->delete <= 0)
			{
				throw new Exception('You have no access to delete currency. Please contact your administrator.');
			}

			$currency = $this->core_model->get('currency', $currency_id);
			$updated = $_POST['updated'];
			$currency_record = array();

			foreach ($currency as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another currency. Please refresh the page.');
				}
				else
				{
					$currency_record[$k] = $v;
				}
			}

			$this->_validate_delete($currency_id);

			$this->core_model->delete('currency', $currency_id);
			$currency_record['id'] = $currency->id;
			$currency_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($currency_record['id'], 'delete', $currency_record, array(), 'currency');

			if ($this->_has_image > 0)
			{
				$this->db->where('currency_id', $currency_id);
	            $arr_image = $this->core_model->get('image');

	            foreach ($arr_image as $image)
	            {
	                unlink("images/website/{$image->id}.{$image->ext}");

	                $this->core_model->delete('image', $image->id);
	            }
			}

			$this->db->trans_complete();
		}
		catch (Exception $e)
		{
			$json['message'] = $e->getMessage();
			$json['status'] = 'error';

			if ($json['message'] == '')
			{
				$json['message'] = 'Server error.';
			}
		}

		echo json_encode($json);
	}

	public function ajax_edit($currency_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['currency']) || $acl['currency']->edit <= 0)
			{
				throw new Exception('You have no access to edit currency. Please contact your administrator.');
			}

			$old_currency = $this->core_model->get('currency', $currency_id);

			$old_currency_record = array();

			foreach ($old_currency as $key => $value)
			{
				$old_currency_record[$key] = $value;
			}

			$currency_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'updated')
				{
					if ($v != $old_currency_record[$k])
					{
						throw new Exception('This data has been updated by another user. Please refresh the page.');
					}
				}
				elseif ($k == 'image_id')
                {
                    $image_id = $v;
                }
				else
				{
					$currency_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($currency_id, $currency_record);

			$this->core_model->update('currency', $currency_id, $currency_record);
			$currency_record['id'] = $currency_id;
			$currency_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($currency_record['id'], 'edit', $currency_record, $old_currency_record, 'currency');

			if ($image_id > 0)
            {
                $this->db->where('currency_id', $currency_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('currency_id' => $currency_id));
            }

			$this->db->trans_complete();
		}
		catch (Exception $e)
		{
			$json['message'] = $e->getMessage();
			$json['status'] = 'error';

			if ($json['message'] == '')
			{
				$json['message'] = 'Server error.';
			}
		}

		echo json_encode($json);
	}

	public function ajax_get($currency_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($currency_id <= 0)
			{
				throw new Exception();
			}

			$currency = $this->core_model->get('currency', $currency_id);
			$currency->currency_exchange = number_format($currency->currency_exchange, 0, '', '');
			$currency->currency_real = number_format($currency->currency_real, 0, '', '');

			$json['currency'] = $currency;
		}
		catch (Exception $e)
		{
			$json['message'] = $e->getMessage();
			$json['status'] = 'error';

			if ($json['message'] == '')
			{
				$json['message'] = 'Server error.';
			}
		}

		echo json_encode($json);
	}




	private function _validate_add($currency_record)
	{
		$this->db->where('name', $currency_record['name']);
		$count_user = $this->core_model->count('currency');

		if ($count_user > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($currency_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $currency_id);
		$count_user = $this->core_model->count('currency');

		if ($count_user > 0)
		{
			throw new Exception('Data cannot be deleted.');
		}
	}

	private function _validate_edit($currency_id, $currency_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $currency_id);
		$count_user = $this->core_model->count('currency');

		if ($count_user > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $currency_id);
		$this->db->where('name', $currency_record['name']);
		$count_user = $this->core_model->count('currency');

		if ($count_user > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}