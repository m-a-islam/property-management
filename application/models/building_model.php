<?php
class Building_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function getAllBuilding($type,$ware)
    {
        if ($type==1){
            return $this->db->select('*')->from('tbl_building')->where('building_status',1)->get()->result();
        }elseif ($type==2){
            return $this->db->select('*')->from('tbl_building')->where('ware_id',$ware)->where('building_status',1)->get()->result();
            //print_r($this->db->last_query());exit;
        }elseif ($type==3){
            return $this->db->select('*')->from('tbl_building')->where('building_auth',$this->session->userdata('admin'))->where('building_status',1)->get()->result();
        }
    }
    public function getUser()
    {
        $ware_id = $this->session->userdata('wire');
        $q = $this->db
                    ->select('*')
                    ->from('password')
                    ->where('ware',$ware_id)
                    ->get();
        return $q->result();
    }
//    call from tenant list
    public function findBuilding($building_id)
    {
        return $this->db->select('*')->from('tbl_building')->where('id',$building_id)->get()->row();
    }
}