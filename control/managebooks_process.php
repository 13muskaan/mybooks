<?php
include( '../model/dbconnection.php' );
include( 'bookcover_upload.php' );

// INSERT BOOKS
if ( isset( $_POST[ "booktitle" ] ) && !isset( $_POST[ 'BookID' ] ) ) {
	try {
		$BookTitle = $_POST[ 'booktitle' ];
		$OrginalTitle = $_POST[ 'booktitle' ];
		$YearofPublication = $_POST[ 'yearofpublication' ];
		$Genre = $_POST[ 'genre' ];
		$AuthorID = $_POST[ 'authorid' ];
		$MillionsSold = $_POST[ 'millionssold' ];
		$LanguageWritten = $_POST[ 'language' ];

		$insertsql = "INSERT INTO book (BookTitle, OriginalTitle, YearofPublication, Genre, AuthorID, MillionsSold, LanguageWritten) VALUES (:BookTitle, :OriginalTitle, :YearofPublication, :Genre, :AuthorID, :MillionsSold, :LanguageWritten)";


		$stmt = $conn->prepare( $insertsql );

		//bindparam
		$stmt->bindParam( ':BookTitle', $BookTitle, PDO::PARAM_STR );
		$stmt->bindParam( ':OriginalTitle', $OriginalTitle, PDO::PARAM_STR );
		$stmt->bindParam( ':YearofPublication', $YearofPublication, PDO::PARAM_INT );
		$stmt->bindParam( ':Genre', $Genre, PDO::PARAM_STR );
		$stmt->bindParam( ':AuthorID', $AuthorID, PDO::PARAM_INT );
		$stmt->bindParam( ':MillionsSold', $MillionsSold, PDO::PARAM_INT );
		$stmt->bindParam( ':LanguageWritten', $LanguageWritten, PDO::PARAM_STR );

		$stmt->execute();
		
		$id = $conn->lastInsertId();

		$imageURL = uploadCover( $_FILES[ "image" ], $id );
		
		$coverUpdateSQL = "UPDATE book SET CoverImage = :image WHERE BookID = :id";
		
		$stmt = $conn->prepare( $coverUpdateSQL);
		
		$stmt->bindParam( ':id', $id, PDO::PARAM_STR );
		$stmt->bindParam( ':image', $imageURL, PDO::PARAM_STR );
		
		$stmt->execute();
		
		//echo "New record created successfully";
	} catch ( PDOException $e ) {
		echo $insertsql . "<br>" . $e->getMessage();
	}

	$conn = null;

	//header( 'location:../view/pages/addbooks.php' );
}

// UPDATE BOOKS
if ( isset( $_POST[ "newbooktitle" ] ) && isset( $_GET[ 'UpdateID' ] ) ) {
	try {

		$UpdateID = $_GET[ 'UpdateID' ];
		$BookTitle = $_POST[ 'newbooktitle' ];
		$YearofPublication = $_POST[ 'yearofpublication' ];
		$Genre = $_POST[ 'genre' ];
		$AuthorID = $_POST[ 'authorid' ];
		$MillionsSold = $_POST[ 'millionssold' ];
		$LanguageWritten = $_POST[ 'language' ];

		$updatesql = "UPDATE book SET BookTitle= :BookTitle, YearofPublication= :YearofPublication, Genre= :Genre, AuthorID= :AuthorID, MillionsSold= :MillionsSold, LanguageWritten= :LanguageWritten WHERE BookID= :id";

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

	} catch ( PDOException $e ) {
		echo $updatesql . "<br>" . $e->getMessage();
	}

	$conn = null;

	header( 'location:../view/pages/viewbooks.php' );
}

// DELETE BOOKS
if ( isset( $_GET[ 'DeleteID' ] ) ) {
	try {
		// sql to delete a record
		$deletesql = "DELETE FROM book WHERE BookID=:id";

		$stmt = $conn->prepare( $deletesql );

		$stmt->bindParam( ':id', $_GET[ 'DeleteID' ], PDO::PARAM_INT );

		// use exec() because no results are returned
		$stmt->execute();
	} catch ( PDOException $e ) {
		echo $deletesql . "<br>" . $e->getMessage();
	}

	$conn = null;

	header( 'location:../view/pages/viewbooks.php' );
}
?>