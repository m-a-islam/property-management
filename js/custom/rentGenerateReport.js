var li;
$(document).ready(function() {
    li = links();
});

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


$('.rent-generate-submit').on('click',function () {
    var building_id = $('#build_id').val();
    var flat_id = $('#flat_id').val();
    var dateMonth = $('.datepickerMonth').val();
    //alert(dateMonth);
    //console.log(building_id+flat_id);
    // alert(typeof flat_id);
    // alert(flat_id);
    if (building_id === "" || flat_id===""){
        alert("Please Select Building first then select flat!");
    }else if (dateMonth=== ""){
        alert("Please Select date!");
    }else{
        $.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'payment/get_building_all_flats_specific_flats',
            data: {
                building_id: building_id,
                flat_id : flat_id,
                dateMonth: dateMonth
            },
            success: function (response) {
                //console.log(response);
                jQuery('.load_GenerateReport').html(response);

            }
        });
    }
    //console.log(building_id+" "+flat_id+" "+ dateMonth);
});

