                                    <table id="van_tbl" class="table table-bordered table-striped table-responsive"
                                           style="font-size: 11px;" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="1%">SL No.</th>
                                                <th>Invoice ID</th>
                                                <th>Timesheet ID</th>
                                                <th>Consultant Name</th>
                                                <th>Consultant Code</th>
                                                <th>Consultant Designation</th>
                                                <th>Point of Contact</th>
                                                <th>Company Name</th>
                                                <th>Admin Name</th>
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
                                            if (count($get_invoice_details)) {

                                                foreach ($get_invoice_details as $vanval) {

                                                    $get_employee_details = $this->employee_model->getEmployeeData($vanval['employee_id']);
                                                    $get_timesheet_period_details = $this->employee_model->getTimesheetDetailsByID($vanval['timesheet_period_id']);
                                                    $invoice_code = $this->employee_model->getInvoiceCodeByID($vanval['timesheet_period_id'], $vanval['vendor_id']);
                                                    $get_vendor_details = $this->profile_model->getVendorData($vanval['vendor_id']);
                                                    if (!empty($get_vendor_details)) {
                                                        $vendor_name = ucwords(strtolower($get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name']));
                                                        $vendor_company_name = ucwords($get_vendor_details[0]['vendor_company_name']);
                                                        $get_admin_details = $this->profile_model->getAdminData($get_vendor_details[0]['admin_id']);
                                                        if (!empty($get_admin_details)) {
                                                            $admin_name = ucwords(strtolower($get_admin_details[0]['first_name']) . " " . strtolower($get_admin_details[0]['last_name']));
                                                        }
                                                    }

                                                    if ($vanval['status'] == '0') {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td> 
                                                                <?php if ($get_timesheet_period_details[0]['status'] != '0') { ?>
                                                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                                                       title="Approve Invoice"
                                                                       onclick="getApprove('<?php echo $vanval['id']; ?>')"
                                                                       style="color: green;"><i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                                           <?php echo $invoice_code[0]['invoice_code']; ?>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    Timesheet Not Approved
                                                                <?php } ?>
                                                            </td>
                                                            <td><a href="<?php echo base_url() . "sadmin-view-period-timesheet/" . base64_encode($vanval['timesheet_period_id']); ?>"><?php echo $get_timesheet_period_details[0]['timesheet_id']; ?></a></td>
                                                            <td><?php echo $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']; ?></td>
                                                            <td><?php echo $get_employee_details[0]['employee_code']; ?></td>
                                                            <td><?php echo $get_employee_details[0]['employee_designation']; ?></td>
                                                            <td><?php echo $vendor_name; ?></td>
                                                            <td><?php echo $vendor_company_name; ?></td>
                                                            <td><?php echo $admin_name; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($vanval['payment_type'] == '1') {
                                                                    echo "Net 45";
                                                                } elseif ($vanval['payment_type'] == '2') {
                                                                    echo "Net 45";
                                                                } elseif ($vanval['payment_type'] == '3') {
                                                                    echo "Net 45";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo ($vanval['start_date'] != '0000-00-00') ? $vanval['start_date'] : '';
                                                                echo " - ";
                                                                echo ($vanval['end_date'] != '0000-00-00') ? $vanval['end_date'] : '';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <div><strong>Standard Time
                                                                        :</strong><br/> <?php echo $vanval['tot_time'] . " hours"; ?>
                                                                </div>
                                                                <br/>

                                                                <div><strong>Over Time
                                                                        :</strong><br/> <?php echo $vanval['over_time'] . " hours"; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div><strong>Standard Rate
                                                                        :</strong><br/> <?php echo ($vanval['bill_rate'] != '') ? "$" . number_format($vanval['bill_rate'], 2) : "0.00"; ?>
                                                                </div>
                                                                <br/>

                                                                <div><strong>Over Time Rate
                                                                        :</strong><br/> <?php echo ($vanval['ot_rate'] != '') ? "$" . number_format($vanval['ot_rate'], 2) : "0.00"; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div><strong>Standard Pay
                                                                        :</strong><br/> <?php echo ($vanval['tot_time_pay'] != '') ? "$" . number_format($vanval['tot_time_pay'], 2) : "0.00"; ?>
                                                                </div>
                                                                <br/>

                                                                <div><strong>Over Time Pay
                                                                        :</strong><br/> <?php echo ($vanval['over_time_pay'] != '') ? "$" . number_format($vanval['over_time_pay'], 2) : "0.00"; ?>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($vanval['status'] == '0') {
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
                                                    }
                                                    $i++;
                                                }
                                            }
                                            ?>

                                        </tbody>

                                    </table>