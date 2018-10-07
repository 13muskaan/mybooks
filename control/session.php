<?php

session_start();

include( '../model/dbconnection.php' );

function PageProtector( $whoCanAccess ) {

	foreach ( $whoCanAccess as $i ) {
		if ( $i == $_SESSION[ 'role' ] ) {
			return true;
		}
	}

	return false;
}

function Redirect() {
	if ( $_SESSION[ 'role' ] == 2 || $_SESSION[ 'role' ] == 1 ) {
		$_SESSION[ 'error' ] = "You cannot view that page.";
		header( "location: viewbooks.php" );
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