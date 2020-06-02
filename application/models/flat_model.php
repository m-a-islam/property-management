<?php

class Flat_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getAllFlat($type, $ware, $building_id)
    {
        if ($type == 1) {
            return $this->db->select('tbl_flat.*')
                ->from('tbl_building')
                ->join('tbl_flat', 'tbl_building.id = tbl_flat.building_id')
                ->where('tbl_flat.building_id', $building_id)
                ->get()
                ->result();
        } elseif ($type == 2) {
            return $this->db->select('tbl_flat.*')
                ->from('tbl_building')
                ->join('tbl_flat', 'tbl_building.id = tbl_flat.building_id')
                ->where('tbl_building.ware_id', $ware)
                ->where('tbl_flat.building_id', $building_id)
                ->get()
                ->result();
        } elseif ($type == 3) {
            return $this->db->select('tbl_flat.*')
                ->from('tbl_building')
                ->join('tbl_flat', 'tbl_building.id = tbl_flat.building_id')
                ->where('tbl_building.ware_id', $ware)
                ->where('tbl_flat.building_id', $building_id)
                ->where('tbl_building.building_auth', $this->session->userdata('admin'))
                ->get()
                ->result();
        }
    }

    public function add_flat()
    {
        $data = [
            'flat_number' => $this->input->post('flatNumber'),
            'status' => 0,
            'flat_rent' => $this->input->post('flatRent'),
            'flat_service_charge' => $this->input->post('flatService'),
            'gas_bill' => $this->input->post('flatGasBill'),
            'building_id' => $this->input->post('build_id')
        ];
        if ($this->db->insert('tbl_flat', $data))
            return true;

    }

    public function getFlat($flat_id)
    {
        return $this->db->select('*')->from('tbl_flat')->where('id', $flat_id)->get()->row();
    }

    public function update_flat()
    {
        $flat_id = $this->input->post('flat_id');
        $data = [
            'flat_number' => $this->input->post('flatNumber'),
            'status' => $this->input->post('sts'),
            'flat_rent' => $this->input->post('flatRent'),
            'flat_service_charge' => $this->input->post('flatService'),
            'gas_bill' => $this->input->post('flatGasBill'),
            'building_id' => $this->input->post('building_id')
        ];
        $q = $this->db->where('id', $flat_id)->update('tbl_flat', $data);
        if ($this->db->affected_rows() == '1') {
            return $q;
        } else {
            return FALSE;
        }
    }

    public function delete_flat()
    {
        $flat_id = $this->input->post('flat_id');
        return $this->db->delete('tbl_flat', ['id' => $flat_id]);
       // $this->db->where('id', $flat_id)->update('tbl_flat', ['status'=>0]);
    }

    //call from tenant list
    public function findFlat($flat_id)
    {
        return $this->db->select('*')->from('tbl_flat')->where('id', $flat_id)->get()->row();
    }

//    call from payment controller
    public function getAllActiveFlat($type, $ware, $building_id)
    {
        if ($type == 1) {
            return $this->db->select('tbl_flat.*')
                ->from('tbl_building')
                ->join('tbl_flat', 'tbl_building.id = tbl_flat.building_id')
                ->where('tbl_flat.building_id', $building_id)
                ->where('tbl_flat.status',1)
                ->get()
                ->result();
        } elseif ($type == 2) {
            return $this->db->select('tbl_flat.*')
                ->from('tbl_building')
                ->join('tbl_flat', 'tbl_building.id = tbl_flat.building_id')
                ->where('tbl_building.ware_id', $ware)
                ->where('tbl_flat.building_id', $building_id)
                ->where('tbl_flat.status',1)
                ->get()
                ->result();
        } elseif ($type == 3) {
            return $this->db->select('tbl_flat.*')
                ->from('tbl_building')
                ->join('tbl_flat', 'tbl_building.id = tbl_flat.building_id')
                ->where('tbl_building.ware_id', $ware)
                ->where('tbl_flat.building_id', $building_id)
                ->where('tbl_flat.status',1)
                ->where('tbl_building.building_auth', $this->session->userdata('admin'))
                ->get()
                ->result();
        }
    }

}