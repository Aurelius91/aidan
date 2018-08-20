<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller
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

		if (!isset($acl['media']) || $acl['media']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Media';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();
		$arr_data['arr_product'] = $this->_get_product();

		$this->load->view('html', $arr_data);
		$this->load->view('media_add', $arr_data);
	}

	public function edit($media_id = 0)
	{
		$acl = $this->_acl;

		if ($media_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['media']) || $acl['media']->edit <= 0)
		{
			redirect(base_url());
		}

		$media = $this->core_model->get('media', $media_id);
		$media->date_display = date('Y-m-d', $media->date);
		$media->image_name = '';

		$this->db->where('media_id', $media->id);
		$arr_image = $this->core_model->get('image');

		if (count($arr_image) > 0)
		{
			$media->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
		}

		// get media_product
		$this->db->where('media_id', $media_id);
		$arr_media_product = $this->core_model->get('media_product');

		$media->arr_media_product = $arr_media_product;

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Media';
		$arr_data['media'] = $media;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();
		$arr_data['arr_product'] = $this->_get_product();

		$this->load->view('html', $arr_data);
		$this->load->view('media_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['media']) || $acl['media']->list <= 0)
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
		$arr_media = $this->core_model->get('media');

		foreach ($arr_media as $media)
		{
			$media->date_display = date('d F Y', $media->date);
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

		$count_media = $this->core_model->count('media');
		$count_page = ceil($count_media / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Media';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_media'] = $arr_media;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('media', $arr_data);
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

			if (!isset($acl['media']) || $acl['media']->add <= 0)
			{
				throw new Exception('You have no access to add media. Please contact your administrator.');
			}

			$media_record = array();
			$image_id = 0;
			$arr_product_id = array();

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				elseif ($k == 'product_id_product_id')
				{
					$arr_product_id = explode(',', $v);
				}
				else
				{
					$media_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

            $this->_validate_add($media_record);

			$media_id = $this->core_model->insert('media', $media_record);
			$media_record['id'] = $media_id;
			$media_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($media_record['id'], 'add', $media_record, array(), 'media');
			$this->_add_media_product($media_id, $media_record, $arr_product_id);

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('media_id' => $media_id));
			}

			$json['media_id'] = $media_id;

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

	public function ajax_change_status($media_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($media_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['media']) || $acl['media']->edit <= 0)
			{
				throw new Exception('You have no access to edit media. Please contact your administrator.');
			}

			$old_media = $this->core_model->get('media', $media_id);

			$old_media_record = array();

			foreach ($old_media as $key => $value)
			{
				$old_media_record[$key] = $value;
			}

			$media_record = array();

			foreach ($_POST as $k => $v)
			{
				$media_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('media', $media_id, $media_record);
			$media_record['id'] = $media_id;
			$media_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($media_id, 'status', $media_record, $old_media_record, 'media');

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

	public function ajax_delete($media_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($media_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['media']) || $acl['media']->delete <= 0)
			{
				throw new Exception('You have no access to delete media. Please contact your administrator.');
			}

			$media = $this->core_model->get('media', $media_id);
			$updated = $_POST['updated'];
			$media_record = array();

			foreach ($media as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$media_record[$k] = $v;
				}
			}

			$this->_validate_delete($media_id);

			$this->core_model->delete('media', $media_id);
			$media_record['id'] = $media->id;
			$media_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($media_record['id'], 'delete', $media_record, array(), 'media');
			$this->_delete_media_product($media_id);

			if ($this->_has_image > 0)
			{
				$this->db->where('media_id', $media_id);
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

	public function ajax_edit($media_id)
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

			if (!isset($acl['media']) || $acl['media']->edit <= 0)
			{
				throw new Exception('You have no access to edit media. Please contact your administrator.');
			}

			$old_media = $this->core_model->get('media', $media_id);

			$old_media_record = array();

			foreach ($old_media as $key => $value)
			{
				$old_media_record[$key] = $value;
			}

			$media_record = array();
			$image_id = 0;
			$arr_product_id = array();

			foreach ($_POST as $k => $v)
			{
				if ($k == 'image_id')
				{
					$image_id = $v;
				}
				elseif ($k == 'product_id_product_id')
				{
					$arr_product_id = explode(',', $v);
				}
				else
				{
					$media_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$this->_validate_edit($media_id, $media_record);

			$this->core_model->update('media', $media_id, $media_record);
			$media_record['id'] = $media_id;
			$media_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($media_record['id'], 'edit', $media_record, $old_media_record, 'media');
			$this->_add_media_product($media_id, $media_record, $arr_product_id);

			if ($image_id > 0)
            {
                $this->db->where('media_id', $media_id);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('media_id' => $media_id));
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

	public function ajax_get($media_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($media_id <= 0)
			{
				throw new Exception();
			}

			$media = $this->core_model->get('media', $media_id);

			$json['media'] = $media;
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




	private function _add_media_product($media_id, $media_record, $arr_product_id)
	{
		// delete media_product
		$this->_delete_media_product($media_id);

		// get all color
		$arr_product = $this->_get_product();
		$arr_product_lookup = array();

		foreach ($arr_product as $product)
		{
			$arr_product_lookup[$product->id] = clone $product;
		}

		// add product_category
		foreach ($arr_product_id as $product_id)
		{
			$media_product_record = array();

			$media_product_record['product_id'] = $product_id;
			$media_product_record['media_id'] = $media_id;

			$media_product_record['product_type'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->type : '';
			$media_product_record['product_number'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->number : '';
			$media_product_record['product_name'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->name : '';
			$media_product_record['product_date'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->date : 0;
			$media_product_record['product_status'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->status : '';

			$media_product_record['media_type'] = (isset($media_record['type'])) ? $media_record['type'] : '';
			$media_product_record['media_number'] = (isset($media_record['number'])) ? $media_record['number'] : '';
			$media_product_record['media_name'] = (isset($media_record['name'])) ? $media_record['name'] : '';
			$media_product_record['media_date'] = (isset($media_record['date'])) ? $media_record['date'] : '';
			$media_product_record['media_status'] = (isset($media_record['status'])) ? $media_record['status'] : '';
			$this->core_model->insert('media_product', $media_product_record);
		}
	}

	private function _delete_media_product($media_id)
	{
		$this->db->where('media_id', $media_id);
		$this->core_model->delete('media_product');
	}

	private function _get_product()
	{
		$this->db->order_by('name');
		$this->db->where('status', 'Active');
		return $this->core_model->get('product');
	}

	private function _validate_add($media_record)
	{
		$this->db->where('name', $media_record['name']);
		$count_media = $this->core_model->count('media');

		if ($count_media > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($media_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $media_id);
		$count_media = $this->core_model->count('media');

		if ($count_media > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($media_id, $media_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $media_id);
		$count_media = $this->core_model->count('media');

		if ($count_media > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $media_id);
		$this->db->where('name', $media_record['name']);
		$count_media = $this->core_model->count('media');

		if ($count_media > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}