<?php
$this->load->view('superadmin/includes/header');
?>
<style type="text/css">
.loader-container{
    display:none;
}
.loader{
   width: 100px;
   height: auto;
}
</style>

<div class="wrapper">

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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    	<section class="content-header">
            <h1>
                Historical Timesheet <small>Management</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
        	
        	<!-- Main row -->
            <div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
            		<div class="panel panel-info">
            			<div class="panel-heading">
            				<h3 class="panel-title">
                                <span class="glyphicon glyphicon-book"></span>
                                Get Historical Timesheet Data
                                <p style="float: right;font-size: 11px;"><span style="color:red;">*</span>Required Fields</p>
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

                        <form id="historical_timesheet_form" method="post" enctype="multipart/form-data">
                        <!--action="<?php //echo site_url('sadmin-load-historical-timesheet'); ?>"-->
                            <div class="panel-body">
                            	<div class="row">
                            		<div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">
                            			
                            			<table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                            				<tbody>
                            					<tr>
                            						<td width="25%">
                            							<label for="from_date">From Date <span style="color: red;"> *</span></label>
                            						</td>
                            						<td width="25%">
                            							<input type="date" name="from_date" class="form-control validate[required]" id="from_date" value="" >
                            						</td>
                            						<td width="25%">
                            							<label for="to_date">To Date <span style="color: red;">*</span></label>
                            						</td>
                            						<td>
                            							<input type="date" name="to_date" class="form-control validate[required]" id="to_date" value="" >
                            						</td>
                            					</tr>
                            					<tr>
                            						<td width="25%">
                            							<label for="user_type">User Type <span style="color: red;"> *</span></label>
                            						</td>
                            						<td width="25%">
                            							<select name="user_type" id="user_type" class="form-control">
															<option value="C">Consultant</option>
															<option value="E">Employee</option>
															<option value="1099">1099 Users</option>
														</select>
                            						</td>
                            						<td width="25%">
                            							<label for="ts_Status">Timesheet Status <span style="color: red;">*</span></label>
                            						</td>
                            						<td width="25%">
                            							<select name="ts_Status" id="ts_Status" class="form-control">
															<option value="1">Approved</option>
															<option value="2">Pending</option>
															<option value="0">Not Approved</option>
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
                                        <input class="btn btn-success" id="form_submit" type="submit" name="submit" value="Submit">
                                        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
                                        <input type="hidden" name="sa_id" value="<?php echo $get_details[0]['sa_id']; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
            		</div>
            	</div>
            </div>
            <!-- /.row (main row) -->

            <div class="loader-container" id="loader">
                <center>
                    <img class="loader" src="<?php echo base_url(); ?>assets/images/loader-transparent.gif" alt="" />
                </center>
            </div>

            <div class="table-responsive" id="ajax_data">
            	
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php
    $this->load->view('superadmin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('superadmin/includes/footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sadmin-historical-timesheet.js"></script>