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
    label{
        font-weight: 600;
    }
</style>
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>dashboard" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <?php
            $this->load->view('superadmin/includes/upper_menu');
            ?>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <?php
            $this->load->view('superadmin/includes/user_panel');
            $this->load->view('superadmin/includes/sidebar');
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Vendor
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Vendor User</a></li>
                <li class="active">Add Vendor User</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-user"></span>
                                Add Vendor User
                                <p style="float: right;font-size: 11px;"><span style="color:red;">*</span>Required Fields</p>
                            </h3>
                        </div>

                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div
                                class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>

                        <form id="add_admin_form"
                              action="<?php echo site_url('insert_vendor'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1"
                                               cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email">Company Logo <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td width="25%">
                                                        <input class="image-file validate[required]" type="file" name="photo">
                                                        <span style="color: #ff2121;">(Max File Size : 2MB)</span>
                                                    </td>
                                                    <td width="25%"><label for="email">Admin Name<span
                                                                style="color: red;">*</span></label></td>
                                                    <td width="25%">
                                                        <select name="admin_id" id="admin_id"
                                                                class="form-control validate[required]">
                                                            <option value="">Select Admin</option>
                                                            <?php
                                                            if (count($get_admin) > 0) {
                                                                foreach ($get_admin as $aval) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $aval['admin_id']; ?>"><?php echo $aval['first_name'] . " " . $aval['last_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Prefix</label>
                                                    </td>
                                                    <td>
                                                        <input type="radio" id="name_prefix1" name="name_prefix" value="Mr."
                                                               checked> Mr.
                                                        <input type="radio" id="name_prefix2" name="name_prefix"
                                                               value="Mrs."> Mrs.
                                                        <input type="radio" id="name_prefix3" name="name_prefix"
                                                               value="Ms."> Ms.
                                                        <input type="radio" id="name_prefix4" name="name_prefix"
                                                               value="Dr."> Dr.
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">POC First Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="first_name" name="first_name" placeholder="First Name"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <label for="email">POC Last Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="last_name" name="last_name" placeholder="Last Name"
                                                               value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Designation <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="vendor_designation"
                                                               name="vendor_designation" placeholder="Designation" value="">
                                                    </td>
                                                    <td>
                                                        <label for="email">Company <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="text"
                                                               id="vendor_company_name" name="vendor_company_name"
                                                               placeholder="Company" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Company ID </label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" id="company_id"
                                                               name="company_id" placeholder="Company ID" value="">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label for="email">Federal Tax ID #<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyNumberSp],minSize[9],maxSize[10]]" type="text"
                                                               id="federal_tax_id" name="federal_tax_id"
                                                               placeholder="Federal Tax ID" value="">
                                                    </td>
                                                    <td>
                                                        <label for="email">Email ID<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[email]]"
                                                               type="text" id="vendor_email" name="vendor_email"
                                                               placeholder="Email ID" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Password<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="password"
                                                               id="password" name="password" placeholder="New Password">
                                                    </td>
                                                    <td>
                                                        <label for="email">Confirm Password<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,equals[password]]"
                                                               type="password" id="conf_password" name="conf_password"
                                                               placeholder="Confirm New Password">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Phone No. <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input
                                                            class="form-control validate[required,custom[phone],minSize[10],maxSize[10]]"
                                                            type="text"
                                                            id="phone_no" name="phone_no" placeholder="Phone No."
                                                            value="">
                                                    </td>
                                                    <td>
                                                        <label for="email">Fax No.</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[custom[onlyNumberSp]]" type="text"
                                                               id="fax_no" name="fax_no" placeholder="Fax No."
                                                               value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Country <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="country" id="country"
                                                                class="form-control validate[required]"
                                                                onChange="getstatedetails(this.value)">
                                                            <option value="">Select Country</option>
                                                            <?php
                                                            if (count($get_country) > 0) {
                                                                foreach ($get_country as $coval) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $coval['id']; ?>"><?php echo $coval['sortname'] . " - " . $coval['name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email">State <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="state" id="state"
                                                                class="form-control validate[required]"
                                                                onChange="getcitydetails(this.value)">
                                                            <option value="">Select State</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">City<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="city" id="city"
                                                                class="form-control validate[required]">
                                                            <option value="">Select City</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email">Address <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <textarea name="address" id="address"
                                                                  class="form-control validate[required]" rows="5" cols="10"
                                                                  placeholder="Address" style="resize: none;"></textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label for="email">Remittance Address <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <textarea name="remittance_address" id="remittance_address"
                                                                  class="form-control validate[required]" rows="5" cols="10"
                                                                  placeholder="Remittance Address"
                                                                  style="resize: none;"></textarea>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Main Contact Person <span
                                                                style="color: red;">*</span></label></td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[onlyLetterSp]]" type="text"
                                                               name="main_contact_person" id="main_contact_person">
                                                    </td>
                                                    <td>
                                                        <label for="email">Main Email Address <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[email]]"
                                                               type="text" name="main_email_address"
                                                               id="main_email_address">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Main Phone Number <span
                                                                style="color: red;">*</span></label></td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[phone],minSize[10],maxSize[10]]"
                                                               type="text" name="main_phone_no" id="main_phone_no">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Billing Contact Person <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[onlyLetterSp]]" type="text"
                                                               name="billing_contact_person" id="billing_contact_person">
                                                    </td>
                                                    <td>
                                                        <label for="email">Billing Email Address <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[email]]"
                                                               type="text" name="billing_email_address"
                                                               id="billing_email_address">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Billing Phone Number <span
                                                                style="color: red;">*</span></label></td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[phone],minSize[10],maxSize[10]]"
                                                               type="text" name="billing_phone_no" id="billing_phone_no">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Additional Contact Person <span
                                                                style="color: red;">*</span></label></td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[onlyLetterSp]]" type="text"
                                                               name="additional_contact_person"
                                                               id="additional_contact_person">
                                                    </td>
                                                    <td>
                                                        <label for="email">Additional Email Address <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[email]]"
                                                               type="text" name="additional_email_address"
                                                               id="additional_email_address">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Additional Phone Number <span
                                                                style="color: red;">*</span></label></td>
                                                    <td>
                                                        <input class="form-control date validate[required,custom[phone],minSize[10],maxSize[10]]"
                                                               type="text" name="additional_phone_no"
                                                               id="additional_phone_no">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Will you be providing Client support in the state
                                                            of California? <span style="color: red;">*</span></label></td>
                                                    <td>
                                                        <select name="client_support_cal" id="client_support_cal"
                                                                class="validate[required]">
                                                            <!--<option value="">Select</option>-->
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected="selected">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="cal-css">Upload File<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <span class="cal-css">
                                                            <input class="pdf-file1 validate[required]" type="file"
                                                                   name="client_support_cal_file"
                                                                   id="client_support_cal_file">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Will you be providing Client support in the state
                                                            of Pennsylvania? <span style="color: red;">*</span></label></td>
                                                    <td>
                                                        <select name="client_support_pen" id="client_support_pen"
                                                                class="validate[required]">
                                                            <!--<option value="">Select</option>-->
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected="selected">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="pen-css">Upload File<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <span class="pen-css">
                                                            <input class="pdf-file2 validate[required]" type="file"
                                                                   name="client_support_pen_file"
                                                                   id="client_support_pen_file">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Will you be providing Client support in Puerto
                                                            Rico? <span style="color: red;">*</span></label></td>
                                                    <td>
                                                        <select name="client_support_pu" id="client_support_pu"
                                                                class="validate[required]">
                                                            <!--<option value="">Select</option>-->
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected="selected">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="pu-css">Upload File<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <span class="pu-css">
                                                            <input class="pdf-file3 validate[required]" type="file"
                                                                   name="client_support_pu_file"
                                                                   id="client_support_pu_file">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">National Minority Supplier Development Council
                                                            (NMSDC) <span style="color: red;">*</span></label></td>
                                                    <td>
                                                        <select name="nmsdc" id="nmsdc" class="validate[required]">
                                                            <!--<option value="">Select</option>-->
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected="selected">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="nmsdc-css">Upload File<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <span class="nmsdc-css">
                                                            <input class="pdf-file4 validate[required]" type="file"
                                                                   name="nmsdc_file"
                                                                   id="nmsdc_file">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Women's Business Enterprise National Council
                                                            (WBENC) <span style="color: red;">*</span></label></td>
                                                    <td>
                                                        <select name="wbenc" id="wbenc" class="validate[required]">
                                                            <!--<option value="">Select</option>-->
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected="selected">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="wbenc-css">Upload File<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <span class="wbenc-css">
                                                            <input class="pdf-file5 validate[required]" type="file"
                                                                   name="wbenc_file"
                                                                   id="wbenc_file">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Small Business Administration (SBA) (includes HUB
                                                            Zone) <span style="color: red;">*</span></label></td>
                                                    <td>
                                                        <select name="sba" id="sba" class="validate[required]">
                                                            <!--<option value="">Select</option>-->
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected="selected">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="sba-css">Upload File<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <span class="sba-css">
                                                            <input class="pdf-file6 validate[required]" type="file"
                                                                   name="sba_file"
                                                                   id="sba_file">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">Center for Veteran's Enterprise (VetBiz.gov)
                                                            <span style="color: red;">*</span></label></td>
                                                    <td>
                                                        <select name="vetbiz" id="vetbiz" class="validate[required]">
                                                            <!--<option value="">Select</option>-->
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected="selected">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="vetbiz-css">Upload File<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <span class="vetbiz-css">
                                                            <input class="pdf-file7 validate[required]" type="file"
                                                                   name="vetbiz_file"
                                                                   id="vetbiz_file">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label for="email">National Gay & Lesbian Chamber of Commerce
                                                            (NGLCC) <span style="color: red;">*</span></label></td>
                                                    <td>
                                                        <select name="nglcc" id="nglcc" class="validate[required]">
                                                            <!--<option value="">Select</option>-->
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected="selected">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="nglcc-css">Upload File<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <span class="nglcc-css">
                                                            <input class="pdf-file8 validate[required]" type="file"
                                                                   name="nglcc_file"
                                                                   id="nglcc_file">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Contract From Date <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control date validate[required]" type="text"
                                                               name="contract_from_date" id="contract_from_date">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input class="btn btn-success" type="submit" name="submit"
                                               value="Add Vendor User">
                                        <a href="javascript:void(0)" onclick="window.history.back();"
                                           class="btn btn-default">Back</a>
                                        <input type="hidden" name="sa_id"
                                               value="<?php echo $get_details[0]['sa_id']; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('superadmin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('superadmin/includes/footer');
?>
<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/css/validationEngine.jquery.css"
      type="text/css"/>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js"
        type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/jquery.validationEngine.js"
        type="text/javascript" charset="utf-8">
</script>
<script>
    $(document).ready(function () {
        // binds form submission and fields to the validation engine
        $("#add_admin_form").validationEngine({promptPosition: 'inline'});
    });

    function getstatedetails(id) {
        var country_id = id;
        $.post("<?php echo site_url('ajax_state_list'); ?>", {country_id: country_id}, function (data) {
            //alert(data);
            $('#state').html(data);

        });
    }

    function getcitydetails(id) {
        var state_id = id;
        $.post("<?php echo site_url('ajax_city_list'); ?>", {state_id: state_id}, function (data) {
            //alert(data);
            $('#city').html(data);

        });
    }

    $(function () {
        $('#contract_from_date').datepicker(
                {
                    format: 'mm-dd-yyyy',
                    startDate: new Date(),
                    todayHighlight: true
                }
        );
    });

</script>
<script type="text/javascript">
    $('.image-file').on('change', function () {
        var file_extension = ['jpeg', 'jpg', 'png'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.image-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.image-file').val("");
            alert("Only '.jpeg','.jpg', '.png' formats are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>
<script type="text/javascript">
    $('.pdf-file1').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.pdf-file1').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.pdf-file1').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
    
    $('.pdf-file2').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.pdf-file2').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.pdf-file2').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
    
    $('.pdf-file3').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.pdf-file3').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.pdf-file3').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
    
    $('.pdf-file4').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.pdf-file4').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.pdf-file4').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
    
    $('.pdf-file5').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.pdf-file5').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.pdf-file5').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
    
    $('.pdf-file6').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.pdf-file6').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.pdf-file6').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
    
    $('.pdf-file7').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.pdf-file7').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.pdf-file7').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
    
    $('.pdf-file8').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.pdf-file8').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.pdf-file8').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>

<script>
    $(function () {
        $('#client_support_cal').change(function () {
            if ($('#client_support_cal').val() == '1') {
                $('.cal-css').show();
            } else {
                $('.cal-css').hide();
            }
        });

        $('#client_support_pen').change(function () {
            if ($('#client_support_pen').val() == '1') {
                $('.pen-css').show();
            } else {
                $('.pen-css').hide();
            }
        });

        $('#client_support_pu').change(function () {
            if ($('#client_support_pu').val() == '1') {
                $('.pu-css').show();
            } else {
                $('.pu-css').hide();
            }
        });

        $('#nmsdc').change(function () {
            if ($('#nmsdc').val() == '1') {
                $('.nmsdc-css').show();
            } else {
                $('.nmsdc-css').hide();
            }
        });
        $('#wbenc').change(function () {
            if ($('#wbenc').val() == '1') {
                $('.wbenc-css').show();
            } else {
                $('.wbenc-css').hide();
            }
        });
        $('#sba').change(function () {
            if ($('#sba').val() == '1') {
                $('.sba-css').show();
            } else {
                $('.sba-css').hide();
            }
        });
        $('#vetbiz').change(function () {
            if ($('#vetbiz').val() == '1') {
                $('.vetbiz-css').show();
            } else {
                $('.vetbiz-css').hide();
            }
        });
        $('#nglcc').change(function () {
            if ($('#nglcc').val() == '1') {
                $('.nglcc-css').show();
            } else {
                $('.nglcc-css').hide();
            }
        });
    });
</script>