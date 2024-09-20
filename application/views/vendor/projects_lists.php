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
                <li class="active"><a href="">Projects List</a></li>
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
                                <a href="<?php echo base_url('add_projects'); ?>" style="margin: 0 10px 0px 0px;"><i
                                        class="fa fa-plus"></i> Add Projects</a>
                                <a href="<?php echo base_url('assign_project_to_employee'); ?>"><i
                                        class="fa fa-plus"></i> Assign Project To Employees</a>
<!--                                <a href="--><?php //echo base_url('add_tasks'); ?><!--"><i class="fa fa-plus"></i> Add Tasks</a>-->
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Projects Lists</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Project Name</th>
                                    <th>Client Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Approx. Total Time(hrs)</th>
                                    <th>Status</th>
                                    <th>View Assigned Employess</th>
<!--                                    <th>Tasks</th>-->
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                if (count($get_project_details > 0)) {

                                    foreach ($get_project_details as $aval) {

                                        $get_count_tasks = $this->employee_model->getCountTasksByProjects($aval['id']);
                                        $get_count_employess = $this->employee_model->getCountEmployeesByProjects($aval['id']);

                                        if ($get_count_tasks[0]['cnt'] != '') {
                                            $cnt_tasks = $get_count_tasks[0]['cnt'];
                                        } else {
                                            $cnt_tasks = 0;
                                        }
                                        if ($get_count_employess[0]['cnt'] != '') {
                                            $cnt_employees = $get_count_employess[0]['cnt'];
                                        } else {
                                            $cnt_employees = 0;
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $aval['project_name']; ?></td>
                                            <td><?php echo $aval['client_name']; ?></td>
                                            <td><?php echo date("d-m-Y",strtotime($aval['start_date'])); ?></td>
                                            <td><?php echo date("d-m-Y",strtotime($aval['end_date'])); ?></td>
                                            <td><?php echo $aval['approx_total_time']; ?></td>
                                            <td>&nbsp;</td>
                                            <td>
                                                <a class="tbl_icon"
                                                   href="<?php echo base_url('view_employee/' . base64_encode($aval['id'])); ?>"
                                                   data-toggle="tooltip" title="View Employees ">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                    <span class="badge"><?php echo $cnt_employees; ?> Employee(s) Assigned</span>
                                                </a>
                                            </td>
                                            <?php
                                            /*
                                            <td>
                                                <a class="tbl_icon"
                                                   href="<?php echo base_url('tasks_lists/' . base64_encode($aval['id'])); ?>"
                                                   data-toggle="tooltip" title="View Tasks ">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                    <span class="badge"><?php echo $cnt_tasks; ?> Task(s)</span>
                                                </a>
                                            </td>
                                            */
                                            ?>
                                            <td>
                                                <a class="tbl_icon"
                                                   href="<?php echo base_url('edit_projects/' . base64_encode($aval['id'])); ?>"
                                                   data-toggle="tooltip" title="Edit "><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>


                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>

                                </tbody>

                            </table>
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
        $('#admin_tbl').DataTable();
    });
</script>