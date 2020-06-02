<?php

class Summary_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_totalSummary($from,$to)
    {
        $start 	 = $this->payment_model->getDateForDB($from);
        $end 	 = $this->payment_model->getDateForDB($to);
        $ware_id = $this->session->userdata('wire');
        if(isset($ware_id))
        {
            return $this->db->query("SELECT  
                    SUM(IF( (payment_type) = 2, amount, 0)) AS debitAmount,
                    SUM(IF( (payment_type) = 1, amount, 0)) AS creditAmount
            FROM tbl_transaction
                WHERE tbl_transaction.date >= '$start' AND tbl_transaction.date <= '$end'
                AND ware_id = $ware_id
            ")->result();
        }
    }

    public function showAdvanceAgreementByBuilding($building_id)
    {
        $ware_id = $this->session->userdata('wire');
        if(isset($ware_id))
        {
            return $this->db->query("SELECT tbl_tenant.*, tbl_transaction.invoice_id,tbl_building.building_name,tbl_flat.flat_number,tbl_invoice.invoice_no
            FROM `tbl_tenant`
            INNER JOIN tbl_transaction on tbl_tenant.build_id = tbl_transaction.building_id
            INNER JOIN tbl_building on tbl_tenant.build_id = tbl_building.id
            INNER JOIN tbl_flat on tbl_tenant.flat_id = tbl_flat.id
            INNER JOIN tbl_invoice on tbl_transaction.invoice_id = tbl_invoice.invoice_id
            WHERE tbl_transaction.credit = 11 
            AND tbl_transaction.debit = 13 
            AND tbl_tenant.build_id = $building_id
            AND tbl_transaction.ware_id = $ware_id")->result();
        }
    }

    public function showYearly_statement($building_id,$from,$to)
    {
        $start 	 = $this->payment_model->getDateForDB($from);
        $end 	 = $this->payment_model->getDateForDB($to);
        $ware_id = $this->session->userdata('wire');
        if(isset($ware_id))
        {
            return $this->db->query("SELECT date,sum(cash) as cash,sum(Bank) as bank from (
                SELECT date,transaction_id,0 Bank, amount as cash 
                FROM `tbl_transaction` 
                WHERE payment_type=2 and debit=13 and tbl_transaction.date >= '$start' 
                AND tbl_transaction.date <= '$end'
                AND tbl_transaction.building_id = $building_id
                AND tbl_transaction.ware_id = $ware_id
                group by transaction_id
                UNION 
                SELECT date,transaction_id,amount as Bank,0 cash 
                FROM `tbl_transaction` 
                WHERE payment_type=2 and debit=16 and tbl_transaction.date >= '$start' 
                AND tbl_transaction.date <= '$end'
                AND tbl_transaction.building_id = $building_id
                AND tbl_transaction.ware_id = $ware_id
                group by transaction_id) as tt group by substring(date,1,7)")->result();
        }
    }
}