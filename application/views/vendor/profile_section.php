<?php
if (!empty($get_details)) {
    $vendor_id = $get_details[0]['vendor_id'];
    $get_files = $this->profile_model->getVendorFiles($vendor_id);

    $form_1_status = 0;
    $form_2_status = 0;
    $form_3_status = 0;
    $form_4_status = 0;
    $form_5_status = 0;
    $form_6_status = 0;

    if (!empty($get_files)) {
        foreach ($get_files as $fkey => $fval) {
            if ($fval['form_no'] == '1') {
                $form_1_status = $fval['form_status'];
            } elseif ($fval['form_no'] == '2') {
                $form_2_status = $fval['form_status'];
            } elseif ($fval['form_no'] == '3') {
                $form_3_status = $fval['form_status'];
            } elseif ($fval['form_no'] == '4') {
                $form_4_status = $fval['form_status'];
            } elseif ($fval['form_no'] == '5') {
                $form_5_status = $fval['form_status'];
            } elseif ($fval['form_no'] == '6') {
                $form_6_status = $fval['form_status'];
            }
        }
    } else {
        $form_1_status = 0;
        $form_2_status = 0;
        $form_3_status = 0;
        $form_4_status = 0;
        $form_5_status = 0;
        $form_6_status = 0;
    }
}
?>
<div class="box box-primary">
    <div class="box-body box-profile">
        <?php
        if ($get_details[0]['photo'] != '') {
            ?>
            <img src="<?php echo base_url(); ?>uploads/<?php echo $get_details[0]['photo']; ?>"
                 class="profile-user-img img-responsive img-circle"
                 alt="User Image">
                 <?php
             } else {
                 ?>
            <div id="profileImage2"></div>
            <?php
        }
        ?>

        <h3 class="profile-username text-center"><?php echo $get_details[0]['name_prefix'] . " " . $get_details[0]['first_name'] . " " . $get_details[0]['last_name']; ?></h3>

        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Company Name</b> <br>
                <?php echo $get_details[0]['vendor_company_name']; ?>
            </li>
            <li class="list-group-item">
                <b>Date of Contract</b> <br>
                <?php echo date("m-d-Y", strtotime($get_details[0]['contract_from_date'])) . " - " . date("m-d-Y", strtotime($get_details[0]['contract_to_date'])); ?>
            </li>
            <li class="list-group-item">
                <b>Email ID</b> <br>
                <?php echo $get_details[0]['vendor_email']; ?>
            </li>
            <li class="list-group-item">
                <b>Phone Number</b> <br>
                <?php echo ($get_details[0]['phone_ext']) . " - " . (($get_details[0]['phone_no'] != '0') ? $get_details[0]['phone_no'] : ""); ?>
            </li>
            <li class="list-group-item">
                <b>Fax Number</b> <br>
                <?php echo ($get_details[0]['fax_no'] != '0') ? $get_details[0]['fax_no'] : ""; ?>
            </li>
            <li class="list-group-item">
                <b>No of Employees</b> <br>
                <?php //echo $get_details[0]['vendor_email']; ?>
            </li>
        </ul>
        <?php
        if ($get_details[0]['status'] != '0' && $get_details[0]['block_status'] != '0') {

            if (isset($form_1_status) && $form_1_status != '0' && isset($form_2_status) && $form_2_status != '0' && isset($form_3_status) && $form_3_status != '0' && isset($form_4_status) && $form_4_status != '0' && isset($form_5_status) && $form_5_status != '0' && isset($form_6_status) && $form_6_status != '0') {
                ?>
                <a href="<?php echo site_url('vendor_profile'); ?>" class="btn btn-primary btn-block"><b>Edit
                        Information</b></a>
                <?php
            }
        }
        ?>
    </div>
    <!-- /.box-body -->
</div>