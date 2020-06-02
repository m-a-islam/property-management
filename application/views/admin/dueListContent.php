<hr>
<div class="col-md-12">
    <div class="table-responsive" id="printMe">
        <?php if (count($transactionList)): ?>
        <table border="3" class="table table-bordered table-bordered table-condensed" >
            <thead>
                <th>Flat</th>
                <th>Previous Due</th>
                <th>Generated Amount</th>
                <th>Paid Amount</th>
                <th>Current Due</th>
                <th>Total Due</th>
                <th>Details</th>
            </thead>
            <tbody>
            <?php foreach ($transactionList as $trans):?>

            <tr>
                <td>
                    <?php
                    //$flat = $this->flat_model->findFlat($trans->flat_id);
                    echo $trans->flat_number;
                    ?>
                </td>

                <td>
                    <?php
                        $previous_due  = $this->duelist_model->get_previousDue($trans->tenant_id,$start);
                        echo $previous_due;
                    ?>
                </td>

                <?php foreach ($generatedList as $generated):?>
                <?php if ($generated->flat_id==$trans->flat_id):?>
                    <td><?= $generated->generated_total;?></td>
                    <td><?= $trans->paid_total;?></td>
                    <td><?= ($generated->generated_total - $trans->paid_total); ?></td>
                    <td><?= ($generated->generated_total - $trans->paid_total)+$previous_due?></td>
                    <td>
                        <a href="#" flat-id="<?= $trans->flat_id?>"
                           buildd-id="<?= $trans->building_id;?>"
                           ware-id="<?= $trans->ware_id;?>"
                           frm-date="<?= $start;?>"
                           t-date="<?= $end;?>"
                           total-generated="<?=$generated->generated_total;?>"
                           total-paid="<?=$trans->paid_total;?>"
                           pre-due="<?=$previous_due;?>"
                           class="forDueDetails">
                            <i style="font-size: 25px;" class="fa fa-credit-card"></i>
                        </a>
                    </td>
                <?php endif;?>
                <?php endforeach;?>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>

<!--  due details modal start      -->
        <div class="modal fade" id="dueDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                                        <div class="col-md-6" id="generatedDetails">

                                        </div>
                                        <div class="col-md-6" id="transactionDetails">

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

<!--  due details modal end      -->
        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url(); ?>js/custom/myDueListContent.js"></script>
    </div>
    <div style="text-align: center;"><button onclick="printDiv('printMe')"><i class="fa fa-print" aria-hidden="true"></i>Print </button> </div>
    <?php
/*
    echo "<pre>";
    print_r($generatedList);
    echo "invoice";
    print_r($transactionList);*/
    ?>
    <?php else: ?>
        <div><p style="color: red">No transaction found within this date.</p></div>
    <?php endif; ?>
</div>
<hr>