<div class="insert-details">
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?page=editStaff&amp;staff_ID=<?php echo $_GET['staff_ID']; ?>" method="POST">
		
		<div>
			<label for="name">Staff Name: </label>
			<input type="text" name="name" value="<?php echo htmlspecialchars($this->name); ?>" id="name">	
			<span class="error"><?php echo $this->nameError; ?></span>
		</div>
		<div>
			<label for="bio">Biography: </label>
			<textarea id="bio" rows="5" cols="20" name="bio"><?php echo htmlspecialchars($this->bio); ?></textarea>
			<span class="error"><?php echo $this->bioError; ?></span>
		</div>
		<input type="submit" name="update-staff" value="Update Staff" class="button">

	</form>
</div>