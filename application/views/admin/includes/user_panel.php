<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left image">
        <?php
        if ($get_details[0]['file'] != '') {
            $file_path = "uploads/admin/profile_pic/" . strtolower($get_details[0]['first_name']) . "_" . strtolower($get_details[0]['last_name']) . "/";
            ?>
            <img src="<?php echo site_url() . $file_path . $get_details[0]['file']; ?>" class="img-circle"
                 alt="User Image">
                 <?php
             } else {
                 ?>
            <div id="profileImage2"></div>
            <?php
        }
        ?>
    </div>
    <div class="pull-left info">
        <p>
            <?php
                if ($get_details[0]['is_hiring_manager'] == "1") {
                    echo "Hiring Manager";
                } else {
                    echo "Admin";
                }
            ?>
        </p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
</div>