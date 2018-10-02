<?php
include( '../model/dbconnection.php' );
//include('session.php');
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] == 1) {
	header ('location:../view/pages/register.php');
}

$email = $_POST[ 'email' ];
$password = $_POST[ 'pass' ];
$firstname = $_POST[ 'firstname' ];
$lastname = $_POST[ 'lastname' ];
$role = $_POST['role'];

$_SESSION[ 'error' ] = "";

//Hash password
$hash = password_hash( $password, PASSWORD_DEFAULT );

if ( empty( $email ) || empty( $password ) || empty( $firstname ) || empty( $lastname ) ) {
	$_SESSION[ 'error' ] = "Please fill in all the input fields.";
} else {

	echo "<br>";
	echo $email . " | " . $password . " | " . $firstname . " | " . $lastname;
	
	$firstname_check = preg_match( '~^[A-Za-z\-]{3,20}$~i', $firstname );
	if ( !$firstname_check ) {
		$_SESSION[ 'error' ] .= "\n<hr>First Name is not formatted correctly, Make sure there is:\n-at least three characters\n-No numbers\n-No symbols (except hyphen '-')";
	}

	$lastname_check = preg_match( '~^[A-Za-z\-]{3,20}$~i', $lastname );
	if ( !$lastname_check ) {
		$_SESSION[ 'error' ] .= "\n<hr>Last Name is not formatted correctly, Make sure there is:\n-at least three characters\n-No numbers\n-No symbols (except hyphen '-')";
	}

	$email_check = preg_match( '~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email );
	if ( !$email_check ) {
		$_SESSION[ 'error' ] .= "\n<hr> Email is not formatted correctly, Make sure there is:\n- @ in the email \n- A mail-to address eg. (domain).com";
	}

	$emailSQL = "SELECT * FROM login WHERE email = :email";
	$stmt = $conn->prepare( $emailSQL );
	$stmt->bindParam( ':email', $email, PDO::PARAM_STR );
	
	try {
		$stmt->execute();
	} catch (PDOException $e) {
		echo $e;
	}

	
	
	if ( $stmt->rowcount() > 0 ) {
		$_SESSION[ 'error' ] = "<hr>This email is already registered.";
	}

	echo "<hr>Session error: " . $_SESSION['error'] . "<hr>";
	
	if ( $_SESSION[ 'error' ] == "" ) {
		
		
		if ( newUser($conn, $email, $hash, $role, $firstname, $lastname) ) {
			$_SESSION[ 'message' ] = 'user successfully created! Welcome ' . $_POST[ 'firstname' ] . "";
			header( 'location:../view/pages/viewbooks.php' );
		} else {
			$_SESSION[ 'error' ] = 'database error - failed to insert user registration data';
		}
	} else {
		header( 'location:../view/pages/register.php' );
	}
}
?>