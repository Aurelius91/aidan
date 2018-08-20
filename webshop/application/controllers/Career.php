<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Career extends CI_Controller
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

		if (!isset($acl['career']) || $acl['career']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'career';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('career_add', $arr_data);
	}

	public function edit($career_id = 0)
	{
		$acl = $this->_acl;

		if ($career_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['career']) || $acl['career']->edit <= 0)
		{
			redirect(base_url());
		}

		$career = $this->core_model->get('career', $career_id);
		$career->date_display = date('Y-m-d', $career->date);
		$career->date_end_display = date('Y-m-d', $career->date_end);
		$career->image_name = '';

		$this->db->where('career_id', $career->id);
		$arr_image = $this->core_model->get('image');

		if (count($arr_image) > 0)
		{
			$career->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'career';
		$arr_data['career'] = $career;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('career_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['career']) || $acl['career']->list <= 0)
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
		$arr_career = $this->core_model->get('career');

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

		$count_career = $this->core_model->count('career');
		$count_page = ceil($count_career / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'career';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_career'] = $arr_career;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('career', $arr_data);
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

			if (!isset($acl['career']) || $acl['career']->add <= 0)
			{
				throw new Exception('You have no access to add career. Please contact your administrator.');
			}

			$career_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$career_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$career_record['url_name'] = str_replace(array('.', ',', '&', '?', '!', '/', '(', ')', '+'), '' , strtolower($career_record['name']));
            $career_record['url_name'] = preg_replace("/[\s_]/", "-", $career_record['url_name']);

            $this->_validate_add($career_record);

			$career_id = $this->core_model->insert('career', $career_record);
			$career_record['id'] = $career_id;
			$career_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($career_record['id'], 'add', $career_record, array(), 'career');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('career_id' => $career_id));
			}

			$json['career_id'] = $career_id;

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

	public function ajax_change_status($career_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($career_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['career']) || $acl['career']->edit <= 0)
			{
				throw new Exception('You have no access to edit career. Please contact your administrator.');
			}

			$old_career = $this->core_model->get('career', $career_id);

			$old_career_record = array();

			foreach ($old_career as $key => $value)
			{
				$old_career_record[$key] = $value;
			}

			$career_record = array();

			foreach ($_POST as $k => $v)
			{
				$career_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('career', $career_id, $career_record);
			$career_record['id'] = $career_id;
			$career_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($career_id, 'status', $career_record, $old_career_record, 'career');

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

	public function ajax_delete($career_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($career_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['career']) || $acl['career']->delete <= 0)
			{
				throw new Exception('You have no access to delete career. Please contact your administrator.');
			}

			$career = $this->core_model->get('career', $career_id);
			$updated = $_POST['updated'];
			$career_record = array();

			foreach ($career as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$career_record[$k] = $v;
				}
			}

			$this->_validate_delete($career_id);

			$this->core_model->delete('career', $career_id);
			$career_record['id'] = $career->id;
			$career_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($career_record['id'], 'delete', $career_record, array(), 'career');

			if ($this->_has_image > 0)
			{
				$this->db->where('career_id', $career_id);
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

	public function ajax_edit($career_id)
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

			if (!isset($acl['career']) || $acl['career']->edit <= 0)
			{
				throw new Exception('You have no access to edit career. Please contact your administrator.');
			}

			$old_career = $this->core_model->get('career', $career_id);

			$old_career_record = array();

			foreach ($old_career as $key => $value)
			{
				$old_career_record[$key] = $value;
			}

			$career_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$career_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$career_record['url_name'] = str_replace(array('.', ',', '&', '?', '!', '/', '(', ')', '+'), '' , strtolower($career_record['name']));
            $career_record['url_name'] = preg_replace("/[\s_]/", "-", $career_record['url_name']);

			$this->_validate_edit($career_id, $career_record);

			$this->core_model->update('career', $career_id, $career_record);
			$career_record['id'] = $career_id;
			$career_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($career_record['id'], 'edit', $career_record, $old_career_record, 'career');

			if ($image_id > 0)
            {
                $this->db->where('career_id', $career_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('career_id' => $career_id));
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

	public function ajax_get($career_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($career_id <= 0)
			{
				throw new Exception();
			}

			$career = $this->core_model->get('career', $career_id);

			$json['career'] = $career;
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




	private function _validate_add($career_record)
	{
		$this->db->where('name', $career_record['name']);
		$count_career = $this->core_model->count('career');

		if ($count_career > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($career_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $career_id);
		$count_career = $this->core_model->count('career');

		if ($count_career > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($career_id, $career_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $career_id);
		$count_career = $this->core_model->count('career');

		if ($count_career > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $career_id);
		$this->db->where('name', $career_record['name']);
		$count_career = $this->core_model->count('career');

		if ($count_career > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}