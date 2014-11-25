<?php
	// SNIP "Latest News" Page
	class NewsView extends View {

		public function content() {

			$result = $this->model->processGetAllNews();

			// If there is news, show them.
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						
						// All written content should be inside 
						echo '<div id="container">';

							// All news content should be inside 
							echo '<div class="news-container-news">';

								// Each news article should be inside own <div></div>
								echo '<div class="news">';
									echo '<h3>'.htmlspecialchars($row['news_title']).'</h3>';

										// Show edit and delete buttons if admin is logged on 
										if( isset($_SESSION['user_access']) && $_SESSION['user_access'] == 'admin' ) {

											echo '<ul class="admin-controls">';
												echo '<li><a href="index.php?page=editNews&news_ID='.$row['news_ID'].'"><i class="fa fa-pencil-square-o"></i> Edit</a></li>';
												echo '<li><a href="index.php?page=deleteNews&news_ID='.$row['news_ID'].'"><i class="fa fa-times"></i> Delete</a></li>';
											echo '</ul>';
										}

									echo '<hr/>';

									echo '<p class="date"> Date: '.$row['news_date'].'</p>';

									// If an image is available for article, include it
									if( $row['news_photo'] != '' ) {
										echo '<img src="images/news/'.htmlspecialchars($row['news_photo']).'" alt="Latest News at SNIP, hair salon on The Terrace."/></a>';
									}
																		
									echo '<p>'.htmlspecialchars($row['news_desc']).'</p>';

								echo '</div>';
								// End of news

							echo '</div>';
							// End of news container

						echo '</div>';
						// End of written content
					}
					
			} else {
				// Else, tell user that no news exists.
				echo '<div id="container">';
					echo '<div class="news-container-news">';
						echo '<div class="news">';
							echo '<p>There is no news at this point in time.</p>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		}
	}