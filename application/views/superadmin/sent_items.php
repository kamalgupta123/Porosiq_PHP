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

    .nav-tabs .glyphicon:not(.no-margin) {
        margin-right: 10px;
    }

    .tab-pane .list-group-item:first-child {
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
    }

    .tab-pane .list-group-item:last-child {
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
    }

    .tab-pane .list-group .checkbox {
        display: inline-block;
        margin: 0px;
    }

    .tab-pane .list-group input[type="checkbox"] {
        margin-top: 2px;
    }

    .tab-pane .list-group .glyphicon {
        margin-right: 5px;
    }

    .tab-pane .list-group .glyphicon:hover {
        color: #FFBC00;
    }

    a.list-group-item.read {
        color: #222;
        background-color: #F3F3F3;
    }

    hr {
        margin-top: 5px;
        margin-bottom: 10px;
    }

    .nav-pills > li > a {
        padding: 5px 10px;
    }

    /*-------------Pagination------------------------*/

    .easyPaginateNav {
        display: inline-block;
    }

    .easyPaginateNav a {
        color: black;
        float: left;
        padding: 8px 12px;
        text-decoration: none;
        border: 1px solid #ddd;
    }

    .easyPaginateNav a.current {
        background-color: #09274b;
        color: white;
    }

    .easyPaginateNav a:hover:not(.current) {background-color: #ddd;}

    /*-------------Pagination------------------------*/
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
                Sent
                <small>Items</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Communication</a></li>
                <li class="active">Sent Items</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box">
                        <div class="box-body">
                            <div class="col-sm-12 col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-send"></span>Sent</a></li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="box">
                                    <div class="box-body">
                                        <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="1%">SL No.</th>
                                                    <th>To</th>
                                                    <th>Name</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $recipient_email = "";
                                                $recipient_name = "";
                                                if (!empty($get_sent_mails)) {

                                                    foreach ($get_sent_mails as $mval) {

                                                            $subject = strip_tags(stripslashes($mval['subject']));
                                                            $message = strip_tags(stripslashes($mval['message']));
                                                            $time = $mval['entry_date'];


                                                        /* ------------------Get Receipient Details-------------------- */

                                                        if ($mval['recipient_type'] == 'superadmin') {
                                                            $get_recipient_details = $this->communication_model->getSuperAdminDetails($mval['recipient_id']);
                                                            if (!empty($get_recipient_details)) {
                                                                $recipient_id = $get_recipient_details[0]['sa_id'];
                                                                $recipient_name = ucwords($get_recipient_details[0]['sa_name']);
                                                                $recipient_email = $get_recipient_details[0]['sa_email'];
                                                                $file = $get_recipient_details[0]['file'];
                                                            }
                                                        }
                                                        if ($mval['recipient_type'] == 'admin') {
                                                            $get_recipient_details = $this->communication_model->getAdminDetails($mval['recipient_id']);
                                                            if (!empty($get_recipient_details)) {
                                                                $recipient_id = $get_recipient_details[0]['admin_id'];
                                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . " " . $get_recipient_details[0]['last_name']);
                                                                $recipient_email = $get_recipient_details[0]['admin_email'];
                                                                $file = $get_recipient_details[0]['file'];
                                                            }
                                                        }
                                                        if ($mval['recipient_type'] == 'vendor') {
                                                            
                                                            $get_recipient_details = $this->communication_model->getVendorDetails($mval['recipient_id']);
                                                            if (!empty($get_recipient_details)) {
                                                                $recipient_id = $get_recipient_details[0]['vendor_id'];
                                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . " " . $get_recipient_details[0]['last_name']);
                                                                $recipient_email = $get_recipient_details[0]['vendor_email'];
                                                                $file = $get_recipient_details[0]['photo'];
                                                            }
                                                        }
                                                        if ($mval['recipient_type'] == 'employee') {

                                                            $get_recipient_details = $this->communication_model->getEmployeeDetails($mval['recipient_id']);
                                                            if (!empty($get_recipient_details)) {
                                                                $recipient_id = $get_recipient_details[0]['employee_id'];
                                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . " " . $get_recipient_details[0]['last_name']);
                                                                $recipient_email = $get_recipient_details[0]['employee_email'];
                                                                $file = $get_recipient_details[0]['file'];
                                                            }
                                                        }
                                                        /* ------------------Get Receipient Details-------------------- */
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td width="25%"><label><?php echo $recipient_email; ?></label></td>
                                                            <td width="25%"><label><?php echo $recipient_name; ?></label></td>
                                                            <td width="25%">
                                                                <a href="<?php echo site_url('sent_mail_details') . "/" . base64_encode($mval['id']); ?>">
                                                                    <?php echo ucwords($subject); ?>
                                                                </a>
                                                            </td>
                                                            <td width="25%">
                                                                <?php
                                                                if (strlen($message) > 300) {
                                                                    echo substr($message, 0, 150) . "..";
                                                                } else {
                                                                    echo $message;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><span class="badge"><?php echo date("m-d-Y h:i A", strtotime($time)); ?></span></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>

                                            </tbody>

                                        </table>
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

</script>
<script>
    $(function () {
        $('#admin_tbl').DataTable();
    });
</script>

