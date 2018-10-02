<!doctype html>

<body style="height:1500px">

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">My Books</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="active"><a href="viewbooks.php">View Books</a>
				</li>
				<li><a href="addbooks.php">Add Books</a>
				</li>
				<?php if($_SESSION['role'] == 1){
	echo '<li><a href="register.php">Register New User</a></li>';
} 
				?>
				<li><a href="../../control/logout_process.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>
	
