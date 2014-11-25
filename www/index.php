<?php
	// Note: This file is necessary for generating each webpage. It interacts with the page views,
	// model and database files. If making any changes, please consider these other files as 
	// important locations. Disregarding them may disrupt the functioning of this website. 

	// Start session
	session_start();

	// Required for running website
	require '../config.php';
	require 'includes/models/database.php';
	require 'includes/models/model.php';
	require 'includes/views/view.php';

	// If page requested, send user there. Else, go to homepage by default
	if(isset($_GET['page'])) {
		$requestedPage = $_GET['page'];
	} else {
		$requestedPage = 'home';
	}

	// Instance of model
	$model = new Model();

	// Get page data
	$pageData = $model->processGetPageData($requestedPage);

	// Switch for requested pages with necessary files for generating them
	switch($requestedPage) {
		case 'home':
			include 'includes/views/home-view.php';
			$page = new HomeView($pageData);
		break;

		case 'news':
			include 'includes/views/news-view.php';
			$page = new NewsView($pageData, $model);
		break;

		case 'learn':
			include 'includes/views/learn-view.php';
			$page = new LearnView($pageData);
		break;

		case 'team':
			include 'includes/views/team-view.php';
			$page = new TeamView($pageData, $model);
		break;

		case 'prices':
			include 'includes/views/price-view.php';
			$page = new PriceView($pageData, $model);
		break;

		case 'contact':
			include 'includes/views/contact-view.php';
			$page = new ContactView($pageData);
		break;

		case 'login':
			include 'includes/views/login-view.php';
			$page = new LoginView($pageData, $model);
		break;

		case 'admin':
			include 'includes/views/account-view.php';
			$page = new AccountView($pageData, $model);
		break;

		case 'logout':
			include 'includes/views/logout-view.php';
			$page = new LogoutView($pageData, $model);
		break;

		case 'access':
			include 'includes/views/access-view.php';
			$page = new AccessView($pageData);
		break;

		case 'newsSuccess':
			include 'includes/views/success-view.php';
			$page = new SuccessView($pageData);
		break;

		case 'editNews':
			include 'includes/views/edit-news-view.php';
			$page = new EditPieceView($pageData, $model);
		break;

		case 'deleteNews':
			include 'includes/views/delete-news-view.php';
			$page = new DeletePieceView($pageData, $model);
		break;

		case 'editStaff':
			include 'includes/views/edit-staff-view.php';
			$page = new EditStaffView($pageData, $model);
		break;

		case 'deleteStaff':
			include 'includes/views/delete-staff-view.php';
			$page = new DeleteStaffView($pageData, $model);
		break;

		case 'editProd':
			include 'includes/views/edit-product-view.php';
			$page = new EditProductView($pageData, $model);
		break;

		case 'deleteProd':
			include 'includes/views/delete-product-view.php';
			$page = new DeleteProductView($pageData, $model);
		break;

		default:
			include 'includes/views/error-404-view.php';
			$page = new Error404View($pageData);
		break;
	}

	// Render each page view
	$page->render();