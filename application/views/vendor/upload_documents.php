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
                <li class="active"><a href="">Upload Documents</a></li>
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
                                Uploads Documents
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

                        <form id="documents_form"
                              action="<?php echo site_url('upload_documents'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email">File 1 :</label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="validate[required]" type="file" name="file_1" id="file_1">
                                                    <span style="color: red;">(PDF File Only)</span>
                                                    <?php
                                                    if(!empty($get_files) && $get_files[0]['file_1'] != ''){
                                                        ?>
                                                        <span><a href="<?php echo base_url(); ?>uploads/<?php echo $get_files[0]['file_1']; ?>" target="_blank">Download Previous Uploaded File</a></span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email">File 2 :</label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="validate[required]" type="file" name="file_2" id="file_2">
                                                    <span style="color: red;">(PDF File Only)</span>
                                                    <?php

                                                    if(!empty($get_files) && $get_files[0]['file_2'] != ''){
                                                        ?>
                                                        <span><a href="<?php echo base_url(); ?>uploads/<?php echo $get_files[0]['file_2']; ?>" target="_blank">Download Previous Uploaded File</a></span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email">File 3 :</label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="validate[required]" type="file" name="file_3" id="file_3">
                                                    <span style="color: red;">(PDF File Only)</span>
                                                    <?php
                                                    if(!empty($get_files) && $get_files[0]['file_3'] != ''){
                                                        ?>
                                                        <span><a href="<?php echo base_url(); ?>uploads/<?php echo $get_files[0]['file_3']; ?>" target="_blank">Download Previous Uploaded File</a></span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email">File 4 :</label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="validate[required]" type="file" name="file_4" id="file_4">
                                                    <span style="color: red;">(PDF File Only)</span>
                                                    <?php
                                                    if(!empty($get_files) && $get_files[0]['file_4'] != ''){
                                                        ?>
                                                        <span><a href="<?php echo base_url(); ?>uploads/<?php echo $get_files[0]['file_4']; ?>" target="_blank">Download Previous Uploaded File</a></span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input class="btn btn-success" type="submit" name="submit" value="Upload Documents">
                                        <button class="btn btn-warning" onclick="window.history.back();">Back</button>
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
        $("#documents_form").validationEngine({promptPosition: 'inline'});
    });
    $(function () {
        $('#datetimepicker1').datepicker(
            {
                format: 'yyyy-mm-dd'
            }
        );
    });
    $(function () {
        $("#file_1").change(function () {
            var fileExtension = ['pdf'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only format are allowed : " + fileExtension.join(', '));
                $("#file_1").val('');
            }
        });
        $("#file_2").change(function () {
            var fileExtension = ['pdf'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only format are allowed : " + fileExtension.join(', '));
                $("#file_1").val('');
            }
        });
        $("#file_3").change(function () {
            var fileExtension = ['pdf'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only format are allowed : " + fileExtension.join(', '));
                $("#file_1").val('');
            }
        });
        $("#file_4").change(function () {
            var fileExtension = ['pdf'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only format are allowed : " + fileExtension.join(', '));
                $("#file_1").val('');
            }
        });

    });
</script>