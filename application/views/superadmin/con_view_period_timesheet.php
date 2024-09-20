<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
    <tr>
        <th style="text-align: center;">Timesheet ID</th>
        <th style="text-align: center;">Project Code</th>
        <th style="text-align: center;">Project Name</th>
        <th style="text-align: center;">Start Date</th>
        <th style="text-align: center;">End Date</th>
        <th style="text-align: center;">ST</th>
        <th style="text-align: center;">OT</th>
        <th style="text-align: center;">Comment</th>
        <th style="text-align: center;">Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $start_date = "";
    $end_date = "";
    $st = "";
    $ot = "";
    if (!empty($get_timesheet_details)) {
        foreach ($get_timesheet_details as $tkey => $tvalue) {

            $get_project_data = $this->employee_model->getProjectData($tvalue['project_id']);
            $get_employee_data = $this->employee_model->getEmployeeData($tvalue['employee_id']);

            $cal_st = $this->employee_model->getTotalST($tvalue['id']);
            $cal_ot = $this->employee_model->getTotalOT($tvalue['id']);

            $period_arr = explode("~", $tvalue['period']);
            $start_date = date("m-d-Y", strtotime($period_arr[0]));
            $end_date = date("m-d-Y", strtotime($period_arr[1]));
            ?>
            <tr>
                <td><label><?php echo $tvalue['timesheet_id']; ?></label></td>
                <td><?php echo $get_project_data[0]['project_code']; ?></td>
                <td><?php echo $get_project_data[0]['project_name']; ?></td>
                <td><?php echo $start_date; ?></td>
                <td><?php echo $end_date; ?></td>
                <td><?php echo number_format($cal_st[0]['tot_time'], 2); ?></td>
                <td><?php echo number_format($cal_ot[0]['over_time'], 2); ?></td>
                <td>
                    <?php
                    echo stripslashes($tvalue['comment']);
                    ?>
                </td>
                <td>
                    <?php
                    if ($tvalue['status'] == '0') {
                        ?>
                        <span style="color: red;">Not Approved</span>
                        <?php
                    } elseif ($tvalue['status'] == '1') {
                        ?>
                        <span style="color: green;">Approved</span>
                        <?php
                    } elseif ($tvalue['status'] == '2') {
                        ?>
                        <span style="color: #f39c12;">Pending Approval</span>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
<br>
<table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
    <tr>
        <th>Day</th>
        <th>Date</th>
        <th>ST/Hr</th>
        <th>OT/Hr</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($get_timesheet_period_details)) {
        foreach ($get_timesheet_period_details as $pval) {
            ?>
            <tr>
                <td><?php echo date("l", strtotime($pval['project_date'])); ?></td>
                <td><?php echo date("m-d-Y", strtotime($pval['project_date'])); ?></td>
                <td><?php echo $pval['tot_time']; ?></td>
                <td><?php echo $pval['over_time']; ?></td>
                <td>
                    <?php
                    if ($pval['approved_by_status'] == '0') {
                        ?>
                        <span style="color: red;">Not Approved</span>
                        <?php
                    } elseif ($pval['approved_by_status'] == '1') {
                        ?>
                        <span style="color: green;">Approved</span>
                        <?php
                    } elseif ($pval['approved_by_status'] == '2') {
                        ?>
                        <span style="color: #f39c12;">Pending Approval</span>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>