<?php

class Collection_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
/*
	public function get_transaction($building_id,$flat_id,$from,$to)
	{
		$start 	= $this->payment_model->getDateForDB($from);
		$end 		= $this->payment_model->getDateForDB($to);
		$ware_id = $this->session->userdata('wire');
		if (is_numeric($flat_id)) {
			return $this->db->query("SELECT tbl_transaction.*,tbl_tenant.tenant_name,tbl_flat.flat_number 
				FROM `tbl_transaction`
				INNER JOIN tbl_tenant ON tbl_transaction.tenant_id=tbl_tenant.id
				INNER JOIN tbl_flat ON tbl_transaction.flat_id=tbl_flat.id
				WHERE tbl_transaction.date >='$start' AND tbl_transaction.date <= '$end'
				AND tbl_transaction.building_id = $building_id
				AND tbl_transaction.flat_id = $flat_id
				AND tbl_transaction.ware_id = $ware_id
				")->result();
		}else{
			return $this->db->query("SELECT tbl_transaction.*,tbl_tenant.tenant_name,tbl_flat.flat_number 
				FROM `tbl_transaction`
				INNER JOIN tbl_tenant ON tbl_transaction.tenant_id=tbl_tenant.id
				INNER JOIN tbl_flat ON tbl_transaction.flat_id=tbl_flat.id
				WHERE tbl_transaction.date >='$start' AND tbl_transaction.date <= '$end'
				AND tbl_transaction.building_id = $building_id
				AND tbl_transaction.ware_id = $ware_id
				")->result();
		}
	}*/
	public function details_collectionReport()
	{
		
		$flat_id 		= $this->input->post('flat_id');
		$building_id	= $this->input->post('building_id');
		$ware_id 		= $this->input->post('ware_id');
		$start_date 	= $this->input->post('start_date');
		$end_date 		= $this->input->post('end_date');
		$start 			= $this->payment_model->getDateForDB($start_date);
		$end 				= $this->payment_model->getDateForDB($end_date);
		
		$data['transactionDetails'] 	= $this->db->query("SELECT tbl_transaction.*,account_head.*, tbl_transaction.amount as transactionAmount 
			FROM `tbl_transaction`
			INNER JOIN account_head ON tbl_transaction.credit = account_head.id
			WHERE tbl_transaction.date >= '$start' AND tbl_transaction.date <= '$end'
			AND tbl_transaction.flat_id 	= $flat_id 
			AND tbl_transaction.building_id = $building_id
			AND tbl_transaction.ware_id 	= $ware_id
			")->result();
		return $data;
	}
	public function get_transaction_collection($building_id,$flat_id,$from,$to)
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
             		WHEN (tbl_transaction.payment_type=2) THEN tbl_transaction.amount 
                     WHEN (tbl_transaction.payment_type=1) THEN -tbl_transaction.amount 
           			END) AS paid_total 
				FROM `tbl_transaction` 
				INNER JOIN tbl_tenant ON tbl_transaction.tenant_id=tbl_tenant.id
				INNER JOIN tbl_flat ON tbl_transaction.flat_id=tbl_flat.id
				WHERE tbl_transaction.date >= '$start' AND tbl_transaction.date <= '$end'
				AND tbl_transaction.building_id = $building_id".' '."$extend";
			return $this->db->query($sql)->result();
	}
}