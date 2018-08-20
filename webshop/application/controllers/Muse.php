<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Muse extends CI_Controller
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




	public function add($type = 1)
	{
		$acl = $this->_acl;

		if (!isset($acl['muse']) || $acl['muse']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'muse';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();
		$arr_data['arr_product'] = $this->_get_product();

		$this->load->view('html', $arr_data);
		$this->load->view('muse_add_' . $type, $arr_data);
	}

	public function edit($muse_id = 0)
	{
		$acl = $this->_acl;

		if ($muse_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['muse']) || $acl['muse']->edit <= 0)
		{
			redirect(base_url());
		}

		$muse = $this->core_model->get('muse', $muse_id);
		$muse->date_display = date('Y-m-d', $muse->date);
		$muse->image_cover_name = '';
		$muse->image_name = '';
		$muse->image2_name = '';
		$muse->image3_name = '';
		$muse->image4_name = '';
		$muse->image5_name = '';
		$muse->image6_name = '';

		$this->db->where('muse_id', $muse->id);
		$arr_image = $this->core_model->get('image');

		foreach ($arr_image as $image)
		{
			if ($image->type == 1)
			{
				$muse->image_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
			elseif ($image->type == 2)
			{
				$muse->image2_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
			elseif ($image->type == 3)
			{
				$muse->image3_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
			elseif ($image->type == 4)
			{
				$muse->image4_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
			elseif ($image->type == 5)
			{
				$muse->image5_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
			elseif ($image->type == 6)
			{
				$muse->image6_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
			else
			{
				$muse->image_cover_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
		}

		// get muse_product
		$this->db->where('muse_id', $muse_id);
		$arr_muse_product = $this->core_model->get('muse_product');

		$muse->arr_muse_product = $arr_muse_product;

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'muse';
		$arr_data['muse'] = $muse;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();
		$arr_data['arr_product'] = $this->_get_product();

		$this->load->view('html', $arr_data);
		$this->load->view('muse_edit_' . $muse->type, $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['muse']) || $acl['muse']->list <= 0)
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
		$this->db->order_by("date DESC");
		$arr_muse = $this->core_model->get('muse');

		foreach ($arr_muse as $muse)
		{
			$muse->date_display = date('F, Y', $muse->date);
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

		$count_muse = $this->core_model->count('muse');
		$count_page = ceil($count_muse / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'muse';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_muse'] = $arr_muse;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('muse', $arr_data);
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

			if (!isset($acl['muse']) || $acl['muse']->add <= 0)
			{
				throw new Exception('You have no access to add muse. Please contact your administrator.');
			}

			$muse_record = array();
			$image_cover_id = 0;
			$image_id = 0;
			$image2_id = 0;
			$image3_id = 0;
			$image4_id = 0;
			$image5_id = 0;
			$image6_id = 0;
			$arr_product_id = array();

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
				elseif ($k == 'image3_id')
				{
					$image3_id = $v;
				}
				elseif ($k == 'image4_id')
				{
					$image4_id = $v;
				}
				elseif ($k == 'image5_id')
				{
					$image5_id = $v;
				}
				elseif ($k == 'image6_id')
				{
					$image6_id = $v;
				}
				elseif ($k == 'image_cover_id')
				{
					$image_cover_id = $v;
				}
				elseif ($k == 'product_id_product_id')
				{
					$arr_product_id = explode(',', $v);
				}
				else
				{
					$muse_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$muse_record['url_name'] = str_replace(array('.', ',', '&', '?', '!', '/', '(', ')', '+'), '' , strtolower($muse_record['name']));
            $muse_record['url_name'] = preg_replace("/[\s_]/", "-", $muse_record['url_name']);

            $this->_validate_add($muse_record);

			$muse_id = $this->core_model->insert('muse', $muse_record);
			$muse_record['id'] = $muse_id;
			$muse_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($muse_record['id'], 'add', $muse_record, array(), 'muse');
			$this->_add_muse_product($muse_id, $muse_record, $arr_product_id);

			if ($image_cover_id > 0)
			{
				$this->core_model->update('image', $image_cover_id, array('muse_id' => $muse_id));
			}

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('muse_id' => $muse_id));
			}

			if ($image2_id > 0)
			{
				$this->core_model->update('image', $image2_id, array('muse_id' => $muse_id));
			}

			if ($image3_id > 0)
			{
				$this->core_model->update('image', $image3_id, array('muse_id' => $muse_id));
			}

			if ($image4_id > 0)
			{
				$this->core_model->update('image', $image4_id, array('muse_id' => $muse_id));
			}

			if ($image5_id > 0)
			{
				$this->core_model->update('image', $image5_id, array('muse_id' => $muse_id));
			}

			if ($image6_id > 0)
			{
				$this->core_model->update('image', $image6_id, array('muse_id' => $muse_id));
			}

			$json['muse_id'] = $muse_id;

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

	public function ajax_change_status($muse_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($muse_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['muse']) || $acl['muse']->edit <= 0)
			{
				throw new Exception('You have no access to edit muse. Please contact your administrator.');
			}

			$old_muse = $this->core_model->get('muse', $muse_id);

			$old_muse_record = array();

			foreach ($old_muse as $key => $value)
			{
				$old_muse_record[$key] = $value;
			}

			$muse_record = array();

			foreach ($_POST as $k => $v)
			{
				$muse_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('muse', $muse_id, $muse_record);
			$muse_record['id'] = $muse_id;
			$muse_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($muse_id, 'status', $muse_record, $old_muse_record, 'muse');

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

	public function ajax_delete($muse_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($muse_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['muse']) || $acl['muse']->delete <= 0)
			{
				throw new Exception('You have no access to delete muse. Please contact your administrator.');
			}

			$muse = $this->core_model->get('muse', $muse_id);
			$updated = $_POST['updated'];
			$muse_record = array();

			foreach ($muse as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$muse_record[$k] = $v;
				}
			}

			$this->_validate_delete($muse_id);

			$this->core_model->delete('muse', $muse_id);
			$muse_record['id'] = $muse->id;
			$muse_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($muse_record['id'], 'delete', $muse_record, array(), 'muse');
			$this->_delete_muse_product($muse_id);

			if ($this->_has_image > 0)
			{
				$this->db->where('muse_id', $muse_id);
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

	public function ajax_edit($muse_id)
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

			if (!isset($acl['muse']) || $acl['muse']->edit <= 0)
			{
				throw new Exception('You have no access to edit muse. Please contact your administrator.');
			}

			$old_muse = $this->core_model->get('muse', $muse_id);

			$old_muse_record = array();

			foreach ($old_muse as $key => $value)
			{
				$old_muse_record[$key] = $value;
			}

			$muse_record = array();
			$image_id = 0;
			$image2_id = 0;
			$image3_id = 0;
			$image4_id = 0;
			$image5_id = 0;
			$image6_id = 0;
			$image_cover_id = 0;
			$arr_product_id = array();

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
				elseif ($k == 'image3_id')
				{
					$image3_id = $v;
				}
				elseif ($k == 'image4_id')
				{
					$image4_id = $v;
				}
				elseif ($k == 'image5_id')
				{
					$image5_id = $v;
				}
				elseif ($k == 'image6_id')
				{
					$image6_id = $v;
				}
				elseif ($k == 'image_cover_id')
				{
					$image_cover_id = $v;
				}
				elseif ($k == 'product_id_product_id')
				{
					$arr_product_id = explode(',', $v);
				}
				else
				{
					$muse_record[$k] = ($k == 'date' || $k == 'date_end') ? strtotime($v) : $v;
				}
			}

			$muse_record['url_name'] = str_replace(array('.', ',', '&', '?', '!', '/', '(', ')', '+'), '' , strtolower($muse_record['name']));
            $muse_record['url_name'] = preg_replace("/[\s_]/", "-", $muse_record['url_name']);

			$this->_validate_edit($muse_id, $muse_record);

			$this->core_model->update('muse', $muse_id, $muse_record);
			$muse_record['id'] = $muse_id;
			$muse_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($muse_record['id'], 'edit', $muse_record, $old_muse_record, 'muse');
			$this->_add_muse_product($muse_id, $muse_record, $arr_product_id);

			if ($image_cover_id > 0)
            {
                $this->db->where('muse_id', $muse_id);
                $this->db->where('type', 'cover');
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_cover_id, array('muse_id' => $muse_id));
            }

			if ($image_id > 0)
            {
                $this->db->where('muse_id', $muse_id);
                $this->db->where('type', 1);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('muse_id' => $muse_id));
            }

            if ($image2_id > 0)
            {
                $this->db->where('muse_id', $muse_id);
                $this->db->where('type', 2);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image2_id, array('muse_id' => $muse_id));
            }

            if ($image3_id > 0)
            {
                $this->db->where('muse_id', $muse_id);
                $this->db->where('type', 3);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image3_id, array('muse_id' => $muse_id));
            }

            if ($image4_id > 0)
            {
                $this->db->where('muse_id', $muse_id);
                $this->db->where('type', 4);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image4_id, array('muse_id' => $muse_id));
            }

            if ($image5_id > 0)
            {
                $this->db->where('muse_id', $muse_id);
                $this->db->where('type', 5);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image5_id, array('muse_id' => $muse_id));
            }

            if ($image6_id > 0)
            {
                $this->db->where('muse_id', $muse_id);
                $this->db->where('type', 6);
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image6_id, array('muse_id' => $muse_id));
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

	public function ajax_get($muse_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($muse_id <= 0)
			{
				throw new Exception();
			}

			$muse = $this->core_model->get('muse', $muse_id);

			$json['muse'] = $muse;
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




	private function _add_muse_product($muse_id, $muse_record, $arr_product_id)
	{
		// delete muse_product
		$this->_delete_muse_product($muse_id);

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
			$muse_product_record = array();

			$muse_product_record['product_id'] = $product_id;
			$muse_product_record['muse_id'] = $muse_id;

			$muse_product_record['product_type'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->type : '';
			$muse_product_record['product_number'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->number : '';
			$muse_product_record['product_name'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->name : '';
			$muse_product_record['product_date'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->date : 0;
			$muse_product_record['product_status'] = (isset($arr_product_lookup[$product_id])) ? $arr_product_lookup[$product_id]->status : '';

			$muse_product_record['muse_type'] = (isset($muse_record['type'])) ? $muse_record['type'] : '';
			$muse_product_record['muse_number'] = (isset($muse_record['number'])) ? $muse_record['number'] : '';
			$muse_product_record['muse_name'] = (isset($muse_record['name'])) ? $muse_record['name'] : '';
			$muse_product_record['muse_date'] = (isset($muse_record['date'])) ? $muse_record['date'] : '';
			$muse_product_record['muse_status'] = (isset($muse_record['status'])) ? $muse_record['status'] : '';
			$this->core_model->insert('muse_product', $muse_product_record);
		}
	}

	private function _delete_muse_product($muse_id)
	{
		$this->db->where('muse_id', $muse_id);
		$this->core_model->delete('muse_product');
	}

	private function _get_product()
	{
		$this->db->order_by('name');
		$this->db->where('status', 'Active');
		return $this->core_model->get('product');
	}

	private function _validate_add($muse_record)
	{
		$this->db->where('name', $muse_record['name']);
		$count_muse = $this->core_model->count('muse');

		if ($count_muse > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($muse_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $muse_id);
		$count_muse = $this->core_model->count('muse');

		if ($count_muse > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($muse_id, $muse_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $muse_id);
		$count_muse = $this->core_model->count('muse');

		if ($count_muse > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $muse_id);
		$this->db->where('name', $muse_record['name']);
		$count_muse = $this->core_model->count('muse');

		if ($count_muse > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}