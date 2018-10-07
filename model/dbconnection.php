<?php
$servername = "localhost";
$username = "root";
$password = "root"; // Use this for Mac (MAMP)
//$password=""; // Use this for Windows (XAMPP)


// connection to database

try {
	$conn = new PDO( "mysql:host=$servername;dbname=mybooks", $username, $password );
	// set the PDO error mode to exception
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( PDOException $e ) {
	echo "Connection failed: " . $e->getMessage();
}

// 
function NewUser( $conn, $email, $passwordhash, $role, $firstname, $lastname ) {
	try {
		$conn->beginTransaction();
		$stmt = $conn->prepare( "INSERT INTO login (email, password, role) VALUES (:email, :password, :role)" );

		$stmt->bindParam( ':email', $email, PDO::PARAM_STR );
		$stmt->bindParam( ':password', $passwordhash, PDO::PARAM_STR );
		$stmt->bindParam( ':role', $role, PDO::PARAM_INT );

		$stmt->execute();

		$lastloginID = $conn->lastInsertId();
		$stmt = $conn->prepare( "INSERT INTO users (loginID, firstname, lastname) VALUES (:loginID, :firstname, :lastname)" );

		$stmt->bindParam( ':firstname', $firstname, PDO::PARAM_STR );
		$stmt->bindParam( ':lastname', $lastname, PDO::PARAM_STR );
		$stmt->bindValue( ':loginID', $lastloginID );

		$stmt->execute();

		$conn->commit();

		return true;

	} catch ( PDOException $e ) {
		$conn->rollBack();
		echo "<hr>ERROR: PDOException<hr>" . $e . "<hr>";

		return false;
	}
}
?>