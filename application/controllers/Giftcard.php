<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Giftcard extends CI_Controller
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
        $header_id = 4;

        $this->db->order_by('value');
        $arr_voucher = $this->core_model->get('voucher');

        foreach ($arr_voucher as $voucher)
        {
            $voucher->quantity = (isset($arr_voucher_code_lookup[$voucher->id])) ? $arr_voucher_code_lookup[$voucher->id] : '';
        }

        $arr_data['title'] = 'Giftcard';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_voucher'] = $arr_voucher;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('giftcard', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    public function ajax_add_to_cart()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            // get currency
            $currency = $this->core_model->get('currency', $this->_currency);

            $voucher_id = $this->input->post('voucher_id');
            $quantity = $this->input->post('quantity');
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');
            $type = $this->input->post('type');
            $arr_cart = array();

            // get old session cart
            $old_session_cart = ($this->session->userdata('session_cart')) ? $this->session->userdata('session_cart') : '';

            $arr_old_cart = ($old_session_cart != '') ? json_decode($old_session_cart) : array();
            $found = 0;

            foreach ($arr_old_cart as $key => $old_cart)
            {
                if ($old_cart->voucher_id == $voucher_id)
                {
                    continue;
                }

                $arr_cart[] = clone $old_cart;
            }

            $cart = new stdClass();
            $cart->product_id = 0;
            $cart->quantity = $quantity;
            $cart->voucher_id = $voucher_id;
            $cart->type = $type;
            $cart->name = $name;
            $cart->email = $email;
            $cart->message = $message;

            $arr_cart[] = clone $cart;;

            $session_cart = json_encode($arr_cart);
            $this->session->set_userdata('session_cart', $session_cart);

            $voucher = $this->core_model->get('voucher', $voucher_id);

            $price = ceil($voucher->value / $currency->currency_exchange);
            $total = $price * $quantity;

            $voucher->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
            $voucher->weight_display = 1;
            $voucher->total_display = $currency->name . ' ' . number_format($total, 0, ',', '.');
            $voucher->quantity = $quantity;
            $voucher->image_name = '';

            $json['voucher'] = $voucher;

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
    /* End Private Function Area */
}
