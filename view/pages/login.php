<? include('header.php');?>
<!doctype html>
<html>
<head>
	<!--<meta charset="UTF-8">-->
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
						<label>
                        Enter the email you signed up with</label>
					
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
						<input type="text" placeholder="Email"/>
						<input type="password" placeholder="Password"/>
						<input type="submit" value="Sign In" class="btn btn-success btn-sm"/>
						<div class="remember-forgot">
							<div class="row">
								<div class="col-md-6">
									<div class="checkbox">
										<label>
                                    <input type="checkbox" />
                                    Remember Me
                                </label>
									
									</div>
								</div>
								<div class="col-md-6 forgot-pass-content">
									<a href="javascription:void(0)" class="forgot-pass">Forgot Password</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="posted-by"><a href="register.php">Register an account</a>
		</div>
	</div>

</body>
</html>