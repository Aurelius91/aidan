<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller
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

		if (!isset($acl['product']) || $acl['product']->add <= 0)
		{
			redirect(base_url());
		}

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Product';
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();
		$arr_data['arr_brand'] = $this->_get_brand();
		$arr_data['arr_category'] = $this->_get_category();
		$arr_data['arr_collection'] = $this->_get_collection();
		$arr_data['arr_alterego'] = $this->_get_alterego();
		$arr_data['arr_color'] = $this->_get_color();

		$this->load->view('html', $arr_data);
		$this->load->view('product_add', $arr_data);
	}

	public function edit($product_id = 0)
	{
		$acl = $this->_acl;

		if ($product_id <= 0)
		{
			redirect(base_url());
		}

		if (!isset($acl['product']) || $acl['product']->edit <= 0)
		{
			redirect(base_url());
		}

		$product = $this->core_model->get('product', $product_id);
		$product->price_display = number_format($product->price, 0, '', '');
		$product->discount_display = number_format($product->discount, 0, '', '');
		$product->weight_display = number_format($product->weight, 0, '', '');
		$product->image_name = '';
		$product->image_hover_name = '';

		$product->discount_period_start_display = ($product->discount_period_start <= 0) ? '' : date('Y-m-d', $product->discount_period_start);
		$product->discount_period_end_display = ($product->discount_period_end <= 0) ? '' : date('Y-m-d', $product->discount_period_end);

		$this->db->where('product_id', $product->id);
		$this->db->where_in('type', array('', 'hover'));
		$arr_image = $this->core_model->get('image');

		foreach ($arr_image as $image)
		{
			if ($image->type == '')
			{
				$product->image_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
			else
			{
				$product->image_hover_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
		}

		// get product_category
		$this->db->where('product_id', $product->id);
		$arr_product_category = $this->core_model->get('product_category');

		$product->category = 0;
		$arr_looks = array();

		foreach ($arr_product_category as $product_category)
		{
			if ($product_category->category_type == 'category')
			{
				$product->category = $product_category->category_id;
			}

			if ($product_category->category_type == 'looks')
			{
				$arr_looks[] = $product_category->category_id;
			}
		}

		$product->arr_looks = $arr_looks;

		// get product_color
		$this->db->where('product_id', $product->id);
		$arr_product_color = $this->core_model->get('product_color');
		$product->arr_color_id = $this->cms_function->extract_records($arr_product_color, 'color_id');

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Product';
		$arr_data['product'] = $product;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();
		$arr_data['arr_brand'] = $this->_get_brand();
		$arr_data['arr_category'] = $this->_get_category();
		$arr_data['arr_collection'] = $this->_get_collection();
		$arr_data['arr_alterego'] = $this->_get_alterego();
		$arr_data['arr_color'] = $this->_get_color();

		$this->load->view('html', $arr_data);
		$this->load->view('product_edit', $arr_data);
	}

	public function view($page = 1, $filter = 'all', $query = '')
	{
		$acl = $this->_acl;

		if (!isset($acl['product']) || $acl['product']->list <= 0)
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
		$this->db->order_by("number");
		$arr_product = $this->core_model->get('product');
		$arr_product_id = $this->cms_function->extract_records($arr_product, 'id');

		$arr_image_lookup = array();

		if (count($arr_product_id) > 0)
		{
			$this->db->where_in('product_id', $arr_product_id);
			$arr_image = $this->core_model->get('image');

			foreach ($arr_image as $image)
			{
				$arr_image_lookup[$image->product_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
			}
		}

		foreach ($arr_product as $product)
		{
			$product->image_name = (isset($arr_image_lookup[$product->id])) ? $arr_image_lookup[$product->id] : '';

			$product->price_display = number_format($product->price, 0, ',', '.');
			$product->weight_display = number_format($product->weight, 2, ',', '.');
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

		$count_product = $this->core_model->count('product');
		$count_page = ceil($count_product / $this->_setting->setting__limit_page);

		$arr_data['setting'] = $this->_setting;
		$arr_data['account'] = $this->_user;
		$arr_data['acl'] = $acl;
		$arr_data['type'] = 'Product';
		$arr_data['page'] = $page;
		$arr_data['count_page'] = $count_page;
		$arr_data['query'] = $query;
		$arr_data['filter'] = $filter;
		$arr_data['arr_product'] = $arr_product;
		$arr_data['csrf'] = $this->cms_function->generate_csrf();
		$arr_data['total_size'] = $this->cms_function->check_memory();

		$this->load->view('html', $arr_data);
		$this->load->view('product', $arr_data);
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

			if (!isset($acl['product']) || $acl['product']->add <= 0)
			{
				throw new Exception('You have no access to add product. Please contact your administrator.');
			}

			$product_record = array();
			$image_id = 0;
			$image2_id = 0;
			$arr_category_id = array();
			$arr_color_id = array();

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
				elseif ($k == 'category_id_category_id')
				{
					$arr_category_id = explode(',', $v);
				}
				elseif ($k == 'color_id_color_id')
				{
					$arr_color_id = explode(',', $v);
				}
				else
				{
					$product_record[$k] = ($k == 'date' || $k == 'discount_period_start' || $k == 'discount_period_end') ? strtotime($v) : $v;
				}
			}

			$product_record['url_name'] = str_replace(array('.', ',', '&', '?', '!', '/', '(', ')', '+'), '' , strtolower($product_record['name']));
            $product_record['url_name'] = preg_replace("/[\s_]/", "-", $product_record['url_name']);

            $product_record = $this->cms_function->populate_foreign_field($product_record['collection_id'], $product_record, 'collection');
            $product_record = $this->cms_function->populate_foreign_field($product_record['alterego_id'], $product_record, 'alterego');

			$this->_validate_add($product_record);

			$product_id = $this->core_model->insert('product', $product_record);
			$product_record['id'] = $product_id;
			$product_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($product_record['id'], 'add', $product_record, array(), 'product');

			if (!isset($product_record['number']) || (isset($product_record['number']) && $product_record['number'] == ''))
			{
				$product_record['number'] = '#P' . str_pad($product_id, 6, 0, STR_PAD_LEFT);
				$this->core_model->update('product', $product_id, array('number' => $product_record['number']));
			}

			if (!isset($product_record['barcode']) || (isset($product_record['barcode']) && $product_record['barcode'] == ''))
			{
				$product_record['barcode'] = date('ymd', time()) . '' . str_pad($product_id, 4, 0, STR_PAD_LEFT);
				$this->core_model->update('product', $product_id, array('barcode' => $product_record['barcode']));
			}

			$this->_add_inventory($product_id, $product_record);
			$this->_add_product_category($product_id, $product_record, $arr_category_id);
			$this->_add_product_color($product_id, $product_record, $arr_color_id);

			if ($image_id > 0)
			{
				$this->core_model->update('image', $image_id, array('product_id' => $product_id));
			}

			if ($image2_id > 0)
			{
				$this->core_model->update('image', $image2_id, array('product_id' => $product_id));
			}

			$json['product_id'] = $product_id;

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

	public function ajax_change_status($product_id)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($product_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['product']) || $acl['product']->edit <= 0)
			{
				throw new Exception('You have no access to edit product. Please contact your administrator.');
			}

			$old_product = $this->core_model->get('product', $product_id);

			$old_product_record = array();

			foreach ($old_product as $key => $value)
			{
				$old_product_record[$key] = $value;
			}

			$product_record = array();

			foreach ($_POST as $k => $v)
			{
				$product_record[$k] = ($k == 'date') ? strtotime($v) : $v;
			}

			$this->core_model->update('product', $product_id, $product_record);
			$product_record['id'] = $product_id;
			$product_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($product_id, 'status', $product_record, $old_product_record, 'product');

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

	public function ajax_delete($product_id = 0)
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			if ($product_id <= 0)
			{
				throw new Exception();
			}

			if ($this->session->userdata('user_id') != $this->_user->id)
			{
				throw new Exception('Server Error. Please log out first.');
			}

			$acl = $this->_acl;

			if (!isset($acl['product']) || $acl['product']->delete <= 0)
			{
				throw new Exception('You have no access to delete product. Please contact your administrator.');
			}

			$product = $this->core_model->get('product', $product_id);
			$updated = $_POST['updated'];
			$product_record = array();

			foreach ($product as $k => $v)
			{
				if ($k == 'updated' && $v != $updated)
				{
					throw new Exception('This data has been updated by another User. Please refresh the page.');
				}
				else
				{
					$product_record[$k] = $v;
				}
			}

			$this->_validate_delete($product_id);

			$this->core_model->delete('product', $product_id);
			$product_record['id'] = $product->id;
			$product_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($product_record['id'], 'delete', $product_record, array(), 'product');

			$this->_delete_inventory($product_id);
			$this->_delete_product_category($product_id);
			$this->_delete_product_color($product_id);

			if ($this->_has_image > 0)
			{
				$this->db->where('product_id', $product_id);
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

	public function ajax_edit($product_id)
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

			if (!isset($acl['product']) || $acl['product']->edit <= 0)
			{
				throw new Exception('You have no access to edit product. Please contact your administrator.');
			}

			$old_product = $this->core_model->get('product', $product_id);

			$old_product_record = array();

			foreach ($old_product as $key => $value)
			{
				$old_product_record[$key] = $value;
			}

			$product_record = array();
			$image_id = 0;
			$image2_id = 0;
			$arr_category_id = array();
			$arr_color_id = array();

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
				elseif ($k == 'category_id_category_id')
				{
					$arr_category_id = explode(',', $v);
				}
				elseif ($k == 'color_id_color_id')
				{
					$arr_color_id = explode(',', $v);
				}
				else
				{
					$product_record[$k] = ($k == 'date' || $k == 'discount_period_start' || $k == 'discount_period_end') ? strtotime($v) : $v;
				}
			}

			$product_record['type'] = $old_product_record['type'];

			$product_record['url_name'] = str_replace(array('.', ',', '&', '?', '!', '/', '(', ')', '+'), '' , strtolower($product_record['name']));
            $product_record['url_name'] = preg_replace("/[\s_]/", "-", $product_record['url_name']);

            $product_record = $this->cms_function->populate_foreign_field($product_record['collection_id'], $product_record, 'collection');
            $product_record = $this->cms_function->populate_foreign_field($product_record['alterego_id'], $product_record, 'alterego');

			$this->_validate_edit($product_id, $product_record);

			$this->core_model->update('product', $product_id, $product_record);
			$product_record['id'] = $product_id;
			$product_record['last_query'] = $this->db->last_query();

			$this->cms_function->system_log($product_record['id'], 'edit', $product_record, $old_product_record, 'product');
			$this->cms_function->update_foreign_field(array('adjustment_item', 'inventory', 'movement_item', 'product_category', 'purchase_item', 'receive_item', 'sale_item', 'stock', 'wishlist'), $product_record, 'product');

			$this->_add_product_category($product_id, $product_record, $arr_category_id);
			$this->_add_product_color($product_id, $product_record, $arr_color_id);

			if ($image_id > 0)
            {
                $this->db->where('product_id', $product_id);
                $this->db->where('type', '');
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image_id, array('product_id' => $product_id));
            }

            if ($image2_id > 0)
            {
                $this->db->where('product_id', $product_id);
                $this->db->where('type', 'hover');
                $arr_image = $this->core_model->get('image');

                foreach ($arr_image as $image)
                {
                    unlink("images/website/{$image->id}.{$image->ext}");

                    $this->core_model->delete('image', $image->id);
                }

                $this->core_model->update('image', $image2_id, array('product_id' => $product_id));
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

	public function ajax_get($product_id = 0, $barcode = 0)
	{
		$json['status'] = 'success';

		try
		{
			if ($product_id <= 0 && $barcode == '')
			{
				throw new Exception();
			}

			$product = null;

			if ($product_id > 0)
			{
				$product = $this->core_model->get('product', $product_id);
			}
			else
			{
				$this->db->where('barcode', $barcode);
				$arr_product = $this->core_model->get('product');

				if (count($arr_product) <= 0)
				{
					throw new Exception('No Product Found');
				}

				$product = $arr_product[0];
				$product->price_display = number_format($product->price, 0, ',', '.');
			}

			$json['product'] = $product;
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

	public function ajax_update_all()
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			$product_record = array();

			foreach ($_POST as $k => $v)
			{
				$product_record[$k] = ($k == 'date' || $k == 'discount_period_start' || $k == 'discount_period_end') ? strtotime($v) : $v;
			}

			$this->core_model->update('product', 0, $product_record);

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




	private function _add_product_category($product_id, $product_record, $arr_category_id)
	{
		// delete product_category
		$this->_delete_product_category($product_id);

		// get all category
		$arr_category = $this->_get_category();
		$arr_category_lookup = array();

		foreach ($arr_category as $category)
		{
			$arr_category_lookup[$category->id] = clone $category;
		}

		// add product_category
		foreach ($arr_category_id as $category_id)
		{
			$product_category_record = array();

			$product_category_record['category_id'] = $category_id;
			$product_category_record['product_id'] = $product_id;

			$product_category_record['category_type'] = (isset($arr_category_lookup[$category_id])) ? $arr_category_lookup[$category_id]->type : '';
			$product_category_record['category_number'] = (isset($arr_category_lookup[$category_id])) ? $arr_category_lookup[$category_id]->number : '';
			$product_category_record['category_name'] = (isset($arr_category_lookup[$category_id])) ? $arr_category_lookup[$category_id]->name : '';
			$product_category_record['category_date'] = (isset($arr_category_lookup[$category_id])) ? $arr_category_lookup[$category_id]->date : 0;
			$product_category_record['category_status'] = (isset($arr_category_lookup[$category_id])) ? $arr_category_lookup[$category_id]->status : '';

			$product_category_record['product_type'] = (isset($product_record['type'])) ? $product_record['type'] : '';
			$product_category_record['product_number'] = (isset($product_record['number'])) ? $product_record['number'] : '';
			$product_category_record['product_name'] = (isset($product_record['name'])) ? $product_record['name'] : '';
			$product_category_record['product_date'] = (isset($product_record['date'])) ? $product_record['date'] : '';
			$product_category_record['product_status'] = (isset($product_record['status'])) ? $product_record['status'] : '';
			$this->core_model->insert('product_category', $product_category_record);
		}
	}

	private function _add_product_color($product_id, $product_record, $arr_color_id)
	{
		// delete product_color
		$this->_delete_product_color($product_id);

		// get all color
		$arr_color = $this->_get_color();
		$arr_color_lookup = array();

		foreach ($arr_color as $color)
		{
			$arr_color_lookup[$color->id] = clone $color;
		}

		// add product_category
		foreach ($arr_color_id as $color_id)
		{
			$product_color_record = array();

			$product_color_record['color_id'] = $color_id;
			$product_color_record['product_id'] = $product_id;

			$product_color_record['color_type'] = (isset($arr_color_lookup[$color_id])) ? $arr_color_lookup[$color_id]->type : '';
			$product_color_record['color_number'] = (isset($arr_color_lookup[$color_id])) ? $arr_color_lookup[$color_id]->number : '';
			$product_color_record['color_name'] = (isset($arr_color_lookup[$color_id])) ? $arr_color_lookup[$color_id]->name : '';
			$product_color_record['color_date'] = (isset($arr_color_lookup[$color_id])) ? $arr_color_lookup[$color_id]->date : 0;
			$product_color_record['color_status'] = (isset($arr_color_lookup[$color_id])) ? $arr_color_lookup[$color_id]->status : '';

			$product_color_record['product_type'] = (isset($product_record['type'])) ? $product_record['type'] : '';
			$product_color_record['product_number'] = (isset($product_record['number'])) ? $product_record['number'] : '';
			$product_color_record['product_name'] = (isset($product_record['name'])) ? $product_record['name'] : '';
			$product_color_record['product_date'] = (isset($product_record['date'])) ? $product_record['date'] : '';
			$product_color_record['product_status'] = (isset($product_record['status'])) ? $product_record['status'] : '';
			$this->core_model->insert('product_color', $product_color_record);
		}
	}

	private function _add_inventory($product_id, $product_record)
	{
		// get all location
		$arr_location = $this->core_model->get('location');

		foreach ($arr_location as $location)
		{
			$inventory_record = array();

			$inventory_record['location_id'] = $location->id;
			$inventory_record['product_id'] = $product_id;

			$inventory_record['location_type'] = $location->type;
			$inventory_record['location_number'] = $location->number;
			$inventory_record['location_name'] = $location->name;
			$inventory_record['location_date'] = $location->date;
			$inventory_record['location_status'] = $location->status;

			$inventory_record['product_type'] = (isset($product_record['type'])) ? $product_record['type'] : '';
			$inventory_record['product_number'] = (isset($product_record['number'])) ? $product_record['number'] : '';
			$inventory_record['product_name'] = (isset($product_record['name'])) ? $product_record['name'] : '';
			$inventory_record['product_date'] = (isset($product_record['date'])) ? $product_record['date'] : '';
			$inventory_record['product_status'] = (isset($product_record['status'])) ? $product_record['status'] : '';

			$this->core_model->insert('inventory', $inventory_record);
		}
	}

	private function _delete_product_category($product_id)
	{
		$this->db->where('product_id', $product_id);
		$this->core_model->delete('product_category');
	}

	private function _delete_product_color($product_id)
	{
		$this->db->where('product_id', $product_id);
		$this->core_model->delete('product_color');
	}

	private function _delete_inventory($product_id)
	{
		$this->db->where('product_id', $product_id);
		$arr_inventory = $this->core_model->get('inventory');

		$found = 0;

		foreach ($arr_inventory as $inventory)
		{
			if ($inventory->quantity > 0)
			{
				$found += 1;
			}
		}

		if ($found > 0)
		{
			throw new Exception('Data cannot be deleted because it has stock in the inventory');
		}

		$this->db->where('product_id', $product_id);
		$this->core_model->delete('inventory');
	}

	private function _get_alterego()
	{
		$this->db->order_by('name');
		return $this->core_model->get('alterego');
	}

	private function _get_brand()
	{
		$this->db->order_by('name');
		return $this->core_model->get('brand');
	}

	private function _get_category()
	{
		$this->db->order_by('name');
		return $this->core_model->get('category');
	}

	private function _get_collection()
	{
		$this->db->order_by('name');
		return $this->core_model->get('collection');
	}

	private function _get_color()
	{
		$this->db->order_by('name');
		return $this->core_model->get('color');
	}

	private function _validate_add($product_record)
	{
		$this->db->where('name', $product_record['name']);
		$count_product = $this->core_model->count('product');

		if ($count_product > 0)
		{
			throw new Exception('Name already exist.');
		}
	}

	private function _validate_delete($product_id)
	{
		$this->db->where('deletable <=', 0);
		$this->db->where('id', $product_id);
		$count_product = $this->core_model->count('product');

		if ($count_product > 0)
		{
			throw new Exception('Data cannot be deleted');
		}

		// count adjustment
		$this->db->where('product_id', $product_id);
		$count_adjustment_item = $this->core_model->count('adjustment_item');

		if ($count_adjustment_item > 0)
		{
			throw new Exception('Data cannot be deleted');
		}

		// count movement
		$this->db->where('product_id', $product_id);
		$count_movement_item = $this->core_model->count('movement_item');

		if ($count_movement_item > 0)
		{
			throw new Exception('Data cannot be deleted');
		}

		// count purchase
		$this->db->where('product_id', $product_id);
		$count_purchase_item = $this->core_model->count('purchase_item');

		if ($count_purchase_item > 0)
		{
			throw new Exception('Data cannot be deleted');
		}

		// count sale
		$this->db->where('product_id', $product_id);
		$count_sale_item = $this->core_model->count('sale_item');

		if ($count_sale_item > 0)
		{
			throw new Exception('Data cannot be deleted');
		}
	}

	private function _validate_edit($product_id, $product_record)
	{
		$this->db->where('editable <=', 0);
		$this->db->where('id', $product_id);
		$count_product = $this->core_model->count('product');

		if ($count_product > 0)
		{
			throw new Exception('Data cannot be updated.');
		}

		$this->db->where('id !=', $product_id);
		$this->db->where('name', $product_record['name']);
		$count_product = $this->core_model->count('product');

		if ($count_product > 0)
		{
			throw new Exception('Name is already exist.');
		}
	}
}