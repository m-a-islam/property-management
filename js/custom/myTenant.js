var li;
$(document).ready(function() {
    li = links();
    $( function() {
        $( "#tabs" ).tabs();
    });
});

$( function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
} );

//fetching all status=0  flat using building id start
$("#build_id").on("change",function () {
   var building_id = $(this).val();
   //alert(building_id);
    $.ajax({ //ajax for add flat
        type: 'POST',
        dataType: 'json',
        url: li + 'flat_controller/flatList',
        data: {
            building_id: building_id
        },
        success: function (msg) {
            //alert(msg.length);
            //console.log(msg);
            var flt = "";
            for (var i = 0; i < msg.length; i++)
            {
                if(msg[i].status==0){
                            flt = flt
                            + "<option value='"+msg[i].id+"' >" + msg[i].flat_number + "</option>";
                }
            }
            $("#flat_id").html(flt);
            //console.log(msg);
        }
    });
});
// fetching all status=0 flat using building id


// on change function for edit dropdown building
$("#edit_build_id").on('change', function () {
    var building_id = $(this).val();
    $.ajax({ //ajax for add flat
        type: 'POST',
        dataType: 'json',
        url: li + 'flat_controller/flatList',
        data: {
            building_id: building_id
        },
        success: function (msg) {
            //alert(msg.length);
            //console.log(msg);
            var flt = "";
            for (var i = 0; i < msg.length; i++)
            {
                if(msg[i].status==0){
                    flt = flt
                        + "<option value='"+msg[i].id+"' >" + msg[i].flat_number + "</option>";
                }
            }
            $("#edit_flat_id").html(flt);
            //console.log(msg);
        }
    });
});

//edit flat
$(".tenant_edit").on("click",function(){
    var tenant_id = $(this).attr("tenant-id");
   //alert(tenant_id);
  
//console.log(tenant_id);
    $.ajax({ //ajax for getting a view according to tenant_id
        type: 'POST',
        dataType: 'json',
        url: li + 'tenant_controller/get_tenant',
        data: {
            tenant_id: tenant_id
        },
        success: function(dataT) {
            //console.log(dataT);
            var tenant = dataT.tenant;
            var flat = dataT.flatList;
            //console.log(flat);
            $("#edit_voter_src").removeAttr('src');
            $("#edit_tenant_img_src").removeAttr('src');
            $("#edit_agreement_src").removeAttr('src');
            jQuery("#editTenant").modal('show');
            $("#tenant_id_edit").val(tenant.id);
            $("#edit_tenant_name").val(tenant.tenant_name);
            $("#edit_tenant_number").val(tenant.tenant_number);
            $("#edit_tenant_address").val(tenant.tenant_address);
            $("#edit_tenant_adv").val(tenant.tenant_adv);
            $("#edit_adjustable_adv").val(tenant.adjustable_adv);
            $("#edit_tenant_adv_deduct_amount").val(tenant.tenant_adv_deduct_amount);
            $("#edit_agree_start_date").val(tenant.start_date);
            $("#edit_agree_end_date").val(tenant.end_date);
            $("#edit_parking_bill").val(tenant.parking_bill);
            $("."+tenant.build_id+"buildingList").prop("selected",true);
            $("."+tenant.flat_id+"flatList").prop("selected",true);
            var voterId = li + "uploads/documents/"+tenant.tenant_name+"-"+tenant.id+"-voter_card.jpg";
            var agreementPaper = li + "uploads/documents/"+tenant.tenant_name+"-"+tenant.id+"-agreement_paper.jpg";
            var tenantImage = li + "uploads/tenant_image/"+tenant.id+".jpg";
            //console.log(voterId);
            $("#edit_voter_src").attr('src',voterId);
            $("#edit_tenant_img_src").attr('src',tenantImage);
            $("#edit_agreement_src").attr('src',agreementPaper);
            var flt = "";
            for (var i = 0; i < flat.length; i++)//dropdown of flat list
            {
                    flt = flt
                        + "<option class='"+flat[i].flatid+"+flatList' value='"+flat[i].flatid+"' >" + flat[i].flat_number + "</option>";
            }
            $("#edit_flat_id").html(flt);

        },
        error: function(jqXHR, textStatus, errorThrown) {
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

});



//clicking update button start
// $("#edit_tenant_submit").on('click',function () {
//     var tenant_name = $("#edit_tenant_name").val();
//     var tenant_number = $("#edit_tenant_number").val();
//     var tenant_address = $("#edit_tenant_address").val();
//     var tenant_adv = $("#edit_tenant_adv").val();
//     var tenant_adv_deduct_amount = $("#edit_tenant_adv_deduct_amount").val();
//     var agree_start_date = $("#edit_agree_start_date").val();
//     var agree_end_date = $("#edit_agree_end_date").val();
//     var build_id = $("#edit_build_id").val();
//     var flat_id = $("#edit_flat_id").val();
//     var tenant_id = $("#tenant_id_edit").val();
//     var tenant_image = $("#edit_tenant_image").val();
//     var agreement_paper = $("#edit_agreement_paper").val();
//     var voter_card = $("#edit_voter_card").val();
   // alert(tenant_image);

    // $.ajax({ //ajax for getting a view according to tenant_id
    //     type: 'POST',
    //     dataType: 'json',
    //     url: li + 'tenant_controller/update_tenant',
    //     data: {
    //         tenant_name: tenant_name,
    //         tenant_number: tenant_number,
    //         tenant_address:tenant_address,
    //         tenant_adv: tenant_adv,
    //         tenant_adv_deduct_amount:tenant_adv_deduct_amount,
    //         agree_start_date:agree_start_date,
    //         agree_end_date:agree_end_date,
    //         build_id:build_id,
    //         flat_id:flat_id,
    //         tenant_id:tenant_id
    //     },
    //     success: function(dataT) {
    //         window.location = li+"tenant_controller";
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //         //alert("Server Error");
    //         if (jqXHR.status === 0) {
    //             alert('Not connect.\n Verify Network.');
    //         } else if (jqXHR.status == 404) {
    //             alert('Requested page not found.');
    //         } else if (jqXHR.status == 500) {
    //             alert('Internal Server Error.');
    //         } else if (errorThrown === 'parsererror') {
    //             alert('Requested JSON parse failed');
    //         } else if (errorThrown === 'timeout') {
    //             alert('Time out error');
    //         } else if (errorThrown === 'abort') {
    //             alert('Ajax request aborted ');
    //         } else {
    //             alert('Uncaught Error.\n' + jqXHR.responseText);
    //         }
    //
    //     }
    // });
// });

//clicking update button end
