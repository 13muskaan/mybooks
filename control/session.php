<?php

 session_start();

include('../model/dbconnection.php');

function PageProtector ($whoCanAccess) {
	
	foreach ($whoCanAccess as $i) {
		if ($i == $_SESSION['role']) {
			return true;
		}
	}
	
	return false;
}

function Redirect() {
	if ($_SESSION['role'] == 2 || $_SESSION['role'] == 1) {
		$_SESSION['error'] = "You cannot view that page.";
		header("location: viewbooks.php");
	} else{
		$_SESSION['error'] = "Please log in.";
		header("location: login.php");
	}
}

if (isset($whoCanAccess)) {
	if (!PageProtector($whoCanAccess)) {
		Redirect();
	}
}
/*// error messages
if (isset($_SESSION['Login']) == true) {
 if ($_GET['role'] == '1') {
 	client_portal();
 } else if ($_GET['role'] == '2'){ 		
    Admin_portal();   
 }
 } else {
	session_destroy();
 	header('location:../view/html/login.php');
 }
  function client_portal(){
 	header('location:../view/html/user.php');
 }
 function Admin_portal(){
 	header('location:../view/html/admin.php');
 }*/
?>