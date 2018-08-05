<?php

 session_start();

//include('../model/dbconnection.php');



// create

?>

<?php
// redirect
?>


<?php 

//destroy
session_start();
session_destroy();
header("location: login.php");

?>

<?php

// error messages
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
 }
?>