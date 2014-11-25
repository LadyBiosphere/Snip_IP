<div class="insert-details">

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?page=editNews&amp;news_ID=<?php echo $_GET['news_ID']; ?>" method="POST">
		<div>
			<label for="title">Heading: </label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($this->title); ?>" id="title">	
			<span class="error"><?php echo $this->titleError; ?></span>
		</div>
		<div>
			<label for="desc">Description: </label>
			<textarea id="desc" rows="5" cols="20" name="desc"><?php echo htmlspecialchars($this->desc); ?></textarea>
			<span class="error"><?php echo $this->descError; ?></span>
		</div>
		<input type="submit" name="update-piece" value="Update News" class="button">
	</form>

</div>