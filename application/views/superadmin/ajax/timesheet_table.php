                            <table class="table table-bordered table-striped" style="font-size: 12px;" id="timesheet_tbl">
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
                                        <th style="text-align: center;">Timesheet Status</th>
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
                                            $ed = (isset($period_arr[1])) ? $period_arr[1] : "";  # To prevent undefined offset error
                                            $end_date = date("m-d-Y", strtotime($ed));
											if(($get_employee_data[0]['employee_type'] == 'C') || ($get_employee_data[0]['employee_type'] == 'E')){
												$url = base_url() . "sadmin-view-period-timesheet/";
											}else{
												$url = base_url() . "sadmin-view-ten99user-period-timesheet/";
											}
											//echo $url;
                                            ?>
                                            <tr>
                                                <td><a href="<?php echo $url . base64_encode($tvalue['id']); ?>"><?php echo $tvalue['timesheet_id']; ?></a></td>
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
                                                    }else{
														echo "1099";
													}
                                                    ?>
                                                </td>
                                                <td><?php echo $start_date; ?></td>
                                                <td><?php echo $end_date; ?></td>
                                                <td><?php echo number_format($cal_st[0]['tot_time'], 2); ?></td>
                                                <td><?php echo number_format($cal_ot[0]['over_time'], 2); ?></td>
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