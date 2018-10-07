<?php
include( 'session.php' );
session_destroy();

$_SESSION[ 'message' ] = "Logged out successfully";
header( "location: ../view/pages/login.php" );
?>