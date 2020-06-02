<hr>
<div class="col-md-12">
    <div class="table-responsive">
        <?php if(count($totalSummary)):?>
        <div class="col-md-12" style="text-align: center;">
                <h3><?= $start?> To <?= $end?></h3>
        </div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>Total Collection</th>
                <th>Total Expense</th>
                <th>Income/(-Loss)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($totalSummary as $ts):?>
            <tr>
                <td><?php echo $ts->debitAmount;?></td>
                <td><?php echo $ts->creditAmount;?></td>
                <td><?php echo ($ts->debitAmount)-($ts->creditAmount);?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
    <?php else: ?>
        <div><p style="color: red">No Summary found within this date.</p></div>
    <?php endif; ?>
</div>
<hr>