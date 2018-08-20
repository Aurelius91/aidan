<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockist extends CI_Controller
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

		if (!isset($acl['stockist']) || $acl['stockist']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Stockist';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('stockist_add', $arr_data);
	}

	public function edit($stockist_id = 0)
	{
		$acl = $this->_acl;

		if ($stockist_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['stockist']) || $acl['stockist']->edit <= 0)
		{
			redirect(base_url());
		}

		$stockist = $this->core_model->get('stockist', $stockist_id);
		$stockist->image_name = '';

		$this->db->where('stockist_id', $stockist->id);
		$arr_image = $this->core_model->get('image');

		if (count($arr_image) > 0)
		{
			$stockist->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Stockist';
		$arr_data['stockist'] = $stockist;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('stockist_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['stockist']) || $acl['stockist']->list <= 0)
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
		$arr_stockist = $this->core_model->get('stockist');

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

		$count_stockist = $this->core_model->count('stockist');
		$count_page = ceil($count_stockist / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Stockist';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_stockist'] = $arr_stockist;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('stockist', $arr_data);
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

			if (!isset($acl['stockist']) || $acl['stockist']->add <= 0)
			{
				throw new Exception('You have no access to add stockist. Please contact your administrator.');
			}

			$stockist_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$stockist_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

            $this->_validate_add($stockist_record);

			$stockist_id = $this->core_model->insert('stockist', $stockist_record);
			$stockist_record['id'] = $stockist_id;
			$stockist_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($stockist_record['id'], 'add', $stockist_record, array(), 'stockist');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('stockist_id' => $stockist_id));
			}

			$json['stockist_id'] = $stockist_id;

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

	public function ajax_change_status($stockist_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($stockist_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['stockist']) || $acl['stockist']->edit <= 0)
			{
				throw new Exception('You have no access to edit stockist. Please contact your administrator.');
			}

			$old_stockist = $this->core_model->get('stockist', $stockist_id);

			$old_stockist_record = array();

			foreach ($old_stockist as $key => $value)
			{
				$old_stockist_record[$key] = $value;
			}

			$stockist_record = array();

			foreach ($_POST as $k => $v)
			{
				$stockist_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('stockist', $stockist_id, $stockist_record);
			$stockist_record['id'] = $stockist_id;
			$stockist_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($stockist_id, 'status', $stockist_record, $old_stockist_record, 'stockist');

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

	public function ajax_delete($stockist_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($stockist_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['stockist']) || $acl['stockist']->delete <= 0)
			{
				throw new Exception('You have no access to delete stockist. Please contact your administrator.');
			}

			$stockist = $this->core_model->get('stockist', $stockist_id);
			$updated = $_POST['updated'];
			$stockist_record = array();

			foreach ($stockist as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$stockist_record[$k] = $v;
				}
			}

			$this->_validate_delete($stockist_id);

			$this->core_model->delete('stockist', $stockist_id);
			$stockist_record['id'] = $stockist->id;
			$stockist_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($stockist_record['id'], 'delete', $stockist_record, array(), 'stockist');

			if ($this->_has_image > 0)
			{
				$this->db->where('stockist_id', $stockist_id);
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

	public function ajax_edit($stockist_id)
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

			if (!isset($acl['stockist']) || $acl['stockist']->edit <= 0)
			{
				throw new Exception('You have no access to edit stockist. Please contact your administrator.');
			}

			$old_stockist = $this->core_model->get('stockist', $stockist_id);

			$old_stockist_record = array();

			foreach ($old_stockist as $key => $value)
			{
				$old_stockist_record[$key] = $value;
			}

			$stockist_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$stockist_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($stockist_id, $stockist_record);

			$this->core_model->update('stockist', $stockist_id, $stockist_record);
			$stockist_record['id'] = $stockist_id;
			$stockist_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($stockist_record['id'], 'edit', $stockist_record, $old_stockist_record, 'stockist');

			if ($image_id > 0)
            {
                $this->db->where('stockist_id', $stockist_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('stockist_id' => $stockist_id));
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

	public function ajax_get($stockist_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($stockist_id <= 0)
			{
				throw new Exception();
			}

			$stockist = $this->core_model->get('stockist', $stockist_id);

			$json['stockist'] = $stockist;
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




	private function _validate_add($stockist_record)
	{
		$this->db->where('name', $stockist_record['name']);
		$count_stockist = $this->core_model->count('stockist');

		if ($count_stockist > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($stockist_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $stockist_id);
		$count_stockist = $this->core_model->count('stockist');

		if ($count_stockist > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($stockist_id, $stockist_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $stockist_id);
		$count_stockist = $this->core_model->count('stockist');

		if ($count_stockist > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $stockist_id);
		$this->db->where('name', $stockist_record['name']);
		$count_stockist = $this->core_model->count('stockist');

		if ($count_stockist > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}