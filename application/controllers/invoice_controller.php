<?php

class Invoice_controller extends CI_Controller
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

    public function view_invoice($invoice_id)
    {           
        $ware = $this->session->userdata('wire');
        $type = $this->session->userdata('type');
        $admin = $this->session->userdata('admin');
        $data['type'] = 0;
        // $data['buildingList']   = $this->building_model->getAllBuilding($type,$ware);
//        echo "<pre>";
//        print_r($data['buildingList']);exit();
        // $this->load->view('home/headar',$data);
        $data['invoiceDetails'] = $this->invoice_model->get_invoice_details($invoice_id, $ware);
        $data['transDetailsByInvoiceId'] = $this->invoice_model->get_transaction_details($invoice_id, $ware);
        $this->load->view('admin/invoiceView.php', $data);
        //$this->load->view('home/footer');
    }
    // call from myRentReceiveReportContent.js editPayment
    public function processing_edit_payment()
    {
        echo json_encode($this->invoice_model->processing_edit_payment());
    }

    public function update_invoice()
    {
        echo json_encode($this->invoice_model->update_invoice());
    }
    public function delete_invoice()
    {
        echo json_encode($this->invoice_model->delete_invoice());
    }

/*
    // call from myRentReceiveReportContent.js takepayment
    public function processing_take_payment()
    {
        //$invoice_id = $this->input->post('invoice_id');
        //echo $invoice_id;

        echo json_encode($this->invoice_model->processing_take_payment());
    }
    public function take_payment()//taking payment for unpaid tenant/flat call from ajax
    {
        $temp = $this->invoice_model->take_payment();
        if($temp['check']== true)
        {
            $this->session->set_flashdata('feedback', $temp['msg']);
            $this->session->set_flashdata('feedback_class', 'alert-success');
        }
        return redirect(base_url('payment/rent_receive_report'),'refresh');
    } */
}
