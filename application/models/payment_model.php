<?php

class Payment_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getDateForDB($val)
    {
        //$datestamp = strtotime($val);
        //$date_formated = date('Y-m-d', $datestamp);
        // return date_format($datestamp,"Y-m-d");
        // return $date_formated;
        if ($val != '') {
            return date("Y-m-d", strtotime($val));
        }

    }

    public function getAccHead()
    {
        return $this->db->select('*')
        ->from('account_head')
        ->where('status', 1)
        ->get()->result();
    }
    public function getAccSubHead()
    {
        return $this->db->query("SELECT * FROM account_head WHERE sub_head_id != 0")->result(); 
    }

    public function getFlatRent($flat_id)
    {
        return $this->db->select('*')->from('tbl_flat')->where('id', $flat_id)->get()->row();
    }

    public function getTenantByFlat($flat_id)
    {
        return $this->db->select('*')->from('tbl_tenant')->where('flat_id', $flat_id)->where('status', 1)->get()->row();
    }

    public function bill_generate()
    {
        $acc['heads'] = $this->getAccHead();
//        echo "<pre>";
//        print_r($acc['heads']);exit();
        $tenant_id = $this->input->post('tenant');
        $flat_id = $this->input->post('flatt_id');
        $building_id = $this->input->post('building_id');
        $month = $this->input->post('month');
        $month = strtotime($month);
        $month = date('m-Y', $month);
        $checkMonth = $this->checkMonth($month, $building_id);
        $building_idExist = $this->buildingIsExistInBillGenerateTable($building_id);
        if (count($building_idExist) > 0) {
            if (count($checkMonth) <= 0) {
                for ($i = 0; $i < count($tenant_id); $i++) {
                    foreach ($acc['heads'] as $list) {
                        $acc_head_name = str_replace(' ', '', $list->name);

                        $value = $this->input->post($acc_head_name);

                        $data['tenant_id'] = $tenant_id[$i];
                        $data['flat_id'] = $flat_id[$i];
                        $data['accounts_id'] = $list->id;

                        if ($data['accounts_id'] == 11) {
                            $data['amount'] = -$value[$i];
                        }else{
                            $data['amount'] = $value[$i];
                        }
                        $data['building_id'] = $building_id;
                        $data['month'] = $month;
                        $data['date_time'] = $this->getDateTime();


                        if ($data['amount'] != 0) {
                            $q = $this->db->insert('bill_generate', $data);
                        }
                    }
                }
                $msg['msg'] = "Bill generated Sucessfully!";
                $msg['check'] = true;
                return $msg;
            } else {
                $msg['msg'] = "Bill already generated for this month!";
                $msg['check'] = false;
                return $msg;
            }
        } else {
            for ($i = 0; $i < count($tenant_id); $i++) {
                foreach ($acc['heads'] as $list) {
                    $acc_head_name = str_replace(' ', '', $list->name);

                    $value = $this->input->post($acc_head_name);

                    $data['tenant_id']   = $tenant_id[$i];
                    $data['flat_id']     = $flat_id[$i];
                    $data['accounts_id'] = $list->id;

                    if ($data['accounts_id'] == 11) {
                        $data['amount']  = -$value[$i];
                    }else{
                        $data['amount']  = $value[$i];
                    }

                    $data['building_id'] = $building_id;
                    $data['month']       = $month;
                    $data['date_time']   = $this->getDateTime();

                    if ($data['amount'] != 0) {
                        $q = $this->db->insert('bill_generate', $data);
                    }
                }
            }
            $msg['msg'] = "Bill generated Sucessfully!";
            $msg['check'] = true;
            return $msg;
        }

    }


    public function getDateTime()
    {
        $date_time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $hours = $date_time->format('G');
        $date_time = $date_time->format('Y-m-d G:i:s');
        return $date_time;

    }

    public function buildingIsExistInBillGenerateTable($building_id)//building id is exist in bill generate table initially
    {
        return $this->db->select('*')->from('bill_generate')->where('building_id', $building_id)->get()->result();
    }

    public function checkMonth($month, $building_id, $flat_id = "")
    {
        if (is_numeric($flat_id)) {
            return $this->db
            ->select('*')
            ->from('bill_generate')
            ->where('month', $month)->where('building_id', $building_id)->where('flat_id', $flat_id)
            ->order_by('accounts_id', 'asc')
            ->get()->result();
        } else {
            return $this->db
            ->select('*')
            ->from('bill_generate')
            ->where('month', $month)->where('building_id', $building_id)
            ->order_by('accounts_id', 'asc')
            ->get()->result();
        }
    }

    public function getDistinctAccHead($month, $building_id, $flat_id = "")
    {
        if (is_numeric($flat_id)) {
            return $this->db
            ->select('accounts_id')
            ->from('bill_generate')
            ->where('month', $month)->where('building_id', $building_id)->where('flat_id', $flat_id)
            ->group_by('accounts_id')
            ->get()->result();
        } else {
            return $this->db
            ->select('accounts_id')
            ->from('bill_generate')
            ->where('month', $month)->where('building_id', $building_id)
            ->group_by('accounts_id')
            ->get()->result();
        }
    }

    public function getDistinctFlat($dateMonth, $building_id, $flat_id)
    {
        if (is_numeric($flat_id)) {
            return $this->db
            ->select('tbl_flat.flat_number,bill_generate.flat_id,bill_generate.tenant_id,tbl_flat.id,bill_generate.month,bill_generate.building_id')
            ->from('tbl_flat')
            ->join('bill_generate', 'tbl_flat.id=bill_generate.flat_id')
            ->where('bill_generate.month', $dateMonth)->where('bill_generate.building_id', $building_id)->where('bill_generate.flat_id', $flat_id)
            ->group_by('bill_generate.flat_id')
            ->get()->result();
        } else {
            return $this->db
            ->select('tbl_flat.flat_number,bill_generate.flat_id,bill_generate.tenant_id,tbl_flat.id,bill_generate.month,bill_generate.building_id')
            ->from('tbl_flat')
            ->join('bill_generate', 'tbl_flat.id=bill_generate.flat_id')
            ->where('bill_generate.month', $dateMonth)->where('bill_generate.building_id', $building_id)
            ->group_by('bill_generate.flat_id')
            ->get()->result();
        }
    }

    public function getAccHeadById($accounts_id)
    {
        return $this->db->select('name')->from('account_head')->where('id', $accounts_id)->get()->row();
    }
    public function getLiabilitiesId()
    {
        $temp_liabilities_id = $this->db->select('id')->from('account_head')->where('sub_head_id',2)->get()->result();
        $liabilities_id[]=0; $li=0;
        foreach($temp_liabilities_id as $liabilities){
            $liabilities_id[$li] = $liabilities->id;
            $li++;
        }
        return $liabilities_id;
    }
    public function getIncomeId()
    {
        $temp_income_id =  $this->db->select('id')->from('account_head')->where('sub_head_id',3)->get()->result();
        $income_id[]=0; $in=0;
        foreach($temp_income_id as $income){
            $income_id[$in] = $income->id;
            $in++;
        }
        return $income_id;
    }
    public function bill_payment()
    {
        $acc['heads'] = $this->getAccHead();
        $tenant_id = $this->input->post('tenant_id');
        $flat_id = $this->input->post('flatt_id');
        $building_id = $this->input->post('building_id');
        $month = $this->input->post('month');
        $month = strtotime($month);
        $month = date('m-Y', $month);
        $gross_amount = $this->input->post('total');
        $payment_date = $this->input->post('payment_date');
        $remarks = $this->input->post('remarks');
        $liabilities_id = $this->getLiabilitiesId();//id of liabilities from account_head table ex: gas bill, electrcity bill
        $income_id = $this->getIncomeId(); //id of income from account_head table ex: houserent, flat service
        // echo "<pre>";
        // print_r($this->input->post('flat_id'));exit();
        $flt_id = $this->input->post('flat_id');
        //echo "<pre>";
        //print_r($gross_amount);
        // print_r($this->input->post());exit();

        //$checkInvoiceForMonth = $this->checkInvoiceForMonth($month, $building_id, $flt_id);
        // echo "<pre>";
        // print_r($this->input->post());exit();

        // echo "<pre>";
        // print_r(count($checkInvoiceForMonth));exit();
        // $flatIsExistInInvoiceTable = (count($this->checkInvoiceForMonth($month,$building_id,29))<=0) ? true : false ;
        // var_dump($flatIsExistInInvoiceTable);exit();
        //if (count($checkInvoiceForMonth) <= 0) {
        for ($i = 0; $i < count($tenant_id); $i++) {
            $data = [
                'invoice_no' => $month . $building_id . $i,
                'tenant_id' => $tenant_id[$i],
                'flat_id' => $flat_id[$i],
                'building_id' => $building_id,
                'gross_amount' => $gross_amount[$i],
                'discount' => 0,
                'card' => 0,
                'cash' => 1,
                'created_date' => $this->getDateTime(),
                'payment_date' => $this->getDateForDB($payment_date[$i]),
                'month' => $month,
                'status' => 1,
                'remarks' => $remarks[$i],
                'ware_id' => $this->session->userdata('wire')

            ];
            //$flatIsExistInInvoiceTable = (count($this->checkInvoiceForMonth($month, $building_id, $flat_id[$i])) <= 0) ? true : false; //specific flat already pay the bill or not.
            // if ($flatIsExistInInvoiceTable) {

            //insert into tbl_invoice
            $this->db->insert('tbl_invoice', $data);
            $lastIns_id = $this->db->insert_id();

            // insert into tbl_transaction table for specific accounts_head
            foreach ($acc['heads'] as $list) {
                $acc_head_name = str_replace(' ', '', $list->name);
                $value = $this->input->post($acc_head_name);
                

                //check credit payment or debit payment where 1=debit payment, 2=credit payment
                if(in_array($list->id,$liabilities_id)){
                    if ($list->id==11) {
                        $transactionData['payment_type'] = 1;
                    }else{
                        $transactionData['payment_type'] = 2;
                    }
                }elseif (in_array($list->id,$income_id)) {
                    $transactionData['payment_type'] = 2;
                }else{
                    $transactionData['payment_type'] = 1;
                }
                $transactionData['invoice_id'] = $lastIns_id;
                $transactionData['month'] = $month;
                $transactionData['tenant_id'] = $tenant_id[$i];
                $transactionData['flat_id'] = $flat_id[$i];
                $transactionData['building_id'] = $building_id;
                $transactionData['date'] = $this->getDateForDB($payment_date[$i]);

                if ($list->id==11) {
                    $transactionData['amount'] = abs($value[$i]);
                }else{
                    $transactionData['amount'] = $value[$i];
                }

                if (in_array($list->id, $liabilities_id)) {
                    if ($list->id==11) {
                        $transactionData['debit'] = 11;
                        $transactionData['credit'] = 14;
                    }else{
                        $transactionData['debit'] = 13;
                        $transactionData['credit'] = $list->id;
                    }
                    
                } elseif (in_array($list->id, $income_id)) {
                    $transactionData['debit'] = 13;
                    $transactionData['credit'] = $list->id;
                } else {
                    $transactionData['debit'] = $list->id;
                    $transactionData['credit'] = 13;
                }
                $transactionData['ware_id'] = $this->session->userdata('wire');

                if ($transactionData['amount'] != 0) {
                    $this->db->insert('tbl_transaction', $transactionData);
                }
            }
            //}
        }
        $msg['msg'] = "Payment Received Sucessfully!";
        $msg['check'] = true;
        return $msg;
        // } else {
        //     $msg['msg'] = "Payment already Received for this month!";
        //     $msg['check'] = false;
        //     return $msg;
        // }
    }

    public function single_bill_payment()
    {
        $acc['heads'] = $this->getAccHead();
        $postData = $this->input->post();
        $myData = $postData['myData'];
        $tenant_id = $myData['tenant_id'];
        $flat_id = $myData['flatt_id'];
        $building_id = $myData['buil_id'];
        $month = $myData['monthh'];
        $gross_amount = $myData['total'];
        $payment_date = $myData['payment_date'];
        $remarks = $myData['remarks'];

        $liabilities_id = $this->getLiabilitiesId();//id of liabilities from account_head table ex: gas bill, electrcity bill
        $income_id = $this->getIncomeId(); //id of income from account_head table ex: houserent, flat service

        $nextInvoice = $this->getLastInvoiceNoBuilding($month, $building_id);

        $data = [
            'invoice_no'    => $month .$building_id. $nextInvoice,
            'tenant_id'     => $tenant_id,
            'flat_id'       => $flat_id,
            'building_id'   => $building_id,
            'gross_amount'  => $gross_amount,
            'discount'      => 0,
            'card'          => 0,
            'cash'          => 1,
            'created_date'  => $this->getDateTime(),
            'payment_date'  => $this->getDateForDB($payment_date),
            'month'         => $month,
            'status'        => 1,
            'remarks'       => $remarks,
            'ware_id'       => $this->session->userdata('wire')

        ];

        //return $data;
        // $lastIns_id = 1;
        $this->db->insert('tbl_invoice', $data);
        $lastIns_id         = $this->db->insert_id();

        foreach ($acc['heads'] as $list) {
            $acc_head_name = str_replace(' ', '', $list->name);
            if(array_key_exists($acc_head_name, $myData)){//to check if the index named of accouts is exists in the array then set the value
                $value = $myData[$acc_head_name];
            }else{
                $myData[$acc_head_name] = 0;
                $value = $myData[$acc_head_name];
            }
            
            //check credit payment or debit payment where 1=debit payment, 2=credit payment
            if(in_array($list->id,$liabilities_id)){
                if ($list->id==11) {
                    $transactionData['payment_type'] = 1;
                }else{
                    $transactionData['payment_type'] = 2;
                }
            }elseif (in_array($list->id,$income_id)) {
                $transactionData['payment_type'] = 2;
            }else{
                $transactionData['payment_type'] = 1;
            }

            
            $transactionData['invoice_id']      = $lastIns_id;
            $transactionData['month']           = $month;
            $transactionData['tenant_id']       = $tenant_id;
            $transactionData['flat_id']         = $flat_id;
            $transactionData['building_id']     = $building_id;
            $transactionData['date']            = $this->getDateForDB($payment_date);
            
            if ($list->id==11) {
                $transactionData['amount'] = abs($value);
            }else{
                $transactionData['amount'] = $value;
            }

            if (in_array($list->id, $liabilities_id)) {
                if ($list->id==11) {
                    $transactionData['debit'] = 11;
                    $transactionData['credit'] = 14;
                }else{
                    $transactionData['debit'] = 13;
                    $transactionData['credit'] = $list->id;
                }
            } elseif (in_array($list->id, $income_id)) {
                $transactionData['debit']       = 13;
                $transactionData['credit']      = $list->id;
            } else {
                $transactionData['debit']       = $list->id;
                $transactionData['credit']      = 13;
            }
            $transactionData['ware_id']         = $this->session->userdata('wire');

            if ($transactionData['amount'] != 0) {
                $this->db->insert('tbl_transaction', $transactionData);
            }
        }
        if($lastIns_id){
            $msg['msg'] = "Payment Received Sucessfully!";
            $msg['check'] = true;
            return $msg;
        }else{
            $msg['msg'] = "Payment Received failed!";
            $msg['check'] = false;
            return $msg; 
        }
        
    }

    public function getLastInvoiceNoBuilding($month, $building_id)//return incremented last value of invoice that is incremented
    {
        $lastInvoice = $this->db->query("SELECT invoice_no
            FROM tbl_invoice
            WHERE MONTH = '$month'
            AND building_id =$building_id
            ORDER BY invoice_id DESC")->row();
        $lastInvoice = $lastInvoice->invoice_no;
        //return $lastInvoice;
        $start = strlen($month)+strlen($building_id);
        $end = strlen($lastInvoice);
        $invoice_no = substr($lastInvoice, $start, $end);
        $invoice_no = (int)$invoice_no;
        return $invoice_no + 1;
    }


    public function checkInvoiceForMonth($month, $building_id, $flt_id = "")
    {
        if (is_numeric($flt_id)) {
            return $this->db
            ->select('*')
            ->from('tbl_invoice')
            ->where('month', $month)
            ->where('building_id', $building_id)
            ->where('flat_id', $flt_id)
            ->where('status', 1)
            ->where('ware_id', $this->session->userdata('wire'))
            ->get()->result();
        } else {
            return $this->db
            ->select('*')
            ->from('tbl_invoice')
            ->where('month', $month)->where('building_id', $building_id)
            ->where('status', 1)
            ->where('ware_id', $this->session->userdata('wire'))
            ->get()->result();
        }
    }

    public function checkInvoiceGenerateBillForMonth($dateMonth, $building_id, $flat_id = "")//call from payment/
    {
        // $data = [
        //     'datemonth' => $dateMonth,
        //     'building' => $building_id,
        //     'flat_id' => $flat_id
        // ];
        // return $data;
        $ware_id = $this->session->userdata('wire');
        if (is_numeric($flat_id)) {
            return $this->db->query("SELECT tbl_invoice . * , bill_generate . * , SUM( bill_generate.amount ) AS generated_total
                FROM `bill_generate`
                INNER JOIN tbl_invoice ON bill_generate.tenant_id = tbl_invoice.tenant_id
                WHERE tbl_invoice.month = '$dateMonth'
                AND tbl_invoice.building_id =$building_id
                AND tbl_invoice.flat_id = $flat_id
                AND tbl_invoice.ware_id =$ware_id
                AND tbl_invoice.status =1
                GROUP BY bill_generate.tenant_id")
            ->result();
        } else {
            return $this->db->query("SELECT tbl_invoice . * , bill_generate . * , SUM( bill_generate.amount ) AS generated_total
                FROM `bill_generate`
                INNER JOIN tbl_invoice ON bill_generate.tenant_id = tbl_invoice.tenant_id
                WHERE tbl_invoice.month = '$dateMonth'
                AND tbl_invoice.building_id =$building_id
                AND tbl_invoice.ware_id =$ware_id
                AND tbl_invoice.status =1
                GROUP BY bill_generate.tenant_id")
            ->result();


        }
    }

    public function getTransactionDetails($dateMonth, $building_id, $flat_id)
    {
        $ware_id = $this->session->userdata('wire');
        if (is_numeric($flat_id)) {
            return $this->db->query("SELECT bill_generate.flat_id as bFlat, bill_generate.bill_id, bill_generate.tenant_id as bTenant, bill_generate.month as bMonth, bill_generate.accounts_id,bill_generate.tenant_id,bill_generate.amount as bAmount,                
                tbl_transaction.flat_id as tFlat, tbl_transaction.debit,tbl_transaction.credit,tbl_transaction.tenant_id as tTenant, tbl_transaction.month as tMonth, tbl_transaction.amount as tAmount, tbl_transaction.payment_type
                FROM bill_generate
                LEFT JOIN `tbl_transaction` on tbl_transaction.tenant_id = bill_generate.tenant_id 
                AND tbl_transaction.month = bill_generate.month 
                AND bill_generate.accounts_id = (CASE 
                                                    WHEN tbl_transaction.payment_type=2
                                                        THEN tbl_transaction.credit
                                                        ELSE tbl_transaction.debit
                                                    END)
                WHERE bill_generate.month       = '$dateMonth'
                AND bill_generate.building_id   = $building_id
                AND bill_generate.flat_id       = $flat_id
                ORDER BY bill_generate.accounts_id")->result();
        } else {
            return $this->db->query("SELECT bill_generate.flat_id as bFlat, bill_generate.bill_id, bill_generate.tenant_id as bTenant, bill_generate.month as bMonth, bill_generate.accounts_id,bill_generate.tenant_id,bill_generate.amount as bAmount,                
                tbl_transaction.flat_id as tFlat, tbl_transaction.debit,tbl_transaction.credit,tbl_transaction.tenant_id as tTenant, tbl_transaction.month as tMonth, tbl_transaction.amount as tAmount, tbl_transaction.payment_type
                FROM bill_generate
                LEFT JOIN `tbl_transaction` on tbl_transaction.tenant_id = bill_generate.tenant_id 
                AND tbl_transaction.month = bill_generate.month 
                AND bill_generate.accounts_id = (CASE 
                                                    WHEN tbl_transaction.payment_type=2
                                                        THEN tbl_transaction.credit
                                                        ELSE tbl_transaction.debit
                                                    END)
                WHERE bill_generate.month       ='$dateMonth'
                AND bill_generate.building_id   =$building_id
                ORDER BY bill_generate.accounts_id")->result();
        }
    }

    

    public function getAdvTransactionTable($flat_id,$tenant_id)
    {
        //here tbl_transaction.credit = 14 is income_advance id from account_head table
        return $this->db->query("SELECT IF((SUM(adjustable_adv-IFNULL(checkAmount,0)+tenant_adv_deduct_amount)) <= 0,false,true) as canDeduct FROM(
            SELECT 
            SUM(tbl_transaction.amount) as checkAmount,tbl_tenant.adjustable_adv,tbl_tenant.tenant_adv_deduct_amount
            FROM tbl_transaction, tbl_tenant
            WHERE tbl_transaction.flat_id= $flat_id
            AND tbl_transaction.tenant_id= $tenant_id
            AND tbl_tenant.id= $tenant_id
            AND tbl_transaction.credit = 14) as t
            ")->row();
    }


    public function getPaymentType()
    {
      return $this->db->select('*')->from('account_head')->where('sub_head_id',1)->get()->result(); 
    }
    public function getExpLedger()
    {
        return $this->db->select('*')->from('account_head')->where('sub_head_id',4)->get()->result();
    }


    
    public function add_cash_bank_payment()
    {
        // $data['invoice_no'] = $this->makeExpInvoiceNo();
        $payment_date = $this->input->post('exp_date');
        
        $month = strtotime($payment_date);
        $month = date('m-Y', $month);
        $payment_date = $this->getDateForDB($payment_date);
        $invoice_no = $this->invoice_model->getLastInvoiceNoBuilding($month,0);
        $bankOrCash = $this->input->post('payType');
        $exp_ledger = $this->input->post('exp_ledger');

        $data['invoice_no']  = $month."0".$invoice_no;
        $data['tenant_id']   = 0;
        $data['flat_id']     = 0;
        $data['building_id'] = 0;
        $data['gross_amount']= $this->input->post('exp_amount');
        $data['discount']    = 0;
        if($bankOrCash == 16){ //16(account_head table bank id) for bank payment
            $data['card']        = 1;
            $data['cash']        = 0;
        }else{
            $data['card']        = 0;
            $data['cash']        = 1;
        }
        $data['created_date']= $this->getDateTime();
        $data['payment_date']= $payment_date;
        $data['month']       = $month;
        $data['status']      = 1;
        $data['remarks']     = $this->input->post('nots');
        $data['ware_id']     = $this->session->userdata('wire');
        

        $this->db->insert('tbl_invoice', $data);
        $lastIns_id         = $this->db->insert_id();

        if(isset($lastIns_id)){
        
            $transaction['payment_type'] = 1;
            $transaction['invoice_id']   = $lastIns_id;
            $transaction['month']        = $month;
            $transaction['tenant_id']    = 0;
            $transaction['flat_id']      = 0;
            $transaction['building_id']  = 0;
            $transaction['date']         = $payment_date;
            $transaction['amount']       = $data['gross_amount'];
        
            $transaction['debit']        = $exp_ledger;
            $transaction['credit']       = $bankOrCash;
            
            $transaction['ware_id']      = $data['ware_id'];
            return $this->db->insert('tbl_transaction',$transaction);
        
        }
    }
    public function get_ledger_report($ledger,$from,$to)
    {
        $start 	= $this->payment_model->getDateForDB($from);
        $end 	= $this->payment_model->getDateForDB($to);
        $ware_id = $this->session->userdata('wire');
        if(isset($ware_id))
        {
            $data['opening'] = $this->db->query("SELECT if(ah.type = 1,debit-credit,credit-debit) as opening, ah.type,tt.* FROM account_head as ah LEFT JOIN (
            
            SELECT SUM(debit) as debit, SUM(credit) as credit FROM (
            select  SUM(amount) as debit,0 credit FROM tbl_transaction WHERE debit = $ledger AND tbl_transaction.date <= '$start' AND tbl_transaction.ware_id = $ware_id
            union
            select 0 debit,sum(amount) FROM tbl_transaction WHERE credit = $ledger AND tbl_transaction.date <= '$start' AND tbl_transaction.ware_id = $ware_id)as t
            
            ) as tt on ah.id = $ledger where ah.id = $ledger")->row();
            // return $opening;
            $data['journalList'] = $this->db->query("SELECT 
            transaction_id,date,
            0 d_id,credit as c_id,
            amount as debit_amount,0 credit_amount 
            FROM tbl_transaction where debit=$ledger 
            AND tbl_transaction.date >= '$start' AND tbl_transaction.date <= '$end' AND tbl_transaction.ware_id = $ware_id
            group by transaction_id,debit_amount
            UNION 
            SELECT transaction_id,date,
            debit as d_id,0 c_id,
            0 debit_amount,amount as credit_amount 
            FROM tbl_transaction where credit=$ledger 
            AND tbl_transaction.date >= '$start' AND tbl_transaction.date <= '$end' AND tbl_transaction.ware_id = $ware_id
            group by transaction_id,credit_amount")->result();
            return $data;
        }
    }
}