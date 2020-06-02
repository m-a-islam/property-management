<hr>
<div class="col-md-12">
    <div class="table-responsive">
        <?php if (count($generatedBill)): ?>
        <?php
        $checkTransaction = array();
        foreach ($transactionData as $td){
            if(isset($td->tFlat)){
                array_push($checkTransaction,true);
            }else{
                array_push($checkTransaction,false);
            }
        }
        ?>
        <?php if (in_array(true,$checkTransaction)): ?>
            <!--        if already pay one time then individual pay will work with due amount-->

            <table border="3" class="table table-bordered table-bordered table-condensed">
                <thead>
                <!--<th>Flat</th>-->
                <!--<?php //foreach ($gHead as $gh): ?>-->
                <!--    <th>-->
                <!--        <?php //$head = $this->payment_model->getAccHeadById($gh->accounts_id); ?>-->
                <!--        <?php// echo $head->name; ?>-->
                <!--    </th>-->
                <!--<?php //endforeach; ?>-->
                <!--<th>Advance Adjust(Last Month)</th>-->
                <!--<th>Total</th>-->
                <!--<th>Payment Date</th>-->
                <!--<th>Remarks</th>-->
                <!--<th>Action</th>-->
                </thead>
                <tbody>
                <?php foreach ($gFlat as $flt): ?>

                    <tr id="<?= $flt->id . 'row'; ?>">

                        <td data-toggle="tooltip" data-placement="top" title="Flat Number!">
                            <div style="overflow: auto; width: 50px;">
                                <?= $flt->flat_number; ?>
                                <p style="color:blue;"><small>Flat no.</small></p>
                                <input type="hidden" class="form-control" name="flatt_id[]" value="<?= $flt->id ?>">
                                <input type="hidden" class="form-control" name="tenant_id[]"
                                       value="<?= $flt->tenant_id ?>">
                                <input type="hidden" class="form-control" name="buil_id"
                                       value="<?= $flt->building_id ?>">
                                <input type="hidden" class="form-control" name="monthh" value="<?= $flt->month ?>">
                            </div>
                        </td>
                        <?php $total = 0; ?>
                        <?php foreach ($transactionData as $tBill): ?>
                            <?php if ($tBill->bFlat==$flt->flat_id):?>
                                <?php $head = $this->payment_model->getAccHeadById($tBill->accounts_id); ?>
                                <td  data-toggle="tooltip" data-placement="top" title="<?= $head->name;?>">
                                    
                                    <div style="overflow: auto;width: 70px;">
                                        <input type="text" name="<?= str_replace(' ', '', $head->name) . '[]'; ?>"
                                               onkeyup="calTotalBill('<?php echo $flt->flat_id ?>')"
                                               onkeypress="return isNumberKey(event)"
                                               value="<?php
                                               if ($tBill->payment_type == 1 && $tBill->credit == 14){
                                                   $val = $tBill->bAmount + $tBill->tAmount;
                                               }else {
                                                   $val = $tBill->bAmount - $tBill->tAmount;
                                               }
                                               echo $val; ?>"
                                               class="form-control <?php echo $flt->flat_id . "list"; ?>">
                                               <p style="color:blue;"><small><?= $head->name; ?></small></p>
                                    </div>
                                    <?php $total += $val; ?>
                                </td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <td data-toggle="tooltip" data-placement="top" title="Advance Adjust(Last Month)">
                            <div style="overflow: auto;width: 70px;">
                                <input type="text" name="<?= 'Advance' . '[]'; ?>"
                                       onkeyup="calTotalBill('<?php echo $flt->flat_id ?>')"
                                       onkeypress="return isNumberKey(event)"
                                       value=""
                                       class="form-control <?php echo $flt->flat_id . "list"; ?>">
                                       <p style="color:blue;"><small>Advance Adjust(Last Month)</small></p>
                            </div>
                        </td>
                        <td data-toggle="tooltip" data-placement="top" title="Total">
                            <div style="overflow: auto;width: 70px;">
                                <input type="text" onkeyup="calTotalBill('<?php echo $flt->flat_id ?>')" name="total[]"
                                       value="<?php echo $total; ?>" class="form-control <?= $flt->flat_id . "total"; ?>">
                                       <p style="color:blue;"><small>Total</small></p>
                            </div>
                        </td>
                        <td data-toggle="tooltip" data-placement="top" title="Payment Date">
                            <div style="overflow: auto;width: 70px;">
                                <input type="text" value="" name="payment_date[]" required
                                       class="form-control datepicker">
                                    <p style="color:blue;"><small>Payment Date</small></p>
                            </div>
                        </td>
                        <td data-toggle="tooltip" data-placement="top" title="Remarks">
                            <div style="overflow: auto;width: 70px;">
                                <textarea name="remarks[]" value="" cols="100" class="form-control"></textarea>
                                <p style="color:blue;"><small>Remarks</small></p>
                            </div>
                        </td>
                        <td data-toggle="tooltip" data-placement="top" title="Pay">
                            <div style="overflow: auto;width: 70px;">
                                <input type="button" value="Pay" name="pay[]"
                                       onclick="payRent(<?= $flt->id ?>)" class="btn btn-info payBtn">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </form>
        <?php else: ?>
        <!--    else as it is not pay previously then it can pay all generated amount at a time using button "Bill Payment"    -->
        <table border="3" class="table table-bordered table-bordered table-condensed">
            <thead>
            <!--<th>Flat</th>-->

            <!--<?php //foreach ($gHead as $gh): ?>-->
            <!--    <th>-->
            <!--        <?php //$head = $this->payment_model->getAccHeadById($gh->accounts_id); ?>-->
            <!--        <?php //echo $head->name; ?>-->
            <!--    </th>-->

            <!--<?php //endforeach; ?>-->
            <!--<th>Advance Adjust(Last Month)</th>-->
            <!--<th>Total</th>-->
            <!--<th>Payment Date</th>-->
            <!--<th>Remarks</th>-->
            <!--<th>Action</th>-->
            </thead>
            <tbody>
            <?php foreach ($gFlat as $flt): ?>
                <tr id="<?= $flt->id . 'row'; ?>">
                    <td data-toggle="tooltip" data-placement="top" title="Flat Number!">
                        <div style="overflow: auto; width: 50px;">
                            <?= $flt->flat_number; ?>
                            <p style="color:blue;"><small>Flat no.</small></p>
                            
                            <input type="hidden" class="form-control" name="flatt_id[]" value="<?= $flt->id ?>">
                            <input type="hidden" class="form-control" name="tenant_id[]" value="<?= $flt->tenant_id ?>">
                            <input type="hidden" class="form-control" name="buil_id" value="<?= $flt->building_id ?>">
                            <input type="hidden" class="form-control" name="monthh" value="<?= $flt->month ?>">
                        </div>
                    </td>
                    <?php $total = 0; ?>
                    <?php foreach ($generatedBill as $gBill): ?>

                        <?php if ($gBill->flat_id == $flt->flat_id): ?>
                        <?php $head = $this->payment_model->getAccHeadById($gBill->accounts_id); ?>
                            <td data-toggle="tooltip" data-placement="top" title="<?= $head->name;?>">
                                <div style="overflow: auto;width: 70px;">
                                    <input type="text" name="<?= str_replace(' ', '', $head->name) . '[]'; ?>"
                                           onkeyup="calTotalBill('<?php echo $flt->flat_id ?>')"
                                           onkeypress="return isNumberKey(event)" value="<?= $gBill->amount; ?>"
                                           class="form-control <?php echo $flt->flat_id . "list"; ?>">
                                           <p style="color:blue;"><small><?= $head->name?></small></p>
                                </div>
                                <?php $total += $gBill->amount; ?>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td data-toggle="tooltip" data-placement="top" title="Advance Adjust(Last Month)">
                            <div style="overflow: auto;width: 70px;">
                                <input type="text" name="<?= 'Advance' . '[]'; ?>"
                                       onkeyup="calTotalBill('<?php echo $flt->flat_id ?>')"
                                       onkeypress="return isNumberKey(event)"
                                       value=""
                                       class="form-control <?php echo $flt->flat_id . "list"; ?>">
                                       <p style="color:blue;"><small>Advance Adjust(Last Month)</small></p>
                            </div>
                           
                        </td>
                    <td data-toggle="tooltip" data-placement="top" title="Total">
                        <div style="overflow: auto;width: 70px;">
                            <input type="text" onkeyup="calTotalBill('<?php echo $flt->flat_id ?>')" name="total[]"
                                   value="<?php echo $total; ?>" class="form-control <?= $flt->flat_id . "total"; ?>">
                                   <p style="color:blue;"><small>Total</small></p>
                        </div>
                    </td>
                    <td data-toggle="tooltip" data-placement="top" title="Payment Date">
                        <div style="overflow: auto;width: 70px;">
                            <input type="text" name="payment_date[]" required class="form-control datepicker">
                            <p style="color:blue;"><small>Payment Date</small></p>
                        </div>
                    </td>
                    <td data-toggle="tooltip" data-placement="top" title="Remarks">
                        <div style="overflow: auto;width: 70px;">
                            <textarea name="remarks[]" cols="100" class="form-control"></textarea>
                            <p style="color:blue;"><small>Remarks</small></p>
                        </div>
                    </td>
                    <td data-toggle="tooltip" data-placement="top" title="Pay">
                        <div style="overflow: auto;width: 70px;">
                            <input type="button" value="Pay" name="pay[]"
                                   onclick="payRent(<?= $flt->id ?>)" class="btn btn-info payBtn">
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div align="center">
            <input type="submit" class="btn btn-success" onclick="return confirm('Sure to pay bill all at a time?')" value="Bill Payment">
        </div>
        </form>
    </div>
    <?php endif; ?>
    <?php else: ?>
        <div><p style="color: red">No Generated Bills in this month.</p></div>
    <?php endif; ?>
    <?php

/*
    echo "<pre>";
    //print_r($generatedBill);
    echo "trans";
    print_r($transactionData);
    foreach ($transactionData as $td){
        if(isset($td->tFlat)){
            echo "\n yes";
        }else{
            echo "\n no";
        }
    }
*/

    ?>
</div>
<script>
    $(document).on("focus", ".datepicker", function () {
        $(this).datepicker({dateFormat: 'dd-mm-yy'});
    });

    /* $('.payBtn').on('click',function () {
         //alert("Hello");
         var tt = $(this).attr('row-id');
         //$('#transactionTable tr#tt acchead')
        var id = $('input[type=text].#transactionTable tr#tt .acchead');
         for(var i = 0;i<=id.length;i++){
             console.log(id[i].value);
         }
        // console.log($('#transactionTable tr#tt'));
        // console.log($("#transactionTable tr#tt"));
        //
        //  $('#transactionTable tr#tt input').each(function() {
        //      var inputName = "";
        //      var values = "";
        //      inputName = inputName +","+ $(this).attr("name");
        //     #transactionTable tr#tt values =  values + "," + $(this).val()
        //      console.log(values);
        //  });


         //console.log(document.querySelector('input').value);

     });*/

    function payRent(id) { // this function is for single payment
        var conf = confirm("Are you sure to pay?");
        //alert(conf);
        if (conf === true) {
            //alert("Confirmed");
            var myData = {};
            var id = id + "row";
            $('#' + id + ' input').each(function () {
                var name = $(this).attr('name');//if there is [] in the post or input it throws exception of disallowed characters
                name = name.replace('[]', '');
                myData[name] = $(this).val();
            });
            $('#' + id + ' textarea').each(function () {
                var name = $(this).attr('name');
                name = name.replace('[]', '');
                myData[name] = $(this).val();
            });
            //console.log(myData);
            console.log("send data ends");
            if (myData.total > 0) {
                if (myData.payment_date != "") {
                    $.ajax({ //ajax for single bill payment
                        type: 'POST',
                        dataType: 'json',
                        url: li + 'payment/single_bill_payment',
                        data: {
                            myData: myData
                        },
                        success: function (dataT) {
                            console.log(dataT);
                            //alert(dataT);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            //alert("Server Error");
                            if (jqXHR.status === 0) {
                                alert('Not connect.\n Verify Network.');
                            } else if (jqXHR.status == 404) {
                                alert('Requested page not found.');
                            } else if (jqXHR.status == 500) {
                                alert('Internal Server Error.');
                            } else if (errorThrown === 'parsererror') {
                                alert('Requested JSON parse failed');
                            } else if (errorThrown === 'timeout') {
                                alert('Time out error');
                            } else if (errorThrown === 'abort') {
                                alert('Ajax request aborted ');
                            } else {
                                alert('Uncaught Error.\n' + jqXHR.responseText);
                            }

                        }
                    });

                    $('#' + id + ' :input[type=button]').attr('disabled', true);
                } else {
                    alert("Please select payment date!");
                }
            }
        }
    }
</script>
