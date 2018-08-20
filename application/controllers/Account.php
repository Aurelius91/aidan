<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller
{
    private $_currency;
    private $_customer;
    private $_lang;
    private $_setting;

    public function __construct()
    {
        parent:: __construct();

        $this->_setting = $this->setting_model->load();

        // check session for customer
        $customer_id = $this->session->userdata('customer_id');

        if ($customer_id)
        {
            $this->_customer = $this->core_model->get('customer', $customer_id);

            $this->_customer->birthday_day = ($this->_customer->birthday <= 0) ? date('d', time()) : date('d', $this->_customer->birthday);
            $this->_customer->birthday_month = ($this->_customer->birthday <= 0) ? date('m', time()) : date('m', $this->_customer->birthday);
            $this->_customer->birthday_year = ($this->_customer->birthday <= 0) ? date('Y', time()) : date('Y', $this->_customer->birthday);
        }

        // Set Language from Cookie
        $this->_lang = (!get_cookie('aidan_lang')) ? $this->_setting->setting__system_language : get_cookie('aidan_lang');
        $this->_lang = ($this->_setting->setting__website_enabled_dual_language <= 0) ? $this->_setting->setting__system_language : $this->_lang;

        // Set Language from Cookie
        $this->_currency = (!get_cookie('aidan_curr')) ? 1 : get_cookie('aidan_curr');
    }




    /* Public Function Area */
    public function index()
    {
        if (!$this->_customer)
        {
            redirect(base_url());
        }

        $header_id = 0;
        $year_now = date('Y', time());

        $arr_data['title'] = 'Account';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['year_now'] = $year_now;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('account-profile', $arr_data);
    }

    public function address()
    {
        if (!$this->_customer)
        {
            redirect(base_url());
        }

        $header_id = 0;

        // get all customer_addresss
        $this->db->where('customer_id', $this->_customer->id);
        $arr_address = $this->core_model->get('address');

        // get all country
        $this->db->order_by('name');
        $arr_country = $this->core_model->get('country');

        // get all country
        $this->db->order_by('name');
        $arr_province = $this->core_model->get('province');

        $arr_data['title'] = 'Account Address';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_address'] = $arr_address;
        $arr_data['arr_country'] = $arr_country;
        $arr_data['arr_province'] = $arr_province;

        $this->load->view('account-address', $arr_data);
    }

    public function giftcard()
    {
        if (!$this->_customer)
        {
            redirect(base_url());
        }

        $header_id = 0;

        // get giftcard
        $this->db->where('customer_id', $this->_customer->id);
        $arr_voucher_code = $this->core_model->get('voucher_code');

        foreach ($arr_voucher_code as $voucher_code)
        {
            $voucher_code->value_display = number_format($voucher_code->value, 0, ',', '.');
        }

        $arr_data['title'] = 'Account Giftcard';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_voucher_code'] = $arr_voucher_code;

        $this->load->view('account-giftcard', $arr_data);
    }

    public function order_status()
    {
        if (!$this->_customer)
        {
            redirect(base_url());
        }

        $header_id = 0;

        // get currency
        $currency = $this->core_model->get('currency', $this->_currency);

        // get all sale
        $this->db->where('customer_id', $this->_customer->id);
        $arr_sale = $this->core_model->get('sale');
        $arr_sale_id = $this->cms_function->extract_records($arr_sale, 'id');

        $arr_sale_item_lookup = array();

        if (count($arr_sale_id) > 0)
        {
            $this->db->where_in('sale_id', $arr_sale_id);
            $arr_sale_item = $this->core_model->get('sale_item');

            foreach ($arr_sale_item as $sale_item)
            {
                $sale_item->total = $sale_item->price;
                $sale_item->price = $sale_item->price / $sale_item->quantity;

                $sale_item->price_display = number_format($sale_item->price, 0, ',', '.');
                $sale_item->total_display = number_format($sale_item->total, 0, ',', '.');

                $sale_item->quantity_display = number_format($sale_item->quantity, 0, '', '');

                $arr_sale_item_lookup[$sale_item->sale_id][] = clone $sale_item;
            }
        }

        foreach ($arr_sale as $sale)
        {
            $sale->date_display = date('d F Y', $sale->date);
            $total = ceil($sale->total / $currency->currency_exchange);

            $sale->subtotal_display = number_format($sale->subtotal, 0, ',', '.');
            $sale->discount_display = number_format($sale->discount, 0, ',', '.');
            $sale->shipping_display = number_format($sale->shipping, 0, ',', '.');
            $sale->total_display = number_format($sale->total, 0, ',', '.');

            if ($sale->status == 'pending')
            {
                $sale->status_display = 'PENDING';
                $sale->status_class = 'pending';
            }
            elseif ($sale->status == 'settlement' || $sale->status == 'capture')
            {
                $sale->status_display = 'PAID';
                $sale->status_class = 'paid';
            }
            elseif ($sale->status == 'shipping')
            {
                $sale->status_display = 'Shipped';
                $sale->status_class = 'on-process';
            }
            else
            {
                $sale->status_display = 'Done';
                $sale->status_class = 'done';
            }

            $sale->arr_sale_item = (isset($arr_sale_item_lookup[$sale->id])) ? $arr_sale_item_lookup[$sale->id] : array();
        }

        $arr_data['title'] = 'Account Order Status';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_sale'] = $arr_sale;

        $this->load->view('account-order-status', $arr_data);
    }

    public function wishlist()
    {
        if (!$this->_customer)
        {
            redirect(base_url());
        }

        $header_id = 0;

        // get currency
        $currency = $this->core_model->get('currency', $this->_currency);

        // get all wishlist
        $this->db->where('customer_id', $this->_customer->id);
        $arr_wishlist = $this->core_model->get('wishlist');
        $arr_product_id = $this->cms_function->extract_records($arr_wishlist, 'product_id');

        $arr_product = $this->core_model->get('product', $arr_product_id);
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
            $product->price_display = $currency->name . ' ' . number_format($product->price, 0, ',', '.');
        }

        $arr_data['title'] = 'Account Wishlist';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_product'] = $arr_product;

        $this->load->view('account-wishlist', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    public function ajax_delete_address($address_id)
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $this->core_model->delete('address', $address_id);

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

    public function ajax_edit_customer($customer_id)
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $customer_record = array();
            $image_id = 0;

            foreach ($_POST as $k => $v)
            {
                if ($k == 'image_id')
                {
                    $image_id = $v;
                }
                else
                {
                    $customer_record[$k] = ($k == 'date' || $k == 'birthday') ? strtotime($v) : $v;
                }
            }

            $this->_validate_edit($customer_id, $customer_record);
            $customer_record['id'] = $customer_id;

            $this->core_model->update('customer', $customer_id, $customer_record);
            $this->cms_function->update_foreign_field(array('address', 'payment','sale', 'sale_item', 'transaction', 'wishlist'), $customer_record, 'customer');

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

    public function ajax_edit_password($customer_id)
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $old_customer = $this->core_model->get('customer', $customer_id);

            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');

            if (md5($old_password) != $old_customer->password)
            {
                throw new Exception('Password not Match!');
            }

            $customer_record['password'] = md5($new_password);
            $customer_record['name'] = $old_customer->name;

            $this->_validate_edit($customer_id, $customer_record);

            $customer_record['id'] = $customer_id;

            $this->core_model->update('customer', $customer_id, $customer_record);
            $this->cms_function->update_foreign_field(array('address', 'payment','sale', 'sale_item', 'transaction'), $customer_record, 'customer');

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

    public function ajax_get_city($province_id)
    {
        $json['status'] = 'success';

        try
        {
            $this->db->where('province_id', $province_id);
            $this->db->order_by('name');
            $arr_city = $this->core_model->get('city');

            $json['arr_city'] = $arr_city;
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

    public function ajax_get_district($city_id)
    {
        $json['status'] = 'success';

        try
        {
            $this->db->where('city_id', $city_id);
            $this->db->order_by('name');
            $arr_district = $this->core_model->get('district');

            $json['arr_district'] = $arr_district;
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

    public function ajax_get_shipping($country_id, $province_id, $city_id, $district_id)
    {
        $json['status'] = 'success';

        try
        {
            // get cart
            $currency = $this->core_model->get('currency', $this->_currency);

            // get all currency
            $arr_all_currency = $this->core_model->get('currency');

            // get all cart weight
            $session_cart = ($this->session->userdata('session_cart')) ? $this->session->userdata('session_cart') : '';
            $arr_sess_cart = json_decode($session_cart);
            $arr_product_id = array();
            $arr_quantity_lookup = array();
            $weight = 0;
            $count_voucher_printed = 0;

            foreach ($arr_sess_cart as $sess_cart)
            {
                $arr_product_id[] = $sess_cart->product_id;
                $arr_quantity_lookup[$sess_cart->product_id] = $sess_cart->quantity;

                if ($sess_cart->voucher_id > 0)
                {
                    $count_voucher_printed = ($sess_cart->type == 'Printed') ? $count_voucher_printed + 1 : $count_voucher_printed;
                }
            }

            if (count($arr_product_id) > 0)
            {
                $arr_product = $this->core_model->get('product', $arr_product_id);

                foreach ($arr_product as $product)
                {
                    $weight += $product->weight * ($arr_quantity_lookup[$product->id]);
                }
            }

            if (count($arr_product_id) <= 0 || $count_voucher_printed > 0)
            {
                $weight = $weight + 1;
            }

            $this->db->where('country_id', $country_id);
            $this->db->where('province_id', $province_id);
            $this->db->where('city_id', $city_id);
            $this->db->where('district_id', $district_id);
            $this->db->order_by('name');
            $arr_shipping = $this->core_model->get('shipping');

            foreach ($arr_shipping as $shipping)
            {
                if ($country_id == '233')
                {
                    $price = $shipping->price / $currency->currency_exchange;

                    if ($shipping->type != 'GOJEK / GRAB')
                    {
                        $price = $price * ceil($weight);
                    }

                    $shipping->price_fix = ceil($price);
                    $shipping->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
                }
                else
                {
                    $price = $shipping->price * $arr_all_currency[1]->currency_exchange;
                    $price = $price / $currency->currency_exchange;
                    $price = $price * ceil($weight);

                    $shipping->price_fix = ceil($price);
                    $shipping->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
                }

            }

            $this->session->set_userdata('session_weight', $weight);

            $json['arr_shipping'] = $arr_shipping;
            $json['weight'] = $weight;
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

    public function ajax_save_address()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $address_record = array();
            $image_id = 0;

            foreach ($_POST as $k => $v)
            {
                if ($k == 'image_id')
                {
                    $image_id = $v;
                }
                else
                {
                    $address_record[$k] = ($k == 'date') ? strtotime($v) : $v;
                }
            }

            $address_record = $this->cms_function->populate_foreign_field($address_record['city_id'], $address_record, 'city');
            $address_record = $this->cms_function->populate_foreign_field($address_record['country_id'], $address_record, 'country');
            $address_record = $this->cms_function->populate_foreign_field($address_record['district_id'], $address_record, 'district');
            $address_record = $this->cms_function->populate_foreign_field($address_record['province_id'], $address_record, 'province');
            $address_record = $this->cms_function->populate_foreign_field($address_record['customer_id'], $address_record, 'customer');

            $address_id = $this->core_model->insert('address', $address_record);

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
    /* End Ajax Area */




    /* Private Function Area */
    private function _validate_edit($customer_id, $customer_record)
    {
        $this->db->where('editable <=', 0);
        $this->db->where('id', $customer_id);
        $count_customer = $this->core_model->count('customer');

        if ($count_customer > 0)
        {
            throw new Exception('Data cannot be updated.');
        }

        $this->db->where('id !=', $customer_id);
        $this->db->where('name', $customer_record['name']);
        $count_customer = $this->core_model->count('customer');

        if ($count_customer > 0)
        {
            throw new Exception('Name is already exist.');
        }
    }
    /* End Private Function Area */
}
