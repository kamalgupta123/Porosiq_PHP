<?php
if (!empty($get_vendor_dtls)) {
    ?>
    <select name="vendor_id[]" id="vendor_id" class="form-control validate[required]" multiple="multiple">
        <option value="">--Select Vendor--</option>
        <?php
        if (!empty($get_vendor_dtls)) {
            foreach ($get_vendor_dtls as $vval) {
                ?>
                <option value="<?php echo $vval['vendor_id']; ?>"><?php echo $vval['vendor_company_name']; ?></option>
                <?php
            }
        }
        ?>
    </select>
    <?php
}
else{
    ?>
    <select name="vendor_id" id="vendor_id" class="form-control validate[required]" multiple="multiple">
        <option value="">--Select Vendor--</option>
    </select>
    <?php
}
?>