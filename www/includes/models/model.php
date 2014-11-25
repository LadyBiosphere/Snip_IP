<?php

	// Methods that relate to general website:
	class Model extends Database {

		// Webpages
		public function processGetPageData($requestedPage) {
			$result = $this->getPageData($requestedPage);
			return $result;
		}

		// Get News
		public function processGetAllNews() {
			return $this->getAllNews();
		}

		// Get Staff
		public function processGetAllStaff() {
			return $this->getAllStaff();
		}

		// Get categories, products and prices
		public function processGetAllProductData() {

			// Run query and get DB Object to return
			$allData = $this->getAllProductData();

			// Convert data to a very large associative array
			//$allData = $allData->fetch_all();

			// Container to hold all data as it is being looped through
			$tempAllData = [];

			// Loop through the data and put it all into a large assoc array
			while( $oneItem = $allData->fetch_assoc() ) {
				$tempAllData[] = $oneItem;
			}

			// Use previous name
			$allData = $tempAllData;
			
			// Create an array to hold all the categories
			$allCategories = [];

			foreach( $allData as $product ) {
				$allCategories[] = $product['category'];
			}

			// At this point, we have categories for each product but there is plenty of duplication.
			// Remove duplicate categories.
			$allCategories = array_unique($allCategories);

			// After that duplication has been removed, keys are no longer numbered correctly.
			// Reset the array keys to prevent looping issues later on. NOTE: There must not be any
			// gaps in the list of keys.
			$allCategories = array_values($allCategories);

			// Array to contain the sorted collection of data 
			$allProducts = [];

			// Loop through each category. 
			foreach( $allCategories as $category ) {
				// Prepare new array for allProducts
				$newSetOfProducts = [];

				// Loop through each product
				foreach( $allData as $product ) {

					// If this product category is the same as the category we are looking for, put it in it's own 'container'
					if( $product['category'] == $category ) {
						$newSetOfProducts[] = $product;
					}
				}
				// Put the new set of data into the collection
				$allProducts[] = [$category => $newSetOfProducts];
			}
			return $allProducts;
		}

		// Login user. Checking input 
		public function processUserLogin() {

			$errorMessages = [];

			if(strlen($_POST['username']) < 4) {
				$errorMessages['username-error'] = '* Username is Required / Invalid ';
				$errorMessages['success'] = false;
			}

			if(strlen($_POST['password']) < 5) {
				$errorMessages['password-error'] = '* Password Required / Invalid ';
				$errorMessages['success'] = false;
			}

			// If errors found during validation, send errors to view. Do not login until 
			// all errors have been addressed by user.
			// If no errors, then login and start session
			if(isset($errorMessages['success']) && $errorMessages['success'] == false) {
				return $errorMessages;
			} else {
				$loginResult = $this->attemptLogin();
				if($loginResult == false) {
					$errorMessages['login-error'] = '* Incorrect combination';
					$errorMessages['success'] = false;
					return $errorMessages;
				} else {
					$_SESSION['user_ID'] 		= $loginResult['user_ID'];
					$_SESSION['user_username'] 	= $loginResult['user_username'];
					$_SESSION['user_access'] 	= $loginResult['user_access'];
					$errorMessages['success'] 	= true;
					return $errorMessages;
				}
			}
		}

		// Get userdata from database 
		public function processGetUserData() {
			$userData = $this->getUserData();
			return $userData;
		}

		// Update password
		public function processUserDataUpdate() {

			$updateResult['success'] = true;
			$updateResult['message'] = '';

			include 'includes/classes/validateClass.php';

			$validate = new Validate();

			if( !$validate->checkRequired($_POST['existing-password']) ) {
				$updateResult['success'] = false;
				$updateResult['message'] = '* All fields required';
			}

			if( !$validate->checkRequired($_POST['new-password']) || !$validate->checkRequired($_POST['confirm-new-password']) ) {

				$updateResult['success'] = false;
				$updateResult['message'] = '* All fields required';

			} elseif($_POST['new-password'] != $_POST['confirm-new-password']) {

				$updateResult['success'] = false;
				$updateResult['message'] = '* New passwords do not match';

			} elseif( strlen($_POST['new-password']) < 8 ) {

				$updateResult['success'] = false;
				$updateResult['message'] = '* Passwords must be at least 8 characters long ';

			}

			// Issues?
			if( $updateResult['success'] == false ) {

				return $updateResult;

			} else {

				// Attempt to change password
				$passwordFromDataBase = $this->getUserPassword();

				// Get the password.php file
				require_once 'includes/lib/password.php';

				// Does the new password work with the existing password?
				if( password_verify($_POST['new-password'], $passwordFromDataBase['user_password']) ) {

					$updateResult['success'] = false;
					$updateResult['message'] = '* Cannot use your old password!';
					return $updateResult;

				}

				// Compare the passwords
				if( password_verify( $_POST['existing-password'], $passwordFromDataBase['user_password'] ) ) {

					// Password is valid
					// Insert new password into database
					$this->updatePassword();

					// Prepare success message
					$updateResult['message'] = 'Password Changed!';
					return $updateResult;

				} else {

					// Password is invalid
					// Prepare error messages
					// Send errors back to view
					$updateResult['success'] = false;
					$updateResult['message'] = '* Password is incorrect';

					return $updateResult;

				}
			}
		}


		// Logout the user, and end session
		public function logout() {
			unset($_SESSION['user_username']);
			unset($_SESSION['user_access']);
			unset($_SESSION['user_ID']);
		}

		// Take uploaded image file, and resize it using resizer. Put originals
		// in seperate folders.
		public function processInsertNews() {

			// Has the user submitted an image?
			if( isset($_FILES['newsPhoto']) && $_FILES['newsPhoto']['name'] != '' ) {

				require 'includes/classes/image-upload-and-resize.php';

				// Uploader class
				$imageUploader = new ImageUploadAndResize();

				// Rename news-pic
				$newName = $imageUploader->newName;

				// Original news-pic destination
				$imageUploader->upload('newsPhoto', 'images/news', 645, $newName);

				if($imageUploader->result == false){
					

					// Validation for file failing to upload OR file could not upload for whatever reason
					$uploadMessages['news-error'] ='<p><span class="error">Photo Error:</span> Max size 1MB. Valid formats: .png, .jpeg, .tiff, .gif, .bmp. </p>';
					$uploadMessages['success'] = false;
					return $uploadMessages;

				}

				// Retrieve and hold onto new filename
				$_POST['newsPhoto'] = $imageUploader->newName;

			} else {

				$_POST['newsPhoto'] = '';

			}

			// Field validation
			include 'includes/classes/validateClass.php';

			$validate = new Validate();

			// Array for error/corrective messages
			$errorMessages = [];

			// Assume validation is ok
			$errorMessages['success'] = true;

			// News title
			if( !$validate->checkRequired($_POST['title'])) {
				$errorMessages['news-title-error'] = '* Required (Max 60 characters)';
				$errorMessages['news-error'] = 'News could not be posted';
				$errorMessages['success'] = false;
			}

			// News desc
			if( !$validate->checkRequired($_POST['desc'])) {
				$errorMessages['news-desc-error'] = '* Required (Max 250 characters)';
				$errorMessages['news-error'] = 'News could not be posted';
				$errorMessages['success'] = false;
			}

			// Did validation fail?
			if( $errorMessages['success'] == false ) {
				return $errorMessages;
			}

			// If validated, add news-pic to news
			$this->insertNews();

			$uploadMessages['success'] = true;
			return $uploadMessages;

		}

		public function processGetAllCategories() {
			$catList = $this->getAllCategories();
			return $catList;
		}

		public function processInsertProduct() {

			// Field validation
			include 'includes/classes/validateClass.php';

			$validate = new Validate();

			// Array for error/corrective messages
			$errorMessages = [];

			// Assume validation is ok
			$errorMessages['success'] = true;

			// Product Name
			if( !$validate->checkRequired($_POST['productName'])) {
				$errorMessages['product-name-error'] = '* Required (Max 50 characters)';
				$errorMessages['product-error'] = 'Product could not be added';
				$errorMessages['success'] = false;
			}

			// Product Price
			if( !$validate->checkRequired($_POST['productPrice'])) {
				$errorMessages['product-price-error'] = '* Required';
				$errorMessages['product-error'] = 'Product could not be added';
				$errorMessages['success'] = false;
			}


			// Product can't contain letters
			if( $validate->checkRequired($_POST['productPrice'])) {
				if(!$validate->checkNumeric($_POST['productPrice'])) {
					$errorMessages['product-price-error'] = '* Numbers and full-stops only';
					$errorMessages['product-error'] = 'Product could not be added';
					$errorMessages['success'] = false;
				}
			} else {
				$errorMessages['product-price-error'] = '* If price varies, enter 0.00';
				$errorMessages['product-error'] = 'Product could not be added';
				$errorMessages['success'] = false;
			}

			// Did validation fail?
			if( $errorMessages['success'] == false ) {
				return $errorMessages;
			}

			// If validated, add news-pic to news
			$this->insertProduct();

			$uploadMessagesProduct['success'] = true;
			return $uploadMessagesProduct;

		}


		public function processInsertStaff() {

			// Has the user submitted an image?
			if( isset($_FILES['staffPhoto']) && $_FILES['staffPhoto']['name'] != '' ) {

				require 'includes/classes/image-upload-and-resize.php';

				// Uploader class
				$imageUploader = new ImageUploadAndResize();

				// Rename news-pic
				$newName = $imageUploader->newName;

				// Original news-pic destination
				$imageUploader->upload('staffPhoto', 'images/staff', 645, $newName);

				if($imageUploader->result == false){
					

					// Validation for file failing to upload OR file could not upload for whatever reason
					$uploadMessagesStaff['staff-error'] = '<p><span class="error">Photo error:</span> Max size 1MB. Valid formats: .png, .jpeg, .tiff, .gif, .bmp.  </p>';
					$uploadMessagesStaff['success'] = false;
					return $uploadMessagesStaff;

				}

				// Retrieve and hold onto new filename
				$_POST['staffPhoto'] = $imageUploader->newName;

			} else {

				$_POST['staffPhoto'] = '';

			}

			// Field validation
			include 'includes/classes/validateClass.php';

			$validate = new Validate();

			// Array for error/corrective messages
			$errorMessages = [];

			// Assume validation is ok
			$errorMessages['success'] = true;

			// Staff name
			if( $validate->checkRequired($_POST['staffName'])) {
				if(!$validate->checkName($_POST['staffName'])) {
					$errorMessages['staff-name-error'] = '* Letters only';
					$errorMessages['staff-error'] = 'Staff could not be added';
					$errorMessages['success'] = false;
				}
			} else {
				$errorMessages['staff-name-error'] = '* Required (Max 35 characters)';
				$errorMessages['staff-error'] = 'Staff could not be added';
				$errorMessages['success'] = false;
			}

			// Staff photo
			if(!$validate->checkRequired($_POST['staffPhoto'])) {
				$errorMessages['staff-photo-error'] = '* Required (Max 1MB)';
				$errorMessages['staff-error'] = 'Staff could not be added';
				$errorMessages['success'] = false;
			}

			// Staff bio
			if(!$validate->checkRequired($_POST['staffBio'])) {
				$errorMessages['staff-bio-error'] = '* Required (Max 400 characters)';
				$errorMessages['staff-error'] = 'Staff could not be added';
				$errorMessages['success'] = false;
			}

			// Did validation fail?
			if( $errorMessages['success'] == false ) {
				return $errorMessages;
			}

			// If validated, add pic
			$this->insertStaff();

			$uploadMessagesStaff['success'] = true;
			return $uploadMessagesStaff;

		}

		// Process news being uploaded
		public function processGetNewsUploadData() {
			$newsUploadData = $this->getNewsUploadData();
			return $newsUploadData;
		}

		// Process staff being uploaded
		public function processGetStaffUploadData() {
			$staffUploadData = $this->getStaffUploadData();
			return $staffUploadData;
		}

		// Process product being uploaded
		public function processGetProductUploadData() {
			$productUploadData = $this->getProductUploadData();
			return $productUploadData;
		}

		// Update a piece of news, after checking input for each field. 
		// If invalid or blank, show errors via array.
		public function processUpdateNews() {

			// Validation file
			include 'includes/classes/validateClass.php';

			// Validation class
			$validator = new Validate();

			// Array for error/corrective messages
			$updateResult = [];
			$updateResult['success'] = true;

			// News title
			if(strlen($_POST['title']) < 1) {
				$updateResult['title-error'] = 'Required (Min 1 character)';
				$updateResult['success'] = false;
			}

			// News description
			if(strlen($_POST['desc']) < 5) {
				$updateResult['desc-error'] = 'Required (5 - 250 characters)';
				$updateResult['success'] = false;
			}


			// If errors found during validation, send errors to view. Do not update  
			// until all errors have been addressed by user.
			// If no errors, then login and start session
			if($updateResult['success'] == false) {
				return $updateResult;
			} else {
				$resultOfUpdate = $this->updateNews();

				// If the update failed
				if( !$resultOfUpdate ) {
					$updateResult['success'] = false;
					$updateResult['title-error'] = 'No changes applied.';
				}
				return $updateResult;
			}
		}


		// Update staff, after checking input for each field. 
		// If invalid or blank, show errors via array.
		public function processUpdateStaff() {

			// Validation file
			include 'includes/classes/validateClass.php';

			// Validation class
			$validator = new Validate();

			// Array for error/corrective messages
			$updateResult = [];
			$updateResult['success'] = true;

			// Staff title
			if(strlen($_POST['name']) < 1) {
				$updateResult['name-error'] = 'Required (Min 1 character)';
				$updateResult['success'] = false;
			}

			// Staff description
			if(strlen($_POST['bio']) < 5) {
				$updateResult['bio-error'] = 'Required (5 - 400 characters)';
				$updateResult['success'] = false;
			}


			// If errors found during validation, send errors to view. Do not update  
			// until all errors have been addressed by user.
			// If no errors, then login and start session
			if($updateResult['success'] == false) {
				return $updateResult;
			} else {
				$resultOfUpdate = $this->updateStaff();

				// If the update failed
				if( !$resultOfUpdate ) {
					$updateResult['success'] = false;
					$updateResult['name-error'] = 'No changes applied.';
				}
				return $updateResult;
			}
		}


		// Update a product, after checking input for each field. 
		// If invalid or blank, show errors via array.
		public function processUpdateProduct() {

			// Validation file
			include 'includes/classes/validateClass.php';

			// Validation class
			$validator = new Validate();

			// Array for error/corrective messages
			$updateResult = [];
			$updateResult['success'] = true;

			// Product title
			if(strlen($_POST['name']) < 1) {
				$updateResult['name-error'] = 'Required (Min 1 character)';
				$updateResult['success'] = false;
			}

			// Product description
			if(strlen($_POST['price']) < 1) {
				$updateResult['price-error'] = 'If price varies, enter 0.00';
				$updateResult['success'] = false;
			}


			// If errors found during validation, send errors to view. Do not update  
			// until all errors have been addressed by user.
			// If no errors, then login and start session
			if($updateResult['success'] == false) {
				return $updateResult;
			} else {
				$resultOfUpdate = $this->updateProduct();

				// If the update failed
				if( !$resultOfUpdate ) {
					$updateResult['success'] = false;
					$updateResult['name-error'] = 'No changes applied.';
				}
				return $updateResult;
			}
		}


		// Delete a piece of news
		public function processDeletePiece() {
			return $this->deletePiece();
		}

		// Delete staff
		public function processDeleteStaff() {
			return $this->deleteStaff();
		}

		// Delete staff
		public function processDeleteProduct() {
			return $this->deleteProduct();
		}


	}