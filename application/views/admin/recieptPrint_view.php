<!DOCTYPE html>
<html lang="en">

<head>

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
    <link href="<?php echo base_url(); ?>css/colorbox.css" rel="stylesheet">

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

</head>

<body onload="start_first(<?php echo $type ?>)">

<div id="wrapper">
    <hr>
    <div class="col-md-12">

        <div class="table-responsive">
            <?php foreach ($gFlat as $flt): ?>
                <div class="col-md-6">
                    <div class="text-left col-md-6">
                        <h3>
                        <?php
                        echo $this->building_model->findBuilding($flt->building_id)->building_name;
                        ?>
                        </h3>
                    </div>
                    <div class="text-right col-md-6">
                        <p><b>Flat No: </b> <?php echo $flt->flat_number; ?></p>
                        <p><b>Tenant Name: </b><?php $tenant = $this->tenant_model->findTenant($flt->tenant_id);
                            echo $tenant->tenant_name;
                            ?>
                        </p>
                        <p><b>Month: </b> <?php echo $flt->month;?></p>
                    </div>

                    <table class="table table-bordered">
                        <tbody>

                        <?php $total=0; $gt=0; foreach($generatedBill as $gen):?>
                        <?php if ($gen->flat_id == $flt->flat_id): ?>
                        <tr>
                            <td>
                                <?php $head = $this->invoice_model->getAccHeadById($gen->accounts_id);
                                    echo $head->name;
                                ?>
                            </td>
                            <td class="text-right"><?php
                                $total += $gen->amount;
                                echo $gen->amount;?>
                            </td>
                        </tr>
                            <?php
                                $tenant_id = $gen->tenant_id;
                                $myDate = $gen->date_time;
                                $myDate = date("Y-m-d",strtotime($myDate));
                                ?>
                        <?php endif;?>

                        <?php endforeach;?>
                        <tr>
                            <td class="text-right"><b>Total:</b></td>
                            <td class="text-right"><?= $total;?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>Previous Due:</b></td>
                            <td class="text-right">
                                <?php
                                $previous_due = $this->duelist_model->get_previousDue($tenant_id,$myDate);
                                $gt = $previous_due + $total;
                                echo $previous_due;
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <td class="text-right"><b>Grand Total:</b></td>
                            <td class="text-right">
                                <?php echo $gt;?>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <p>Signature:_________________</p>
                </div>
            <?php endforeach; ?>
            <?php
//            echo "<pre>";
//                        print_r($generatedBill);
//                        print_r($gFlat);
            ?>
        </div>
    </div>
    <script>

        window.onload = function () {

            window.print();

            parent.jQuery.colorbox.close();
        }
    </script>


