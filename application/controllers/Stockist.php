<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stockist extends CI_Controller
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
        $header_id = 1;

        $this->db->order_by('id');
        $arr_stockist = $this->core_model->get('stockist');
        $arr_stockist_id = $this->cms_function->extract_records($arr_stockist, 'id');

        $arr_image_lookup = array();

        if (count($arr_stockist_id) > 0)
        {
            $this->db->where_in('stockist_id', $arr_stockist_id);
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_image_lookup[$image->stockist_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_stockist as $stockist)
        {
            $stockist->image_name = (isset($arr_image_lookup[$stockist->id])) ? $arr_image_lookup[$stockist->id] : '';
            $stockist->address = strip_tags($stockist->address);
        }

        $arr_data['title'] = 'Stockist';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();
        $arr_data['arr_stockist'] = $arr_stockist;

        $this->load->view('stockist', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    /* End Ajax Area */




    /* Private Function Area */
    /* End Private Function Area */
}
