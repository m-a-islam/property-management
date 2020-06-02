<?php
class Tenant_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function test()
    {
        /*
        $data['date'] = '2018-05-10';
        //$temp = ;
        return date('m-Y',strtotime($data['date'])).$this->invoice_model->getLastInvoiceNoBuilding(date('m-Y',strtotime($data['date'])),7);
        $tem = $this->invoice_model->isExistMonth(date('m-Y',strtotime($data['date'])),10);
        return $tem;
        return $this->db->query("SELECT IF((SUM(adjustable_adv-IFNULL(checkAmount,0)+tenant_adv_deduct_amount)) <= 0,false,true) as canDeduct FROM(
            SELECT 
            SUM(tbl_transaction.amount) as checkAmount,tbl_tenant.adjustable_adv,tbl_tenant.tenant_adv_deduct_amount
            FROM tbl_transaction, tbl_tenant
            WHERE tbl_transaction.flat_id= 3
            AND tbl_transaction.tenant_id=29
            AND tbl_tenant.id=29
            AND tbl_transaction.credit = 14) as t
            ")->result();*/
             $data = $this->db->select('id')->from('account_head')->where('sub_head_id',2)->get()->result();
            return $data;
            $month = '07-2018';
            $building_id = 100;
        $lastInvoice =  $this->db->query("SELECT invoice_no FROM tbl_invoice WHERE month='$month' AND building_id=7 ORDER BY invoice_id DESC")->row();
        
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
       
        //return 0;
        
    }

    public function add_tenant()
    {
        $this->load->library('upload');
        $data['tenant_name']                = $this->input->post('tenant_name');
        $data['tenant_number']              = $this->input->post('tenant_number');
        $data['tenant_address']             = $this->input->post('tenant_address');
        $data['tenant_adv']                 = $this->input->post('tenant_adv');
        $data['adjustable_adv']             = $this->input->post('adjustable_adv');
        $data['tenant_adv_deduct_amount']   = $this->input->post('tenant_adv_deduct_amount');
        $data['start_date']                 = date('Y-m-d', strtotime($this->input->post('agree_start_date')));
        $data['end_date']                   = date('Y-m-d', strtotime($this->input->post('agree_end_date')));
        $data['build_id']                   = $this->input->post('build_id');
        $data['flat_id']                    = $this->input->post('flat_id');
        $data['parking_bill']               = $this->input->post('parking_bill');
        $data['status']                     = 1;
        $flat_id = $data['flat_id'];
        $this->db->insert('tbl_tenant', $data);
        $lastInsert_id = $this->db->insert_id();


        if (isset($data['tenant_adv'])) {
            $currentMonth = date('m-Y',strtotime($this->payment_model->getDateTime()));
            if($this->invoice_model->isExistMonth($currentMonth,$data['build_id'])){
                $inv['invoice_no'] = $currentMonth.$this->invoice_model->getLastInvoiceNoBuilding($currentMonth,$data['build_id']);
            }else{
                $inv['invoice_no'] = $currentMonth.$data['build_id'].'1';
            }
            $inv['tenant_id']       = $lastInsert_id;
            $inv['flat_id']         = $data['flat_id'];
            $inv['building_id']     = $data['build_id'];
            $inv['gross_amount']    = $data['tenant_adv'];
            $inv['discount']        = 0;
            $inv['card']            = 0;
            $inv['cash']            = 1;
            $inv['created_date']    = $this->payment_model->getDateTime();
            $inv['payment_date']    = date('Y-m-d',strtotime($this->payment_model->getDateTime()));
            $inv['month']           = $currentMonth;
            $inv['status']          = 1;
            $inv['remarks']         = "advance when inserting tenant";
            $inv['ware_id']         = $this->session->userdata('wire');
           // $inv['invoice_no'] = 
            $this->db->insert('tbl_invoice',$inv);
            $inv_id = $this->db->insert_id();

            //insert value to transaction table for advance

            $trans['payment_type']    = 2;
            $trans['invoice_id']      = $inv_id;
            $trans['month']           = $currentMonth;
            $trans['tenant_id']       = $lastInsert_id;
            $trans['flat_id']         = $data['flat_id'];
            $trans['building_id']     = $data['build_id'];
            $trans['date']            = date('Y-m-d',strtotime($this->payment_model->getDateTime()));
            $trans['amount']          = $data['tenant_adv'];
            $trans['debit']           = 13;
            $trans['credit']          = 11;//in account_head table advance=11 id 
            $trans['ware_id']         = $this->session->userdata('wire');
            $this->db->insert('tbl_transaction',$trans);
        }

        
        
        if (!empty($_FILES['tenant_image']['name']))
        {
            $userfile_name                      = $_FILES['tenant_image']['name'];
            $userfile_extn                      = substr($userfile_name, strrpos($userfile_name, '.') + 1);
            $voter_card                         = $_FILES['tenant_image'];
            $config['upload_path']              = 'uploads/tenant_image/';
            $config['allowed_types']            = '*';
            $_FILES['tenant_image']['name']     = $lastInsert_id . '.' . $userfile_extn;
            $_FILES['tenant_image']['type']     = $voter_card['type'];
            $_FILES['tenant_image']['tmp_name'] = $voter_card['tmp_name'];
            $_FILES['tenant_image']['size']     = $voter_card['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('tenant_image');
        }

        if (!empty($_FILES['voter_card']['name']))
        {
            $userfile_name = $_FILES['voter_card']['name'];
            $userfile_extn = substr($userfile_name, strrpos($userfile_name, '.') + 1);
            $voter_card = $_FILES['voter_card'];
            $config['upload_path'] = 'uploads/documents/';
            $config['allowed_types'] = '*';
            $_FILES['voter_card']['name'] = $data['tenant_name'] . '-' . $lastInsert_id . '-voter_card.' . $userfile_extn;
            $_FILES['voter_card']['type'] = $voter_card['type'];
            $_FILES['voter_card']['tmp_name'] = $voter_card['tmp_name'];
            $_FILES['voter_card']['size'] = $voter_card['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('voter_card');
        }
        if (!empty($_FILES['agreement_paper']['name']))
        {
            $userfile_name = $_FILES['agreement_paper']['name'];
            $userfile_extn = substr($userfile_name, strrpos($userfile_name, '.') + 1);
            $voter_card = $_FILES['agreement_paper'];
            $config['upload_path'] = 'uploads/documents/';
            $config['allowed_types'] = '*';
            $_FILES['agreement_paper']['name'] = $data['tenant_name'] . '-' . $lastInsert_id . '-agreement_paper.' . $userfile_extn;
            $_FILES['agreement_paper']['type'] = $voter_card['type'];
            $_FILES['agreement_paper']['tmp_name'] = $voter_card['tmp_name'];
            $_FILES['agreement_paper']['size'] = $voter_card['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('agreement_paper');
        }
        $this->db->where('id', $flat_id);
        $this->db->update('tbl_flat', ['status'=>1]);
        return true;
    }
    public function getAllTenant($type,$ware)
    {
        if($type==1)
        {
            return $this->db->select('*')->from('tbl_tenant')->where('status',1)->get()->result();
        }elseif ($type==2)
        {
            return $this->db->select('tbl_tenant.*')
            ->from('tbl_building')
            ->join('tbl_tenant', 'tbl_building.id = tbl_tenant.build_id')
            ->where('tbl_building.ware_id',$ware)
            ->where('status',1)
            ->get()
            ->result();
        }elseif ($type==3)
        {
            return $this->db->select('tbl_tenant.*')
            ->from('tbl_building')
            ->join('tbl_tenant', 'tbl_building.id = tbl_tenant.build_id')
            ->where('tbl_building.ware_id',$ware)
            ->where('tbl_building.building_auth',$this->session->userdata('admin'))
            ->where('status',1)
            ->get()
            ->result();
        }
    }
    public function get_tenant()
    {
        $tenant_id = $this->input->post('tenant_id');
        $data['tenant']= $this->db->select('*')->from('tbl_tenant')->where('id',$tenant_id)->get()->row();
        //echo "<pre>";
        //print_r($data['tenant']);exit();
        $flat_id = $data['tenant']->flat_id;
        $building_id = $data['tenant']->build_id;

        $start_date = $data['tenant']->start_date;
        $start_date = date("d-m-Y", strtotime($start_date));
        $data['tenant']->start_date = $start_date;

        $end_date = $data['tenant']->end_date;
        $end_date = date("d-m-Y", strtotime($end_date));
        $data['tenant']->end_date = $end_date;

        $data['flatList'] = $this->db->query("SELECT tbl_flat.*, tbl_tenant.*,tbl_flat.id as flatid FROM `tbl_flat`
            LEFT JOIN tbl_tenant 
            on tbl_tenant.flat_id=tbl_flat.id
            WHERE tbl_flat.building_id=$building_id 
            AND ((tbl_flat.status=0) 
            OR (tbl_flat.id=$flat_id AND tbl_flat.status=1))")->result();
        //echo "<pre>";
        //print_r($data['flatList']);exit();
        return $data;
    }


    public function update_tenant()
    {
        $this->load->library('upload');
        $tenant_id = $this->input->post('tenant_id_edit');
        $new_flat_id = $this->input->post('edit_flat_id');
        //print_r($new_flat_id);exit();
        //$data['tenant_id'] = $tenant_id;
//        update previous flat status to 0
        $old_flat_id = $this->db->select('flat_id')->from('tbl_tenant')->where('id',$tenant_id)->get()->row();
        //print_r($old_flat_id->flat_id);exit();

        if ( $new_flat_id != $old_flat_id->flat_id){
            $this->db->where('id', $old_flat_id->flat_id);
            $this->db->update('tbl_flat',['status'=>0]);
            $this->db->where('id', $new_flat_id);
            $this->db->update('tbl_flat', ['status'=>1]);
        }
        $data['tenant_name']                = $this->input->post('edit_tenant_name');
        $data['tenant_number']              = $this->input->post('edit_tenant_number');
        $data['tenant_address']             = $this->input->post('edit_tenant_address');
        $data['tenant_adv']                 = $this->input->post('edit_tenant_adv');
        $data['adjustable_adv']             = $this->input->post('edit_adjustable_adv');
        $data['tenant_adv_deduct_amount']   = $this->input->post('edit_tenant_adv_deduct_amount');
        $data['start_date']                 = date('Y-m-d', strtotime($this->input->post('edit_agree_start_date')));
        $data['end_date']                   = date('Y-m-d', strtotime($this->input->post('edit_agree_end_date')));
        $data['build_id']                   = $this->input->post('build_id');
        $data['flat_id']                    = $this->input->post('edit_flat_id');
        $data['status']                     = 1;
        //echo "<pre>";
        //print_r(!empty($_FILES['edit_tenant_image']['name']));exit();
        $this->db->where('id',$tenant_id)->update('tbl_tenant',$data);
        //unlink('uploads/tenant_image/24.jpeg');exit();
        if (!empty($_FILES['edit_tenant_image']['name']))
        {
            $userfile_name                      = $_FILES['edit_tenant_image']['name'];
            $userfile_extn                      = substr($userfile_name, strrpos($userfile_name, '.') + 1);
            $userfile_extn = "jpg";
            unlink('uploads/tenant_image/'.$tenant_id.'.'.$userfile_extn);// delete previous photo from folder
            $voter_card                         = $_FILES['edit_tenant_image'];
            $config['upload_path']              = 'uploads/tenant_image/';
            $config['allowed_types']            = '*';
            $_FILES['edit_tenant_image']['name']     = $tenant_id . '.' . $userfile_extn;
            $_FILES['edit_tenant_image']['type']     = $voter_card['type'];
            $_FILES['edit_tenant_image']['tmp_name'] = $voter_card['tmp_name'];
            $_FILES['edit_tenant_image']['size']     = $voter_card['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('edit_tenant_image');
        }

        if (!empty($_FILES['voter_card']['name']))
        {
            $userfile_name = $_FILES['voter_card']['name'];
            $userfile_extn = substr($userfile_name, strrpos($userfile_name, '.') + 1);
            $userfile_extn = "jpg";
            unlink('uploads/documents/'.$data['tenant_name'] . '-' . $tenant_id . '-voter_card.' . $userfile_extn);//delete previous photofrom folder
            $voter_card = $_FILES['voter_card'];
            $config['upload_path'] = 'uploads/documents/';
            $config['allowed_types'] = '*';
            $_FILES['voter_card']['name'] = $data['tenant_name'] . '-' . $tenant_id . '-voter_card.' . $userfile_extn;
            $_FILES['voter_card']['type'] = $voter_card['type'];
            $_FILES['voter_card']['tmp_name'] = $voter_card['tmp_name'];
            $_FILES['voter_card']['size'] = $voter_card['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('voter_card');
        }
        if (!empty($_FILES['agreement_paper']['name']))
        {
            $userfile_name = $_FILES['agreement_paper']['name'];
            $userfile_extn = substr($userfile_name, strrpos($userfile_name, '.') + 1);
            $userfile_extn = "jpg";
            unlink('uploads/documents/'.$data['tenant_name'] . '-' . $tenant_id . '-agreement_paper.' . $userfile_extn);//delete previous photo from folder
            $voter_card = $_FILES['agreement_paper'];
            $config['upload_path'] = 'uploads/documents/';
            $config['allowed_types'] = '*';
            $_FILES['agreement_paper']['name'] = $data['tenant_name'] . '-' . $tenant_id . '-agreement_paper.' . $userfile_extn;
            $_FILES['agreement_paper']['type'] = $voter_card['type'];
            $_FILES['agreement_paper']['tmp_name'] = $voter_card['tmp_name'];
            $_FILES['agreement_paper']['size'] = $voter_card['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('agreement_paper');
        }
        //echo "upload";
        //exit();
//        $this->db->where('id', $flat_id);
//        $this->db->update('tbl_flat', ['status'=>1]);
        return true;
    }
    public function delete_tenant($tenant_id)
    {
        $flat_id = $this->db->select('flat_id')->from('tbl_tenant')->where('id',$tenant_id)->get()->row();
        $this->db->where('id',$flat_id->flat_id)->update('tbl_flat',['status'=>0]);
        return $this->db->where('id',$tenant_id)->update('tbl_tenant',['status'=>0]);
    }
    public function findTenant($tenant_id)
    {
        return $this->db->select('*')->from('tbl_tenant')->where('id', $tenant_id)->get()->row();
    }
    public function showAgreementSheetByBuilding($building_id)
    {
        return $this->db->query("SELECT tbl_tenant.*,tbl_building.building_name,tbl_flat.flat_number 
        FROM `tbl_tenant`
        INNER JOIN tbl_building ON tbl_tenant.build_id = tbl_building.id
        INNER JOIN tbl_flat ON tbl_tenant.flat_id=tbl_flat.id
        WHERE tbl_tenant.build_id=$building_id AND tbl_tenant.status = 1")->result();
    }
}