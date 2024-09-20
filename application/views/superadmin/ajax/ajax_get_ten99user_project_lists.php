<select name="project_id" id="project_id" class="form-control validate[required]" onchange="return fetchDate();">
    <option value="">Select</option>
    <?php
    if (!empty($get_project_list)) {
        foreach ($get_project_list as $cpval) {
            $get_project_data = $this->employee_model->getProjectData($cpval['project_id']);
            ?>
            <option value="<?php echo $cpval['project_id']; ?>"><?php echo $get_project_data[0]['project_code']. " - " .  ucwords($get_project_data[0]['project_name']); ?></option>
            <?php
        }
    }
    ?>
</select>
