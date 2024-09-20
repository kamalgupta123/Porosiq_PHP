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
                <li class="active"><a href="">Open Requirements</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box" style="margin-top: 30px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <a href="<?php echo base_url('assign_project_to_consultant'); ?>" style="color: #09274B;"><i
                                        class="fa fa-plus" style="color: green;"></i> Assign Project To Consultants</a>
                            </div>
                        </div>
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
                    <?php if (DEMO) { ?>
                    <?php if(false) { ?>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Open Requirements</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Project Code</th>
                                        <th>Project Type</th>
                                        <th>Project Name</th>
                                        <th>Client Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Approx. Total Time(hrs)</th>
                                        <th>Status</th>
                                        <th>View Assigned Consultants</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $vendor_id = $get_details[0]['vendor_id'];
                                    if (count($get_project_details) > 0) {

                                        foreach ($get_project_details as $aval) {

                                            $get_count_employess = $this->employee_model->getCountEmployeesByProjects($aval['id'],$vendor_id);

                                            if ($get_count_employess[0]['cnt'] != '') {
                                                $cnt_employees = $get_count_employess[0]['cnt'];
                                            } else {
                                                $cnt_employees = 0;
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><label><?php echo $aval['project_code']; ?></label></td>
                                                <td><?php echo $aval['project_type']; ?></td>
                                                <td><label><?php echo $aval['project_name']; ?></label></td>
                                                <td><?php echo $aval['client_name']; ?></td>
                                                <td><label><?php echo date("m-d-Y", strtotime($aval['start_date'])); ?></label></td>
                                                <td>
                                                    <label>
                                                        <?php
                                                        if ($aval['end_date'] != '0000-00-00') {
                                                            echo date("m-d-Y", strtotime($aval['end_date']));
                                                        }
                                                        ?>
                                                    </label>
                                                </td>
                                                <td><?php echo $aval['approx_total_time']; ?></td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('view_consultant/' . base64_encode($aval['id'])); ?>"
                                                       data-toggle="tooltip" title="View Consultant" style="color: #09274B;">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                        <span class="badge"><?php echo $cnt_employees; ?> Consultant(s)</span>
                                                    </a>
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
                <?php } ?>

                <div class="box">
                    <div class="box-body">
                      <table
                        id="table_id"
                        class="table table-bordered table-striped"
                        style="font-size: 11px;"
                        width="100%"
                      >
                        <thead>
                          <tr>
                            <th>Req. #</th>
                            <th>Job Title</th>
                            <th>Client Name</th>
                            <th>Openings #</th>
                            <th>Req. Owner</th>
                            <th>Job Category</th>
                            <th>Classification</th>
                            <th>Bill Rate</th>
                            <th>Pay Rate</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Candidates #</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          if(!empty($requisition_list)) {

                            foreach ($requisition_list as $requisition) {
                         ?>
                          <tr>
                            <td><?php echo "REQ" . $requisition['req_id']; ?></td>
                            <td><?php echo $requisition['job_title']; ?></td>
                            <td>
                                <?php 
                                  if (!empty($requisition['client_name'])) {

                                    echo $requisition['client_name']; 

                                  } else{

                                    echo "-";
                                  } 
                                  ?>  
                            </td>
                            <td class="text-center"><?php echo $requisition['number_of_openings']; ?></td>
                            <td><?php //echo $requisition['admin_id']; ?>Tanmoy</td></td>
                            <td><?php echo show_categories($requisition['job_category'], false); ?></td>
                            <td><?php echo show_classifications($requisition['department'], false); ?></td>
                            <td><?php echo $requisition['bill_rate'] . "<br>";
                                      echo "(" . $requisition['bill_rate_type'] . ")";
                             ?></td>
                            <td><?php echo $requisition['pay_rate'] . "<br>";
                                      echo "(" . $requisition['pay_rate_type'] . ")";
                             ?></td>
                            <td><?php echo date('m-d-Y',strtotime($requisition['start_date'])); ?></td>
                            <td><?php echo date('m-d-Y',strtotime($requisition['end_date'])); ?></td>
                            <td class="text-center">
                              <?php
                                if(!empty($requisition['candidate_type'])) {

                                   if ( ($requisition['candidate_type'] == "Employee,Consultant") || ($requisition['candidate_type'] == "Employee") ) { ?>
                                  <span>Emp. # - </span><a
                                    href=""
                                    >1</a><br>
                                  <?php
                                   }
                                   if ( ($requisition['candidate_type'] == "Employee,Consultant") || ($requisition['candidate_type'] == "Consultant") ) {
                                  ?>
                                  <span>Con. # - </span><a
                                    href=""
                                    >1</a>
                                    <?php
                                  }
                                }
                                ?>
                            </td>
                            <td>
                              <?php 
                                echo show_requisition_status($requisition['status'], false);
                              ?> 
                            </td>
                            <td class="text-center">
                                <a
                                  href=""
                                  data-toggle="tooltip"
                                  data-placement="top"
                                  title="View Details"
                                  style="margin: 0 2px;"
                                >
                                  <i
                                    class="fa fa-lg fa-eye"
                                    aria-hidden="true"
                                    style="color: #09274b;"
                                  ></i>
                                </a>
                              </a>
                              <span
                                data-toggle="modal"
                                data-target="#requisition_modal"
                              >
                                
                              </span>
                              <a
                                style="margin: 0px 2px; color: blue;"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Add Candidate"
                                href="#"
                                ><i class="fa fa-lg fa-plus" aria-hidden="true"></i
                              ></a>
                            </td>
                          </tr>
                          <?php
                        }
                    }
                    ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.box-body -->
              </div>
              <?php } ?>
              <?php if (INDIA || US) { ?>
                <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Open Requirements</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Project Code</th>
                                        <th>Project Type</th>
                                        <th>Project Name</th>
                                        <th>Client Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Approx. Total Time(hrs)</th>
                                        <th>Status</th>
                                        <th>View Assigned Consultants</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $vendor_id = $get_details[0]['vendor_id'];
                                    if (count($get_project_details) > 0) {

                                        foreach ($get_project_details as $aval) {

                                            $get_count_employess = $this->employee_model->getCountEmployeesByProjects($aval['id'],$vendor_id);

                                            if ($get_count_employess[0]['cnt'] != '') {
                                                $cnt_employees = $get_count_employess[0]['cnt'];
                                            } else {
                                                $cnt_employees = 0;
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><label><?php echo $aval['project_code']; ?></label></td>
                                                <td><?php echo $aval['project_type']; ?></td>
                                                <td><label><?php echo $aval['project_name']; ?></label></td>
                                                <td><?php echo $aval['client_name']; ?></td>
                                                <td><label><?php echo date("m-d-Y", strtotime($aval['start_date'])); ?></label></td>
                                                <td>
                                                    <label>
                                                        <?php
                                                        if ($aval['end_date'] != '0000-00-00') {
                                                            echo date("m-d-Y", strtotime($aval['end_date']));
                                                        }
                                                        ?>
                                                    </label>
                                                </td>
                                                <td><?php echo $aval['approx_total_time']; ?></td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('view_consultant/' . base64_encode($aval['id'])); ?>"
                                                       data-toggle="tooltip" title="View Consultant" style="color: #09274B;">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                        <span class="badge"><?php echo $cnt_employees; ?> Consultant(s)</span>
                                                    </a>
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

              <?php } ?>
              <?php if (LATAM) { ?>
                <?php if(false) { ?>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Open Requirements</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Project Code</th>
                                        <th>Project Type</th>
                                        <th>Project Name</th>
                                        <th>Client Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Approx. Total Time(hrs)</th>
                                        <th>Status</th>
                                        <th>View Assigned Consultants</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $vendor_id = $get_details[0]['vendor_id'];
                                    if (count($get_project_details) > 0) {

                                        foreach ($get_project_details as $aval) {

                                            $get_count_employess = $this->employee_model->getCountEmployeesByProjects($aval['id'],$vendor_id);

                                            if ($get_count_employess[0]['cnt'] != '') {
                                                $cnt_employees = $get_count_employess[0]['cnt'];
                                            } else {
                                                $cnt_employees = 0;
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><label><?php echo $aval['project_code']; ?></label></td>
                                                <td><?php echo $aval['project_type']; ?></td>
                                                <td><label><?php echo $aval['project_name']; ?></label></td>
                                                <td><?php echo $aval['client_name']; ?></td>
                                                <td><label><?php echo date("m-d-Y", strtotime($aval['start_date'])); ?></label></td>
                                                <td>
                                                    <label>
                                                        <?php
                                                        if ($aval['end_date'] != '0000-00-00') {
                                                            echo date("m-d-Y", strtotime($aval['end_date']));
                                                        }
                                                        ?>
                                                    </label>
                                                </td>
                                                <td><?php echo $aval['approx_total_time']; ?></td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('view_consultant/' . base64_encode($aval['id'])); ?>"
                                                       data-toggle="tooltip" title="View Consultant" style="color: #09274B;">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                        <span class="badge"><?php echo $cnt_employees; ?> Consultant(s)</span>
                                                    </a>
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
                <?php } ?>

                <div class="box">
                    <div class="box-body">
                      <table
                        id="table_id"
                        class="table table-bordered table-striped"
                        style="font-size: 11px;"
                        width="100%"
                      >
                        <thead>
                          <tr>
                            <th>Req. #</th>
                            <th>Job Title</th>
                            <th>Project ID</th>
                            <th>Openings #</th>
                            <th>Req. Owner</th>
                            <th>Job Category</th>
                            <th>Classification</th>
                            <th>Bill Rate</th>
                            <th>Pay Rate</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Candidates #</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $i = 1;
                          if(!empty($requisition_list)) {

                            foreach ($requisition_list as $requisition) {
                         ?>
                          <tr>
                            <td><?php echo "REQ" . $i; ?></td>
                            <td><?php echo $requisition['job_title']; ?></td>
                            <td><?php echo $requisition['project_id']; ?></td>
                            <td class="text-center"><?php echo $requisition['number_of_openings']; ?></td>
                            <td><?php //echo $requisition['admin_id']; ?>Tanmoy</td></td>
                            <td><?php echo show_categories($requisition['job_category'], false); ?></td>
                            <td><?php echo show_classifications($requisition['department'], false); ?></td>
                            <td><?php echo $requisition['bill_rate'] . "<br>";
                                      echo "(" . $requisition['bill_rate_type'] . ")";
                             ?></td>
                            <td><?php echo $requisition['pay_rate'] . "<br>";
                                      echo "(" . $requisition['pay_rate_type'] . ")";
                             ?></td>
                            <td><?php echo date('m-d-Y',strtotime($requisition['start_date'])); ?></td>
                            <td><?php echo date('m-d-Y',strtotime($requisition['end_date'])); ?></td>
                            <td class="text-center">
                              <a
                                href="<?php echo site_url('admin-requisition-candidate-list'); ?>"
                                >0</a
                              >
                            </td>
                            <td>
                              <?php if($requisition['status'] == "1") {

                                echo "Searching";
                              } else if ($requisition['status'] == "1") {
                                echo "Hired";
                              }
                              ?> 
                            </td>
                            <td class="text-center">
                                <a
                                  href=""
                                  data-toggle="tooltip"
                                  data-placement="top"
                                  title="View Details"
                                  style="margin: 0 2px;"
                                >
                                  <i
                                    class="fa fa-lg fa-eye"
                                    aria-hidden="true"
                                    style="color: #09274b;"
                                  ></i>
                                </a>
                              </a>
                              <span
                                data-toggle="modal"
                                data-target="#requisition_modal"
                              >
                                
                              </span>
                              <a
                                style="margin: 0px 2px; color: blue;"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Add Candidate"
                                href="#"
                                ><i class="fa fa-lg fa-plus" aria-hidden="true"></i
                              ></a>
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
              <?php } ?>
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
<script>
  $(function () {
    $("#table_id").DataTable();
  });
</script>
<script>
  $(document).ready(function() {
        $('#ingredients').multiselect();
    });
</script>