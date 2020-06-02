<hr>
<div class="col-md-12">
    <div  class="table-responsive">
        <?php if(count($yearlyInfoList)):?>
            <div class="form-group" style="margin: 5px;">
                <button class="print-me fa fa-print btn btn-primary btn-lg">Print</button>
            </div>
            <div id="printTable">
                <div class="form-group" style="text-align: center; font-size:25px; font-family:Arial, sans-serif; font-weight:bold; margin: 0px">
                    <p style="margin: 0px">Yearly Statement</p>
                    <p style="margin: 0px"><small><?=$building->building_name?></small></p>
                    <small style="margin: 0px"><?=$start?> to <?=$end?></small>
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
                <th class="tg-9hbo">Months</th>
                <th class="tg-9hbo">Cash</th>
                <th class="tg-9hbo">Bank</th>
            </tr>
           <?php $i=0; $t_b=0;$t_c=0; foreach($yearlyInfoList as $info):?>
            <tr>
                <td class="tg-lqy6"><?= ++$i?></td>
                <td class="tg-yw4l"><?php echo date("F Y", strtotime($info->date));?></td>
                <td class="tg-yw4l">
                    <?php echo number_format($info->cash, 2, '.', ''); 
                    $t_c = $t_c +$info->cash;
                    ?></td>
                <td class="tg-yw4l">
                    <?php echo number_format($info->bank, 2, '.', '');
                    $t_b = $t_b + $info->bank; 
                ?></td>
            </tr>
      <?php endforeach;?>
      <tr>
          <td class="tg-p8bj" colspan="2">Total:</td> 
          <td class="tg-yw4l"><?= number_format($t_c, 2, '.', '')?></td> 
          <td class="tg-yw4l"><?= number_format($t_b, 2, '.', '')?></td> 
      </tr>
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
print_r($yearlyInfoList);
*/
?>
</div>
<hr>