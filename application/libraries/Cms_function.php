<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_function
{
    public function extract_records($records, $field)
    {
        $data = array();

        foreach ($records as $record)
        {
            if (isset($data[$record->$field]))
            {
                continue;
            }

            $data[$record->$field] = $record->$field;
        }

        return array_values($data);
    }

    public function generate_acl($user_id)
    {
        if ($user_id <= 0)
        {
            return array();
        }

        $CI = &get_instance();

        $acl = array();

        $CI->db->select('id');
        $CI->db->where('enabled <=', 0);
        $arr_module = $CI->core_model->get('module');
        $arr_module_id = $CI->cms_function->extract_records($arr_module, 'id');

        $CI->db->where('user_id', $user_id);

        if (count($arr_module_id) > 0)
        {
            $CI->db->where_not_in('module_id', $arr_module_id);
        }

        $arr_user_access = $CI->core_model->get('user_access');

        foreach ($arr_user_access as $user_access)
        {
            $acl[$user_access->module_id] = new stdClass();
            $acl[$user_access->module_id]->add = $user_access->add;
            $acl[$user_access->module_id]->delete = $user_access->delete;
            $acl[$user_access->module_id]->edit = $user_access->edit;
            $acl[$user_access->module_id]->list = $user_access->list;
        }

        return $acl;
    }

    public function generate_cart()
    {
        $CI = &get_instance();

        // get CUrrency
        $currency_id = (!get_cookie('aidan_curr')) ? 1 : get_cookie('aidan_curr');
        $currency = $CI->core_model->get('currency', $currency_id);

        // get old session cart
        $old_session_cart = ($CI->session->userdata('session_cart')) ? $CI->session->userdata('session_cart') : '';

        $arr_old_cart = ($old_session_cart != '') ? json_decode($old_session_cart) : array();
        $last_cart = null;

        $now = time();

        // get last cart
        if (count($arr_old_cart) > 0)
        {
            $count_old_cart = count($arr_old_cart) - 1;

            $last_cart = $arr_old_cart[$count_old_cart];

            if ($last_cart->product_id > 0)
            {
                $product = $CI->core_model->get('product', $last_cart->product_id);

                if ($product->discount_period_start > 0 && $product->discount_period_end > 0)
                {
                    if ($product->discount_period_start <= $now && $product->discount_period_end >= $now)
                    {
                        $product->price = ($product->discount > 0) ? ($product->price - ($product->discount / 100) * $product->price) : 0;
                    }
                }

                $price = ceil($product->price / $currency->currency_exchange);

                $total = $price * $last_cart->quantity;

                $product->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
                $product->weight_display = number_format($product->weight, 2, ',', '.');
                $product->total_display = $currency->name . ' ' . number_format($total, 0, ',', '.');
                $product->type = '';

                foreach ($product as $k => $v)
                {
                    $last_cart->$k = $v;
                }

                $last_cart->image_name = '';

                $CI->db->where('product_id', $last_cart->product_id);
                $arr_image = $CI->core_model->get('image');

                if (count($arr_image) > 0)
                {
                    $last_cart->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
                }
            }
            else
            {
                $voucher = $CI->core_model->get('voucher', $last_cart->voucher_id);
                $voucher->quantity = $last_cart->quantity;

                $price = ceil($voucher->value / $currency->currency_exchange);
                $total = $price * $last_cart->quantity;

                $voucher->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
                $voucher->weight_display = ($voucher->type == 'Printed') ? 1 : 0;
                $voucher->total_display = $currency->name . ' ' . number_format($total, 0, ',', '.');
                $voucher->type = '';

                foreach ($voucher as $k => $v)
                {
                    $last_cart->$k = $v;
                }

                $last_cart->image_name = ($last_cart->type != 'Printed') ? base_url() . 'assets/images/giftcard/virtual.png' :  base_url() . 'assets/images/giftcard/printed.png';
            }
        }

        return $last_cart;
    }

	public function generate_csrf()
	{
		$CI = &get_instance();

		$arr_csrf = array();
		$arr_csrf['name'] = $CI->security->get_csrf_token_name();
		$arr_csrf['hash'] = $CI->security->get_csrf_hash();

		return $arr_csrf;
	}

    public function generate_header()
    {
        $CI = &get_instance();

        $CI->db->where('header_id <=', 0);
        $CI->db->order_by('sort');
        $arr_header = $CI->core_model->get('header');
        $arr_header_id = $CI->cms_function->extract_records($arr_header, 'id');

        $arr_header_lookup = array();

        if (count($arr_header_id) > 0)
        {
            $CI->db->where_in('header_id', $arr_header_id);
            $CI->db->order_by('sort');
            $arr_child_header = $CI->core_model->get('header');

            foreach ($arr_child_header as $child_header)
            {
                $arr_header_lookup[$child_header->header_id][] = clone $child_header;
            }
        }

        foreach ($arr_header as $header)
        {
            $header->arr_child_header = (isset($arr_header_lookup[$header->id])) ? $arr_header_lookup[$header->id] : array();
        }

        return $arr_header;
    }

	public function generate_metatag($header_id)
	{
		$CI = &get_instance();

		$CI->db->where('header_id', $header_id);
		$arr_metatag = $CI->core_model->get('metatag');

        if (count($arr_metatag) <= 0)
        {
            $metatag = new stdClass();
            $metatag->name = '';
            $metatag->keywords = '';
            $metatag->author = '';
            $metatag->description = '';

            $arr_metatag[] = clone $metatag;
        }

		return $arr_metatag[0];
	}

    public function generate_navbar_menu()
    {
        $CI = &get_instance();

        $arr_navbar_menu_record = array();

        // get collection
        $CI->db->order_by('name DESC');
        $arr_collection = $CI->core_model->get('collection');

        // get alterego
        $CI->db->order_by('name');
        $arr_alterego = $CI->core_model->get('alterego');

        // get category
        $CI->db->order_by('name');
        $arr_category = $CI->core_model->get('category');

        $arr_navbar_menu_record['arr_navbar_collection'] = $arr_collection;
        $arr_navbar_menu_record['arr_navbar_alterego'] = $arr_alterego;
        $arr_navbar_menu_record['arr_navbar_category'] = $arr_category;

        return $arr_navbar_menu_record;
    }

    public function generate_random_number($table, $count_length)
    {
        $CI = &get_instance();

        $char = '0123456789abcdefghijklmnopqrstuvwxyz';
        $length = strlen($char);
        $number = '';

        for ($i = 0; $i < $count_length; $i++)
        {
            $number .= $char[rand(0, $length - 1)];
        }

        $CI->db->where('number', $number);
        $count_table = $CI->core_model->count($table);

        if ($count_table > 0)
        {
            return '12345678';
        }

        return $number;
    }

    public function generate_section($header_id)
    {
        $CI = &get_instance();

        $CI->db->where('header_id', $header_id);
        $CI->db->order_by('id');
        $arr_section = $CI->core_model->get('section');
        $arr_section_id = $CI->cms_function->extract_records($arr_section, 'id');

        $arr_image_lookup = array();

        if (count($arr_section_id) > 0)
        {
            $CI->db->where_in('section_id', $arr_section_id);
            $arr_image = $CI->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_image_lookup[$image->section_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_section as $section)
        {
            $section->image_name = (isset($arr_image_lookup[$section->id])) ? $arr_image_lookup[$section->id] : '';
        }

        return $arr_section;
    }

    public function get_currency()
    {
        $CI = &get_instance();

        $CI->db->order_by('id');
        $arr_currency = $CI->core_model->get('currency');

        foreach ($arr_currency as $currency)
        {
            $currency->currency_exchange = number_format($currency->currency_exchange, 0, '', '');
        }

        return $arr_currency;
    }

    public function populate_foreign_field($id, $record, $table)
    {
        $CI = &get_instance();

        if ($table == 'module')
        {
            $CI->db->select('type, number, name, date, status');
            $CI->db->where('id', $id);
            $arr_query_result = $CI->core_model->get($table);

            $query_result = (count($arr_query_result) > 0) ? $arr_query_result[0] : new stdClass();
        }
        else
        {
            if ($id > 0)
            {
                $CI->db->select('type, number, name, date, status');
                $query_result = $CI->core_model->get($table, $id);
            }
        }

        if ($id > 0)
        {
            foreach ($query_result as $k => $v)
            {
                $record["{$table}_{$k}"] = $v;
            }
        }

        return $record;
    }

    public function system_log($type, $record, $old_record, $table)
    {
        $CI = &get_instance();

        $log_record = array();
        $log_record['date'] = time();

        if ($type == 'add')
        {
			$log_record['name'] = (isset($record['name'])) ? 'Add ' . $table . ' ' . $record['name'] : 'Add ' . $table . ' ' . $record['title'];
        }
        elseif ($type == 'edit')
        {
			$log_record['name'] = (isset($record['name'])) ? 'Edit ' . $table . ' ' . $old_record['name'] . ' to ' .  $record['name'] : 'Edit ' . $table . ' ' . $old_record['title'] . ' to ' .  $record['title'];
        }
        elseif ($type == 'delete')
        {
			$log_record['name'] = (isset($record['name'])) ? 'Delete ' . $table . ' ' . $record['name'] : 'Delete ' . $table . ' ' . $record['title'];
        }
        elseif ($type == 'status')
        {
            $status = ($record['active'] > 0) ? 'Active' : 'Inactive';
            $log_record['name'] = (isset($old_record['name'])) ? 'Change Status ' . $old_record['name'] . ' to ' . $status : 'Change Status ' . $old_record['title'] . ' to ' . $status;
        }
        elseif ($type == 'Update Stock')
        {
            $log_record['name'] = 'Update Stock ' . $old_record['name'] . ' from ' . number_format($old_record['quantity'], 0, '', '') . ' to ' . $record['quantity'];
        }
        elseif ($type == 'setting')
        {
            $log_record['name'] = 'Update Setting';
        }

        $log_record['query'] = $record['last_query'];
        $CI->core_model->insert('log', $log_record);
    }

    public function trim_text($text)
    {
        $text = str_replace("\n", "", $text);
        $text = str_replace("\t", "", $text);
        $text = str_replace("\r", "", $text);

        return $text;
    }

    public function update_foreign_field($arr_table, $record, $foreign_id)
    {
        $CI = &get_instance();

        foreach ($arr_table as $table)
        {
            $update_record["{$foreign_id}_type"] = (isset($record['type'])) ? $record['type'] : '';
            $update_record["{$foreign_id}_number"] = (isset($record['number'])) ? $record['number'] : '';
            $update_record["{$foreign_id}_name"] = (isset($record['name'])) ? $record['name'] : '';
            $update_record["{$foreign_id}_date"] = (isset($record['date'])) ? $record['date'] : 0;
            $update_record["{$foreign_id}_status"] = (isset($record['status'])) ? $record['status'] : '';

            $CI->db->where($foreign_id . '_id', $record['id']);
            $CI->core_model->update($table, 0, $update_record);

            if (($foreign_id == 'location' && ($table == 'movement' || $table == 'movement_item')) || $foreign_id == 'statement' && ($table == 'transfer' || $table == 'transfer_item'))
            {
                $update_record["{$foreign_id}_type"] = (isset($record['type'])) ? $record['type'] : '';
                $update_record["{$foreign_id}_number"] = (isset($record['number'])) ? $record['number'] : '';
                $update_record["{$foreign_id}_name"] = (isset($record['name'])) ? $record['name'] : '';
                $update_record["{$foreign_id}_date"] = (isset($record['date'])) ? $record['date'] : 0;
                $update_record["{$foreign_id}_status"] = (isset($record['status'])) ? $record['status'] : '';

                $CI->db->where($foreign_id . 'to_id', $record['id']);
                $CI->core_model->update($table, 0, $update_record);
            }
        }
    }
}