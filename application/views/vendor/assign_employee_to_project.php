<?php
$this->load->view('vendor/includes/header');
?>
<style>
    .lbl-css{
        margin-bottom: 0px !important;
    }
    .input-group{
        margin-bottom: 10px;
        width: 75%;
    }
    label{
        font-weight: 600;
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
                <li class="active"><a href="">Assign Projects To Consultants</a></li>
            </ol>
        </section>

        <br/>
        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-th"></span>
                                Assign Projects To Consultants
                            </h3>
                        </div>

                        <?php
                        if ($this->session->flashdata('error_msg')) {
                            $msg = $this->session->flashdata('error_msg');
                            ?>
                            <div class="alert alert-danger"> 
                                <ul>
                                    <?php
                                    foreach ($msg as $mval) {
                                        ?>
                                        <li style="color: #fff !important;"><?php echo $mval; ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>

                        <form id="add_projects_form"
                              action="<?php echo site_url('add_assign_projects'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Project Name <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="project_name" class="form-control validate[required]">
                                                            <option value="">Select Project</option>
                                                            <?php
                                                            if (!empty($get_projects)) {
                                                                foreach ($get_projects as $pval) {
                                                                    ?>
                                                                    <option value="<?php echo $pval['id']; ?>"><?php echo $pval['project_code'] . " - " . $pval['project_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Consultants <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select id="employee_id" name="employee_id[]" class="form-control validate[required] con-mul" multiple>
                                                            <option value="">Select Consultants</option>
                                                            <?php
                                                            if (!empty($get_employees)) {
                                                                foreach ($get_employees as $eval) {
                                                                    ?>
                                                                    <option value="<?php echo $eval['employee_id']; ?>"><?php echo $eval['employee_code'] . " - " . $eval['first_name'] . " " . $eval['last_name'] . " - " . $eval['employee_designation']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
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
                                        <input type="hidden" name="vendor_id" value="<?php echo $get_details[0]['vendor_id']; ?>">
                                        <input class="btn btn-success" type="submit" name="submit" value="Assign Projects">
                                        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
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
        $("#add_projects_form").validationEngine({promptPosition: 'inline'});
    });
    $(function () {
        $('#start_date').datepicker(
                {
                    format: 'yyyy-mm-dd'
                }
        );
        $('#end_date').datepicker(
                {
                    format: 'yyyy-mm-dd'
                }
        );

        $(".con-mul").select2({
            placeholder: "Select",
            maximumSelectionLength: 3
        });
    });

</script>
