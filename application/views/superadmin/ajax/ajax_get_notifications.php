<?php
if (!empty($get_details)) {
    $notification_count = count($get_details);
} else {
    $notification_count = 0;
}
?>
<li class="header">You have <?php echo $notification_count; ?> notifications</li>
<li>
    <!-- inner menu: contains the actual data -->
    <ul class="menu">
        <!-- start messa ge -->
        <?php
        if (!empty($get_details)) {
            foreach ($get_details as $n_val) {
//print_r($m_val);
                ?>
                <li>
                    <a href="<?php echo site_url('notifications'); ?>">
                        <h4 style="margin: 0 auto; font-size: 12px;">
                            <?php if(strlen($n_val) > 50){ echo substr($n_val,0,45).".."; }else{ echo $n_val; } ?>
                        </h4>
                    </a>
                </li>
                <?php
            }
        }
        ?>
        <!-- end message -->
    </ul>
</li>
<li class="footer"><a href="<?php echo site_url('notifications'); ?>">See All Notifications</a></li>