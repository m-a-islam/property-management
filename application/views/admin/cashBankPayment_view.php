<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cash/Bank Payment</h1>
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
        <form id="" method="post" action="#" class="form-horizontal"
              enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-xs-2 control-label" for="payType" style="font-size: smaller">Payment Type</label>
                <div class="col-xs-6">
                    <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true" id="payType" required name="payType">
                        <option value="">-- Select Payment Type --</option>
                        <?php foreach ($payment_type as $payType): ?>
                            <option value="<?= $payType->id; ?>">
                                <?= $payType->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-xs-5 messageContainer"></div>
            </div>

            <div class="form-group">
                <label class="col-xs-2 control-label" for="exp_ledger" style="font-size: smaller">Pay For</label>
                <div class="col-xs-6">
                    <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true" id="exp_ledger" required name="exp_ledger">
                        <option value="">-- Select Payment for --</option>
                        <option value="16">Bank</option>
                        <?php foreach ($expLedger as $exp): ?>
                            <option value="<?= $exp->id; ?>">
                                <?= $exp->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-xs-5 messageContainer"></div>
            </div>

            <div class="form-group">
                <label class="col-xs-2 control-label" style="font-size: smaller">Amount</label>
                <div class="col-xs-6">
                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="exp_amount" name="exp_amount"/>
                </div>
                <div class="col-xs-5 messageContainer"></div>
            </div>



            <div class="form-group">
                <label class="col-xs-2 control-label" style="font-size: smaller">Date</label>
                <div class="col-xs-6">
                    <input type="text" class="form-control datepicker" id="exp_date"  name="exp_date"/>
                </div>
                <div class="col-xs-5 messageContainer"></div>
            </div>



            <div class="form-group">
                <label class="col-xs-2 control-label" style="font-size: smaller">Notes</label>
                <div class="col-xs-6">
                    <textarea class="form-control" name="notes" id="nots" cols="30" rows="5"></textarea>

                </div>
                <div class="col-xs-5 messageContainer"></div>
            </div>

            <div class="form-group">
                <div class="col-xs-9 col-xs-offset-2">
                    <button type="button" id="cash_bank_pay" class="btn btn-primary" style="font-size: smaller">Submit</button>
                </div>
            </div>
        </form>
        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url(); ?>js/custom/payment.js"></script>
    </div>

    <?php


    ?>
</div>
