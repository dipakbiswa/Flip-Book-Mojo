<?php

	session_start();

	$true = false;

	include 'dbcon.php';

	
	if (isset($_GET['email']) && isset($_GET['token'])) {

		$email = $_GET['email'];
		$token = $_GET['token'];

		date_default_timezone_get();
		$date = date("Y-m-d");

		$query = "select * from user where email='$email' and reset_token='$token' and token_expire='$date'";
		$query_run = mysqli_query($conn, $query);

		if ($query_run) {
			if (mysqli_num_rows($query_run)==1) {
				$true = true;
			}
		}
		else{
			$set_password_status = "Link Expired!";
		}
	}

	if (isset($_POST['set_password'])) {
		
		$password = $_POST['new_password'];
		$cpassword = $_POST['new_cpassword'];
		$email = $_POST['email'];

		//Password Encripting
       

        if ($password === $cpassword) {
        	
        	$update_password = "update user SET password='$password', reset_token='NULL',token_expire='NULL' WHERE email= '$email'";
        	$update_password_run = mysqli_query($conn, $update_password);

        	if ($update_password_run) {
        		$set_password_status = "Password Updated! <a href='$app_url/login.php'> Login Now</a>";
        	}
        }
        else{
        	$set_password_status = "Passwords not matched!";
        }
	}
	

?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="FlipBookMojo, Flip Book Creator">
    <meta name="description"
        content="FlipBookMojo | Flip Book Creator">
    <meta name="robots" content="noindex,nofollow">
    <title>Set Password</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <style>
    		.center {
		  margin: auto;
		  width: 100%;
		  border: 1px solid green;
		  padding: 75px;
		  border-radius: 5px;
		}

    </style>
</head>

<body class="app app-reset-password p-0">    	
    <div class="row justify-content-center">
	    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
		    <div class="d-flex flex-column align-content-end">
			    <div class="app-auth-body mx-auto center">	
				    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.php"><img class="logo-icon me-2" src="https://app.flipbookmojo.live/logo.png" style="border-radius: 25px; width: 100%; height: auto;" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-4">Set Your New Password</h2>

					<div class="auth-intro mb-4 text-center">Enter your password below.</div>
					

					<?php  

						if (isset($set_password_status)) {
							?>
								<center><h3 class="auth-heading text-center mb-5" style="color:red;"><?php echo $set_password_status; ?></h3></center>
							<?php
						}

					?>


				<?php 


					if ($true) {
					?>
						<div class="auth-form-container text-left">
							
							<form class="auth-form resetpass-form" action="set-password.php" method="POST">                
								<div class="email mb-3">
									<label class="sr-only" for="reg-email">Password</label>
									<input id="reg-email" name="new_password" type="password" class="form-control login-email" placeholder="New Password" required="required">
								</div><!--//form-group-->
								<div class="email mb-3">
									<label class="sr-only" for="reg-email">Confirm Password</label>
									<input id="reg-email" name="new_cpassword" type="password" class="form-control login-email" placeholder="Confirm Password" required="required">
								</div>
								<div class="text-center">
									<button type="submit" name="set_password" class="btn d-grid btn-danger text-white" style="width:100%;">Reset Password</button>
								</div>


								<input id="reg-email" name="email" type="hidden" class="form-control login-email" value="<?php echo $_GET['email']; ?>" required="required">

							</form>
							
							<div class="auth-option text-center pt-5"><a class="app-link" href="login.php" >Log in</a> <span class="px-2">|</span> <a class="app-link" href="index.php" >Sign up</a></div>
						</div><!--//auth-form-container-->
					<?php	
					}
				?>

			    </div><!--//auth-body-->
		    	
		    </div><!--//flex-column-->   
	    </div><!--//auth-main-col-->
	    
    </div><!--//row-->


</body>
</html> 

