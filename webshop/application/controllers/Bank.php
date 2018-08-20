<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends CI_Controller
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

			$this->_has_image = 1;
		}
		else
		{
			redirect(base_url() . 'login/');
		}
	}




	public function add()
	{
		$acl = $this->_acl;

		if (!isset($acl['bank']) || $acl['bank']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Bank';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('bank_add', $arr_data);
	}

	public function edit($bank_id = 0)
	{
		$acl = $this->_acl;

		if ($bank_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['bank']) || $acl['bank']->edit <= 0)
		{
			redirect(base_url());
		}

		$bank = $this->core_model->get('bank', $bank_id);
		$bank->image_name = '';

		$this->db->where('bank_id', $bank->id);
		$arr_image = $this->core_model->get('image');

		if (count($arr_image) > 0)
		{
			$bank->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Bank';
		$arr_data['bank'] = $bank;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('bank_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['bank']) || $acl['bank']->list <= 0)
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
		$arr_bank = $this->core_model->get('bank');

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

		$count_bank = $this->core_model->count('bank');
		$count_page = ceil($count_bank / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Bank';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_bank'] = $arr_bank;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('bank', $arr_data);
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

			if (!isset($acl['bank']) || $acl['bank']->add <= 0)
			{
				throw new Exception('You have no access to add bank. Please contact your administrator.');
			}

			$bank_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$bank_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

            $this->_validate_add($bank_record);

			$bank_id = $this->core_model->insert('bank', $bank_record);
			$bank_record['id'] = $bank_id;
			$bank_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($bank_record['id'], 'add', $bank_record, array(), 'bank');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('bank_id' => $bank_id));
			}

			$json['bank_id'] = $bank_id;

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

	public function ajax_change_status($bank_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($bank_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['bank']) || $acl['bank']->edit <= 0)
			{
				throw new Exception('You have no access to edit bank. Please contact your administrator.');
			}

			$old_bank = $this->core_model->get('bank', $bank_id);

			$old_bank_record = array();

			foreach ($old_bank as $key => $value)
			{
				$old_bank_record[$key] = $value;
			}

			$bank_record = array();

			foreach ($_POST as $k => $v)
			{
				$bank_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('bank', $bank_id, $bank_record);
			$bank_record['id'] = $bank_id;
			$bank_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($bank_id, 'status', $bank_record, $old_bank_record, 'bank');

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

	public function ajax_delete($bank_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($bank_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['bank']) || $acl['bank']->delete <= 0)
			{
				throw new Exception('You have no access to delete bank. Please contact your administrator.');
			}

			$bank = $this->core_model->get('bank', $bank_id);
			$updated = $_POST['updated'];
			$bank_record = array();

			foreach ($bank as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$bank_record[$k] = $v;
				}
			}

			$this->_validate_delete($bank_id);

			$this->core_model->delete('bank', $bank_id);
			$bank_record['id'] = $bank->id;
			$bank_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($bank_record['id'], 'delete', $bank_record, array(), 'bank');

			if ($this->_has_image > 0)
			{
				$this->db->where('bank_id', $bank_id);
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

	public function ajax_edit($bank_id)
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

			if (!isset($acl['bank']) || $acl['bank']->edit <= 0)
			{
				throw new Exception('You have no access to edit bank. Please contact your administrator.');
			}

			$old_bank = $this->core_model->get('bank', $bank_id);

			$old_bank_record = array();

			foreach ($old_bank as $key => $value)
			{
				$old_bank_record[$key] = $value;
			}

			$bank_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$bank_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($bank_id, $bank_record);

			$this->core_model->update('bank', $bank_id, $bank_record);
			$bank_record['id'] = $bank_id;
			$bank_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($bank_record['id'], 'edit', $bank_record, $old_bank_record, 'bank');

			if ($image_id > 0)
            {
                $this->db->where('bank_id', $bank_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('bank_id' => $bank_id));
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

	public function ajax_get($bank_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($bank_id <= 0)
			{
				throw new Exception();
			}

			$bank = $this->core_model->get('bank', $bank_id);

			$json['bank'] = $bank;
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




	private function _validate_add($bank_record)
	{
		$this->db->where('name', $bank_record['name']);
		$count_bank = $this->core_model->count('bank');

		if ($count_bank > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($bank_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $bank_id);
		$count_bank = $this->core_model->count('bank');

		if ($count_bank > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($bank_id, $bank_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $bank_id);
		$count_bank = $this->core_model->count('bank');

		if ($count_bank > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $bank_id);
		$this->db->where('name', $bank_record['name']);
		$count_bank = $this->core_model->count('bank');

		if ($count_bank > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}