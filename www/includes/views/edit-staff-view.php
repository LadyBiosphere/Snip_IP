<?php
	// Edit staff page
	class EditStaffView extends View {

		// Error properties
		private $nameError 	= '';
		private $bioError 		= '';

		// Content properties
		private $img 			= '';
		private $name 			= '';
		private $bio 			= '';
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
			if(isset($_POST['update-staff'])) {

				// Hold data
				$this->name 	= $_POST['name'];
				$this->bio 		= $_POST['bio'];

				// Process and get result
				$updateResult = $this->model->processUpdateStaff();
				$getStaffUploadData = $this->model->processGetStaffUploadData();

				// If edit failed, then put error message into property. 
				if( $updateResult['success'] == false) {
					if(isset($updateResult['name-error'])) {
						$this->nameError = $updateResult['name-error'];
					}
					if(isset($updateResult['bio-error'])) {
						$this->bioError = $updateResult['bio-error'];
					}
				} else {

					// Inform user that an update was made
					echo '<div class="news-container">';
						echo '<div class="news">';
								echo '<p><span class="error">Updates Applied:</span> Check it out on the <a href="index.php?page=team">Team</a> page!</p>';
						echo '</div>';
					echo '</div>';

				}
			// Else, successful. Process.
			} else {
				$staffData = $this->model->processGetStaffUploadData();
				$getStaffUploadData = $this->model->processGetStaffUploadData();

				// Put data into properties
				$this->name 		= $staffData['staff_name'];
				$this->photo 		= $staffData['staff_photo'];
				$this->bio 			= $staffData['staff_desc'];
			}

			// Editing interface
			echo '<div id="container">';
				echo '<div class="news-container-news">';
					echo '<div class="news">';

						// If an image is available, include it
						if( $getStaffUploadData['staff_photo'] != '' ) {
							echo '<img src="images/staff/'.htmlspecialchars($getStaffUploadData['staff_photo']).'" alt="Hairdresser at Snip"/>';
						} else {
							echo '<img src="images/staff/default.png" alt="Hairdresser at Snip"/></a>';
						}

						require 'includes/views/templates/update-staff-form.php';

					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}