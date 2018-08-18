<?php
$servername = "localhost";
$username = "root";
$password = "root"; // Use this for Mac (MAMP)
//$password=""; // Use this for Windows (XAMPP)

try {
    $conn = new PDO("mysql:host=$servername;dbname=mybooks", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>