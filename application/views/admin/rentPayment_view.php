<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Rent Generate</h1>
            </div>
        </div>
        <?php if ($feedback = $this->session->flashdata('feedback')):
            $feedback_class = $this->session->flashdata('feedback_class');
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-dismissible <?= $feedback_class; ?>">
                        <?= $feedback; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default panel-shadow" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"></div>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">

                            </div>
                        </div>
                        <form action="<?= base_url('payment/bill_generate')?>" method="post">

                        <div class="row">
                            <label class="col-sm-3 control-label">Building</label>
                            <div class="col-sm-4">
                                <select name="building_id" class="form-control" id="build_id">
                                    <option value="">--Select Building--</option>
                                    <?php foreach ($buildingList as $building):?>
                                    <option value="<?= $building->id ?>"><?= $building->building_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
<!--                            <div class="col-sm-5">-->
<!--                                <select name="flat_id" class="form-control" id="flat_id">-->
<!--                                    <option value="">--Select Building First--</option>-->
<!--                                </select>-->
<!--                            </div>-->
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <label class="col-sm-3 control-label">Month</label>
                            <div class="col-sm-4">

                                <input type="text" class="form-control datepickerMonth" name="month"/>

                            </div>
                            <div class="col-sm-5"></div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <label class="col-sm-3 control-label"></label>
                            <button type="button" class="btn  btn-primary rent-receipt-submit">Submit</button>
                        </div>
                        <div class="form-group load_payContent">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url();?>js/custom/payment.js"></script>
    </div>
</div>


