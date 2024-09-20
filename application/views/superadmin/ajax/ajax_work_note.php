<?php
if(!empty($get_work_note)){
    ?>
    <span><label>Note:&nbsp;</label><?php echo $get_work_note[0]['work_order_note']; ?></span>
    <?php
}
else{
    ?>
    <span>&nbsp;</span>
    <?php
}
?>