<table class="table table-bordered table-striped" style="font-size: 12px;" id="cons_his_timesheet_tbl">
    <thead>
        <tr>
            <th style="text-align: center;">Timesheet ID</th>
            <th style="text-align: center;">Project Code</th>
            <th style="text-align: center;">Project Name</th>
            <th style="text-align: center;">Code</th>
            <th style="text-align: center;">Name</th>
            <th style="text-align: center;">Type</th>
            <th style="text-align: center;">Start Date</th>
            <th style="text-align: center;">End Date</th>
            <th style="text-align: center;">ST</th>
            <th style="text-align: center;">OT</th>
            <?php if ($timesheet_status != "2") { ?>
            <th style="text-align: center;">Approved - Disapproved By</th>
            <th style="text-align: center;">User Type</th>
            <?php } ?>
            <?php if ($timesheet_status == "1") { ?>
            <th style="text-align: center;">Consultant Invoice</th>
            <th style="text-align: center;">Vendor Invoice</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    <?php 
    $start_date = "";
    $end_date = "";
    $cal_st = "";
    $cal_ot = "";
   

    if (!empty($historical_timesheet)) {
        foreach ($historical_timesheet as $tvalue) {

            $get_project_data = $this->employee_model->getProjectData($tvalue['project_id']);
            $get_employee_data = $this->employee_model->getEmployeeData($tvalue['employee_id']);

            $get_pr_invoice = $this->employee_model->getPrInvoice($tvalue['id']);
            $get_vn_invoice = $this->employee_model->getVnInvoice($tvalue['id']);

            if ($tvalue['approved_by'] != '') {
                if ($tvalue['approved_by'] == 'superadmin') {
                    $get_approved_by_details = $this->employee_model->getSuperAdminData($tvalue['approved_by_id']);
                    if (!empty($get_approved_by_details)) {
                        $approved_by = ucwords($get_approved_by_details[0]['sa_name']);
                    }
                } elseif ($tvalue['approved_by'] == 'admin') {
                    $get_approved_by_details = $this->employee_model->getAdminData($tvalue['approved_by_id']);
                    if (!empty($get_approved_by_details)) {
                        $approved_by = ucwords($get_approved_by_details[0]['first_name'] . " " . $get_approved_by_details[0]['last_name']);
                    }
                }

            } else {
                $approved_by = "";
            }

            $cal_st = $this->employee_model->getTotalST($tvalue['id']);
            $cal_ot = $this->employee_model->getTotalOT($tvalue['id']);

            $period_arr = explode("~", $tvalue['period']);
            $start_date = date("m-d-Y", strtotime($period_arr[0]));
            $ed = (isset($period_arr[1]) ) ? $period_arr[1] : "" ;
            $end_date = date("m-d-Y", strtotime($ed));
            ?>
            <tr>
                <td>
                    <a href="<?php echo base_url() . "sadmin-view-period-timesheet/" . base64_encode($tvalue['id']); ?>"><?php echo $tvalue['timesheet_id']; ?></a>
                </td>
                <td><?php echo $get_project_data[0]['project_code']; ?></td>
                <td><?php echo $get_project_data[0]['project_name']; ?></td>
                <td><?php echo $get_employee_data[0]['employee_code']; ?></td>
                <td><?php echo $get_employee_data[0]['first_name'] . " " . $get_employee_data[0]['last_name']; ?></td>
                <td>
                    <?php
                    if ($get_employee_data[0]['employee_type'] == 'C') {
                        echo "Consultant";
                    } elseif ($get_employee_data[0]['employee_type'] == 'E') {
                        echo "Employee";
                    }
                    ?>
                </td>
                <td><?php echo $start_date; ?></td>
                <td><?php echo $end_date; ?></td>
                <td><?php echo number_format($cal_st[0]['tot_time'], 2); ?></td>
                <td><?php echo number_format($cal_ot[0]['over_time'], 2); ?></td>
                <?php if ($timesheet_status != "2") { ?>
                <td>
                    <?php echo $approved_by; ?>
                </td>
                <td><?php if ($approved_by != "") { echo ucwords($tvalue['approved_by']); } ?></td>
                <?php } ?>
                 <?php if ($timesheet_status == "1") { ?>
                <td>
                    <?php
                    if(!empty($get_pr_invoice)){
                        ?>
                        <a class="tbl_icon fancybox"
                           href="<?php echo base_url('sa_invoice_pdf/' . base64_encode($get_pr_invoice[0]['id'])); ?>" target="_blank"
                           data-toggle="tooltip" title="Download PDF"><i
                                class="fa fa-eye"
                                aria-hidden="true" style="color: #09274b;"></i></a>
                        <?php
                    } else {
                        echo "";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if(!empty($get_vn_invoice)){
                        ?>
                        <a class="tbl_icon fancybox"
                           href="<?php echo base_url('superadmin_invoice_pdf/' . base64_encode($get_vn_invoice[0]['id'])); ?>" target="_blank"
                           data-toggle="tooltip" title="Download PDF"><i
                                class="fa fa-eye"
                                aria-hidden="true" style="color: #09274b;"></i></a>
                        <?php
                    } else {
                        echo "";
                    }
                    ?>
                </td>
                <?php } ?>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>

<script>

    $(function () {

        $('#cons_his_timesheet_tbl').DataTable({
            "order": [[ 6, "desc" ]]
        });

    });
</script>
