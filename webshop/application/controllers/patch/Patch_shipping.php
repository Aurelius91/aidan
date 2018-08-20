<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patch_shipping extends CI_Controller
{
	private $_setting;

	public function __construct()
	{
		parent:: __construct();

		$this->_setting = $this->setting_model->load();
	}




	public function generate()
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			$this->db->where('province_id', 10);
			$this->db->where('name', 'REGULER');
			$arr_shipping = $this->core_model->get('shipping');

			foreach ($arr_shipping as $shipping)
			{
				$shipping_record = array();
				$shipping_record['city_id'] = $shipping->city_id;
				$shipping_record['district_id'] = $shipping->district_id;
				$shipping_record['province_id'] = $shipping->province_id;

				$shipping_record['name'] = 'One Day Service';
				$shipping_record['type'] = 'GOJEK / GRAB';
				$shipping_record['price'] = '25000';
				$shipping_record['etd'] = '1';

				$shipping_record['city_type'] = $shipping->city_type;
				$shipping_record['city_number'] = $shipping->city_number;
				$shipping_record['city_name'] = $shipping->city_name;
				$shipping_record['city_date'] = $shipping->city_date;
				$shipping_record['city_status'] = $shipping->city_status;

				$shipping_record['district_type'] = $shipping->district_type;
				$shipping_record['district_number'] = $shipping->district_number;
				$shipping_record['district_name'] = $shipping->district_name;
				$shipping_record['district_date'] = $shipping->district_date;
				$shipping_record['district_status'] = $shipping->district_status;

				$shipping_record['province_type'] = $shipping->province_type;
				$shipping_record['province_number'] = $shipping->province_number;
				$shipping_record['province_name'] = $shipping->province_name;
				$shipping_record['province_date'] = $shipping->province_date;
				$shipping_record['province_status'] = $shipping->province_status;
				$this->core_model->insert('shipping', $shipping_record);
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

	public function generate_country()
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			$this->db->where('id !=', 233);
			$arr_country = $this->core_model->get('country');

			foreach ($arr_country as $country)
			{
				$shipping_record = array();
				$shipping_record['country_id'] = $country->id;

				$shipping_record['name'] = 'JNE INTERNATIONAL';
				$shipping_record['type'] = 'INT Shipping';
				$shipping_record['price'] = $country->price;
				$shipping_record['etd'] = $country->etd;

				$shipping_record['country_type'] = $country->type;
				$shipping_record['country_number'] = $country->number;
				$shipping_record['country_name'] = $country->name;
				$shipping_record['country_date'] = $country->date;
				$shipping_record['country_status'] = $country->status;
				$this->core_model->insert('shipping', $shipping_record);
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
}