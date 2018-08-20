<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collection extends CI_Controller
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

		if (!isset($acl['collection']) || $acl['collection']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Collection';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('collection_add', $arr_data);
	}

	public function edit($collection_id = 0)
	{
		$acl = $this->_acl;

		if ($collection_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['collection']) || $acl['collection']->edit <= 0)
		{
			redirect(base_url());
		}

		$collection = $this->core_model->get('collection', $collection_id);
		$collection->image_name = '';

		$this->db->where('collection_id', $collection->id);
		$arr_image = $this->core_model->get('image');

		if (count($arr_image) > 0)
		{
			$collection->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Collection';
		$arr_data['collection'] = $collection;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('collection_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['collection']) || $acl['collection']->list <= 0)
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
		$arr_collection = $this->core_model->get('collection');

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

		$count_collection = $this->core_model->count('collection');
		$count_page = ceil($count_collection / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Collection';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_collection'] = $arr_collection;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('collection', $arr_data);
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

			if (!isset($acl['collection']) || $acl['collection']->add <= 0)
			{
				throw new Exception('You have no access to add collection. Please contact your administrator.');
			}

			$collection_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$collection_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$collection_id = $this->core_model->insert('collection', $collection_record);
			$collection_record['id'] = $collection_id;
			$collection_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($collection_record['id'], 'add', $collection_record, array(), 'collection');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('collection_id' => $collection_id));
			}

			$json['collection_id'] = $collection_id;

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

	public function ajax_change_status($collection_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($collection_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['collection']) || $acl['collection']->edit <= 0)
			{
				throw new Exception('You have no access to edit collection. Please contact your administrator.');
			}

			$old_collection = $this->core_model->get('collection', $collection_id);

			$old_collection_record = array();

			foreach ($old_collection as $key => $value)
			{
				$old_collection_record[$key] = $value;
			}

			$collection_record = array();

			foreach ($_POST as $k => $v)
			{
				$collection_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('collection', $collection_id, $collection_record);
			$collection_record['id'] = $collection_id;
			$collection_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($collection_id, 'status', $collection_record, $old_collection_record, 'collection');

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

	public function ajax_delete($collection_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($collection_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['collection']) || $acl['collection']->delete <= 0)
			{
				throw new Exception('You have no access to delete collection. Please contact your administrator.');
			}

			$collection = $this->core_model->get('collection', $collection_id);
			$updated = $_POST['updated'];
			$collection_record = array();

			foreach ($collection as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$collection_record[$k] = $v;
				}
			}

			$this->_validate_delete($collection_id);

			$this->core_model->delete('collection', $collection_id);
			$collection_record['id'] = $collection->id;
			$collection_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($collection_record['id'], 'delete', $collection_record, array(), 'collection');

			if ($this->_has_image > 0)
			{
				$this->db->where('collection_id', $collection_id);
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

	public function ajax_edit($collection_id)
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

			if (!isset($acl['collection']) || $acl['collection']->edit <= 0)
			{
				throw new Exception('You have no access to edit collection. Please contact your administrator.');
			}

			$old_collection = $this->core_model->get('collection', $collection_id);

			$old_collection_record = array();

			foreach ($old_collection as $key => $value)
			{
				$old_collection_record[$key] = $value;
			}

			$collection_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$collection_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($collection_id, $collection_record);

			$this->core_model->update('collection', $collection_id, $collection_record);
			$collection_record['id'] = $collection_id;
			$collection_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($collection_record['id'], 'edit', $collection_record, $old_collection_record, 'collection');
			$this->cms_function->update_foreign_field(array('product'), $collection_record, 'collection');

			if ($image_id > 0)
            {
                $this->db->where('collection_id', $collection_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('collection_id' => $collection_id));
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

	public function ajax_get($collection_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($collection_id <= 0)
			{
				throw new Exception();
			}

			$collection = $this->core_model->get('collection', $collection_id);

			$json['collection'] = $collection;
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




	private function _validate_add($collection_record)
	{
		$this->db->where('name', $collection_record['name']);
		$count_collection = $this->core_model->count('collection');

		if ($count_collection > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($collection_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $collection_id);
		$count_collection = $this->core_model->count('collection');

		if ($count_collection > 0)
		{
			throw new Exception('Data cannot be deleted');
		}

		// count adjustment
		$this->db->where('collection_id', $collection_id);
		$count_product = $this->core_model->count('product');

		if ($count_product > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($collection_id, $collection_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $collection_id);
		$count_collection = $this->core_model->count('collection');

		if ($count_collection > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $collection_id);
		$this->db->where('name', $collection_record['name']);
		$count_collection = $this->core_model->count('collection');

		if ($count_collection > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}