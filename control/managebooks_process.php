<?php
include( '../model/dbconnection.php' );

// INSERT BOOKS

try {

    $insertsql = "INSERT INTO MyGuests (firstname, lastname, email)
    VALUES ('John', 'Doe', 'john@example.com')";
    // use exec() because no results are returned
    $conn->exec($insertsql);
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo $insertsql . "<br>" . $e->getMessage();
    }

$conn = null;

header( 'location:../view/pages/addbooks.php' );


// UPDATE BOOKS

try {

	$updatesql = "UPDATE book SET lastname='Doe' WHERE id=2";

	// Prepare statement
	$stmt = $conn->prepare( $updatesql );

	// execute the query
	$stmt->execute();

	// echo a message to say the UPDATE succeeded
	echo $stmt->rowCount() . " records UPDATED successfully";
} catch ( PDOException $e ) {
	echo $updatesql . "<br>" . $e->getMessage();
}

$conn = null;

header( 'location:../view/pages/updatebooks.php' );

// DELETE BOOKS

try {
	// sql to delete a record
	$sql = "DELETE FROM book WHERE BookID=:";

	// use exec() because no results are returned
	$conn->exec( $deletesql );
	echo "Record deleted successfully";
} catch ( PDOException $e ) {
	echo $deletesql . "<br>" . $e->getMessage();
}

$conn = null;

header( 'location:../view/pages/deletebooks.php' );
?>