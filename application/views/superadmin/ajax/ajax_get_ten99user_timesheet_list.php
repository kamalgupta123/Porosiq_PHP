<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.css">
<?php
if (!empty($get_project_details)) {
    $project_code = $get_project_details[0]['project_code'];
    $project_name = $get_project_details[0]['project_name'];
}
if (isset($start_date)) {
    $timesheet_start_date = $start_date;
}
if (isset($end_date)) {
    $timesheet_end_date = $end_date;
}
if (isset($timesheet_id)) {
    $timesheet_id = $timesheet_id;
}
$period = $start_date . "~" . $end_date;

$begin = new DateTime(date("Y-m-d", strtotime($timesheet_start_date)));
$end = new DateTime(date("Y-m-d", strtotime($timesheet_end_date)));
$end = $end->modify('+1 day');

$interval = new DateInterval('P1D');
$daterange = new DatePeriod($begin, $interval, $end);
//print_r($daterange);
//echo "<br>";
?>
<table id="admin_tbl" width="100%" class="table table-bordered table-striped" style="font-size: 11px;" border="1">
    <thead>
    <tr>
        <th>Timesheet ID</th>
        <th>Project Code</th>
        <th>Project Name</th>
        <th>Current End Date</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo $timesheet_id; ?></td>
        <td><?php echo $project_code; ?></td>
        <td><?php echo $project_name; ?></td>
        <td><?php echo $timesheet_end_date; ?></td>
    </tr>
    </tbody>
</table>
<table id="admin_tbl" width="100%" class="table table-bordered table-striped" style="font-size: 11px;" border="1">
    <thead>
    <tr>
        <th>Day</th>
        <?php
        if (!empty($daterange)) {
            foreach ($daterange as $date) {
                ?>
                <th><?php echo $date->format("jS F Y") . " [" . $date->format("D") . "]"; ?></th>
                <input type="hidden" name="project_date[]" value="<?php echo $date->format("Y-m-d"); ?>">
                <?php
            }
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Start Time</td>
        <?php
        if (!empty($daterange)) {
            foreach ($daterange as $date) {
                ?>
                <td>
                    <input type="text" name="start_time[]" class="timepicker validate[required]" data-time-format="H:i" data-step="15" data-show-2400="true"/>
                </td>
                <?php
            }
        }
        ?>
    </tr>
    <tr>
        <td>End Time</td>
        <?php
        if (!empty($daterange)) {
            foreach ($daterange as $date) {
                ?>
                <td>
                    <input type="text" name="end_time[]" class="timepicker validate[required]" data-time-format="H:i" data-step="15" data-show-2400="true"/>
                </td>
                <?php
            }
        }
        ?>
    </tr>
    </tbody>
</table>
<input type="hidden" name="period" value="<?php echo $period; ?>">
<input type="hidden" name="timesheet_id" value="<?php echo $timesheet_id; ?>">

<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.timepicker.js"></script>
<script>
    $(function(){
        $('.timepicker').timepicker();
    })
</script>


