<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>

<?php if (!empty(CLIENT_LOGO) && file_exists(FCPATH . CLIENT_LOGO)) { ?>
<div>
    <img src="<?php echo base_url() . CLIENT_LOGO; ?>" style="display: inline-block;
        position: absolute;
        right: 181px;
        background-color: white; height:50px;">
</div>
<?php } ?>

<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
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

        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php
                if ($get_details[0]['file'] != '') {
                    $file_path = "uploads/admin/profile_pic/" . strtolower($get_details[0]['first_name']) . "_" . strtolower($get_details[0]['last_name']) . "/";
                    ?>
                    <img src="<?php echo site_url() . $file_path . $get_details[0]['file']; ?>"
                         class="user-image" alt="User Image">
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
                <!-- User image -->
                <li class="user-header">
                    <?php
                    if ($get_details[0]['file'] != '') {
                        $file_path = "uploads/admin/profile_pic/" . strtolower($get_details[0]['first_name']) . "_" . strtolower($get_details[0]['last_name']) . "/";
                        ?>
                        <img src="<?php echo site_url() . $file_path . $get_details[0]['file']; ?>"
                             class="img-circle" alt="User Image">
                             <?php
                         } else {
                             ?>
                        <div id="profileImage1"></div>
                        <?php
                    }
                    ?>
                </li>
                <li class="user-body">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <?php
                            if ($this->session->userdata('admin_logged_in')) {
                                $sess_array = $this->session->userdata('admin_logged_in');
                                $fullname = $get_details[0]['first_name'] . " " . $get_details[0]['last_name'];
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
                        <?php
                        if ($get_details[0]['change_password'] == '1') {
                            ?>
                            <a href="<?php echo base_url('admin_profile'); ?>">Edit Profile <i class="fa fa-user icon octicon octicon-person" aria-hidden="true"></i></a>
                            <?php
                        }
                        ?>
                        <a href="<?php echo base_url('admin-change-password'); ?>">Change Password <i class="fa fa-key icon octicon octicon-graph" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url('admin-logout'); ?>">Logout <i class="fa fa-sign-out icon octicon octicon-pencil" aria-hidden="true"></i></a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>