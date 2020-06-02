<hr>
<div class="col-md-12">
    <div class="table-responsive">
        <?php if (count($invoiceList)): ?>
        <table border="3" class="table table-bordered table-bordered">
            <thead>
                <th>Sl#</th>
                <th>Invoice No.</th>
                <th>Flat No.</th>
                <th>Tenant Name</th>
                <!--            <th>Payment Status</th>-->
                <th>Payment Date</th>
                <th>Amount Paid</th>
                <th>Option</th>
            </thead>
            <tbody>
            <?php $i=0; foreach ($invoiceList as $invoice): ?>
                <tr id="<?php echo 'delete'.$invoice->invoice_id;?>">
                    <td><?= ++$i;?></td>
                    <td>
                        <?= $invoice->invoice_no ?>
                    </td>
                    <td>
                        <?php
                        $flat = $this->flat_model->findFlat($invoice->flat_id);
                        echo $flat->flat_number;
                        ?>
                    </td>
                    <td>
                        <?php
                        $tenant = $this->tenant_model->findTenant($invoice->tenant_id);
                        echo $tenant->tenant_name;
                        ?>
                    </td>

                    <td><?php
                        echo date("d-m-Y", strtotime($invoice->payment_date));
                        ?>
                    </td>
                    <td><?php echo $invoice->gross_amount; ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-block dropdown-toggle" type="button" data-toggle="dropdown">Action
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href='<?= base_url("invoice_controller/view_invoice/{$invoice->invoice_id}") ?>'
                                       target="_blank"><i class="fa fa-credit-card"></i> View Invoice</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#" building-id="<?= $invoice->building_id ?>"
                                       invoice-id="<?= $invoice->invoice_id ?>" class="forEditPayment"><i
                                                class="fa fa-edit"></i> Edit </a>
                                </li>

                                <li>
                                    <a href="#" invoice-id="<?= $invoice->invoice_id ?>" class="forDeletePayment"><i class="fa fa-trash-o"></i> Delete </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <!--        Take payment  modal start-->
        <div class="modal fade" id="takePayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                                    class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-shadow" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title">Take Payment</div>
                                    </div>
                                    <div class="panel-body">

                                        <div id="">

                                        </div>
                                        <div class="form-group">

                                            <label class='col-sm-3 control-label' style='margin: 5px 0;'>Payment
                                                Date</label>
                                            <div class='col-sm-9'>
                                                <input type="text" style="margin: 5px 0;" name="payment_date"
                                                       required class="form-control datepicker">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label class='col-sm-3 control-label' style='margin: 5px 0;'>Payment
                                                Date</label>
                                            <div class='col-sm-9'>
                                                    <textarea name="remarks" style="margin: 5px 0;" cols="30" rows="10"
                                                              class="form-control datepicker"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <input type="submit" value="Take payment" class="btn btn-info">
                                            </div>
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
        <!--        Take Payment modal end  -->

        <!--        Edit payment start-->
        <div class="modal fade" id="editPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                                    class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-shadow" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title">Edit Payment</div>
                                    </div>
                                    <div class="panel-body">
                                        <div id="allReceivedField">

                                        </div>
                                        <div class="col-md-12 restField">

                                            <div class="form-group">

                                                <label class='col-sm-3 control-label'
                                                       style='margin: 5px 0;'>Remarks</label>
                                                <div class='col-sm-8'>
                                                    <textarea name="remarks" style="margin: 5px 0;" cols="20" rows="10"
                                                              class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="submit" name="update" id="updatePayment" value="Update payment"
                                                           class="btn btn-info">
                                                </div>
                                            </div>
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
        <!--        Edit payment End-->
        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url(); ?>js/custom/myRentReceiveReportContent.js"></script>

    </div>
    <?php else: ?>
        <div><p style="color: red">No Invoice found for this month.</p></div>
    <?php endif; ?>
</div>
