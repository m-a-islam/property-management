var li;
$(document).ready(function() {
    li = links();
});
//for showing add flat modal start
$('#forFlatPopup').on('click',function(){
    jQuery("#addFlat").modal('show');
    $('#flat_submit').show();
    $('#edit_flat_submit').hide();
    $('input').val('');
});
//for showing add flat modal end

// view all flat from specific building start
$('.allFlat').on("click", function() {

    var building_id = $(this).attr('building-id');
    
    $('#flat_submit').val(building_id); //set value of a button which is allocate in another ajax function

    //jQuery("#allFlat").modal('show');
    //$("#flatTable").attr("class","display nowrap");
   // table.ajax.url( li + 'flat_controller/flatList/'+building_id ).load();

    $.ajax({ //ajax for getting a view according to building_id
        type: 'POST',
        dataType: 'json',
        url: li + 'flat_controller/flatList',
        data: {
            building_id: building_id
        },
        success: function(dataT) {
               //var tab= "";
             //alert(data);
            jQuery("#allFlat").modal('show');
           //console.log(dataT);
            //console.log(dataT[0].flat_number);
            //$('#flatNmbr').html(dataT[0].flat_number);
            
            $("#flatTable > tbody").html(doFlat(dataT));

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
// view all flat from specific building end

// add flat ajax start
$('#flat_submit').on("click", function() {

    var build_id = $(this).val(); // this value is set from $('.allFlat').on("click", function ()) that is $('#flat_submit').val(building_id)
    //alert(build_id);
    
    var flatNumber = $("#flat_number").val();
    var flatRent = $("#flat_rent").val();
    var flatService = $("#flat_service").val();
    var flatGasBill = $("#flat_gas_bill").val();
    if (flatNumber == '') {
        alert('Please give Flat Number!');
    } else {
        $.ajax({ //ajax for add flat
            type: 'POST',
            dataType: 'json',
            url: li + 'flat_controller/add_flat',
            data: {
                build_id: build_id,
                flatNumber: flatNumber,
                flatRent: flatRent,
                flatService: flatService,
                flatGasBill: flatGasBill
            },
            success: function(msg) {
                //var tab = "";
                $('input').val('');
                jQuery("#addFlat").modal('hide');
                jQuery("#allFlat").modal('show');
               // var stsTg = "<div class='alert alert-success'></div>";
               // $('#sts').after(stsTg);
                $('#sts').attr('class', 'alert alert-success');
                
                //document.getElementById("sts").classList.remove("alert-danger");
                //document.getElementById("sts").classList.add("alert-success");
                $('#msg').html("Flat Added!");
                $( "#sts" ).slideUp( 3000 ).delay( 8000 ).fadeOut( 4000 ); 
                //console.log(msg);
                $("#flatTable > tbody").html(doFlat(msg));
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
// add flat ajax end


//edit flat start
$('#flatTable').on('click',".edit_flat",function(){
    var flat_id = $(this).attr('flat-id');
    $.ajax({ //ajax for getting a view according to building_id
        type: 'POST',
        dataType: 'json',
        url: li + 'flat_controller/edit_flat',
        data: {
            flat_id: flat_id
        },
        success: function(dataT) {
           
           //alert(dataT);
           //console.log(dataT);
           jQuery("#addFlat").modal('show');
            $("#flat_number").val(dataT.flat_number);
            $("#flat_rent").val(dataT.flat_rent);
            $("#flat_service").val(dataT.flat_service_charge);
            $("#flat_gas_bill").val(dataT.gas_bill);
            
            $('#flat_submit').hide();
            $('#edit_flat_submit').show();
           
             $('#edit_flat_submit').val(dataT.id);

             $('#edit_flat_submit').attr('onclick','update_flat('+dataT.id+','+dataT.building_id+','+dataT.status+');');//call update flat function
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
//edit flat end
//update flat start

function update_flat(flat_id,building_id,status){
    
    var flatNumber = $("#flat_number").val();
    var flatRent = $("#flat_rent").val();
    var flatService = $("#flat_service").val();
    var flatGasBill = $("#flat_gas_bill").val();
    var sts = status;
    //alert(flat_id);
    //alert(building_id);
    //console.log("flat number:"+flatNumber);
    if (flatNumber == '') {
        alert('Please give Flat Number!');
    } else {
        $.ajax({ //ajax for add flat
            type: 'POST',
            dataType: 'json',
            url: li + 'flat_controller/update_flat',
            data: {
                building_id:building_id,
                flat_id: flat_id,
                flatNumber: flatNumber,
                sts: status,
                flatRent: flatRent,
                flatService: flatService,
                flatGasBill: flatGasBill
            },
            success: function(msg) {
                //console.log(msg);
                if(msg.update === true){
                    $('#sts').attr('class', 'alert alert-success');
                    $('#msg').html("Flat updated successfully!");
                    $( "#sts" ).slideUp( 3000 ).delay( 8000 ).fadeOut( 4000 ); 
                }
                jQuery("#addFlat").modal('hide');
                jQuery("#allFlat").modal('show');
                $("#flatTable > tbody").html(doFlat(msg.flatList));
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
}
//update flat end


//delete flat start
$('#flatTable').on('click','.delete_flat', function(){
    var conf = confirm("Are you want to delete this flat?");
    if(conf===true){
    var flat_id = $(this).attr('flat-id');
    var building_id = $('.delete_flat').attr('bld-id');
    $.ajax({ //ajax for getting a view according to building_id
        type: 'POST',
        dataType: 'json',
        url: li + 'flat_controller/delete_flat',
        data: {
            flat_id: flat_id,
            building_id: building_id
        },
        success: function(data) {
            if(data.delete === true){
                //document.getElementById("sts").classList.remove("alert-success");
                //document.getElementById("sts").classList.add("alert-danger");
                //var stsTg = "<div class='alert alert-danger'></div>";
                $('#sts').attr('class', 'alert alert-danger');
                //$('#sts').after(stsTg);
                $('#msg').html("Flat deleted successfully!");
                $( "#sts" ).slideUp( 3000 ).delay( 8000 ).fadeOut( 4000 ); 
            }
            jQuery("#addFlat").modal('hide');
            jQuery("#allFlat").modal('show');
            $("#flatTable > tbody").html(doFlat(data.flatList));
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
// delete flat end

//making a flatlist start
function doFlat(x){
    dataT = x;
    var tab = "";
    for (var i = 0; i < dataT.length; i++) {
                
        tab = tab 
        +   "<tr><td>"  +   dataT[i].flat_number
        +   "</td><td>" +   dataT[i].flat_rent
        +   "</td><td>" +   dataT[i].flat_service_charge
        +   "</td><td>" +   dataT[i].gas_bill
        +   "</td><td> <a class='btn btn-primary edit_flat' flat-id='"+ dataT[i].id + "' type='button' data-toggle='tooltip' data-placement='top' title='Edit'><i class='fa fa-edit'></i>"
        
        +   "</a><a class='btn btn-danger delete_flat' type='button' bld-id='"+dataT[i].building_id+"' flat-id='"+ dataT[i].id + "' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash-o'></i>"
        +   "</a></td></tr>";
    }
    return tab;
};
//making a flatlist end