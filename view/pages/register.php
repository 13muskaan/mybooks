<?

// Page protector
$whoCanAccess = [ 1 ];

include( 'header.php' );
include( 'navigationbar.php' );
?>

<head>

	<title>Register</title>
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
				<div class="wrap">
					<form class="login" action="../../control/register_process.php" method="post">
						<p class="form-title">
							Register</p>
						<p style="color: aliceblue; text-align: center;"> Please fill in your information to create an account.</p>
						<input type="text" placeholder="Email" name="email" min="2" max="5" required/>
						<input type="password" placeholder="Password" name="pass" required/>
						<input type="text" placeholder="First Name" name="firstname" required/>
						<input type="text" placeholder="Last Name" name="lastname" required/>
						<select class="form-control" name="role">
							<option value="2">Normal User</option>
							<option value="1">Admin</option>
						</select>

						<?php include ('../../model/message_boxes.php'); ?>

						<input type="submit" value="Register" class="btn btn-success btn-sm"/>
					</form>
				</div>
			</div>
		</div>
	</div>

</body>
</html>