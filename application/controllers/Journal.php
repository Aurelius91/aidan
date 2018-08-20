<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Journal extends CI_Controller
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
        $this->muse();
    }

    public function events()
    {
        $header_id = 8;

        // get all events
        $today = time();

        $this->db->where('date <', $today);
        $arr_events = $this->core_model->get('events');
        $arr_events_id = $this->cms_function->extract_records($arr_events, 'id');

        $arr_image_lookup = array();

        if (count($arr_events_id) > 0)
        {
            $this->db->where_in('events_id', $arr_events_id);
            $this->db->where('type', '');
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                if ($image->type != '')
                {
                    continue;
                }

                $arr_image_lookup[$image->events_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_events as $events)
        {
            $events->image_name = (isset($arr_image_lookup[$events->id])) ? $arr_image_lookup[$events->id] : '';
            $events->date_display = date('d F Y', $events->date);
        }

        $arr_data['title'] = 'Events';
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
        $arr_data['arr_events'] = $arr_events;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('journal-events', $arr_data);
    }

    public function media($this_year = '')
    {
        $header_id = 7;

        $arr_year_lookup = array();

        // get all media
        if ($this_year != '')
        {
            $next_year = $this_year + 1;
            $first_day = '01-01-' . $next_year;
            $first_day = strtotime($first_day);

            $this->db->where('date <', $first_day);
        }

        $this->db->order_by('date DESC, id');
        $arr_media = $this->core_model->get('media');
        $arr_media_id = $this->cms_function->extract_records($arr_media, 'id');

        $arr_image_lookup = array();

        if (count($arr_media_id) > 0)
        {
            $this->db->where_in('media_id', $arr_media_id);
            $this->db->where('type', '');
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                if ($image->type != '')
                {
                    continue;
                }

                $arr_image_lookup[$image->media_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_media as $media)
        {
            $media->image_name = (isset($arr_image_lookup[$media->id])) ? $arr_image_lookup[$media->id] : '';
        }

        // get all media
        $this->core_model->get('media');
        $arr_all_media = $this->core_model->get('media');

        foreach ($arr_all_media as $all_media)
        {
            $all_media->year = date('Y', $all_media->date);

            if (isset($arr_year_lookup[$all_media->year]))
            {
                continue;
            }

            $arr_year_lookup[$all_media->year] = $all_media->year;
        }

        $arr_year = array_values($arr_year_lookup);

        $arr_data['title'] = 'Media';
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
        $arr_data['this_year'] = $this_year;
        $arr_data['arr_year'] = $arr_year;
        $arr_data['arr_media'] = $arr_media;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('journal-media', $arr_data);
    }

    public function muse($this_year = '')
    {
        $header_id = 6;

        $arr_year_lookup = array();

        // get all muse
        if ($this_year != '')
        {
            $next_year = $this_year + 1;
            $first_day = '01-01-' . $next_year;
            $first_day = strtotime($first_day);

            $this->db->where('date <', $first_day);
        }

        $this->db->order_by('date DESC, id');
        $arr_muse = $this->core_model->get('muse');
        $arr_muse_id = $this->cms_function->extract_records($arr_muse, 'id');

        $arr_image_lookup = array();

        if (count($arr_muse_id) > 0)
        {
            $this->db->where_in('muse_id', $arr_muse_id);
            $this->db->where('type', 'cover');
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_image_lookup[$image->muse_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_muse as $muse)
        {
            $muse->image_name = (isset($arr_image_lookup[$muse->id])) ? $arr_image_lookup[$muse->id] : '';
        }

        // get all muse
        $this->core_model->get('muse');
        $arr_all_muse = $this->core_model->get('muse');

        foreach ($arr_all_muse as $all_muse)
        {
            $all_muse->year = date('Y', $all_muse->date);

            if (isset($arr_year_lookup[$all_muse->year]))
            {
                continue;
            }

            $arr_year_lookup[$all_muse->year] = $all_muse->year;
        }

        $arr_year = array_values($arr_year_lookup);

        $arr_data['title'] = 'Muse';
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
        $arr_data['this_year'] = $this_year;
        $arr_data['arr_year'] = $arr_year;
        $arr_data['arr_muse'] = $arr_muse;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('journal-muse', $arr_data);
    }

    public function muse_detail($url_name = '')
    {
        $header_id = 6;

        if ($url_name == '')
        {
            redirect(base_url() . 'journal/muse/');
        }

        $this->db->where('url_name', $url_name);
        $arr_muse = $this->core_model->get('muse');

        if (count($arr_muse) <= 0)
        {
            redirect(base_url() . 'journal/muse/');
        }

        $muse = $arr_muse[0];
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
            $image->image_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;

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
        $this->db->where('muse_id', $muse->id);
        $arr_muse_product = $this->core_model->get('muse_product');
        $arr_product_id = $this->cms_function->extract_records($arr_muse_product, 'product_id');

        $arr_product = $this->core_model->get('product', $arr_product_id);
        $arr_product_image_lookup = array();

        if (count($arr_product_id) > 0)
        {
            $this->db->where_in('product_id', $arr_product_id);
            $this->db->where('type', '');
            $arr_product_image = $this->core_model->get('image');

            foreach ($arr_product_image as $product_image)
            {
                $arr_product_image_lookup[$product_image->product_id] = ($product_image->name != '') ? $product_image->name : $product_image->id . '.' . $product_image->ext;
            }
        }

        foreach ($arr_product as $product)
        {
            $product->image_name = (isset($arr_product_image_lookup[$product->id])) ? $arr_product_image_lookup[$product->id] : '';
        }

        $muse->arr_product = $arr_product;

        // get metatag
        $metatag = $this->cms_function->generate_metatag($header_id);
        $metatag->name = ($muse->metatag_title != '') ? $muse->metatag_title : $metatag->name;
        $metatag->keywords = ($muse->metatag_keywords != '') ? $muse->metatag_keywords : $metatag->keywords;
        $metatag->author = ($muse->metatag_author != '') ? $muse->metatag_author : $metatag->author ;
        $metatag->description = ($muse->metatag_description != '') ? $muse->metatag_description : $metatag->description;

        $arr_data['title'] = 'Muse Detail';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $metatag;
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['muse'] = $muse;
        $arr_data['arr_image'] = $arr_image;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('journal-muse-detail-' . $muse->type, $arr_data);
    }

    public function muse_detail_1()
    {
        $header_id = 6;

        $arr_data['title'] = 'Muse Detail';
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

        $this->load->view('journal-muse-detail-1', $arr_data);
    }

    public function muse_detail_2()
    {
        $header_id = 6;

        $arr_data['title'] = 'Muse Detail';
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

        $this->load->view('journal-muse-detail-2', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    public function ajax_get_events($events_id)
    {
        $json['status'] = 'success';

        try
        {
            $events = $this->core_model->get('events', $events_id);
            $events->date_display = date('d F Y', $events->date);

            $this->db->where('events_id', $events->id);
            $this->db->where('type !=', '');
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $image->image_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }

            $json['events'] = $events;
            $json['arr_slider_image'] = $arr_image;
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

    public function ajax_get_media($media_id)
    {
        $json['status'] = 'success';

        try
        {
            $media = $this->core_model->get('media', $media_id);

            $this->db->where('media_id', $media->id);
            $this->db->where('type !=', '');
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $image->image_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }

            // get all product
            $this->db->select('product_id');
            $this->db->where('media_id', $media_id);
            $arr_media_product = $this->core_model->get('media_product');
            $arr_product_id = $this->cms_function->extract_records($arr_media_product, 'product_id');

            $this->db->where('status', 'Active');
            $arr_product = $this->core_model->get('product', $arr_product_id);

            $arr_product_image_lookup = array();

            // get product image
            if (count($arr_product_id) > 0)
            {
                $this->db->where_in('product_id', $arr_product_id);
                $arr_product_image = $this->core_model->get('image');

                foreach ($arr_product_image as $product_image)
                {
                    $arr_product_image_lookup[$product_image->product_id] = ($product_image->name != '') ? $product_image->name : $product_image->id . '.' . $product_image->ext;
                }
            }

            foreach ($arr_product as $product)
            {
                $product->image_name = (isset($arr_product_image_lookup[$product->id])) ? $arr_product_image_lookup[$product->id] : '';
            }

            $json['media'] = $media;
            $json['arr_slider_image'] = $arr_image;
            $json['arr_product'] = $arr_product;
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
