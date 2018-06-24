<?php include('navigationbar.php'); include('../../model/dbconnection.php');?>
<!doctype html>
<head>
	<title> View Books</title>
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
			<p>View all books.</p>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<?php 
		  
		  $contentquery = "SELECT * FROM book";
		  $stmt = $conn->prepare($contentquery);
		  $stmt->execute();
		  $staticresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
		  foreach($staticresult as $row){}
		  
		  echo'<div class="panel-heading">', '<p>', 'Book Title', '</p>',$row['BookTitle'], '</div>';
		  echo'<div class="panel-heading">', '<p>', 'Year of Publication', '</p>', $row['YearofPublication'], '</div>';
		  echo'<div class="panel-heading">', '<p>', 'Genre', '</p>', $row['Genre'], '</div>';
		  echo'<div class="panel-heading">', '<p>', 'Language', '</p>', $row['LanguageWritten'], '</div>';
		  echo '<div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>';
		  echo '<div class="panel-footer">', '<p>', 'Millions Sold: ', $row['MillionsSold'], '</p>','</div>';
?>
	<a href="#" class="btn btn-primary a-btn-slide-text">
       <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        <span><strong>Delete</strong></span>            
    </a>
	<a href="updatebooks.php" class="btn btn-primary a-btn-slide-text">
       <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        <span><strong>Edit</strong></span>            
    </a>
				
				</div>
			</div>
			<div class="col-sm-4">
				<div class="panel panel-danger">
					<div class="panel-heading">BLACK FRIDAY DEAL</div>
					<div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
					</div>
					<div class="panel-footer">Buy 50 mobiles and get a gift card</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="panel panel-success">
					<div class="panel-heading">BLACK FRIDAY DEAL</div>
					<div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
					</div>
					<div class="panel-footer">Buy 50 mobiles and get a gift card</div>
				</div>
			</div>
		</div>
	</div><br>

	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div class="panel-heading">BLACK FRIDAY DEAL</div>
					<div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
					</div>
					<div class="panel-footer">Buy 50 mobiles and get a gift card</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div class="panel-heading">BLACK FRIDAY DEAL</div>
					<div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
					</div>
					<div class="panel-footer">Buy 50 mobiles and get a gift card</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div class="panel-heading">BLACK FRIDAY DEAL</div>
					<div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
					</div>
					<div class="panel-footer">Buy 50 mobiles and get a gift card</div>
				</div>
			</div>
		</div>
	</div><br><br>

	<footer class="container-fluid text-center">
		<?php include('footer.php');?>
	</footer>

</body>
</html>