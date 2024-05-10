<?php session_start(); ?>
<?php 
    if (!isset($_SESSION['username'])) {
        header("location: login.php");
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
    <title>Dashboard | Printable Maker</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    
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

        <?php include 'header.php'; ?>
        <?php include 'nav.php'; ?>
        


        
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4>
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
                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <center><h3 class="box-title"><i class="fas fa-file-pdf"></i> My PDF FlipBooks</h3>
                                <h1 class="box-title" style="font-size: 30px;">
                                    <?php
                                        echo $_SESSION['pdf_flipbook_row_num'];
                                    ?>
                                </h1>
                            </center>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <center><h3 class="box-title"><i class="fas fa-image"></i> My Image FlipBooks</h3>
                                <h1 class="box-title" style="font-size: 30px;">
                                    
                                    <?php
                                        echo $_SESSION['img_flipbook_row_num'];
                                    ?>
                                </h1>
                            </center>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <center><h3 class="box-title"><i class="fas fa-gem"></i> Pre Made Books</h3>
                                <h1 class="box-title" style="font-size: 30px;"><?php echo $_SESSION['premade_row_num']; ?></h1>
                            </center>
                        </div>
                    </div>

                    <hr>

                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <center><h3 class="box-title"><i class="far fa-file-alt"></i> Pre Made Articles</h3>
                                <h1 class="box-title" style="font-size: 30px;"><?php echo $_SESSION['premade_articles_row_num']; ?></h1>
                            </center>
                            
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <center><h3 class="box-title"><i class="fas fa-bell"></i> Notification</h3>
                                <h1 class="box-title" style="font-size: 30px;">
                                    <?php
                                        echo $_SESSION['notification'];
                                    ?>
                                </h1>
                            </center>
                            
                        </div>
                    </div>

                    <!--<div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <center><h3 class="box-title">To-Do List Builder</h3>
                                <a href="todo"><img src="dashboard-img/todo.gif" width="250px" height="250px"></a>
                            </center>
                            
                        </div>
                    </div>
                    <hr>

                    
                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <center><h3 class="box-title">Game Builder</h3>
                                <a href="game"><img src="dashboard-img/game.gif" width="250px" height="250px"></a>
                            </center>
                            
                        </div>
                    </div>
                </div>-->
                
                
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2023 © FlipBookMojo <a
                    href="https://www.dipakbiswakarma.com/">dipakbiswakarma.com</a>
            </footer>
            <!-- ============================================================== -->
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
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="js/pages/dashboards/dashboard1.js"></script>
</body>

</html>