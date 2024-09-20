<?php
$this->load->view('superadmin/includes/header');
?>
    <style>
        .separator {
            border-right: 1px solid #dfdfe0;
        }

        .icon-btn-save {
            padding-top: 0;
            padding-bottom: 0;
        }

        .input-group {
            margin-bottom: 10px;
            width: 90%;
        }

        .btn-save-label {
            position: relative;
            left: -12px;
            display: inline-block;
            padding: 6px 12px;
            background: rgba(0, 0, 0, 0.15);
            border-radius: 3px 0 0 3px;
        }

        .formError .formErrorContent {
            min-width: 150px !important;
        }

        .cal-css {
            display: none;
        }

        .pen-css {
            display: none;
        }

        .pu-css {
            display: none;
        }

        .nmsdc-css {
            display: none;
        }

        .wbenc-css {
            display: none;
        }

        .sba-css {
            display: none;
        }

        .vetbiz-css {
            display: none;
        }

        .nglcc-css {
            display: none;
        }

        label {
            font-weight: 600;
        }
    </style>
    <div class="wrapper">

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-user"></span>
                                Vendor Details
                            </h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                    <table class="table table-bordered table-striped" width="100%" border="1"
                                           cellspacing="2" cellpadding="2">
                                        <tbody>

                                        <tr>
                                            <td width="25%">
                                                <label for="email">Company Logo</label>
                                            </td>
                                            <td width="25%">
                                                <?php
                                                if ($get_vendor_data[0]['photo'] != '') {
                                                    ?>
                                                    <img
                                                        src="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['photo']; ?>"
                                                        class="user-image"
                                                        alt="User Image" width="150" height="50">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img alt="User Image" class="user-image"
                                                         src="<?php echo base_url(); ?>assets/images/blank-profile.png"
                                                         width="150" height="50">
                                                    <?php
                                                }
                                                ?>

                                            </td>
                                            <td width="25%">&nbsp;</td>
                                            <td width="25%">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td width="25%">
                                                <label for="email">Admin Name</label>
                                            </td>
                                            <td width="25%">
                                                <label>
                                                    <?php
                                                    $get_admin_details = $this->vendor_model->getAdminDetails($get_vendor_data[0]['admin_id']);
                                                    if (!empty($get_admin_details)) {
                                                        echo ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']);
                                                    }
                                                    ?>
                                                </label>
                                            </td>
                                            <td width="25%">&nbsp;</td>
                                            <td width="25%">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">Prefix</label>
                                            </td>
                                            <td>
                                                <?php echo ucwords($get_vendor_data[0]['name_prefix']); ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">POC First Name</label>
                                            </td>
                                            <td>
                                                <?php echo ucwords($get_vendor_data[0]['first_name']); ?>
                                            </td>
                                            <td>
                                                <label for="email">POC Last Name</label>
                                            </td>
                                            <td>
                                                <?php echo ucwords($get_vendor_data[0]['last_name']); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">Designation</label>
                                            </td>
                                            <td>
                                                <?php echo ucwords($get_vendor_data[0]['vendor_designation']); ?>
                                            </td>
                                            <td>
                                                <label for="email">Company</label>
                                            </td>
                                            <td>
                                                <?php echo ucwords($get_vendor_data[0]['vendor_company_name']); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">Company ID</label>
                                            </td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['company_id']; ?>
                                            </td>
                                            <td>
                                                <label for="email">Federal Tax ID #</label>
                                            </td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['federal_tax_id']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">Email ID</label>
                                            </td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['vendor_email']; ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">Phone No.</label>
                                            </td>
                                            <td>
                                                <?php echo ($get_vendor_data[0]['phone_no'] != '0') ? $get_vendor_data[0]['phone_no'] : ''; ?>

                                            </td>
                                            <td>
                                                <label for="email">Fax No.</label>
                                            </td>
                                            <td>
                                                <?php echo ($get_vendor_data[0]['fax_no'] != '0') ? $get_vendor_data[0]['fax_no'] : ''; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">Country </label>
                                            </td>
                                            <td>
                                                <?php
                                                if (count($get_country) > 0) {
                                                    foreach ($get_country as $coval) {
                                                        if ($coval['id'] == $get_vendor_data[0]['country']) {
                                                            echo $coval['sortname'] . " - " . $coval['name'];
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <label for="email">State</label>
                                            </td>
                                            <td>
                                                <?php
                                                $state_arr = $this->vendor_model->getState($get_vendor_data[0]['country']);

                                                if (count($state_arr) > 0) {
                                                    foreach ($state_arr as $sval) {
                                                        if ($sval['id'] == $get_vendor_data[0]['state']) {
                                                            echo $sval['name'];
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">City</label>
                                            </td>
                                            <td>
                                                <?php
                                                $city_arr = $this->vendor_model->getCity($get_vendor_data[0]['state']);

                                                if (count($city_arr) > 0) {
                                                    foreach ($city_arr as $cval) {
                                                        if ($cval['id'] == $get_vendor_data[0]['city']) {
                                                            echo $cval['name'];
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <label for="email">Address</label>
                                            </td>
                                            <td>
                                                <?php echo stripslashes($get_vendor_data[0]['address']); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">Remittance Address</label>
                                            </td>
                                            <td>
                                                <?php echo stripslashes($get_vendor_data[0]['remittance_address']); ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Main Contact Person</label></td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['main_contact_person']; ?>
                                            </td>
                                            <td>
                                                <label for="email">Main Email Address</label>
                                            </td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['main_email_address']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Main Phone Number</label></td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['main_phone_no']; ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Billing Contact Person</label>
                                            </td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['billing_contact_person']; ?>
                                            </td>
                                            <td>
                                                <label for="email">Billing Email Address</label>
                                            </td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['billing_email_address']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Billing Phone Number</label></td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['billing_phone_no']; ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Additional Contact Person</label></td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['additional_contact_person']; ?>
                                            </td>
                                            <td>
                                                <label for="email">Additional Email Address</label>
                                            </td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['additional_email_address']; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Additional Phone Number</label></td>
                                            <td>
                                                <?php echo $get_vendor_data[0]['additional_phone_no']; ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Will you be providing Client support in the state
                                                    of California?</label></td>
                                            <td>
                                                <?php
                                                if ($get_vendor_data[0]['client_support_cal'] == '1') {
                                                    echo "Yes";
                                                } elseif ($get_vendor_data[0]['client_support_cal'] == '0') {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>

                                                <?php
                                                if ($get_vendor_data[0]['client_support_cal'] == '1') {

                                                    if (!empty($get_vendor_data[0]['client_support_cal_file']) && $get_vendor_data[0]['client_support_cal_file'] != '') {
                                                        ?>
                                                        <span class="">
                                                            <a href="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['client_support_cal_file']; ?>"
                                                               class="fancybox" style="color: #09274B;"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download
                                                            </a>
                                                        </span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Will you be providing Client support in the state
                                                    of Pennsylvania?</td>
                                            <td>
                                                <?php
                                                if ($get_vendor_data[0]['client_support_pen'] == '1') {
                                                    echo "Yes";
                                                } elseif ($get_vendor_data[0]['client_support_pen'] == '0') {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>

                                                <?php
                                                if ($get_vendor_data[0]['client_support_pen'] == '1') {

                                                    if (!empty($get_vendor_data[0]['client_support_pen_file']) && $get_vendor_data[0]['client_support_pen_file'] != '') {
                                                        ?>
                                                        <span class=""><a
                                                                href="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['client_support_pen_file']; ?>"
                                                                class="fancybox" style="color: #09274B;"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download </a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Will you be providing Client support in Puerto
                                                    Rico?</td>
                                            <td>
                                                <?php
                                                if ($get_vendor_data[0]['client_support_pu'] == '1') {
                                                    echo "Yes";
                                                } elseif ($get_vendor_data[0]['client_support_pu'] == '0') {
                                                    echo "No";
                                                }
                                                ?>

                                            </td>
                                            <td>&nbsp;</td>
                                            <td>

                                                <?php
                                                if ($get_vendor_data[0]['client_support_pu'] == '1') {

                                                    if (!empty($get_vendor_data[0]['client_support_pu_file']) && $get_vendor_data[0]['client_support_pu_file'] != '') {
                                                        ?>
                                                        <span class=""><a
                                                                href="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['client_support_pu_file']; ?>"
                                                                class="fancybox" style="color: #09274B;"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download </a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">National Minority Supplier Development Council
                                                    (NMSDC)</label></td>
                                            <td>
                                                <?php
                                                if ($get_vendor_data[0]['nmsdc'] == '1') {
                                                    echo "Yes";
                                                } elseif ($get_vendor_data[0]['nmsdc'] == '0') {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>

                                                <?php
                                                if ($get_vendor_data[0]['nmsdc'] == '1') {

                                                    if (!empty($get_vendor_data[0]['nmsdc_file']) && $get_vendor_data[0]['nmsdc_file'] != '') {
                                                        ?>
                                                        <span class=""><a
                                                                href="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['nmsdc_file']; ?>"
                                                                class="fancybox" style="color: #09274B;"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download </a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Women's Business Enterprise National Council
                                                    (WBENC)</label></td>
                                            <td>
                                                <?php
                                                if ($get_vendor_data[0]['wbenc'] == '1') {
                                                    echo "Yes";
                                                } elseif ($get_vendor_data[0]['wbenc'] == '0') {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>

                                                <?php
                                                if ($get_vendor_data[0]['wbenc'] == '1') {

                                                    if (!empty($get_vendor_data[0]['wbenc_file']) && $get_vendor_data[0]['wbenc_file'] != '') {
                                                        ?>
                                                        <span class=""><a
                                                                href="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['wbenc_file']; ?>"
                                                                class="fancybox" style="color: #09274B;"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download </a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Small Business Administration (SBA) (includes HUB
                                                    Zone) </label></td>
                                            <td>
                                                <?php
                                                if ($get_vendor_data[0]['sba'] == '1') {
                                                    echo "Yes";
                                                } elseif ($get_vendor_data[0]['sba'] == '0') {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>

                                                <?php
                                                if ($get_vendor_data[0]['sba'] == '1') {

                                                    if (!empty($get_vendor_data[0]['sba_file']) && $get_vendor_data[0]['sba_file'] != '') {
                                                        ?>
                                                        <span class=""><a
                                                                href="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['sba_file']; ?>"
                                                                class="fancybox" style="color: #09274B;"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download </a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">Center for Veteran's Enterprise (VetBiz.gov)
                                                </label></td>
                                            <td>
                                                <?php
                                                if ($get_vendor_data[0]['vetbiz'] == '1') {
                                                    echo "Yes";
                                                } elseif ($get_vendor_data[0]['vetbiz'] == '0') {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>

                                                <?php
                                                if ($get_vendor_data[0]['vetbiz'] == '1') {

                                                    if (!empty($get_vendor_data[0]['vetbiz_file']) && $get_vendor_data[0]['vetbiz_file'] != '') {
                                                        ?>
                                                        <span class=""><a
                                                                href="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['vetbiz_file']; ?>"
                                                                class="fancybox" style="color: #09274B;"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download </a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="email">National Gay & Lesbian Chamber of Commerce
                                                    (NGLCC)</label></td>
                                            <td>
                                                <?php
                                                if ($get_vendor_data[0]['nglcc'] == '1') {
                                                    echo "Yes";
                                                } elseif ($get_vendor_data[0]['nglcc'] == '0') {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>

                                                <?php
                                                if ($get_vendor_data[0]['nglcc'] == '1') {

                                                    if (!empty($get_vendor_data[0]['nglcc_file']) && $get_vendor_data[0]['nglcc_file'] != '') {
                                                        ?>

                                                        <span class=""><a
                                                                href="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_data[0]['nglcc_file']; ?>"
                                                                class="fancybox" style="color: #09274B;"><i
                                                                    class="fa fa-download" aria-hidden="true"></i>
                                                                Download </a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="email">Contract From Date </label>
                                            </td>
                                            <td>
                                                <?php echo ($get_vendor_data[0]['contract_from_date'] != '0000-00-00') ? date("m-d-Y", strtotime($get_vendor_data[0]['contract_from_date'])) : ""; ?>
                                            </td>
                                            <td>
                                                <label for="email">Contract To Date</label>
                                            </td>
                                            <td>
                                               <?php echo ($get_vendor_data[0]['contract_to_date'] != '0000-00-00') ? date("m-d-Y", strtotime($get_vendor_data[0]['contract_to_date'])) : ""; ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">&nbsp;</div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->

    </div>
    <!-- ./wrapper -->
<?php
$this->load->view('superadmin/includes/footer');
?>