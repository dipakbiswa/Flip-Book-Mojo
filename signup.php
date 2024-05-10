<?php

	session_start();

	//includeing phpMailer
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;


    include 'dbcon.php';

    if (isset($_POST['signup'])) {
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

       $email_query = "select * from user where email = '$email'";
       $email_query_run = mysqli_query($conn, $email_query);

       $email_row = mysqli_num_rows($email_query_run);

       if ($email_row>0) {
           $signup_status = "Email Already Registed";
       }else{
        if ($password === $cpassword) {

        	//Verification Code Generate
        	$verification_code = bin2hex(random_bytes(16));

        
        	

            $insert_query = "insert into user(name, email, phone, password, verification_code, is_verified) values('$name', '$email', '$phone', '$password','$verification_code','0')";
            $insert_query_run = mysqli_query($conn, $insert_query);
            if ($insert_query_run && sendMail($email, $name, $verification_code)) {
                $signup_status = "Account Created Successfully! Please check your email and verify your account! Also check spam folder!";
            }
        }
        else{
            $signup_status = "Passwords are not matched!";
        }
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




    function sendMail($email, $name, $verification_code)
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
		    $mail->Subject = 'Email Verification From '.$app_name;
		    $mail->Body    = "<h4>Hello $name,<br> Thanks for registration! </h4><br> 
		    					<a href='$app_url/verify.php?email=$email&verification_code=$verification_code'>Click Here</a> to verify you Account.<br>
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
    <title>Signup <?php echo $app_name; ?></title>
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

<body class="app app-signup p-0">  

    <div class="row justify-content-center">
	    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
		    <div class="d-flex flex-column align-content-end">
			    <div class="app-auth-body mx-auto center">	
				    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.php"><img class="logo-icon me-2" src="https://app.flipbookmojo.live/logo.png" style="border-radius: 25px; width: 100%; height: auto;" alt="logo"></a></div>
				    <hr>
					<h2 class="auth-heading text-center mb-4">Sign up to Portal</h2>
					<h3 class="auth-heading text-center mb-4">Thank You For Your Purchase!</h3>
					<h4 class="auth-heading text-center mb-4">Note: The withdrawal from your account will be done by WarriorPlus</h4>
						<p>Must create your account with the email you purchess this software.</p>
					<hr>	
										
					<?php  

						if (isset($signup_status)) {
							?>
								<center><h3 class="auth-heading text-center mb-5" style="color:red;"><?php echo $signup_status; ?></h3></center>
							<?php
						}

					?>
					<div class="auth-form-container text-start mx-auto">
						<form class="auth-form auth-signup-form" action="#" method="POST">         
							<div class="email mb-3">
								<label class="sr-only" for="signup-email">Your Name</label>
								<input id="signup-name" name="name" type="text" class="form-control signup-name" placeholder="Full name" required="required">
							</div>
							<div class="email mb-3">
								<label class="sr-only" for="signup-email">Your Email</label>
								<input id="signup-email" name="email" type="email" class="form-control signup-email" placeholder="Email" required="required">
							</div>
							<div class="email mb-3">
								<label class="sr-only" for="signup-phone">Your Phone</label>
								<input id="signup-email" name="phone" type="text" class="form-control signup-email" placeholder="Phone" required="required">
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="signup-password">Password</label>
								<input id="signup-password" name="password" type="password" class="form-control signup-password" placeholder="Create a password" required="required">
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="signup-password">Confirm Password</label>
								<input id="signup-password" name="cpassword" type="password" class="form-control signup-password" placeholder="Confirm your password" required="required">
							</div>
							<div class="extra mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="RememberPassword" required>
									<label class="form-check-label" for="RememberPassword">
									I agree to Portal's <a href="https://flipbookmojo.live/terms-and-conditions/" class="app-link" target="_blank">Terms of Service</a> and <a href="https://flipbookmojo.live/privacy-policy/" class="app-link" target="_blank">Privacy Policy</a>.
									</label>
								</div>
							</div><!--//extra-->
							<br>
							<div class="text-center">
								<button type="submit" name="signup" class="btn d-grid btn-danger text-white" style="width:100%;">Sign Up</button>
							</div>
						</form><!--//auth-form-->
						
						<div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="index.php" >Log in</a></div>
					</div><!--//auth-form-container-->	
					
					
				    
			    </div><!--//auth-body-->
		    
			    
		    </div><!--//flex-column-->   
	    </div><!--//auth-main-col-->
	    
    </div><!--//row-->


</body>
</html> 

