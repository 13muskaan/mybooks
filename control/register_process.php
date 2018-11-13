<?php
// Include files.
include( '../model/dbconnection.php' );
include( 'user_manage.php' );
include( 'testInput.php' );

// Start session.
session_start();

// Check user role. Admin privilege has role of 1 and normal user has role of 2.
if ( !isset( $_SESSION[ 'role' ] ) || $_SESSION[ 'role' ] == 1 ) {
	header( 'location:../view/pages/register.php' );
}

// SANTISE FORM INPUTS
$email = SanitiseData( $_POST[ 'email' ] );
$password = SanitiseData( $_POST[ 'pass' ] );
$firstname = SanitiseData( $_POST[ 'firstname' ] );
$lastname = SanitiseData( $_POST[ 'lastname' ] );
$role = SanitiseData( $_POST[ 'role' ] );

// SHOW ERROR
$_SESSION[ 'error' ] = "";

// VALIDATION OF FORM INPUTS
if ( empty( $email ) || empty( $password ) || empty( $firstname ) || empty( $lastname ) ) {
	$_SESSION[ 'error' ] = "Please fill in all the input fields.";
} else {

	echo "<br>";
	echo $email . " | " . $password . " | " . $firstname . " | " . $lastname;

	$firstname_check = preg_match( '~^[A-Za-z\-]{3,20}$~i', $firstname );
	if ( !$firstname_check ) {
		$_SESSION[ 'error' ] = $_SESSION[ 'error' ] . "\n<hr>First Name is not formatted correctly, Make sure there is:\n-at least three characters\n-No numbers\n-No symbols (except hyphen '-')";
	}

	$lastname_check = preg_match( '~^[A-Za-z\-]{3,20}$~i', $lastname );
	if ( !$lastname_check ) {
		$_SESSION[ 'error' ] = $_SESSION[ 'error' ] . "\n<hr>Last Name is not formatted correctly, Make sure there is:\n-at least three characters\n-No numbers\n-No symbols (except hyphen '-')";
	}

	$email_check = preg_match( '~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email );
	if ( !$email_check ) {
		$_SESSION[ 'error' ] = $_SESSION[ 'error' ] . "\n<hr>Email is not formatted correctly, Make sure there is:\n- @ in the email \n- A mail-to address eg. (domain).com";
	}

	$emailSQL = "SELECT * FROM login WHERE email = :email";
	$stmt = $conn->prepare( $emailSQL );
	$stmt->bindParam( ':email', $email, PDO::PARAM_STR );

	try {
		$stmt->execute();
	} catch ( PDOException $e ) {
		echo $e;
	}

	// Email already exists in the database.
	if ( $stmt->rowcount() > 0 ) {
		$_SESSION[ 'error' ] = "<hr>This email is already registered.";
	}

	echo "<hr>Session error: " . $_SESSION[ 'error' ] . "<hr>";

	if ( $_SESSION[ 'error' ] == "" ) {

		// HASH PASSWORD
		$hash = password_hash( $password, PASSWORD_DEFAULT );

		// Message of user creation.

		if ( newUser( $conn, $email, $hash, $role, $firstname, $lastname ) ) {

			// Success.
			$_SESSION[ 'message' ] = 'User successfully created! Welcome ' . $_POST[ 'firstname' ] . " User can now login using their user cresidentials.";
			header( 'location:../view/pages/viewbooks.php' );
		} else {
			// fail
			$_SESSION[ 'error' ] = 'database error - failed to insert user registration data';
		}
	} else {
		header( 'location:../view/pages/register.php' );
	}
}
?>