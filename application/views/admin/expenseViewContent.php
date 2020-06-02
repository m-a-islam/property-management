<hr>
<div class="col-md-12">
    <div  class="table-responsive">
        <?php if(count($journal)):?>
            <div class="form-group" style="margin: 5px;">
                <button class="print-me fa fa-print btn btn-primary btn-lg">Print</button>
            </div>
            <div id="printTable">
                <div class="form-group" style="text-align: center; font-size:25px; font-family:Arial, sans-serif; font-weight:bold; margin: 0px">
                    <?php echo $this->payment_model->getAccHeadById($ledger)->name;?>
                    <p style="font-size:15px; margin: 0px">
                        <?php echo $start?> to <?php echo $end?>
                    </p>
                </div>
                <style type="text/css">
                .tg  {border-collapse:collapse;border-spacing:0;}
                .tg td{font-family:Arial, sans-serif;font-size:14px;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
                .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
                .tg .tg-a2cf{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;text-align:center;vertical-align:top}
                .tg .tg-baqh{text-align:center;vertical-align:top}
                .tg .tg-lqy6{text-align:right;vertical-align:top}
                .tg .tg-p8bj{font-weight:bold;border-color:inherit;vertical-align:top}
                .tg .tg-9hbo{font-weight:bold;vertical-align:top}
                .tg .tg-yw4l{vertical-align:top}
            </style>
            <table  class="tg" style="width: 100%">
              <tr>
                <th class="tg-p8bj">Date</th>
                <th class="tg-9hbo">Particular</th>
                <th class="tg-9hbo">Debit</th>
                <th class="tg-a2cf">Credit</th>
            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l">Balance B/D</td>
                <?php if((($opening->type == 1) && ($opening->opening >= 0))||(($opening->type == 2) && ($opening->opening <= 0))):?>
                <td class="tg-lqy6">
                    <?php echo number_format($opening->opening);
                    ?>
                </td>
                <td class="tg-lqy6"></td>
                <?php elseif ((($opening->type == 1) && ($opening->opening <= 0))||(($opening->type == 2) && ($opening->opening >= 0))):?>
                <td class="tg-lqy6"></td>
                <td class="tg-lqy6">
                    <?php echo number_format($opening->opening);

                    ?></td>
                <?php endif;?>

            </tr>
            <?php $d_total=0;$c_total=0;foreach($journalList as $journal):?>
            <tr>
                <td class="tg-yw4l">
                    <?php
                    echo date("d-m-Y", strtotime($journal->date));
                    ?>    
                </td>
                <?php if($journal->d_id != 0):?>
                    <td class="tg-yw4l"><?php
                    $particular = $this->payment_model->getAccHeadById($journal->d_id)->name;
                    echo $particular;
                    ?> 
                </td>
                <td class="tg-lqy6"></td>
                <td class="tg-lqy6">
                    <?php echo number_format($journal->credit_amount);
                    $c_total = $c_total + $journal->credit_amount; 
                    ?></td>
                    <?php elseif($journal->c_id != 0):?>
                        <td class="tg-yw4l"><?php 
                        $particular = $this->payment_model->getAccHeadById($journal->c_id)->name;
                        echo $particular;
                        ?>   
                    </td>
                    <td class="tg-lqy6">
                        <?php echo number_format($journal->debit_amount);
                        $d_total = $d_total + $journal->debit_amount;
                        ?></td>
                        <td class="tg-lqy6"></td> 
                    <?php endif;?>
                </tr>
            <?php endforeach;?>
            <tr>
                <td></td>
                <td></td>
                <td class="tg-a2cf">Total: <?= number_format($d_total)?></td>
                <td class="tg-a2cf">Total: <?= number_format($c_total)?></td>

            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l">Closing C/D</td>
                <?php if($opening->type==1):?>

                    <td class="tg-lqy6">
                        <?php
                        $total = ($opening->opening + $d_total) - ($c_total);
                        echo number_format($total);
                        ?>
                    </td>
                    <td class="tg-lqy6"></td>
                    <?php elseif($opening->type==2):?>
                        <td class="tg-lqy6"></td>
                        <td class="tg-lqy6">
                            <?php
                            $total = ($opening->opening + $c_total) - ($d_total);
                            echo number_format($total);
                            ?>
                        </td>

                    <?php endif;?>
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
    <div><p style="color: red">No data found within this date.</p></div>
<?php endif; ?>
<?php
/*
echo "<pre>";
print_r($journalList);
*/
?>
</div>
<hr>