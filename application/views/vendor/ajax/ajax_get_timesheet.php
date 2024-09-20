<?php
$data = array();
$json = array();
if (!empty($get_timesheet_data)) {
    foreach ($get_timesheet_data as $tval) {
        $data["title"] = stripslashes($tval['comment']);
        $data["start"] = $tval['project_date']."T".$tval['start_time'].":00";
        $data["end"] = $tval['project_date']."T".$tval['end_time'].":00";
        //$data["url"] = base_url('edit_timesheet/' . base64_encode($tval['project_id']));

        $json[] = $data;
    }
    echo json_encode($json);
}
?>