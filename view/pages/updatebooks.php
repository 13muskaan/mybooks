<?php
$whoCanAccess = [1,2];
include('header.php');
include( 'navigationbar.php' );

include( '../../model/dbconnection.php' );

$selectsql = "SELECT * FROM book WHERE BookID = :id";

$stmt = $conn->prepare( $selectsql );

$stmt->bindParam( ':id', $_GET[ 'UpdateID' ], PDO::PARAM_INT );
//
$stmt->execute();

$row = $stmt->fetch();

?>
<!doctype html>
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
</head>
<body>

	<div class="jumbotron">
		<div class="container text-center">
			<h1>My Books</h1>
			<p>Update Books</p>
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
	
	<a href="viewbooks.php" class="btn btn-primary a-btn-slide-text" style="align-items: center;">
       <span class="glyphicon glyphicon-back" aria-hidden="true"></span>
        <span><strong>Go Back</strong></span>            
    </a>


	<div class="container1" align="center" ; width="20%;">
		<!--<form role="form" width="50%;" method="post" action="../../control/managebooks_process.php?UpdateID=<?php //echo $row['BookID']; ?>">-->


		<form role="form" width="50%" method="post" action="../../model/managebooks_process.php?UpdateID=<?php echo $_GET['UpdateID']; ?>">
			<br style="clear:both">
			<h3 style="margin-bottom: 25px; text-align: center;">Update book details.</h3>
			<div class="form-group">
				<input type="text" class="form-control" id="bookTitle" name="newbooktitle" placeholder="Book Title" value="<?php echo $row['BookTitle']; ?>" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="authorid" name="authorid" placeholder="AuthorID" value="<?php echo $row['AuthorID']; ?>" required>
			</div>
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