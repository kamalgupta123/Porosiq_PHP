<?php
$this->load->view('superadmin/includes/header');
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

    .fa-lock  {
        color: #f90000;
    }
    .fa-times  {
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
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Document
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Documentation</a></li>
                <li class="active">Edit Document Template</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">
            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
            <?php } ?>
            <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
            <?php } ?>
            <div class="alert alert-success succ-msg" style="display: none;">success</div>
            <div class="alert alert-danger succ-err" style="display: none;">error</div>
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box">
                        <div class="box-body">
                            <!--Write your codes here-->
                            <div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="panel panel-info">
										<div class="panel-heading">
											<h3 class="panel-title">
												<span class="glyphicon glyphicon-file"></span> Edit Document Template
												<p style="float: right; font-size: 11px;">
													<span style="color: red;">*</span>Required Fields
												</p>
											</h3>
										</div>

                       
                                        <form id="edit_doc_template_form"
											action="<?php echo site_url('update-document-template'); ?>"
											method="post" enctype="multipart/form-data">
											<div class="panel-body">
												<div class="row">

													<div style="margin-top: 20px;"
														class="col-xs-12 col-sm-12 col-md-12">

														<table class="table table-bordered table-striped"
															width="100%" border="1" cellspacing="2" cellpadding="2">
															<tbody>
																<tr>
																	<td width="25%"><label for="document_name" class="lbl-css">Document Template
																			Name <span style="color: red;">*</span>
																	</label></td>
																	<td width="25%">
																		<input class="form-control validate[required]"
																		type="text" id="doc_template_name" name="doc_template_name"
																		placeholder="Document Template Name" 
                                                                        value="<?php echo $doc_template_name; ?>">
																	</td>
																	<td colspan="2"></td>
																</tr>
																<tr>
																	<td width="25%"><label for="required_for" class="lbl-css">Required For <span style="color: red;">*</span>
																	</label></td>
																	<td><span> 
																		<input class="validate[required]" type="checkbox"
																		id="check1" name="required_for[]" value="C" <?php echo $is_consultant; ?>>
																			Consultants &nbsp;&nbsp;&nbsp; 
																		<input class="validate[required]" type="checkbox"
																		id="check1" name="required_for[]" value="E"<?php echo $is_employee; ?>>
																			Employees <br /> 
																		<input class="validate[required]"
																		type="checkbox" id="check2" name="required_for[]"
																		value="TE"  
                                                                        <?php echo $is_temp_emp; ?>> Temporary Employees  &nbsp;&nbsp;&nbsp;
																		<input class="validate[required]"
																			type="checkbox" id="check2" name="required_for[]"
																			value="1099"  
                                                                             <?php echo $is_1099; ?>> 1099 Users
																	</span></td>
																	<td><label>Pay Rate Type</label></td>
																	<td>
																		<select name="pay_rate_type" id="pay_rate_type" class="">
                                                                            <option value="">---Select Type---</option>
                                                                            <option value="hourly"
                                                                            <?php echo $is_monthly; ?>>Hourly</option>
                                                                            <option value="yearly"
                                                                            <?php echo $is_yearly; ?>>Yearly</option>
                                                                        </select>
																	</td>
																</tr>
																<tr>
																	<td width="25%">
                                                                        <label>Classification</label> 
                                                                    </td>
																	<td width="25%">
																	    <select name="classification" id="classification" class="">
                                                                            <option value="">---Select---</option>
                                                           			        <?php echo show_classifications($classification); ?>
                                                      				    </select>
																	</td>
																	<td width="25%">
                                                                        <label>Category</label>
                                                                    </td>
																	<td width="25%">
																	   <select name="category" id="category" class="">
                                                                            <option value="">---Select---</option>
                                                           				    <?php echo show_categories($category); ?>
                                                        			    </select>
																	</td>
																</tr>
																	<td><label>Applicable Date</label></td>
																	<td>
                                                                        <input type="date" id="applicable_date" name="applicable_date" class=""
                                                                        value="<?php echo $applicable_date; ?>">
                                                                    </td>
																	<td>
                                                                        <label>
                                                                            Status
                                                                            <span style="color: red;">*</span>
                                                                        </label>
                                                                    </td>
																	<td>
																	<select name="status" class="validate[required]">
																		<option value="">---Select---</option>
                                                                        <option value="1"
                                                                        <?php echo $is_active; ?>>Active</option>
                                                                        <option value="2"
                                                                        <?php echo $is_archive; ?>>Archive</option>
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
                                                        <input type="hidden" name="doc_template_id" value="<?php echo $doc_template_id; ?>">
														<input class="btn btn-success" type="submit" name="submit"
														value="Update Document Template">
                                                        <a href="<?php echo site_url('document-template-list'); ?>" class="btn btn-default">Back</a>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
                            
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
    $this->load->view('superadmin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('superadmin/includes/footer');
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
        $("#edit_doc_template_form").validationEngine({promptPosition: 'inline'});
    });
</script>
<script>
    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })
</script>
