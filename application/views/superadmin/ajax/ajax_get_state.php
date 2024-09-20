<select name="state" id="state" class="form-control validate[required]" onChange="getcitydetails(this.value)">
    <option value="">Select State</option>
    <?php foreach($get_state as $sval){ ?>
        <option value="<?php echo $sval['id']; ?>"><?php echo $sval['name']; ?></option>
    <?php } ?>
</select> 