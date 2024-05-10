<?php

	session_start();

	//includeing phpMailer
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	include 'dbcon.php';

	if (isset($_POST['reset-password'])) {
		$email = $_POST['reg-email'];

		$check_account_registed_or_not = "select * from user where email='$email'";
		$check_account_registed_or_not_run = mysqli_query($conn, $check_account_registed_or_not);

		$fetch_name = mysqli_fetch_assoc($check_account_registed_or_not_run);

		$check_account_row_no = mysqli_num_rows($check_account_registed_or_not_run);

		if ($check_account_row_no == 1) {

			$reset_token = bin2hex(random_bytes(16));
			date_default_timezone_get();
			$date = date("Y-m-d");

			$update_query = "update user SET reset_token='$reset_token', token_expire ='$date' WHERE email = '$email'";
			$update_query_run = mysqli_query($conn, $update_query);

			if ($update_query_run && sendMail($email, $fetch_name['name'], $reset_token)) {
				$reset_password_status = "Please check your email to set new password!";
			}
			
		}
		else{

			$reset_password_status = "Email not found! Please <a href='$app_url'>Sign Up</a>";
			
			
		}
	}



	//Fetching SMTP Data
    $smtp_query = "select * from smtp where id=1";
    $smtp_query_run = mysqli_query($conn, $smtp_query);
    $smtp_fetch_data = mysqli_fetch_assoc($smtp_query_run);

    $smtp_host = $smtp_fetch_data['host'];
    $smtp_username = $smtp_fetch_data['username'];
    $smtp_password = $smtp_fetch_data['password'];
    $smtp_port = $smtp_fetch_data['port'];


    //Fetching APP Data
    $app_query = "select * from application where id=1";
    $app_query_run = mysqli_query($conn, $app_query);
    $app_fetch_data = mysqli_fetch_assoc($app_query_run);

    $app_name = $app_fetch_data['name'];
    $app_url = $app_fetch_data['url'];
    $app_logo = $app_fetch_data['logo'];
    




	//Send mail function
	function sendMail($email, $name, $reset_token)
    {
    	require 'PHPMailer/PHPMailer.php';
    	require 'PHPMailer/SMTP.php';
    	require 'PHPMailer/Exception.php';

    	$mail = new PHPMailer(true);

    	try {
		    //Server settings
		    $mail->isSMTP();                                            //Send using SMTP
		    $mail->Host       = $smtp_host;                     //Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		    $mail->Username   = $smtp_username;                     //SMTP username
		    $mail->Password   = $smtp_password;                               //SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		    $mail->Port       = $smtp_port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		    //Recipients
		    $mail->setFrom($smtp_username, $app_name);
		    $mail->addAddress($email, $name);     //Add a recipient
		    

		    //Content
		    $mail->isHTML(true);                                  //Set email format to HTML
		    $mail->Subject = 'Reset Password For '.$app_name.' Account';
		    $mail->Body    = "<h4>Hello $name,<br> Thanks for being a member! </h4><br> 
		    					We got a request from you to reset your password!<br>
		    					Click the link below:<br>
		    					<a href='$app_url/set-password.php?email=$email&token=$reset_token'>Reset Password</a><br>
		    					Thank You";

		    $mail->send();
		    return true;
		} catch (Exception $e) {
			return false;
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
    <title>Reset Password</title>
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

<body class="app app-reset-password p-0">    	
    <div class="row justify-content-center">
	    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
		    <div class="d-flex flex-column align-content-end">
			    <div class="app-auth-body mx-auto center">	
				    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.php"><img class="logo-icon me-2" src="https://app.flipbookmojo.live/logo.png" style="border-radius: 25px; width: 100%; height: auto;" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-4">Password Reset</h2>

					<div class="auth-intro mb-4 text-center">Enter your email address below. We'll email you a link to a page where you can easily create a new password.</div>

					<?php  

						if (isset($reset_password_status)) {
							?>
								<center><h3 class="auth-heading text-center mb-5" style="color:red;"><?php echo $reset_password_status; ?></h3></center>
							<?php
						}

					?>
	
					<div class="auth-form-container text-left">
						
						<form class="auth-form resetpass-form" action="reset-password.php" method="POST">                
							<div class="email mb-3">
								<label class="sr-only" for="reg-email">Your Email</label>
								<input id="reg-email" name="reg-email" type="email" class="form-control login-email" placeholder="Your Email" required="required">
							</div><!--//form-group-->
							<div class="text-center">
								<button type="submit" name="reset-password" class="btn d-grid btn-danger text-white" style="width:100%;">Reset Password</button>
							</div>
						</form>
						
						<div class="auth-option text-center pt-5"><a class="app-link" href="index.php" >Log in</a></div>
					</div><!--//auth-form-container-->


			    </div><!--//auth-body-->
		    	
		    </div><!--//flex-column-->   
	    </div><!--//auth-main-col-->
	    
    </div><!--//row-->


</body>
</html> 

