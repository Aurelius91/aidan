<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller
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
    public function query($name = '')
    {
        $header_id = 10;

        $arr_result = array();
        $arr_result['product'] = array();
        $arr_result['other']['muse'] = array();
        $arr_result['other']['media'] = array();
        $arr_result['other']['events'] = array();

        if ($name != '')
        {
            $name = urldecode($name);

            // get product
            $arr_product = $this->_generate_product($name);
            $arr_result['product'] = $arr_product;

            // get muse
            $this->db->like('name', $name);
            $this->db->or_like('subtitle', $name);
            $this->db->or_like('short_description', $name);
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

            $arr_result['other']['muse'] = $arr_muse;

            // get events
            $this->db->like('name', $name);
            $this->db->or_like('subtitle', $name);
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

            $arr_result['other']['events'] = $arr_events;

            // get media
            $this->db->like('name', $name);
            $this->db->or_like('subtitle', $name);
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

            $arr_result['other']['media'] = $arr_media;
        }

        $arr_data['title'] = 'Search';
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
        $arr_data['arr_result'] = $arr_result;

        $this->load->view('search', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    /* End Ajax Area */




    /* Private Function Area */
    private function _generate_product($search)
    {
        // get currency
        $currency = $this->core_model->get('currency', $this->_currency);

        if ($search != '')
        {
            $this->db->like('name', $search);
        }

        $this->db->where('status', 'Active');
        $this->db->order_by('name');
        $arr_product = $this->core_model->get('product');
        $arr_product_id = $this->cms_function->extract_records($arr_product, 'id');

        $arr_image_lookup = array();

        if (count($arr_product_id) > 0)
        {
            $this->db->where_in('product_id', $arr_product_id);
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_image_lookup[$image->product_id][$image->type] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        $now = time();

        foreach ($arr_product as $product)
        {
            $product->image_name = (isset($arr_image_lookup[$product->id][''])) ? $arr_image_lookup[$product->id][''] : '';
            $product->image_hover_name = (isset($arr_image_lookup[$product->id]['hover'])) ? $arr_image_lookup[$product->id]['hover'] : '';

            $price = ceil($product->price / $currency->currency_exchange);
            $product->price_discount = 0;

            if ($product->discount_period_start > 0 && $product->discount_period_end > 0)
            {
                if ($product->discount_period_start <= $now && $product->discount_period_end >= $now)
                {
                    $product->price_discount = ($product->discount > 0) ? ($price - ($product->discount / 100) * $price) : 0;
                }
            }

            $product->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
            $product->price_discount_display = $currency->name . ' ' . number_format($product->price_discount, 0, ',', '.');
            $product->weight_display = number_format($product->weight, 2, ',', '.');
        }

        return $arr_product;
    }
    /* End Private Function Area */
}
