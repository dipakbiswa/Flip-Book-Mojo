<?php session_start(); ?>
<?php 
    if (!isset($_SESSION['username'])) {
        header("location: ../login.php");
    }
?>

<?php
	include '../dbcon.php';
	if (isset($_POST['submit'])) {

		$name = $_POST['name'];

        //echo "<pre>";
        //print_r($_FILES['file']);
        
		$file_name = $_FILES['file']['name'];
		$file_type = $_FILES['file']['type'];
		$temp_name = $_FILES['file']['tmp_name'];

		$link = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))).time();

		$email = $_SESSION['email'];

        $rand = rand(111111111, 999999999);
		$target_dir = "img/$rand";
		$target_file = $target_dir . basename($file_name);
		
		if ($file_type === 'application/x-zip-compressed') {
			
            $zip = new ZipArchive();
            if ($zip->open($temp_name) === TRUE) {

                $zip->extractTo($target_dir);
                $zip->close();
                
                $images = scandir($target_dir);
                
                //Create Table with folder name
                $create_table_query = "create TABLE `$rand` (`id` INT NOT NULL AUTO_INCREMENT , `image` VARCHAR(255) NOT NULL , `position` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
                $create_table_query_run = mysqli_query($conn, $create_table_query);

                $image_position = 1;

                foreach($images as $list){

                    if (strlen($list) > 4) {

                        $insert_image = mysqli_query($conn, "insert INTO `$rand`(`image`, `position`) VALUES ('$list','$image_position')");
                        $image_position++;
                    }
                    
                }

                //Creating actual flipbook
                $create_flipbook_query = "insert INTO `image_flipbook`(`name`, `folder`, `link`, `user_email`) VALUES ('$name','$rand','$link','$email')";
                $create_flipbook_query_run = mysqli_query($conn, $create_flipbook_query);

                if ($create_flipbook_query_run) {
                    header("location: ../img-flip-books/index.php");
                }



            }
            else{
                $error_msg = "Something went wrong!";
            }

		}
		else{
			$error_msg = "Please upload a ZIP file!";
		}
	}


?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

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
    <title>Image to Flip Book</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="../css/style.min.css" rel="stylesheet">

    <style type="text/css">
        
		.center {
		  margin: auto;
		  width: 50%;
		  padding: 10px;
		}
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->

        <?php include '../header.php'; ?>
        <?php include '../nav.php'; ?>
        


        
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Image to Flip-Books</h4>
                    </div>

                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Three charts -->
                <!-- ============================================================== -->
                <div class="row justify-content-center">
                    


                    
                    <div class="container table-responsive py-5 center"> 
                    	<h4 align="center">Create Flip-Book with Image</h4>
                    	<h5 align="center" style="color:red;">
                    		<?php 
                    			if (isset($error_msg)) {
                    				echo $error_msg;
                    			}
                    	 	?>	
                    	 </h5>
                    	<br><hr><br>
                    	<form method="post" action="#" enctype="multipart/form-data">
							  <div class="mb-3">
							    <label for="exampleInputEmail1" class="form-label">Enter Name:</label>
							    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name" required>
							    
							  </div>
							  <div class="mb-3">
							    <label for="exampleInputPassword1" class="form-label">Upload Image zip:</label>
							    <input type="file" name="file" class="form-control" id="exampleInputPassword1" required>
							  </div>
							  
							  <center><button type="submit" name="submit" class="btn btn-primary">Create</button></center>
						</form>
                    </div>



                </div>
                

                
            <!-- footer -->
            <!-- ==============================================================
            <footer class="footer text-center"> 2022 © Printable Maker <a
                    href="https://www.dipakbiswakarma.com/">dipakbiswakarma.com</a>
            </footer>
            ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/app-style-switcher.js"></script>
    <script src="../plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="../js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="../plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="../plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../js/pages/dashboards/dashboard1.js"></script>
</body>

</html>