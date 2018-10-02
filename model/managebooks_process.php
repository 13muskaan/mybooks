<?php
include( '../model/dbconnection.php' );
include( 'bookcover_upload.php' );
include('../control/testInput.php');
// INSERT BOOKS
if ( isset( $_POST[ "booktitle" ] ) && !isset( $_POST[ 'BookID' ] ) ) {
	try {
		$BookTitle = SanitiseData($_POST['booktitle'], 'untitled');
		$OriginalTitle = SanitiseData($_POST['originaltitle'], $BookTitle);
		$YearofPublication = SanitiseData($_POST['yearofpublication']);
		$Genre = SanitiseData($_POST[ 'genre' ], 'un-genre');
		$AuthorID = SanitiseData($_POST[ 'authorid' ], '0');
		$MillionsSold = SanitiseData($_POST[ 'millionssold' ], '0');
		$LanguageWritten = SanitiseData($_POST[ 'language' ], 'English');

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

		if (!empty($_FILES['image'])) {
		
		$imageURL = uploadCover( $_FILES[ "image" ], $id );
		
		$coverUpdateSQL = "UPDATE book SET CoverImage = :image WHERE BookID = :id";
		
		$stmt = $conn->prepare( $coverUpdateSQL);
		
		$stmt->bindParam( ':id', $id, PDO::PARAM_STR );
		$stmt->bindParam( ':image', $imageURL, PDO::PARAM_STR );
		
		$stmt->execute();
			
		}
		
		//echo "New record created successfully";
	} catch ( PDOException $e ) {
		echo $insertsql . "<br>" . $e->getMessage();
	}

	$conn = null;

	header( 'location:../view/pages/addbooks.php' );
}

// UPDATE BOOKS
if ( isset( $_POST[ "newbooktitle" ] ) && isset( $_GET[ 'UpdateID' ] ) ) {
	try {
		
		$UpdateID = SanitseData($_GET[ 'UpdateID' ]);
		$BookTitle = SanitiseData($_POST[ 'newbooktitle' ], 'untitled');
		$YearofPublication = SanitiseData($_POST['yearofpublication']);
		$Genre = SanitiseData($_POST[ 'genre' ], 'un-genre');
		$AuthorID = SanitiseData($_POST[ 'authorid' ], '0');
		$MillionsSold = SanitiseData($_POST[ 'millionssold' ], '0');
		$LanguageWritten = SanitiseData($_POST[ 'language' ], 'English');

		$updatesql = "UPDATE book SET BookTitle= :BookTitle, YearofPublication= :YearofPublication, Genre= :Genre, AuthorID= :AuthorID, MillionsSold= :MillionsSold, LanguageWritten= :LanguageWritten WHERE BookID= :id;";

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

		$stmt->bindParam( ':id', SanatiseData($_GET[ 'DeleteID' ]), PDO::PARAM_INT );

		// use exec() because no results are returned
		$stmt->execute();
	} catch ( PDOException $e ) {
		echo $deletesql . "<br>" . $e->getMessage();
	}

	$conn = null;

	header( 'location:../view/pages/viewbooks.php' );
}
?>