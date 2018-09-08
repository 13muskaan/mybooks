<? include('header.php');?> <!-- use transactions. -->
<!doctype html>
<html>
<head>
	<!--<meta charset="UTF-8">-->
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
						
						<?php
				if ( isset( $_SESSION[ 'error' ] ) ) {
					if ( $_SESSION[ 'error' ] != "" ) {
						echo '<div class="alert alert-danger"><strong>ERROR: </strong>' . $_SESSION[ 'error' ] . '</div>';
						$_SESSION[ 'error' ] = "";
					}
				}
				?>
						
						<input type="submit" value="Register" class="btn btn-success btn-sm"/>
					</form>
				</div>
			</div>
		</div>
		<div class="posted-by"><a href="login.php">Login</a>
		</div>
		</div>
</body>
</html>