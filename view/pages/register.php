<? include('header.php');?>
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
						<input type="text" placeholder="Email"/>
						<input type="password" placeholder="Password"/>
						<input type="text" placeholder="First Name"/>
						<input type="text" placeholder="Last Name"/>
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