<?php
if (isset($get_details)) {
    $admin_id = $get_details[0]['admin_id'];
}
$menu_str = "";
$get_admin_menu_permission = $this->profile_model->getAdminPermissionDetails($admin_id);
foreach ($get_admin_menu_permission as $mval) {
    $menu_str .= $mval['menu_id'] . ',';
}
$menus = trim($menu_str, ",");

$get_admin_menu = $this->profile_model->getAdminMenu($menus);

// echo "<pre>".print_r($get_admin_menu,1)."</pre>";
// exit;

// Making this array global will be a necessary justice
global $global_user_privileges;
?>
<ul class="sidebar-menu">
    <!--<li class="header">MAIN NAVIGATION</li>-->
    <li class="treeview <?php if (isset($page) && $page == "dashboard") { ?> active <?php } ?>">
        <a href="<?php echo base_url('admin_dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <?php
    if (!empty($get_admin_menu)) {
        foreach ($get_admin_menu as $aval) {
			$get_admin_child_menu = $this->profile_model->getAdminChildMenu($aval['id']);
            ?>
            <li class="treeview <?php if (isset($page) && $page == $aval['page_name']) { ?> active <?php } ?>">
                <a href="<?php echo base_url() . $aval['menu_url']; ?>"><i class="fa fa-book"></i> <span><?php echo ucwords($aval['menu_name']); ?></span>
                    <?php
                    if (!empty($get_admin_child_menu)) {
                        ?>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        <?php
                    }
                    ?>
                </a>
                <?php
                if (!empty($get_admin_child_menu)) {
                    ?>
                    <ul class="treeview-menu">
                        <?php
                        foreach ($get_admin_child_menu as $cval) {
                            // For the child menus, check if it's showable using the menu_is_showable() helper function
                            if (!menu_is_showable($cval['menu_name'])) {
                                continue;
                            }

                            if ($cval['menu_name'] == "Compose") {
                                $f_icon = "fa-plus-circle";
                            } elseif ($cval['menu_name'] == "Inbox") {
                                $f_icon = "fa-inbox";
                            } elseif ($cval['menu_name'] == "Sent Items") {
                                $f_icon = "fa-paper-plane-o";
                            } else {
                                $f_icon = "fa-circle-o";
                            }
                            ?>
                            <li><a href="<?php echo base_url() . $cval['menu_url']; ?>"><i class="fa <?php echo $f_icon; ?>"></i> <?php echo ucwords($cval['menu_name']); ?></a></li>
                                <?php
                            }
                            ?>
                    </ul>
                    <?php
                }
                ?>
            </li>
            <?php
        }
    }
    ?>

</ul>
