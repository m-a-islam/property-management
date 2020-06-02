var li;
$(document).ready(function() {
    li = links();
});
$(document).on("focus", ".datepicker", function () {
    $(this).datepicker({dateFormat: 'dd-mm-yy'});
});

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

$('.collection-report-submit').on('click',function () {
    // alert("Hello");
    var building_id = $('#build_id').val();
    var flat_id = $('#flat_id').val();
    var start = $('.startD').val();
    var end = $('.endD').val();
    //alert(dateMonth);
    // console.log(building_id+flat_id);
    /* alert(start);
     alert(end);
     alert(building_id);
     alert(flat_id);*/
    if (building_id === "" || flat_id === ""){
        alert("Please Select Building first then select flat!");
    }else if (start === "" || end === ""){
        alert("Please Select start date and end date!");
    }else{
        $(".img").show();
        $.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'collection_controller/get_collectionReport',
            data: {
                building_id: building_id,
                flat_id : flat_id,
                start: start,
                end: end
            },
            success: function (response) {
                $(".img").hide();
                //console.log(response);
                jQuery('.load_collectionReportContent').html(response);

            }
        });
    }
    //console.log(building_id+" "+flat_id+" "+ dateMonth);
});