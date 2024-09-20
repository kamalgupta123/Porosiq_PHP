<?php
$this->load->view('vendor/includes/header');
?>
<style>
    .lbl-css {
        margin-bottom: 0px !important;
    }

    .input-group {
        margin-bottom: 10px;
        width: 75%;
    }
    .text-css{
        border-top: 0px;
        border-right: 0px;
        border-left: 0px;
        border-bottom: 1px solid #000;
    }
    label{
        font-weight: 600;
    }
    .wo_top_table_td {
      text-align: center;
      border: 1px solid black;
    }
</style>
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <?php
            $this->load->view('vendor/includes/upper_menu');
            ?>
        </nav>
    </header>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><a href="">Work Order</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <?php if (INDIA || US) { ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-th"></span>
                                Work Order
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

                        <div class="col-xs-12 col-sm-12 col-md-12 separator social-login-box" align="center"><br>
                            <img src="<?php echo base_url().CLIENT_LOGO; ?>" alt="" style="">
                        </div>
                        <div>
                            <center>
                                <h2>Work Order</h2>
                            </center>
                            <p>&nbsp;</p>
                            <p align="center">
                                This Work Order (WO) is being generated pursuant to the Agreement dated <label><?php echo $agreement_date; ?></label>
                                between <label><?php echo CLIENT_NAME; ?></label>
                                and <label><?php echo $vendor_company_name; ?></label>.
                            </p>
                        </div>

                        <form id="work_order_form"
                              action="<?php echo site_url('update_vendor_employee_work_order'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">
                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12 col-md-12 col-md-12">
                                                <table id="admin_tbl" class="table table-responsive"
                                                       style="font-size: 14px; text-align: center; border: 1px solid black;">
                                                    <tbody>
                                                        <tr>
                                                            <td width="50%" class="wo_top_table_td">
                                                                <p>Consultant Name</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <p><?php echo $consultant_name; ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="wo_top_table_td">
                                                                <p>Vendor Name</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <label><?php echo $vendor_company_name; ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="wo_top_table_td">
                                                                <p>Start Date</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <p><?php echo $start_date; ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="wo_top_table_td">
                                                                <p>Duration of Project</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <p><?php echo $project_duration; ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="wo_top_table_td">
                                                                <p>Bill Rate</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <p><?php echo $bill_rate; ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="wo_top_table_td">
                                                                <p>OT Bill Rate</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <p><?php echo $ot_rate; ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="wo_top_table_td">
                                                                <p>Client Name</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <label><?php echo $client_name; ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="wo_top_table_td">
                                                                <p>Invoicing Terms</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <p><?php echo $invoicing_terms; ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="wo_top_table_td">
                                                                <p>Payment Terms</p>
                                                            </td>
                                                            <td class="wo_top_table_td">
                                                                <p><?php echo $payment_terms; ?></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p class="work-note">
                                                    <span><label>Note:</label>&nbsp;
                                                    <?php echo $work_note; ?></span>
                                                </p>

                                                <p style="text-align: center;">Accepted by:</p>

                                                <table id="admin_tbl" class="table table-bordered"
                                                       style="font-size: 14px; text-align: left;">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <h4><?php echo CLIENT_NAME; ?></h4>
                                                            </td>
                                                            <td colspan="2">
                                                                <h4><?php echo $vendor_company_name; ?></h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">
                                                                <p>Name</p>
                                                            </td>
                                                            <td width="35%">&nbsp;</td>
                                                            <td width="15%">
                                                                <p>Name</p>
                                                            </td>
                                                            <td>
                                                                <input class="form-control validate[required] text-css"
                                                                       type="text"
                                                                       id="vendor_poc_name"
                                                                       name="vendor_poc_name" 
                                                                       value="<?php echo $vendor_poc_name; ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>Designation</p>
                                                            </td>
                                                            <td>
                                                                &nbsp;
                                                            </td>
                                                            <td>
                                                                <p>Designation</p>
                                                            </td>
                                                            <td>
                                                                <input class="form-control validate[required] text-css"
                                                                       type="text"
                                                                       id="vendor_poc_designation"
                                                                       name="vendor_poc_designation"
                                                                       value="<?php echo $vendor_poc_designation; ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>Company Name</p>
                                                            </td>
                                                            <td>
                                                                <label><?php echo CLIENT_NAME; ?></label>
                                                            </td>
                                                            <td>
                                                                <p>Company Name</p>
                                                            </td>
                                                            <td>
                                                                <label><?php echo $vendor_company_name; ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><p>Date</p></td>
                                                            <td>&nbsp;</td>
                                                            <td><p>Date</p></td>
                                                            <td>
                                                                <label><?php echo date('M d, Y'); ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>Signature</p>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                <p>Signature</p>
                                                            </td>
                                                            <td>
                                                                <input class="form-control validate[required] text-css"
                                                                       type="text"
                                                                       id="vendor_signature"
                                                                       name="vendor_signature" 
                                                                       value="<?php echo $vendor_signature; ?>"
                                                                       style="font-family: 'Dancing Script', cursive; font-size: 1.7em;">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input class="btn btn-success" type="submit" name="submit" value="Sign Work Order">
                                        <a class="btn btn-default" href="<?php echo site_url('all_documents_lists'); ?>" style="text-decoration: none;">Back</a>
                                        <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
                                        <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                                        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if (LATAM) { ?>
                <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-th"></span>
                                Work Order
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

                        <form id="work_order_form"
                              action="<?php echo site_url('update_vendor_employee_work_order'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">


                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <div class="form-group">
                                            <div class="col-sm-12 col-md-12 col-md-12">
                                                <table id="admin_tbl" class="table table-bordered table-striped"
                                                       style="font-size: 12px; text-align: center;">
                                                    <tbody>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Consultant</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required,custom[onlyLetterSp]] text-css" type="text" id="consultant" name="consultant" value="<?php echo $get_work_details[0]['consultant']; ?>" disabled>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Vendor</p>
                                                            </td>
                                                            <td width="312">
                                                                <label>
                                                                    <?php
                                                                    if ($get_vendor_details[0]['first_name'] != '') {
                                                                        echo $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                                                                    }
                                                                    ?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Start Date</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css date" type="text" id="start_date" name="start_date" value="<?php echo $get_work_details[0]['start_date']; ?>" disabled>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Duration of Project</p>
                                                            </td>
                                                            <td width="312">
                                                                <textarea class="form-control validate[required] text-css" name="project_duration" id="project_duration" disabled><?php echo $get_work_details[0]['project_duration']; ?></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Bill Rate</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required,custom[onlyNumberSp]] text-css" type="text" id="bill_rate" name="bill_rate" value="<?php echo $get_work_details[0]['bill_rate']; ?>" disabled>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>OT Rate</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required,custom[onlyNumberSp]] text-css" type="text" id="ot_rate" name="ot_rate" value="<?php echo $get_work_details[0]['ot_rate']; ?>" disabled>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Client Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <?php
                                                                //echo $get_work_details[0]['client_name'];
                                                                if ($get_work_details[0]['client_name'] != '') {
                                                                    $get_work_note_details = $this->employee_model->getWorkNote($get_work_details[0]['client_name']);
                                                                    ?>
                                                                    <label><?php echo $get_work_note_details[0]['client_name']; ?></label>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Invoicing Terms</p>
                                                            </td>
                                                            <td width="312">
                                                                <textarea class="form-control validate[required] text-css" name="invoicing_terms" id="invoicing_terms" disabled><?php echo $get_work_details[0]['invoicing_terms']; ?></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Payment Terms</p>
                                                            </td>
                                                            <td width="312">
                                                                <textarea class="form-control validate[required] text-css" name="payment_terms" id="payment_terms" disabled><?php echo $get_work_details[0]['payment_terms']; ?></textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p class="work-note">
                                                    <?php
                                                    if ($get_work_details[0]['client_name'] != '') {
                                                        $get_work_note = $this->employee_model->getWorkNote($get_work_details[0]['client_name']);
                                                        ?>
                                                        <span><label>Note:&nbsp;</label><?php echo $get_work_note[0]['work_order_note']; ?></span>
                                                        <?php
                                                    } else {
                                                        echo "";
                                                    }
                                                    ?>
                                                </p>

                                                <p style="text-align: center;">Accepted by:</p>

                                                <p>&nbsp;</p>
                                                <table id="admin_tbl" class="table table-bordered"
                                                       style="font-size: 12px; text-align: center;">
                                                    <tbody>
                                                        <tr>
                                                            <td width="312" colspan="2">&nbsp;</td>
                                                            <td width="312" colspan="2">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <?php
                                                                /* if (!empty($get_admin_details) && $get_admin_details[0]['first_name'] != '') {
                                                                  echo $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                                                                  } */
                                                                ?>
                                                                <label>Aurica Bhattacharya</label>
                                                            </td>
                                                            <td width="312">
                                                                <p>Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" type="text" id="vendor_poc_name" name="vendor_poc_name" value="<?php echo $get_work_details[0]['vendor_poc_name']; ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Designation</p>
                                                            </td>
                                                            <td width="312">
                                                                <label>Legal Counsel</label>
                                                                <?php
                                                                /* if (!empty($get_admin_details) && $get_admin_details[0]['admin_designation'] != '') {
                                                                  echo $get_admin_details[0]['admin_designation'];
                                                                  } */
                                                                ?>
                                                            </td>
                                                            <td width="312">
                                                                <p>Designation</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" type="text" id="vendor_poc_designation" name="vendor_poc_designation" value="<?php echo $get_work_details[0]['vendor_poc_designation']; ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Company Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <?php
                                                                if (!empty($get_admin_details) && $get_admin_details[0]['admin_company_name'] != '') {
                                                                    echo $get_admin_details[0]['admin_company_name'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td width="312">
                                                                <p>Company Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <label>
                                                                    <?php
                                                                    if ($get_vendor_details[0]['vendor_company_name'] != '') {
                                                                        echo $get_vendor_details[0]['vendor_company_name'];
                                                                    }
                                                                    ?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Signature</p>
                                                            </td>
                                                            <td width="312">&nbsp;</td>
                                                            <td width="312">
                                                                <p>Signature</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" type="text" id="vendor_signature" name="vendor_signature" value="<?php echo $get_work_details[0]['vendor_signature']; ?>" style="font-family: 'Dancing Script', cursive; font-size: 1.7em;">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input class="btn btn-success" type="submit" name="submit" value="Sign Work Order">
                                        <a class="btn btn-default" href="<?php echo site_url('all_documents_lists'); ?>" style="text-decoration: none;">Back</a>
                                        <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
                                        <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                                        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('vendor/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('vendor/includes/footer');
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
        $("#work_order_form").validationEngine({promptPosition: 'inline'});
    });
    $(function () {
        var LATAM = <?php echo json_encode(LATAM); ?>;
        if (LATAM) {
            $('#start_date').datepicker(
                    {
                        format: 'yyyy-mm-dd'
                    }
            );
        }
    });
</script>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet"> 