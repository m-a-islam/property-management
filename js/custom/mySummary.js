var li;
$(document).ready(function() {
    li = links();
});



$( function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
} );


$('.summary-submit').on('click',function () {
    var start = $('.starttD').val();
    var end = $('.endtD').val();
    if (start == "" || end == ""){
        alert("Please Select start date and end date!");
    }else{
        $.ajax({
            type: 'POST',
            //dataType: 'json',
            url: li + 'summary/get_totalSummary',
            data: {
                start: start,
                end: end
            },
            success: function (response) {
                //console.log(response);
                jQuery('.load_summaryContent').html(response);

            }
        });

    }
});