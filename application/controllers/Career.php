<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Career extends CI_Controller
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
        $header_id = 12;

        $today = time();

        $this->db->where('date <=', $today);
        $this->db->where('date_end >', $today);
        $this->db->order_by('name');
        $arr_career = $this->core_model->get('career');

        $arr_data['title'] = 'Career';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['arr_section'] = $this->cms_function->generate_section($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_career'] = $arr_career;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('career', $arr_data);
    }

    public function detail($url_name = '')
    {
        $header_id = 12;

        if ($url_name == '')
        {
            redirect(base_url() . 'career/');
        }

        $this->db->where('url_name', $url_name);
        $arr_career = $this->core_model->get('career');

        if (count($arr_career) <= 0)
        {
            redirect(base_url() . 'career/');
        }

        $career = $arr_career[0];
        $career->image_name = '';

        $this->db->where('career_id', $career->id);
        $arr_image = $this->core_model->get('image');

        if (count($arr_image) > 0)
        {
            $career->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
        }

        $arr_data['title'] = 'Career Detail';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['career'] = $career;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('career-detail', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    /* End Ajax Area */




    /* Private Function Area */
    /* End Private Function Area */
}
