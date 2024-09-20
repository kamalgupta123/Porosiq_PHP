<select name="city" id="city" class="form-control validate[required]">
    <option value="">Select City</option>
    <?php foreach($get_city as $cval){ ?>
        <option value="<?php echo $cval['id']; ?>"><?php echo $cval['name']; ?></option>
    <?php } ?>
</select>