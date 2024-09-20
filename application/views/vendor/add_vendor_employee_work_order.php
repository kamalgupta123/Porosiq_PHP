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
            <!--                <h1>-->
            <!--                    User Profile-->
            <!--                </h1>-->
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><a href="">Work Order</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
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
                              action="<?php echo site_url('insert_vendor_employee_work_order'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">


                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <div class="form-group">
                                            <div class="col-sm-12 col-md-12 col-md-12">
                                                <table id="admin_tbl" class="table table-bordered"
                                                       style="font-size: 12px; text-align: center;">
                                                    <tbody>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Consultant</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" type="text" id="consultant" name="consultant">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Vendor</p>
                                                            </td>
                                                            <td width="312">
                                                                <label>
                                                                    <?php
                                                                    if (isset($get_vendor_details) && $get_vendor_details[0]['first_name'] != '') {
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
                                                                <input class="form-control validate[required] text-css date" type="text" id="start_date" name="start_date">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Duration of Project</p>
                                                            </td>
                                                            <td width="312">
                                                                <textarea class="form-control validate[required] text-css" name="project_duration" id="project_duration"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Bill Rate</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" type="text" id="bill_rate" name="bill_rate">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>OT Rate</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" type="text" id="ot_rate" name="ot_rate">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Client Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" type="text" id="client_name" name="client_name">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Invoicing Terms</p>
                                                            </td>
                                                            <td width="312">
                                                                <textarea class="form-control validate[required] text-css" name="invoicing_terms" id="invoicing_terms"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Payment Terms</p>
                                                            </td>
                                                            <td width="312">
                                                                <textarea class="form-control validate[required] text-css" name="payment_terms" id="payment_terms"></textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p>Note: UHG 5% Tenure discount after the first 6 months and then
                                                    another 5% for the following 6 months<strong>.</strong></p>

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
                                                            </td>
                                                            <td width="312">
                                                                <p>Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <label>
                                                                    <?php
                                                                    if (isset($get_vendor_details) && $get_vendor_details[0]['first_name'] != '') {
                                                                        echo $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                                                                    }
                                                                    ?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Designation</p>
                                                            </td>
                                                            <td width="312">
                                                            </td>
                                                            <td width="312">
                                                                <p>Designation</p>
                                                            </td>
                                                            <td width="312">
                                                                <label>
                                                                    <?php
                                                                    if ($get_vendor_details[0]['vendor_designation'] != '') {
                                                                        echo $get_vendor_details[0]['vendor_designation'];
                                                                    }
                                                                    ?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Company Name</p>
                                                            </td>
                                                            <td width="312">
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
                                                            <td width="312">
                                                            </td>
                                                            <td width="312">
                                                                <p>Signature</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" type="text" id="vendor_signature" name="vendor_signature">
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
                                        <input class="btn btn-success" type="submit" name="submit"
                                               value="Add Work Order">
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
        $('#start_date').datepicker(
                {
                    format: 'yyyy-mm-dd'
                }
        );
    });

</script>