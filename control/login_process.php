<?php
include '../model/dbconnection.php';
//include '../session.php';

session_start();
$email = $_POST[ 'email' ];
$password = $_POST[ 'pass' ];
$message = "";

//When registering, store password in SQL Statement as $hash instead of $password:
$hash = password_hash( $password, PASSWORD_DEFAULT );

if ( empty( $email ) || empty( $password ) ) {
	$message = "username and password can't be empty";
} else {
	$login_sql = "SELECT * FROM login WHERE email = :email";

	$stmt = $conn->prepare( $login_sql );

	//bindparam
	$stmt->bindParam( ':email', $email, PDO::PARAM_STR );


	$stmt->execute();
	//$result = $stmt->fetchAll();

	if ( $stmt->rowcount() == 0 ) {
		$_SESSION[ 'error' ] = "Email doesn't exist";
		header( 'Location: ../view/pages/login.php' );
	} else {
		$result = $stmt->fetch();
		if ( password_verify( $password, $result[ 'password' ] ) ) {
			
			
			$_SESSION[ 'role' ] = $result[ 'role' ];
			
			$user_sql = "SELECT * FROM users WHERE loginID = " . $result['loginID'];
			
			$stmt = $conn->prepare($user_sql);
			$stmt->execute();
			$result = $stmt->fetch();
			
			$_SESSION[ 'userID' ] = $result[ 'userID' ];
			
			
			$_SESSION[ 'message' ] = "Login successful";
			header( 'Location: ../view/pages/viewbooks.php' );
		} else {
			$_SESSION[ 'error' ] = "Password Mismatch";
			header( 'Location: ../view/pages/login.php' );
		}

	}
}
?>