var li;
$(document).ready(function () {
    li = links();
});
$('.forDueDetails').on('click', function () {

    var flat_id = $(this).attr('flat-id');
    var building_id = $(this).attr('buildd-id');
    var ware_id = $(this).attr('ware-id');
    var start_date = $(this).attr('frm-date');
    var end_date = $(this).attr('t-date');
    var generated_total = $(this).attr('total-generated');
    var paid_total = $(this).attr('total-paid');
    var previous_due = $(this).attr('pre-due');
    var current_due = Number(Number(generated_total)-Number(paid_total));
    var total_due = Number(Number(current_due)+ Number(previous_due));
    /*alert(flat_id);
    alert(building_id);
    alert(ware_id);*/
    $.ajax({ //ajax for getting a view according to building_id
        type: 'POST',
        dataType: 'json',
        url: li + 'dueList_controller/details_dueList',
        data: {
            flat_id: flat_id,
            building_id: building_id,
            ware_id: ware_id,
            start_date: start_date,
            end_date: end_date
        },
        success: function (respose) {
        //console.log(respose.generatedBillDetails);
        //console.log(respose.transactionDetails);
        jQuery("#dueDetails").modal('show');
        $("#generatedDetails").html(makeGeneratedTableDetails(respose.generatedBillDetails,generated_total));
        $("#transactionDetails").html(makeTransactionTableDetails(respose.transactionDetails,paid_total));
        $("#summary").html("<h4> Previous Due: "+ previous_due +"<br>Due:"+ current_due +"<br>Total Due: "+ total_due +"</h4>");

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

function makeGeneratedTableDetails(generatedBillDetails,generatedTotal)
{
    var tabl = "<h3><u>Generated Bill</u></h3><div class='col-md-12'>" +
        " <div class='table-responsive'> " +
        "<table border='3' class='table table-bordered table-bordered table-condensed'>" +
            "<thead>" +
                "<th>Date</th>" +
                "<th>Particular</th>" +
                "<th>Amount</th>" +
            "</thead>" +
        "<tbody>";
    for (var i=0; i<generatedBillDetails.length;i++){
        tabl = tabl
        + "<tr>"
            + "<td>"+generatedBillDetails[i].date_time.substr(0, 10)+"</td>"
            + "<td>"+generatedBillDetails[i].name+"</td>"
            + "<td>"+generatedBillDetails[i].generateAmount+"</td>"
        + "</tr>"
    }
    tabl = tabl+"<tr><td colspan='2'>Total Generated:</td><td>"+generatedTotal+"</td></tr></tbody>";
    return tabl;
}
function makeTransactionTableDetails(transactionDetails,paidTotal)
{
    var tabl = "<h3><u>Paid Bill</u></h3><div class='col-md-12'>" +
        " <div class='table-responsive'> " +
        "<table border='3' class='table table-bordered table-bordered table-condensed'>" +
        "<thead>" +
            "<th>Date</th>" +
            "<th>Particular</th>" +
            "<th>Amount</th>" +
        "</thead>" +
        "<tbody>";
    for (var i=0; i<transactionDetails.length;i++){
        if(transactionDetails[i].payment_type==1){
            tabl = tabl
                + "<tr>"
                    + "<td>"+transactionDetails[i].date+"</td>"
                    + "<td>"+transactionDetails[i].name+"</td>"
                    + "<td>-"+transactionDetails[i].transactionAmount+"</td>"
                + "</tr>"
        }else{
            tabl = tabl
                + "<tr>"
                    + "<td>"+transactionDetails[i].date+"</td>"
                    + "<td>"+transactionDetails[i].name+"</td>"
                    + "<td>"+transactionDetails[i].transactionAmount+"</td>"
                + "</tr>"
        }
    }
    tabl = tabl+"<tr><td colspan='2'>Total Paid:</td><td>"+paidTotal+"</td></tr></tbody>";
    return tabl;
}
function printDiv(divName){
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}