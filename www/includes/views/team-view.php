<?php
	// SNIP "Meet the team" page
	class TeamView extends View {

		public function content() {

			$result = $this->model->processGetAllStaff();

			echo '<div id="container">';
				echo '<div class="news-container">';
				
					// All staff should be inside this slider
					echo '<div class="wallop-slider">';
						echo '<button class="wallop-slider__btn wallop-slider__btn--previous" disabled="disabled"><i class="fa fa-chevron-circle-left"></i></button>';
						echo '<ul class="wallop-slider__list">';

						// If there is staff, show them.
						if($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
							
								// If first staff member, then give them first position inside slider
								if( $row['staff_ID'] == 1 ) {
									echo '<li class="wallop-slider__item wallop-slider__item--current">';
									echo '<img src="images/staff/'.htmlspecialchars($row['staff_photo']).'" alt="Hairdresser working at SNIP, on The Terrace"/>';
									echo '<div class="news">';
										echo '<h2>'.htmlspecialchars($row['staff_name']).'</h2>';

										// If admin is logged in, then show edit and delete buttons
										if( isset($_SESSION['user_access']) && $_SESSION['user_access'] == 'admin' ) {

											echo '<ul>';
												echo '<li><a href="index.php?page=editStaff&amp;staff_ID='.$row['staff_ID'].'"><i class="fa fa-pencil-square-o"></i> Edit</a></li>';
												echo '<li><a href="index.php?page=deleteStaff&amp;staff_ID='.$row['staff_ID'].'"><i class="fa fa-times"></i> Delete</a></li>';
											echo '</ul>';
										}

										echo '<hr/>';
										echo '<p>'.htmlspecialchars($row['staff_desc']).'</p>';
									echo '</div>';
								echo '</li>';

								} else {

									// All other staff should go into these slider positions
									echo '<li class="wallop-slider__item">';
										echo '<img src="images/staff/'.htmlspecialchars($row['staff_photo']).'" alt="Hairdresser working at SNIP, on The Terrace"/>';
										echo '<div class="news">';
											echo '<h2>'.htmlspecialchars($row['staff_name']).'</h2>';

											// If admin is logged in, then show edit and delete buttons
											if( isset($_SESSION['user_access']) && $_SESSION['user_access'] == 'admin' ) {

												echo '<ul>';
													echo '<li><a href="index.php?page=editStaff&amp;staff_ID='.$row['staff_ID'].'"><i class="fa fa-pencil-square-o"></i> Edit</a></li>';
													echo '<li><a href="index.php?page=deleteStaff&amp;staff_ID='.$row['staff_ID'].'"><i class="fa fa-times"></i> Delete</a></li>';
												echo '</ul>';
											}

											echo '<hr/>';
											echo '<p>'.htmlspecialchars($row['staff_desc']).'</p>';
										echo '</div>';
										// End of news
									echo '</li>';
								}
							}
		
						} else {
							// Else, tell user that no staff exists.
							echo '<li class="wallop-slider__item wallop-slider__item--current">';
								echo '<img src="images/temp/placeholder.png" alt="No staff profiles available">';
								echo '<div class="news">';
									echo '<h2>Staff profiles coming soon!</h2>';
									echo '<hr/>';
									echo '<p>At this point in time, we have not uploaded any photos of our amazing staff. Feel free to meet us in person though!</p>';
								echo '</div>';
								echo '</li>';
						}

						echo '</ul>';
						echo '<button class="wallop-slider__btn wallop-slider__btn--next"><i class="fa fa-chevron-circle-right"></i></button>';
					
					echo '</div>';
					// End of slider

				echo '</div>';

			echo '</div>';
			// End of written content
		}
	}