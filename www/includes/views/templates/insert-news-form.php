<div class="insert-details" id="news-form">
	<h3><i class="fa fa-bullhorn"></i> Share news</h3>
	<form action="<?php echo $_SERVER['PHP_SELF'].'?page=admin'; ?>" method="POST" enctype="multipart/form-data" id="insert-news">
		<div>
			<label>Heading: </label>
			<input type="text" name="title" id="title" placeholder="e.g. We're closing early today" value="<?php echo htmlspecialchars($this->newsTitle); ?>">
			<span class="error" id="news-title-error"><?php echo $this->newsTitleError; ?></span>
		</div>
		<div>
			<label>Photo (optional): </label>
			<input type="file" name="newsPhoto">
		</div>
		<div>
			<label>Description: </label>
			<textarea rows="5" cols="20" name="desc" id="desc"></textarea>
			<span class="error" id="news-desc-error"><?php echo $this->newsDescError; ?></span>
		</div>
		<div>
			<input type="submit" value="Post News" class="button" name="insert-news" >
			<span class="error" id="news-error"><?php echo $this->uploadMessages; ?></span>

		</div>
		
	</form>
</div>