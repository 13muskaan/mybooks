<?php function NewUser( $conn, $email, $passwordhash, $role, $firstname, $lastname ) {
	try { //BEGIN try/catch
		//Begin database transaction
		$conn->beginTransaction();

		//Prepare insert statement into login table
		$stmt = $conn->prepare( "INSERT INTO login (email, password, role) VALUES (:email, :password, :role)" );

		//Bind params
		$stmt->bindParam( ':email', $email, PDO::PARAM_STR );
		$stmt->bindParam( ':password', $passwordhash, PDO::PARAM_STR );
		$stmt->bindParam( ':role', $role, PDO::PARAM_INT );

		//Execute login insert
		$stmt->execute();

		//Get insert id of login
		$lastloginID = $conn->lastInsertId();

		//Prepare insert into users table
		$stmt = $conn->prepare( "INSERT INTO users (loginID, firstname, lastname) VALUES (:loginID, :firstname, :lastname)" );

		//Bind params
		$stmt->bindParam( ':firstname', $firstname, PDO::PARAM_STR );
		$stmt->bindParam( ':lastname', $lastname, PDO::PARAM_STR );
		$stmt->bindValue( ':loginID', $lastloginID );

		//Execute users insert
		$stmt->execute();

		//Commit transaction
		$conn->commit();

		//Return success
		return true;

	} catch ( PDOException $e ) { //If transaction failed

		//Rollback transaction
		$conn->rollBack();

		//Echo error
		echo "<hr>ERROR: PDOException<hr>" . $e . "<hr>";

		//Return failure
		return false;
	} //END try/catch
} ?>