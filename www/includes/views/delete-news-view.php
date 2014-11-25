<?php
	// Delete a piece of news
	class DeletePieceView extends View {

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
			$getNewsUploadData = $this->model->processGetNewsUploadData();

			// Show content for deleting
			// If user submitted form, then process and delete it. Inform user that content is gone.
			if(isset($_POST['yes'])) {
				$result = $this->model->processDeletePiece();

				// Did it work?
				if( $result ) {
					// Deleted

					echo '<div class="news">';
							echo '<p><span class="error">Snippet Deleted:</span> Head back to the <a href="index.php?page=news">News</a> page! </p>';
					echo '</div>';

				} else {
					// Failed to delete.
					echo '<div id="user-details">';
						echo '<p>Snippet was NOT deleted. </p>';
					echo '</div>';
				}
			} else {

				echo '<div id="container">';
					echo '<div class="news-container-news">';
						echo '<div class="news">';


							echo '<h3>'.htmlspecialchars($getNewsUploadData['news_title']).'</h3>';

							// If an image is available, include it
							if( $getNewsUploadData['news_photo'] != '' ) {
								echo '<img src="images/news/'.htmlspecialchars($getNewsUploadData['news_photo']).'" alt="Salon News"/></a>';
							}

							echo '<p>'.htmlspecialchars($getNewsUploadData['news_desc']).'</p>';

						echo '</div>';

						// Offer deleting AND 'back' option
						echo '<form action="index.php?page=deleteNews&amp;news_ID='.$_GET['news_ID'].'" method="POST" class="form">';
								echo '<input type="submit" name="yes" value="Yes, delete!" class="button">';
								echo '<a href="index.php?page=news"> Back to Latest News</a>';
						echo '</form>';

					echo '</div>';
				echo '</div>';
			}
		}
	}