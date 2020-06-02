<hr>
<div class="col-md-12">
    <?php if (count($generatedBill)):?>
    <div class="table-responsive">
<!--        <iframe id="myFrame" src='' style="height:380px;width:100%;display: none;"></iframe>-->
        <button id="printBtn" buildin-id="<?= $buildId?>" date-mnth="<?= $dateMonth?>" type="button" class="btn btn-primary hidden-print">
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
        <table id="GenRepView" class="table table-bordered table-bordered table-condensed">
            <thead>
            <th>Flat</th>
            <?php foreach ($heads as $head): ?>
                <?php foreach ($gHead as $g): ?>
                    <?php if ($head->id == $g->accounts_id): ?>
                        <th><?= $head->name ?></th>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <th>Total</th>
            </thead>
            <tbody>

            <?php foreach ($gFlat as $flt): ?>
                <tr>
                    <td><?php echo $flt->flat_number; ?></td>
                    <?php $total = 0;?>
                    <?php foreach ($generatedBill as $gBill): ?>

                        <?php if ($gBill->flat_id == $flt->flat_id): ?>
                            <td>
                                <?php
                                $total += $gBill->amount;
                                   echo $gBill->amount;
                                ?>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td><?= $total;?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div><p style="color: red">No Generated Bills in this month.</p></div>
    <?php endif; ?>
    <?php
    /*
    echo "<pre>";
    print_r($generatedBill);
    */
    ?>
</div>
<script>
    $('#printBtn').on('click',function () {
        // var prtContent = document.table;
        // var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        // WinPrint.document.write(prtContent.innerHTML);
        // WinPrint.document.close();
        // WinPrint.focus();
        // WinPrint.print();
        // WinPrint.close();


        // var iframe = document.getElementById("myFrame");
        //
        // iframe.style.display = iframe.style.display === 'none' ? '' : 'none';

        var building_id = $(this).attr('buildin-id');
        var dateMonth = $(this).attr('date-mnth');
       // alert(building_id);
        //alert(dateMonth);

        $.colorbox({height:'750px',width:'1000px',href:decodeURI('<?= base_url();?>payment/recieptPrint/'+building_id+'/'+dateMonth),iframe:true});

        //var prtContent = $.colorbox({height:'750px',width:'1000px',href:'<?//= base_url();?>//payment/recieptPrint/{1}',iframe:true});
        //var WinPrint = window.open(prtContent, '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        //
        //WinPrint.document.write(prtContent.innerHTML);
        //WinPrint.document.close();
        //WinPrint.focus();
        //WinPrint.print();
        //WinPrint.close();

        //var elmnt = iframe.contentWindow.document.getElementsByTagName("H1")[0];
        //elmnt.style.display = "none";

        //console.log(generated);
        //alert(generated);
        //window.print();

    });
</script>
