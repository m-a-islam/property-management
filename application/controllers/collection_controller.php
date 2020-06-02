<?php

class collection_controller extends CI_Controller
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

    public function collection_report()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);

        $this->load->view('home/headar',$data);
        $this->load->view('admin/collection_report_view.php',$data);
        $this->load->view('home/footer');
    }

    public function get_collectionReport()
    {
        $flat_id        = $this->input->post('flat_id');
        $building_id    = $this->input->post('building_id');
        $start          = $this->input->post('start');
        $end            = $this->input->post('end');
       
        $data['start']  = $start;
        $data['end']    = $end;
        $data['transaction'] = $this->collection_model->get_transaction_collection($building_id,$flat_id,$start,$end); 
        $this->load->view('admin/collectionControllerContent',$data);
    }

    public function details_collectionReport()
    {
      echo json_encode($this->collection_model->details_collectionReport());
    }
    
}
