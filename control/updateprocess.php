<?php
// UPDATE BOOKS
include('../model/dbconnection.php');

if ( isset( $_POST[ "newbooktitle" ] ) && isset( $_GET[ 'UpdateID' ] ) ) {
	try {

		$bookID = $_GET[ 'UpdateID' ];
		$BookTitle = $_POST[ 'newbooktitle' ];
		$YearofPublication = $_POST[ 'yearofpublication' ];
		$Genre = $_POST[ 'genre' ];
		$AuthorID = $_POST[ 'authorid' ];
		$MillionsSold = $_POST[ 'millionssold' ];
		$LanguageWritten = $_POST[ 'language' ];

		$updatesql = "UPDATE book SET BookTitle=:BookTitle, YearofPublication=:YearofPublication, Genre=:Genre, AuthorID=:AuthorID, MillionsSold=:MillionsSold, LanguageWritten=:LanguageWritten WHERE BookID=:id";

		// Prepare statement
		$stmt = $conn->prepare( $updatesql );

		//bindparam
		$stmt->bindParam( ':id', $UpdateID, PDO::PARAM_INT );
		$stmt->bindParam( ':BookTitle', $BookTitle, PDO::PARAM_STR );
		$stmt->bindParam( ':YearofPublication', $YearofPublication, PDO::PARAM_INT );
		$stmt->bindParam( ':Genre', $Genre, PDO::PARAM_STR );
		$stmt->bindParam( ':AuthorID', $AuthorID, PDO::PARAM_INT );
		$stmt->bindParam( ':MillionsSold', $MillionsSold, PDO::PARAM_INT );
		$stmt->bindParam( ':LanguageWritten', $LanguageWritten, PDO::PARAM_STR );

		// execute the query
		$stmt->execute();

		echo $stmt->rowCount()  . "records updated successfully";
	} catch ( PDOException $e ) {
		echo $updatesql . "<br>" . $e->getMessage();
	}

	$conn = null;

	header( 'location:../view/pages/viewbooks.php' );
}


?>

<?php

try {
    $sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    echo $stmt->rowCount() . " records UPDATED successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>


