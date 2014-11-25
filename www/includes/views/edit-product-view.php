<?php
	// Edit products and services
	class EditProductView extends View {

		// Error properties
		private $nameError 		= '';
		private $priceError 	= '';

		// Content properties
		private $name 			= '';
		private $price 			= '';
		private $userID 		= '';

		public function content() {

			// If a user attempts to access page without login, inform that page is restricted
			if(!isset($_SESSION['user_username'])) {

				echo '<div id="container">';
					echo '<div class="news-container">';
						echo '<div class="news">';
							echo '<h2>Access Denied</h2>';
							echo '<p>You need to be <a href="index.php?page=login">logged in</a> to see this page!</p>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				return;
			}

			// If user submitted form, put all 'POST' values from the form into properties
			if(isset($_POST['update-product'])) {

				// Hold data
				$this->name 		= $_POST['name'];
				$this->price 		= $_POST['price'];

				// Process and get result
				$updateResult = $this->model->processUpdateProduct();
				$getProductUploadData = $this->model->processGetProductUploadData();

				// If edit failed, then put error message into property. 
				if( $updateResult['success'] == false) {
					if(isset($updateResult['name-error'])) {
						$this->nameError = $updateResult['name-error'];
					}
					if(isset($updateResult['price-error'])) {
						$this->priceError = $updateResult['price-error'];
					}
				} else {

					// Inform user that an update was made
					echo '<div class="news-container">';
						echo '<div class="news">';
								echo '<p><span class="error">Updates Applied:</span> Check it out on the <a href="index.php?page=prices">Services and Products</a> page!</p>';
						echo '</div>';
					echo '</div>';
					
				}
			} else {
				// Else, successful. Process.
				$productData = $this->model->processGetProductUploadData();
				$getProductUploadData = $this->model->processGetProductUploadData();

				// Put data into properties
				$this->name 		= $productData['product_name'];
				$this->price 		= $productData['product_price'];

			}

			// Editing interface
			echo '<div id="container">';
				echo '<div class="news-container-news">';
					echo '<div class="news">';

						require 'includes/views/templates/update-product-form.php';

					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}