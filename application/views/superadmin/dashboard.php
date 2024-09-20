<?php
$this->load->view('superadmin/includes/header');
global $global_user_privileges;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js" integrity="sha512-hZf9Qhp3rlDJBvAKvmiG+goaaKRZA6LKUO35oK6EsM0/kjPK32Yw7URqrq3Q+Nvbbt8Usss+IekL7CRn83dYmw==" crossorigin="anonymous"></script>
<style>
    table.scroll {
        /* width: 100%; */
        /* Optional */
        /* border-collapse: collapse; */
        border-spacing: 0;
        /*border: 2px solid black;*/
    }

    table.scroll tbody,
    table.scroll thead {
        /*display: block;*/
    }

    table.scroll thead tr th {
        height: 30px;
        line-height: 30px;
        /* text-align: left; */
    }

    table.scroll tbody {
        height: 400px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    table.scroll tbody {
        /*border-top: 2px solid black; */
    }

    table.scroll tbody td, thead th {
        /* width: 20%; */
        /* Optional */
        /*border-right: 1px solid black;*/
        /* white-space: nowrap; */
    }

    table.scroll tbody td:last-child, thead th:last-child {
        border-right: none;
    }

    #timesheet, #consultant_invoice, #employee_invoice, #user_invoice {
        display: none;
    }
    #expand-collapse, #expand-collapse-cons, #expand-collapse-emp, #expand-collapse-user {
        float: right;
        cursor:pointer;
        text-decoration:underline; 
        color:#09f;
    }

.timesheet_container{
    display: flex;
    margin-bottom:1rem;
    align-items: center;
   
}
.start {
    display: block;
    margin-bottom: 10px;
    
}
.calender-container{
    margin: 1rem;
}
.calender{
    padding: 5px;
    border-radius: 5px;
    border: 1px solid;
}
.user{
    display: flex;
    flex-direction: column;
    margin-left: 1rem;
}
.user-type{
    margin-bottom: 10px;
}
.user-select{
    padding: 8px;
    border-radius: 5px;
    padding-right: 100px;
}

.timesheet{
    display: flex;
    flex-direction: column;
    margin-left: 2rem;
}
.timesheet-select{
    padding: 8px;
    border-radius: 5px;
    padding-right: 100px;
}
.timesheet-status{
    margin-bottom: 10px;
}
.button-container{
    margin-left: 1rem;
  
}
.filter-button{
    margin-top: 30px;
    margin-left: 2rem;
    padding: 5px 16px;
    cursor: pointer;
    text-align: center;
    background-color: #4CAF50;
    border: none;
    text-align: center;
    text-decoration: none;
    border-radius: 2px;
    color: white;
    outline: none;
}
.loader-container{
    display:none;
}
.loader{
   width: 100px;
   height: auto;
}
.my-small-box{
        border-radius: 2px;
        position: relative;
        display: block;
        margin-bottom: 90px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        color: white;
        width: 350px;
        height: 200px;
        padding: 0 10px;
        overflow:hidden;
    }
    .my-img-box{
        border-radius: 2px;
        position: relative;
        display: block;
        margin-bottom: 20px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        color: white;
        width: 350px;
        height: 200px;
    }
    .my-small-box-footer{
        display: block;
        position:absolute !important;
        width: 100%;
        left: 0px;
        bottom: 0px;
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px; 
       
    }
    .my-img-footer{
        display: block;
        position:absolute !important;
        width: 100%;
        left: 0px;
        bottom: 0px;
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px; 
    }
    .my-icon{
        transition: all .3s linear;
        position: absolute !important;
        top: -40px  !important;
        right: 13px  !important;
        z-index: 0;
        font-size: 160px  !important;
        color: rgba(0, 0, 0, 0.15);
    }
    .client-top{
        padding-top: 5px;
        padding-bottom: 5px;
        display: block;
        color: black;
        margin: 0;
        font-weight: bold;
        font-size: 12px;
        text-align: center;
        background-color: white;
    }
.box-links-container{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}
.box-link{
    display: block;
    text-align: center;
    padding: 10px;
    color:#fff;
}
.box-link:hover{
    color:white;
    opacity:0.9;
}
.box-link:focus{
    color:white; 
}
.box-link:visited{
    color:white; 
}

</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/expand-collapse.js"></script>
<div class="wrapper" xmlns="http://www.w3.org/1999/html">

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
            <!-- Sidebar user panel -->

            <?php
            $this->load->view('superadmin/includes/user_panel');
            $this->load->view('superadmin/includes/sidebar');
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <?php if (LATAM) { ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo CLIENT_NAME; ?>
                    <small>Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Overview</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <?php
                $check_is_view = "";
                if (!empty($get_menu_permission)) {
                    $check_is_view = $this->profile_model->getMenuStatus('1',  $sa_id);
                    if (!empty($check_is_view)) {
                        if ($check_is_view[0]['is_view'] == '1') {
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <?php
                                if (!empty($get_admin_details)) {
                                    if (count($get_admin_details) > 0) {
                                        $count_admin = count($get_admin_details);
                                    } else {
                                        $count_admin = 0;
                                    }
                                } else {
                                    $count_admin = 0;
                                }
                                ?>
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3><?php echo $count_admin; ?></h3>

                                        <p>Admin</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-stalker"></i>
                                    </div>
                                    <a href="<?php echo site_url('admin-user'); ?>" class="small-box-footer">View All <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <!-- ./col -->

                    <?php
                    $check_is_view = $this->profile_model->getMenuStatus('2', $sa_id);
                    if (!empty($check_is_view)) {
                        if ($check_is_view[0]['is_view'] == '1') {
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <?php
                                if (!empty($get_vendor_details)) {
                                    if (count($get_vendor_details) > 0) {
                                        $count_vendor = count($get_vendor_details);
                                    } else {
                                        $count_vendor = 0;
                                    }
                                } else {
                                    $count_vendor = 0;
                                }
                                ?>
                                <!-- small box -->
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3><?php echo $count_vendor; ?><sup style="font-size: 20px"></sup></h3>

                                        <p>Vendor</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-ios-people"></i>
                                    </div>
                                    <a href="<?php echo site_url('vendor-user'); ?>" class="small-box-footer">View All <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <!-- ./col -->

                    <?php
                    $check_is_view = $this->profile_model->getMenuStatus('8', $sa_id);
                    if (!empty($check_is_view)) {
                        if ($check_is_view[0]['is_view'] == '1') {
                            ?>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <?php
                                if (!empty($get_consultant_details)) {
                                    if (count($get_consultant_details) > 0) {
                                        $count_employee = count($get_consultant_details);
                                    } else {
                                        $count_employee = 0;
                                    }
                                } else {
                                    $count_employee = 0;
                                }
                                ?>
                                <!-- small box -->
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3><?php echo $count_employee; ?></h3>

                                        <p>Consultant</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-android-people"></i>
                                    </div>
                                    <a href="<?php echo site_url('consultant-user'); ?>" class="small-box-footer">View All <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                    <!-- ./col -->

                    <?php
                    $check_is_view = $this->profile_model->getMenuStatus('42', $sa_id);
                    if (!empty($check_is_view)) {
                        if ($check_is_view[0]['is_view'] == '1') {
                            ?>
                            <?php
                            //if ($global_user_privileges['employee']) {
                                // Section - Employee Category
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <?php
                                if ((!empty($get_employee_details)) || (!empty($get_ten99user_details))) {
                                if ((count($get_employee_details) > 0) || (count($get_ten99user_details)>0)) {
                                        $count_emp = count($get_employee_details) + count($get_ten99user_details);
                                    } else {
                                        $count_emp = 0;
                                    }
                                } else {
                                    $count_emp = 0;
                                }
                                ?>
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3><?php echo $count_emp; ?></h3>

                                        <p>Employee</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-stalker"></i>
                                    </div>
                                    <a href="<?php echo site_url('superadmin-employee-list'); ?>" class="small-box-footer">View All <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <?php

                           // }
                        }
                    }

                }
                ?>

            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <?php //if ($global_user_privileges['timesheet']) { ?>
                <section class="col-lg-12 connectedSortable">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Timesheet</h3>
                            <span id="expand-collapse" onClick="expandCollapse()">Expand</span>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body table-responsive no-padding" id="timesheet">
                            <form id="timesheet_form" method="post" enctype="multipart/form-data">
                        <!--action="<?php //echo site_url('sadmin-load-historical-timesheet'); ?>"-->
                                <div class="timesheet_container">
                                  <div class="calender-container">
                                    <label class="start" for="start">Start date:</label>
                                    <input
                                      type="date"
                                      id="from_date"
                                      name="from_date"
                                      value=""
                                      class="calender"
                                    />
                                  </div>

                                  <div class="calender-container">
                                    <label class="start" for="start">End date:</label>
                                    <input
                                      type="date"
                                      id="to_date"
                                      name="to_date"
                                      value=""
                                      class="calender"
                                    />
                                  </div>
                                  <div class="user">
                                    <label class="user-type" for="user_type">User Type:</label>
                                    <select class="user-select" name="user_type" id="user_type">
                                      <option value="C">Consultant</option>
                                      <option value="E">Employee</option>
                                      <option value="1099">1099 Users</option>
                                    </select>
                                  </div>
                                  <div class="timesheet">
                                    <label class="timesheet-status" for="ts_Status">Timesheet Status:</label>
                                    <select class="timesheet-select" name="ts_Status" id="ts_Status">
                                      <option value="1">Approved</option>
                                      <option value="2">Pending</option>
                                      <option value="0">Not Approved</option>
                                    </select>
                                  </div>

                                  <button class="filter-button" id="timesheet_form_submit" type="submit" name="submit" value="Submit">
                                    Apply Filters
                                  </button>
                              </div>
                            </form>
                            <div class="loader-container" id="loader">
                                <center>
                                    <img class="loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="" />
                                </center>
                            </div>
                            <div  style="margin:0 1rem;"  id="ajax_timesheet_data">
                                <table id="timesheet_tbl" class="table table-bordered table-striped table-responsive" style="font-size: 12px;"  width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Timesheet ID</th>
                                            <th style="text-align: center;">Project Code</th>
                                            <th style="text-align: center;">Project Name</th>
                                            <th style="text-align: center;">Code</th>
                                            <th style="text-align: center;">Name</th>
                                            <th style="text-align: center;">Type</th>
                                            <th style="text-align: center;">Start Date</th>
                                            <th style="text-align: center;">End Date</th>
                                            <th style="text-align: center;">ST</th>
                                            <th style="text-align: center;">OT</th>
                                            <th style="text-align: center;">Timesheet Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <?php //} ?>
                <?php
                $check_is_view = $this->profile_model->getMenuStatus('10', $sa_id);
                if (!empty($check_is_view) && count($check_is_view)) {
                    if (isset($check_is_view[0]['is_view']) && $check_is_view[0]['is_view'] == '1') {
                        ?>
                        <section class="col-lg-12 connectedSortable">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Consultant's Invoice Summary</h3>
                                    <span id="expand-collapse-cons" onClick="expandCollapseConsultant()">Expand</span>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body  no-padding" id="consultant_invoice">
                                    
                                        <form id="cons_invoice_form" method="post" enctype="multipart/form-data">
                                            <div class="timesheet_container">
                                              <div class="calender-container">
                                                <label class="start" for="start">Start date:</label>
                                                <input
                                                  type="date"
                                                  id="from_date"
                                                  name="from_date"
                                                  value=""
                                                  class="calender"
                                                />
                                              </div>

                                              <div class="calender-container">
                                                <label class="start" for="start">End date:</label>
                                                <input
                                                  type="date"
                                                  id="to_date"
                                                  name="to_date"
                                                  value=""
                                                  class="calender"
                                                />
                                              </div>
                                              <button class="filter-button" id="form_submit" type="submit" name="submit" value="Submit">
                                                Apply Filters
                                              </button>
                                          </div>
                                        </form>
                                    <div class="loader-container" id="cons_loader">
                                        <center>
                                            <img class="loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="" />
                                        </center>
                                    </div>    
                                    
                                    <div class= "table-responsive" style="margin:0 1rem;" id="cons_ajax_data">
                                        <table id="van_tbl" class="table table-bordered table-striped table-responsive"
                                           style="font-size: 11px;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="1%">SL No.</th>
                                                    <th>Invoice ID</th>
                                                    <th>Timesheet ID</th>
                                                    <th>Consultant Name</th>
                                                    <th>Consultant Code</th>
                                                    <th>Consultant Designation</th>
                                                    <th>Point of Contact</th>
                                                    <th>Company Name</th>
                                                    <th>Admin Name</th>
                                                    <th>Payment Mode</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Rate</th>
                                                    <th>Pay</th>
                                                    <th>Invoice Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="col-lg-12 connectedSortable">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Employee's Invoice Summary</h3>
                                    <span id="expand-collapse-emp" onClick="expandCollapseEmployee()">Expand</span>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding" id="employee_invoice">
                                    <form id="emp_invoice_form" method="post" enctype="multipart/form-data">
                                            <div class="timesheet_container">
                                              <div class="calender-container">
                                                <label class="start" for="start">Start date:</label>
                                                <input
                                                  type="date"
                                                  id="from_date"
                                                  name="from_date"
                                                  value=""
                                                  class="calender"
                                                />
                                              </div>

                                              <div class="calender-container">
                                                <label class="start" for="start">End date:</label>
                                                <input
                                                  type="date"
                                                  id="to_date"
                                                  name="to_date"
                                                  value=""
                                                  class="calender"
                                                />
                                              </div>
                                              <button class="filter-button" id="emp_form_submit" type="submit" name="submit" value="Submit">
                                                Apply Filters
                                              </button>
                                            </div>
                                        </form>
                                        <div class="loader-container" id="emp_loader">
                                            <center>
                                                <img class="loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="" />
                                            </center>
                                        </div>    
                                        <div class= "table-responsive" style="margin:0 1rem;" id="emp_ajax_data">
                                            <table id="emp_tbl" class="table table-bordered table-striped table-responsive"
                                           style="font-size: 11px;" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th width="1%">SL No.</th>
                                                        <th>Invoice ID</th>
                                                        <th>Timesheet ID</th>
                                                        <th>Employee Name</th>
                                                        <th>Employee Code</th>
                                                        <th>Employee Designation</th>
                                                        <th>Payment Mode</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Rate</th>
                                                        <th>Pay</th>
                                                        <th>Invoice Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </section>
                        <section class="col-lg-12 connectedSortable">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">1099 User's Invoice Summary</h3>
                                    <span id="expand-collapse-user" onClick="expandCollapseUser()">Expand</span>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding" id="user_invoice">
                                    <form id="1099_invoice_form" method="post" enctype="multipart/form-data">
                                            <div class="timesheet_container">
                                              <div class="calender-container">
                                                <label class="start" for="start">Start date:</label>
                                                <input
                                                  type="date"
                                                  id="from_date"
                                                  name="from_date"
                                                  value=""
                                                  class="calender"
                                                />
                                              </div>

                                              <div class="calender-container">
                                                <label class="start" for="start">End date:</label>
                                                <input
                                                  type="date"
                                                  id="to_date"
                                                  name="to_date"
                                                  value=""
                                                  class="calender"
                                                />
                                              </div>
                                              <button class="filter-button" id="1099_form_submit" type="submit" name="submit" value="Submit">
                                                Apply Filters
                                              </button>
                                            </div>
                                        </form>
                                        <div class="loader-container" id="1099_loader">
                                            <center>
                                                <img class="loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="" />
                                            </center>
                                        </div> 
                                        <div class= "table-responsive" style="margin:0 1rem;" id="1099_ajax_data">
                                            <table id="ten99_tbl" class="table table-bordered table-striped table-responsive"
                                           style="font-size: 11px;" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th width="1%">SL No.</th>
                                                        <th>Invoice ID</th>
                                                        <th>Timesheet ID</th>
                                                        <th>1099 Usesr Name</th>
                                                        <th>1099 User Code</th>
                                                        <th>1099 User Designation</th>
                                                        <th>Payment Mode</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Rate</th>
                                                        <th>Pay</th>
                                                        <th>Invoice Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </section>
                    <?php
                    }
                }
                ?>
                      
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php } ?>

    <?php if (US || INDIA) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo CLIENT_NAME; ?>
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Overview</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                            <div class="small-box my-small-box">
                            <!--script defer type="text/javascript" src="<?php //echo base_url(); ?>assets/js/charts/accountsRecieveable.js"></script-->
                            <canvas id="accountsChart"></canvas>
                            <script type="text/javascript">
                            let varAccountsChart = document
                                    .getElementById("accountsChart")
                                    .getContext("2d");

                                var accountsChart = new Chart(varAccountsChart, {
                                    type: "doughnut",
                                    data: {
                                        labels: [
                                            "1-30 days",
                                            "31-60 days",
                                            "61-90 days",
                                            "91-120 days",
                                        ],
                                        fontColor: "black",
                                        datasets: [
                                            {
                                                label: "Accounts Receivable",
                                                data: <?php echo json_encode($account_receivable_chart); ?>, //[120, 50, 30, 110, 30]
                                                backgroundColor: [
                                                    "#92ccfc",
                                                    "#e08cec",
                                                    "#f5a5c8",
                                                    "#ffcc5c",
                                                ],
                                            },
                                        ],
                                    },
                                    options: {
                                        responsive: true,
                                        legend: {
                                            display: true,
                                            position: "right",
                                            align: "center",
                                            labels: {
                                                fontColor: "black",
                                                boxWidth: 10,
                                            },
                                        },
                                        title: {
                                            display: true,
                                            text: "Accounts Receivable",
                                            fontColor: "black",
                                        },
                                    },
                                });
            
                            </script>
                                <a style="background-color:#565d64" href="<?php //echo site_url('admin_vendor_lists'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                            <div class="small-box my-small-box">
                                <!--script type="text/javascript" defer src="<?php //echo base_url(); ?>assets/js/charts/financeChart.js"></script-->
                                <canvas id="elFinanceChart"></canvas>
                                <script type="text/javascript">
                                    let varFinanceChart = document
                                        .getElementById("elFinanceChart")
                                        .getContext("2d");

                                    var financeChart = new Chart(varFinanceChart, {
                                        type: "line",
                                        data: {
                                            labels: [
                                                "Jan",
                                                "Feb",
                                                "Mar",
                                                "Apr",
                                                "May",
                                                "Jun",
                                                "Jul",
                                                "Aug",
                                                "Sep",
                                                "Oct",
                                                "Nov",
                                                "Dec",
                                            ],
                                            datasets: [
                                                {
                                                    data: <?php echo json_encode($finance_chart); ?> , //[20, 40, 70, 80, 120, 140, 50, 65, 30, 55, 100, 70]
                                                    fill: false,
                                                    backgroundColor: "green",
                                                    borderColor: "orange",
                                                    pointBackgroundColor: "orange",
                                                    pointBorderColor: "orange",
                                                    pointHoverBackgroundColor: "orange",
                                                    pointHoverBorderColor: "orange",
                                                },
                                            ],
                                        },
                                        options: {
                                            tooltips: {
                                                callbacks: {
                                                    label: function (tooltipItem) {
                                                        return Number(tooltipItem.yLabel) + "$";
                                                    },
                                                },
                                            },
                                            legend: {
                                                display: false,
                                            },
                                            title: {
                                                display: true,
                                                text: "Finance Chart",
                                                fontSize: 12,
                                                fontColor: "black",
                                            },
                                            scales: {
                                                yAxes: [
                                                    {
                                                        scaleLabel: {
                                                            display: true,
                                                            fontColor: "black",
                                                            labelString: "Amount (in $)",
                                                        },
                                                        ticks: {
                                                            beginAtZero: true,
                                                            fontColor: "black",
                                                            stepSize: 50,
                                                            maxTicksLimit: 5,
                                                            callback: function (value, index, values) {
                                                                return value;
                                                            },
                                                        },
                                                        gridLines: {
                                                            color: "rgba(0, 0, 0, 0)",
                                                        },
                                                    },
                                                ],
                                                xAxes: [
                                                    {
                                                        scaleLabel: {
                                                            display: true,
                                                            labelString: "Months",
                                                            fontColor: "black",
                                                        },
                                                        ticks: {
                                                            fontColor: "black",
                                                        },
                                                        gridLines: {
                                                            color: "rgba(0, 0, 0, 0)",
                                                        },
                                                    },
                                                ],
                                            },
                                        },
                                    });

                                </script>
                                <a style="background-color:#565d64" href="<?php //echo site_url('admin-employee-list'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                                    <div style="background-color:#565d64" class="small-box my-small-box">
                                    <!--script type="text/javascript" defer src="<?php //echo base_url(); ?>assets/js/charts/employeeCategory.js"></script-->
                                    <canvas id="elEmployeeChart"></canvas>
                                        <script type="text/javascript">
                                            let varEmployeeChart = document
                                            .getElementById("elEmployeeChart")
                                            .getContext("2d");

                                            Chart.defaults.global.defaultFontColor = "white";
                                            Chart.defaults.global.defaultFontSize = 10;
                                            var employeeChart = new Chart(varEmployeeChart, {
                                                type: "pie",
                                                data: {
                                                    labels: [
                                                        "IT",
                                                        "Admin Clerical",
                                                        "Professional",
                                                        "Light Industrial",
                                                        "Engineering",
                                                        "Scientific",
                                                        "Healthcare",
                                                    ],
                                                    datasets: [
                                                        {
                                                            label: "Employee category",
                                                            data: <?php echo json_encode($emp_chart); ?>,
                                                            backgroundColor: [
                                                                "rgba(255, 99, 132, 1)",
                                                                "rgba(54, 162, 235, 1)",
                                                                "rgba(255, 206, 86, 1)",
                                                                "rgba(75, 192, 192, 1)",
                                                                "rgba(153, 102, 255, 1)",
                                                                "rgba(255, 159, 64, 1)",
                                                                "rgb(187,187,187)",
                                                                "rgba(255, 99, 132, 1)",
                                                                "rgba(255, 206, 86, 1)",
                                                                "rgba(75, 192, 192, 1)",
                                                                "rgba(153, 102, 255, 1)",
                                                            ],
                                                        },
                                                    ],
                                                },
                                                options: {
                                                    legend: {
                                                        display: true,
                                                        position: "right",
                                                        align: "center",
                                                        labels: {
                                                            boxWidth: 10,
                                                        },
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: "Employee Category",
                                                    },
                                                },
                                            });

                                        </script>
                                        
                                        <a href="<?php //echo site_url('admin-employee-list'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                                <div class="small-box my-small-box">
                                <!--script defer type="text/javascript" src="<?php //echo base_url(); ?>assets/js/charts/vendorChart.js"></script-->
                                <canvas id="VendorChart"></canvas>
                                    <script type="text/javascript">
                                        let varVenderChart = document.getElementById("VendorChart").getContext("2d");

                                        var vendorChart = new Chart(varVenderChart, {
                                            type: "bar",
                                            data: {
                                                labels: [
                                                    "Jan",
                                                    "Feb",
                                                    "Mar",
                                                    "Apr",
                                                    "May",
                                                    "Jun",
                                                    "Jul",
                                                    "Aug",
                                                    "Sep",
                                                    "Oct",
                                                    "Nov",
                                                    "Dec",
                                                ],
                                                datasets: [
                                                    {
                                                        data: <?php echo json_encode($vendor_chart); ?>, //[4, 30, 20, 35, 23, 12, 22, 43, 34, 33, 29, 30]
                                                        backgroundColor: "blue",
                                                    },
                                                ],
                                            },
                                            options: {
                                                legend: {
                                                    display: false,
                                                },
                                                title: {
                                                    display: true,
                                                    text: "Vendor Chart",
                                                    fontSize: 12,
                                                    fontColor: "black",
                                                },
                                                scales: {
                                                    yAxes: [
                                                        {
                                                            scaleLabel: {
                                                                display: false,
                                                                fontColor: "black",
                                                                labelString: "Vendor",
                                                            },
                                                            ticks: {
                                                                beginAtZero: true,
                                                                fontColor: "black",
                                                                stepSize: 10,
                                                                maxTicksLimit: 5,
                                                            },
                                                            gridLines: {
                                                                color: "rgba(0, 0, 0, 0)",
                                                            },
                                                        },
                                                    ],
                                                    xAxes: [
                                                        {
                                                            scaleLabel: {
                                                                display: true,
                                                                labelString: "Months",
                                                                fontColor: "black",
                                                            },
                                                            ticks: {
                                                                fontColor: "black",
                                                            },
                                                            gridLines: {
                                                                color: "rgba(0, 0, 0, 0)",
                                                            },
                                                        },
                                                    ],
                                                },
                                            },
                                        });

                                    </script>
                                    <a style="background-color:#565d64" href="<?php //echo site_url('admin-employee-list'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                            <div  class="small-box my-small-box">
                                <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/charts/clientPerformance.js"></script>
                                <canvas id="clientChart"></canvas>
                                <a style="background-color:#565d64" href="<?php //echo site_url('admin_consultant_lists'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                            
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                                <div style="background-color:#565d64; padding:0px;" class="small-box my-small-box">
                                        <div class="box-links-container">
                                            <a style="background-color:#09274B;" class="box-link" href="<?php echo site_url('sadmin-timesheet'); ?>">TimeSheet</a> 
                                            <a style="background-color:#09274B;" class="box-link" href="<?php echo site_url('sadmin-cons-invoice-summery'); ?>">Consultant's Invoice Summary</a> 
                                            <a style="background-color:#09274B;" class="box-link" href="<?php echo site_url('sadmin-emp-invoice-summery'); ?>">Employee's Invoice Summary</a> 
                                            <a style="background-color:#09274B;" class="box-link" href="<?php echo site_url('sadmin-ten99-invoice-summery'); ?>">1099 User's Invoice Summary</a> 
                                        </div>   
                                    </div>
                            </div>
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
    <?php } ?>
    <?php
    $this->load->view('superadmin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('superadmin/includes/footer');
?>

<?php if (LATAM) { ?>
<script>
    $(function() {

  $("#form_submit").click(function(e){  // passing down the event 

    $('#cons_loader').show();
    $('#cons_ajax_data').hide();

    $.ajax({
       url:'sadmin-load-cons-invoice', // //superadmin/login/load_cons_invoice
       type: 'POST',
       data: $("#cons_invoice_form").serialize(),
       success: function(response){
           $("#cons_ajax_data").html(response);
           $('#cons_loader').hide();
           $('#cons_ajax_data').show();
       },
       error: function(){
       }
   });
   e.preventDefault(); // could also use: return false;
 });

 $("#timesheet_form_submit").click(function(e){  // passing down the event 

    var spinner = $('#loader');
    spinner.show();
    $('#ajax_timesheet_data').hide();
    $.ajax({
       url:'sadmin-load-timesheet', 
       type: 'POST',
       data: $("#timesheet_form").serialize(),
       success: function(response){
           $("#ajax_timesheet_data").html(response);
           spinner.hide();
            $('#ajax_timesheet_data').show();
       },
       error: function(){
       }
   });
   e.preventDefault(); // could also use: return false;
 });

 $("#emp_form_submit").click(function(e){  // passing down the event 

    $('#emp_loader').show();
    $('#emp_ajax_data').hide();

    $.ajax({
       url:'sadmin-load-emp-invoice', 
       type: 'POST',
       data: $("#emp_invoice_form").serialize(),
       success: function(response){
           $("#emp_ajax_data").html(response);
           $('#emp_loader').hide();
           $('#emp_ajax_data').show();
       },
       error: function(){
       }
   });
   e.preventDefault(); // could also use: return false;
 });

 $("#1099_form_submit").click(function(e){  // passing down the event 

    $('#1099_loader').show();
    $('#1099_ajax_data').hide();

    $.ajax({
       url:'sadmin-load-1099-invoice', 
       type: 'POST',
       data: $("#1099_invoice_form").serialize(),
       success: function(response){
           $("#1099_ajax_data").html(response);
           $('#1099_loader').hide();
           $('#1099_ajax_data').show();
       },
       error: function(){
       }
   });
   e.preventDefault(); // could also use: return false;
 });

});

    $(function () {

        $('#timesheet_tbl').DataTable({
            //scrollY: "300px",
            // scrollX: true,
            // scrollCollapse: true,
//            paging: false,
            "order": [[ 6, "desc" ]]

        });

        $('#van_tbl').DataTable({
           // "order": [[ 1, "desc" ]]
        });
        $('#emp_tbl').DataTable({
           // "order": [[ 1, "desc" ]]
        });
        $('#ten99_tbl').DataTable({
            "order": [[ 1, "desc" ]]
        });
    });
    
</script>
<?php } ?>

<script>

    function getApprove(val) {
        var invoice_id = val;

        $.post("<?php echo site_url('approve_invoice'); ?>", {invoice_id: invoice_id}, function (data) {
            //alert(data);
            if (data == 1) {
                location.reload();
                $(".err").hide();
                $(".succ").show();
            } else {
                location.reload();
                $(".err").show();
                $(".succ").hide();
            }

        });
    }
</script>