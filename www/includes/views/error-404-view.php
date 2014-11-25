<?php
	// SNIP '404 error' page
	class Error404View extends View {

		public function content() {
			
			echo '<div id="container">';
				echo '<div class="news-container">';
					echo '<div class="news">';
						echo '<h3>404 Page Not Found</h3>';
						echo '<hr/>';
						echo '<p>Oops! It looks like an error occurred! Please try refreshing the page. If this error persists, please <a href="index.php?page=contact">let us know</a>!</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}