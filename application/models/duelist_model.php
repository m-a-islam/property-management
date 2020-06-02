<?php

class Duelist_model extends CI_Model
{
	public function get_generatedBill($building_id,$flat_id,$from,$to)
	{
		$start 	= $this->payment_model->getDateForDB($from);
		$end 	= $this->payment_model->getDateForDB($to);
		$startTime = "00:00:00";
		$endTime = "23:59:59";

		if (is_numeric($flat_id)) {
			return $this->db->query("SELECT *, SUM( bill_generate.amount ) AS generated_total 
				FROM `bill_generate` 
				WHERE date_time 
				BETWEEN CONCAT('$start',' ','$startTime') AND CONCAT('$end',' ','$endTime')
				AND building_id = $building_id 
				AND flat_id = $flat_id
				")
			->result();
		}else{
			return $this->db->query("SELECT *, SUM( bill_generate.amount ) AS generated_total 
				FROM `bill_generate` 
				WHERE date_time 
				BETWEEN CONCAT('$start',' ','$startTime') AND CONCAT('$end',' ','$endTime')
				AND building_id = $building_id 
				GROUP BY bill_generate.flat_id
				")
			->result();
		}
	}
	public function get_transaction($building_id,$flat_id,$from,$to)
	{
		$start 	= $this->payment_model->getDateForDB($from);
		$end 	= $this->payment_model->getDateForDB($to);
		$extend = "";
		if(is_numeric($flat_id)){
			$extend = "AND tbl_transaction.flat_id = ".$flat_id;
		}else{
			$extend = "GROUP BY tbl_transaction.flat_id";
		}
		$sql = "SELECT tbl_transaction.*,tbl_tenant.tenant_name,tbl_flat.flat_number, sum(CASE  
             		WHEN (tbl_transaction.payment_type=2 AND tbl_transaction.credit !=11) THEN tbl_transaction.amount 
                     WHEN (tbl_transaction.payment_type=1 AND tbl_transaction.credit !=11) THEN -tbl_transaction.amount 
           			END) AS paid_total 
				FROM `tbl_transaction` 
				INNER JOIN tbl_tenant ON tbl_transaction.tenant_id=tbl_tenant.id
				INNER JOIN tbl_flat ON tbl_transaction.flat_id=tbl_flat.id
				WHERE tbl_transaction.date >= '$start' AND tbl_transaction.date <= '$end'
				AND tbl_transaction.building_id = $building_id".' '."$extend";
			return $this->db->query($sql)->result();
	}

	public function details_dueList()
	{
		$flat_id 		= $this->input->post('flat_id');
		$building_id	= $this->input->post('building_id');
		$ware_id 		= $this->input->post('ware_id');
		$start_date 	= $this->input->post('start_date');
		$end_date 		= $this->input->post('end_date');
		$start 	= $this->payment_model->getDateForDB($start_date);
		$end 	= $this->payment_model->getDateForDB($end_date);
		$startTime = "00:00:00";
		$endTime = "23:59:59";

		$data['generatedBillDetails'] 	= $this->db->query("SELECT bill_generate.*, account_head.*, bill_generate.amount as generateAmount
			FROM `bill_generate`
			INNER JOIN account_head ON bill_generate.accounts_id = account_head.id
			WHERE bill_generate.date_time 
			BETWEEN CONCAT('$start',' ','$startTime') AND CONCAT('$end',' ','$endTime')
			AND bill_generate.building_id = $building_id 
			AND bill_generate.flat_id 	= $flat_id
			")->result();
		$data['transactionDetails'] 	= $this->db->query("SELECT tbl_transaction.*,account_head.*,tbl_transaction.amount as transactionAmount 
			FROM `tbl_transaction`
			INNER JOIN account_head ON account_head.id = (CASE 
                                                    WHEN tbl_transaction.payment_type=2
                                                        THEN tbl_transaction.credit
                                                        ELSE tbl_transaction.debit
                                                    END)
			WHERE tbl_transaction.date
			BETWEEN '$start' AND '$end'
			AND tbl_transaction.flat_id 	= $flat_id 
			AND tbl_transaction.building_id = $building_id
			AND tbl_transaction.ware_id 	= $ware_id
			")->result();
		return $data;
	}

	public function get_previousDue($tenant_id,$start_date)
	{
		$current_date 	= $this->payment_model->getDateForDB($start_date); //this is the start date passed from date between UI
		$generated =  $this->db->query("SELECT *, SUM( bill_generate.amount ) AS generated_total
			FROM `bill_generate` 
			WHERE date_time < CONCAT('$current_date',' ','00:00:00')
			AND tenant_id = $tenant_id
			")->result();
		$transaction = $this->db->query("SELECT * FROM `tbl_transaction` 
			WHERE date < '$current_date'
			AND tenant_id = $tenant_id
			")->result();
		$transAmount = 0;
		foreach ($transaction as $trans) {
			if($trans->payment_type==2){
				$transAmount += $trans->amount;
			}
		}
		foreach ($generated as $gen) {
			return $gen->generated_total-$transAmount;
		}
	}
}