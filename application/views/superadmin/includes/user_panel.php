<div class="user-panel">
    <div class="pull-left image">
        <?php
        if ($get_details[0]['file'] != '') {
            ?>
            <img src="<?php echo base_url(); ?>uploads/<?php echo $get_details[0]['file']; ?>"
                 class="img-circle"
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
        <p>Super Admin</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
</div>