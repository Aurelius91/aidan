<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller
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

		if (!isset($acl['events']) || $acl['events']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Events';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('events_add', $arr_data);
	}

	public function edit($events_id = 0)
	{
		$acl = $this->_acl;

		if ($events_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['events']) || $acl['events']->edit <= 0)
		{
			redirect(base_url());
		}

		$events = $this->core_model->get('events', $events_id);
		$events->date_display = date('Y-m-d', $events->date);
		$events->image_name = '';

		$this->db->where('events_id', $events->id);
		$arr_image = $this->core_model->get('image');

		if (count($arr_image) > 0)
		{
			$events->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Events';
		$arr_data['events'] = $events;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('events_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['events']) || $acl['events']->list <= 0)
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
		$arr_events = $this->core_model->get('events');

		foreach ($arr_events as $events)
		{
			$events->date_display = date('d F Y', $events->date);
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

		$count_events = $this->core_model->count('events');
		$count_page = ceil($count_events / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Events';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_events'] = $arr_events;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('events', $arr_data);
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

			if (!isset($acl['events']) || $acl['events']->add <= 0)
			{
				throw new Exception('You have no access to add events. Please contact your administrator.');
			}

			$events_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$events_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

            $this->_validate_add($events_record);

			$events_id = $this->core_model->insert('events', $events_record);
			$events_record['id'] = $events_id;
			$events_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($events_record['id'], 'add', $events_record, array(), 'events');

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('events_id' => $events_id));
			}

			$json['events_id'] = $events_id;

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

	public function ajax_change_status($events_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($events_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['events']) || $acl['events']->edit <= 0)
			{
				throw new Exception('You have no access to edit events. Please contact your administrator.');
			}

			$old_events = $this->core_model->get('events', $events_id);

			$old_events_record = array();

			foreach ($old_events as $key => $value)
			{
				$old_events_record[$key] = $value;
			}

			$events_record = array();

			foreach ($_POST as $k => $v)
			{
				$events_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('events', $events_id, $events_record);
			$events_record['id'] = $events_id;
			$events_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($events_id, 'status', $events_record, $old_events_record, 'events');

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

	public function ajax_delete($events_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($events_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['events']) || $acl['events']->delete <= 0)
			{
				throw new Exception('You have no access to delete events. Please contact your administrator.');
			}

			$events = $this->core_model->get('events', $events_id);
			$updated = $_POST['updated'];
			$events_record = array();

			foreach ($events as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$events_record[$k] = $v;
				}
			}

			$this->_validate_delete($events_id);

			$this->core_model->delete('events', $events_id);
			$events_record['id'] = $events->id;
			$events_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($events_record['id'], 'delete', $events_record, array(), 'events');

			if ($this->_has_image > 0)
			{
				$this->db->where('events_id', $events_id);
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

	public function ajax_edit($events_id)
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

			if (!isset($acl['events']) || $acl['events']->edit <= 0)
			{
				throw new Exception('You have no access to edit events. Please contact your administrator.');
			}

			$old_events = $this->core_model->get('events', $events_id);

			$old_events_record = array();

			foreach ($old_events as $key => $value)
			{
				$old_events_record[$key] = $value;
			}

			$events_record = array();
			$image_id = 0;

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				else
				{
					$events_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($events_id, $events_record);

			$this->core_model->update('events', $events_id, $events_record);
			$events_record['id'] = $events_id;
			$events_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($events_record['id'], 'edit', $events_record, $old_events_record, 'events');

			if ($image_id > 0)
            {
                $this->db->where('events_id', $events_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('events_id' => $events_id));
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

	public function ajax_get($events_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($events_id <= 0)
			{
				throw new Exception();
			}

			$events = $this->core_model->get('events', $events_id);

			$json['events'] = $events;
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




	private function _validate_add($events_record)
	{
		$this->db->where('name', $events_record['name']);
		$count_events = $this->core_model->count('events');

		if ($count_events > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($events_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $events_id);
		$count_events = $this->core_model->count('events');

		if ($count_events > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($events_id, $events_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $events_id);
		$count_events = $this->core_model->count('events');

		if ($count_events > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $events_id);
		$this->db->where('name', $events_record['name']);
		$count_events = $this->core_model->count('events');

		if ($count_events > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}