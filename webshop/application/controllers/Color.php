<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class color extends CI_Controller
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

		if (!isset($acl['color']) || $acl['color']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Color';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('color_add', $arr_data);
	}

	public function edit($color_id = 0)
	{
		$acl = $this->_acl;

		if ($color_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['color']) || $acl['color']->edit <= 0)
		{
			redirect(base_url());
		}

		$color = $this->core_model->get('color', $color_id);
		$color->address = $this->cms_function->trim_text($color->address);

		$this->db->select('module_id, add, delete, edit, list');
		$this->db->where('color_id', $color->id);
		$color->arr_color_access = $this->core_model->get('color_access');

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Color';
		$arr_data['color'] = $color;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('color_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['color']) || $acl['color']->list <= 0)
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
		$arr_color = $this->core_model->get('color');

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

		$count_color = $this->core_model->count('color');
		$count_page = ceil($count_color / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Color';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_color'] = $arr_color;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('color', $arr_data);
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

			if (!isset($acl['color']) || $acl['color']->add <= 0)
			{
				throw new Exception('You have no access to add color. Please contact your administrator.');
			}

			$color_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$color_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$color_record['url_name'] = str_replace(array('.', ',', '&', '?', '!', '/', '(', ')', '+'), '' , strtolower($color_record['name']));
            $color_record['url_name'] = preg_replace("/[\s_]/", "-", $color_record['url_name']);

			$this->_validate_add($color_record);

			$color_id = $this->core_model->insert('color', $color_record);
			$color_record['id'] = $color_id;
			$color_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($color_record['id'], 'add', $color_record, array(), 'color');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('color_id' => $color_id));
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

	public function ajax_change_status($color_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($color_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['color']) || $acl['color']->edit <= 0)
			{
				throw new Exception('You have no access to edit color. Please contact your administrator.');
			}

			$old_color = $this->core_model->get('color', $color_id);

			$old_color_record = array();

			foreach ($old_color as $key => $value)
			{
				$old_color_record[$key] = $value;
			}

			$color_record = array();

			foreach ($_POST as $k => $v)
			{
				$color_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('color', $color_id, $color_record);
			$color_record['id'] = $color_id;
			$color_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log('status', $color_record, $old_color_record, 'color');

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

	public function ajax_delete($color_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($color_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['color']) || $acl['color']->delete <= 0)
			{
				throw new Exception('You have no access to delete color. Please contact your administrator.');
			}

			$color = $this->core_model->get('color', $color_id);
			$updated = $_POST['updated'];
			$color_record = array();

			foreach ($color as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another color. Please refresh the page.');
				}
				else
				{
					$color_record[$k] = $v;
				}
			}

			$this->_validate_delete($color_id);

			$this->core_model->delete('color', $color_id);
			$color_record['id'] = $color->id;
			$color_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($color_record['id'], 'delete', $color_record, array(), 'color');

			if ($this->_has_image > 0)
			{
				$this->db->where('color_id', $color_id);
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

	public function ajax_edit($color_id)
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

			if (!isset($acl['color']) || $acl['color']->edit <= 0)
			{
				throw new Exception('You have no access to edit color. Please contact your administrator.');
			}

			$old_color = $this->core_model->get('color', $color_id);

			$old_color_record = array();

			foreach ($old_color as $key => $value)
			{
				$old_color_record[$key] = $value;
			}

			$color_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'updated')
				{
					if ($v != $old_color_record[$k])
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
					$color_record[$k] = ($k == 'date') ? strtotime($v) : $v;
				}
			}

			$color_record['url_name'] = str_replace(array('.', ',', '&', '?', '!', '/', '(', ')', '+'), '' , strtolower($color_record['name']));
            $color_record['url_name'] = preg_replace("/[\s_]/", "-", $color_record['url_name']);

			$this->_validate_edit($color_id, $color_record);

			$this->core_model->update('color', $color_id, $color_record);
			$color_record['id'] = $color_id;
			$color_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($color_record['id'], 'edit', $color_record, $old_color_record, 'color');

			$this->cms_function->update_foreign_field(array('product', 'product_color'), $color_record, 'color');

			if ($image_id > 0)
            {
                $this->db->where('color_id', $color_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('color_id' => $color_id));
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

	public function ajax_get($color_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($color_id <= 0)
			{
				throw new Exception();
			}

			$color = $this->core_model->get('color', $color_id);

			$json['color'] = $color;
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




	private function _validate_add($color_record)
	{
		$this->db->where('name', $color_record['name']);
		$count_user = $this->core_model->count('color');

		if ($count_user > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($color_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $color_id);
		$count_user = $this->core_model->count('color');

		if ($count_user > 0)
		{
			throw new Exception('Data cannot be deleted.');
		}
	}

	private function _validate_edit($color_id, $color_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $color_id);
		$count_user = $this->core_model->count('color');

		if ($count_user > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $color_id);
		$this->db->where('name', $color_record['name']);
		$count_user = $this->core_model->count('color');

		if ($count_user > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}