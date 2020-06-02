<?php

class User_Head extends CI_Model{
	public function __construct()
	{
		$this->load->database();
	}
	
	function ChatofAccounts($table,$col,$vas,&$mang1,$i=null,$last=null){
		
		$w = $this->session->userdata('wire');
		if(!empty($w))
			$this->db->where("(ware='".$w."' OR ware='0')");
		
		
		$this->db->where($col,$vas);
		$info=$this->db->get($table);
		foreach($info->result_array() as $val){
			
			$post= array();
			$post["id"]= $val["id"];
			$post["name"]= $val["name"];
			$post["head"]= $val["head"];
			
			array_push($mang1, $post);

			
			
				// $mang[]=$val['id'];
				// $mang[]=$val['name'];
				// $mang[]=$val['head'];
			
			$this->ChatofAccounts($table,'head',$val['id'],$mang1,$i);
			
			
			
			
			
			
			
		}
		
		return $mang1;
		
	}
	
	
	
	
	public function getHealList($table,$col,$vas,$i,$test){
		
		$mang1=array();
		
		$i = 0;
		$mang1=$this->getlist($table,$col,$vas,$mang1,$i);

		
		
		return $mang1;
		
		
	}
	
	public function getHealList2($table,$col,$vas,$i,$test){
		
		$mang1=array();
		
		$i = 0;
		$mang1=$this->getlist_pname($table,$col,$vas,$mang1,$i);

		
		
		return $mang1;
		
		
	}
	function getlist_pname($table,$col,$vas,&$mang1,$i){
		
		
		$w = $this->session->userdata('wire');
		if(!empty($w))
			$this->db->where("(ware='".$w."' OR ware='0')");
		
		$this->db->where($col,$vas);
		$info=$this->db->get($table);
		foreach($info->result_array() as $val){
			
			
			$mang1[]=$val['id'];
			$this->getlist_pname($table,'head',$val['id'],$mang1,$i);
			
			
		}
		
		return $mang1;
		
	}
	
	function getlist($table,$col,$vas,&$mang1,$i){
		
		
		$w = $this->session->userdata('wire');
		if(!empty($w))
			$this->db->where("(ware='".$w."' OR ware='0')");
		
		$this->db->where($col,$vas);
		$info=$this->db->get($table);
		foreach($info->result_array() as $val){
			
			
			$mang1[]=$val['id'];
			$this->getlist($table,'id',$val['head'],$mang1,$i);
			
			
			
			
			
			
			
			
			
			
		}
		
		return $mang1;
		
	}
	


	public function getHeadDList($acc_id)
	{

		if (isset($acc_id)) {
		return $this->db->select('*')
					->from('account_head')
					->where('sub_head_id',$acc_id)
					->get()->result();
		}
		
	}
	public function addLedger()
	{
		$main_acc_head_id  	= $this->input->post('ledgerId');
		$acc_head_name 		= $this->input->post('ac_head_name');
		if($main_acc_head_id == 1 || $main_acc_head_id == 4){
			$data['type'] = 1;
		}elseif($main_acc_head_id == 2 || $main_acc_head_id == 3){
			$data['type'] = 2;
		}
		$data['name'] = $acc_head_name;
		$data['amount'] = 0;
		$data['sub_head_id'] = $main_acc_head_id;
		$data['asc'] = 0;
		$data['status'] = 0;
		if ($main_acc_head_id != null) {
			if ($this->db->insert('account_head',$data)) {
			 	return "Ledger Created Sucessfully";
			 }
		}
	}
	
}

