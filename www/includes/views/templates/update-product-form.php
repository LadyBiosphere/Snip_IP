<div class="insert-details">
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?page=editProd&amp;product_ID=<?php echo $_GET['product_ID']; ?>" method="POST">
		
		<div>
			<label for="name">Name: </label>
			<input type="text" name="name" value="<?php echo htmlspecialchars($this->name); ?>" id="name">	
			<span class="error"><?php echo $this->nameError; ?></span>
		</div>
		<div>
			<label for="price">Price $: </label>
			<input type="text" name="price" value="<?php echo htmlspecialchars($this->price); ?>" id="price">	
			<span class="error"><?php echo $this->priceError; ?></span>
		</div>
		<input type="submit" name="update-product" value="Update" class="button">

	</form>
</div>