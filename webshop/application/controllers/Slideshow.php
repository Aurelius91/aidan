<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slideshow extends CI_Controller
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

		if (!isset($acl['website']) || $acl['website']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Slideshow';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('slideshow_add', $arr_data);
	}

	public function edit($slideshow_id = 0)
	{
		$acl = $this->_acl;

		if ($slideshow_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['website']) || $acl['website']->edit <= 0)
		{
			redirect(base_url());
		}

		$slideshow = $this->core_model->get('slideshow', $slideshow_id);
		$slideshow->image_name = '';
		$slideshow->image_mobile_name = '';

		$this->db->where('slideshow_id', $slideshow->id);
		$arr_image = $this->core_model->get('image');

		foreach ($arr_image as $image)
		{
			if ($image->type == '')
			{
				$slideshow->image_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
			else
			{
				$slideshow->image_mobile_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Slideshow';
		$arr_data['slideshow'] = $slideshow;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('slideshow_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['website']) || $acl['website']->list <= 0)
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
		$arr_slideshow = $this->core_model->get('slideshow');
		$arr_slideshow_id = $this->cms_function->extract_records($arr_slideshow, 'id');

		$arr_image_lookup = array();

		if (count($arr_slideshow_id) > 0)
		{
			$this->db->where_in('slideshow_id', $arr_slideshow_id);
			$arr_image = $this->core_model->get('image');

			foreach ($arr_image as $image)
			{
				$arr_image_lookup[$image->slideshow_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
		}

		foreach ($arr_slideshow as $slideshow)
		{
			$slideshow->image_name = (isset($arr_image_lookup[$slideshow->id])) ? $arr_image_lookup[$slideshow->id] : '';
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

		$count_slideshow = $this->core_model->count('slideshow');
		$count_page = ceil($count_slideshow / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Slideshow';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_slideshow'] = $arr_slideshow;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('slideshow', $arr_data);
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

			if (!isset($acl['website']) || $acl['website']->add <= 0)
			{
				throw new Exception('You have no access to add slideshow. Please contact your administrator.');
			}

			$slideshow_record = array();
			$image_id = 0;
			$image2_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				elseif ($k == 'image2_id')
				{
					$image2_id = $v;
				}
				else
				{
					$slideshow_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

            $this->_validate_add($slideshow_record);

			$slideshow_id = $this->core_model->insert('slideshow', $slideshow_record);
			$slideshow_record['id'] = $slideshow_id;
			$slideshow_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($slideshow_record['id'], 'add', $slideshow_record, array(), 'slideshow');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('slideshow_id' => $slideshow_id));
			}

			if ($image2_id > 0)
			{
				$this->core_model->update('image', $image2_id, array('slideshow_id' => $slideshow_id));
			}

			$json['slideshow_id'] = $slideshow_id;

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

	public function ajax_change_status($slideshow_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($slideshow_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['website']) || $acl['website']->edit <= 0)
			{
				throw new Exception('You have no access to edit slideshow. Please contact your administrator.');
			}

			$old_slideshow = $this->core_model->get('slideshow', $slideshow_id);

			$old_slideshow_record = array();

			foreach ($old_slideshow as $key => $value)
			{
				$old_slideshow_record[$key] = $value;
			}

			$slideshow_record = array();

			foreach ($_POST as $k => $v)
			{
				$slideshow_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('slideshow', $slideshow_id, $slideshow_record);
			$slideshow_record['id'] = $slideshow_id;
			$slideshow_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($slideshow_id, 'status', $slideshow_record, $old_slideshow_record, 'slideshow');

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

	public function ajax_delete($slideshow_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($slideshow_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['website']) || $acl['website']->delete <= 0)
			{
				throw new Exception('You have no access to delete slideshow. Please contact your administrator.');
			}

			$slideshow = $this->core_model->get('slideshow', $slideshow_id);
			$updated = $_POST['updated'];
			$slideshow_record = array();

			foreach ($slideshow as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$slideshow_record[$k] = $v;
				}
			}

			$this->_validate_delete($slideshow_id);

			$this->core_model->delete('slideshow', $slideshow_id);
			$slideshow_record['id'] = $slideshow->id;
			$slideshow_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($slideshow_record['id'], 'delete', $slideshow_record, array(), 'slideshow');

			if ($this->_has_image > 0)
			{
				$this->db->where('slideshow_id', $slideshow_id);
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

	public function ajax_edit($slideshow_id)
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

			if (!isset($acl['website']) || $acl['website']->edit <= 0)
			{
				throw new Exception('You have no access to edit slideshow. Please contact your administrator.');
			}

			$old_slideshow = $this->core_model->get('slideshow', $slideshow_id);

			$old_slideshow_record = array();

			foreach ($old_slideshow as $key => $value)
			{
				$old_slideshow_record[$key] = $value;
			}

			$slideshow_record = array();
			$image_id = 0;
			$image2_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				elseif ($k == 'image2_id')
				{
					$image2_id = $v;
				}
				else
				{
					$slideshow_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($slideshow_id, $slideshow_record);

			$this->core_model->update('slideshow', $slideshow_id, $slideshow_record);
			$slideshow_record['id'] = $slideshow_id;
			$slideshow_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($slideshow_record['id'], 'edit', $slideshow_record, $old_slideshow_record, 'slideshow');

			if ($image_id > 0)
            {
                $this->db->where('slideshow_id', $slideshow_id);
                $this->db->where('type', '');
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('slideshow_id' => $slideshow_id));
            }

            if ($image2_id > 0)
            {
                $this->db->where('slideshow_id', $slideshow_id);
                $this->db->where('type !=', '');
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image2_id, array('slideshow_id' => $slideshow_id));
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

	public function ajax_get($slideshow_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($slideshow_id <= 0)
			{
				throw new Exception();
			}

			$slideshow = $this->core_model->get('slideshow', $slideshow_id);

			$json['slideshow'] = $slideshow;
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




	private function _validate_add($slideshow_record)
	{
		$this->db->where('name', $slideshow_record['name']);
		$count_slideshow = $this->core_model->count('slideshow');

		if ($count_slideshow > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($slideshow_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $slideshow_id);
		$count_slideshow = $this->core_model->count('slideshow');

		if ($count_slideshow > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($slideshow_id, $slideshow_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $slideshow_id);
		$count_slideshow = $this->core_model->count('slideshow');

		if ($count_slideshow > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $slideshow_id);
		$this->db->where('name', $slideshow_record['name']);
		$count_slideshow = $this->core_model->count('slideshow');

		if ($count_slideshow > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}