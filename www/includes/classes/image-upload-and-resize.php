<?php
	// Note: This file is necessary for uploading artwork. It resizes a given image
	// file to generate a thumbnail (the original file is not destroyed). If making 
	// any changes, please consider the uploading interface in account-view. Disregarding 
	// it may disrupt the functioning of this website.

class ImageUploadAndResize {

	// PROPERTIES FOR IMAGE
	private $image;
	private $name;
	private $tempName;
	private $type;
	private $size;
	private $extension;
	private $width;
	private $height;
	private $destinationFolder;

	// PROPERTIES FOR RESIZED IMAGE
	private $newWidth;
	private $newHeight;
	private $newImage;
	public $newName;

	// PROPERTIES FOR ALL IMAGE TYPES AND SIZES
	private $maxSize 	= 1000000; // 1MB
	private $imageMIMEs = ['image/bmp', 'image/gif', 'image/jpeg', 'image/png', 'image/tiff'];

	// PROPERTIES FOR UPLOAD AND RESIZE RESULTS
	public $result 	= false;
	public $message = '';

	// METHOD to prepare and upload image
	public function upload($fileFormName, $destinationFolder, $newWidth=0, $nameToUse='') {
		
		// Save image
		$this->image 	= $_FILES[$fileFormName];
		// Save destination folder
		$this->destinationFolder = $destinationFolder;
		// Save new width (if any)
		$this->newWidth = $newWidth;
		// Save image name
		$this->name 	= $this->image['name'];
		// Save temp name
		$this->tempName = $this->image['tmp_name'];
		// Save image type
		$this->type 	= $this->image['type'];
		// Save image size
		$this->size 	= $this->image['size'];
		// Save file extension into property
		$this->extension = pathinfo($this->name, PATHINFO_EXTENSION);

		// Save width / height
		$dimensions = getimagesize($this->tempName);
		$this->width = $dimensions[0];
		$this->height = $dimensions[1];

		// Generate unique name
		if($nameToUse == '') {
			$this->newName = uniqid().$this->name;
		} else {
			$this->newName = $nameToUse;
		}

		// If MIME not valid, then inform user
		if(!in_array($this->type, $this->imageMIMEs)) {
			$this->message = 'This file is not a valid image format';
			return;
		}

		// If file too large, then inform user
		if($this->size > $this->maxSize) {
			$this->message = 'Sorry. This file too large. Please choose an image that is less than 1MB in size';
			return;
		}
		
		// If large image width, resize. Else, move file to folder
		if($this->newWidth > 0) {
			$this->resize();
		} else {
			move_uploaded_file( $this->tempName, $this->destinationFolder.'/'.$this->newName );

			$this->result = true;
		}
	}

	// METHOD to resize image according to image type
	private function resize() {
		switch($this->type) {
			case 'image/jpeg':
				$originalImage = imagecreatefromjpeg($this->tempName);
			break;
			case 'image/png':
				$originalImage = imagecreatefrompng($this->tempName);
			break;
			case 'image/gif':
				$originalImage = imagecreatefromgif($this->tempName);
			break;
			default:
				die('FILE CANNOT BE RESIZED');
			break;
		}

		// Determine new height
		$this->newHeight = ($this->height / $this->width) * $this->newWidth;

		// Create new image
		$this->newImage = imagecreatetruecolor($this->newWidth, $this->newHeight);

		// Resample original image into new image
		imagecopyresampled($this->newImage, $originalImage, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);

		// Switch based on image being resized
		switch($this->type) {
			case 'image/jpeg':
				// Source, Dest, Quality 0 to 100
				imagejpeg($this->newImage, $this->destinationFolder.'/'.$this->newName, 80);
			break;
			case 'image/png':
				// Source, Dest, Quality 0 (no compression) to 9
				imagepng($this->newImage, $this->destinationFolder.'/'.$this->newName, 0);
			break;
			case 'image/gif':
				imagegif($this->newImage, $this->destinationFolder.'/'.$this->newName);
			break;
			default:
				die('YOUR FILE CANNOT BE RESIZED');
			break;
		}

		// DESTROY NEW IMAGE TO SAVE SERVER SPACE
		imagedestroy($this->newImage);
		imagedestroy($originalImage);

		// SUCCESSFULLY UPLOADED
		$this->result = true;
		$this->message = 'Image uploaded and resized successfully';
	}
}