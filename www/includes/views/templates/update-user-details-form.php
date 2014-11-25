<div class="insert-details" id="pass-form">
	<h3><i class="fa fa-pencil-square-o"></i> Change Password</h3>
	<form action="<?php echo $_SERVER['PHP_SELF'].'?page=admin'; ?>" method="POST" enctype="multipart/form-data" id="update-account" class="contact-form">
		<div>	
			<label>Current Password: </label>
			<input type="password" name="existing-password">
		</div>

		<div>	
			<label>New Password: </label>
			<input type="password" name="new-password">
		</div>

		<div>	
			<label>Confirm New Password: </label>
			<input type="password" name="confirm-new-password">
		</div>

		<div>	
			<input type="submit" name="update-account" value="Apply Changes">
			<span class="error"><?php echo $this->message; ?></span>
		</div>
	</form>
</div>