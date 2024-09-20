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

    .nav > li > a:hover, .nav > li > a:active, .nav > li > a:focus {
        color: #444;
        background: none;
    }

    .nav > li > a:focus, .nav > li > a:hover {
        text-decoration: none;
    }

    .nav .open > a, .nav .open > a:focus, .nav .open > a:hover {
        background-color: #fff;
        border-color: #337ab7;
        margin: 3px 0;
    }

    .nav-css {
        float: right;
        margin: -12px 0 0 0;
    }
    .email_profile{
        display:flex;
        align-items:center;
    }
    .email_img{
        width: 47px; 
        margin-right:10px;
        text-align: center;
        display: inline-block;
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

            <?php
            $this->load->view('superadmin/includes/user_panel');
            $this->load->view('superadmin/includes/sidebar');
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php /*
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
         */ ?>

        <!-- Main content -->
        <section class="content" id="admin_div">

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                <div class="">
                                    <a href="<?php echo site_url('inbox'); ?>"><span
                                            class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp; Back to
                                        Inbox</a>
                                </div>
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-12 col-md-12">
                                <?php
                                if (!empty($get_inbox_mail_details)) {

                                    $recipient_name = "";
                                    $recipient_email = "";
                                    $recipient_email_shw = "";

                                    $reply_id = $get_inbox_mail_details[0]['reply_id'];
                                    $mail_id = $get_inbox_mail_details[0]['id'];
                                    $recipient_id = $get_inbox_mail_details[0]['recipient_id'];
                                    $recipient_type = $get_inbox_mail_details[0]['recipient_type'];


                                    if ($reply_id == 0) {

                                        $subject = stripslashes($get_inbox_mail_details[0]['subject']);
                                        $message = stripslashes($get_inbox_mail_details[0]['message']);
                                        $datetime = $get_inbox_mail_details[0]['entry_date'];
                                        $id = $mail_id;

                                        /* ------------------Get Recipients Details-------------------- */


                                        if ($recipient_type == 'superadmin') {

                                            $get_recipient_details = $this->communication_model->getSuperAdminDetails($recipient_id);
                                            if (!empty($get_recipient_details)) {
                                                $recipient_name = ucwords($get_recipient_details[0]['sa_name']);
                                                $recipient_email = $get_recipient_details[0]['sa_email'] . " (" . ucwords($recipient_type) . ") <br/>";
                                                $recipient_email_shw = substr($get_recipient_details[0]['sa_email'], 0, strrpos($get_recipient_details[0]['sa_email'], '@'));
                                            }
                                        }

                                        if ($recipient_type == 'admin') {

                                            $get_recipient_details = $this->communication_model->getAdminDetails($recipient_id);
                                            if (!empty($get_recipient_details)) {
                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . " " . $get_recipient_details[0]['last_name']);
                                                $recipient_email = $get_recipient_details[0]['admin_email'] . " (" . ucwords($recipient_type) . ") <br/>";
                                                $recipient_email_shw = substr($get_recipient_details[0]['admin_email'], 0, strrpos($get_recipient_details[0]['admin_email'], '@'));
                                            }
                                        }
                                        if ($recipient_type == 'vendor') {

                                            $get_recipient_details = $this->communication_model->getVendorDetails($recipient_id);
                                            if (!empty($get_recipient_details)) {
                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . " " . $get_recipient_details[0]['last_name']);
                                                $recipient_email = $get_recipient_details[0]['vendor_email'] . " (" . ucwords($recipient_type) . ") <br/>";
                                                $recipient_email_shw = substr($get_recipient_details[0]['vendor_email'], 0, strrpos($get_recipient_details[0]['vendor_email'], '@'));
                                            }
                                        }
                                        if ($recipient_type == 'employee') {
                                            $get_recipient_details = $this->communication_model->getEmployeeDetails($recipient_id);
                                            if (!empty($get_recipient_details)) {
                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . " " . $get_recipient_details[0]['last_name']);
                                                $recipient_email = $get_recipient_details[0]['employee_email'] . " (" . ucwords($recipient_type) . ") <br/>";
                                                $recipient_email_shw = substr($get_recipient_details[0]['employee_email'], 0, strrpos($get_recipient_details[0]['employee_email'], '@'));
                                            }
                                        }


                                        /* ------------------Get Recipients Details-------------------- */

                                        /* ------------------Get Sender Details-------------------- */

                                        if ($get_inbox_mail_details[0]['sender_type'] == 'superadmin') {
                                            $get_sender_details = $this->communication_model->getSuperAdminDetails($get_inbox_mail_details[0]['sender_id']);
                                            if (!empty($get_sender_details)) {
                                                $sender_id = $get_sender_details[0]['sa_id'];
                                                $sender_name = ucwords($get_sender_details[0]['sa_name']);
                                                $sender_email = $get_sender_details[0]['sa_email'];
                                                $file = $get_sender_details[0]['file'];
                                                $path = base_url() . "uploads/";
                                            }
                                        }
                                        if ($get_inbox_mail_details[0]['sender_type'] == 'admin') {
                                            $get_sender_details = $this->communication_model->getAdminDetails($get_inbox_mail_details[0]['sender_id']);
                                            if (!empty($get_sender_details)) {
                                                $sender_id = $get_sender_details[0]['admin_id'];
                                                $sender_name = ucwords($get_sender_details[0]['first_name'] . "" . $get_sender_details[0]['last_name']);
                                                $sender_email = $get_sender_details[0]['admin_email'];
                                                $file = $get_sender_details[0]['file'];
                                                $path = base_url() . "uploads/admin/profile_pic/" . strtolower($get_sender_details[0]['first_name']) . "_" . strtolower($get_sender_details[0]['last_name']) . "/";
                                            }
                                        }
                                        if ($get_inbox_mail_details[0]['sender_type'] == 'vendor') {
                                            $get_sender_details = $this->communication_model->getVendorDetails($get_inbox_mail_details[0]['sender_id']);
                                            if (!empty($get_sender_details)) {
                                                $sender_id = $get_sender_details[0]['vendor_id'];
                                                $sender_name = ucwords($get_sender_details[0]['first_name'] . "" . $get_sender_details[0]['last_name']);
                                                $sender_email = $get_sender_details[0]['vendor_email'];
                                                $file = $get_sender_details[0]['photo'];
                                                $path = base_url() . "uploads/";
                                            }
                                        }
                                        if ($get_inbox_mail_details[0]['sender_type'] == 'employee') {

                                            $get_sender_details = $this->communication_model->getEmployeeDetails($get_inbox_mail_details[0]['sender_id']);
                                            if (!empty($get_sender_details)) {
                                                $sender_id = $get_sender_details[0]['employee_id'];
                                                $sender_name = ucwords($get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name']);
                                                $sender_email = $get_sender_details[0]['employee_email'];
                                                $file = $get_sender_details[0]['file'];
                                                $path = base_url() . "uploads/";
                                            }
                                        }
                                        /* ------------------Get Sender Details-------------------- */


                                        $check_reply_mails = $this->communication_model->getReplyMailDetails($mail_id);
//                                        echo "<pre>";
//                                        print_r($check_reply_mails);
                                    } else {

                                        $get_mail_details = $this->communication_model->getMailDetails($reply_id);

                                        $subject = strip_tags(stripslashes($get_mail_details[0]['subject']));
                                        $message = strip_tags(stripslashes($get_mail_details[0]['message']));
                                        $datetime = $get_mail_details[0]['entry_date'];
                                        $id = $reply_id;
                                        $recipient_id = $get_mail_details[0]['recipient_id'];
                                        $recipient_type = $get_mail_details[0]['recipient_type'];

                                        /* ------------------Get Recipients Details-------------------- */


                                        if ($recipient_type == 'superadmin') {

                                            $get_recipient_details = $this->communication_model->getSuperAdminDetails($recipient_id);
                                            if (!empty($get_recipient_details)) {
                                                $recipient_name = ucwords($get_recipient_details[0]['sa_name']);
                                                $recipient_email = $get_recipient_details[0]['sa_email'] . " (" . ucwords($recipient_type) . ") <br/>";
                                                $recipient_email_shw = substr($get_recipient_details[0]['sa_email'], 0, strrpos($get_recipient_details[0]['sa_email'], '@'));
                                            }
                                        }

                                        if ($recipient_type == 'admin') {

                                            $get_recipient_details = $this->communication_model->getAdminDetails($recipient_id);
                                            if (!empty($get_recipient_details)) {
                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . "" . $get_recipient_details[0]['last_name']);
                                                $recipient_email = $get_recipient_details[0]['admin_email'] . " (" . ucwords($recipient_type) . ") <br/>";
                                                $recipient_email_shw = substr($get_recipient_details[0]['admin_email'], 0, strrpos($get_recipient_details[0]['admin_email'], '@'));
                                            }
                                        }
                                        if ($recipient_type == 'vendor') {

                                            $get_recipient_details = $this->communication_model->getVendorDetails($recipient_id);
                                            if (!empty($get_recipient_details)) {
                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . "" . $get_recipient_details[0]['last_name']);
                                                $recipient_email = $get_recipient_details[0]['vendor_email'] . " (" . ucwords($recipient_type) . ") <br/>";
                                                $recipient_email_shw = substr($get_recipient_details[0]['vendor_email'], 0, strrpos($get_recipient_details[0]['vendor_email'], '@'));
                                            }
                                        }
                                        if ($recipient_type == 'employee') {
                                            $get_recipient_details = $this->communication_model->getEmployeeDetails($recipient_id);
                                            if (!empty($get_recipient_details)) {
                                                $recipient_name = ucwords($get_recipient_details[0]['first_name'] . " " . $get_recipient_details[0]['last_name']);
                                                $recipient_email = $get_recipient_details[0]['employee_email'] . " (" . ucwords($recipient_type) . ") <br/>";
                                                $recipient_email_shw = substr($get_recipient_details[0]['employee_email'], 0, strrpos($get_recipient_details[0]['employee_email'], '@'));
                                            }
                                        }


//                                        echo "<pre>";
//                                        print_r($recipient_names_arr);
                                        /* ------------------Get Recipients Details-------------------- */

                                        /* ------------------Get Sender Details-------------------- */

                                        if ($get_mail_details[0]['sender_type'] == 'superadmin') {
                                            $get_sender_details = $this->communication_model->getSuperAdminDetails($get_mail_details[0]['sender_id']);
                                            if (!empty($get_sender_details)) {
                                                $sender_id = $get_sender_details[0]['sa_id'];
                                                $sender_name = ucwords($get_sender_details[0]['sa_name']);
                                                $sender_email = $get_sender_details[0]['sa_email'];
                                                $file = $get_sender_details[0]['file'];
                                                $path = base_url() . "uploads/";
                                            }
                                        }
                                        if ($get_mail_details[0]['sender_type'] == 'admin') {
                                            $get_sender_details = $this->communication_model->getAdminDetails($get_mail_details[0]['sender_id']);
                                            if (!empty($get_sender_details)) {
                                                $sender_id = $get_sender_details[0]['admin_id'];
                                                $sender_name = ucwords($get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name']);
                                                $sender_email = $get_sender_details[0]['admin_email'];
                                                $file = $get_sender_details[0]['file'];
                                                $path = base_url() . "uploads/admin/profile_pic/" . strtolower($get_sender_details[0]['first_name']) . "_" . strtolower($get_sender_details[0]['last_name']) . "/";
                                            }
                                        }
                                        if ($get_mail_details[0]['sender_type'] == 'vendor') {
                                            $get_sender_details = $this->communication_model->getVendorDetails($get_mail_details[0]['sender_id']);
                                            if (!empty($get_sender_details)) {
                                                $sender_id = $get_sender_details[0]['vendor_id'];
                                                $sender_name = ucwords($get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name']);
                                                $sender_email = $get_sender_details[0]['vendor_email'];
                                                $file = $get_sender_details[0]['photo'];
                                                $path = base_url() . "uploads/";
                                            }
                                        }
                                        if ($get_mail_details[0]['sender_type'] == 'employee') {
                                            $get_sender_details = $this->communication_model->getEmployeeDetails($get_mail_details[0]['sender_id']);
                                            if (!empty($get_sender_details)) {
                                                $sender_id = $get_sender_details[0]['employee_id'];
                                                $sender_name = ucwords($get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name']);
                                                $sender_email = $get_sender_details[0]['employee_email'];
                                                $file = $get_sender_details[0]['file'];
                                                $path = base_url() . "uploads/";
                                            }
                                        }
                                        /* ------------------Get Sender Details-------------------- */

                                        $check_reply_mails = $this->communication_model->getReplyMailDetails($reply_id);
//                                        echo "<pre>";
//                                        print_r($check_reply_mails);
                                        
                                    }
                                }
                                ?>
                                <table id="inbox_items_tbl" class="table" style="font-size: 11px;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="" style="width: 582px;"></div>
                                                <div class="">
                                                    <span class=""
                                                          style="font-weight: bold; font-size: 20px;"><?php echo ucwords($subject); ?></span>
                                                </div>
                                                <div class="">
                                                    <hr>
                                                </div>
                                                <div class="email_profile">
                                                    <span class="img email_img" style="min-width: 30px; display: inline-block;">
                                                        <?php
                                                        if ($file != '') {
                                                            ?>
                                                            <img
                                                                src="<?php echo $path.$file; ?>"
                                                                class="" alt="User Image" width="24px" height="24px">
                                                                <?php
                                                            } else {
                                                                $fullname = $sender_name;
                                                                $name_arr = explode(" ", $fullname);
                                                                if (count($name_arr) == 1) {
                                                                    $firstname = $name_arr[0];
                                                                    $lastname = "";
                                                                } elseif (count($name_arr) == 2) {
                                                                    $firstname = $name_arr[0];
                                                                    $lastname = $name_arr[1];
                                                                } elseif (count($name_arr) > 2) {
                                                                    $c = count($name_arr);
                                                                    $firstname = $name_arr[0];
                                                                    $lastname = $name_arr[$c - 1];
                                                                }
                                                                ?>
                                                            <span id="firstName" style="display: none;"><?php echo ucwords($firstname); ?></span>
                                                            <span id="lastName" style="display: none;"><?php echo ucwords($lastname); ?></span>
                                                            <div id="profileImage3"></div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </span>
                                                    <span class="name"
                                                          style=" display: inline-block; font-size: 16px;">
                                                        <label><?php echo $sender_name; ?></label> <span
                                                            style="font-size: 14px;">< <?php echo $sender_email; ?>
                                                            ></span>
                                                    </span>

                                                </div>
                                                <div class="">
                                                    <span class="img"
                                                          style="min-width: 30px; display: inline-block;">&nbsp;</span>
                                                    <span class="name"
                                                          style="margin-left:26px; display: inline-block; font-size: 14px;">
                                                        <span style="font-size: 13px;">to</span>&nbsp;
                                                        <span style="font-size: 13px;">
                                                            <?php
                                                            if (strlen($recipient_email_shw) > 50) {
                                                                echo substr($recipient_email_shw, 0, 35) . "..";
                                                            } else {
                                                                echo $recipient_email_shw;
                                                            }
                                                            ?>
                                                        </span>&nbsp;
                                                        <span style="font-size: 13px;">
                                                            <ul class="nav navbar-nav nav-css">
                                                                <li class="dropdown messages-menu">
                                                                    <a style="padding-top:12px" href="#" class="dropdown-toggle"
                                                                       data-toggle="dropdown">
                                                                        <i class="fa fa-angle-down"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu" style="width: auto;">
                                                                        <li>
                                                                            <ul class="menu"
                                                                                style="max-height: 500px;width: 100%;overflow-x: visible;">

                                                                                <li>
                                                                                    <a href="#">
                                                                                        <div class="pull-left">
                                                                                            <span>from:</span>
                                                                                        </div>
                                                                                        <p>
                                                                                            <label><?php echo $sender_name; ?></label>
                                                                                            <span
                                                                                                style="font-size: 14px;">< <?php echo $sender_email; ?>
                                                                                                ></span>
                                                                                        </p>
                                                                                    </a>
                                                                                </li>

                                                                                <li>
                                                                                    <a href="#">
                                                                                        <div class="pull-left">
                                                                                            to:
                                                                                        </div>
                                                                                        <p>
                                                                                            <?php
                                                                                            echo $recipient_email;
                                                                                            ?>
                                                                                        </p>
                                                                                    </a>
                                                                                </li>

                                                                                <li>
                                                                                    <a href="#">
                                                                                        <div class="pull-left">
                                                                                            date:
                                                                                        </div>
                                                                                        <p>
                                                                                            <?php
                                                                                            echo date("l F j, Y h:i A", strtotime($datetime));
                                                                                            ?>
                                                                                        </p>
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#">
                                                                                        <div class="pull-left">
                                                                                            sub:
                                                                                        </div>
                                                                                        <p>
                                                                                            <?php echo $subject; ?>
                                                                                        </p>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </span>
                                                    </span>

                                                </div>
                                                <div class="" style="font-size: 18px;">
                                                    <p>
                                                        <?php
                                                        echo $message;
                                                        ?>
                                                    </p>
                                                </div>
                                                <div class="">
                                                    <hr/>
                                                </div>
                                                <div class="">
                                                    <?php
                                                    // echo $mail_id."sdf";
                                                    if ($recipient_type == "superadmin") {
                                                        ?>
                                                        <a href="<?php echo site_url() . "inbox_mail_reply" . "/" . base64_encode($id) . "/" . base64_encode($sender_id); ?>"><span
                                                                class="glyphicon glyphicon-arrow-left"></span>&nbsp;
                                                            Reply</a>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <?php
                    if (!empty($check_reply_mails)) {
                        foreach ($check_reply_mails as $reply_val) {

//                            if ($reply_val['reply_id'] == 0) {
                                    $id = $reply_val['id'];
//                            } else {
//                                $id = $reply_val['reply_id'];
//                            }
                                $reply_subject = stripslashes($reply_val['subject']);
                                $reply_message = stripslashes($reply_val['message']);
                                $reply_datetime = $reply_val['entry_date'];

                                $reply_recipient_type = $reply_val['recipient_type'];

                                /* -----------------------Get From Detail------------------------------------ */

                                if ($reply_val['sender_type'] == 'admin') {
                                    $get_sender_details = $this->communication_model->getAdminDetails($reply_val['sender_id']);
                                    $from_id = $get_sender_details[0]['admin_id'];
                                $from_name = $get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name'];
                                    $from_email = $get_sender_details[0]['admin_email'];
                                    $from_img = $get_sender_details[0]['file'];
                                    $path = base_url() . "uploads/admin/profile_pic/" . strtolower($get_sender_details[0]['first_name']) . "_" . strtolower($get_sender_details[0]['last_name']) . "/";
                                }
                                if ($reply_val['sender_type'] == 'superadmin') {
                                    $get_sender_details = $this->communication_model->getSuperAdminDetails($reply_val['sender_id']);
                                    $from_id = $get_sender_details[0]['sa_id'];
                                    $from_name = $get_sender_details[0]['sa_name'];
                                    $from_email = $get_sender_details[0]['sa_email'];
                                    $from_img = $get_sender_details[0]['file'];
                                    $path = base_url() . "uploads/";
                                }
                                if ($reply_val['sender_type'] == 'vendor') {
                                    $get_sender_details = $this->communication_model->getVendorDetails($reply_val['sender_id']);
                                    $from_id = $get_sender_details[0]['vendor_id'];
                                $from_name = $get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name'];
                                    $from_email = $get_sender_details[0]['vendor_email'];
                                    $from_img = $get_sender_details[0]['photo'];
                                    $path = base_url() . "uploads/";
                                }
                                if ($reply_val['sender_type'] == 'employee') {
                                    $get_sender_details = $this->communication_model->getEmployeeDetails($reply_val['sender_id']);
                                    $from_id = $get_sender_details[0]['employee_id'];
                                    $from_name = $get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name'];
                                    $from_email = $get_sender_details[0]['employee_email'];
                                    $from_img = $get_sender_details[0]['file'];
                                    $path = base_url() . "uploads/";
                                }
                                /* -----------------------Get From Detail------------------------------------ */

                                /* -----------------------Get To Detail------------------------------------ */

                                if ($reply_val['recipient_type'] == 'admin') {
                                    //echo "ds";
                                    $get_to_details = $this->communication_model->getAdminDetails($reply_val['recipient_id']);
                                    $to_name = $get_to_details[0]['first_name'] . " " . $get_to_details[0]['last_name'];
                                    $to_full_mail = $get_to_details[0]['admin_email'];
                                    $to_email = substr($get_to_details[0]['admin_email'], 0, strrpos($get_to_details[0]['admin_email'], '@'));
                                }
                                if ($reply_val['recipient_type'] == 'superadmin') {

                                    $get_to_details = $this->communication_model->getSuperAdminDetails($reply_val['recipient_id']);
                                    $to_name = $get_to_details[0]['sa_name'];
                                    $to_full_mail = $get_to_details[0]['sa_email'];
                                    $to_email = substr($get_to_details[0]['sa_email'], 0, strrpos($get_to_details[0]['sa_email'], '@'));
                                }
                                if ($reply_val['recipient_type'] == 'vendor') {
                                    $get_to_details = $this->communication_model->getVendorDetails($reply_val['recipient_id']);
                                    $to_name = $get_to_details[0]['first_name'] . " " . $get_to_details[0]['last_name'];
                                    $to_full_mail = $get_to_details[0]['vendor_email'];
                                    $to_email = substr($get_to_details[0]['vendor_email'], 0, strrpos($get_to_details[0]['vendor_email'], '@'));
                                }
                                if ($reply_val['recipient_type'] == 'employee') {
                                    $get_to_details = $this->communication_model->getEmployeeDetails($reply_val['recipient_id']);
                                    $to_name = $get_to_details[0]['first_name'] . " " . $get_to_details[0]['last_name'];
                                    $to_full_mail = $get_to_details[0]['employee_email'];
                                    $to_email = substr($get_to_details[0]['employee_email'], 0, strrpos($get_to_details[0]['employee_email'], '@'));
                                }

                                /* -----------------------Get To Detail------------------------------------ */
                                ?>

                                <div class="box">
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="col-sm-12 col-md-12">

                                            <table id="inbox_items_tbl" class="table" style="font-size: 11px;">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="">
                                                                <span class="img"
                                                                      style="min-width: 30px; display: inline-block;">
                                                                          <?php
                                                                          if ($from_img != '') {
                                                                              ?>
                                                                    <img
                                                                        src="<?php echo $path.$from_img; ?>"
                                                                        class="" alt="User Image" width="24px"
                                                                        height="24px">
                                                                            <?php
                                                                        } else {
                                                                            $fullname = $from_name;
                                                                            $name_arr = explode(" ", $fullname);
                                                                            if (count($name_arr) == 1) {
                                                                                $firstname = $name_arr[0];
                                                                                $lastname = "";
                                                                            } elseif (count($name_arr) == 2) {
                                                                                $firstname = $name_arr[0];
                                                                                $lastname = $name_arr[1];
                                                                            } elseif (count($name_arr) > 2) {
                                                                                $c = count($name_arr);
                                                                                $firstname = $name_arr[0];
                                                                                $lastname = $name_arr[$c - 1];
                                                                            }
                                                                            ?>
                                                                        <span id="firstName" style="display: none;"><?php echo ucwords($firstname); ?></span>
                                                                                        <span id="lastName" style="display: none;"><?php echo ucwords($lastname); ?></span>
                                                                                        <div id="profileImage4"></div>
                                                                             <?php
                                                                         }
                                                                         ?>
                                                                </span>
                                                                <span class="name"
                                                                      style="min-width: 120px; display: inline-block; font-size: 16px;">
                                                                    <label><?php echo ucwords($from_name);
                                                                         ?></label> <span
                                                                        style="font-size: 14px;">< <?php echo $from_email;
                                                                         ?> ></span>
                                                                </span>

                                                            </div>
                                                            <div class="">
                                                                <span class="img"
                                                                      style="min-width: 30px; display: inline-block;">&nbsp;</span>
                                                                <span class="name"
                                                                      style="min-width: 120px; display: inline-block; font-size: 14px;">
                                                                    <span style="font-size: 13px;">to</span>&nbsp;
                                                                    <span style="font-size: 13px;">
                                                                        <?php
                                                                        if (strlen($to_email) > 50) {
                                                                            echo substr($to_email, 0, 35) . "..";
                                                                        } else {
                                                                            echo $to_email;
                                                                        }
                                                                        ?>
                                                                    </span>&nbsp;
                                                                    <span style="font-size: 13px;">
                                                                        <ul class="nav navbar-nav nav-css">
                                                                            <li class="dropdown messages-menu">
                                                                                <a href="#" class="dropdown-toggle"
                                                                                   data-toggle="dropdown">
                                                                                    <i class="fa fa-angle-down"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu"
                                                                                style="width: auto">
                                                                                    <li>
                                                                                        <ul class="menu"
                                                                                            style="max-height: 500px;width: 100%;overflow-x: visible;">

                                                                                            <li>
                                                                                                <a href="#">
                                                                                                <div class="pull-left">
                                                                                                        <span>from:</span>
                                                                                                    </div>
                                                                                                    <p>
                                                                                                        <label><?php echo ucwords($from_name); ?></label>
                                                                                                        <span
                                                                                                            style="font-size: 14px;">< <?php echo $from_email; ?>
                                                                                                            ></span>
                                                                                                    </p>
                                                                                                </a>
                                                                                            </li>

                                                                                            <li>
                                                                                                <a href="#">
                                                                                                <div class="pull-left">
                                                                                                        to:
                                                                                                    </div>
                                                                                                    <p>
                                                                                                        <?php
                                                                                                        echo $to_full_mail;
                                                                                                        ?>
                                                                                                    </p>

                                                                                                    <p>
                                                                                                        <?php
                                                                                                        echo "< " . $to_full_mail . " >";
                                                                                                        ?>
                                                                                                    </p>
                                                                                                </a>
                                                                                            </li>

                                                                                            <li>
                                                                                                <a href="#">
                                                                                                <div class="pull-left">
                                                                                                        date:
                                                                                                    </div>
                                                                                                    <p>
                                                                                                        <?php
                                                                                                        echo date("l F j, Y h:i A", strtotime($reply_datetime));
                                                                                                        ?>
                                                                                                    </p>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a href="#">
                                                                                                <div class="pull-left">
                                                                                                        subject:
                                                                                                    </div>
                                                                                                    <p style="padding: 0px 0px 0px 10px;">
                                                                                                        <?php echo "Re: " . strip_tags($reply_subject); ?>
                                                                                                    </p>
                                                                                                </a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </span>
                                                                </span>

                                                            </div>
                                                            <div class="" style="font-size: 18px;">
                                                                <p>
                                                                    <?php
                                                                    echo $reply_message;
                                                                    ?>
                                                                </p>
                                                            </div>
                                                            <div class="">
                                                                <hr/>
                                                            </div>
                                                            <div class="">
                                                                <?php
                                                            //echo $id."sdf";
                                                            if ($reply_recipient_type == "superadmin") {
                                                                    ?>
                                                                <a href="<?php echo site_url() . "inbox_mail_reply" . "/" . base64_encode($id) . "/" . base64_encode($from_id); ?>"><span
                                                                            class="glyphicon glyphicon-arrow-left"></span>&nbsp;
                                                                        Reply</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->

                                <?php
                            }
                        }
                    ?>

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
        $('#inbox_items_tbl').DataTable();
    });
</script>