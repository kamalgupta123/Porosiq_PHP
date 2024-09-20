<center>
	<form method="post" action="<?php echo site_url('superadmin/manage_employee/send_migration_email'); ?>">
		
		<!--label>User Type : </label><br>
		<select name="user_type">
			<option value="S">Super Admin</option>
			<option value="A">Admin</option>
			<option value="V">Vendor</option>
			<option value="C">Consultant</option>
			<option value="E">Employee</option>
		</select><br><br><br-->

		<label>To : </label><br>
		<textarea name="email_ids"></textarea><br><br><br>
		<input cols="20" rows="7" type="submit" name="submit" value="Submit">

	</form>
</center>