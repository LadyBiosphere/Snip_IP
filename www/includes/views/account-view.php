<?php
	// SNIP admin 'controls' page
	class AccountView extends View {

		// Error properties
		public $newsTitleError 		= '';
		public $newsDescError 		= '';
		
		public $productNameError	= '';
		public $productPriceError	= '';
		
		public $staffNameError		= '';
		public $staffPhotoError 	= '';
		public $staffBioError		= '';


		// Form field properties
		public $newsTitle 		= '';
		public $newsDesc 		= '';
		
		public $productName 	= '';
		public $productPrice 	= '';
		public $productCat 		= '';

		public $staffName		= '';
		public $staffBio		= '';

		// Upload result properties
		private $message 				= '';
		private $uploadMessages 		= '';
		private $uploadMessagesProduct 	= '';
		private $uploadMessagesStaff 	= '';


		public function content() {

			// If a user attempts to access page without login, inform login required
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

			// Get a list of all product categories
			$listOfCat = $this->model->processGetAllCategories();

			// If user submitted this form, then user wants to change password
			if( isset($_POST['update-account']) ) {
				$updateResult = $this->model->processUserDataUpdate();
				$this->message = $updateResult['message'];
			}

			// If user submitted this form, then user wants to upload news
			if (isset($_POST['insert-news'])) {

				$this->newsTitle 	= $_POST['title'];
				$this->newsDesc 	= $_POST['desc'];
				$result = $this->doInsertNews();
			}

			// If user submitted this form, then user wants to upload product
			if (isset($_POST['insert-product'])) {

				$this->productName 		= $_POST['productName'];
				$this->productPrice 	= $_POST['productPrice'];
				$this->productCat 		= $_POST['category'];
				$result = $this->doInsertProduct();
			}

			// If user submitted this form, then user wants to add new staff
			if (isset($_POST['insert-staff'])) {

				$this->staffName 	= $_POST['staffName'];
				$this->staffBio 	= $_POST['staffBio'];
				$result = $this->doInsertStaff();
			}

			// Get info about user - show user their own info
			$userData = $this->model->processGetUserData();
			echo '<div id="container">';
				echo '<div class="contact-details">';
					echo '<div class="disclaimer">';
						echo '<h3>Account Info</h3>';
						echo '<p>You are logged in as '.$_SESSION['user_username'].' and have '.$_SESSION['user_access'].' rights.</p>';
					echo '</div>';
				echo '</div>';

				// Uploading interfaces
				include 'includes/views/templates/update-user-details-form.php';
				require 'includes/views/templates/insert-news-form.php';
				require 'includes/views/templates/insert-product-form.php';
				require 'includes/views/templates/insert-staff-form.php';
			echo '</div>';

		}
		// End of content

		private function doInsertNews() {

			// Process and upload
			$resultOfInsert = $this->model->processInsertNews();

			// If upload failed, then put error message into property. Else, upload was successful.
			if( $resultOfInsert['success'] == false ) {
				if( isset($resultOfInsert['news-title-error']) ) {
					$this->newsTitleError = $resultOfInsert['news-title-error'];
				}
			}

			// If upload failed, then put error message into property. Else, upload was successful.
			if( $resultOfInsert['success'] == false ) {
				if( isset($resultOfInsert['news-desc-error']) ) {
					$this->newsDescError = $resultOfInsert['news-desc-error'];
				}
			}

			// If result is success
			if( $resultOfInsert['success'] == true ) {
				header('Location: index.php?page=newsSuccess');
			} else {
				// Save the messages for use later
				$this->uploadMessages = $resultOfInsert['news-error'];
			}
		}

		private function doInsertProduct() {

			// Process and upload
			$resultOfInsert = $this->model->processInsertProduct();

			// If upload failed, then put error message into property. Else, upload was successful.
			if( $resultOfInsert['success'] == false ) {
				if( isset($resultOfInsert['product-name-error']) ) {
					$this->productNameError = $resultOfInsert['product-name-error'];
				}
			}

			// If upload failed, then put error message into property. Else, upload was successful.
			if( $resultOfInsert['success'] == false ) {
				if( isset($resultOfInsert['product-price-error']) ) {
					$this->productPriceError = $resultOfInsert['product-price-error'];
				}
			}

			// If result is success
			if( $resultOfInsert['success'] == true ) {
				header('Location: index.php?page=newsSuccess');
			} else {
				// Save the messages for use later
				$this->uploadMessagesProduct = $resultOfInsert['product-error'];
			}
		}

		private function doInsertStaff() {

			// Process and upload
			$resultOfInsert = $this->model->processInsertStaff();

			// If upload failed, then put error message into property. Else, upload was successful.
			if( $resultOfInsert['success'] == false ) {
				if( isset($resultOfInsert['staff-name-error']) ) {
					$this->staffNameError = $resultOfInsert['staff-name-error'];
				}
			}

			// If upload failed, then put error message into property. Else, upload was successful.
			if( $resultOfInsert['success'] == false ) {
				if( isset($resultOfInsert['staff-photo-error']) ) {
					$this->staffPhotoError = $resultOfInsert['staff-photo-error'];
				}
			}

			// If upload failed, then put error message into property. Else, upload was successful.
			if( $resultOfInsert['success'] == false ) {
				if( isset($resultOfInsert['staff-bio-error']) ) {
					$this->staffBioError = $resultOfInsert['staff-bio-error'];
				}
			}

			// If result is success
			if( $resultOfInsert['success'] == true ) {
				header('Location: index.php?page=newsSuccess');
			} else {
				// Save the messages for use later
				$this->uploadMessagesStaff = $resultOfInsert['staff-error'];
			}
		}

	}