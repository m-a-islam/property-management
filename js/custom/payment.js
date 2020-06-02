var li;
$(document).ready(function() {
    li = links();
});



$( function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
} );




$( function() {
    $('.datepickerMonth').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
} );
//fetching data using build id on change start
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
            var flt = "<option value='all' >All Flat</option>";
            for (var i = 0; i < msg.length; i++)
            {
                if(msg[i].status==1){//showing only active flat for generating bill
                    flt = flt
                    + "<option value='"+msg[i].id+"' >" + msg[i].flat_number + "</option>";
                }
            }
            if (flt == "<option value='all' >All Flat</option>") {
                flt = "<option value='' >No active flat</option>";
            }
            $("#flat_id").html(flt);

        }
    });
});
//fetching data using build id on change end

$('.rent-receipt-submit').on('click',function () {
 var building_id = $('#build_id').val();
  // var flat_id = $('#flat_id').val();
  var dateMonth = $('.datepickerMonth').val();
   //alert(dateMonth);
   //console.log(building_id+flat_id);
    //alert(typeof building_id);
    //alert(flat_id);
    if (building_id === ""){
        alert("Please Select Building!");
    }else if (dateMonth=== ""){
        alert("Please Select date!");
    }else{
        $.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'payment/get_building_all_flats',
            data: {
                building_id: building_id,

                dateMonth: dateMonth
            },
            success: function (response) {
                //console.log(response);
                jQuery('.load_payContent').html(response);

            }
        });
    }
    //console.log(building_id+" "+flat_id+" "+ dateMonth);
});


$('.expense-submit').on('click',function () {
    var start = $('.starttD').val();
    var ledger = $('#ledger').val();
    var end = $('.endtD').val();
   
    if (start == "" || end == ""){
        alert("Please Select start date and end date!");
    }else if(ledger == ""){
        alert("Please Select Ledger!");
    }else{
        // alert(ledger);
        // alert(start);
        // alert(end);
        $.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'payment/get_expenseReport',
            data: {
                start: start,
                end: end,
                ledger: ledger
            },
            success: function (response) {
                //console.log(response);
                jQuery('.load_expenseContent').html(response);

            }
        });

    }
});


// <?php echo base_url();?>

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    // Added to allow decimal, period, or delete


    if (charCode == 110 || charCode == 190 || charCode == 46)
        return true;

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
} // isNumberKey

$('#cash_bank_pay').on('click',function(){
    var conf = confirm('Are you sure to submit?');

    var payType = $('#payType').val();
    var exp_ledger = $('#exp_ledger').val();
    var exp_amount = $('#exp_amount').val();
    var exp_date = $('#exp_date').val();
    var nots = $('#nots').val();
    if (conf===true) {
        if (payType=="") {
            alert('Select Payment Type!');
        }else if (payType === exp_ledger ) {
            alert('Both field can not be same!');
        }else if (exp_ledger == "") {
            alert('Select Pay for field!');
        }else if (exp_amount=="") {
            alert('Give amount Please!');
        }else if (exp_date=="") {
            alert('Select date please!');
        }else{
            $.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'payment/add_cash_bank_payment',
            data: {
                payType: payType,
                exp_ledger: exp_ledger,
                exp_amount: exp_amount,
                exp_date: exp_date,
                nots: nots
            },
            success: function (response) {
               // alert('Inserted Successfully!');
               window.location.href= li + 'payment/cash_bank_payment';

            }
        });
        }
    }
});