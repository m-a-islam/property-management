<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Ledger View</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default panel-shadow" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title"></div>
                    </div>
                    <div class="panel-body">

                        <div class="form-group" style="margin-top:5px;">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <label class="col-sm-2 control-label">Ledger</label>
                            <div class="col-sm-10" style="margin-top:5px;">
                                <select class="form-control selectpicker" id="ledger"  name="ledger" data-show-subtext="true" data-live-search="true">
                                    <option value="">-- Select  Ledger --</option>
                                    <?php foreach($ledgerList as $ledger):?>
                                        <option value="<?= $ledger->id?>">
                                            <?= $ledger->name;?>
                                        </option>
                                    <?php endforeach;?>
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
                   
                        <div class="row" style="margin-top:5px; text-align: left;">
                            <label class="col-sm-3 control-label"></label>
                            <button type="button" class="btn  btn-primary expense-submit">Submit</button>
                        </div>
                        <div class="form-group load_expenseContent">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url();?>js/custom/payment.js"></script>
    </div>
</div>


