<?php
// Code to connect to the database.

// Provide connection details in order to connect to the database.

$servername = "localhost";
$username = "root";
$password = "root"; // Use this code when using MacOs (MAMP)
//$password= ""; // Use this code when using Windows (XAMPP)

// try & catch statement.

// Begin connection to the database.

try {
	$conn = new PDO( "mysql:host=$servername;dbname=mybooks", $username, $password );

	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	// Set the PDO error mode to exception.

} catch ( PDOException $e ) {

	// Echo error.
	echo "Connection failed: " . $e->getMessage();
	die();
}
?>