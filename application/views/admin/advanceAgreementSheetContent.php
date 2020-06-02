<hr>
<div class="col-md-12">
    <div  class="table-responsive">
        <?php if(count($advanceList)):?>
            <div class="form-group" style="margin: 5px;">
                <button class="print-me fa fa-print btn btn-primary btn-lg">Print</button>
            </div>
            <div id="printTable">
                <div class="form-group" style="text-align: center; font-size:25px; font-family:Arial, sans-serif; font-weight:bold; margin: 0px">
                    <p>Advance Sheet</p>
                </div>
                <style type="text/css">
                .tg  {border-collapse:collapse;border-spacing:0;}
                .tg td{font-family:Arial, sans-serif;font-size:14px;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:gray;}
                .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:gray;}
                .tg .tg-a2cf{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;text-align:center;vertical-align:top}
                .tg .tg-baqh{text-align:center;vertical-align:top}
                .tg .tg-lqy6{text-align:right;vertical-align:top}
                .tg .tg-p8bj{font-weight:bold;border-color:inherit;vertical-align:top}
                .tg .tg-9hbo{font-weight:bold;vertical-align:top}
                .tg .tg-yw4l{vertical-align:top}
            </style>
            <table  class="tg" style="width: 100%">
              <tr>
                <th class="tg-p8bj">SL#</th>
                <th class="tg-9hbo">Date</th>
                <th class="tg-9hbo">Building Name</th>
                <th class="tg-9hbo">Floor/Flt</th>
                <th class="tg-9hbo">Advance</th>
                <th class="tg-a2cf">Invoice No.</th>
            </tr>
           <?php $i=0;foreach($advanceList as $adv):?>
            <tr>
                <td class="tg-lqy6"><?= ++$i;?></td>
                <td class="tg-yw4l"><?php echo date("d-m-Y", strtotime($adv->start_date));?></td>
                <td class="tg-yw4l"><?= $adv->building_name; ?> </td>
                <td class="tg-yw4l"><?= $adv->flat_number;?></td>
                <td class="tg-lqy6"><?= number_format($adv->tenant_adv, 2, '.', '')?></td>
                <td class="tg-lqy6"><?= $adv->invoice_no?></td>
            </tr>
       <?php endforeach;?>
            </table>
        </div>
    </div>

    <script>

        function printData()
        {
         var divToPrint=document.getElementById("printTable");
         newWin= window.open("");
         newWin.document.write(divToPrint.outerHTML);
         newWin.print();
         newWin.close();
        }

     $('.print-me').on('click',function(){
        printData();
    });
</script>
<?php else: ?>
    <div><p style="color: red">No data found.</p></div>
<?php endif; ?>
<?php
/*
echo "<pre>";
print_r($advanceList);
*/
?>
</div>
<hr>