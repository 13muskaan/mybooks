<?php

function uploadCover( $file, $BookID ) {
	$control_relocate = "../view/";
	$target_dir = "img/bookcovers/";
	$target_file = basename( $file[ "name" ] );
	$uploadOk = 1;
	$imageFileType = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );
	$target_file = $control_relocate . $target_dir . $BookID . "." . $imageFileType;
	// Check if image file is a actual image or fake image
	if ( isset( $_POST[ "submit" ] ) ) {
		$check = getimagesize( $file[ "tmp_name" ] );
		if ( $check !== false ) {
			$uploadOk = 1;
		} else {
			$_SESSION[ 'error' ] = "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if ( file_exists( $target_file ) ) {
		unlink($target_file);
	}
	// Check file size
	if ( $file[ "size" ] > 500000 ) {
		$_SESSION[ 'error' ] = "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if ( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
		$_SESSION[ 'error' ] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ( $uploadOk == 0 ) {
		$_SESSION[ 'error' ] = "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
		if ( move_uploaded_file( $file[ "tmp_name" ], $target_file ) ) {} else {
			$_SESSION[ 'error' ] = "Sorry, there was an error uploading your file.";
		}
	}

	$target_file = $target_dir . $BookID . "." . $imageFileType;
	return $target_file;
}
?>