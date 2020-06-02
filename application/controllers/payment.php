<?php

class Payment extends CI_Controller
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
    public function rent_generate()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);
//        echo "<pre>";
//        print_r($data['buildingList']);exit();
        $this->load->view('home/headar',$data);
        $this->load->view('admin/rentPayment_view.php',$data);
        $this->load->view('home/footer');
    }
    public function get_building_all_flats()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $building_id            = $this->input->post('building_id');
        //$flat_id                = $this->input->post('flat_id');
        $dateMonth              = $this->input->post('dateMonth');
        //$data['flats']=[];
        //echo json_encode(date('Y-m',strtotime($dateMonth)));
        $dateMonth = date('Y-m',strtotime($dateMonth));
        $data['flats'] = $this->flat_model->getAllActiveFlat($type,$ware,$building_id);
       // print_r($data['flats']);exit();

//        if ($flat_id=="all"){
//            $data['flats'] = $this->flat_model->getAllActiveFlat($type,$ware,$building_id);
//        }else{
//            $data['flats'] = $this->db->select('*')->from('tbl_flat')->where('id',$flat_id)->get()->result();
//        }
        //echo json_encode($data['flats']);
        $data['heads'] = $this->payment_model->getAccHead();//all active sub-head
        //echo json_encode(count($data['heads']));
        
        $this->load->view('admin/paymentContent',$data);
    }
    public function bill_generate()
    {
        $temp = $this->payment_model->bill_generate();
        if($temp['check']==true)
        {
            $this->session->set_flashdata('feedback', $temp['msg']);
            $this->session->set_flashdata('feedback_class', 'alert-success');
        }else{
            $this->session->set_flashdata('feedback', $temp['msg']);
            $this->session->set_flashdata('feedback_class', 'alert-danger');
        }
        return redirect(base_url('payment/rent_generate'),'refresh');
    }

    public function rent_generate_report()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);
//        echo "<pre>";
//        print_r($data['buildingList']);exit();
        $this->load->view('home/headar',$data);
        $this->load->view('admin/rentGenerateReport_view.php',$data);
        $this->load->view('home/footer');
    }
    public function get_building_all_flats_specific_flats()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $building_id            = $this->input->post('building_id');
        $flat_id                = $this->input->post('flat_id');
        $dateMonth              = $this->input->post('dateMonth');
        $data['buildId'] = $building_id;
        
        //$data['flats']=[];
        //echo json_encode(date('Y-m',strtotime($dateMonth)));
        $dateMonth = date('m-Y',strtotime($dateMonth));
        $data['dateMonth'] = $dateMonth;
//        $data['flats'] = $this->flat_model->getAllActiveFlat($type,$ware,$building_id);
        // print_r($data['flats']);exit();
        $data['generatedBill'] = $this->payment_model->checkMonth($dateMonth,$building_id,$flat_id);//fetch all generated bill for selected month and building
        $data['gHead'] = $this->payment_model->getDistinctAccHead($dateMonth,$building_id,$flat_id);
        $data['gFlat'] = $this->payment_model->getDistinctFlat($dateMonth,$building_id,$flat_id);

//        if ($flat_id=="all"){
//            $data['flats'] = $this->flat_model->getAllActiveFlat($type,$ware,$building_id);
//        }else{
//            $data['flats'] = $this->db->select('*')->from('tbl_flat')->where('id',$flat_id)->get()->result();
//        }
        //echo json_encode($data['flats']);
        $data['heads'] = $this->payment_model->getAccHead();//all active sub-head
        //echo json_encode(count($data['heads']));
        $this->load->view('admin/paymentGenerateReport',$data);
    }

    public function recieptPrint($building_id,$datemonth)
    {
        
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;
        $data['generatedBill'] = $this->payment_model->checkMonth($datemonth,$building_id,'all');//fetch all generated bill for selected month and building
        $data['gFlat'] = $this->payment_model->getDistinctFlat($datemonth,$building_id,'all');
        // echo "<pre>";
        // print_r($data['generatedBill']);exit();
        
        $this->load->view('admin/recieptPrint_view.php',$data);
        $this->load->view('home/footer');
    }




    public function rent_receive()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);

        $this->load->view('home/headar',$data);
        $this->load->view('admin/rentReceive_view.php',$data);
        $this->load->view('home/footer');
    }
    public function get_building_all_flats_receive()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $building_id            = $this->input->post('building_id');
        $flat_id                = $this->input->post('flat_id');
        $dateMonth              = $this->input->post('dateMonth');

        $dateMonth = date('m-Y',strtotime($dateMonth));


        $data['generatedBill']   = $this->payment_model->checkMonth($dateMonth,$building_id,$flat_id);//fetch all generated bill for selected month and building
        $data['gHead']           = $this->payment_model->getDistinctAccHead($dateMonth,$building_id,$flat_id);
        $data['gFlat']           = $this->payment_model->getDistinctFlat($dateMonth,$building_id,$flat_id);
        $data['heads']           = $this->payment_model->getAccHead();//all active sub-head
        

        $data['transactionData'] = $this->payment_model->getTransactionDetails($dateMonth,$building_id,$flat_id);//for checking already pay bill or not, if paid then check it has due or not
        //echo json_encode($data['generatedBill']);
        $this->load->view('admin/paymentReceiveContent',$data);
    }


    public function bill_payment()
    {
    //     echo "<pre>";
    //    print_r($this->input->post());exit();
       $temp = $this->payment_model->bill_payment();
       if($temp['check']== true)
       {
           $this->session->set_flashdata('feedback', $temp['msg']);
           $this->session->set_flashdata('feedback_class', 'alert-success');
       }else{
           $this->session->set_flashdata('feedback', $temp['msg']);
           $this->session->set_flashdata('feedback_class', 'alert-danger');
       }
        return redirect(base_url('payment/rent_receive'),'refresh');
    }

    public function single_bill_payment()
    {
        //$data = $this->input->post();
        $temp = $this->payment_model->single_bill_payment();
        if($temp['check']== true)
        {
            echo json_encode($temp['msg']);
        }
    }


    public function rent_receive_report()
    {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;
        $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);

        $this->load->view('home/headar',$data);
        $this->load->view('admin/rentReceiveReport_view.php',$data);
        $this->load->view('home/footer');
    }
   public function get_building_all_flats_receive_report()
   {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $building_id            = $this->input->post('building_id');
        $flat_id                = $this->input->post('flat_id');
        $dateMonth              = $this->input->post('dateMonth');
        $dateMonth = date('m-Y',strtotime($dateMonth));

        //$data['generatedBill']  = $this->payment_model->checkMonth($dateMonth,$building_id,$flat_id);//fetch all generated bill for selected month and building
        $data['invoiceList'] = $this->payment_model->checkInvoiceForMonth($dateMonth,$building_id,$flat_id);
        $data['generatedBillvsInvoice'] = $this->payment_model->checkInvoiceGenerateBillForMonth($dateMonth,$building_id,$flat_id);//to check total generated value and invoice gross amount 
        $this->load->view('admin/rentReceiveReportContent',$data);
   }



   public function cash_bank_payment()
   {
        $ware                   = $this->session->userdata('wire');
        $type                   = $this->session->userdata('type');
        $admin                  = $this->session->userdata('admin');
        $data['type']           = 0;

        $data['payment_type']   = $this->payment_model->getPaymentType();
        $data['expLedger']      = $this->payment_model->getExpLedger();
        
        $this->load->view('home/headar',$data);
        $this->load->view('admin/cashBankPayment_view.php',$data);
        $this->load->view('home/footer');
   }

   public function add_cash_bank_payment()
   {
    //    echo json_encode($this->payment_model->add_cash_bank_payment());
       
       if($this->payment_model->add_cash_bank_payment())
       {
        $this->session->set_flashdata('feedback','Payment Inserted successfully.');
        $this->session->set_flashdata('feedback_class','alert-success');
       }
       return redirect(base_url('payment/cash_bank_payment'),'refresh');
       
   }
   public function expense_view()//further rename as ledger view
   {
    
    $data['type']           = 0;
    $data['ledgerList']     = $this->payment_model->getAccSubHead();
    $this->load->view('home/headar',$data);
    $this->load->view('admin/expenseView_view.php',$data);
    $this->load->view('home/footer');
   }

   public function get_expenseReport()
   {
    $start          = $this->input->post('start');
    $end            = $this->input->post('end');
    $ledger         = $this->input->post('ledger');
    $data['ledger'] = $ledger;
    $data['start']  = $start;
    $data['end']    = $end;
    $data['journal']       = $this->payment_model->get_ledger_report($ledger,$start,$end);
    $data['opening'] = $data['journal']['opening'];
    $data['journalList'] = $data['journal']['journalList'];
    $this->load->view('admin/expenseViewContent',$data);
   }
}