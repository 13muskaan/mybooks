<?
$whoCanAccess = [ 0 ];

include( 'header.php' );
?>

<head>
	<title>Login</title>
	<script>
		$( document ).ready( function () {
			$( '.forgot-pass' ).click( function ( event ) {
				$( ".pr-wrap" ).toggleClass( "show-pass-reset" );
			} );

			$( '.pass-reset-submit' ).click( function ( event ) {
				$( ".pr-wrap" ).removeClass( "show-pass-reset" );
			} );
		} );
	</script>
	<link href="../css/loginregister_stylesheet.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="pr-wrap">
					<div class="pass-reset">
						<label> Enter the email you signed up with</label>

						<input type="email" placeholder="Email"/>
						<input type="submit" value="Submit" class="pass-reset-submit btn btn-success btn-sm"/>
					</div>
				</div>
				<div class="wrap">
					<div class="text-center">
						<img src="../img/logo.png" style="padding-top: " width="400px" class="avatar img-circle img-thumbnail" alt="avatar">
						<div class="row">

						</div>
						<form class="login" action="../../control/login_process.php" method="post">
							<p class="form-title">
								Sign In</p>
							<p style="color: aliceblue; text-align: center;"> Please sign in to have access.</p>
							<!-- error messages-->
							<?php include ('../../model/message_boxes.php'); ?>
							<input type="text" placeholder="Email" name="email" style="text-align: center" required/>
							<input type="password" placeholder="Password" name="pass" style="text-align: center" required/>
							<input type="submit" value="Sign In" class="btn btn-success btn-sm"/>
						</form>
					</div>
				</div>
			</div>
		</div>
</body>
</html>