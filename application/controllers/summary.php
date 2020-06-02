<?php

class Summary extends CI_Controller
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

    public function index()
    {
        $data['type']        = 0;
        $this->load->view('home/headar',$data);
        $this->load->view('admin/totalSummary_view.php',$data);
        $this->load->view('home/footer');
    }
    public function get_totalSummary()
    {
        $data['start']       = $this->input->post('start');
        $data['end']         = $this->input->post('end');

        $data['totalSummary']= $this->summary_model->get_totalSummary($data['start'],$data['end']);
        $this->load->view('admin/totalSummaryContent',$data);
    }

    public function adv_sheet()
    {
        $data['type']        = 0;
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);
        $this->load->view('home/headar',$data);
        $this->load->view('admin/advSheet_view.php',$data);
        $this->load->view('home/footer');
    }

    public function showAdvanceAgreementByBuilding()
    {
        $building_id            = $this->input->post('building_id');
        $data['advanceList']    = $this->summary_model->showAdvanceAgreementByBuilding($building_id);
        $this->load->view('admin/advanceAgreementSheetContent',$data);
    }

    public function yearly_statement()
    {
        $data['type']        = 0;
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);
        $this->load->view('home/headar',$data);
        $this->load->view('admin/yearlySheet_view.php',$data);
        $this->load->view('home/footer');
    }
    public function showYearly_statement()
    {
        $building_id            = $this->input->post('building_id');
        $start            = $this->input->post('start');
        $end            = $this->input->post('end');
        $data['start'] = $start;
        $data['end'] = $end;
        $data['building'] = $this->db->select('building_name')->from('tbl_building')->where('id',$building_id)->where('ware_id',$this->session->userdata('wire'))->get()->row();
        $data['yearlyInfoList']    = $this->summary_model->showYearly_statement($building_id,$start,$end);
        $this->load->view('admin/yearlySheetContent',$data);
    }
}