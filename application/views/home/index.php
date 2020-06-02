<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

        <?php foreach ($wire as $val): ?>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="background-color:wheat">

                        <a href="<?php echo base_url(); ?>admin/change_wire/<?php echo $val['id'] ?>">
                            <h3><strong><?php echo $val['name'] ?><strong></h3>
                            <p>Address :<?php echo $val['address'] ?></p>
                            <p>Phone :<?php echo $val['phone'] ?></p>
                            <p>Admin :<?php echo $this->setting->anyName('password', 'id', $val['ch'], 'user') ?></p>
                        </a>


                    </div>
                </div>

            </div>


        <?php endforeach; ?>


    </div>


    <div class="row">

        <div class="col-lg-12">

            <h1 class="page-header">Store List</h1>

        </div>


    </div>


    <div class="row">

        <div class="col-lg-12">

            <?php foreach ($store as $s): ?>


                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="background-color:wheat">
                            <a href="#">
                                <h3><strong><?php echo $s['name'] ?><strong></h3>
                                <p>Ware House
                                    :<?php echo $this->setting->anyName('ware', 'id', $s['ware'], 'name'); ?></p>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->
		

		
		