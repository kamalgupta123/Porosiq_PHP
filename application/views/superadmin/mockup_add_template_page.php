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
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Documents</a></li>
                <li class="active">Add Documents</li>
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
												<span class="glyphicon glyphicon-file"></span> Add Documents
												<p style="float: right; font-size: 11px;">
													<span style="color: red;">*</span>Required Fields
												</p>
											</h3>
										</div>

                       
                                        <form id="add_documentation_form"
											action=""
											method="post" enctype="multipart/form-data">
											<div class="panel-body">
												<div class="row">

													<div style="margin-top: 20px;"
														class="col-xs-12 col-sm-12 col-md-12">

														<table class="table table-bordered table-striped" id="docTable"
															width="100%" border="1" cellspacing="2" cellpadding="2">
															<tbody>
																<tr>
																	<td colspan="4">
																		 <div class="table-responsive">
																			<table id="docs_tbl"
																				class="table table-bordered table-striped"
																				style="font-size: 11px;">
																				<thead>
																					<tr>
																						<th>Sl.</th>
																						<th>Document Template</th>
																						<th>Document  Name</th>
																						<th>File</th>
																						<th>Applicable Date</th>
																						<th>Status</th>
																					</tr>
																				</thead>
																				<tbody>
																					<tr>
																						<td>1</td>
																						<td>
																							<select name="doc_template_name" id="doc_template_name" class="form-control validate[required]">
                                                                                                <option value="">---Select Doc Template---</option>
                                                                                                <option value="temp1">Doc Template 1</option>
                                                                                                <option value="temp2">Doc Template 2</option>
                                                                                            </select>
																						</td>
																						<td><input class="form-control validate[required]" type="text" id="document_name1" name="document_name"	placeholder="Document  Name" value=""></td>
																						<td><input class="validate[required]" type="file" name="list_a_doc_name[]" id="template_file"></td>
																						<td><input type="date" id="start_date" name="start_date" class="validate[required]" placeholder="From Date"></td>
																						<td><select name="status">
                        																		<option value="">---Select---</option>
                                                                                                <option value="1">Active</option>
                                                                                                <option value="0">Archive</option>
                                                                                       	 	</select>
                                                                                        </td>
																					</tr>
																					<tr>
                																		<td colspan="4"><a href="javascript:void(0);" class="attachMore">Add
                																		another file</a></td>
                																	</tr>
																				</tbody>
    																			</table>
																		</div>
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
														<input class="btn btn-success" type="submit" name="submit"
															value="Save Document Template File(s)">
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

<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })
    
   
$(document).ready(function() {

	var upload_number = 2;
	$('.attachMore').click(function() {
		var moreUploadTag = '';

	/* 	moreUploadTag += '<tr><td><label>Document Name</label></td>';
		moreUploadTag += '<td><input class="form-control validate[required]" type="text" id="document_name' + upload_number + '" name="document_name' + upload_number + '" placeholder="Document Template Name" value=""> </td>';
		moreUploadTag += '<td colspan="2"><input class="validate[required]" type="file" name="list_a_doc_name[]" id="template_file' + upload_number + '"></td></tr>';
		moreUploadTag += '<tr><td><label>Applicable Date</label></td>';
		moreUploadTag += '<td><input type="date" id="start_date' + upload_number + '" name="start_date" class="validate[required]" placeholder="From Date"></td>';
		moreUploadTag += '<td><label>Status</label></td>';
		moreUploadTag += '<td><select name="status"><option value="">---Select---</option><option value="1">Active</option><option value="0">Archive</option></select></td></tr>';
		
		$('#docTable tr:last').prev().after(moreUploadTag);
		console.log(moreUploadTag);
		upload_number++; */

		moreUploadTag += '<tr><td><label>' + upload_number + '</label></td>';
		moreUploadTag += '<td><select name="doc_template_name" id="doc_template_name' + upload_number + '" class="form-control validate[required]"><option value="">---Select Doc Template---</option> <option value="temp2">Doc Template 1</option><option value="temp2">Doc Template 2</option></td>';
		moreUploadTag += '<td><input class="form-control validate[required]" type="text" id="document_name' + upload_number + '" name="document_name' + upload_number + '" placeholder="Document Template Name" value=""> </td>';
		moreUploadTag += '<td><input class="validate[required]" type="file" name="list_a_doc_name[]" id="template_file' + upload_number + '"></td>';
		moreUploadTag += '<td><input type="date" id="start_date' + upload_number + '" name="start_date" class="validate[required]" placeholder="From Date"></td>';
		moreUploadTag += '<td><select name="status"><option value="">---Select---</option><option value="1">Active</option><option value="0">Archive</option></select></td></tr>';
		
		$('#docs_tbl tr:last').prev().after(moreUploadTag);
		console.log(moreUploadTag);
		upload_number++;

		
	});

	function del_file(eleId) {
		var ele = document.getElementById("delete_file" + eleId);
		ele.parentNode.removeChild(ele);
	}
});

</script>
