<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Yearly Statement</h3>
            </div>
        </div>
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
                            <label class="col-sm-2 control-label">Building</label>
                            <div class="col-sm-10">
                                <select name="building_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" id="build_id">
                                    <option value="">-- Select Building --</option>
                                    <?php foreach ($buildingList as $building):?>
                                    <option value="<?= $building->id ?>"><?= $building->building_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Start</label>
                            <div class="col-sm-4" style="margin-top:5px;">
                                <input type="text" class="form-control datepicker starttD" name="start"/>
                            </div>
                            <label class="col-sm-2 control-label">End</label>
                            <div class="col-sm-4" style="margin-top:5px;">
                                <input type="text" class="form-control datepicker endtD" name="end"/>
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <label class="col-sm-3 control-label"></label>
                            <button type="button" class="btn  btn-primary yearlyStatementSheet-submit">Submit</button>
                        </div>
                        <div class="form-group load_yearlySheetContent">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url();?>js/custom/agreementSheet.js"></script>
    </div>
</div>


