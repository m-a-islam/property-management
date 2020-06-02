<?php

class Flat_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('news_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->library("pagination");
        $admin_user = $this->session->userdata('admin');
        if (empty($admin_user)) {
            redirect('member/adminlogin');
        }
    }
    private function getAllFlat($building_id)
    {
        $ware   = $this->session->userdata('wire');
        $type   = $this->session->userdata('type'); 
        return $this->flat_model->getAllFlat($type,$ware,$building_id);
    }
    public function index()
    {
        $ware   = $this->session->userdata('wire');
        $type   = $this->session->userdata('type');
        $admin  = $this->session->userdata('admin');
        $data['type'] = 0;
        // $data['userList'] = $this->building_model->getUser();
        $data['buildingList'] = $this->building_model->getAllBuilding($type,$ware);
        $this->load->view('home/headar',$data);
        $this->load->view('admin/manageFlat_view.php',$data);
        $this->load->view('home/footer');
    }
    public function flatList()//call from ajax for list of flat according to building_id
    {
      $building_id = $this->input->post('building_id');
       $data['flatList'] = $this->getAllFlat($building_id);
        echo json_encode($data['flatList']);
    }

    public function add_flat()
    {
        $building_id = $this->input->post('build_id');
        if($this->flat_model->add_flat()){
            $data['flatList'] = $this->getAllFlat($building_id);
            echo json_encode($data['flatList']);
        }
    }
    public function edit_flat()
    {
        $flat_id = $this->input->post('flat_id');
        $data['flat'] = $this->flat_model->getFlat($flat_id);
        echo json_encode($data['flat']);
    }
    public function update_flat()
    {
        $ware   = $this->session->userdata('wire');
        $type   = $this->session->userdata('type');
        $data['update'] = $this->flat_model->update_flat();
        $data['flatList'] = $this->flat_model->getAllFlat($type,$ware,$this->input->post('building_id'));
        echo json_encode($data);
    }
    public function delete_flat()
    {
        $data['delete'] = $this->flat_model->delete_flat();
        $data['flatList'] = $this->getAllFlat($this->input->post('building_id'));
        echo json_encode($data);
    }

//    call from payment controller
    public function flats($building_id)
    {
        return $this->getAllFlat($building_id);
    }
}