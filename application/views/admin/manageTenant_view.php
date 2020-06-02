<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Tenant</h1>
            </div>
        </div>
        <?php if ($feedback = $this->session->flashdata('feedback')):
            $feedback_class = $this->session->flashdata('feedback_class');
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-dismissible <?= $feedback_class; ?>">
                        <?= $feedback; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!------CONTROL TABS------>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"> <i class="fa fa-list"></i> List</a></li>
                <li><a href="#tabs-2"> <i class="fa fa-user"></i> Add Tenant</a></li>
            </ul>

            <div id="tabs-1">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tenant Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Building & Flat</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    <?php if (count($tenantList)): ?>
                        <?php foreach ($tenantList as $tenant): ?>
                            <tr>
                                <td><?= ++$i; ?></td>

                                <td><?= $tenant->tenant_name ?></td>
                                <td><?= $tenant->tenant_number; ?></td>
                                <td><?= $tenant->tenant_address; ?></td>
                                <td>
                                    <?php
                                    $building = $this->building_model->findBuilding($tenant->build_id);
                                    $flat = $this->flat_model->findFlat($tenant->flat_id);
                                    echo "Building: " . $building->building_name;
                                    echo "<br> Flat: " . $flat->flat_number;
                                    ?>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary tenant_edit" tenant-id="<?php echo $tenant->id; ?>"
                                       href='#' data-toggle="tooltip" data-placement="top" title="Edit!">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" href='<?php echo base_url("tenant_controller/delete_tenant/{$tenant->id}");?>'
                                       onclick="return confirm('Are you sure you want to delete Income?')"
                                       data-toggle="tooltip" data-placement="top" title="Delete!">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">
                                No records found.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div id="tabs-2">
                <form id="tenantForm" method="post" action="<?php echo base_url();?>tenant_controller/add_tenant" class="form-horizontal"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Name</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" required name="tenant_name"/>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Phone</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" required name="tenant_number"/>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Address</label>
                        <div class="col-xs-6">
                            <textarea class="form-control" name="tenant_address" id="" cols="30" rows="5"></textarea>

                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Advance Amount</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="tenant_adv"/>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Adjustable Adv. Amount</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="adjustable_adv"/>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Deduction from
                            Adv.(/month)</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="tenant_adv_deduct_amount"/>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Agreement Start Date</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" required name="agree_start_date"/>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Agreement End Date</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" required name="agree_end_date"/>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" for="build_id" style="font-size: smaller">Building</label>
                        <div class="col-xs-6">
                            <select class="form-control" id="build_id" required name="build_id">
                                <option value="">--Select Building--</option>
                                <?php foreach ($buildingList as $building): ?>
                                    <option value="<?= $building->id; ?>">
                                        <?= $building->building_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" for="flat_id" style="font-size: smaller">Flat</label>
                        <div class="col-xs-6">
                            <select class="form-control" required id="flat_id" name="flat_id">

                            </select>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Parking(if.)</label>
                        <div class="col-xs-6">
                            <input type="number" class="form-control" name="parking_bill"/>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Tenant Image</label>
                        <div class="col-xs-6">
                            <input name="tenant_image" type="file" class="custom-file-input form-control">
                            <span class="custom-file-control">Upload tenant image</span>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Voter ID</label>
                        <div class="col-xs-6">
                            <input name="voter_card" type="file" class="custom-file-input form-control">
                            <span class="custom-file-control">Upload Voter ID Card</span>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label" style="font-size: smaller">Agreement Paper</label>
                        <div class="col-xs-6">
                            <input name="agreement_paper" type="file" class="custom-file-input form-control">
                            <span class="custom-file-control">Upload agreement paper</span>
                        </div>
                        <div class="col-xs-5 messageContainer"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9 col-xs-offset-2">
                            <button type="submit" class="btn btn-primary" style="font-size: smaller">Add Tenant</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--        modal for edit tenant start-->
        <div id="editTenant" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align-last: center">Edit Tenant</h4>
                    </div>
                    <form action="tenant_controller/update_tenant" method="post" enctype="multipart/form-data">
                        <div class="modal-body" style="overflow: auto;">
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Name</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="edit_tenant_name" id="edit_tenant_name"/>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Phone</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="edit_tenant_number" id="edit_tenant_number"/>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Address</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" name="edit_tenant_address" id="edit_tenant_address" cols="30"
                                                  rows="5"></textarea>

                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Advance
                                        Amount</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="edit_tenant_adv" id="edit_tenant_adv"/>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Adjustable Adv Amount</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="edit_adjustable_adv" id="edit_adjustable_adv"/>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Deduction from
                                        Adv.(/month)</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="edit_tenant_adv_deduct_amount" id="edit_tenant_adv_deduct_amount"/>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Agreement Start
                                        Date</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control datepicker" name="edit_agree_start_date" id="edit_agree_start_date"/>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Agreement End
                                        Date</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control datepicker" name="edit_agree_end_date" id="edit_agree_end_date"/>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" for="edit_build_id"
                                           style="font-size: smaller">Building</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="edit_build_id" name="build_id">
                                            <option class="0buildingList" value="">--Select Building--</option>
                                            <?php foreach ($buildingList as $building): ?>
                                                <option class='<?php echo $building->id . "buildingList"; ?>'
                                                        value="<?= $building->id; ?>">
                                                    <?= $building->building_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" for="edit_flat_id" style="font-size: smaller">Flat</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" name="edit_flat_id" id="edit_flat_id">

                                        </select>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                            <div class="form-group">
                                <label class="col-xs-3 control-label" style="font-size: smaller">Parking(if.)</label>
                                <div class="col-xs-9">
                                    <input type="number" class="form-control" name="edit_parking_bill" id="edit_parking_bill"/>
                                </div>
                                <div class="col-xs-5 messageContainer"></div>
                            </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Tenant
                                        Image</label>
                                    <div class="col-xs-9">
                                        <img id="edit_tenant_img_src" src="" style="height: 150px;width: 200px;"
                                             alt="tenantImage">
                                        <input id="edit_tenant_image" name="edit_tenant_image" type="file"
                                               class="custom-file-input form-control">
                                        <span class="custom-file-control">Upload tenant image</span>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Voter ID</label>
                                    <div class="col-xs-9">
                                        <img id="edit_voter_src" src="" style="height: 150px;width: 200px;"
                                             alt="Voter ID">
                                        <input name="voter_card" id="edit_voter_card" type="file"
                                               class="custom-file-input form-control">
                                        <span class="custom-file-control">Upload Voter ID Card</span>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>
                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label" style="font-size: smaller">Agreement
                                        Paper</label>
                                    <div class="col-xs-9">
                                        <img id="edit_agreement_src" src="" style="height: 150px;width: 200px;"
                                             alt="agreementPaper">
                                        <input name="agreement_paper" id="edit_agreement_paper" type="file"
                                               class="custom-file-input form-control">
                                        <span class="custom-file-control">Upload agreement paper</span>
                                    </div>
                                    <div class="col-xs-5 messageContainer"></div>
                                </div>
                            </div>


                            <div class="row r_padding">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-sm-9">
                                        <button id="edit_tenant_submit" name="update" class="btn btn-success">Update</button>
                                        <input type="hidden" class="form-control" name="tenant_id_edit" id="tenant_id_edit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--        modal for edit tenant end-->
        <script src="<?php //echo base_url(); ?>js/custom/link.js"></script>
        <script src="<?php //echo base_url(); ?>js/custom/myTenant.js"></script>
    </div>
</div>


