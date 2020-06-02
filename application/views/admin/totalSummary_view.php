<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Total Summary</h3>
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

                        <div class="row" style="margin-top:5px;">
                            <label class="col-sm-1 control-label">Start</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control datepicker starttD" name="start"/>
                            </div>
                            <label class="col-sm-1 control-label">End</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control datepicker endtD" name="end"/>
                            </div>

                        </div>
                        <div class="row" style="margin-top:5px; text-align: left;">
                            <label class="col-sm-3 control-label"></label>
                            <button type="button" class="btn  btn-primary summary-submit">Submit</button>
                        </div>
                        <div class="form-group load_summaryContent">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url();?>js/custom/mySummary.js"></script>
    </div>
</div>


