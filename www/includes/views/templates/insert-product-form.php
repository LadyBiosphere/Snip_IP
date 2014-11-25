<div class="insert-details" id="product-form">
	<h3><i class="fa fa-plus-square-o"></i> Add a Product</h3>

	<form action="<?php echo $_SERVER['PHP_SELF'].'?page=admin'; ?>" method="POST" enctype="multipart/form-data" id="insert-product">
		<div>
			<label>Name of Product or Service: </label>
			<input type="text" name="productName" id="productName" placeholder="e.g. Restyle / Status Quo Silver" value="<?php echo htmlspecialchars($this->productName); ?>">
			<span class="error" id="product-name-error"><?php echo $this->productNameError; ?></span>
		</div>
		<div>
			<label>Price $:</label>
			<input type="text" name="productPrice" id="productPrice" placeholder="00.00" value="<?php echo htmlspecialchars($this->productPrice); ?>">
			<span class="error" id="product-name-error"><?php echo $this->productPriceError; ?></span>
		</div>
		<div>
			<label>Category: </label>
			<select name="category">
				<?php while($cat = $listOfCat->fetch_assoc()) {
				echo '<option value="'.$cat['cat_ID'].'">'.$cat['category'].'</option>';
				} ?>
			</select>
		</div>
		<div>
			<input type="submit" value="Add Product" class="button" name="insert-product" >
			<span class="error" id="product-error"><?php echo $this->uploadMessagesProduct; ?></span>
		</div>
	</form>
	
</div>