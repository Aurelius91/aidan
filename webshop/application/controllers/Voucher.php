<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Voucher extends CI_Controller
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

		if (!isset($acl['voucher']) || $acl['voucher']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'voucher';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('voucher_add', $arr_data);
	}

	public function edit($voucher_id = 0)
	{
		$acl = $this->_acl;

		if ($voucher_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['voucher']) || $acl['voucher']->edit <= 0)
		{
			redirect(base_url());
		}

		$voucher = $this->core_model->get('voucher', $voucher_id);
		$voucher->address = $this->cms_function->trim_text($voucher->address);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'voucher';
		$arr_data['voucher'] = $voucher;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('voucher_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['voucher']) || $acl['voucher']->list <= 0)
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
		$arr_voucher = $this->core_model->get('voucher');

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

		$count_voucher = $this->core_model->count('voucher');
		$count_page = ceil($count_voucher / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'voucher';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_voucher'] = $arr_voucher;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('voucher', $arr_data);
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

			if (!isset($acl['voucher']) || $acl['voucher']->add <= 0)
			{
				throw new Exception('You have no access to add voucher. Please contact your administrator.');
			}

			$voucher_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$voucher_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$this->_validate_add($voucher_record);

			$voucher_id = $this->core_model->insert('voucher', $voucher_record);
			$voucher_record['id'] = $voucher_id;
			$voucher_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($voucher_record['id'], 'add', $voucher_record, array(), 'voucher');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('voucher_id' => $voucher_id));
			}

			// generate voucher_code
			for ($i = 1; $i <= $voucher_record['quantity']; $i++)
			{
				$voucher_code_record = array();
				$voucher_code_record['voucher_id'] = $voucher_id;
				$voucher_code_record['number'] = $this->cms_function->generate_random_number('voucher_code', 10);
				$voucher_code_record['value'] = $voucher_record['value'];
				$voucher_code_record['status'] = 'Vacant';

				$voucher_code_record['voucher_type'] = (isset($voucher_record['type'])) ? $voucher_record['type'] : '';
				$voucher_code_record['voucher_number'] = (isset($voucher_record['number'])) ? $voucher_record['number'] : '';
				$voucher_code_record['voucher_name'] = (isset($voucher_record['name'])) ? $voucher_record['name'] : '';
				$voucher_code_record['voucher_date'] = (isset($voucher_record['date'])) ? $voucher_record['date'] : '';
				$voucher_code_record['voucher_status'] = (isset($voucher_record['status'])) ? $voucher_record['status'] : '';
				$this->core_model->insert('voucher_code', $voucher_code_record);
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

	public function ajax_change_status($voucher_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($voucher_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['voucher']) || $acl['voucher']->edit <= 0)
			{
				throw new Exception('You have no access to edit voucher. Please contact your administrator.');
			}

			$old_voucher = $this->core_model->get('voucher', $voucher_id);

			$old_voucher_record = array();

			foreach ($old_voucher as $key => $value)
			{
				$old_voucher_record[$key] = $value;
			}

			$voucher_record = array();

			foreach ($_POST as $k => $v)
			{
				$voucher_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('voucher', $voucher_id, $voucher_record);
			$voucher_record['id'] = $voucher_id;
			$voucher_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log('status', $voucher_record, $old_voucher_record, 'voucher');

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

	public function ajax_delete($voucher_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($voucher_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['voucher']) || $acl['voucher']->delete <= 0)
			{
				throw new Exception('You have no access to delete voucher. Please contact your administrator.');
			}

			$voucher = $this->core_model->get('voucher', $voucher_id);
			$updated = $_POST['updated'];
			$voucher_record = array();

			foreach ($voucher as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another voucher. Please refresh the page.');
				}
				else
				{
					$voucher_record[$k] = $v;
				}
			}

			$this->_validate_delete($voucher_id);

			$this->core_model->delete('voucher', $voucher_id);
			$voucher_record['id'] = $voucher->id;
			$voucher_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($voucher_record['id'], 'delete', $voucher_record, array(), 'voucher');

			if ($this->_has_image > 0)
			{
				$this->db->where('voucher_id', $voucher_id);
	            $arr_image = $this->core_model->get('image');

	            foreach ($arr_image as $image)
	            {
	                unlink("images/website/{$image->id}.{$image->ext}");

	                $this->core_model->delete('image', $image->id);
	            }
			}

			// delete voucher_code
			$this->db->where('voucher_id', $voucher_id);
			$this->db->where('status', 'Vacant');
			$this->core_model->delete('voucher_code');

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

	public function ajax_edit($voucher_id)
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

			if (!isset($acl['voucher']) || $acl['voucher']->edit <= 0)
			{
				throw new Exception('You have no access to edit voucher. Please contact your administrator.');
			}

			$old_voucher = $this->core_model->get('voucher', $voucher_id);

			$old_voucher_record = array();

			foreach ($old_voucher as $key => $value)
			{
				$old_voucher_record[$key] = $value;
			}

			$voucher_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'updated')
				{
					if ($v != $old_voucher_record[$k])
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
					$voucher_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($voucher_id, $voucher_record);

			$this->core_model->update('voucher', $voucher_id, $voucher_record);
			$voucher_record['id'] = $voucher_id;
			$voucher_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($voucher_record['id'], 'edit', $voucher_record, $old_voucher_record, 'voucher');
			$this->cms_function->update_foreign_field(array('sale', 'sale_item', 'voucher_code'), $voucher_record, 'voucher');

			// count all voucher
			$this->db->where('voucher_id', $voucher_id);
			$this->db->where('status', 'Vacant');
			$old_voucher_quantity = $this->core_model->count('voucher_code');

			if ($old_voucher_quantity > $voucher_record['quantity'])
			{
				throw new Exception("Voucher Quantity cannot be less than the actual quantity");
			}

			$qty = $voucher_record['quantity'] - $old_voucher_quantity;

			for ($i = 1; $i <= $qty; $i++)
			{
				$voucher_code_record = array();
				$voucher_code_record['voucher_id'] = $voucher_id;
				$voucher_code_record['number'] = $this->cms_function->generate_random_number('voucher_code', 10);
				$voucher_code_record['value'] = $voucher_record['value'];
				$voucher_code_record['status'] = 'Vacant';

				$voucher_code_record['voucher_type'] = (isset($voucher_record['type'])) ? $voucher_record['type'] : '';
				$voucher_code_record['voucher_number'] = (isset($voucher_record['number'])) ? $voucher_record['number'] : '';
				$voucher_code_record['voucher_name'] = (isset($voucher_record['name'])) ? $voucher_record['name'] : '';
				$voucher_code_record['voucher_date'] = (isset($voucher_record['date'])) ? $voucher_record['date'] : '';
				$voucher_code_record['voucher_status'] = (isset($voucher_record['status'])) ? $voucher_record['status'] : '';
				$this->core_model->insert('voucher_code', $voucher_code_record);
			}

			if ($image_id > 0)
            {
                $this->db->where('voucher_id', $voucher_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('voucher_id' => $voucher_id));
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

	public function ajax_get($voucher_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($voucher_id <= 0)
			{
				throw new Exception();
			}

			$voucher = $this->core_model->get('voucher', $voucher_id);
			$voucher->value_display = number_format($voucher->value, 0, '', '');

			$this->db->where('voucher_id', $voucher->id);
			$this->db->where('status', 'Vacant');
			$voucher->quantity_display = $this->core_model->count('voucher_code');

			$json['voucher'] = $voucher;
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




	private function _validate_add($voucher_record)
	{
		$this->db->where('name', $voucher_record['name']);
		$count_voucher = $this->core_model->count('voucher');

		if ($count_voucher > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($voucher_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $voucher_id);
		$count_voucher = $this->core_model->count('voucher');

		if ($count_voucher > 0)
		{
			throw new Exception('Data cannot be deleted.');
		}
	}

	private function _validate_edit($voucher_id, $voucher_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $voucher_id);
		$count_voucher = $this->core_model->count('voucher');

		if ($count_voucher > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $voucher_id);
		$this->db->where('name', $voucher_record['name']);
		$count_voucher = $this->core_model->count('voucher');

		if ($count_voucher > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}