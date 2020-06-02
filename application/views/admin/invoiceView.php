<!DOCTYPE html>
<html lang="en">

<head id="headd">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Houserent Management</title>

    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic'
          rel='stylesheet' type='text/css'>

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url(); ?>css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url(); ?>css/morris.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/test.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>css/tcal.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/jquery.autocomplete.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>css/jquery-ui.css" rel="stylesheet" type="text/css">
    <!--    datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!--    select2 tools-->
    <!--    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />-->
    <!--    <link rel="stylesheet" type="text/css" href="select2-bootstrap.css">-->
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
    <style>
        .ui-#datepickerMonth-calendar {
            display: none;
        }
    </style>
    <style>
        @import url(http://fonts.googleapis.com/css?family=Bree+Serif);

        body, h1, h2, h3, h4, h5, h6 {
            font-family: 'Bree Serif', serif;
        }
    </style>


</head>

<body onload="start_first(<?php echo $type ?>)">

<div id="wrapper">
    <div class="container">
        <div class="row" id="printMe">
            <div class="col-xs-6">
<!--
                <h1>
                    <a href="#">
                        Logo here
                    </a>
                </h1>
 -->
            </div>
            <div class="col-xs-6 text-right">
                INVOICE
                <small>Date: <?= date("d-m-Y", strtotime($invoiceDetails->payment_date)) ?></small>
                Invoice Number: <?= $invoiceDetails->invoice_no ?>
            </div>
            <hr>
            <!--client details section start-->
            <div class="row">
                <div class="col-xs-5 col-xs-offset-2 text-right" style="float: right">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            To : <a href="#"><?php
                                $tenant = $this->tenant_model->findTenant($invoiceDetails->tenant_id);
                                $flat = $this->flat_model->findFlat($invoiceDetails->flat_id);
                                $building = $this->building_model->findBuilding($invoiceDetails->building_id);
                                echo $tenant->tenant_name;
                                ?>
                            </a>
                        </div>
                        <div class="panel-body" style="height: 80%;padding:1%">
                            Building Name: <a style="color: #0000FF"><?= $building->building_name; ?></a><br>
                            Flat Name: <a style="color: #0000FF"><?= $flat->flat_number; ?></a><br>
                            Address: <a style="color: #0000FF"><?= $tenant->tenant_address; ?></a><br>
                            Mobile: <a style="color: #0000FF"><?= $tenant->tenant_number; ?></a><br>
                        </div>
                    </div>
                </div>
            </div> <!-- / end client details section -->

            <!--        Job/project details Section start-->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th><h4>Date</h4></th>
                    <th><h4>Services</h4></th>
                    <th class="text-right">
                        <h4>Rate/Price
                            <small>(৳)</small>
                        </h4>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php //$total = 0;
                foreach ($transDetailsByInvoiceId as $trans): ?>
                    <tr>
                        <td><?= date("d-m-Y", strtotime($trans->date)); ?></td>
                        <td><?php
                            $head = $this->invoice_model->getAccHeadById($trans->credit);
                            echo $head->name;
                            ?>
                        </td>
                        <td class="text-right">
                            <?php
                            //                            $total += $trans->amount;
                            if($trans->credit==14){
                                echo "-";
                            }
                            echo $trans->amount;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!--        Job/project details Section end-->


            <!--        Total amount section start -->
            <div class="row text-right">
                <div class="col-xs-2 col-xs-offset-8">
                    <p>

                            <u>Total :</u> <br>

                    </p>
                </div>
                <div class="col-xs-2">

                        <?= $invoiceDetails->gross_amount; ?> <br>

                </div>
            </div>
            <!--        Total amount section end-->

            <!--        payment section start-->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Received By: ______________________________
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div style="text-align: center;"><button onclick="printDiv('printMe')"><i class="fa fa-print" aria-hidden="true"></i>Print </button> </div>
    </div>
</div>
<script>
    function printDiv(divName){
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url(); ?>js/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url(); ?>js/raphael-min.js"></script>


<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url(); ?>js/sb-admin-2.js"></script>


<script src="<?php echo base_url(); ?>js/custom/test.js"></script>
<script>
    $(document).ready(function () {
        $('#example,#example1').DataTable();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<!--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
</body>

</html>


