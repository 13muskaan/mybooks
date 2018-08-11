<?php
include( '../model/dbconnection.php' );
//include('session.php');
session_start();

$email = $_POST[ 'email' ];
$password = $_POST[ 'pass' ];
$firstname = $_POST[ 'firstname' ];
$lastname = $_POST[ 'lastname' ];

$_SESSION[ 'error' ] = "";

//Hash password
$hash = password_hash( $password, PASSWORD_DEFAULT );


if ( empty( $email ) || empty( $password ) || empty( $firstname ) || empty( $lastname ) ) {
	$_SESSION[ 'error' ] = "Please fill in all the input fields.";
} else {

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

	$emailSQL = "SELECT * FROM users WHERE email = :email";

	$stmt = $conn->prepare( $emailSQL );
	$stmt->bindParam( ':email', $email, PDO::PARAM_STR );
	$stmt->execute();

	if ( $stmt->rowcount() > 0 ) {
		$_SESSION[ 'error' ] = "<hr>This email is already registered.";
	}

	if ( $_SESSION[ 'error' ] == "" ) {

		$register_sql = "INSERT INTO users (email, password, firstname, lastname ) VALUES (:email, :password, :firstname, :lastname)";

		$stmt = $conn->prepare( $register_sql );

		//bindparam
		$stmt->bindParam( ':email', $email, PDO::PARAM_STR );
		$stmt->bindParam( ':firstname', $firstname, PDO::PARAM_STR );
		$stmt->bindParam( ':lastname', $lastname, PDO::PARAM_STR );
		$stmt->bindParam( ':password', $hash, PDO::PARAM_STR );

		$stmt->execute();

		if ( $conn->lastInsertId() > 0 ) {
			$_SESSION[ 'message' ] = 'user successfully created! Welcome ' . $_POST[ 'firstname' ] . "";
			$_SESSION[ 'userID' ] = $conn->lastInsertId();
			$_SESSION[ 'firstname' ] = $_POST[ 'firstname' ];
			$_SESSION[ 'lastEmail' ] = $_POST[ 'email' ];
			// This code is to create other users with limited privileges
			$_SESSION[ 'role' ] = 2;
			$_SESSION[ 'login_time' ] = time();
			header( 'location:../view/pages/viewbooks.php' );
		} else {
			$_SESSION[ 'error' ] = 'database error - failed to insert user registration data';
		}
	} else {
		header( 'location:../view/pages/register.php' );
	}
}
?>