<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Collection Report</h1>
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
            <div class="col-md-12">
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
                        <div class="row">
                            <label class="col-sm-1 control-label">Building</label>
                            <div class="col-sm-4">
                                <select name="building_id" class="form-control" id="build_id">
                                    <option value="">--Select Building--</option>
                                    <?php foreach ($buildingList as $building):?>
                                        <option value="<?= $building->id ?>"><?= $building->building_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label class="col-sm-1 control-label">Flat</label>
                            <div class="col-sm-4">
                                <select name="flat_id" class="form-control" id="flat_id">
                                    <option value="">--Select Building First--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <label class="col-sm-1 control-label">Start</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control datepicker startD" name="start"/>
                            </div>
                            <label class="col-sm-1 control-label">End</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control datepicker endD" name="end"/>
                            </div>

                        </div>
                        <div class="row" style="margin-top:5px; text-align: left;">
                            <label class="col-sm-3 control-label"></label>
                            <button type="button" class="btn  btn-primary collection-report-submit">Submit</button>
                        </div>
                        <div class="form-group load_collectionReportContent">

                        </div>
                        <div id="modals">

                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" style="margin-top:15%;">

                            <img style="display:none;" class="img" src="<?php echo base_url(); ?>css/715.gif"
                                 title="Loading........"/>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url();?>js/custom/collectionReport.js"></script>
    </div>
</div>


