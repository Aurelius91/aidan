<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends CI_Controller
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
        $header_id = 13;

        $arr_data['title'] = 'Contact Us';
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
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('contact-us', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    public function ajax_send_contact()
    {
        $json['status'] = 'success';

        try
        {
            $arr_subject = array();
            $arr_subject[1] = 'Customer Care';
            $arr_subject[2] = 'Private Concierge (Home Shopping/Appointment at the office)';
            $arr_subject[3] = 'Press & Media';
            $arr_subject[4] = 'Collaborations or Contributors';
            $arr_subject[5] = 'Feedback & Suggestions';

            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');

            // send email
            $this->load->library('email');

            $this->email->from('no-reply@aidanandice.com', 'Aidan and Ice');

            if ($subject <= 1)
            {
                $this->email->to($this->_setting->system_email_send_to);

                $arr_cc_email = explode(';', $this->_setting->system_email_send_to);

                foreach ($arr_cc_email as $cc_email)
                {
                    $cc_email = trim($cc_email);
                }

                $this->email->cc($arr_cc_email);
            }
            else
            {
                $setting_to = "system_email_send{$subject}_to";
                $setting_cc = "system_email_send{$subject}_cc";
                $this->email->to($this->_setting->$setting_to);

                $arr_cc_email = explode(';', $this->_setting->$setting_cc);

                foreach ($arr_cc_email as $cc_email)
                {
                    $cc_email = trim($cc_email);
                }

                $this->email->cc($arr_cc_email);
            }

            $this->email->to($this->_setting->system_email_send_to);
            $this->email->bcc('sugianto@labelideas.co');
            $this->email->set_mailtype('html');

            $arr_content = array();
            $arr_content['first_name'] = $first_name;
            $arr_content['last_name'] = $last_name;
            $arr_content['email'] = $email;
            $arr_content['message'] = $message;
            $arr_content['subject'] = $arr_subject[$subject];
            $arr_content['setting'] = $this->_setting;
            $message = $this->load->view('email/contact-us', $arr_content, true);

            $this->email->subject("[AIDAN AND ICE] {$arr_subject[$subject]}");
            $this->email->message($message);

            if ($this->input->post('email') && $this->input->post('email') != '')
            {
                @$this->email->send();
            }
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
