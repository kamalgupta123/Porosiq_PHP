<?php
if (!empty($get_mails)) {
    $mail_count = count($get_mails);
} else {
    $mail_count = 0;
}
?>
<li class="header">You have <?php echo $mail_count; ?> messages</li>
<li>
    <!-- inner menu: contains the actual data -->
    <ul class="menu">
        <!-- start message -->
        <?php
        if (!empty($get_mails)) {
            foreach ($get_mails as $m_val) {
//print_r($m_val);
                $subject = strip_tags(stripslashes($m_val['subject']));
                $message = strip_tags(stripslashes($m_val['message']));
                $time = $m_val['entry_date'];

//                $datetime1 = new DateTime(date("Y-m-d h:i:s"));
//                $datetime2 = new DateTime($m_val['entry_date']);
//                $interval = $datetime1->diff($datetime2);

//                if ($m_val['reply_id'] == 0) {
                    $id = $m_val['id'];
//                } else {
//                    $id = $m_val['reply_id'];
//                }


                /* ------------------Get Sender Details-------------------- */

                if ($m_val['sender_type'] == 'superadmin') {
                    $get_sender_details = $this->communication_model->getSuperAdminDetails($m_val['sender_id']);
                    if (!empty($get_sender_details)) {
                        $sender_id = $get_sender_details[0]['sa_id'];
                        $sender_name = ucwords($get_sender_details[0]['sa_name']);
                        $sender_email = $get_sender_details[0]['sa_email'];
                        $file = $get_sender_details[0]['file'];
                        $file_path = "uploads/";
                    }
                }
                if ($m_val['sender_type'] == 'admin') {
                    $get_sender_details = $this->communication_model->getAdminDetails($m_val['sender_id']);
                    if (!empty($get_sender_details)) {
                        $sender_id = $get_sender_details[0]['admin_id'];
                        $sender_name = ucwords($get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name']);
                        $sender_email = $get_sender_details[0]['admin_email'];
                        $file = $get_sender_details[0]['file'];
                        $file_path = "uploads/admin/profile_pic/" . strtolower($get_sender_details[0]['first_name']) . "_" . strtolower($get_sender_details[0]['last_name']) . "/";
                    }
                }
                if ($m_val['sender_type'] == 'vendor') {
                    $get_sender_details = $this->communication_model->getVendorDetails($m_val['sender_id']);
                    if (!empty($get_sender_details)) {
                        $sender_id = $get_sender_details[0]['vendor_id'];
                        $sender_name = ucwords($get_sender_details[0]['first_name'] . " " . $get_sender_details[0]['last_name']);
                        $sender_email = $get_sender_details[0]['vendor_email'];
                        $file = $get_sender_details[0]['photo'];
                        $file_path = "uploads/";
                    }
                }
                if ($m_val['sender_type'] == 'employee') {
                    $get_sender_details = $this->communication_model->getEmployeeDetails($m_val['sender_id']);
                    if (!empty($get_sender_details)) {
                        $sender_id = $get_sender_details[0]['employee_id'];
                        $sender_name = ucwords($get_sender_details[0]['first_name']. " " . $get_sender_details[0]['last_name']);
                        $sender_email = $get_sender_details[0]['employee_email'];
                        $file = $get_sender_details[0]['file'];
                        $file_path = "uploads/";
                    }
                }
                /* ------------------Get Sender Details-------------------- */
                ?>
                <li>
                    <a href="<?php echo site_url('inbox_mail_details') . "/" . base64_encode($id); ?>" style="color: #45b1cd;font-size: 15px;">
                        <div class="pull-left">
                            <?php
                            if ($file != '') {
                                ?>
                                <img src="<?php echo site_url() . $file_path . $file; ?>" class="img-circle" alt="User Image">
                                <?php
                            } else {
                                ?>
                                <img alt="User Image" class="img-circle" src="<?php echo base_url(); ?>assets/images/blank-profile.png">
                                <?php
                            }
                            ?>
                        </div>
                        <h4>
                            <span style="font-size: 12px;">
                                <?php
                                if (strlen($subject) > 30) {
                                    echo substr($subject, 0, 20) . "..";
                                } else {
                                    echo $subject;
                                }
                                ?>
                            </span>
                            <small>
                               <?php //echo $interval->format('%h') . " hours " . $interval->format('%i') . " minutes"; ?>
                                <i class="fa fa-clock-o"></i> <?php echo date("m-d-Y h:i A", strtotime($time)); ?>
                            </small>
                        </h4>
                        <span style="font-size: 12px;">
                           <?php
                            if (strlen($message) > 35) {
                                echo substr($message, 0, 30) . "..";
                            } else {
                                echo $message;
                            }
                            ?>
                        </span>
                    </a>
                </li>
                <?php
            }
        }
        ?>
        <!-- end message -->
    </ul>
</li>
<li class="footer"><a href="<?php echo site_url('inbox'); ?>">See All Messages</a></li>