<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Building</h1>
            </div>
        </div>
        <div id="sts" class="col-lg-12">
            <strong id="msg"></strong>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addBuilding"
                   style="float: left;">
                    <i class="fa fa-plus-circle"></i> Add new building
                </a>
            </div>
        </div>

        <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=0;?>
            <?php if (count($buildingList)):?>
            <?php foreach ($buildingList as $building):?>
            <tr id = "<?= $building->id ?>">
                <td><?= ++$i?></td>
                <td><?= $building->building_name?></td>
                <td><?= $building->building_code?></td>
                <td><?= $building->building_loc?></td>
                <td>
                    <a href='<?= base_url("building_controller/delete_building/{$building->id}")?>' type="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete Building?')" data-toggle="tooltip" data-placement="top" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    <a data-id="<?= $building->id?>" class="btn btn-success btnModal" data-toggle="tooltip" data-placement="top" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="6" >No records found</td>
                </tr>
            <?php endif;?>
            </tbody>
        </table>
        <!-- Modal for adding building -->
        <div id="addBuilding" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align-last: center">Add Building</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Building Name</label>
                                <div class="col-sm-6">
                                    <input type="text" id="building_name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Code</label>
                                <div class="col-sm-6">
                                    <input type="text" id="building_code" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Location</label>
                                <div class="col-sm-6">
                                    <input type="text" id="building_loc" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Auth. Person</label>
                                <div class="col-sm-6">
                                    <select class="form-control s_ware" id="building_auth">
                                        <option value=""></option>
                                        <?php foreach ($userList as $auth): ?>

                                            <option value="<?php echo $auth->id; ?>"><?php echo $auth->user ?></option>

                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <button id="building_submit" class="btn btn-success">Add Building</button>
                                    <input type="hidden" class="form-control" id="wareId" value="<?= $this->session->userdata('wire')?>" >
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
<!--        modal add building end-->

<!-- Modal for edit building start -->
<div id="editBuilding" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align-last: center">Edit Building</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Building Name</label>
                                <div class="col-sm-6">
                                    <input type="text" id="edit_building_name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Code</label>
                                <div class="col-sm-6">
                                    <input type="text" id="edit_building_code" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Location</label>
                                <div class="col-sm-6">
                                    <input type="text" id="edit_building_loc" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Auth. Person</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="edit_building_auth">
                                        <option class="0userList" value=""></option>
                                        <?php foreach ($userList as $auth): ?>

                                            <option class='<?php echo $auth->id."userList"; ?>' value="<?php echo $auth->id; ?>"><?php echo $auth->user ?>
                                            </option>

                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-6">
                                    <button id="update_building_submit" class="btn btn-success">Update Building</button>
                                    <input type="hidden" class="form-control" id="building_id_edit" >
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
<!-- Modal for edit building end -->

        <script src="<?php echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php echo base_url(); ?>js/custom/myBuilding.js"></script>
    </div>
</div>
