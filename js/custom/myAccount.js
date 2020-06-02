var li;
$(document).ready(function() {
    li = links();
});


function parent_change(id,headName) {
    //alert(id);

    var field="";
    field = field + "<div class='row col-md-12'>"
    +"<button type='button' onclick='addLedger("+id+")' class='btn btn-info btn-lg' style='margin:5px;' >Create Ledger</button>"
    +"<button type='button' onclick='getLedger("+id+")' class='btn btn-success btn-lg' style='margin:5px;'>Ledger All</button>"
    +"</div>";
    document.getElementById("re").innerHTML=field;
}



function getLedger(id) {


    $("#pp").show();
    $(".img").show();
    var allLedger = "";
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url:li+'account_permission/myTransaction',
        data: {
            id: id
        },
        success: function (dataT) {
            $(".img").hide();
            // console.log(dataT);
            var j = 1;
            for (var i=0; i<dataT.acc_head.length;i++ ){
                allLedger = allLedger+ "<div class='row col-md-12'>"
                +"<label style='font-size:15px;text-align:left;' class='col-sm-6 control-label'>"+j+')'+dataT.acc_head[i].name+"</label>"
                +"</div>";
                j++;
            }

            document.getElementById("myLedger").innerHTML=allLedger;

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


function addLedger(id) {
    $("#ledger_submit").val(id);
    jQuery("#cLedger").modal('show');

}
$('#ledger_submit').on("click", function() {
    var ac_head_name = $("#ac_head_name").val();
    var ledgerId = $(this).val();


    $.ajax({
        type: 'POST',
        dataType: 'json',
        url:li+'account_permission/addLedger',
        data: {
            ledgerId: ledgerId, ac_head_name : ac_head_name
        },
        success: function (dataT) {
            $('input').val('');
            jQuery("#cLedger").modal('hide');

            alert(dataT);

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