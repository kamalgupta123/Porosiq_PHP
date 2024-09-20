<table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Employee Code</th>
            <th>Employee Designation</th>
            <th>Month</th>
            <th>Year</th>
            <th>Total Time</th>
            <th>Bill Rate</th>
            <th>Total Time Pay</th>
            <th>Over Time</th>
            <th>Overtime Rate</th>
            <th>Overtime Pay</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($tot_time != '') {
            ?>
            <tr>
                <td>
                    <?php
                    if ($employee_name != '') {
                        echo $employee_name;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($employee_code != '') {
                        echo $employee_code;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($employee_designation != '') {
                        echo $employee_designation;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($month != '') {

                        if ($month == '01') {
                            echo "January";
                        } else if ($month == '02') {
                            echo "February";
                        } else if ($month == '03') {
                            echo "March";
                        } else if ($month == '04') {
                            echo "April";
                        } else if ($month == '05') {
                            echo "May";
                        } else if ($month == '06') {
                            echo "June";
                        } else if ($month == '07') {
                            echo "July";
                        } else if ($month == '08') {
                            echo "August";
                        } else if ($month == '09') {
                            echo "September";
                        } else if ($month == '10') {
                            echo "October";
                        } else if ($month == '11') {
                            echo "November";
                        } else if ($month == '12') {
                            echo "December";
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($year != '') {
                        echo $year;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($tot_time != '') {
                        echo $tot_time . " hours";
                    } else {
                        echo "0 hours";
                    }
                    ?>
                </td>
                <td>
    <?php
    if ($bill_rate != '') {
        echo "$" . number_format($bill_rate, 2);
    } else {
        echo "$0.00";
    }
    ?>
                </td>
                <td>
                    <?php
                    if ($tot_time_pay != '') {
                        echo "$" . number_format($tot_time_pay, 2);
                    } else {
                        echo "$0.00";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($over_time != '') {
                        echo $over_time . " hours";
                    } else {
                        echo "0 hours";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($ot_rate != '') {
                        echo "$" . number_format($ot_rate, 2);
                    } else {
                        echo "$0.00";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($over_time_pay != '') {
                        echo "$" . number_format($over_time_pay, 2);
                    } else {
                        echo "$0.00";
                    }
                    ?>
                </td>
            </tr>
                    <?php
                } else {
                    ?>
            <tr>
                <td colspan="11">No data found</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>