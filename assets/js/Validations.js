$(function () {

    function myDateFormatter (date) {

        var d = new Date(date);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();

        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }

        var date = year + "-" + month + "-" + day;
        return date;
        
    }

    $('#start_date').on('change',function(){
        var date = new Date($(this).val());
        date. setDate(date. getDate() + 7);
        $("#end_date").attr('max',myDateFormatter(date));
        $("#end_date").attr('min',myDateFormatter($(this).val()));
        $('#end_date').val('yyyy-MM-dd');
    });

});

function fetchDate() {

    var project_id = $("#project_id").val();
//        alert(project_id);
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();

    if (project_id != '' && start_date != '' && end_date != '') {
        $.post(url, {
            project_id: project_id,
            start_date: start_date,
            end_date: end_date
        }, function (data) {
            //alert(data);
            $("#timesheet_list").html(data);
        });
    } else if (project_id == '') {
        $("#timesheet_list").html('');
    } else if (start_date == '') {
        $("#timesheet_list").html('');
    } else if (end_date == '') {
        $("#timesheet_list").html('');
    }
}
