<?php
	// SNIP 'login' page
	class LoginView extends View {

		// Error properties
		private $usernameError 	= '';
		private $passwordError 	= '';

		// Login properies
		private $message 		= '';
		private $username 		= '';

		public function content() {

			// Inform user when login is successful
			if(isset($_SESSION['user_username'])) {
				echo '<div id="container">';
					echo '<div class="news-container">';
						echo '<div class="news">';
							echo '<h2>Hey there, '.$_SESSION['user_username'].'! </h2>';
							echo '<p>You have successfully logged in!</p>';
							
						echo '</div>';
					echo '</div>';
				echo '</div>';
			} else {
				include 'includes/views/templates/login-form.php';
			}
		}

		// If user submits login form via 'POST', process it. If error occurs, show error 
		public function render() {
			if(isset($_POST['login'])) {
				$this->username = $_POST['username'];
				$loginResult = $this->model->processUserLogin();

				if($loginResult['success'] == false) {
					if(isset($loginResult['username-error'])) {
						$this->usernameError = $loginResult['username-error'];
					}
					if(isset($loginResult['password-error'])) {
						$this->passwordError = $loginResult['password-error'];
					}
					if(isset($loginResult['login-error'])) {
						$this->message = $loginResult['login-error'];
					}
				}
			}

			// Run original render
			parent::render();
		}
	}