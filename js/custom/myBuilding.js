var li;
$(document).ready(function() {
    li = links();
});
// add building js start
$("#building_submit").click(function() {

    var buildingName = $("#building_name").val();
    var buildingCode = $("#building_code").val();
    var buildingLoc = $("#building_loc").val();
    var buildingAuth = $('#building_auth').val();
    // alert(buildingAuth);

    if (buildingName == '') {
        alert('Please fill information!');
    } else {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: li + 'building_controller/add_building',
            data: {
                buildingName: buildingName,
                buildingCode: buildingCode,
                buildingLoc: buildingLoc,
                buildingAuth: buildingAuth
            },
            success: function(data) {
                $('input').val('');
                $('#building_auth').val('');
                alert('Building added!');
                window.location = li + 'building_controller';
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
    }
});
// add building js end


// edit building js start

$(".btnModal").on("click", function() {
    var id = $(this).attr("data-id");
    //alert(id);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: li + 'building_controller/get_building',
            data: {
                id: id
            },
            success: function(data) {
                //console.log(data.building_name);
                 $("#editBuilding").modal("show");
                 $("#building_id_edit").val(data.id);
                 $("#edit_building_name").val(data.building_name);
                 $("#edit_building_code").val(data.building_code);
                 $("#edit_building_loc").val(data.building_loc);
                 $("."+data.building_auth+"userList").prop("selected",true);// dropdown er value selected show korar jonno
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
// edit building js end

// update buildin js start
$("#update_building_submit").click(function() {
    var building_id = $("#building_id_edit").val(); 
    var buildingName = $("#edit_building_name").val();
    var buildingCode = $("#edit_building_code").val();
    var buildingLoc = $("#edit_building_loc").val();
    var buildingAuth = $('#edit_building_auth').val();
    // alert(building_id);

    if (buildingName == '') {
        alert('Please fill information!');
    } else {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: li + 'building_controller/update_building',
            data: {
                building_id: building_id,
                buildingName: buildingName,
                buildingCode: buildingCode,
                buildingLoc: buildingLoc,
                buildingAuth: buildingAuth
            },
            success: function(data) {
               // console.log(data);
               // window.location = li + 'building_controller';
                if (data.sts==1) 
                {
                    //$('#sts').toggleClass('alert-success alert-danger');  
                    $('#sts').attr('class', 'alert alert-success');  
                    $('#msg').html(data.msg);
                    $('#'+building_id+" td:nth-child(2)").html(buildingName);
                    $('#'+building_id+" td:nth-child(3)").html(buildingCode);
                    $('#'+building_id+" td:nth-child(4)").html(buildingLoc);
                    //$('#'+building_id+" td:nth-child(5)").html(buildingLoc);
                }else if(data.sts==0){
                    //$('#sts').toggleClass('alert-danger alert-success');
                    $('#sts').attr('class', 'alert alert-danger');
                    $('#msg').html(data.msg); 
                }
                $("#editBuilding").modal("hide");
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
    }
});
// update buildin js end