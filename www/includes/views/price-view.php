<?php
	// SNIP "Check out our prices" page
	class PriceView extends View {

		public function content() {
 
			$result = $this->model->processGetAllProductData();

			// All written content should be inside 
			echo '<div id="container">';
				
				// All products should be inside this
				echo '<div class="prices-container">';

				// If no results, then inform user.
				if (!$result){
						echo '<div class="news-container-news">';
							echo '<div class="news">';
								echo '<p>There are no products or services listed at this point in time.</p>';
							echo '</div>';
						echo '</div>';
				}

				// Otherwise, loop through categories in the database collection
				foreach( $result as $category ) {

						// Get the key
						$key = key($category);

						// If the category is 'shampoo', then put a "products" section in front of it
						if($key == "Shampoo") {
							echo '<h3>Take home one of our awesome products!</h3>';
							echo '<hr/>';
						}

						echo '<table class="price-board">';
						echo '<thead>';
						echo '<tr>';
						echo '<th>'.key($category).'</th>';
						echo '<th>Price</th>';

						// If admin is logged in, then show edit and delete buttons
						if( isset($_SESSION['user_access']) && $_SESSION['user_access'] == 'admin' ) {

							
							echo '<th>Edit</th>';
							echo '<th>Delete</th>';
							
						}
						echo '</tr>';
						echo '</thead>';
						echo '<tbody>';

						// Loop through each product for this category
						foreach( $category as $product ) {

							foreach( $product as $item ) {
								echo '<tr>';
								echo '<td>'.htmlspecialchars($item['product_name']).'</td>';

								if($item['product_price'] == "0.00") {
									echo '<td>Price on application</td>';
								} else {
									echo '<td>$ '.htmlspecialchars($item['product_price']).'</td>';
								}

								// If admin is logged in, then show edit and delete buttons
								if( isset($_SESSION['user_access']) && $_SESSION['user_access'] == 'admin' ) {
									echo '<td class="admin-controls"><a href="index.php?page=editProd&product_ID='.$item['product_ID'].'"><i class="fa fa-pencil-square-o"></i></a></td>';
									echo '<td class="admin-controls"><a href="index.php?page=deleteProd&product_ID='.$item['product_ID'].'"><i class="fa fa-times"></i></a></td>';
								}
								echo '</tr>';
							}

						}

						echo '</tbody>';
						echo '</table>';
						// End of table
					} 


				echo '</div>';
				// End of news container

			echo '</div>';
			// End of written content
		}
	}