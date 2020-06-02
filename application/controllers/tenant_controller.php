<?php

class Tenant_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('news_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->library("pagination");
        $admin_user = $this->session->userdata('admin');
        //$this->session->keep_flashdata('feedback');
        //$this->session->keep_flashdata('feedback_class');
        if (empty($admin_user)) {
            redirect('member/adminlogin');
        }
    }
    public function test()
    {
        $start = "10:10";
        $end = $start;
        $building_id = 99;
        $flat_id = "add";
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
        // $liabilities_id = [5, 8, 10, 11];
        // print_r($liabilities_id);
       
        echo $sql;
    }

    public function index()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);
        $data['tenantList']     = $this->tenant_model->getAllTenant($type,$ware);
        //echo "<pre>";
        //print_r($data['tenantList']);exit();
        $this->load->view('home/headar',$data);
        $this->load->view('admin/manageTenant_view.php',$data);
        $this->load->view('home/footer');
    }
    public function add_tenant()
    {
       // echo "<pre>";
//        print_r($this->input->post());
        //print_r($_FILES);
        if($this->tenant_model->add_tenant())
        {
            $this->session->set_flashdata('feedback','Tenant added successfully.');
            $this->session->set_flashdata('feedback_class','alert-success');
        }
        return redirect(base_url('tenant_controller'),'refresh');
    }
    public function get_tenant()
    {
        $data = $this->tenant_model->get_tenant();
        echo json_encode($data);
    }

    public function update_tenant()
    {
        //echo "<pre>";
        //print_r($this->input->post());
        //$data = $this->tenant_model->update_tenant();
        //echo json_encode($data);
        if($this->tenant_model->update_tenant())
        {
            $this->session->set_flashdata('feedback','Tenant Updated successfully.');
            $this->session->set_flashdata('feedback_class','alert-success');
        }
        return redirect(base_url('tenant_controller'),'refresh');
    }

    public function delete_tenant($tenant_id)
    {
        if ($this->tenant_model->delete_tenant($tenant_id))
        {
            $this->session->set_flashdata('feedback','Tenant deleted successfully.');
            $this->session->set_flashdata('feedback_class','alert-success');
        }
        return redirect(base_url('tenant_controller'),'refresh');
    }

    public function agreementSheet()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);
        $this->load->view('home/headar',$data);
        $this->load->view('admin/agreementSheet_view.php',$data);
        $this->load->view('home/footer');
    }

    public function showAgreementSheetByBuilding()
    {

        $building_id            = $this->input->post('building_id');
        
        //echo json_encode($building_id);
        $data['agreementist'] = $this->tenant_model->showAgreementSheetByBuilding($building_id);
        $this->load->view('admin/agreementSheetContent',$data);
    }

}