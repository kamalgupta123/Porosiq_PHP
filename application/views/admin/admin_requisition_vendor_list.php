<?php
$this->load->view('admin/includes/header'); ?>
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

  label {
    font-weight: 600;
  }
  .form-control-plaintext {
    display: block;
    width: 100%;
    margin-bottom: 0;
    color: #212529;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
  }
</style>
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>admin_dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"
        ><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""
      /></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"
        ><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""
      /></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <?php
            $this->load->view('admin/includes/upper_menu'); ?>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <?php
            $this->load->view('admin/includes/user_panel');
      $this->load->view('admin/includes/sidebar'); ?>
    </section>
    <!-- /.sidebar -->
  </aside>

<!-- Requisition details modal -->

<div class="modal fade" id="requisition_modal" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="line-height: inherit;">Details</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            style="margin-top: -21px;"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group row">
              <label for="staticId" class="col-sm-3 col-form-label padding-top"
                >Requisition ID</label
              >
              <div class="col-sm-4">
                <input
                  type="text"
                  readonly
                  class="form-control-plaintext"
                  id="staticId"
                  value="123456"
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="staticJob" class="col-sm-3 col-form-label padding-top"
                >Job Title</label
              >
              <div class="col-sm-4" >
                <input
                  type="text"
                  readonly
                  class="form-control-plaintext"
                  id="staticJob"
                  value="Web Developer"
                />
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3" style="margin-right: 2rem;" for="ingredients">Select Vendor</label>
              <select class="col-sm-4"  name="ingredients[]" id="ingredients" multiple="multiple">
                <option value="cheese">3k Technologies</option>
                <option value="tomatoes">Excelgens</option>
                <option value="tomatoes">FIS</option>
            </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>













  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Vendor
        <small> listing</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href=""><i class="fa fa-dashboard"></i>Home</a>
        </li>
        <li class="active">Vendor listing</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="box">
            <div class="panel panel-default">
              <div class="panel-body" style="text-align: right;">
                <a
                data-toggle="modal"
                data-target="#requisition_modal"
                  
                  style="color: #09274b;"
                  ><i class="fa fa-plus" style="color: green;"></i> Select
                  Vendor</a
                >
              </div>
            </div>
          </div>
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
                    <th class="text-center">SL No.</th>
                    <th class="text-center">Photo</th>
                    <th>Point of Contact</th>
                    <th>Company Name</th>
                    <th>Vendor Email ID</th>
                    <th class="text-center">Phone No.</th>
                    <th class="text-center">Requisition Assigned Date</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="text-center">
                      <div id="img_div" style="height: auto; width: 60px;">
                        <img
                          src="https://demo.porosiq.com/uploads/160746775980.png"
                          alt="User Image"
                          class="img-circle"
                          style="
                            width: 100%;
                            max-height: 100%;
                            object-fit: contain;
                          "
                        />
                      </div>
                    </td>
                    <td>Dr. Vendor Tester</td>
                    <td>3k Technologies</td>
                    <td>test.vendor@porosiq.com</td>
                    <td class="text-center">7891234560</td>
                    <td class="text-center">12/29/2020</td>
                    <td class="text-center">
                      <a href="#">
                        <i class="fa fa-lg fa-times" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    $this->load->view('admin/includes/common_footer'); ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('admin/includes/footer'); ?>
<link
  rel="stylesheet"
  href="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/css/validationEngine.jquery.css"
  type="text/css"
/>
<script
  src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js"
  type="text/javascript"
  charset="utf-8"
></script>
<script
  src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/jquery.validationEngine.js"
  type="text/javascript"
  charset="utf-8"
></script>
<script>
  $(document).ready(function () {
    // binds form submission and fields to the validation engine
    $("#add_documentation_form").validationEngine({ promptPosition: "inline" });
  });
</script>
<script type="text/javascript">
  $(".image-file").on("change", function () {
    var file_extension = ["pdf"];
    var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
    if (parseFloat(file_size) > 2.0) {
      $(".image-file").val("");
      alert("File Size must be less than 2MB");
      return false;
    } else if (
      $.inArray($(this).val().split(".").pop().toLowerCase(), file_extension) ==
      -1
    ) {
      $(".image-file").val("");
      alert("Only '.pdf' format are allowed.");
      return false;
    }
    //       alert(file_size);
  });
</script>
<script>
  $(function () {
    $("#table_id").DataTable();
  });
</script>
