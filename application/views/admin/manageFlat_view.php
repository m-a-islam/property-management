<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Flat</h1>
            </div>
        </div>
        
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <td colspan="4" align="center"><b>Building List</b></td>
            </tr>
            <tr>
                <th>#</th>
                <th>Building Name</th>
                <th>Code</th>
                <th>Location</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0; ?>
            <?php if (count($buildingList)) : ?>
                <?php foreach ($buildingList as $building) : ?>
                    <tr class="allFlat" building-id="<?= $building->id ?>">
                        <td><?= ++$i ?></td>
                        <td><?= $building->building_name ?></td>
                        <td><?= $building->building_code ?></td>
                        <td><?= $building->building_loc ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No records found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal for list flat -->
        <div id="allFlat" class="modal fade bd-example-modal-lg" role="dialog" >
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align-last: center">Flat List</h4>
                    </div>
                    <div class="modal-body">
                    <div id="sts" class="col-lg-12">
                    <strong id="msg"></strong>
                    </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="#" class="btn btn-success" data-toggle="modal" id="forFlatPopup"
                                   style="float: left;">
                                    <i class="fa fa-plus-circle"></i> Add Flat
                                </a>
                            </div>
                        </div>
                    <div style="overflow:scroll;height:100vh;width:100%;overflow:auto">
                        <table id="flatTable" class="table table-striped table-bordered display" scrollbars="yes" >
                            <thead>
                            
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Flat Number</th>
                                <th>Flat Rent</th>
                                <th>Service Charge</th>
                                <th>Gas Bill</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--        modal  list flat end-->

        <!-- Modal for add flat start -->
        <div id="addFlat" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align-last: center">Add Flat</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Flat Number</label>
                                <div class="col-sm-6">
                                    <input type="text" id="flat_number" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Flat Rent</label>
                                <div class="col-sm-6">
                                    <input type="text" id="flat_rent" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Service charge</label>
                                <div class="col-sm-6">
                                    <input type="text" id="flat_service" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Gas bill</label>
                                <div class="col-sm-6">
                                    <input type="text" id="flat_gas_bill" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <button id="flat_submit" class="btn btn-success">Add</button>
                                </div>
                                <div class="col-sm-6">
                                    <button id="edit_flat_submit" class="btn btn-success" >Update</button>
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
        <!-- Modal for add flat end -->

        <!-- Modal for update flat start -->
        <!-- Modal for update flat end -->

        <script src="<?php //echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php //echo base_url(); ?>js/custom/myFlat.js"></script>
    </div>
</div>
