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
                <li class="active"><a href="">Edit Projects</a></li>
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
                                Edit Projects
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

                        <form id="add_projects_form"
                              action="<?php echo site_url('update_projects'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">



                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Project Type <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <select name="project_type" class="form-control validate[required]">
                                                        <option value="">Select Project Type</option>
                                                        <?php
                                                       // echo $get_project_data[0]['project_type'];
                                                        if(!empty($get_project_type)){
                                                            foreach($get_project_type as $ptval){
                                                                ?>
                                                                <option value="<?php echo $ptval['project_type_name']; ?>" <?php if($ptval['project_type_name'] == $get_project_data[0]['project_type']){ ?> selected <?php } ?>><?php echo $ptval['project_type_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Project Name <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="form-control validate[required]" type="text" id="project_name" name="project_name" placeholder="Project Name" value="<?php echo $get_project_data[0]['project_name'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Project Details <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <textarea style="resize: none;" class="form-control validate[required]" type="text" id="project_details" name="project_details" placeholder="Project Details"><?php echo $get_project_data[0]['project_details'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Client Name <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="form-control validate[required]" type="text" id="client_name" name="client_name" placeholder="Client Name" value="<?php echo $get_project_data[0]['client_name'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Project Start Date <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="form-control validate[required] date" type="text" id="start_date" name="start_date" placeholder="Start Date" value="<?php echo $get_project_data[0]['start_date'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Project End Date </label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group date" id="end_dt">
                                                    <input class="form-control date" type="text" id="end_date" name="end_date" placeholder="End Date" value="<?php echo $get_project_data[0]['end_date'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Approx. Total Time(hrs) </label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="approx_total_time" name="approx_total_time" placeholder="Approx. Total Time(hrs)" value="<?php echo $get_project_data[0]['approx_total_time'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6 col-md-4">
                                                <label for="email" class="lbl-css">Monthly Payment </label>
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="monthly_payment" name="monthly_payment" placeholder="Monthly Payment" value="<?php echo $get_project_data[0]['monthly_payment'] ?>">
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
                                        <input type="hidden" name="project_id" value="<?php echo $get_project_data[0]['id'] ?>">
                                        <input class="btn btn-success" type="submit" name="submit" value="Update Project">
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
    });

</script>