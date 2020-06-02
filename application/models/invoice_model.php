<?php

class invoice_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function get_invoice_details($invoice_id,$ware)
	{
		 /*$this->db->query("SELECT tbl_invoice . * , bill_generate . * , SUM( bill_generate.amount ) AS generated_total
			FROM `bill_generate`
			INNER JOIN tbl_invoice ON bill_generate.tenant_id = tbl_invoice.tenant_id
			WHERE tbl_invoice.invoice_id = $invoice_id
			AND tbl_invoice.ware_id =$ware
                  
                    GROUP BY bill_generate.tenant_id")->row();*/
    	return $this->db->select('*')->from('tbl_invoice')->where('ware_id',$ware)->where('invoice_id',$invoice_id)->get()->row();
	}
	public function get_transaction_details($invoice_id,$ware)
	{
		return $this->db->select('*')->from('tbl_transaction')->where('ware_id',$ware)->where('invoice_id',$invoice_id)->get()->result();
	}

	public function getAccHeadById($head_id)
	{
		return $this->db->select('*')->from('account_head')->where('id',$head_id)->get()->row();
	}


	public function processing_edit_payment()
	{
		$invoice_id = $this->input->post('invoice_id');
		$invoice = $this->db->select('*')->from('tbl_invoice')->where('invoice_id',$invoice_id)->get()->row();
		$transaction = $this->db
							->select('*')->from('tbl_transaction')
							->where('invoice_id',$invoice_id)
							->where('tenant_id',$invoice->tenant_id)
							->where('flat_id',$invoice->flat_id)
							->where('month',$invoice->month)
							->where('ware_id',$this->session->userdata('wire'))
							->get()->result_array();

		$response["posts"] = array();
		foreach ($transaction as $val) {
                $post = array();

                $post["amount"] = $val["amount"];
                $post["building_id"] = $val["building_id"];
                $post["credit"] = $val["credit"];
                
                $post["date"] = $val["date"];
                $post["debit"] = $val["debit"];
                $post["flat_id"] = $val["flat_id"];
                $post["invoice_id"] = $val["invoice_id"];
                $post["month"] = $val["month"];
                $post["tenant_id"] = $val["tenant_id"];
                $post["transaction_id"] = $val["transaction_id"];
                $post["ware_id"] = $val["ware_id"];
                $post["payment_type"] = $val["payment_type"];

                if ($val["payment_type"]==2) {//get acc head name if it is credit payment or debit payment
                	$post["headName"] = $this->getAccHeadById($val["credit"])->name;
                }elseif($val["payment_type"]==1){
                	$post["headName"] = $this->getAccHeadById($val["debit"])->name;
                }
                array_push($response["posts"], $post);

            }
            return $response["posts"];
	}

	public function update_invoice()
	{
		$dynamicData 	= $this->input->post('dynamicData');//here get all values where input 	= text
		$staticData		= $this->input->post('staticData');//here get all values where 	input 	= hidden
		//return $dynamicData;
        
        $tenant_id 		= $staticData['tenant_id'];
        $flat_id 		= $staticData['flat_id'];
        $building_id 	= $staticData['building_id'];
        $month 			= $staticData['month'];
        $gross_amount 	= $staticData['total'];
        $payment_date 	= $staticData['date'];
        $remarks 		= $staticData['remarks'];
        $invoice_id 	= $staticData['invoice_id'];

        $invoice 		= $this->findInvoiceById($invoice_id); //return $invoiceNo;
        $data = [
            'gross_amount'  => $gross_amount,
            'remarks'       => $remarks
        ];
        if (isset($invoice->invoice_id)) {
        	 $this->db->where('invoice_id',$invoice->invoice_id)->update('tbl_invoice',$data);
        }
        //return $data;
       foreach ($dynamicData as $temp) 
       {
       		$transaction = $this->findTransactionById($temp[0]);
       		
       		$transactionData['amount']			= $temp[2];
       		if (isset($transaction->transaction_id)) {
       			$this->db->where('transaction_id',$transaction->transaction_id)->update('tbl_transaction',$transactionData);
       		}
       		//return $transactionData;
       }
       return "Updated successfully";
	}

	public function findInvoiceById($id)
	{
		return $this->db->select('*')->from('tbl_invoice')->where('invoice_id',$id)->get()->row();
	}
	public function findTransactionById($id)
	{
		return $this->db->select('*')->from('tbl_transaction')->where('transaction_id',$id)->get()->row();
	}


	public function delete_invoice()
	{
		$invoice_id = $this->input->post('invoice_id');
		$data = [
			'status' => 0
		];
		return $this->db->where('invoice_id',$invoice_id)->update('tbl_invoice',$data);
	}




	public function processing_take_payment()
	{
		$invoice_id = $this->input->post('invoice_id');

		$invoice = $this->db->select('*')->from('tbl_invoice')->where('invoice_id',$invoice_id)->get()->row();
    	//return $invoice->month;
		$tenant_id = $invoice->tenant_id;
		$flat_id = $invoice->flat_id;
		$generatedBill = $this->db
		->select('bill_generate.*,account_head.*')
		->select('bill_generate.amount AS billAmount')
		->select('account_head.amount AS accuntAmount')
		->from('bill_generate')
		->join('account_head', 'account_head.id=bill_generate.accounts_id')
		->where('bill_generate.tenant_id',$invoice->tenant_id)
		->where('bill_generate.flat_id',$invoice->flat_id)
		->where('bill_generate.month',$invoice->month)
		->get()->result();
    	//return $generatedBill;
		$transaction = $this->db
		->select('*')->from('tbl_transaction')
		->where('tenant_id',$invoice->tenant_id)
		->where('flat_id',$invoice->flat_id)
		->where('month',$invoice->month)
		->where('ware_id',$this->session->userdata('wire'))
		->get()->result();
		$data=[
			'inVoice'		=> $invoice,
			'generatedBill'	=> $generatedBill,
			'transAction'	=> $transaction
		];
		return $data;
	}

	public function take_payment()
	{
		
		//print_r($this->input->post());
		$acc['heads'] 	= $this->payment_model->getAccHead();
		$tenant_id 		= $this->input->post('tenant_id');
		$flat_id		= $this->input->post('flat_id');
		$building_id 	= $this->input->post('building_id');
		$month			= $this->input->post('month');
		$payment_date   = $this->input->post('payment_date');
		$remarks 		= $this->input->post('remarks');
		$liabilities_id = [5, 8, 10, 11];
		$income_id      = [6, 7, 9];
		$last_invoice_building = $this->getLastInvoiceNoBuilding($month,$building_id);

		$gross_amount = 0;
		foreach ($acc['heads'] as $list) 
		{
			$acc_head_name = str_replace(' ', '', $list->name);
			$value = $this->input->post($acc_head_name);
			$gross_amount += $value; 
		}

		$data = [
			'invoice_no'    => $month.$last_invoice_building,
			'tenant_id'     => $tenant_id,
			'flat_id'       => $flat_id,
			'building_id'   => $building_id,
			'gross_amount'  => $gross_amount,
			'discount'      => 0,
			'card'          => 0,
			'cash'          => 1,
			'created_date'  => $this->payment_model->getDateTime(),
			'payment_date'  => $this->payment_model->getDateForDB($payment_date),
			'month'         => $month,
			'status'        => 1,
			'remarks'       => $remarks,
			'ware_id'       => $this->session->userdata('wire')

		];
        $this->db->insert('tbl_invoice', $data);
        $lastIns_id = $this->db->insert_id();
		//$lastIns_id=1;
		foreach ($acc['heads'] as $list) 
		{
			$acc_head_name = str_replace(' ', '', $list->name);
			$value = $this->input->post($acc_head_name);

			$transactionData['payment_type'] = 1;
			$transactionData['invoice_id'] = $lastIns_id;
			$transactionData['month'] = $month;
			$transactionData['tenant_id'] = $tenant_id;
			$transactionData['flat_id'] = $flat_id;
			$transactionData['date'] = $this->payment_model->getDateForDB($payment_date);
			$transactionData['amount'] = $value;

			if (in_array($list->id, $liabilities_id)) {
				$transactionData['debit'] = 13;
				$transactionData['credit'] = $list->id;
			} elseif (in_array($list->id, $income_id)) {
				$transactionData['debit'] = 13;
				$transactionData['credit'] = $list->id;
			} else {
				$transactionData['debit'] = $list->id;
				$transactionData['credit'] = 13;
			}
			$transactionData['ware_id'] = $this->session->userdata('wire');

			if ($transactionData['amount'] != 0) {
                $this->db->insert('tbl_transaction', $transactionData);
				
			}
		}
		$msg['msg'] = "Payment Received Sucessfully!";
        $msg['check'] = true;
        return $msg;

	}
    public function getLastInvoiceNoBuilding($month,$building_id)//return incremented last value of invoice that is incremented
    {
    	$lastInvoice = $this->db->select('invoice_no')->from('tbl_invoice')->where('month',$month)->where('building_id',$building_id)->order_by('invoice_id',"desc")->get()->row();
 
    	if(empty($lastInvoice->invoice_no)){
            $invoice_no = $building_id."0";
            $invoice_no = (int)$invoice_no;
            return $invoice_no+1;
        }else{
            $lastInvoice = $lastInvoice->invoice_no;
            $start = strlen($month);
            $end = strlen($lastInvoice);
            $invoice_no = substr($lastInvoice,$start,$end);
            $invoice_no = (int)$invoice_no;
            return $invoice_no+1;
        }
    }


    public function isExistMonth($month,$building_id)
    {
    	$val = $this->db->select('*')->from('tbl_invoice')->where('month',$month)->where('building_id',$building_id)->get()->result();
    	if (count($val)) {
    		return true;
    	}else{
    		return false;
    	}
    }

}