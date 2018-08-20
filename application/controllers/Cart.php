<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
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
        $header_id = 0;

        $voucher_value = ($this->session->userdata('session_voucher') == null) ? 0 : $this->session->userdata('session_voucher');
        $voucher_number = ($this->session->userdata('session_voucher_number') == null) ? '' : $this->session->userdata('session_voucher_number');

        $arr_data['title'] = 'Cart';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_cart'] = $this->_get_cart();
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();
        $arr_data['voucher_value'] = $voucher_value;
        $arr_data['voucher_number'] = $voucher_number;

        $this->load->view('cart', $arr_data);
    }

    public function confirm()
    {
        // for manual Transfer
        $header_id = 0;
        $order_number = $this->cms_function->generate_random_number('sale', 8);;
        $status = 'pending';

        $session_cart = $this->session->userdata('session_cart');
        $address = $this->session->userdata('session_address');
        $shipping_id = $this->session->userdata('session_shipping');
        $weight = $this->session->userdata('session_weight');
        $message = ($this->session->userdata('session_message') == null) ? '' : $this->session->userdata('session_message');
        $discount = ($this->session->userdata('session_discount') == null) ? 0 : $this->session->userdata('session_discount');

        if ($session_cart == null || $session_cart == '' || !$session_cart)
        {
            redirect(base_url() . 'cart/');
        }

        // add order
        $currency = $this->core_model->get('currency', $this->_currency);

        $arr_product = $this->core_model->get('product');
        $arr_product_lookup = array();

        $now = time();

        foreach ($arr_product as $product)
        {
            if ($product->discount_period_start > 0 && $product->discount_period_end > 0)
            {
                if ($product->discount_period_start <= $now && ($product->discount_period_end + 86400) >= $now)
                {
                    $product->price = ($product->discount > 0) ? ($product->price - (($product->discount / 100) * $product->price)) : $product->price;
                }
            }

            $arr_product_lookup[$product->id] = clone $product;
        }

        $this->db->trans_start();

        $shipping = $this->core_model->get('shipping', $shipping_id);
        $shipping->price_fix = $shipping->price * $weight;

        // insert sale
        $sale_record = array();
        $customer_id = (!$this->_customer) ? 0 : $this->_customer->id;

        $sale_record['customer_id'] = $customer_id;
        $sale_record['location_id'] = 1;
        $sale_record['number'] = $order_number;
        $sale_record['status'] = $status;
        $sale_record['date'] = time();
        $sale_record['weight'] = $weight;
        $sale_record['discount'] = $discount;
        $sale_record['shipping'] = $shipping->price_fix;
        $sale_record['message'] = $message;

        $sale_record['shipping_name'] = $address->first_name . ' ' . $address->last_name;
        $sale_record['shipping_address'] = $address->address;
        $sale_record['shipping_phone'] = $address->phone;
        $sale_record['shipping_email'] = $address->email;
        $sale_record['shipping_zip_code'] = $address->zip_code;
        $sale_record['shipping_country'] = $shipping->country_name;
        $sale_record['shipping_province'] = $shipping->province_name;
        $sale_record['shipping_city'] = $shipping->city_name;
        $sale_record['shipping_district'] = $shipping->district_name;
        $sale_record['shipping_courier'] = $shipping->name . ' ' . $shipping->type;
        $sale_record['shipping_etd'] = $shipping->etd;

        $sale_record = $this->cms_function->populate_foreign_field($sale_record['customer_id'], $sale_record, 'customer');
        $sale_record = $this->cms_function->populate_foreign_field($sale_record['location_id'], $sale_record, 'location');

        $sale_id = $this->core_model->insert('sale', $sale_record);

        $subtotal = 0;

        // insert sale_item
        $arr_sess_cart = json_decode($session_cart);

        foreach ($arr_sess_cart as $sess_cart)
        {
            $sale_item_record = array();

            $sale_item_record['product_id'] = $sess_cart->product_id;
            $sale_item_record['voucher_id'] = $sess_cart->voucher_id;
            $sale_item_record['customer_id'] = $customer_id;
            $sale_item_record['location_id'] = 1;
            $sale_item_record['sale_id'] = $sale_id;
            $sale_item_record['quantity'] = $sess_cart->quantity;
            $sale_item_record['price'] = (isset($arr_product_lookup[$sess_cart->product_id])) ? $arr_product_lookup[$sess_cart->product_id]->price : 0;

            if ($sess_cart->voucher_id > 0)
            {
                $voucher = $this->core_model->get('voucher', $sale_item_record['voucher_id']);
                $sale_item_record['price'] = $voucher->value;

                $sale_item_record['voucher_type'] = $voucher->type;
                $sale_item_record['voucher_number'] = $voucher->number;
                $sale_item_record['voucher_name'] = $voucher->name;
                $sale_item_record['voucher_date'] = $voucher->date;
                $sale_item_record['voucher_status'] = $voucher->status;
            }
            else
            {
                $sale_item_record = $this->cms_function->populate_foreign_field($sale_item_record['product_id'], $sale_item_record, 'product');
            }

            $sale_item_record = $this->cms_function->populate_foreign_field($sale_item_record['customer_id'], $sale_item_record, 'customer');
            $sale_item_record = $this->cms_function->populate_foreign_field($sale_item_record['location_id'], $sale_item_record, 'location');
            $sale_item_record = $this->cms_function->populate_foreign_field($sale_item_record['sale_id'], $sale_item_record, 'sale');

            $sale_item_id = $this->core_model->insert('sale_item', $sale_item_record);

            if ($sale_item_record['voucher_id'] > 0)
            {
                $arr_message = array();

                if ($sess_cart->type != 'Virtual')
                {
                    $arr_message = json_decode($sess_cart->message);
                }

                for ($i = 0; $i < $sale_item_record['quantity']; $i++)
                {
                    $voucher_code_record = array();
                    $voucher_code_record['voucher_id'] = $voucher->id;
                    $voucher_code_record['sale_id'] = $sale_id;
                    $voucher_code_record['sale_item_id'] = $sale_item_id;
                    $voucher_code_record['customer_id'] = $customer_id;
                    $voucher_code_record['status'] = 'Vacant';

                    if ($sess_cart->type == 'Virtual')
                    {
                        $voucher_code_record['message'] = $sess_cart->message;
                        $voucher_code_record['recipient_name'] = $sess_cart->name;
                        $voucher_code_record['recipient_email'] = $sess_cart->email;
                    }
                    else
                    {
                        $voucher_code_record['message'] = $arr_message[$i];
                    }

                    $voucher_code_record['number'] = $this->cms_function->generate_random_number('voucher_code', 8);

                    $voucher_code_record['voucher_type'] = $voucher->type;
                    $voucher_code_record['voucher_number'] = $voucher->number;
                    $voucher_code_record['voucher_name'] = $voucher->name;
                    $voucher_code_record['voucher_date'] = $voucher->date;
                    $voucher_code_record['voucher_status'] = $voucher->status;

                    $voucher_code_record = $this->cms_function->populate_foreign_field($voucher_code_record['customer_id'], $voucher_code_record, 'customer');
                    $voucher_code_record = $this->cms_function->populate_foreign_field($voucher_code_record['sale_item_id'], $voucher_code_record, 'sale_item');
                    $voucher_code_record = $this->cms_function->populate_foreign_field($voucher_code_record['sale_id'], $voucher_code_record, 'sale');
                    $voucher_code_id = $this->core_model->insert('voucher_code', $voucher_code_record);
                }
            }

            $subtotal += $sale_item_record['price'];
        }

        // update total
        $total = $subtotal - $discount + $shipping->price_fix;
        $this->core_model->update('sale', $sale_id, array('subtotal' => $subtotal, 'total' => $total));

        // update voucher
        $this->db->where('number', $this->session->userdata('session_voucher_number'));
        $this->core_model->update('voucher_code', 0, array('status' => 'Used'));

        $this->db->trans_complete();

        // SEND EMAIL
        $this->_send_confirmation_email($sale_id, 'manual');

        // unset session for cart
        $this->session->unset_userdata('amount_total');
        $this->session->unset_userdata('session_cart');
        $this->session->unset_userdata('session_address');
        $this->session->unset_userdata('session_shipping');
        $this->session->unset_userdata('session_weight');
        $this->session->unset_userdata('session_message');
        $this->session->unset_userdata('session_discount');
        $this->session->unset_userdata('session_discount_percentage');
        $this->session->unset_userdata('session_voucher');
        $this->session->unset_userdata('session_voucher_number');

        $arr_data['title'] = 'Confirmation';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['order_number'] = $order_number;
        $arr_data['sale_record'] = $sale_record;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('cart-confirmation', $arr_data);
    }

    public function confirmation()
    {
        // for midtrans
        $header_id = 0;
        $order_number = $_GET['order_id'];
        $status = $_GET['transaction_status'];
        $amount = $this->session->userdata('amount_total');

        if ($amount == null)
        {
            redirect(base_url() . 'cart/');
        }

        // add order
        $currency = $this->core_model->get('currency', $this->_currency);

        $arr_product = $this->core_model->get('product');
        $arr_product_lookup = array();

        foreach ($arr_product as $product)
        {
            if ($product->discount_period_start > 0 && $product->discount_period_end > 0)
            {
                if ($product->discount_period_start <= $now && ($product->discount_period_end + 86400) >= $now)
                {
                    $product->price = ($product->discount > 0) ? ($product->price - (($product->discount / 100) * $product->price)) : $product->price;
                }
            }

            $arr_product_lookup[$product->id] = clone $product;
        }

        $this->db->trans_start();

        $session_cart = $this->session->userdata('session_cart');
        $address = $this->session->userdata('session_address');
        $shipping_id = $this->session->userdata('session_shipping');
        $weight = $this->session->userdata('session_weight');
        $message = ($this->session->userdata('session_message') == null) ? '' : $this->session->userdata('session_message');
        $discount = ($this->session->userdata('session_discount') == null) ? 0 : $this->session->userdata('session_discount');

        $shipping = $this->core_model->get('shipping', $shipping_id);
        $shipping->price_fix = $shipping->price * $weight;

        // insert sale
        $sale_record = array();
        $customer_id = (!$this->_customer) ? 0 : $this->_customer->id;

        $sale_record['customer_id'] = $customer_id;
        $sale_record['location_id'] = 1;
        $sale_record['number'] = $order_number;
        $sale_record['status'] = $status;
        $sale_record['date'] = time();
        $sale_record['weight'] = $weight;
        $sale_record['subtotal'] = $amount - $shipping->price_fix + $discount;
        $sale_record['discount'] = $discount;
        $sale_record['shipping'] = $shipping->price_fix;
        $sale_record['total'] = $amount;
        $sale_record['message'] = $message;

        $sale_record['shipping_name'] = $address->first_name . ' ' . $address->last_name;
        $sale_record['shipping_address'] = $address->address;
        $sale_record['shipping_phone'] = $address->phone;
        $sale_record['shipping_email'] = $address->email;
        $sale_record['shipping_zip_code'] = $address->zip_code;
        $sale_record['shipping_country'] = $shipping->country_name;
        $sale_record['shipping_province'] = $shipping->province_name;
        $sale_record['shipping_city'] = $shipping->city_name;
        $sale_record['shipping_district'] = $shipping->district_name;
        $sale_record['shipping_courier'] = $shipping->name . ' ' . $shipping->type;
        $sale_record['shipping_etd'] = $shipping->etd;

        $sale_record = $this->cms_function->populate_foreign_field($sale_record['customer_id'], $sale_record, 'customer');
        $sale_record = $this->cms_function->populate_foreign_field($sale_record['location_id'], $sale_record, 'location');

        $sale_id = $this->core_model->insert('sale', $sale_record);

        // insert sale_item
        $arr_sess_cart = json_decode($session_cart);

        foreach ($arr_sess_cart as $sess_cart)
        {
            $sale_item_record = array();

            $sale_item_record['product_id'] = $sess_cart->product_id;
            $sale_item_record['voucher_id'] = $sess_cart->voucher_id;
            $sale_item_record['customer_id'] = $customer_id;
            $sale_item_record['location_id'] = 1;
            $sale_item_record['sale_id'] = $sale_id;
            $sale_item_record['quantity'] = $sess_cart->quantity;
            $sale_item_record['price'] = (isset($arr_product_lookup[$sess_cart->product_id])) ? $arr_product_lookup[$sess_cart->product_id]->price : 0;

            if ($sess_cart->voucher_id > 0)
            {
                $voucher = $this->core_model->get('voucher', $sale_item_record['voucher_id']);
                $sale_item_record['price'] = $voucher->value;

                $sale_item_record['voucher_type'] = $voucher->type;
                $sale_item_record['voucher_number'] = $voucher->number;
                $sale_item_record['voucher_name'] = $voucher->name;
                $sale_item_record['voucher_date'] = $voucher->date;
                $sale_item_record['voucher_status'] = $voucher->status;
            }
            else
            {
                $sale_item_record = $this->cms_function->populate_foreign_field($sale_item_record['product_id'], $sale_item_record, 'product');
            }

            $sale_item_record = $this->cms_function->populate_foreign_field($sale_item_record['customer_id'], $sale_item_record, 'customer');
            $sale_item_record = $this->cms_function->populate_foreign_field($sale_item_record['location_id'], $sale_item_record, 'location');
            $sale_item_record = $this->cms_function->populate_foreign_field($sale_item_record['sale_id'], $sale_item_record, 'sale');

            $sale_item_id = $this->core_model->insert('sale_item', $sale_item_record);

            if ($sale_item_record['voucher_id'] > 0)
            {
                $arr_message = array();

                if ($sess_cart->type != 'Virtual')
                {
                    $arr_message = json_decode($sess_cart->message);
                }

                for ($i = 0; $i < $sale_item_record['quantity']; $i++)
                {
                    $voucher_code_record = array();
                    $voucher_code_record['voucher_id'] = $voucher->id;
                    $voucher_code_record['sale_id'] = $sale_id;
                    $voucher_code_record['sale_item_id'] = $sale_item_id;
                    $voucher_code_record['customer_id'] = $customer_id;
                    $voucher_code_record['status'] = 'Vacant';

                    if ($sess_cart->type == 'Virtual')
                    {
                        $voucher_code_record['message'] = $sess_cart->message;
                        $voucher_code_record['recipient_name'] = $sess_cart->name;
                        $voucher_code_record['recipient_email'] = $sess_cart->email;
                    }
                    else
                    {
                        $voucher_code_record['message'] = $arr_message[$i];
                    }

                    $voucher_code_record['number'] = $this->cms_function->generate_random_number('voucher_code', 8);

                    $voucher_code_record['voucher_type'] = $voucher->type;
                    $voucher_code_record['voucher_number'] = $voucher->number;
                    $voucher_code_record['voucher_name'] = $voucher->name;
                    $voucher_code_record['voucher_date'] = $voucher->date;
                    $voucher_code_record['voucher_status'] = $voucher->status;

                    $voucher_code_record['value'] = $voucher->value;

                    $voucher_code_record = $this->cms_function->populate_foreign_field($voucher_code_record['customer_id'], $voucher_code_record, 'customer');
                    $voucher_code_record = $this->cms_function->populate_foreign_field($voucher_code_record['sale_item_id'], $voucher_code_record, 'sale_item');
                    $voucher_code_record = $this->cms_function->populate_foreign_field($voucher_code_record['sale_id'], $voucher_code_record, 'sale');
                    $voucher_code_id = $this->core_model->insert('voucher_code', $voucher_code_record);
                }
            }
        }

        $this->db->trans_complete();

        // SEND EMAIL
        $this->_send_confirmation_email($sale_id, 'midtrans');

        // unset session for cart
        $this->session->unset_userdata('amount_total');
        $this->session->unset_userdata('session_cart');
        $this->session->unset_userdata('session_address');
        $this->session->unset_userdata('session_shipping');
        $this->session->unset_userdata('session_weight');
        $this->session->unset_userdata('session_message');
        $this->session->unset_userdata('session_discount');

        $arr_data['title'] = 'Confirmation';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['order_number'] = $order_number;
        $arr_data['sale_record'] = $sale_record;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('cart-confirmation', $arr_data);
    }

    public function payment()
    {
        $header_id = 0;

        $arr_cart = $this->_get_cart();

        if (count($arr_cart) <= 0)
        {
            redirect(base_url() . 'cart/');
        }

         // get all currency
        $arr_all_currency = $this->core_model->get('currency');

        $currency = $this->core_model->get('currency', $this->_currency);
        $address = $this->session->userdata('session_address');
        $shipping_id = $this->session->userdata('session_shipping');
        $weight = $this->session->userdata('session_weight');
        $message = $this->session->userdata('session_message');
        $discount = $this->session->userdata('session_discount');
        $discount_percentage = $this->session->userdata('session_discount_percentage');

        $message = str_replace('h3', 'p', $message);

        // get shipping
        $shipping = $this->core_model->get('shipping', $shipping_id);

        if ($shipping->country_id == 233)
        {
            if ($shipping->type != 'GOJEK / GRAB')
            {
                $shipping->price_fix = ceil($shipping->price / $currency->currency_real) * $weight;
            }
            else
            {
                $shipping->price_fix = ceil($shipping->price / $currency->currency_real);
            }

            $shipping->price_fix_display = $currency->name . ' ' . number_format($shipping->price_fix, 0, ',', '.');
        }
        else
        {
            $price = $shipping->price * $arr_all_currency[1]->currency_real;
            $shipping->price_fix = ceil($price / $currency->currency_real) * $weight;
            $shipping->price_fix_display = $currency->name . ' ' . number_format($shipping->price_fix, 0, ',', '.');
        }

        $discount_display = '';
        $discount = $discount / $currency->currency_real;

        $arr_data['title'] = 'Payment';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_cart'] = $arr_cart;
        $arr_data['address'] = $address;
        $arr_data['shipping'] = $shipping;
        $arr_data['message'] = $message;
        $arr_data['discount'] = $discount;
        $arr_data['discount_percentage'] = $discount_percentage;
        $arr_data['discount_display'] = $discount_display;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('cart-payment', $arr_data);
    }

    public function review()
    {
        $header_id = 0;

        $arr_cart = $this->_get_cart();

        if (count($arr_cart) <= 0)
        {
            redirect(base_url() . 'cart/');
        }

        // get all currency
        $arr_all_currency = $this->core_model->get('currency');

        $currency = $this->core_model->get('currency', $this->_currency);
        $address = $this->session->userdata('session_address');
        $shipping_id = $this->session->userdata('session_shipping');
        $weight = $this->session->userdata('session_weight');
        $message = $this->session->userdata('session_message');

        $message = str_replace('h3', 'p', $message);

        // get shipping
        $shipping = $this->core_model->get('shipping', $shipping_id);

        if ($shipping->country_id == 233)
        {
            if ($shipping->type != 'GOJEK / GRAB')
            {
                $shipping->price_fix = ceil($shipping->price / $currency->currency_real) * $weight;
            }
            else
            {
                $shipping->price_fix = ceil($shipping->price / $currency->currency_real);
            }

            $shipping->price_fix_display = $currency->name . ' ' . number_format($shipping->price_fix, 0, ',', '.');
        }
        else
        {
            $price = $shipping->price * $arr_all_currency[1]->currency_real;
            $shipping->price_fix = ceil($price / $currency->currency_real) * $weight;
            $shipping->price_fix_display = $currency->name . ' ' . number_format($shipping->price_fix, 0, ',', '.');
        }

        $voucher_value = ($this->session->userdata('session_voucher') == null) ? 0 : $this->session->userdata('session_voucher');
        $voucher_number = ($this->session->userdata('session_voucher_number') == null) ? '' : $this->session->userdata('session_voucher_number');

        if ($voucher_value > 0)
        {
            $discount = $voucher_value;
            $discount_percentage = 0;
            $discount_display = 0;

            $this->session->set_userdata('session_discount', $discount);
            $this->session->set_userdata('session_discount_percentage', $discount_percentage);
        }
        else
        {
            $discount = 0;
            $discount_percentage = 0;
            $discount_display = 0;

            // get discount for first registraion
            if ($this->_customer)
            {
                if ($this->_setting->setting__webshop_registration_promo > 0)
                {
                    $this->db->where('customer_id', $this->_customer->id);
                    $count_sale = $this->core_model->count('sale');

                    if ($count_sale <= 0)
                    {
                        $discount_percentage = $this->_setting->setting__webshop_registration_promo;
                        $discount = 0;
                    }
                }
            }

            if ($this->_setting->setting__webshop_promo == 'Free Shipping')
            {
                $count_sale = $this->core_model->count('sale');

                if ($this->_setting->setting__webshop_promo_count_sale > 0 && $count_sale <= $this->_setting->setting__webshop_promo_count_sale)
                {
                    $discount_percentage = 0;
                    $discount = $shipping->price_fix;
                }
            }
            elseif ($this->_setting->setting__webshop_promo == 'Discount')
            {
                $count_sale = $this->core_model->count('sale');

                if ($this->_setting->setting__webshop_promo_count_sale > 0 && $count_sale <= $this->_setting->setting__webshop_promo_count_sale)
                {
                    $discount_percentage = $this->_setting->setting__webshop_promo_value;
                    $discount = 0;
                }
            }
            elseif ($this->_setting->setting__webshop_promo == 'Price')
            {
                $count_sale = $this->core_model->count('sale');

                if ($this->_setting->setting__webshop_promo_count_sale > 0 && $count_sale <= $this->_setting->setting__webshop_promo_count_sale)
                {
                    $discount_percentage = 0;
                    $discount = $this->_setting->setting__webshop_promo_value;
                    $discount = $discount / $currency->currency_real;
                }
            }

            $this->session->set_userdata('session_discount', $discount);
            $this->session->set_userdata('session_discount_percentage', $discount_percentage);
        }

        $arr_data['title'] = 'Review';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_cart'] = $arr_cart;
        $arr_data['address'] = $address;
        $arr_data['shipping'] = $shipping;
        $arr_data['message'] = $message;
        $arr_data['discount'] = $discount;
        $arr_data['discount_percentage'] = $discount_percentage;
        $arr_data['discount_display'] = $discount_display;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('cart-review', $arr_data);
    }

    public function shipping($address_id = 0)
    {
        $header_id = 0;

        $arr_cart = $this->_get_cart();

        $voucher_value = ($this->session->userdata('session_voucher') == null) ? 0 : $this->session->userdata('session_voucher');
        $voucher_number = ($this->session->userdata('session_voucher_number') == null) ? '' : $this->session->userdata('session_voucher_number');

        if (count($arr_cart) <= 0)
        {
            redirect(base_url() . 'cart/');
        }

        // get cart
        $currency = $this->core_model->get('currency', $this->_currency);

        // get all currency
        $arr_all_currency = $this->core_model->get('currency');

        $arr_address = array();

        if ($this->_customer)
        {
            // get all address
            $this->db->where('customer_id', $this->_customer->id);
            $arr_address = $this->core_model->get('address');
        }

        // get all country
        $this->db->order_by('name');
        $arr_country = $this->core_model->get('country');

        // get all country
        $this->db->order_by('name');
        $arr_province = $this->core_model->get('province');

        $selected_address = $this->core_model->get('address', $address_id);

        $arr_city = array();
        $arr_district = array();
        $arr_shipping = array();

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

        $this->session->set_userdata('session_weight', $weight);

        if ($address_id > 0)
        {
            $this->db->where('province_id', $selected_address->province_id);
            $this->db->order_by('name');
            $arr_city = $this->core_model->get('city');

            $this->db->where('city_id', $selected_address->city_id);
            $this->db->order_by('name');
            $arr_district = $this->core_model->get('district');

            $this->db->where('province_id', $selected_address->country_id);
            $this->db->where('province_id', $selected_address->province_id);
            $this->db->where('city_id', $selected_address->city_id);
            $this->db->where('district_id', $selected_address->district_id);
            $this->db->order_by('name');
            $arr_shipping = $this->core_model->get('shipping');

            foreach ($arr_shipping as $shipping)
            {
                if ($selected_address->country_id == 233)
                {
                    $price = $shipping->price / $currency->currency_real;
                    $price = $price * ceil($weight);

                    $shipping->price_fix = ceil($price);
                    $shipping->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
                }
                else
                {
                    $price = $shipping->price * $arr_all_currency[1]->currency_real;
                    $price = $price * ceil($weight);

                    $shipping->price_fix = ceil($price);
                    $shipping->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
                }
            }
        }

        // get message
        $message = ($this->session->userdata('session_message')) ? $this->session->userdata('session_message') : '';

        $arr_data['title'] = 'Shipping';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_cart'] = $this->_get_cart();
        $arr_data['address_id'] = $address_id;
        $arr_data['arr_address'] = $arr_address;
        $arr_data['arr_country'] = $arr_country;
        $arr_data['arr_province'] = $arr_province;
        $arr_data['arr_city'] = $arr_city;
        $arr_data['arr_district'] = $arr_district;
        $arr_data['arr_shipping'] = $arr_shipping;
        $arr_data['selected_address'] = $selected_address;
        $arr_data['message'] = $message;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();
        $arr_data['voucher_value'] = $voucher_value;
        $arr_data['voucher_number'] = $voucher_number;

        $this->load->view('cart-shipping', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    public function ajax_generate_order_number()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            // get all currency
            $arr_all_currency = $this->core_model->get('currency');

            $selected_currency = $this->core_model->get('currency', $this->_currency);

            $gross_amount = $this->input->post('gross_amount');
            $number = $this->cms_function->generate_random_number('sale', 8);

            // testing midtrans api
            $auth_string = base64_encode($this->_setting->setting__third_party_midtrans_server_key . ':');

            $arr_header = array();
            $arr_header[] = 'Accept: application/json';
            $arr_header[] = 'Content-Type: application/json';
            $arr_header[] = 'Authorization: Basic ' . $auth_string;

            // get item
            $arr_cart = $this->_get_cart();
            $discount = $this->session->userdata('session_discount');
            $discount_percentage = $this->session->userdata('session_discount_percentage');
            $shipping_id = $this->session->userdata('session_shipping');
            $weight = $this->session->userdata('session_weight');
            $address = $this->session->userdata('session_address');

            $item = '';
            $subtotal = 0;

            // get all product
            $arr_product = $this->core_model->get('product');

            $arr_product_lookup = array();

            foreach ($arr_product as $product)
            {
                $arr_product_lookup[$product->id] = clone $product;
            }

            foreach ($arr_cart as $key => $cart)
            {
                if ($key > 0)
                {
                    $item .= ', ';
                }

                $price = ceil($cart->product_price * $selected_currency->currency_real);
                $item .= '{"id": "' . $cart->product_id . '","price": ' . number_format($price, 0, '', '') . ',"quantity": ' . number_format($cart->quantity, 0, '', '') . ',"name": "'. $cart->product_name .'"}';
                $subtotal += $price * $cart->quantity;
            }

            // get discount
            if ($discount <= 0)
            {
                $discount = ($discount_percentage / 100) * $subtotal;
            }

            $item .= ', {"id": "9999998","price": -' . number_format($discount, 0, '', '') . ',"quantity": 1,"name": "Discount"}';

            // get shipping
            $shipping = $this->core_model->get('shipping', $shipping_id);

            if ($shipping->country_id == 233)
            {
                if ($shipping->type != 'GOJEK / GRAB')
                {
                    $shipping->price_fix = $shipping->price * $weight;
                }
                else
                {
                    $shipping->price_fix = $shipping->price;
                }
            }
            else
            {
                $price = $shipping->price * $arr_all_currency[1]->currency_real;
	            $shipping->price_fix = $price * $weight;
            }

            $item .= ', {"id": "9999999","price": ' . number_format($shipping->price_fix, 0, '', '') . ',"quantity": 1,"name": "Shipping by ' . $shipping->type . '"}';

            $gross_amount = $subtotal - number_format($discount, 0, '', '') + number_format($shipping->price_fix, 0, '', '');

            //customer_detail
            $customer_detail = '"first_name": "' . $address->first_name . '", "last_name": "' . $address->last_name . '", "email": "' . $address->email . '", "phone": "' . $address->phone . '", "shipping_address": {"first_name": "' . $address->first_name . '", "last_name": "' . $address->last_name . '", "email": "' . $address->email . '", "phone": "' . $address->phone . '", "address": "' . $address->address . '", "city": "' . $shipping->city_name . '", "postal_code": "12190", "' . $address->zip_code . '": "' . $shipping->country_name . '"}';

            $post = '{"transaction_details": {"order_id": "' . $number . '","gross_amount": ' . $gross_amount . '}, "item_details": [' . $item . '], "customer_details": {' . $customer_detail . '}, "credit_card": {"secure": true}}';

            $ch = curl_init('https://app.midtrans.com/snap/v1/transactions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $arr_header);
            $response = curl_exec($ch);

            curl_close($ch);

            $result = json_decode($response);
            $token = $result->token;

            $this->session->set_userdata('amount_total', $gross_amount);

            $json['number'] = $number;
            $json['token'] = $token;

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

    public function ajax_get_voucher($voucher_number = '')
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            if ($voucher_number == '')
            {
                // set session
                $this->session->set_userdata('session_voucher', 0);
                $this->session->set_userdata('session_voucher_id', 0);

                $json['voucher_code'] = '';
                $json['value'] = 0;
            }
            else
            {
                $currency = $this->core_model->get('currency', $this->_currency);

                $this->db->where('number', $voucher_number);
                $this->db->where('status', 'Vacant');
                $arr_voucher_code = $this->core_model->get('voucher_code');

                if (count($arr_voucher_code) <= 0)
                {
                    throw new Exception('Voucher not found.');
                }

                $voucher_code = $arr_voucher_code[0];

                if ($voucher_code->voucher_type == 'Virtual' && $this->_customer->email != $voucher_code->recipient_email)
                {
                    throw new Exception('Voucher not found.');
                }

                $voucher_code->value = ceil($voucher_code->value / $currency->currency_real);

                // set session
                $this->session->set_userdata('session_voucher', $voucher_code->value);
                $this->session->set_userdata('session_voucher_number', $voucher_code->number);

                $json['voucher_code'] = $voucher_code->number;
                $json['value'] = $voucher_code->value;
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

    public function ajax_remove_cart()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $product_id = $this->input->post('product_id');
            $voucher_id = $this->input->post('voucher_id');
            $arr_cart = array();

            // get old session cart
            $old_session_cart = ($this->session->userdata('session_cart')) ? $this->session->userdata('session_cart') : '';

            $arr_old_cart = ($old_session_cart != '') ? json_decode($old_session_cart) : array();

            foreach ($arr_old_cart as $key => $old_cart)
            {
                if ($old_cart->product_id == $product_id && $old_cart->voucher_id == $voucher_id)
                {
                    continue;
                }

                $arr_cart[] = clone $old_cart;
            }

            $session_cart = json_encode($arr_cart);
            $this->session->set_userdata('session_cart', $session_cart);

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

    public function ajax_remove_message()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $this->session->set_userdata('session_message', '');

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

    public function ajax_set_message()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $message = $this->input->post('message');
            $this->session->set_userdata('session_message', $message);

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

    public function ajax_set_shipping()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $name = $this->input->post('name');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $new_address = $this->input->post('address');
            $zip_code = $this->input->post('zip_code');
            $city_id = $this->input->post('city_id');
            $country_id = $this->input->post('country_id');
            $district_id = $this->input->post('district_id');
            $province_id = $this->input->post('province_id');
            $shipping_id = $this->input->post('shipping_id');

            $customer_id = (!$this->_customer) ? 0 : $this->_customer->id;

            // insert customer
            if ($customer_id <= 0)
            {
                $password = $this->input->post('password');

                if ($password != '')
                {
                    // check email exist
                    $this->db->where('email', $email);
                    $count_customer = $this->core_model->count('customer');

                    if ($count_customer > 0)
                    {
                        throw new Exception('Email already exist.');
                    }

                    $customer_record = array();
                    $customer_record['name'] = $first_name . ' ' . $last_name;
                    $customer_record['phone'] = $phone;
                    $customer_record['email'] = $email;
                    $customer_record['password'] = md5($password);
                    $customer_id = $this->core_model->insert('customer', $customer_record);

                    $this->session->set_userdata('customer_id', $customer_id);
                    $this->session->set_userdata('customer_name', $customer_record['name']);
                }
            }

            // insert to address
            $address = new stdClass();
            $address->first_name = $first_name;
            $address->last_name = $last_name;
            $address->phone = $phone;
            $address->email = $email;
            $address->address = $new_address;
            $address->zip_code = $zip_code;
            $address->country_id = $country_id;
            $address->city_id = $city_id;
            $address->district_id = $district_id;
            $address->province_id = $province_id;
            $address->customer_id = $customer_id;

            $session_address = $address;
            $this->session->set_userdata('session_address', $session_address);
            $this->session->set_userdata('session_shipping', $shipping_id);

            if ($name != '')
            {
                $address_record = array();
                $address->name = $name;

                foreach ($address as $k => $v)
                {
                    $address_record[$k] = $v;
                }

                $address_record = $this->cms_function->populate_foreign_field($address_record['customer_id'], $address_record, 'customer');
                $address_record = $this->cms_function->populate_foreign_field($address_record['country_id'], $address_record, 'country');
                $address_record = $this->cms_function->populate_foreign_field($address_record['province_id'], $address_record, 'province');
                $address_record = $this->cms_function->populate_foreign_field($address_record['city_id'], $address_record, 'city');
                $address_record = $this->cms_function->populate_foreign_field($address_record['district_id'], $address_record, 'district');

                $this->core_model->insert('address', $address_record);
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

    public function ajax_update_cart()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $product_id = $this->input->post('product_id');
            $voucher_id = $this->input->post('voucher_id');
            $quantity = $this->input->post('quantity');
            $arr_cart = array();

            // get old session cart
            $old_session_cart = ($this->session->userdata('session_cart')) ? $this->session->userdata('session_cart') : '';

            $arr_old_cart = ($old_session_cart != '') ? json_decode($old_session_cart) : array();

            foreach ($arr_old_cart as $key => $old_cart)
            {
                if ($old_cart->product_id == $product_id && $old_cart->voucher_id == $voucher_id)
                {
                    $old_cart->quantity = $quantity;
                }

                $arr_cart[] = clone $old_cart;
            }

            $session_cart = json_encode($arr_cart);
            $this->session->set_userdata('session_cart', $session_cart);

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
    private function _get_cart()
    {
        // get cart
        $currency = $this->core_model->get('currency', $this->_currency);

        $arr_product_lookup = array();
        $arr_voucher_lookup = array();

        // get all product
        $arr_product = $this->core_model->get('product');
        $arr_product_id = $this->cms_function->extract_records($arr_product, 'id');

        $arr_image_lookup = array();
        $arr_inventory_lookup = array();

        if (count($arr_product_id) > 0)
        {
            $this->db->where_in('product_id', $arr_product_id);
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_image_lookup[$image->product_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }

            // get inventory
            $this->db->where_in('product_id', $arr_product_id);
            $this->db->where('location_id', '1');
            $arr_inventory = $this->core_model->get('inventory');

            foreach ($arr_inventory as $inventory)
            {
                $arr_inventory_lookup[$inventory->product_id] = $inventory->quantity;
            }
        }

        $now = time();

        foreach ($arr_product as $product)
        {
            $product->image_name = (isset($arr_image_lookup[$product->id])) ? $arr_image_lookup[$product->id] : '';

            $price = ceil($product->price / $currency->currency_exchange);

            if ($product->discount_period_start > 0 && $product->discount_period_end > 0)
            {
                if ($product->discount_period_start <= $now && ($product->discount_period_end + 86400) >= $now)
                {
                    $price = ($product->discount > 0) ? ($price - (($product->discount / 100) * $price)) : $price;
                }
            }

            $product->price = $price;
            $product->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
            $product->weight_display = number_format($product->weight, 2, ',', '.');

            $product->max_quantity = isset($arr_inventory_lookup[$product->id]) ? number_format($arr_inventory_lookup[$product->id], 0, '', '') : 0;

            $arr_product_lookup[$product->id] = clone $product;
        }

        // get all voucher
        $arr_voucher = $this->core_model->get('voucher');
        $arr_voucher_id = $this->cms_function->extract_records($arr_voucher, 'id');

        foreach ($arr_voucher as $voucher)
        {
            $voucher->image_name = ($voucher->type != 'Printed') ? base_url() . 'assets/images/giftcard/virtual.png' :  base_url() . 'assets/images/giftcard/printed.png';;

            $price = ceil($voucher->value / $currency->currency_exchange);

            $voucher->price = $price;
            $voucher->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
            $voucher->weight = ($voucher->type == 'Printed') ? 1 : 0;
            $voucher->weight_display = ($voucher->type == 'Printed') ? 1 : 0;

            $voucher->max_quantity = 0;

            $arr_voucher_lookup[$voucher->id] = clone $voucher;
        }

        // get old session cart
        $session_cart = ($this->session->userdata('session_cart')) ? $this->session->userdata('session_cart') : '';
        $arr_sess_cart = ($session_cart != '') ? json_decode($session_cart) : array();

        $arr_cart = array();
        $cart_id = 1;

        foreach ($arr_sess_cart as $sess_cart)
        {
            $sess_cart->id = $cart_id;

            if ($sess_cart->product_id > 0)
            {
                $sess_cart->product_name = isset($arr_product_lookup[$sess_cart->product_id]) ? $arr_product_lookup[$sess_cart->product_id]->name : '';
                $sess_cart->product_price = isset($arr_product_lookup[$sess_cart->product_id]) ? $arr_product_lookup[$sess_cart->product_id]->price : '';
                $sess_cart->product_price_display = $currency->name . ' ' . number_format($sess_cart->product_price, 0, ',', '.');
                $sess_cart->product_weight = isset($arr_product_lookup[$sess_cart->product_id]) ? $arr_product_lookup[$sess_cart->product_id]->weight : '';
                $sess_cart->image_name = isset($arr_product_lookup[$sess_cart->product_id]) ? $arr_product_lookup[$sess_cart->product_id]->image_name : '';
                $sess_cart->product_max_quantity = isset($arr_product_lookup[$sess_cart->product_id]) ? $arr_product_lookup[$sess_cart->product_id]->max_quantity : '';

                $sess_cart->total = $sess_cart->product_price * $sess_cart->quantity;
                $sess_cart->total_display = $currency->name . ' ' . number_format($sess_cart->total, 0, ',', '.');

                $sess_cart->currency_name = $currency->name;
            }
            else
            {
                $sess_cart->product_name = isset($arr_voucher_lookup[$sess_cart->voucher_id]) ? $arr_voucher_lookup[$sess_cart->voucher_id]->name : '';
                $sess_cart->product_price = isset($arr_voucher_lookup[$sess_cart->voucher_id]) ? $arr_voucher_lookup[$sess_cart->voucher_id]->price : '';
                $sess_cart->product_price_display = $currency->name . ' ' . number_format($sess_cart->product_price, 0, ',', '.');
                $sess_cart->product_weight = 1;
                $sess_cart->image_name = isset($arr_voucher_lookup[$sess_cart->voucher_id]) ? $arr_voucher_lookup[$sess_cart->voucher_id]->image_name : '';
                $sess_cart->product_max_quantity = isset($arr_voucher_lookup[$sess_cart->voucher_id]) ? $arr_voucher_lookup[$sess_cart->voucher_id]->max_quantity : '';

                $sess_cart->total = $sess_cart->product_price * $sess_cart->quantity;
                $sess_cart->total_display = $currency->name . ' ' . number_format($sess_cart->total, 0, ',', '.');

                $sess_cart->currency_name = $currency->name;
            }

            $cart_id += 1;
        }

        return $arr_sess_cart;
    }

    private function _send_confirmation_email($sale_id, $type = 'manual')
    {
        // get sale
        $sale = $this->core_model->get('sale', $sale_id);
        $sale->subtotal_display = number_format($sale->subtotal, 0, '.', ',');
        $sale->discount_display = number_format($sale->discount, 0, '.', ',');
        $sale->shipping_display = number_format($sale->shipping, 0, '.', ',');
        $sale->total_display = number_format($sale->total, 0, '.', ',');

        // get sale_item
        $this->db->where('sale_id', $sale_id);
        $arr_sale_item = $this->core_model->get('sale_item');
        $arr_product_id = $this->cms_function->extract_records($arr_sale_item, 'product_id');
        $arr_voucher_id = $this->cms_function->extract_records($arr_sale_item, 'voucher_id');

        $arr_product_image_lookup = array();
        $arr_voucher_image_lookup = array();

        // get image
        if (count($arr_product_id) > 0)
        {
            $this->db->where_in('product_id', $arr_product_id);
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_product_image_lookup[$image->product_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        $arr_voucher = $this->core_model->get('voucher', $arr_voucher_id);

        foreach ($arr_voucher as $voucher)
        {
            $arr_voucher_image_lookup[$voucher->id] = ($voucher->type == 'Virtual') ? base_url() . 'assets/images/giftcard/virtual.png' :  base_url() . 'assets/images/giftcard/printed.png';
        }

        foreach ($arr_sale_item as $sale_item)
        {
            $sale_item->image_name = '';

            if ($sale_item->product_id > 0)
            {
                $sale_item->image_name = (isset($arr_product_image_lookup[$sale_item->product_id])) ? $arr_product_image_lookup[$sale_item->product_id] : '';
            }
            else
            {
                $sale_item->image_name = (isset($arr_voucher_image_lookup[$sale_item->voucher_id])) ? $arr_voucher_image_lookup[$sale_item->voucher_id] : '';
            }

            $sale_item->quantity_display = number_format($sale_item->quantity, 0, '', '');
            $sale_item->price_display = number_format($sale_item->price, 0, '.', ',');
        }

        $arr_content = array();

        // send email
        $this->load->library('email');

        $this->email->from('no-reply@aidanandice.com', 'Aidan and Ice');

        if ($this->_customer)
        {
            $this->email->to($this->_customer->email);
        }
        else
        {
            $this->email->to($sale->shipping_email);
        }

        $this->email->cc('sales@aidanandice.com');
        $this->email->bcc('sugianto@labelideas.co');
        $this->email->set_mailtype('html');

        $arr_content = array();
        $arr_content['sale'] = $sale;
        $arr_content['arr_sale_item'] = $arr_sale_item;
        $arr_content['setting'] = $this->_setting;
        $arr_content['type'] = $type;
        $message = $this->load->view('email/confirmation', $arr_content, true);

        $this->email->subject("[AIDAN AND ICE] Checkout Notification - {$sale->number}");
        $this->email->message($message);

        @$this->email->send();
    }
    /* End Private Function Area */
}
