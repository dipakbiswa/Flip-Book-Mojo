<?php  
	session_start();
	include 'dbcon.php';
	if (isset($_POST['login'])) {
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        $email_query = "select * from user where email = '$email'";
        $email_query_run = mysqli_query($conn, $email_query);

        $email_row = mysqli_num_rows($email_query_run);



        if ($email_row == 0) {
            $login_status = "Email address not found!";
            
        }
        else{
        		$result_fetch = mysqli_fetch_assoc($email_query_run);
        		if ($password === $result_fetch['password']) {
        			
        				if ($result_fetch['is_verified'] == 0) {
		            		$login_status = "Please Verify Your Email!";
			            }
			            else{

				            $_SESSION['username'] = $result_fetch['name'];
				            $_SESSION['email'] = $result_fetch['email'];
				            $_SESSION['phone'] = $result_fetch['phone'];

        
				            //Cookie Set
				            if (isset($_POST['remember_me'])) {
				            	setcookie('email', $email, time() + (60*60+24) );
				            	setcookie('password', $password, time() + (60*60+24) );
				            }
				            else{  //Cookie Unset when Remember Me unset
				            	setcookie('email', '', time() - (60*60+24) );
				            	setcookie('password', '', time() - (60*60+24) );
				            }


				            //Geting Dashboard Data
				            
				            
				            
				            
				            $pdf_flipbook_query = "select * from flipbook where user_email = '$email'";
				            $pdf_flipbook_query_run = mysqli_query($conn, $pdf_flipbook_query);
				            $pdf_flipbook_row_num = mysqli_num_rows($pdf_flipbook_query_run);
				            $_SESSION['pdf_flipbook_row_num'] = $pdf_flipbook_row_num;

				            $img_flipbook_query = "select * from image_flipbook where user_email = '$email'";
				            $img_flipbook_query_run = mysqli_query($conn, $img_flipbook_query);
				            $_SESSION['img_flipbook_row_num'] = mysqli_num_rows($img_flipbook_query_run);


				            
				            
				            
				            $notification_query = "select * from notification";
				            $notification_query_run = mysqli_query($conn, $notification_query);
				            $_SESSION['notification'] = mysqli_num_rows($notification_query_run);

				            
				            
				            //Redirecting to Dashboard Onece Login
				            header('location: dashboard.php');

				            
			        	}
        		}
        		else{
        			$login_status = "Password Incorrect!";
        		}
            
        }

        
    }

    //Cookie Fetch
    if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
		$cookie_email = $_COOKIE['email'];
		$cookie_password = $_COOKIE['password'];
	}
	else{
		$cookie_email = "";
		$cookie_password = "";
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
    <title>Login | FlipBookMojo</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <style type="text/css">
  		.center {
		  margin: auto;
		  width: 100%;
		  border: 1px solid green;
		  padding: 75px;
		  border-radius: 5px;
		}
    </style>
</head>

<body class="app app-login p-0">    	
    <div class="row justify-content-center">
	    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
		    <div class="d-flex flex-column align-content-end">
			    <div class="app-auth-body mx-auto center">	
				    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.php"><img class="logo-icon me-2" src="logo.png" style="border-radius: 25px; width: 100%; height: auto;" alt="logo" align="center"></a></div>
					
						
			        <div class="auth-form-container text-start">

			        	<h2 class="auth-heading text-center mb-5">Log in to Portal</h2>
			        	<?php  

							if (isset($login_status)) {
								?>
									<center><h3 class="auth-heading text-center mb-5" style="color:red;"><?php echo $login_status; ?></h3></center>
								<?php
							}

						?>
						<form class="auth-form login-form" action="login.php" method="POST">         
							<div class="email mb-3">
								<label class="sr-only" for="signin-email">Email</label>
								<input id="signin-email" name="email" type="email" class="form-control signin-email" placeholder="Email address" value="<?php echo $cookie_email; ?>" required="required">
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="signin-password">Password</label>
								<input id="signin-password" name="password" type="password" class="form-control signin-password" placeholder="Password" value="<?php echo $cookie_password; ?>" required="required">
								<div class="extra mt-3 row justify-content-between">
									<div class="col-6">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="remember_me" value="" id="RememberPassword">
											<label class="form-check-label" for="RememberPassword">
											Remember me
											</label>
										</div>
									</div>
									<div class="col-6">
										<div class="forgot-password text-end">
											<a href="reset-password.php">Forgot password?</a>
										</div>
									</div>
								</div>
							</div><br>
							<div class="text-center">
								<button type="submit" name="login" class="btn d-grid btn-danger text-white" style="width:100%;">Log In</button>
							</div>
						</form>
						
						<div class="auth-option text-center pt-5">No Account? Sign up <a class="text-link" href="https://flipbookmojo.live/" >here</a>.</div>
					</div>

			    </div>
		    
			    
		    </div>
	    </div>
	    
    
    </div>

</body>
</html> 

