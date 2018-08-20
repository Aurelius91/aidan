<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Midtrans extends CI_Controller
{
	private $_setting;

	public function __construct()
	{
		parent:: __construct();

		$this->_setting = $this->setting_model->load();
	}




	public function ajax_update_payment()
	{
		$json['status'] = 'success';

		try
		{
			$this->db->trans_start();

			$json_result = file_get_contents('php://input');
            $result_fix = json_decode($json_result);

            $sale_record = array();

            if ($result_fix->transaction_status == 'capture')
            {
                if ($result_fix->payment_type == 'credit_card')
                {
                    if ($result_fix->fraud_status == 'challenge')
                    {
                        $sale_record['status'] = 'Challenge by FDS';
                    }
                    else
                    {
                        $sale_record['status'] = 'CC Accepted';
                    }
                }
            }
            else
            {
                $sale_record['status'] = $result_fix->transaction_status;
            }

            $this->cms_function->update_foreign_field(array('transaction', 'voucher_code', 'sale_item'), $sale_record, 'sale');

            $this->db->where('number', $result_fix->order_id);
            $this->core_model->update('sale', 0, $sale_record);

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