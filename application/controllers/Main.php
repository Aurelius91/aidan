<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
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

        // get today date
        $day = date('d', time());
        $month = date('m', time());
        $year = date('Y', time());

        // generate slideshow
        $this->db->order_by('id DESC');
        $this->db->limit(4);
        $arr_slideshow = $this->core_model->get('slideshow');
        $arr_slideshow_id = $this->cms_function->extract_records($arr_slideshow, 'id');

        $arr_image_lookup = array();

        if (count($arr_slideshow_id) > 0)
        {
            $this->db->where_in('slideshow_id', $arr_slideshow_id);
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_image_lookup[$image->slideshow_id][$image->type] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_slideshow as $slideshow)
        {
            $slideshow->image_name = (isset($arr_image_lookup[$slideshow->id][''])) ? $arr_image_lookup[$slideshow->id][''] : '';
            $slideshow->image_mobile_name = (isset($arr_image_lookup[$slideshow->id]['mobile'])) ? $arr_image_lookup[$slideshow->id]['mobile'] : $slideshow->image_name;
        }

        // generate product
        $arr_alterego = $this->core_model->get('alterego');
        $arr_alterego_lookup = array();

        $this->db->order_by('id DESC');
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
            if (isset($arr_alterego_lookup[$product->alterego_id]) && count($arr_alterego_lookup[$product->alterego_id]) >= 8)
            {
                continue;
            }

            $product->image_name = (isset($arr_image_lookup[$product->id])) ? $arr_image_lookup[$product->id] : '';
            $arr_alterego_lookup[$product->alterego_id][] = clone $product;
        }

        $arr_data['title'] = 'Home';
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
        $arr_data['arr_slideshow'] = $arr_slideshow;
        $arr_data['arr_alterego'] = $arr_alterego;
        $arr_data['arr_alterego_lookup'] = $arr_alterego_lookup;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();
        $arr_data['day'] = $day;
        $arr_data['month'] = $month;
        $arr_data['year'] = $year;

        $this->load->view('home', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    public function ajax_login()
    {
        $json['status'] = 'success';

        try
        {
            $this->load->helper('security');

            $email = $this->security->xss_clean($this->input->post('email'));
            $password = md5($this->security->xss_clean($this->input->post('password')));

            $this->db->select('id, name');
            $this->db->where("BINARY email = '{$email}'", null, false);
            $this->db->where("BINARY password = '{$password}'", null, false);
            $arr_customer = $this->core_model->get('customer');

            if (count($arr_customer) <= 0)
            {
                throw new Exception('Wrong Email or Password.');
            }

            $this->session->set_userdata('customer_id', $arr_customer[0]->id);
            $this->session->set_userdata('customer_name', $arr_customer[0]->name);

            $json['customer'] = $arr_customer[0];
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

    public function ajax_register()
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
                    $customer_record[$k] = ($k == 'date') ? strtotime($v) : $v;
                }
            }

            $customer_record['password'] = md5($customer_record['password']);

            $customer_id = $this->core_model->insert('customer', $customer_record);

            $this->session->set_userdata('customer_id', $customer_id);
            $this->session->set_userdata('customer_name', $customer_record['name']);

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

    public function ajax_reset_password()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $email = $this->input->post('email');

            $this->db->where('email', $email);
            $arr_customer = $this->core_model->get('customer');

            if (count($arr_customer) <= 0)
            {
                throw new Exception('Wrong Email!');
            }

            $customer = $arr_customer[0];
            $password = $this->cms_function->generate_random_number('sale', 8);

            $customer_record = array();
            $customer_record['password'] = md5($this->cms_function->generate_random_number('user', 8));

            $this->core_model->update('customer', $customer->id, $customer_record);

            // send email
            $this->load->library('email');

            $message = "Dear {$customer->name}\n\nYour Password has been reset..\n\nEmail: {$customer->email}\nPassword: {$password}\n\nPlease change your password immediately\n\nThank You";

            $this->email->from('no-reply@aidanandice.com', 'Aidan and Ice');
            $this->email->to($email);
            $this->email->bcc('sugianto@labelideas.co');
            $this->email->subject("[AIDAN AND ICE] Reset Password Notifications");
            $this->email->message($message);

            if ($this->input->post('email') && $this->input->post('email') != '')
            {
                @$this->email->send();
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

    public function ajax_send_appointment()
    {
        $json['status'] = 'success';

        try
        {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $day = $this->input->post('day');
            $month = $this->input->post('month');
            $year = $this->input->post('year');
            $time = $this->input->post('time');

            // send email
            $this->load->library('email');

            $this->email->from('no-reply@aidanandice.com', 'Aidan and Ice');
            $this->email->to($email);
            $this->email->bcc('sugianto@labelideas.co');
            $this->email->set_mailtype('html');

            $arr_content = array();
            $arr_content['name'] = $name;
            $arr_content['email'] = $email;
            $arr_content['phone'] = $name;
            $arr_content['day'] = $day;
            $arr_content['month'] = $month;
            $arr_content['year'] = $year;
            $arr_content['time'] = $time;
            $arr_content['setting'] = $this->_setting;
            $message = $this->load->view('email/book', $arr_content, true);

            $this->email->subject("[AIDAN AND ICE] Book an Appointment Notifications");
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

    public function ajax_set_currency($currency_id)
    {
        $json['status'] = 'success';

        try
        {
            // set cookie Currency
            // change expiration in expire = time() + {duration}
            $cookie = array(
                'name'   => 'aidan_curr',
                'value'  => $currency_id,
                'expire' => time() + 7200,
            );

            set_cookie($cookie);
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

    public function ajax_set_language($lang)
    {
        $json['status'] = 'success';

        try
        {
            // set cookie Language
            // change expiration in expire = time() + {duration}
            $cookie = array(
                'name'   => 'aidan_lang',
                'value'  => $lang,
                'expire' => time() + 7200,
            );

            set_cookie($cookie);
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

    public function ajax_subscribe()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            $email = $this->input->post('email');

            // count email
            $this->db->where('email', $email);
            $count_subscribe = $this->core_model->count('subscribe');

            if ($count_subscribe <= 0)
            {
                $subscribe_record = array();
                $subscribe_record['email'] = $email;
                $this->core_model->insert('subscribe');
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
    /* End Ajax Area */




    /* Private Function Area */
    /* End Private Function Area */
}
