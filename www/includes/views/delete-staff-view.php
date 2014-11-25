<?php
	// Delete staff
	class DeleteStaffView extends View {

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
			$getStaffUploadData = $this->model->processGetStaffUploadData();

			// If user submitted form, then process and delete it. Inform user that content is gone.
			if(isset($_POST['yes'])) {
				$result = $this->model->processDeleteStaff();

				// Did it work?
				if( $result ) {
					// Deleted

					echo '<div class="news">';
							echo '<p><span class="error">Hairdresser Deleted:</span> Head back to the <a href="index.php?page=team">Team</a> page.</p>';
					echo '</div>';

				} else {
					// If failed to delete.
					echo '<div id="user-details">';
						echo '<p>This hairdresser was NOT deleted. </p>';
					echo '</div>';
				}
			} else {

				echo '<div id="container">';
					echo '<div class="news-container-news">';
						echo '<div class="news">';


							echo '<h3>'.htmlspecialchars($getStaffUploadData['staff_name']).'</h3>';

							// If an image is available, include it
							if( $getStaffUploadData['staff_photo'] != '' ) {
								echo '<img src="images/staff/'.htmlspecialchars($getStaffUploadData['staff_photo']).'" alt="Salon News"/>';
							}

							echo '<p>'.htmlspecialchars($getStaffUploadData['staff_desc']).'</p>';

						echo '</div>';

						// Offer deleting AND 'back' option
						echo '<form action="index.php?page=deleteStaff&amp;staff_ID='.$_GET['staff_ID'].'" method="POST" class="form">';
								echo '<input type="submit" name="yes" value="Yes, delete!" class="button">';
								echo '<a href="index.php?page=team">Back to Team Page.</a>';
						echo '</form>';

					echo '</div>';
				echo '</div>';
			}
		}
	}