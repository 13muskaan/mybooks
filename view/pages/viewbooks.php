<?php
// Page protector
$whoCanAccess = [ 1, 2 ];

include( 'header.php' );
include( 'navigationbar.php' );

?>
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
			<p>
				<?php 
				
				// Code to show user information.
				$stmt = $conn->prepare("SELECT * FROM login INNER JOIN users ON login.loginID = users.loginID WHERE userID = " . $_SESSION['userID']);
				
				$stmt->execute();
				
				$res = $stmt->FetchAll()[0];
				
				echo "Current User: " . $res['firstname'] . " " . $res['lastname'] . " (";
				
				if ($_SESSION['role'] == 1) {
					echo "admin";
				} else {
					echo "user";
				}
				echo ")"; ?>
			</p>
		</div>
	</div>
	<br>

	<?php include ('../../model/message_boxes.php'); ?>

	<div class="container">
		<?php 
		  // Code to show all books and author information from the database. 
		  $contentquery = "SELECT * FROM book INNER JOIN author ON book.AuthorID = author.AuthorID";
		  $stmt = $conn->prepare($contentquery);
		  $stmt->execute();
		  $staticresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
		  echo '<div class="row">';
		
		$count = -1;
		
		  foreach($staticresult as $row) {
			  if ($row['AuthorID'] == 0) {
				continue;  
			  }
			  
			  if ($count % 3 == 2) {
				  echo '</div> <div class="row">';
			  }
			  
		  echo'<div class="col-sm-4"> 
		  			<div class="panel panel-primary">';
		  echo'<div class="panel-heading" style="background-color: #69C">', '<p><strong>', 'Book Title', '</strong></p>',$row['BookTitle'], '</div>';
		  echo'<div class="panel-heading">', '<p><strong>', 'Author', '</strong></p>',$row['Name'] . " " . $row['Surname'], '</div>';
		  echo'<div class="panel-heading" style="background-color: #69C">', '<p><strong>', 'Year of Publication', '</strong></p>', $row['YearofPublication'], '</div>';
		  echo'<div class="panel-heading">', '<p><strong>', 'Genre', '</strong></p>', $row['Genre'], '</div>';
		  echo'<div class="panel-heading" style="background-color: #69C">', '<p><strong>', 'Language', '</strong></p>', $row['LanguageWritten'], '</div>';
		  echo '<div class="panel-body"><img src="', "../" . $row['CoverImage'] ,'" class="img-responsive" style="width:100%" alt="Image"></div>';
		  echo '<div class="panel-footer">', '<p><strong>', 'Millions Sold: ', $row['MillionsSold'], '</strong></p>','</div>';
			  
			echo '<a href="../../model/managebooks_process.php?DeleteID='. $row['BookID'] .'" class="btn btn-primary a-btn-slide-text">
       <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        <span><strong>Delete</strong></span>            
    </a>
				
					<a href="updatebooks.php?UpdateID='. $row['BookID'] .'" class="btn btn-primary a-btn-slide-text">
       <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        <span><strong>Edit</strong></span>            
    </a>';
		
			echo '</div>
			</div>';
			 
			  $count++;
		  }
?>
	</div>
	</div>
	<br><br>
	<footer class="container-fluid text-center">
		<?php include('footer.php');?>
	</footer>

</body>
</html>