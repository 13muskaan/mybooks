<?php

// Code to show message to user (e.g. login, add new book and so on.) using $_SESSION.

// Show Error message to user.
if ( isset( $_SESSION[ 'error' ] ) ) {
	if ( $_SESSION[ 'error' ] != "" ) {
		echo '<div class="alert alert-danger"><strong>ERROR: </strong>' . $_SESSION[ 'error' ] . '</div>';
		$_SESSION[ 'error' ] = "";
	}
}
// Show Message to user.
if ( isset( $_SESSION[ 'message' ] ) ) {
	if ( $_SESSION[ 'message' ] != "" ) {
		echo '<div class="alert alert-success">' . $_SESSION[ 'message' ] . '</div>';
		$_SESSION[ 'message' ] = "";
	}
}
?>