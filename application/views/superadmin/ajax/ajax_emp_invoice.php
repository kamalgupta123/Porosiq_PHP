<table id="emp_invoice_tbl" class="table table-bordered table-striped table-responsive"
                                           style="font-size: 11px;" width="100%">
    <thead>
        <tr>
            <th width="1%">SL No.</th>
            <th>Invoice ID</th>
            <th>Timesheet ID</th>
            <th>Employee Name</th>
            <th>Employee Code</th>
            <th>Employee Designation</th>
            <th>Payment Mode</th>
            <th>Date</th>
            <th>Time</th>
            <th>Rate</th>
            <th>Pay</th>
            <th>Invoice Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if (count($get_emp_invoice_details)) {
            foreach ($get_emp_invoice_details as $aeval) {
                $get_employee_details = $this->employee_model->getEmployeeData($aeval['employee_id']);
                $get_timesheet_period_details = $this->employee_model->getTimesheetDetailsByID($aeval['timesheet_period_id']);
                ?>
                <tr>
                     <td><?php echo $i; ?></td>
                    <td><?php echo $aeval['invoice_code']; ?></td>
                    <td><a href="<?php echo base_url() . "sadmin-view-period-timesheet/" . base64_encode($aeval['timesheet_period_id']); ?>"><?php echo $get_timesheet_period_details[0]['timesheet_id']; ?></a></td>
                    <td><?php echo $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']; ?></td>
                    <td><?php echo $get_employee_details[0]['employee_code']; ?></td>
                    <td><?php echo $get_employee_details[0]['employee_designation']; ?></td>
                    <td>
                        <?php
                        if ($aeval['payment_type'] == '1') {
                            echo "Net 45";
                        } elseif ($aeval['payment_type'] == '2') {
                            echo "Net 45";
                        } elseif ($aeval['payment_type'] == '3') {
                            echo "Net 45";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        echo ($aeval['start_date'] != '0000-00-00') ? $aeval['start_date'] : '';
                        echo " - ";
                        echo ($aeval['end_date'] != '0000-00-00') ? $aeval['end_date'] : '';
                        ?>
                    </td>
                    <td>
                        <div><strong>Standard Time
                                :</strong><br/> <?php echo $aeval['tot_time'] . " hours"; ?>
                        </div>
                        <br/>

                        <div><strong>Over Time
                                :</strong><br/> <?php echo $aeval['over_time'] . " hours"; ?>
                        </div>
                    </td>
                    <td>
                        <div><strong>Standard Rate
                                :</strong><br/> <?php echo ($aeval['bill_rate'] != '') ? "$" . number_format($aeval['bill_rate'], 2) : "0.00"; ?>
                        </div>
                        <br/>

                        <div><strong>Over Time Rate
                                :</strong><br/> <?php echo ($aeval['ot_rate'] != '') ? "$" . number_format($aeval['ot_rate'], 2) : "0.00"; ?>
                        </div>
                    </td>
                    <td>
                        <div><strong>Standard Pay
                                :</strong><br/> <?php echo ($aeval['tot_time_pay'] != '') ? "$" . number_format($aeval['tot_time_pay'], 2) : "0.00"; ?>
                        </div>
                        <br/>

                        <div><strong>Over Time Pay
                                :</strong><br/> <?php echo ($aeval['over_time_pay'] != '') ? "$" . number_format($aeval['over_time_pay'], 2) : "0.00"; ?>
                        </div>

                    </td>
                    <td>
                        <?php
                        if ($aeval['status'] == '0') {
                            ?>
                            <label style="color:#e08e0b;">Pending Approval</label>
                            <?php
                        } else {
                            ?>
                            <label style="color:green;">Invoice Approved</label>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php

                $i++; 
            }
        }
        ?>

    </tbody>

</table>

<script>

    $(function () {

        $('#emp_invoice_tbl').DataTable({
            //"order": [[ 6, "desc" ]]
        });

    });
</script>