<?php
if (isset($get_details)) {
    $sa_id = $get_details[0]['sa_id'];
	//echo $sa_id;
}
$menu_str = "";
$get_admin_menu_permission = $this->profile_model->getSuperAdminPermissionDetails($sa_id);
// echo "<pre>Menu ID = " . print_r($get_admin_menu_permission, 1) . "</pre>";

foreach ($get_admin_menu_permission as $mval) {
    $menu_str .= $mval['menu_id'] . ',';
}
$menus = trim($menu_str, ",");

$get_superadmin_menu = $this->profile_model->getSuperAdminMenu($menus);
// echo "<pre>Menu options = " . print_r($get_superadmin_menu, 1) . "</pre>";
?>
<ul class="sidebar-menu">
    <!--<li class="header">MAIN NAVIGATION</li>-->
    <li class="treeview <?php if (isset($page) && $page == "dashboard") { ?> active <?php } ?>">
        <a href="<?php echo base_url('dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>

    <?php
    if (!empty($get_superadmin_menu)) {
        foreach ($get_superadmin_menu as $aval) {
            $get_superadmin_child_menu = $this->profile_model->getSuperAdminChildMenu($aval['id']);
            ?>
            <li class="treeview <?php if (isset($page) && $page == $aval['page_name']) { ?> active <?php } ?>">
                <a href="<?php echo base_url() . $aval['menu_url']; ?>"><i class="fa fa-book"></i> <span><?php echo ucwords($aval['menu_name']); ?></span>
                    <?php
                    if (!empty($get_superadmin_child_menu)) {
                        ?>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        <?php
                    }
                    ?>
                </a>
                <?php
                if (!empty($get_superadmin_child_menu)) {
                    ?>
                    <ul class="treeview-menu">
                        <?php
                        foreach ($get_superadmin_child_menu as $cval) {
                            if (!empty($get_details)) {
                                $sa_id = $get_details[0]['sa_id'];
                            }
                            $child_menu_id = $cval['id'];
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
                            <li <?php if ($sa_id != '1' && $child_menu_id == '37') { ?> style="display:none;" <?php } ?>><a href="<?php echo base_url() . $cval['menu_url']; ?>"><i class="fa <?php echo $f_icon; ?>"></i> <?php echo ucwords($cval['menu_name']); ?></a></li>
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