<?php
$whoCanAccess = [ 1, 2 ];
include( 'header.php' );
include( 'navigationbar.php' );

//include( '../../model/dbconnection.php' );

$selectsql = "SELECT * FROM book WHERE BookID = :id";

$stmt = $conn->prepare( $selectsql );

$stmt->bindParam( ':id', $_GET[ 'UpdateID' ], PDO::PARAM_INT );
//
$stmt->execute();

$row = $stmt->fetch();

$image = "../" . $row['CoverImage'];

?>

<head>
	<style>
		/* Remove the navbar's default rounded borders and increase the bottom margin */
		
		.navbar {
			margin-bottom: 50px;
			border-radius: 0;
		}
		/* Remove the jumbotron's default bottom margin */
		
		.jumbotron {
			margin-bottom: 0;
		}
	</style>
	
	<script src="../JS/authorinput.js" type="text/javascript"></script>
</head>
<body>

	<div class="jumbotron">
		<div class="container text-center">
			<h1>My Books</h1>
			<p>Update Books</p>
		</div>
	</div>

	<?php include ('../../model/message_boxes.php'); ?>

	<a href="viewbooks.php" class="btn btn-primary a-btn-slide-text" style="align-items: center;">
       <span class="glyphicon glyphicon-back" aria-hidden="true"></span>
        <span><strong>Go Back</strong></span>            
    </a>



	<div class="container1" align="center" ; width="20%;">
		<!--<form role="form" width="50%;" method="post" action="../../control/managebooks_process.php?UpdateID=<?php //echo $row['BookID']; ?>">-->


		<form role="form" width="50%" method="post" action="../../model/managebooks_process.php?UpdateID=<?php echo $_GET['UpdateID']; ?>" enctype="multipart/form-data">
			<br style="clear:both">
			<h3 style="margin-bottom: 25px; text-align: center;">Update book details.</h3>
			<div class="form-group">
				<input type="text" class="form-control" id="bookTitle" name="newbooktitle" placeholder="Book Title" value="<?php echo $row['BookTitle']; ?>" required>
			</div>
			
			<hr class="hr-primary">
			<h4 style="margin-bottom: 25px; text-align: center;">Author</h4>

			<div class="form-group" id="authorRadios">
				<label class="radio-inline"><input type="radio" name="newAuthorRadio" value="0" onClick="AuthorRadios()" checked>Choose Existing Author</label>
				<label class="radio-inline"><input type="radio" name="newAuthorRadio" value="1" onClick="AuthorRadios()">Create New Author</label>
			</div>

			<div class="form-group" id="existingAuthor">
				<label>Select the author from the list:</label>
				<select class="form-control" name="existingAuthorID">
					<?php 
					$authorSQL = "SELECT * FROM Author";
					$stmt = $conn->prepare( $authorSQL );
					$stmt->execute();
					$staticResults = $stmt->FetchAll();
					foreach ($staticResults as $result) {
						if ($result['AuthorID'] == 0) {
							continue;
						}
						echo "<option value=\"" . $result['AuthorID'] . "\"";
						
						if ($result['AuthorID'] == $row['AuthorID']) {
							echo "selected";
							
						}
						
						echo ">" . $result['Name'] . " " . $result['Surname'] . "</option>";
					}
					?>
				</select>
			</div>

			<div class="form-group" id="newAuthor" style="display: none">
				<label for="newAuthor">Fill in the Author's Details:</label>
				<input type="text" class="form-control" id="newAuthorName" name="newAuthorName" placeholder="First Name">
				<input type="text" class="form-control" id="newAuthorSurname" name="newAuthorSurname" placeholder="Surname(s)">
				<input type="text" class="form-control" id="newAuthorNationality" name="newAuthorNationality" placeholder="Nationality">
				<input class="form-control" id="birthDate" name="newAuthorBirthDate" placeholder="Year of Birth" type="text"/>
				<input class="form-control" id="deathDate" name="newAuthorDeathDate" placeholder="Year of Death" type="text"/>
			</div>
			<hr class="hr-primary">
			
			
			<div class="form-group">
				<input type="text" class="form-control" id="genre" name="genre" placeholder="Genre" value="<?php echo $row['Genre']; ?>" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="yearOfpublication" name="yearofpublication" placeholder="Year Of Publication" value="<?php echo $row['YearofPublication']; ?>" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="language" name="language" placeholder="Language" value="<?php echo $row['LanguageWritten']; ?>" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="millionsold" name="millionssold" placeholder="Millions Sold" value="<?php echo $row['MillionsSold']; ?>" required>
			</div>
			
			<div class="form-group">
				<div class="text-center">
					<img src="<?php echo $image ?>" class="avatar img-thumbnail" alt="cover">
					<h6>Upload a coverimage...</h6>
					<input type="file" name="image" id="fileToUpload" size="50" class="text-center center-block well well-sm">
					<div id=" imageAlert " class="alert alert-danger " style="display: none; "></div>
				</div>
			</div>
			
			<div class="form-group">
				<input type="submit" id="submit" name="submit" class="btn btn-primary">
			</div>
		</form>
	</div>
	</div>
	</div>
	<footer class="container-fluid text-center">
		<?php include('footer.php');?>
	</footer>

</body>
</html>