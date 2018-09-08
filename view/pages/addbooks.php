<?php include('navigationbar.php'); include('header.php');?>
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
</head>
<body>
	<div class="jumbotron">
		<div class="container text-center">
			<h1>My Books</h1>
			<p>Add New Books.</p>
		</div>
	</div>
	<div class="container1" align="center" ; width="20%;">
		<form role="form" width="50%;" action="../../model/managebooks_process.php" method="post" enctype="multipart/form-data">
			<br style="clear:both">
			<h3 style="margin-bottom: 25px; text-align: center;">Add book details.</h3>
			<div class="form-group">
				<input type="text" class="form-control" id="bookTitle" name="booktitle" placeholder="Book Title" required>
			</div>
			<div class="form-group">
				<div class="form-group">
					<input type="text" class="form-control" id="language" name="language" placeholder="Language" required>
				</div> <input type="text" class="form-control" id="originalTitle" name="originaltitle" placeholder="Original Title" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="authorid" name="authorid" placeholder="AuthorID" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="genre" name="genre" placeholder="Genre" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="yearOfpublication" name="yearofpublication" placeholder="Year Of Publication" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="language" name="language" placeholder="Language" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="millionsold" name="millionssold" placeholder="Millions Sold" required>
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