<?php

class Building_controller extends CI_Controller
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
    public function index()
    {
        $ware = $this->session->userdata('wire');
        $type = $this->session->userdata('type');
        $admin = $this->session->userdata('admin');
        $data['type'] = 0;
        $data['userList'] = $this->building_model->getUser();//admin er across e user list 
        $data['buildingList'] = $this->building_model->getAllBuilding($type,$ware);
        
        $this->load->view('home/headar',$data);
        $this->load->view('admin/manageBuilding_view',$data);
        $this->load->view('home/footer');
    }
    public function add_building()
    {
        $data = [
            'user_id'       => $this->session->userdata('admin'),//person who loggin
            'ware_id'       => $this->session->userdata('wire'),//which ware this building belongs
            'user_type'     => $this->session->userdata('type'),//1=superAdmin, 2=admin or 3=user
            'building_name' => $this->input->post('buildingName'),
            'building_code' => $this->input->post('buildingCode'),
            'building_loc'  => $this->input->post('buildingLoc'),
            'building_auth' => $this->input->post('buildingAuth'),
            'building_status'=> 1
        ];
        $this->db->insert('tbl_building',$data);
        echo true;
    }
    public function delete_building($building_id)
    {
       $this->db->where('id',$building_id)->update('tbl_building',['building_status'=>0]);
       return redirect('building_controller');
    }

    public function get_building() // find building using id of tbl_building
    {
        $id = $this->input->post('id');
        echo json_encode($this->db->select('*')->from('tbl_building')->where('id',$id)->get()->row());
    }
    public function update_building()
    {
        $id = $this->input->post('building_id');
        $data = [
            'user_id'        => $this->session->userdata('admin'),//person who loggin
            'ware_id'        => $this->session->userdata('wire'),//which ware this building belongs
            'user_type'      => $this->session->userdata('type'),//1=superAdmin, 2=admin or 3=user
            'building_name'  => $this->input->post('buildingName'),
            'building_code'  => $this->input->post('buildingCode'),
            'building_loc'   => $this->input->post('buildingLoc'),
            'building_auth'  => $this->input->post('buildingAuth'),
            'building_status'=> 1
        ];
        $q = $this->db->where('id',$id)->update('tbl_building',$data);
        if($this->db->affected_rows()=='1')
        {
         $msg = 'Update successfully';
         $sts = 1;   
        }else{
            $msg = 'Update failed';
            $sts = 0;   
        }
        $arr = [

                'msg' => $msg,
                'sts' => $sts
        ];
        echo json_encode($arr);
    }
}