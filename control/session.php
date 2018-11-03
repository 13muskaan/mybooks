<?php

session_start();

// Page protection

function PageProtector( $whoCanAccess ) {
	foreach ( $whoCanAccess as $i ) {
		if ( isset( $_SESSION[ 'role' ] ) ) {
			if ( $i == $_SESSION[ 'role' ] ) {
				return true;
			}
		} else {
			if ( $i == 0 ) {
				return true;
			}
		}
	}

	return false;
}

// Redirection of user depending on user role. 

function Redirect() {
	if ( isset( $_SESSION[ 'role' ] ) ) {
		if ( $_SESSION[ 'role' ] == 2 || $_SESSION[ 'role' ] == 1 ) {
			$_SESSION[ 'error' ] = "You cannot view that page.";
			header( "location: viewbooks.php" );
		}
	} else {
		$_SESSION[ 'error' ] = "Please log in.";
		header( "location: login.php" );
	}
}

if ( isset( $whoCanAccess ) ) {
	if ( !PageProtector( $whoCanAccess ) ) {
		Redirect();
	}
}
?>