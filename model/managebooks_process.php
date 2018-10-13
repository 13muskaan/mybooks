<?php
include( 'dbconnection.php' );
session_start();

include( '../control/bookcover_upload.php' );
include( '../control/testInput.php' );

// INSERT BOOKS

if ( isset($_GET['newBook']) ) {
	try {
		$conn->beginTransaction();
		
		$BookTitle = SanitiseData( $_POST[ 'booktitle' ], 'untitled' );
		$log = "Book: " . $BookTitle . " was added.";
		
		if ($_POST['newAuthorRadios'] = "true") {
			$authorFirstName = SanitiseData( $_POST[ 'newAuthorName' ] );
			$authorSurname = SanitiseData( $_POST[ 'newAuthorSurname' ] );
			$authorNationality = SanitiseData( $_POST[ 'newAuthorNationality' ] );
			$authorBirthDate = SanitiseData( $_POST[ 'newAuthorBirthDate' ] );
			$authorDeathDate = SanitiseData( $_POST[ 'newAuthorDeathDate' ] );
			
			$insertsql = "INSERT INTO author (Name, Surname, Nationality, BirthYear, DeathYear) VALUES (:n, :sn, :nat, :by, :dy)";
			
			$stmt = $conn->prepare( $insertsql );
			
			$stmt->bindParam( ':n', $authorFirstName, PDO::PARAM_STR );
			$stmt->bindParam( ':sn', $authorSurname, PDO::PARAM_STR );
			$stmt->bindParam( ':nat', $authorNationality, PDO::PARAM_STR );
			$stmt->bindParam( ':by', $authorBirthDate, PDO::PARAM_STR );
			$stmt->bindParam( ':dy', $authorDeathDate, PDO::PARAM_STR );
			
			$stmt->execute();
			
			$AuthorID = $conn->lastInsertId();
			
			$log = $log . " - New author (ID: " . $AuthorID . "): " . $authorFirstName . " " . $authorSurname . " was created as well.";
		}
		
		
		$OriginalTitle = SanitiseData( $_POST[ 'originaltitle' ], $BookTitle );
		$YearofPublication = SanitiseData( $_POST[ 'yearofpublication' ] );
		$Genre = SanitiseData( $_POST[ 'genre' ], 'un-genre' );
		if (!isset($AuthorID)) $AuthorID = SanitiseData( $_POST[ 'authorid' ], '0' );
		$MillionsSold = SanitiseData( $_POST[ 'millionssold' ], '0' );
		$LanguageWritten = SanitiseData( $_POST[ 'language' ], 'English' );

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

		if ( !empty( $_FILES[ 'image' ] ) ) {

			$imageURL = uploadCover( $_FILES[ "image" ], $id );

			$coverUpdateSQL = "UPDATE book SET CoverImage = :image WHERE BookID = :id";

			$stmt = $conn->prepare( $coverUpdateSQL );

			$stmt->bindParam( ':id', $id, PDO::PARAM_STR );
			$stmt->bindParam( ':image', $imageURL, PDO::PARAM_STR );

			$stmt->execute();

		}
		
		$insertsql = "INSERT INTO logData (bookID, userID, description) VALUES (:bookID, :userID, :desc)";
		
		$stmt = $conn->prepare($insertsql);
		
		$stmt->bindParam( ':bookID', $id, PDO::PARAM_STR );
		$stmt->bindParam( ':userID', $_SESSION['userID'], PDO::PARAM_INT );
		$stmt->bindParam( ':desc', $log, PDO::PARAM_STR );

		$stmt->execute();
		
	} catch ( PDOException $e ) {
		echo $insertsql . "<br>" . $e->getMessage();
		echo "<hr>";
		print_r($_SESSION);
	}

	$conn = null;

	header( 'location:../view/pages/addbooks.php' );
}

// UPDATE BOOKS
if ( isset( $_POST[ "newbooktitle" ] ) && isset( $_GET[ 'UpdateID' ] ) ) {
	try {
		
		$conn->beginTransaction();

		$UpdateID = SanitiseData( $_GET[ 'UpdateID' ] );
		$BookTitle = SanitiseData( $_POST[ 'newbooktitle' ], 'untitled' );
		$YearofPublication = SanitiseData( $_POST[ 'yearofpublication' ] );
		$Genre = SanitiseData( $_POST[ 'genre' ], 'un-genre' );
		$AuthorID = SanitiseData( $_POST[ 'authorid' ], '0' );
		$MillionsSold = SanitiseData( $_POST[ 'millionssold' ], '0' );
		$LanguageWritten = SanitiseData( $_POST[ 'language' ], 'English' );
		
		

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
		

		// LOGDATA
		$log = "User " . $_SESSION['userID'] . " updated book " . $UpdateID;
		
		$insertsql = "INSERT INTO logData (bookID, userID, description) VALUES (:bookID, :userID, :desc)";
		
		$stmt = $conn->prepare($insertsql);
		
		$stmt->bindParam( ':bookID', $UpdateID, PDO::PARAM_STR );
		$stmt->bindParam( ':userID', $_SESSION['userID'], PDO::PARAM_INT );
		$stmt->bindParam( ':desc', $log, PDO::PARAM_STR );

		$stmt->execute();
		
		
		$conn->commit();
	} catch ( PDOException $e ) {
		echo $updatesql . "<br>" . $e->getMessage();
	}

	$conn = null;

	header( 'location:../view/pages/viewbooks.php' );
}

// DELETE BOOKS
if ( isset( $_GET[ 'DeleteID' ] ) );{
	try {
		$id = $_GET[ 'DeleteID' ];
		$conn->beginTransaction();
		// sql to delete a record
		$deletesql = "UPDATE book SET BookTitle= '{-DELETED BOOK-}', OriginalTitle = '' YearofPublication= '', Genre= '', AuthorID= '0', MillionsSold= '', LanguageWritten= '', CoverImage = '' WHERE BookID= :id;";
		
		$stmt = $conn->prepare($deletesql);

		$stmt->bindParam( ':id', SanitiseData( $id ), PDO::PARAM_INT );

		$stmt->execute();
		
		$log = "User " . $_SESSION['userID'] . " deleted book " . $id;
		
		$insertsql = "INSERT INTO logData (bookID, userID, description) VALUES (:bookID, :userID, :desc)";
		
		$stmt = $conn->prepare($insertsql);
		
		$stmt->bindParam( ':bookID', $id, PDO::PARAM_STR );
		$stmt->bindParam( ':userID', $_SESSION['userID'], PDO::PARAM_INT );
		$stmt->bindParam( ':desc', $log, PDO::PARAM_STR );

		$stmt->execute();
		
		$conn->commit();
	} catch ( PDOException $e ) {
		echo $deletesql . "<br>" . $e->getMessage();
	}

	$conn = null;

	header( 'location:../view/pages/viewbooks.php' );
}
?>