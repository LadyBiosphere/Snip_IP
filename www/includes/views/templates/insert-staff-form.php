<div class="insert-details" id="staff-form">
	<h3><i class="fa fa-plus-square-o"></i> Add New Staff</h3>

	<form action="<?php echo $_SERVER['PHP_SELF'].'?page=admin'; ?>" method="POST" enctype="multipart/form-data" id="insert-staff">
		<div>
			<label>First Name: </label>
			<input type="text" name="staffName" id="staffName" placeholder="e.g. Alex" value="<?php echo htmlspecialchars($this->staffName); ?>">
			<span class="error" id="staff-name-error"><?php echo $this->staffNameError; ?></span>
		</div>
		<div>
			<label>Staff Photo: </label>
			<input type="file" name="staffPhoto">
			<span class="error" id="staff-photo-error"><?php echo $this->staffPhotoError; ?></span>
		</div>
		<div>
			<label>Biography: </label>
			<textarea rows="5" cols="20" name="staffBio" id="staffBio" value="<?php echo htmlspecialchars($this->staffBio); ?>"></textarea>
			<span class="error" id="staff-bio-error"><?php echo $this->staffBioError; ?></span>
		</div>
		<div>
			<input type="submit" value="Add to Team" class="button" name="insert-staff" >
			<span class="error" id="staff-error"><?php echo $this->uploadMessagesStaff; ?></span>
		</div>
	</form>
	
</div>