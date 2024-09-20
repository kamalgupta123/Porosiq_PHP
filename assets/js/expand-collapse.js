function expandCollapse() {
    if($("#timesheet").css('display') == 'none') {
        $("#expand-collapse").html("Collapse");
        $("#timesheet").show("slow");
    } else {
        $("#expand-collapse").html("Expand");
        $("#timesheet").hide("slow");
    }
}

function expandCollapseConsultant() {
    if($("#consultant_invoice").css('display') == 'none') {
        $("#expand-collapse-cons").html("Collapse");
        $("#consultant_invoice").show("slow");
    } else {
        $("#expand-collapse-cons").html("Expand");
        $("#consultant_invoice").hide("slow");
    }
}

function expandCollapseEmployee() {
    if($("#employee_invoice").css('display') == 'none') {
        $("#expand-collapse-emp").html("Collapse");
        $("#employee_invoice").show("slow");
    } else {
        $("#expand-collapse-emp").html("Expand");
        $("#employee_invoice").hide("slow");
    }
}

function expandCollapseUser() {
    if($("#user_invoice").css('display') == 'none') {
        $("#expand-collapse-user").html("Collapse");
        $("#user_invoice").show("slow");
    } else {
        $("#expand-collapse-user").html("Expand");
        $("#user_invoice").hide("slow");
    }
}