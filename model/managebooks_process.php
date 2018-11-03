<?php

// Include: database connection, uploading file of bookcovers, sanitising input files and start the session

session_start();
include( 'dbconnection.php' );


include( '../control/bookcover_upload.php' );
include( '../control/testInput.php' );

// Code to INSERT BOOKS

// Code to fetch user information. In order to store user information in log data. 

// SELECT STATEMENT

$userSQL = "SELECT firstname, lastname FROM users WHERE userID = :id";

// Prepare statement

$stmt = $conn->prepare( $userSQL );

// Bindparam

$stmt->bindParam( ':id', $_SESSION[ 'userID' ], PDO::PARAM_STR );

// Execute

$stmt->execute();

// Fetch data

$res = $stmt->fetch();

// Description for logdata

$user = $res[ "firstname" ] . " " . $res[ 'lastname' ];

$log = $user . " (UserID: " . $_SESSION[ 'userID' ] . ")";

// BEGIN TRANSACTION of INSERTING BOOK

if ( isset( $_GET[ 'newBook' ] ) ) {
	try {
		$conn->beginTransaction();

		// Sanitise book title
		$BookTitle = SanitiseData( $_POST[ 'booktitle' ], 'untitled' );

		// Description for logdata
		$log = $log . " added Book: " . $BookTitle;

		// Author handling

		// IF 'new author' selected
		if ( $_POST[ 'newAuthorRadio' ] === '1' ) {
			
			// Sanitise form inputs
			$authorFirstName = SanitiseData( $_POST[ 'newAuthorName' ] );
			$authorSurname = SanitiseData( $_POST[ 'newAuthorSurname' ] );
			$authorNationality = SanitiseData( $_POST[ 'newAuthorNationality' ] );
			$authorBirthDate = SanitiseData( $_POST[ 'newAuthorBirthDate' ] );
			$authorDeathDate = SanitiseData( $_POST[ 'newAuthorDeathDate' ] );

			// INSERT STATEMENT 
			$insertsql = "INSERT INTO author (Name, Surname, Nationality, BirthYear, DeathYear) VALUES (:n, :sn, :nat, :by, :dy)";

			// Prepare statement
			$stmt = $conn->prepare( $insertsql );

			// Bindparam
			$stmt->bindParam( ':n', $authorFirstName, PDO::PARAM_STR );
			$stmt->bindParam( ':sn', $authorSurname, PDO::PARAM_STR );
			$stmt->bindParam( ':nat', $authorNationality, PDO::PARAM_STR );
			$stmt->bindParam( ':by', $authorBirthDate, PDO::PARAM_STR );
			$stmt->bindParam( ':dy', $authorDeathDate, PDO::PARAM_STR );

			// Execute
			$stmt->execute();

			// Retrieve last insert ID
			$AuthorID = $conn->lastInsertId();

			// Description for logdata
			$log = $log . " - New author (ID: " . $AuthorID . "): " . $authorFirstName . " " . $authorSurname . " was created as well.";

		} else {
			// EXISTING AUTHOR
			$AuthorID = $_POST[ 'existingAuthorID' ];
		} // END IF newAuthorSelected

		// Sanitise form inputs
		$OriginalTitle = SanitiseData( $_POST[ 'originaltitle' ], $BookTitle );
		$YearofPublication = SanitiseData( $_POST[ 'yearofpublication' ] );
		$Genre = SanitiseData( $_POST[ 'genre' ], 'un-genre' );
		if ( !isset( $AuthorID ) )$AuthorID = SanitiseData( $_POST[ 'authorid' ], '0' );
		$MillionsSold = SanitiseData( $_POST[ 'millionssold' ], '0' );
		$LanguageWritten = SanitiseData( $_POST[ 'language' ], 'English' );

		// INSERT STATEMENT
		$insertsql = "INSERT INTO book (BookTitle, OriginalTitle, YearofPublication, Genre, AuthorID, MillionsSold, LanguageWritten) VALUES (:BookTitle, :OriginalTitle, :YearofPublication, :Genre, :AuthorID, :MillionsSold, :LanguageWritten)";

		// Prepare
		$stmt = $conn->prepare( $insertsql );

		// Bindparam
		$stmt->bindParam( ':BookTitle', $BookTitle, PDO::PARAM_STR );
		$stmt->bindParam( ':OriginalTitle', $OriginalTitle, PDO::PARAM_STR );
		$stmt->bindParam( ':YearofPublication', $YearofPublication, PDO::PARAM_INT );
		$stmt->bindParam( ':Genre', $Genre, PDO::PARAM_STR );
		$stmt->bindParam( ':AuthorID', $AuthorID, PDO::PARAM_INT );
		$stmt->bindParam( ':MillionsSold', $MillionsSold, PDO::PARAM_INT );
		$stmt->bindParam( ':LanguageWritten', $LanguageWritten, PDO::PARAM_STR );

		// Execute 
		$stmt->execute();

		// Retrieve last insert ID
		$id = $conn->lastInsertId();

		// UPLOAD BOOK COVER IMAGE (IF NO IMAGE IS UPLOADED, A DEFAULT IMAGE IS INSERTED)
		if ( $_FILES[ 'image' ][ 'size' ] != 0 ) {

			$imageURL = uploadCover( $_FILES[ "image" ], $id );

			// UPDATE STATEMENT
			$coverUpdateSQL = "UPDATE book SET CoverImage = :image WHERE BookID = :id";

			// Prepare the statement
			$stmt = $conn->prepare( $coverUpdateSQL );

			// BindParam
			$stmt->bindParam( ':id', $id, PDO::PARAM_STR );
			$stmt->bindParam( ':image', $imageURL, PDO::PARAM_STR );

			// Execute
			$stmt->execute();

		}

		// LOGDATA

		// INSERT STATEMENT
		$insertsql = "INSERT INTO logData (bookID, userID, description) VALUES (:bookID, :userID, :desc)";


		// Prepare
		$stmt = $conn->prepare( $insertsql );

		// Bindparam

		$stmt->bindParam( ':bookID', $id, PDO::PARAM_STR );
		$stmt->bindParam( ':userID', $_SESSION[ 'userID' ], PDO::PARAM_INT );
		$stmt->bindParam( ':desc', $log, PDO::PARAM_STR );

		// Execute

		$stmt->execute();

		// COMMIT TRANSACTION
		$conn->commit();
		
		//If successful, message
		$_SESSION["message"] = "The book: \"" . $BookTitle . "\" was successfully added!";
		
		//go to viewbooks
		header( 'location:../view/pages/viewbooks.php' );
		
	} catch ( PDOException $e ) { //IF FAILED

		// SHOW ERROR
		$_SESSION['error'] = "The book was not added successfully, database returned this error:<hr>" . $e->getMessage();
		
		//Return to addbooks
		header( 'location:../view/pages/addbooks.php' );
	} //END TRY/CATCH

	//Clear dbconnection in case of accidental follow through
	$conn = null;
}
// END INSERT TRANSACTION

// UPDATE BOOKS
if ( isset( $_POST[ "newbooktitle" ] ) && isset( $_GET[ 'UpdateID' ] ) ) {
	try {

		$conn->beginTransaction();

		$new = array();

		$new[ 0 ] = SanitiseData( $_GET[ 'UpdateID' ] );
		$new[ 1 ] = SanitiseData( $_POST[ 'newbooktitle' ], 'untitled' );
		$new[ 2 ] = SanitiseData( $_POST[ 'yearofpublication' ] );
		$new[ 3 ] = SanitiseData( $_POST[ 'genre' ], 'un-genre' );
		$new[ 4 ] = SanitiseData( $_POST[ 'millionssold' ], '0' );
		$new[ 5 ] = SanitiseData( $_POST[ 'language' ], 'English' );


		//Author Handling
		if ( $_POST[ 'newAuthorRadio' ] === '1' ) {
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
		} else {
			$AuthorID = $_POST[ 'existingAuthorID' ];
		}

		$new[ 6 ] = SanitiseData( $AuthorID, '0' );

		$SQL = "SELECT BookID, BookTitle, YearofPublication, Genre, MillionsSold, LanguageWritten, AuthorID FROM book WHERE BookID = :id";

		$stmt = $conn->prepare( $SQL );

		$stmt->bindParam( ':id', $new[ 0 ], PDO::PARAM_INT );

		$stmt->execute();

		$orig = $stmt->fetch();



		$SQL = "UPDATE book SET BookTitle= :BookTitle, YearofPublication= :YearofPublication, Genre= :Genre, AuthorID= :AuthorID, MillionsSold= :MillionsSold, LanguageWritten= :LanguageWritten WHERE BookID= :id;";

		// Prepare statement
		$stmt = $conn->prepare( $SQL );


		//bindparam
		$stmt->bindParam( ':id', $new[ 0 ], PDO::PARAM_INT );
		$stmt->bindParam( ':BookTitle', $new[ 1 ], PDO::PARAM_STR );
		$stmt->bindParam( ':YearofPublication', $new[ 2 ], PDO::PARAM_INT );
		$stmt->bindParam( ':Genre', $new[ 3 ], PDO::PARAM_STR );
		$stmt->bindParam( ':MillionsSold', $new[ 4 ], PDO::PARAM_INT );
		$stmt->bindParam( ':LanguageWritten', $new[ 5 ], PDO::PARAM_STR );
		$stmt->bindParam( ':AuthorID', $new[ 6 ], PDO::PARAM_INT );

		// execute the query
		$stmt->execute();


		// LOGDATA
		$log = $log . " updated BookID: " . $new[ 0 ] . " - Title: \"" . $new[ 1 ] . "\"";

		//Special Logdata check for update book
		for ( $i = 0; $i < count( $new ); $i++ ) { //Iterate through each entry from the orginal and new ones
			if ( $orig[ $i ] != $new[ $i ] ) { //If ENTRY IS DIFFERENT
				//Check to see what is different and add the name to the log text
				if ( $i == 1 ) { //If TITLE
					$log = $log . " <- New Title, Old: \"" . $orig[ 1 ] . "\"";
				} else { //If NOT TITLE
					$log = $log . " - ";

					if ( $i == 2 ) { //Publication Year
						$log = $log . "Publication Year";
					}
					if ( $i == 3 ) { //Genre
						$log = $log . "Genre";
					}
					if ( $i == 4 ) { //Millions Sold
						$log = $log . "Millions Sold";
					}
					if ( $i == 5 ) { //Language
						$log = $log . "Language";
					}
					if ( $i == 6 ) { //Author ID
						$log = $log . "Author ID";
					}

					//Complete this individual section of the log entry using the old value and the new value
					$log = $log . " updated from \"" . $orig[ $i ] . "\" to \"" . $new[ $i ] . "\"";
				} //Endif NOT TITLE
			} //Endif ENTRY IS DIFFERENT
		} //Endfor

		//Cover image update
		if ( $_FILES[ 'image' ][ 'size' ] != 0 ) {

			$log = $log . " - Cover Image Changed";

			$imageURL = uploadCover( $_FILES[ "image" ], $new[ 0 ] );

			$SQL = "UPDATE book SET CoverImage = :image WHERE BookID = :id";

			$stmt = $conn->prepare( $SQL );

			$stmt->bindParam( ':id', $new[ 0 ], PDO::PARAM_STR );
			$stmt->bindParam( ':image', $imageURL, PDO::PARAM_STR );

			$stmt->execute();

		}

		$SQL = "INSERT INTO logData (bookID, userID, description) VALUES (:bookID, :userID, :desc)";

		$stmt = $conn->prepare( $SQL );

		$stmt->bindParam( ':bookID', $new[ 0 ], PDO::PARAM_STR );
		$stmt->bindParam( ':userID', $_SESSION[ 'userID' ], PDO::PARAM_INT );
		$stmt->bindParam( ':desc', $log, PDO::PARAM_STR );

		$stmt->execute();

		$conn->commit();
		
		$_SESSION['message'] = "The book: \"" . $new[1] . "\" has been updated successfully!";
		
		header( 'location:../view/pages/viewbooks.php' );
		
	} catch ( PDOException $e ) {
		$_SESSION['error'] = "There was an error, the database returned this error message:<hr>" . $e->getMessage()."<hr>Nothing has been changed.";
		
		header( 'location:../view/pages/update.php?UpdateID='.$new[0] );
	}

	$conn = null;

	
}

// DELETE BOOKS
if ( isset( $_GET[ 'DeleteID' ] ) ) {
	try { //img/bookcovers/1.jpg
		$id = SanitiseData($_GET[ 'DeleteID' ]);

		$conn->beginTransaction();
		// sql to delete a record
		$selectsql = "SELECT BookTitle, CoverImage FROM book WHERE BookID = :id";

		$stmt = $conn->prepare( $selectsql );

		$stmt->bindParam( ':id', $id, PDO::PARAM_INT );

		$stmt->execute();

		$res = $stmt->fetchAll()[0];

		$deletesql = "DELETE FROM book WHERE BookID = :id";

		$stmt = $conn->prepare( $deletesql );

		$stmt->bindParam( ':id', $id, PDO::PARAM_INT );

		$stmt->execute();

		$log = $log . " deleted the book (ID: " . $id . ") titled: " . $res[ 'BookTitle' ];

		$insertsql = "INSERT INTO logData (bookID, userID, description) VALUES (0, :userID, :desc)";

		$stmt = $conn->prepare( $insertsql );

		$stmt->bindParam( ':userID', $_SESSION[ 'userID' ], PDO::PARAM_INT );
		$stmt->bindParam( ':desc', $log, PDO::PARAM_STR );

		$stmt->execute();

		if ( strpos( $res[ 'CoverImage' ], 'default' ) == false ) {
			unlink( "../view/" . $res[ 'CoverImage' ] );
		}

		$conn->commit();
		
		$_SESSION['message'] = "The book: \"" . $res[ 'BookTitle' ] . "\" has been deleted!";
		
	} catch ( PDOException $e ) {
		
		$_SESSION['error'] = "The book: \"" . $res[ 'BookTitle' ] . "\" wasn't deleted! The database returned this error:<hr>" . $e->getMessage();
	}

	$conn = null;

	header( 'location:../view/pages/viewbooks.php' );
}
?>