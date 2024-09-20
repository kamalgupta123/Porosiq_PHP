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
                <li><a href="#"><i class="fa fa-dashboard"></i> Open Requirements</a></li>
                <li class="active"><a href="">Upload Document</a></li>
            </ol>
        </section>
        <br/>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-th"></span>
                                Upload Documents
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

                        <form id="upload_document"
                              action="<?php echo site_url('upload_vendor_document'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">



                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Document Name </label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    if (isset($doc_name)) {
                                                        echo ucwords($doc_name);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="photo" class="lbl-css">Upload Document <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="validate[required] image-file" type="file" name="file">
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
                                        <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
                                        <input type="hidden" name="doc_id" value="<?php echo $doc_id; ?>">
                                        <input type="hidden" name="doc_name" value="<?php echo $doc_name; ?>">
                                        <input class="btn btn-success" type="submit" name="submit" value="Upload Document">
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
<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/css/timePicker.css"
      type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-timepicker.js"
        type="text/javascript" charset="utf-8">
</script>
<script>
    $(document).ready(function () {
        // binds form submission and fields to the validation engine
        $("#upload_document").validationEngine({promptPosition: 'inline'});
    });

</script>

<script type="text/javascript">
    $('.image-file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.image-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.image-file').val("");
            alert("Only '.pdf' formats are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>