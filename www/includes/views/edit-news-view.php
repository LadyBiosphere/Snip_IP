<?php
	// Editing news
	class EditPieceView extends View {

		// Error properties
		private $titleError 	= '';
		private $descError 		= '';

		// Content properties
		private $img 			= '';
		private $title 			= '';
		private $desc 			= '';
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
			if(isset($_POST['update-piece'])) {

				// Hold data
				$this->title 	= $_POST['title'];
				$this->desc 	= $_POST['desc'];

				// Process and get result
				$updateResult = $this->model->processUpdateNews();
				$getNewsUploadData = $this->model->processGetNewsUploadData();

				// If edit failed, then put error message into property. 
				if( $updateResult['success'] == false) {
					if(isset($updateResult['title-error'])) {
						$this->titleError = $updateResult['title-error'];
					}
					if(isset($updateResult['desc-error'])) {
						$this->descError = $updateResult['desc-error'];
					}
				} else {

					// Inform user that an update was made
					echo '<div class="news-container">';
						echo '<div class="news">';
								echo '<p><span class="error">Updates Applied:</span> This article will appear at the top of the <a href="index.php?page=news">News</a> page!</p>';
						echo '</div>';
					echo '</div>';

				}
			} else {
				// Else, registration was successful. Process.
				$newsData = $this->model->processGetNewsUploadData();
				$getNewsUploadData = $this->model->processGetNewsUploadData();

				// Put data into properties
				$this->title 	= $newsData['news_title'];
				$this->tag 		= $newsData['news_photo'];
				$this->desc 	= $newsData['news_desc'];
			}

			// Editing interface
			echo '<div id="container">';
				echo '<div class="news-container-news">';
					echo '<div class="news">';

						// If an image is available, include it
						if( $getNewsUploadData['news_photo'] != '' ) {
							echo '<img src="images/news/'.htmlspecialchars($getNewsUploadData['news_photo']).'" alt="Salon News"/></a>';
						}

						require 'includes/views/templates/update-piece-form.php';

					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}