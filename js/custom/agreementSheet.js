var li;
$(document).ready(function() {
    li = links();
});

$( function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
} );



$('.agreementSheet-submit').on('click',function () {


	var building_id = $('#build_id').val();
	
	if(building_id==""){
		alert("Please select building!");
	}else{
		$.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'tenant_controller/showAgreementSheetByBuilding',
            data: {
                building_id: building_id
            },
            success: function (response) {
            	//alert(response);
                //console.log(response);
                jQuery('.load_agreementContent').html(response);

            },
        error: function (jqXHR, textStatus, errorThrown) {
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

$('.advanceAgreementSheet-submit').on('click',function(){
	var building_id = $('#build_id').val();
	
	if(building_id == ""){
		alert("Please Select building!");
	}else{
		$.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'summary/showAdvanceAgreementByBuilding',
            data: {
                building_id: building_id
            },
            success: function (response) {
            	//alert(response);
                //console.log(response);
                jQuery('.load_advanceAgreementContent').html(response);

            },
        error: function (jqXHR, textStatus, errorThrown) {
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
$('.yearlyStatementSheet-submit').on('click',function(){
	var building_id = $('#build_id').val();
	var start = $('.starttD').val();
    var end = $('.endtD').val();
	
	if(building_id == ""){
		alert("Please Select building!");
	}else if(start == "" || end == ""){
		alert("Please select start and end date");
	}else{
		$.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'summary/showYearly_statement',
            data: {
                building_id: building_id,
                start: start,
                end: end
            },
            success: function (response) {
            	//alert(response);
                //console.log(response);
                jQuery('.load_yearlySheetContent').html(response);

            },
        error: function (jqXHR, textStatus, errorThrown) {
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