<?php
	// Essential for rendering every page
	abstract class View {

		// Properties
		public $pgDescription;
		public $pgTitle;
		public $pgHeading;
		public $subHeading;
		public $pgAccess;
		public $model;

		// Constructor
		public function __construct($pageData, $model='') {
			$this->pgDescription 	 = $pageData['meta_desc'];
			$this->pgTitle 			 = $pageData['page_title'];
			$this->pgHeading		 = $pageData['page_heading'];
			$this->subHeading		 = $pageData['sub_heading'];
			$this->pgAccess			 = $pageData['access_restriction'];
			$this->model 			 = $model;
		}

		// Render each page view
		public function render() {

			include 'templates/html-header-template.php';

			echo "<div id='feature'>";
				echo "<h1>$this->pgHeading</h1>";

				if( $this->subHeading != '' ) {
					echo "<h2>$this->subHeading</h2>";
				}

				echo "<hr/>";
			echo "</div>";

			$this->content();

			include 'templates/html-footer-template.php';
		}

		// Class extending 'view' must have content method inside
		abstract public function content();
	}