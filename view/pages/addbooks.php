<?php
$whoCanAccess = [ 1, 2 ];
include( 'header.php' );
include( 'navigationbar.php' );


?>

<style>
	.red {
		color: red;
	}
	
	.form-area {
		background-color: #FAFAFA;
		padding: 10px 40px 60px;
		margin: 10px 0px 60px;
		border: 1px solid GREY;
	}
</style>

<script src="../JS/authorinput.js" type="text/javascript"></script>

<script>
	//FORM SELECTOR SCRIPTS

	//TITLE
	var origTitleCheck;
	var origTitleInput;
	var origTitleValue = ""; //A variable to store the original title if the check box is unchecked just in case

	function origTitleSelect() { //Function that shows/hides the original title input, and stores the value in case of unchecking
		console.log( origTitleInput.style.display );
		if ( origTitleCheck.checked ) {
			origTitleInput.style.display = "block";
			origTitleInput.value = origTitleValue;
		} else {
			origTitleInput.style.display = "none";
			origTitleValue = origTitleInput.value;
			origTitleInput.value = "";
		}
	}

document.onready = function () {
		origTitleCheck = document.getElementById( "origTitleCheck" ); //Check box
		origTitleInput = document.getElementById( "origTitleInput" ); //Input

		AuthorSetup();
	};
</script>

</head>

<body>
	<div class="jumbotron">
		<div class="container text-center">
			<h1>My Books</h1>
			<p>Add New Books.</p>
		</div>
	</div>
	<?php include ('../../model/message_boxes.php'); ?>
	<div class="container1" align="center" ; width="20%;">
		<form role="form" width="50%;" action="../../model/managebooks_process.php?newBook=true" method="post" enctype="multipart/form-data">
			<br style="clear:both">
			<h3 style="margin-bottom: 25px; text-align: center;">New book details.</h3>


			<h4 style="margin-bottom: 25px; text-align: center;">Title</h4>
			<div class="form-group">
				<input type="text" class="form-control" id="bookTitle" name="booktitle" placeholder="Current Book Title*" required>
			</div>
			<div class="form-group">
				<div class="checkbox">
					<label><input type="checkbox" id="origTitleCheck" onClick="origTitleSelect()">Check this box if this book was originally published under a different name.</label>
				</div>
			</div>
			<div class="form-group" id="origTitleInput" style="display: none;">
				<input type="text" class="form-control" id="originalTitle" name="originaltitle" placeholder="Original Title">
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
						echo "<option value=\"" . $result['AuthorID'] . "\">" . $result['Name'] . " " . $result['Surname'] . "</option>";
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
			<h4 style="margin-bottom: 25px; text-align: center;">Book Details</h4>

			<div class="form-group">
				<input type="text" class="form-control" id="genre" name="genre" placeholder="Genre">
			</div>
			<div class="form-group">
				<input class="form-control" id="yearofpublication" name="yearofpublication" placeholder="Year of Publication" type="text"/>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="language" name="language" placeholder="Language (if not English)">
			</div>
			<div class="form-group">
				<input type="number" class="form-control" id="millionsold" name="millionssold" placeholder="Millions Sold">
			</div>
			<div class="form-group">
				<div class="text-center">
					<h6>Upload a coverimage...</h6>
					<input type="file" name="image" id="fileToUpload" size="50" class="text-center center-block well well-sm">
					<div id=" imageAlert " class="alert alert-danger " style="display: none; "></div>
				</div>
			</div>
			
			<div class="form-group">
					<input type="submit" id="submit" name="submit" class="btn btn-primary ">
			</div>
		</form>
	</div>
	<footer class="container-fluid text-center ">
		<?php include('footer.php');?>
	</footer>

</body>



</html>