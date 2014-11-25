<?php
	// Note: This file is necessary for a majority of files. It processes content for many of the
	// pages. This file interacts with the model, index, database and views. If making any changes, 
	// please consider these other files. Disregarding them may disrupt the functioning of this website.

	// All methods that relate to general website functionality follow:

	abstract class Database {

		// Connect to DATABASE and save. If unable to connect, then do not execute website
		private $dbc; 
		public function __construct() {
			$this->dbc = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			if( mysqli_connect_errno() ) {
				die('<h2>Database Error</h2> <p>Unable to connect to database.</p>');
			}
		}

		// Get info for generating WEB-PAGES. If a page does not exist, then show 404 error
		protected function getPageData($requestedPage) {
			$sql = "SELECT meta_desc, page_title, page_heading, sub_heading, access_restriction
					FROM s_pages
					WHERE page_name = '$requestedPage'";

			$resultFromDatabase = $this->dbc->query($sql);

			if(!$resultFromDatabase || $resultFromDatabase->num_rows == 0) {
				$sql = "SELECT meta_desc, page_title, page_heading, sub_heading, access_restriction
									FROM s_pages
									WHERE page_name = 'error'";
				$resultFromDatabase = $this->dbc->query($sql);
			}
			$pageData = $resultFromDatabase->fetch_assoc();
			return $pageData;
		}

		// Retrieve NEWS from database. If unable to get news, inform.
		protected function getAllNews() {
			$sql = "SELECT news_ID, news_title, news_date, news_photo, news_desc 
					FROM s_news
					ORDER BY news_date DESC";

			$result = $this->dbc->query($sql);

			if(!$result) {
				die('Unable to retrieve news');
			}
			return $result;
		}

		// Retrieve PRODUCTS and PRICES from database. If unable to, inform.
		protected function getAllProductData() {
			$sql = "SELECT product_name, product_price, category, s_products.product_ID
					FROM s_products
					JOIN s_cat_prods
					ON s_products.product_ID = s_cat_prods.product_ID
					JOIN s_categories
					ON s_categories.cat_ID = s_cat_prods.cat_ID
					ORDER BY s_categories.cat_ID ASC";

			$result = $this->dbc->query($sql);

			if(!$result) {
				die('Unable to retrieve services, products and prices');
			}
			return $result;
		}

		// Retrieve STAFF from database. If unable to, inform.
		protected function getAllStaff() {
			$sql = "SELECT staff_ID, staff_name, staff_photo, staff_desc 
					FROM s_staff";

			$result = $this->dbc->query($sql);

			if(!$result) {
				die('Unable to retrieve information about staff');
			}
			return $result;
		}

		// LOGIN after processing input and comparing username + password in database
		protected function attemptLogin() {
			$username = $this->dbc->real_escape_string($_POST['username']);

			$sql = "SELECT user_ID, user_username, user_password, user_access
					FROM s_users
					WHERE user_username = '$username'";

			$userData = $this->dbc->query($sql);

			if(!$userData || $userData->num_rows == 0) {
				return false;
			}

			$userData = $userData->fetch_assoc();

			// Hash password
			include 'includes/lib/password.php';

			if(password_verify($_POST['password'], $userData['user_password'])) {
				return $userData;
			} else {
				return false;
			}
		}

		// Get user data for admin controls
		protected function getUserData() {
			$userID = $_SESSION['user_ID'];

			$sql = "SELECT user_username, user_access
					FROM s_users
					WHERE user_ID = $userID";

			$result = $this->dbc->query($sql);
			$userData = $result->fetch_assoc();
			return $userData;
		}

		// Store uploaded NEWS into database after processing input 
		protected function insertNews() {

			$title = $this->dbc->real_escape_string($_POST['title']);
			$newsPhoto = $this->dbc->real_escape_string($_POST['newsPhoto']);
			$desc = $this->dbc->real_escape_string($_POST['desc']);

			$sql = "INSERT INTO s_news (news_ID, news_title, news_photo, news_desc) 
					VALUES (NULL, '$title', '$newsPhoto', '$desc')";

			$this->dbc->query($sql);
		}

		// HOW DO YOU ADD A PRODUCT WHEN DATA NEEDS TO GO INTO THE INTERMEDIATE TABLE TOO?
		protected function insertProduct() {

			$name = $this->dbc->real_escape_string($_POST['productName']);
			$price = $this->dbc->real_escape_string($_POST['productPrice']);
			$category = $this->dbc->real_escape_string($_POST['category']);

			// print_r($name);
			// print_r($price);
			// print_r($category);
			// die();

			$sql = "INSERT INTO s_products (product_ID, product_name, product_price) 
					VALUES (NULL, '$name', '$price')";

			$this->dbc->query($sql);

			$newID = $this->dbc->insert_id;

			 $sql = "INSERT INTO s_cat_prods (catprod_ID, cat_ID, product_ID) 
			 		VALUES (NULL, '$category', '$newID')";

			 $this->dbc->query($sql);

		}


		// Store uploaded NEWS into database after processing input 
		protected function insertStaff() {

			$name = $this->dbc->real_escape_string($_POST['staffName']);
			$staffPhoto = $this->dbc->real_escape_string($_POST['staffPhoto']);
			$staffBio = $this->dbc->real_escape_string($_POST['staffBio']);

			// print_r($name);
			// print_r($staffPhoto);
			// print_r($staffBio);
			// die;

			$sql = "INSERT INTO s_staff (staff_ID, staff_name, staff_photo, staff_desc) 
					VALUES (NULL, '$name', '$staffPhoto', '$staffBio')";

			$this->dbc->query($sql);
		}


		// Retrieve a news snippet after processing input.
		protected function getNewsUploadData() {
			$newsID = $this->dbc->real_escape_string($_GET['news_ID']);

			$sql = "SELECT news_title, news_photo, news_desc
					FROM s_news
					WHERE news_ID = $newsID ";

			$newsID = $this->dbc->query($sql);

			if(!$newsID || $newsID->num_rows == 0) {
				die('Could not get any details for this news snippet. It does not exist!');
			}

			$newsID = $newsID->fetch_assoc();
			return $newsID;
		}


		// Retrieve a news snippet after processing input.
		protected function getStaffUploadData() {
			$staffID = $this->dbc->real_escape_string($_GET['staff_ID']);

			$sql = "SELECT staff_name, staff_photo, staff_desc
					FROM s_staff
					WHERE staff_ID = $staffID ";

			$staffID = $this->dbc->query($sql);

			if(!$staffID || $staffID->num_rows == 0) {
				die('Could not get any details about this staff member.');
			}

			$staffID = $staffID->fetch_assoc();
			return $staffID;
		}

		protected function getUserPassword() {

			// Logged in users ID
			$userID = $_SESSION['user_ID'];

			// Prepare the SQL
			$sql = "SELECT user_password FROM s_users WHERE user_ID = $userID";

			// Run the SQL
			$result = $this->dbc->query($sql);

			// Convert into an assoc
			$password = $result->fetch_assoc();

			// Return back to the model
			return $password;

		}

		protected function updatePassword() {

			// Logged in users ID
			$userID = $_SESSION['user_ID'];

			// Hash the new password
			require_once 'includes/lib/password.php';

			$hash = password_hash($_POST['new-password'], PASSWORD_BCRYPT);

			// Prepare SQL
			$sql = "UPDATE s_users SET user_password = '$hash' WHERE user_ID = $userID";

			// Run the SQL
			$this->dbc->query($sql);

		}


		// TESTING
		protected function getAllCategories() {
			// SQL
			$sql = "SELECT cat_ID, category 
					FROM s_categories";

			// Run SQL
			$result = $this->dbc->query($sql);
			// Was there no result?
			if( !$result || $result->num_rows == 0 ) { 
				return false;
			}
			// Return data
			return $result;
		}



		// TEST
		// Retrieve a news snippet after processing input.
		protected function getProductUploadData() {
			$productID = $this->dbc->real_escape_string($_GET['product_ID']);

			$sql = "SELECT product_name, product_price
					FROM s_products
					WHERE product_ID = $productID ";

			$productID = $this->dbc->query($sql);

			if(!$productID || $productID->num_rows == 0) {
				die('Could not get any details about this product.');
			}

			$productID = $productID->fetch_assoc();
			return $productID;
		}




		// Update a news snippet after processing input
		protected function updateNews() {
			$title = $this->dbc->real_escape_string( $_POST['title'] );
			$desc = $this->dbc->real_escape_string( $_POST['desc'] );
			$newsID = $this->dbc->real_escape_string( $_GET['news_ID'] );

			if($_SESSION['user_access'] == 'admin') {

			$sql = "UPDATE s_news
					SET news_title = '$title',
						news_desc = '$desc',
						news_date = CURRENT_TIMESTAMP
					WHERE news_ID = $newsID";

			} else {
				die('You are not authorized to make changes.');
				
			}

			$this->dbc->query($sql);

			if ($this->dbc->affected_rows == 0) {
				return false;
			} else {
				return true;
			}
		}


		// Update a news snippet after processing input
		protected function updateStaff() {
			$name = $this->dbc->real_escape_string( $_POST['name'] );
			$bio = $this->dbc->real_escape_string( $_POST['bio'] );
			$staffID = $this->dbc->real_escape_string( $_GET['staff_ID'] );

			if($_SESSION['user_access'] == 'admin') {

			$sql = "UPDATE s_staff
					SET staff_name = '$name',
						staff_desc = '$bio'
					WHERE staff_ID = $staffID";

			} else {
				die('You are not authorized to make changes.');
				
			}

			$this->dbc->query($sql);

			if ($this->dbc->affected_rows == 0) {
				return false;
			} else {
				return true;
			}
		}

		// TEST
		// Update a product after processing input
		protected function updateProduct() {
			$name = $this->dbc->real_escape_string( $_POST['name'] );
			$price = $this->dbc->real_escape_string( $_POST['price'] );
			$productID = $this->dbc->real_escape_string( $_GET['product_ID'] );

			if($_SESSION['user_access'] == 'admin') {

			$sql = "UPDATE s_products
					SET product_name = '$name',
						product_price = '$price'
					WHERE product_ID = $productID";

			} else {
				die('You are not authorized to make changes.');
				
			}

			$this->dbc->query($sql);

			if ($this->dbc->affected_rows == 0) {
				return false;
			} else {
				return true;
			}
		}




		// Delete a news snippet and also delete assoicated image IF one exists
		protected function deletePiece() {
			$newsID = $this->dbc->real_escape_string($_GET['news_ID']);

			$sql= "SELECT news_photo
					FROM s_news
					WHERE news_ID = $newsID";

			$imgData = $this->dbc->query($sql);
			$imgData = $imgData->fetch_assoc();
			$imgName = $imgData['news_photo'];

			if($_SESSION['user_access'] == 'admin') {

				$sql = "DELETE 
						FROM s_news 
						WHERE news_ID = $newsID";

				$this->dbc->query($sql);


				if ($imgName !="") {
					unlink("images/news/".$imgName);
				}

			} else {

				die('You are not authorized to delete any content.');
			}

			// Did this work?
			if( $this->dbc->affected_rows > 0 ) {
				return true;
			} else {
				return false;
			}
		}


		// Delete a news snippet and also delete assoicated image IF one exists
		protected function deleteStaff() {
			$staffID = $this->dbc->real_escape_string($_GET['staff_ID']);

			$sql= "SELECT staff_photo
					FROM s_staff
					WHERE staff_ID = $staffID";

			$imgData = $this->dbc->query($sql);
			$imgData = $imgData->fetch_assoc();
			$imgName = $imgData['staff_photo'];

			if($_SESSION['user_access'] == 'admin') {

				$sql = "DELETE 
						FROM s_staff 
						WHERE staff_ID = $staffID";

				$this->dbc->query($sql);


				if ($imgName !="") {
					unlink("images/staff/".$imgName);
				}

			} else {

				die('You are not authorized to delete any content.');
			}

			// Did this work?
			if( $this->dbc->affected_rows > 0 ) {
				return true;
			} else {
				return false;
			}
		}



		// Delete a news snippet and also delete assoicated image IF one exists
		protected function deleteProduct() {
			$productID = $this->dbc->real_escape_string($_GET['product_ID']);

			if($_SESSION['user_access'] == 'admin') {

				$sql = "DELETE 
						FROM s_products 
						WHERE product_ID = $productID";

				$this->dbc->query($sql);


			} else {

				die('You are not authorized to delete any content.');
			}

			// Did this work?
			if( $this->dbc->affected_rows > 0 ) {
				return true;
			} else {
				return false;
			}
		}

	}