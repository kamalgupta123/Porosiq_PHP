<?php
$this->load->view('vendor/includes/header');

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

    .fa-lock {
        color: #f90000;
    }

    .fa-times {
        color: #f90000;
    }

    .fa-check {
        color: #009900;
    }

    .tbl_icon {
        font-size: 18px;
        padding: 0 2px;
    }

    .alert-danger-d {
        color: #fff;
        background-color: #ff5c5c;
        border-color: #ff2d2d;
    }

    .alert-d {
        padding: 14px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-weight: bold;
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
                <li class="active"><a href="">Documentation</a></li>
            </ol>
        </section>

       
        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <?php
                    //                            echo '<pre>';
                    //                            print_r($get_admin_details);
                    ?>
                    <div class="box" style="margin-top: 30px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <?php
//                                if (!empty($get_files)) {
//                                    if ($get_files[0]['file_1_status'] != '1' && $get_files[0]['file_2_status'] != '1' && $get_files[0]['file_3_status'] != '1' && $get_files[0]['file_4_status'] != '1') {
                                        ?>
                                        <a href="<?php echo base_url('upload_vendor_documents'); ?>"><i
                                                class="fa fa-plus"></i> Uploads Documents</a>
                                        <?php
                                    /*}
                                }
                                else
                                {
                                    ?>
                                    <a href="<?php echo base_url('update_documents'); ?>"><i class="fa fa-pen"></i> Update Documents</a>
                                    <?php
                                }*/
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php
                            if (!empty($get_files)) {
                                ?>
                                <div class="col-md-3 text-center">
                                    <h4>
                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $get_files[0]['file_1']; ?>"
                                           target="_blank"><?php echo $get_files[0]['file_1'] ?></a></h4>
                                    <img src="<?php echo base_url(); ?>assets/images/icon-pdf.png" alt=" "><br><br>
                                    <?php
                                    if ($get_files[0]['file_1_status'] != '0') {
                                        ?>
                                        <span class="btn btn-success">Approved</span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="btn btn-danger">Not Approved</span>
                                        <?php
                                    }
                                    ?>

                                </div>

                                <div class="col-md-3 text-center">
                                    <h4>
                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $get_files[0]['file_2']; ?>"
                                           target="_blank"><?php echo $get_files[0]['file_2'] ?></a></h4>
                                    <img src="<?php echo base_url(); ?>assets/images/icon-pdf.png" alt=" "><br><br>
                                    <?php
                                    if ($get_files[0]['file_2_status'] != '0') {
                                        ?>
                                        <span class="btn btn-success">Approved</span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="btn btn-danger">Not Approved</span>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="col-md-3 text-center">
                                    <h4>
                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $get_files[0]['file_3']; ?>"
                                           target="_blank"><?php echo $get_files[0]['file_3'] ?></a></h4>
                                    <img src="<?php echo base_url(); ?>assets/images/icon-pdf.png" alt=" "><br><br>
                                    <?php
                                    if ($get_files[0]['file_3_status'] != '0') {
                                        ?>
                                        <span class="btn btn-success">Approved</span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="btn btn-danger">Not Approved</span>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="col-md-3 text-center">
                                    <h4>
                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $get_files[0]['file_4']; ?>"
                                           target="_blank"><?php echo $get_files[0]['file_4'] ?></a></h4>
                                    <img src="<?php echo base_url(); ?>assets/images/icon-pdf.png" alt=" "><br><br>
                                    <?php
                                    if ($get_files[0]['file_4_status'] != '0') {
                                        ?>
                                        <span class="btn btn-success">Approved</span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="btn btn-danger">Not Approved</span>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <!--                                <div class="clearfix" style="margin:15px 0;"></div>-->
                                <?php
                            } else {
                                ?>
                                <div class="alert-d alert-danger-d"> Documents Not Uploaded Yet.</div>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
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

<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })

</script>