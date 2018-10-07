<?php
$whoCanAccess = [ 1, 2 ];
include( 'header.php' );
include( 'navigationbar.php' );
include( '../../model/dbconnection.php' );

?>
<!doctype html>
<head>
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
	<script>
		$( document ).ready( function () {
			$( '#characterLeft' ).text( '140 characters left' );
			$( '#message' ).keydown( function () {
				var max = 140;
				var len = $( this ).val().length;
				if ( len >= max ) {
					$( '#characterLeft' ).text( 'You have reached the limit' );
					$( '#characterLeft' ).addClass( 'red' );
					$( '#btnSubmit' ).addClass( 'disabled' );
				} else {
					var ch = max - len;
					$( '#characterLeft' ).text( ch + ' characters left' );
					$( '#btnSubmit' ).removeClass( 'disabled' );
					$( '#characterLeft' ).removeClass( 'red' );
				}
			} );
		} );
	</script>
	
	<script>
		//FORM TYPE CONSTRAINER
		function constrainToNumbers(item) {
			console.log(item.value);
			console.log(isNaN(item.value));
			
			while(item.value.length > 0 && isNaN(item.value) && item.value.contains("e") && item.value.contains(".")) {
				item.value = item.value.substr(0,item.value.length -1);
			}
		}
		
		//FORM SELECTOR SCRIPTS
		
		//TITLE
		var origTitleCheck;
		var origTitleInput;
		var origTitleValue = ""; //A variable to store the original title if the check box is unchecked just in case
		
		console.log("Fish");
		
		function origTitleSelect() { //Function that shows/hides the original title input, and stores the value in case of unchecking
			console.log(origTitleInput.style.display);
			if (origTitleCheck.checked) {
				origTitleInput.style.display = "block";
				origTitleInput.value = origTitleValue;
			} else {
				origTitleInput.style.display = "none";
				origTitleValue = origTitleInput.value;
				origTitleInput.value = "";
			}
		}
		
		//AUTHOR
		var authorRadios; //List of two elements, the radio buttons
		var existingAuthorSelect; //Select author input
		var newAuthorInputs; //New author input
		var newAuthorValues;
		
		function AuthorRadios($radio) {
			
			if (authorRadios[0].checked) {
				existingAuthorSelect.style.display = "block";
				newAuthorInputs.style.display = "none";
				
				for (var i = 0; i < newAuthorInputs.children.length; i++) {
					if(newAuthorInputs.children[i].type = HTMLLabelElement) {
					 continue;
					}
					
					newAuthorValues[i] = newAuthorInputs.children[i].value;
					newAuthorInputs.children[i].value = "";
				}
				
				return;
			}
			
			if (authorRadios[1].checked) {
				
				newAuthorInputs.style.display = "block";
				existingAuthorSelect.style.display = "none";
				
				
				for (var i = 0; i < newAuthorInputs.children.length; i++) {
					if(newAuthorInputs.children[i].type = HTMLLabelElement) {
					 continue;
					}
					
					newAuthorInputs.children[i].value = newAuthorValues[i];
				}
				
				return;
			}
			
			console.error ("Author Radio code was run without either radio being selected");
		}
		
		//Variable setting
		document.onready = function () { 
			origTitleCheck = document.getElementById("origTitleCheck"); //Check box
			origTitleInput = document.getElementById("origTitleInput"); //Input
			
			newAuthorInputs = document.getElementById("newAuthor");
			newAuthorValues = Array(newAuthorInputs.length);
			existingAuthorSelect = document.getElementById("existingAuthor");
			
			authorRadios = document.getElementById("authorRadios").children;
			var temparr = Array(authorRadios.length); 
			
			for (var i = 0; i < authorRadios.length; i++) {
				temparr[i] = authorRadios[i].children[0];
			}
			
			authorRadios = temparr;
									  }
		
	</script>
	
</head>
<body>
	<div class="jumbotron">
		<div class="container text-center">
			<h1>My Books</h1>
			<p>Add New Books.</p>
		</div>
	</div>
	<?php
	if ( isset( $_SESSION[ 'error' ] ) ) {
		if ( $_SESSION[ 'error' ] != "" ) {
			echo '<div class="alert alert-danger"><strong>ERROR: </strong>' . $_SESSION[ 'error' ] . '</div>';
			$_SESSION[ 'error' ] = "";
		}
	}
	if ( isset( $_SESSION[ 'message' ] ) ) {
		if ( $_SESSION[ 'message' ] != "" ) {
			echo '<div class="alert alert-success">' . $_SESSION[ 'message' ] . '</div>';
			$_SESSION[ 'message' ] = "";
		}
	}
	?>
	<div class="container1" align="center" ; width="20%;">
		<form role="form" width="50%;" action="../../model/managebooks_process.php" method="post" enctype="multipart/form-data">
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
				<label class="radio-inline"><input type="radio" name="AuthorRadio" onClick="AuthorRadios()" checked>Choose Existing Author</label>
				<label class="radio-inline"><input type="radio" name="AuthorRadio" onClick="AuthorRadios()">Create New Author</label>
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
						echo "<option value=\"" . $result['AuthorID'] . ">" . $result['Name'] . " " . $result['Surname'] . "</option>";
					}
					?>
      			</select>
			</div>
			
			<div class="form-group" id="newAuthor">
				<label for="newAuthor">Fill in the Author's Details:</label>
				<input type="text" class="form-control" id="newAuthorName" name="newAuthorName" placeholder="First Name">
				<input type="text" class="form-control" id="newAuthorSurname" name="newAuthorSurname" placeholder="Surname(s)">
				<input type="text" class="form-control" id="newAuthorNationality" name="newAuthorNationality" placeholder="Nationality">
				<input type="text" class="form-control" id="newAuthorBirthyear" name="newAuthorBirthyear" placeholder="Year of Birth" onKeyUp="constrainToNumbers(this)">
				<input type="text" class="form-control" id="newAuthorDeathyear" name="newAuthorDeathyear" placeholder="Year of Death (leave blank if author is still alive)" onKeyUp="constrainToNumbers(this)">
				
			</div>
			
			<hr class="hr-primary">
			<h4 style="margin-bottom: 25px; text-align: center;">Book Details</h4>
			
			<div class="form-group">
				<input type="text" class="form-control" id="genre" name="genre" placeholder="Genre">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="yearOfpublication" name="yearofpublication" placeholder="Year Of Publication*" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="language" name="language" placeholder="Language (if not English)">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="millionsold" name="millionssold" placeholder="Millions Sold">
			</div>
			<div class="form-group">
				<div class="text-center">
					<img src="<?php echo $image ?>" class="avatar img-thumbnail" alt="cover">
					<h6>Upload a photo...</h6>

					<input type="file" name="image" id="fileToUpload" size="50" class="text-center center-block well well-sm">

					<div id=" imageAlert " class="alert alert-danger " style="display: none; "></div>
				</div>
				<div class="form-group">
					<input type="submit" id="submit" name="submit" class="btn btn-primary ">
				</div>
		</form>

		</div>
	</div>
	<footer class="container-fluid text-center ">
		<?php include('footer.php');?>
	</footer>
	
</body>



</html>