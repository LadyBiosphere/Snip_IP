<?php
	// Delete product or service
	class DeleteProductView extends View {

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

			// Process and get info about content to be deleted
			$getProductUploadData = $this->model->processGetProductUploadData();

			// Show content for deleting
			// If user submitted form, then process and delete it. Inform user that content is gone.
			if(isset($_POST['yes'])) {
				$result = $this->model->processDeleteProduct();

				// Did it work?
				if( $result ) {
					// Deleted

					echo '<div class="news">';
							echo '<p><span class="error">Product Deleted:</span> Back to <a href="index.php?page=prices">Services and Products</a>. </p>';
					echo '</div>';

				} else {
					// Failed to delete.
					echo '<div id="user-details">';
						echo '<p>Product was NOT deleted. </p>';
					echo '</div>';
				}
			} else {

				echo '<div id="container">';
					echo '<div class="news-container-news">';
						echo '<div class="news">';

							echo '<h3>'.htmlspecialchars($getProductUploadData['product_name']).'</h3>';

								echo '<p> $'.htmlspecialchars($getProductUploadData['product_price']).'</p>';

						echo '</div>';

						// Offer deleting AND 'back' option
						echo '<form action="index.php?page=deleteProd&product_ID='.$_GET['product_ID'].'" method="POST" class="form">';
								echo '<input type="submit" name="yes" value="Yes, delete!" class="button">';
								echo '<a href="index.php?page=prices">Back to Services and Prices.</a>';
						echo '</form>';

					echo '</div>';
				echo '</div>';
			}
		}
	}