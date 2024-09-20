<style>
    .nav > li > a {
        position: relative;
        display: block;
        padding: 10px 7px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .topnav ul {
        display: none;
        position: absolute;
    }

    .topnav li ul li {
        background: #45b1cd;
        color: #fff;
        display: inline-block;
        left: -40px;
        padding: 6px 20px;
        text-align: left;
        width: 243px;
        z-index: 9999;
    }

    .topnav li ul li a {
        color: #fff;
        font-size: 14px;
        line-height: 20px;
    }

    .topnav li ul li a:hover {
        text-decoration: none;
        border-bottom: none;
        color: #357CA5;
    }

    .topnav li:hover ul {
        display: block;
    }

    .topnav li a {
        font-size: 11px;
        padding: 0 6px;
    }

    @media only screen and (max-width: 1024px) {
        .topnav li a {
            font-size: 10px;
            padding: 0 3px
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 1023px) {
        .topnav li a {
            font-size: 8px;
            padding: 0 1px
        }

        .topnav ul {
            display: none;
            position: absolute;
            right: -40px;
        }
    }
</style>

<?php
if (!empty($get_details)) {
    $vendor_id = $get_details[0]['vendor_id'];
    $vendor_email = $get_details[0]['vendor_email'];
    $main_email_address = $get_details[0]['main_email_address'];
    $form_status = array();
    $sa_form_status = array();
    $form_status_str = 1;
    $sa_form_status_str = 1;
    $show_hide_menu = "";
    $get_files = $this->profile_model->getVendorFiles($vendor_id);
    $get_tot_docs = $this->profile_model->getAllFiles();

    if (!empty($get_files)) {
        foreach ($get_files as $fkey => $fval) {

            $form_status[] = $fval['form_status'];
            $sa_form_status[] = $fval['sa_form_status'];
        }
    }

    if (!empty($form_status)) {
        if (in_array("0", $form_status)) {
            $form_status_str = 0;
        } else {
            $form_status_str = 1;
        }
    } else {
        $form_status_str = 0;
    }

    if (!empty($sa_form_status)) {
        if (in_array("0", $sa_form_status)) {
            $sa_form_status_str = 0;
        } else {
            $sa_form_status_str = 1;
        }
    } else {
        $sa_form_status_str = 0;
    }

    if ($main_email_address != '') {
        $show_hide_menu = 'style="display:block;"';
    } else {
        $show_hide_menu = 'style="display:none;"';
    }
}

if ($get_details[0]['status'] != '0' || $get_details[0]['block_status'] != '0') {
    ?>
    <ul class="topnav" id="menu" <?php echo $show_hide_menu; ?>>
        <li>
            <a href="<?php echo base_url('vendor_dashboard'); ?>" <?php if (isset($page) && $page == "dashboard") { ?> class="active" <?php } ?>>DASHBOARD</a>
        </li>
        <li>
            <a href="<?php echo base_url('all_documents_lists'); ?>" <?php if (isset($page) && $page == "documentation") { ?> class="active" <?php } ?>>DOCUMENTATION</a>
        </li>
        <?php
        $condition = "";
        
        if (SHOW_DEMO) {

            if (isset($form_status_str) && $form_status_str == 1) {

                $condition = 1;
            } else {
                $condition = 0;
            }
        } else {

            if (isset($form_status_str) && $form_status_str == 1 && isset($sa_form_status_str) && $sa_form_status_str == 1) {

                $condition = 1;
            } else {
                $condition = 0;
            }
        }

        if ($condition) {
            ?>
            <!-- <li>
                <a href="<?php echo base_url('vendor_consultant_lists'); ?>" <?php if (isset($page) && $page == "employee_list") { ?> class="active" <?php } ?>>CONSULTANT</a>
            </li> -->
            <!-- <li>
                <a href="<?php echo base_url('open_requirements'); ?>" <?php if (isset($page) && $page == "open_requirements") { ?> class="active" <?php } ?>>OPEN
                    REQUIREMENTS</a>
            </li> -->
            <!-- <li>
                <a href="<?php echo base_url('vendor_consultant_timesheet'); ?>" <?php if (isset($page) && $page == "employee_timesheet") { ?> class="active" <?php } ?>>TIMESHEET</a>
            </li> -->
            <li>
                <a href="<?php echo base_url('vendor_consultant_invoice'); ?>" <?php if (isset($page) && $page == "payment") { ?> class="active" <?php } ?>>Invoice</a>
            </li>
            <?php
        }
        ?>
        <li><a href="#" <?php if (isset($page) && $page == "communication") { ?> class="active" <?php } ?>>Communication
            </a>
            <ul>
                <li><a href="<?php echo base_url('vendor_compose'); ?>"><i class="fa fa-plus-circle"></i>Compose</a>
                </li>
                <li><a href="<?php echo base_url('vendor_inbox'); ?>"><i class="fa fa-inbox"></i> Inbox</a></li>
                <li><a href="<?php echo base_url('vendor_sent_items'); ?>"><i class="fa fa-paper-plane-o" style="margin-right: 5px;"></i>Sent Items</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?php echo base_url('vendor_notifications'); ?>" <?php if (isset($page) && $page == "notification") { ?> class="active" <?php } ?>>Notifications</a>
        </li>
    </ul>
    <?php
}
?>
<!-- <span class="sr-only">Toggle navigation</span>-->
</a>

<?php if (!empty(CLIENT_LOGO) && file_exists(FCPATH . CLIENT_LOGO)) { ?>
<div>
    <img src="<?php echo base_url() . CLIENT_LOGO; ?>" style="display: inline-block;
        position: absolute;
        right: 115px;
        background-color: white; height:54px;">
</div>
<?php } ?>

<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
    <ul class="nav navbar-nav demo">

        <?php
        if (isset($form_status_str) && $form_status_str == 1 && isset($sa_form_status_str) && $sa_form_status_str == 1) {
            ?>

            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-success" id="notification-count"></span>
                </a>
                <ul class="dropdown-menu" id="notification-latest" style="width: 325px;">

                </ul>
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-success" id="others-notification-count"></span>
                </a>
                <ul class="dropdown-menu" id="others-notification-latest" style="width: 325px;">

                </ul>
            </li>

            <?php
        }
        ?>

        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <?php
                if ($get_details[0]['photo'] != '') {
                    ?>
                    <img src="<?php echo base_url(); ?>uploads/<?php echo $get_details[0]['photo']; ?>"
                         class="user-image"
                         alt="User Image">
                         <?php
                     } else {
                         $fullname = $get_details[0]['first_name'] . " " . $get_details[0]['last_name'];
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
                    <div id="profileImage"></div>
                    <?php
                }
                ?>

            </a>

            <ul class="dropdown-menu">


                <!-- The user image in the menu -->
                <li class="user-header">
                    <?php
                    if ($get_details[0]['photo'] != '') {
                        ?>
                        <img src="<?php echo base_url(); ?>uploads/<?php echo $get_details[0]['photo']; ?>"
                             class="img-circle"
                             alt="User Image">
                             <?php
                         } else {
                             ?>
                        <div id="profileImage1"></div>
                        <?php
                    }
                    ?>

                    <p>

                        <small>
                            <?php
                            if ($get_details[0]['company_id'] != '') {
                                echo $get_details[0]['company_id'];
                            }
                            ?>
                        </small>
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <?php
                            if ($this->session->userdata('vendor_logged_in')) {
                                $sess_array = $this->session->userdata('vendor_logged_in');
                                $fullname = $get_details[0]['name_prefix'] . " " . $get_details[0]['first_name'] . " " . $get_details[0]['last_name'];
                                echo "Hi, " . ucwords($fullname);
                            }
                            ?>
                        </div>
                    </div>
                    <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="menu-css">
                        <a href="<?php echo site_url('vendor_profile'); ?>">Edit Profile <i
                                class="fa fa-user icon octicon octicon-person" aria-hidden="true"></i>
                        </a>
                        <a href="<?php echo base_url('vendor-change-old-password'); ?>">Change Password <i
                                class="fa fa-key icon octicon octicon-graph" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url('vendor-logout'); ?>">Logout <i
                                class="fa fa-sign-out icon octicon octicon-pencil" aria-hidden="true"></i></a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- Control Sidebar Toggle Button
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>-->
    </ul>
</div>
<?php
if (!empty($get_tot_docs) && !empty($get_files)) {
    if (count($get_tot_docs) == count($get_files)) {
        ?>
        <input type="hidden" name="notification_sh" id="notification_sh" value="hide">
        <?php
    } else {
        ?>
        <input type="hidden" name="notification_sh" id="notification_sh" value="show">
        <?php
    }
} else {
    ?>
    <input type="hidden" name="notification_sh" id="notification_sh" value="show">
    <?php
}
?>