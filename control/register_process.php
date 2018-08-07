<?php
Include('../model/dbconnection.php');
// include('session.php');

$email = $_POST[ 'email' ];
$password = $_POST[ 'pass' ];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$message = "";

//Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// or 
// $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

if ( empty( $email ) || empty( $password ) ) {
	$message = "all inputs must be filled";
} else {
	$register_sql = "INSERT INTO users (email, password, firstname, lastname ) VALUES (:email, :password :firstname, :lastname)";

	$stmt = $conn->prepare( $register_sql );
	
	//bindparam
	$stmt->bindParam( ':email', $email, PDO::PARAM_STR );
	$stmt->bindParam( ':firstname', $firstname, PDO::PARAM_STR );
	$stmt->bindParam( ':lastname', $lastname, PDO::PARAM_STR );
	//$stmt->bindParam( ':password', $hash, PDO::PARAM_STR );
	
	$stmt->execute();
	
	if ($conn->lastInsertId() > 0){
		$_SESSION['message'] = 'user successfully created! Welcome ' . $_POST['firstname'] . "";
		$_SESSION['userID'] = $conn->lastInsertId();
		$_SESSION['firstname'] = $_POST['firstname'];
		$_SESSION['lastEmail'] = $_POST['email'];
		// This code is to create other users with limited privileges
		$_SESSION['role'] = 2;
		$_SESSION['login_time'] = time ();
		header('location:../../pages/viewbooks.php');
	}
	else{
		$_SESSION['error'] = 'database error - failed to insert user registration data';
		echo 'error in submitting your registration, please try again';
	}
}
?>
