<?php session_start(); ?>
<?php 
    if (!isset($_SESSION['username'])) {
        header("location: ../login.php");
    }
    include '../dbcon.php';
    
    $id = $_GET['id'];    
    if (!isset($_GET['id'])) {
            header("location: index.php");
        }    
    include("../dbcon.php");

    //select folder from image_flipbook table
    $select_folder_query = "select * from `image_flipbook` where id = '$id'";
    $select_folder_query_run = mysqli_query($conn, $select_folder_query);
    $fetch_folder_name = mysqli_fetch_assoc($select_folder_query_run);
    $folder_name = $fetch_folder_name['folder'];
    $_SESSION['folder_name'] = $folder_name;

    //getting folder data
    $folder_query = "select * from `$folder_name` order by position asc";
    $folder_query_run = mysqli_query($conn, $folder_query);

    $folder_num_row = mysqli_num_rows($folder_query_run);
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
    <title>Edit | FlipBookMojo</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
    <!-- Custom CSS -->
    <link href="../plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="../css/style.min.css" rel="stylesheet">



    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    
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
                    <center><h2>Drag and Drop Images to Arrange Order</h2></center>
                    <hr>

                            <div class="alert icon-alert with-arrow alert-success form-alter" role="alert">
                                <i class="fa fa-fw fa-check-circle"></i>
                                <strong> Success ! </strong> <span class="success-message"> Image Order has been updated successfully </span>
                            </div>
                            <div class="alert icon-alert with-arrow alert-danger form-alter" role="alert">
                                <i class="fa fa-fw fa-times-circle"></i>
                                <strong> Note !</strong> <span class="warning-message"> Empty list can't be Process </span>
                            </div>
                    
                        <ul class="list-unstyled list-group list-group-horizontal position-relative overflow-auto w-75" id="post_list">
                            

                            <?php
                                $row_number = mysqli_num_rows($folder_query_run);
                                if ($row_number > 0) {
                                    while($row = mysqli_fetch_assoc($folder_query_run)){
                                        $id = $row['id']; 
                                        $name = $row['image'];
                                        $location = "../create-img-flip-book/img/".$folder_name."/".$name;
                                        ?>
                                            <li class="list-group-item" data-post-id="<?php echo $row["id"]; ?>">
                                                 <div class="li-post-group">
                                                 <!--<h5 class="li-post-title"><?php //echo $row["id"]; ?></h5>-->
                                                 <img style="width: 200px;" class="li-post-desc" src="<?php echo $location; ?>">
                                                 </div>
                                            </li>
                                            <br>

                                        <?php
                                }
                            }
                                ?>
                                


                          </ul>
                          <br><br>
                    

                    
                </div>

                <script type="text/javascript">

                    $(".alert-danger").hide();
                    $(".alert-success").hide();



                    $( "#post_list" ).sortable({
                     placeholder : "ui-state-highlight",
                     update  : function(event, ui)
                     {
                     var post_order_ids = new Array();
                     $('#post_list li').each(function(){
                     post_order_ids.push($(this).data("post-id"));
                     });
                     $.ajax({
                     url:"changePos.php",
                     method:"POST",
                     data:{post_order_ids:post_order_ids},
                     success:function(data)
                     {
                     if(data){
                     $(".alert-danger").hide();
                     $(".alert-success ").show();
                     }else{
                     $(".alert-success").hide();
                     $(".alert-danger").show();
                     }
                     }
                     });
                     }
                    });
                    
                </script>
                <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

                <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/draggable/1.0.0-beta.12/draggable.min.js"></script>
                
                
            <!-- footer 
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