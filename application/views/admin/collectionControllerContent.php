<hr>
<div class="col-md-12">
    <?php if (count($transaction)): ?>
        <div><button onclick="printDiv('printMe')"><i class="fa fa-print" aria-hidden="true"></i>Print </button> </div>
    <div class="table-responsive" id="printMe">

        <table border="3" class="table table-bordered table-bordered table-condensed">
            <thead>
                <th>Date</th>
                <th>Tenant Name</th>
                <th>Flat</th>
                <th>Transaction Amount</th>
                <th>Details</th>
            </thead>
            <tbody>
            <?php $grandTotal = 0;foreach ($transaction as $trans):?>
                <tr>
                    <td><?= date("d-m-Y", strtotime($trans->date));?></td>
                    <td><?= $trans->tenant_name;?></td>
                    <td><?= $trans->flat_number;?></td>
                    <td><?php
                        $grandTotal += $trans->paid_total;
                        echo $trans->paid_total;
                    ?>
                    </td>
                    <td>
                        <a href="#" flat-id="<?= $trans->flat_id?>"
                           buildd-id="<?= $trans->building_id;?>"
                           ware-id="<?= $trans->ware_id;?>"
                           frm-date="<?= $start;?>"
                           t-date="<?= $end;?>"
                           total-paid="<?=$trans->paid_total;?>"
                           class="forCollectionDetails">
                            <i style="font-size: 25px;" class="fa fa-credit-card"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="3"><b>Total</b></td>
                <td colspan="2"><b><?=$grandTotal?></b></td>
            </tr>
            </tbody>
        </table>

        <!--  transaction details modal start      -->
        <div class="modal fade" id="collectionDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="height: 80%;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                                    class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" style="max-height: calc(100% - 120px); overflow-y: scroll;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-shadow" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title"> Start: <u><b><?php echo $start;?></b></u> End: <u><b><?php echo $end;?></b></u> </div>
                                    </div>
                                    <div class="panel-body">

                                        <div class="col-md-12" id="transactionDetails">

                                        </div>
                                        <div class="col-md-12" id="summary">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--  transaction details modal end      -->

        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url(); ?>js/custom/myCollectionReportContent.js"></script>
    </div>

    <?php
    /*
    echo "<pre>";
    print_r($transaction);*/
    ?>
    <?php else: ?>
        <div><p style="color: red">No transaction found within this date.</p></div>
    <?php endif; ?>
</div>
<hr>