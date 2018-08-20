<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
    private $_currency;
    private $_customer;
    private $_lang;
    private $_setting;
    private $_limit;

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

        $this->_limit = 12;
    }




    /* Public Function Area */
    public function index()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $arr_data['mobile'] = false;

        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent,0,4)))
        {
            $arr_data['mobile'] = true;
        }

        $header_id = 4;
        $page = 1;
        $sort = 'newest';

        // get alterego_id
        $arr_collection = $this->_get_collection();
        $alterego = '';
        $category = '';
        $look = '';
        $collection_id = 0;
        $color_id = 0;

        $choosen_collection = clone $arr_collection[0];
        $choosen_collection->name = 'All Collection';
        $search = '';

        $arr_data['title'] = 'Product';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_product'] = $this->_generate_product($page, $sort, $collection_id, array(), array(), array(), 0, '');
        $arr_data['count_page'] = $this->_count_product($sort, $collection_id, array(), array(), array(), 0, '');
        $arr_data['page'] = $page;
        $arr_data['sort'] = $sort;
        $arr_data['collection_id'] = $collection_id;
        $arr_data['category'] = $category;
        $arr_data['look'] = $look;
        $arr_data['alterego'] = $alterego;
        $arr_data['color_id'] = $color_id;
        $arr_data['arr_color'] = $this->_get_color();
        $arr_data['arr_category'] = $this->_get_category();
        $arr_data['arr_collection'] = $arr_collection;
        $arr_data['arr_alterego'] = $this->_get_alterego();
        $arr_data['choosen_collection'] = $choosen_collection;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $arr_data['arr_choosen_category'] = array();
        $arr_data['arr_choosen_look'] = array();
        $arr_data['arr_choosen_alterego'] = array();

        $this->load->view('product', $arr_data);
    }

    public function detail($url_name = '')
    {
        $header_id = 4;
        $now = time();

        if ($url_name == '')
        {
            redirect('404');
        }

        $this->db->where('url_name', $url_name);
        $this->db->where('status', 'Active');
        $arr_product = $this->core_model->get('product');

        if (count($arr_product) <= 0)
        {
            redirect('404');
        }

        $product = $arr_product[0];

        // get currency
        $currency = $this->core_model->get('currency', $this->_currency);

        $price = ceil($product->price / $currency->currency_exchange);
        $price = ceil($product->price / $currency->currency_exchange);
        $product->price_discount = 0;

        if ($product->discount_period_start <= $now && ($product->discount_period_end + 86400) >= $now)
        {
            $product->price_discount = ($product->discount > 0) ? ($price - ($product->discount / 100) * $price) : 0;
        }

        $product->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
        $product->price_discount_display = $currency->name . ' ' . number_format($product->price_discount, 0, ',', '.');
        $product->weight_display = number_format($product->weight, 2, ',', '.');

        $product->price = $price;
        $product->currency_name = $currency->name;
        $product->weight_display = number_format($product->weight, 2, ',', '.');

        // get product_color
        $this->db->where('product_id', $product->id);
        $arr_product_color = $this->core_model->get('product_color');

        $product->arr_product_color = $arr_product_color;

        # check inventory
        $this->db->where('product_id', $product->id);
        $this->db->where('location_id', '1');
        $arr_inventory = $this->core_model->get('inventory');

        $product->inventory = (count($arr_inventory) > 0) ? $arr_inventory[0]->quantity : 0;

        $product->image_name = '';
        $product->image_hover_name = '';
        $arr_slider_image = array();

        $this->db->where('product_id', $product->id);
        $arr_image = $this->core_model->get('image');

        foreach ($arr_image as $image)
        {
            if ($image->type == '')
            {
                $product->image_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
            elseif ($image->type == 'hover')
            {
                $product->image_hover_name = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
            else
            {
                $arr_slider_image[] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        $product->arr_slider_image = $arr_slider_image;

        // get product_color
        $this->db->where('product_id', $product->id);
        $arr_product_color = $this->core_model->get('product_color');
        $arr_color_id = $this->cms_function->extract_records($arr_product_color, 'color_id');

        $arr_color = $this->core_model->get('color', $arr_color_id);

        // get related product
        $this->db->where('id !=', $product->id);
        $this->db->where('alterego_id', $product->alterego_id);
        $this->db->limit(8);
        $arr_related_product = $this->core_model->get('product');
        $arr_related_product_id = $this->cms_function->extract_records($arr_related_product, 'id');

        $arr_related_product_image = array();

        if (count($arr_related_product_id) > 0)
        {
            $this->db->where_in('product_id', $arr_related_product_id);
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_related_product_image[$image->product_id][$image->type] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_related_product as $related_product)
        {
            $related_product->image_name = (isset($arr_related_product_image[$related_product->id][''])) ? $arr_related_product_image[$related_product->id][''] : '';
            $related_product->image_hover_name = (isset($arr_related_product_image[$related_product->id]['hover'])) ? $arr_related_product_image[$related_product->id]['hover'] : '';

            $price = ceil($related_product->price / $currency->currency_exchange);
            $related_product->price_discount = ($related_product->discount > 0) ? ($price - ($related_product->discount / 100) * $price) : 0;

            $related_product->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
            $related_product->price_discount_display = $currency->name . ' ' . number_format($related_product->price_discount, 0, ',', '.');
        }

        // get metatag
        $metatag = $this->cms_function->generate_metatag($header_id);
        $metatag->name = ($product->metatag_title != '') ? $product->metatag_title : $metatag->name;
        $metatag->keywords = ($product->metatag_keywords != '') ? $product->metatag_keywords : $metatag->keywords;
        $metatag->author = ($product->metatag_author != '') ? $product->metatag_author : $metatag->author ;
        $metatag->description = ($product->metatag_description != '') ? $product->metatag_description : $metatag->description;

        $arr_data['title'] = 'Product Detail';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $metatag;
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['product'] = $product;
        $arr_data['arr_color'] = $arr_color;
        $arr_data['arr_related_product'] = $arr_related_product;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $this->load->view('product-detail', $arr_data);
    }

    public function filter($page = 1, $sort = 'newest', $collection_id = 0, $category = 0, $look = 0, $alterego = 0, $color_id = 0, $search = 0)
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $arr_data['mobile'] = false;

        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent,0,4)))
        {
            $arr_data['mobile'] = true;
        }

        $search = ($search != '0') ? urldecode($search) : '';

        $header_id = 4;
        $arr_collection = $this->_get_collection();

        $category = ($category == 0) ? '' : $category;
        $look = ($look == 0) ? '' : $look;
        $alterego = ($alterego == 0) ? '' : $alterego;
        $color_id = 0;

        $arr_choosen_category = explode('-', $category);
        $arr_choosen_look = explode('-', $look);
        $arr_choosen_alterego = explode('-', $alterego);

        foreach ($arr_choosen_category as $key => $choosen_category)
        {
            if ($choosen_category == '')
            {
                unset($arr_choosen_category[$key]);
            }
        }

        foreach ($arr_choosen_look as $key => $choosen_look)
        {
            if ($choosen_look == '')
            {
                unset($arr_choosen_look[$key]);
            }
        }

        foreach ($arr_choosen_alterego as $key => $choosen_alterego)
        {
            if ($choosen_alterego == '')
            {
                unset($arr_choosen_alterego[$key]);
            }
        }

        foreach ($arr_collection as $collection)
        {
            if ($collection->id == $collection_id)
            {
                $choosen_collection = clone $collection;
            }
        }

        if ($collection_id <= 0)
        {
            $choosen_collection = clone $arr_collection[0];
            $choosen_collection->name = 'All Collection';
        }

        $arr_data['title'] = 'Product';
        $arr_data['setting'] = $this->_setting;
        $arr_data['csrf'] = $this->cms_function->generate_csrf();
        $arr_data['arr_header'] = $this->cms_function->generate_header();
        $arr_data['metatag'] = $this->cms_function->generate_metatag($header_id);
        $arr_data['customer'] = $this->_customer;
        $arr_data['lang'] = $this->_lang;
        $arr_data['curr'] = $this->_currency;
        $arr_data['arr_currency'] = $this->cms_function->get_currency();
        $arr_data['last_cart'] = $this->cms_function->generate_cart();
        $arr_data['arr_product'] = $this->_generate_product($page, $sort, $collection_id, $arr_choosen_category, $arr_choosen_look, $arr_choosen_alterego, $color_id, $search);
        $arr_data['count_page'] = $this->_count_product($sort, $collection_id, $arr_choosen_category, $arr_choosen_look, $arr_choosen_alterego, $color_id, $search);
        $arr_data['page'] = $page;
        $arr_data['sort'] = $sort;
        $arr_data['collection_id'] = $collection_id;
        $arr_data['category'] = ($category == '') ? 0 : $category;
        $arr_data['look'] = ($look == '') ? 0 : $look;
        $arr_data['alterego'] = ($alterego == '') ? 0 : $alterego;
        $arr_data['color_id'] = $color_id;
        $arr_data['arr_color'] = $this->_get_color();
        $arr_data['arr_category'] = $this->_get_category();
        $arr_data['arr_collection'] = $this->_get_collection();
        $arr_data['arr_alterego'] = $this->_get_alterego();
        $arr_data['choosen_collection'] = $choosen_collection;
        $arr_data['arr_navbar_menu'] = $this->cms_function->generate_navbar_menu();

        $arr_data['arr_choosen_category'] = $arr_choosen_category;
        $arr_data['arr_choosen_look'] = $arr_choosen_look;
        $arr_data['arr_choosen_alterego'] = $arr_choosen_alterego;

        $this->load->view('product', $arr_data);
    }
    /* End Public Function Area */




    /* Ajax Area */
    public function ajax_add_wishlist($product_id)
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            if ($product_id <= 0)
            {
                throw new Exception();
            }

            $product = $this->core_model->get('product', $product_id);
            $product->image_name = '';

            $this->db->where('product_id', $product->id);
            $arr_image = $this->core_model->get('image');

            if (count($arr_image) > 0)
            {
                $product->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
            }

            // check customer & product in wishlist
            $this->db->where('customer_id', $this->_customer->id);
            $this->db->where('product_id', $product_id);
            $count_wishlist = $this->core_model->count('wishlist');

            if ($count_wishlist <= 0)
            {
                if ($product->status != 'Active')
                {
                    throw new Exception();
                }

                $wishlist_record = array();
                $wishlist_record['customer_id'] = $this->_customer->id;
                $wishlist_record['customer_type'] = $this->_customer->type;
                $wishlist_record['customer_number'] = $this->_customer->number;
                $wishlist_record['customer_name'] = $this->_customer->name;
                $wishlist_record['customer_date'] = $this->_customer->date;
                $wishlist_record['customer_status'] = $this->_customer->status;

                $wishlist_record['product_id'] = $product_id;
                $wishlist_record['product_type'] = $product->type;
                $wishlist_record['product_number'] = $product->number;
                $wishlist_record['product_name'] = $product->name;
                $wishlist_record['product_date'] = $product->date;
                $wishlist_record['product_status'] = $product->status;
                $wishlist_id = $this->core_model->insert('wishlist', $wishlist_record);

                // send email
                $this->load->library('email');

                $this->email->from('no-reply@aidanandice.com', 'Aidan and Ice');
                $this->email->to($this->_customer->email);
                $this->email->bcc('sugianto@labelideas.co');
                $this->email->set_mailtype('html');

                $arr_content = array();
                $arr_content['product'] = $product;
                $arr_content['setting'] = $this->_setting;
                $message = $this->load->view('email/wishlist', $arr_content, true);

                $this->email->subject("[AIDAN AND ICE] Wishlist Notification");
                $this->email->message($message);

                if ($this->_customer && $this->_customer->email != '')
                {
                    @$this->email->send();
                }
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

    public function ajax_add_to_cart()
    {
        $json['status'] = 'success';

        try
        {
            $this->db->trans_start();

            // get currency
            $currency = $this->core_model->get('currency', $this->_currency);

            $product_id = $this->input->post('product_id');
            $quantity = $this->input->post('quantity');
            $arr_cart = array();

            // get old session cart
            $old_session_cart = ($this->session->userdata('session_cart')) ? $this->session->userdata('session_cart') : '';

            $arr_old_cart = ($old_session_cart != '') ? json_decode($old_session_cart) : array();
            $found = 0;

            foreach ($arr_old_cart as $key => $old_cart)
            {
                if ($old_cart->product_id == $product_id)
                {
                    continue;
                }

                $arr_cart[] = clone $old_cart;
            }

            $cart = new stdClass();
            $cart->product_id = $product_id;
            $cart->quantity = $quantity;
            $cart->voucher_id = 0;
            $cart->type = '';
            $cart->name = '';
            $cart->email = '';
            $cart->message = '';

            $arr_cart[] = clone $cart;;

            $session_cart = json_encode($arr_cart);
            $this->session->set_userdata('session_cart', $session_cart);

            $product = $this->core_model->get('product', $product_id);
            $now = time();

            if ($product->discount_period_start > 0 && $product->discount_period_end > 0)
            {
                if ($product->discount_period_start <= $now && ($product->discount_period_end + 86400) >= $now)
                {
                    $product->price = ($product->discount > 0) ? ($product->price - ($product->discount / 100) * $product->price) : 0;
                }
            }

            $price = ceil($product->price / $currency->currency_exchange);
            $total = $price * $quantity;

            $product->price_display = $currency->name . ' ' . number_format($price, 0, ',', '.');
            $product->weight_display = number_format($product->weight, 2, ',', '.');
            $product->total_display = $currency->name . ' ' . number_format($total, 0, ',', '.');
            $product->quantity = $quantity;
            $product->image_name = '';

            $this->db->where('product_id', $product_id);
            $arr_image = $this->core_model->get('image');

            if (count($arr_image) > 0)
            {
                $product->image_name = ($arr_image[0]->name != '') ? $arr_image[0]->name : $arr_image[0]->id . '.' . $arr_image[0]->ext;
            }

            $json['product'] = $product;

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
    private function _count_product($sort, $collection_id, $arr_choosen_category_id, $arr_choosen_look_id, $arr_choosen_alterego_id, $color_id, $search)
    {
        $arr_product_id = array();

        # check category
        if (count($arr_choosen_category_id) > 0)
        {
            $this->db->where_in('category_id', $arr_choosen_category_id);
            $arr_product_category = $this->core_model->get('product_category');

            foreach ($arr_product_category as $product_category)
            {
                if (isset($arr_product_id[$product_category->product_id]))
                {
                    continue;
                }

                $arr_product_id[$product_category->product_id] = $product_category->product_id;
            }
        }

        # check looks
        if (count($arr_choosen_look_id) > 0)
        {
            $this->db->where_in('category_id', $arr_choosen_look_id);
            $arr_product_category = $this->core_model->get('product_category');

            foreach ($arr_product_category as $product_category)
            {
                if (isset($arr_product_id[$product_category->product_id]))
                {
                    continue;
                }

                $arr_product_id[$product_category->product_id] = $product_category->product_id;
            }
        }

        # check color
        if ($color_id > 0)
        {
            $this->db->where('color_id', $color_id);
            $arr_product_color = $this->core_model->get('product_color');

            foreach ($arr_product_color as $product_color)
            {
                if (isset($arr_product_id[$product_color->product_id]))
                {
                    continue;
                }

                $arr_product_id[$product_color->product_id] = $product_color->product_id;
            }
        }

        $arr_product_id = array_values($arr_product_id);

        if (count($arr_product_id) > 0)
        {
            $this->db->where_in('id', $arr_product_id);
        }

        if (count($arr_choosen_alterego_id) > 0)
        {
            $this->db->where_in('alterego_id', $arr_choosen_alterego_id);
        }

       	if ($collection_id > 0)
        {
        	$this->db->where('collection_id', $collection_id);
        }

        if ($search != '')
        {
            $this->db->like('name', $search);
        }

        $count_product = $this->core_model->count('product');

        if (count($arr_choosen_category_id) > 0 || count($arr_choosen_look_id) > 0 || $color_id > 0)
        {
            if (count($arr_product_id) <= 0)
            {
                $count_product = 0;
            }
        }

        return ceil($count_product / $this->_limit);
    }

    private function _generate_product($page, $sort, $collection_id, $arr_choosen_category_id, $arr_choosen_look_id, $arr_choosen_alterego_id, $color_id, $search)
    {
        // get currency
        $currency = $this->core_model->get('currency', $this->_currency);

        $arr_product_id = array();
        $arr_product = array();

        # check category
        if (count($arr_choosen_category_id) > 0)
        {
            $this->db->where_in('category_id', $arr_choosen_category_id);
            $arr_product_category = $this->core_model->get('product_category');

            foreach ($arr_product_category as $product_category)
            {
                if (isset($arr_product_id[$product_category->product_id]))
                {
                    continue;
                }

                $arr_product_id[$product_category->product_id] = $product_category->product_id;
            }
        }

        # check looks
        if (count($arr_choosen_look_id) > 0)
        {
            $this->db->where_in('category_id', $arr_choosen_look_id);
            $arr_product_category = $this->core_model->get('product_category');

            foreach ($arr_product_category as $product_category)
            {
                if (isset($arr_product_id[$product_category->product_id]))
                {
                    continue;
                }

                $arr_product_id[$product_category->product_id] = $product_category->product_id;
            }
        }

        # check color
        if ($color_id > 0)
        {
            $this->db->where('color_id', $color_id);
            $arr_product_color = $this->core_model->get('product_color');

            foreach ($arr_product_color as $product_color)
            {
                if (isset($arr_product_id[$product_color->product_id]))
                {
                    continue;
                }

                $arr_product_id[$product_color->product_id] = $product_color->product_id;
            }
        }

        $arr_product_id = array_values($arr_product_id);

        if (count($arr_choosen_alterego_id) > 0)
        {
            $this->db->where_in('alterego_id', $arr_choosen_alterego_id);
        }

        if ($collection_id > 0)
        {
            $this->db->where('collection_id', $collection_id);
        }

        if ($search != '')
        {
            $this->db->like('name', $search);
        }

        $this->db->where('status', 'Active');

        if ($sort == 'newest')
        {
            $this->db->order_by('id DESC');
        }
        elseif ($sort == 'price-desc')
        {
            $this->db->order_by('price DESC');
        }
        elseif ($sort == 'price-asc')
        {
            $this->db->order_by('price');
        }
        else
        {
            $this->db->order_by('price');
        }

        $this->db->limit($this->_limit, ($page - 1) * $this->_limit);

        if (count($arr_choosen_category_id) > 0 || count($arr_choosen_look_id) > 0 || $color_id > 0)
        {
            if (count($arr_product_id) > 0)
            {
                $arr_product = $this->core_model->get('product', $arr_product_id);
            }
            else
            {
                $arr_product = $this->core_model->get('product');
                $arr_product = array();
            }
        }
        else
        {
            $arr_product = $this->core_model->get('product');
        }

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
                if ($product->discount_period_start <= $now && ($product->discount_period_end + 86400) >= $now)
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

    private function _get_alterego()
    {
        $this->db->order_by('name');
        $arr_alterego = $this->core_model->get('alterego');
        $arr_alterego_id = $this->cms_function->extract_records($arr_alterego, 'id');

        $arr_image_lookup = array();

        if (count($arr_alterego_id) > 0)
        {
            $this->db->where_in('alterego_id', $arr_alterego_id);
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_image_lookup[$image->alterego_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_alterego as $alterego)
        {
            $alterego->image_name = (isset($arr_image_lookup[$alterego->id])) ? $arr_image_lookup[$alterego->id] : '';
        }

        return $arr_alterego;
    }

    private function _get_category()
    {
        $this->db->order_by('name');
        return $this->core_model->get('category');
    }

    private function _get_collection()
    {
        $this->db->order_by('name');
        $arr_collection = $this->core_model->get('collection');
        $arr_collection_id = $this->cms_function->extract_records($arr_collection, 'id');

        $arr_image_lookup = array();

        if (count($arr_collection_id) > 0)
        {
            $this->db->where_in('collection_id', $arr_collection_id);
            $arr_image = $this->core_model->get('image');

            foreach ($arr_image as $image)
            {
                $arr_image_lookup[$image->collection_id] = ($image->name != '') ? $image->name : $image->id . '.' . $image->ext;
            }
        }

        foreach ($arr_collection as $collection)
        {
            $collection->image_name = (isset($arr_image_lookup[$collection->id])) ? $arr_image_lookup[$collection->id] : '';
        }

        return $arr_collection;
    }

    private function _get_color()
    {
        $this->db->order_by('name');
        return $this->core_model->get('color');
    }
    /* End Private Function Area */
}
