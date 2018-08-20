<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alterego extends CI_Controller
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

		if (!isset($acl['alterego']) || $acl['alterego']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Alterego';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('alterego_add', $arr_data);
	}

	public function edit($alterego_id = 0)
	{
		$acl = $this->_acl;

		if ($alterego_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['alterego']) || $acl['alterego']->edit <= 0)
		{
			redirect(base_url());
		}

		$alterego = $this->core_model->get('alterego', $alterego_id);
		$alterego->image_name = '';

		$this->db->where('alterego_id', $alterego->id);
		$arr_image = $this->core_model->get('image');

		if (count($arr_image) > 0)
		{
			$alterego->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Alterego';
		$arr_data['alterego'] = $alterego;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('alterego_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['alterego']) || $acl['alterego']->list <= 0)
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
		$arr_alterego = $this->core_model->get('alterego');

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

		$count_alterego = $this->core_model->count('alterego');
		$count_page = ceil($count_alterego / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Alterego';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_alterego'] = $arr_alterego;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('alterego', $arr_data);
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

			if (!isset($acl['alterego']) || $acl['alterego']->add <= 0)
			{
				throw new Exception('You have no access to add alterego. Please contact your administrator.');
			}

			$alterego_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$alterego_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$alterego_id = $this->core_model->insert('alterego', $alterego_record);
			$alterego_record['id'] = $alterego_id;
			$alterego_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($alterego_record['id'], 'add', $alterego_record, array(), 'alterego');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('alterego_id' => $alterego_id));
			}

			$json['alterego_id'] = $alterego_id;

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

	public function ajax_change_status($alterego_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($alterego_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['alterego']) || $acl['alterego']->edit <= 0)
			{
				throw new Exception('You have no access to edit alterego. Please contact your administrator.');
			}

			$old_alterego = $this->core_model->get('alterego', $alterego_id);

			$old_alterego_record = array();

			foreach ($old_alterego as $key => $value)
			{
				$old_alterego_record[$key] = $value;
			}

			$alterego_record = array();

			foreach ($_POST as $k => $v)
			{
				$alterego_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('alterego', $alterego_id, $alterego_record);
			$alterego_record['id'] = $alterego_id;
			$alterego_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($alterego_id, 'status', $alterego_record, $old_alterego_record, 'alterego');

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

	public function ajax_delete($alterego_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($alterego_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['alterego']) || $acl['alterego']->delete <= 0)
			{
				throw new Exception('You have no access to delete alterego. Please contact your administrator.');
			}

			$alterego = $this->core_model->get('alterego', $alterego_id);
			$updated = $_POST['updated'];
			$alterego_record = array();

			foreach ($alterego as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$alterego_record[$k] = $v;
				}
			}

			$this->_validate_delete($alterego_id);

			$this->core_model->delete('alterego', $alterego_id);
			$alterego_record['id'] = $alterego->id;
			$alterego_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($alterego_record['id'], 'delete', $alterego_record, array(), 'alterego');

			if ($this->_has_image > 0)
			{
				$this->db->where('alterego_id', $alterego_id);
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

	public function ajax_edit($alterego_id)
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

			if (!isset($acl['alterego']) || $acl['alterego']->edit <= 0)
			{
				throw new Exception('You have no access to edit alterego. Please contact your administrator.');
			}

			$old_alterego = $this->core_model->get('alterego', $alterego_id);

			$old_alterego_record = array();

			foreach ($old_alterego as $key => $value)
			{
				$old_alterego_record[$key] = $value;
			}

			$alterego_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$alterego_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($alterego_id, $alterego_record);

			$this->core_model->update('alterego', $alterego_id, $alterego_record);
			$alterego_record['id'] = $alterego_id;
			$alterego_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($alterego_record['id'], 'edit', $alterego_record, $old_alterego_record, 'alterego');
			$this->cms_function->update_foreign_field(array('product'), $alterego_record, 'alterego');

			if ($image_id > 0)
            {
                $this->db->where('alterego_id', $alterego_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('alterego_id' => $alterego_id));
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

	public function ajax_get($alterego_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($alterego_id <= 0)
			{
				throw new Exception();
			}

			$alterego = $this->core_model->get('alterego', $alterego_id);

			$json['alterego'] = $alterego;
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




	private function _validate_add($alterego_record)
	{
		$this->db->where('name', $alterego_record['name']);
		$count_alterego = $this->core_model->count('alterego');

		if ($count_alterego > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($alterego_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $alterego_id);
		$count_alterego = $this->core_model->count('alterego');

		if ($count_alterego > 0)
		{
			throw new Exception('Data cannot be deleted');
		}

		// count product
		$this->db->where('alterego_id', $alterego_id);
		$count_product = $this->core_model->count('product');

		if ($count_product > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($alterego_id, $alterego_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $alterego_id);
		$count_alterego = $this->core_model->count('alterego');

		if ($count_alterego > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $alterego_id);
		$this->db->where('name', $alterego_record['name']);
		$count_alterego = $this->core_model->count('alterego');

		if ($count_alterego > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}