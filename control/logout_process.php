<?php

// Destroy session 

include( 'session.php' );

session_destroy();

session_start();

// Echo message
$_SESSION[ 'message' ] = "Logged out successfully";

// Redirect to login page
header( "location: ../view/pages/login.php" );
?>