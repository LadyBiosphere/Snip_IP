<?php
	// SNIP 'logout'
	class LogoutView extends View {

		public function content() {

			// Tell user about successful logout
			echo '<div id="container">';
				echo '<div class="news-container">';
					echo '<div class="news">';
						echo '<h2>You have logged out </h2>';
						echo '<p>You have successfully logged out!</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}

		public function render() {

			$this->model->logout();

			parent::render();
		}
	}