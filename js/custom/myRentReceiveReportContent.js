var li;
$(document).ready(function () {
    li = links();
});
//for showing take payment  modal start
$('.forTakePayment').on('click', function () {
    var invoice_id = $(this).attr('invoice-id');
    var building_id = $(this).attr('building-id');

    //alert(invoice_id);
    $.ajax({ //ajax for getting a view according to building_id
        type: 'POST',
        dataType: 'json',
        url: li + 'invoice_controller/processing_take_payment',
        data: {
            invoice_id: invoice_id

        },
        success: function (dataT) {
            //var tab= "";
            //alert(dataT);
            var generatedBill = dataT.generatedBill;
            var transAction = dataT.transAction;
            var inVoice = dataT.inVoice;
            //console.log(generatedBill);
            //console.log(transAction);
            //jQuery("#takePayment").modal('show');
            //console.log(dataT);
            //console.log(dataT[0].flat_number);
            //$('#flatNmbr').html(dataT[0].flat_number);
            //console.log(makePaymentInput(generatedBill,transAction));
            jQuery("#takePayment").modal('show');
            $("#allReceivedField").html(makePaymentInput(generatedBill, transAction, invoice_id, building_id));

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
});
//for showing take payment modal end

//function for making payment input field start
function makePaymentInput(generatedBill, transAction, invoice_id, building_id) {
    var field = "";
    var j = 1;

    for (var i = 0; i < generatedBill.length; i++) {
        var val = generatedBill[i].billAmount;//if he/she don't pay the bill of the specific accounts then by default bill will set as due amount
        if (j <= transAction.length) {
            if ((generatedBill[i].accounts_id == transAction[i].credit)) {
                val = generatedBill[i].billAmount - transAction[i].amount;
                //transActionAmount = transAction[i].amount;//amount that he/she pay for the services
            }
        }
        j++;
        field = field
            + "" +
            "<div class='form-group'> <label class='col-sm-3 control-label' style='margin: 5px 0;'>" + generatedBill[i].name
            + "</label> <div class='col-sm-9'> <input type='text' class='form-control' style='margin: 5px 0;' name='" + generatedBill[i].name.replace(/\s/g, '') + "' value='" + val + "'>"
            + "<input type='hidden' class='form-control' name='invoiceid' value='" + invoice_id + "'>"
            + "<input type='hidden' name='tenant_id' value='" + generatedBill[i].tenant_id + "'>"
            + "<input type='hidden' name='flat_id' value='" + generatedBill[i].flat_id + "'>"
            + "<input type='hidden' name='month' value='" + generatedBill[i].month + "'>"
            + "<input type='hidden' name='building_id' value='" + building_id + "'>"
            + "<p>Dues:" + val + "</p></div>";
    }
    return field;
}

//function for making payment input field end
$(document).on("focus", ".datepicker", function () {
    $(this).datepicker({dateFormat: 'dd-mm-yy'});
});

//for showing take payment  modal start
$('.forEditPayment').on('click', function () {

    var invoice_id = $(this).attr('invoice-id');
    var building_id = $(this).attr('building-id');

    //alert(invoice_id);
    //alert(building_id);


    $.ajax({ //ajax for getting a view according to building_id
        type: 'POST',
        dataType: 'json',
        url: li + 'invoice_controller/processing_edit_payment',
        data: {
            invoice_id: invoice_id
        },
        success: function (dataT) {
            //console.log(dataT);
            jQuery("#editPayment").modal('show');
            $("#allReceivedField").html(makeEditPaymentInput(dataT));

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
});

//for showing take payment modal end


function makeEditPaymentInput(data) {
    var field = "<div class='form-group'>"
        + "<input type='hidden' class='form-control' name='invoice_id' value='" + data[0].invoice_id + "'>"
        + "<input type='hidden' class='form-control' name='tenant_id'   value='" + data[0].tenant_id + "'>"
        + "<input type='hidden' class='form-control' name='flat_id'     value='" + data[0].flat_id + "'>"
        + "<input type='hidden' class='form-control' name='month'       value='" + data[0].month + "'>"
        + "<input type='hidden' class='form-control' name='date'        value='" + data[0].date + "'>"
        + "<input type='hidden' class='form-control' name='building_id' value='" + data[0].building_id + "'>"
        + "</div>";
    for (var i = 0; i < data.length; i++) {
        field = field
            + "<div class='form-group'> <label class='col-sm-3 control-label' style='margin: 5px 0;'>" + data[i].headName
            + "</label> <div class='col-sm-9'> <input transaction-id='" + data[i].transaction_id + "' type='text' onkeypress='return isNumberKey(event)' class='form-control' style='margin: 5px 0;' name='" + data[i].headName.replace(/\s/g, '') + "' value='" + data[i].amount + "'>"
            + "</div>";
    }
    return field;
}


$('#updatePayment').on('click', function () {
    //alert("Success");
    var staticData = {}
    var dynamicData = {};
    var total = 0;
    var id = "allReceivedField";
    var i = 0;
    $('#' + id + ' input').each(function () {
        var name = $(this).attr('name');//if there is [] in the post or input it throws exception of disallowed characters
        // name = name.replace('[]', '');
        var inp = $(this).attr('type');
        if (inp !== "hidden") {
            var transId = $(this).attr('transaction-id');
            dynamicData[i++] = [transId, $(this).attr('name'), $(this).val()];
            if ($(this).val() !== "") {
                total = total + parseFloat($(this).val());
            }
        } else {
            staticData[name] = $(this).val();
        }

        //alert(transId);

    });

    $('.restField textarea').each(function () {
        var name = $(this).attr('name');
        //name = name.replace('[]', '');
        staticData[name] = $(this).val();
    });
    staticData["total"] = total;
    //console.log(dynamicData);
    //console.log("Dynamic ends");
    //console.log(staticData);


    $.ajax({ //ajax for single bill payment
        type: 'POST',
        dataType: 'json',
        url: li + 'invoice_controller/update_invoice',
        data: {
            staticData: staticData,
            dynamicData: dynamicData

        },
        success: function (dataT) {
            //console.log(dataT);
            alert(dataT);

            jQuery("#editPayment").modal('hide');
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


});

//Is number check
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    // Added to allow decimal, period, or delete


    if (charCode == 110 || charCode == 190 || charCode == 46)
        return true;

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
} // isNumberKey


$('.forDeletePayment').on('click', function () {
    var conf = confirm('Are you sure to delete this invoice?');
    var invoice_id = $(this).attr('invoice-id');
    var deleterow = 'delete' + invoice_id;
    if (conf === true) {

        // $("#deleterow").remove();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: li + 'invoice_controller/delete_invoice',
            data: {
                invoice_id: invoice_id
            },
            success: function (dataT) {
                alert(dataT);
                $("#deleterow").remove();
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
