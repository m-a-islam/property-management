<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="col-lg-6">
                    <h1 class="page-header">Setting Accounts</h1>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?php

                    if (!empty($setting)) {

                        ?>
                        <a href="<?php echo base_url(); ?>admin/create_new"
                           style="color:red"><strong><?php echo $setting ?></strong></a>

                        <?php
                    } ?> <span id="sub"></span>
                </header>

                <div class="panel-body" style="padding: 15px;
min-height: 500px;
overflow: auto;">


                    <div class="row" style="margin-bottom:15px;margin-right: -6px;">
                        <div id="cLedger" class="modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Create Ledger</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row r_padding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ledger</label>
                                                <div class="col-sm-6">
                                                    <input type="text" id="ac_head_name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row r_padding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"></label>
                                                <div class="col-sm-6">
                                                    <button id="ledger_submit" class="btn btn-success">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row" id="re">

                        <?php $i = 1;
                        foreach ($head as $val): ?>
                            <div class="row">

                                <div class="col-sm-3" id="<?php echo $val['id'] . "s" ?>">

                                    <label onclick="parent_change(<?php echo $val['id'] ?>,'<?php echo $val['name'] ?>')"
                                           style="font-size:20px;text-align:right;" class="col-sm-3 control-label">

                                        <?php echo $i ?>)<?php echo $val['name'] ?>

                                    </label>
                                </div>
                            </div>
                            <?php $i++; endforeach; ?>
                    </div>
                    <div class="row col-md-12" id="pp" style="display:none">
                        <p id="myLedger"></p>
                    </div>
                    <div id="modals">

                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" style="margin-top:15%;">

                            <img style="display:none;" class="img" src="<?php echo base_url(); ?>css/715.gif"
                                 title="Loading........"/>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
            </section>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
    <script src="<?= base_url(); ?>js/custom/myAccount.js"></script>
</div>





