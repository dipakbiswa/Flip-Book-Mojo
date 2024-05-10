<?php session_start(); ?>
<?php 
    if (!isset($_SESSION['username'])) {
        header("location: ../login.php");
    }
    include '../dbcon.php';
    

    //pagination Code
    $limit = 5;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }
    $offset = ($page -1) * $limit;



    //selection code
    $email = $_SESSION['email'];
    $query = "select * from `image_flipbook` where `user_email` = '$email' order by id desc limit {$offset}, {$limit}";
    $query_run = mysqli_query($conn, $query);
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
    <title>Image flip-books</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
    <!-- Custom CSS -->
    <link href="../plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="../css/style.min.css" rel="stylesheet">
    <style type="text/css">
        .table-button-delete{
            border: 1px soid #000;
            padding: 10px;
            background: red;
            color: #fff;
            border-radius: 100px;
            text-decoration: none;
        }
        .table-button-share{
            border: 1px soid #000;
            padding: 10px;
            background: green;
            color: #fff;
            border-radius: 100px;
            text-decoration: none;
        }
        .table-button-show{
            border: 1px soid #000;
            padding: 10px;
            background: blue;
            color: #fff;
            border-radius: 100px;
            text-decoration: none;
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
                        <h4 class="page-title">Image FlipBooks                       </h4>
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
                <p align="right"><a href="../create-img-flip-book/index.php" class="btn btn-primary" ><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;New Project</a></p>
                <!-- ============================================================== -->
                <!-- Three charts -->
                <!-- ============================================================== -->
                <div class="row justify-content-center">
                    
                    
                    
                    <div class="container table-responsive py-5"> 
                    <table class="table table-bordered table-hover">
                      <thead class="thead-dark">
                        <tr align="center">
                          <th scope="col">#id</th>
                          <th scope="col">Name</th>
                          <th scope="col">Show</th>
                          <th scope="col">Views</th>
                          <th scope="col">Share</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Delete</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                            
                            while($row = mysqli_fetch_assoc($query_run)){
                                ?>
                                
                                    <tr align="center">
                                      <th scope="row"><?php echo $row['id']; ?></th>
                                      <td><?php echo $row['name']; ?></td>

                                      <td>
                                        <a href="https://app.flipbookmojo.live/create-img-flip-book/flipbook.php?link=<?php echo $row['link']; ?>" target="_blank" class="btn btn-primary">Show</a>
                                      </td>

                                      <td><?php echo $row['views']; ?></td>

                                      <td>
                                        <label>Link: </label>
                                        <input type="text" value="https://app.flipbookmojo.live/create-img-flip-book/flipbook.php?link=<?php echo $row['link']; ?>" name="" id="myLink">
                                        <br>
                                        <label>Embed Code: </label>
                                        <input type="text" value="<iframe src='https://app.flipbookmojo.live/create-img-flip-book/flipbook.php?link=<?php echo $row['link']; ?>' width='900' height='450' frameborder='0' allowfullscreen></iframe>" name="" id="myLink">
                                        
                                      </td>

                                      <td>
                                        <form action="#" method="POST">
                                            <input type="hidden" name="editid" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="edit" href="" class="btn btn-secondary"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                        </form>
                                      </td>

                                      <td>
                                        <form action="#" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete" href="" class="btn btn-danger"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
                                        </form>
                                      </td>


                                    </tr>


                                <?php
                            }
                            ?>

                            <?php
                                //Edit Working
                                if (isset($_POST['edit'])) {
                                    $id = $_POST['editid']; //geting id
                                    ?>
                                        <script type="text/javascript">
                                            window.location = "edit.php?id=<?php echo $id; ?>";
                                        </script>
                                    <?php
                                }

                            ?>

                            <?php

                            //Delete Working

                            if (isset($_POST['delete'])) {
                               
                                $id = $_POST['id']; //geting id


                                //select the image_flipbook
                                $select_data_query = "select * from `image_flipbook` where id = '$id'";
                                $select_data_query_run = mysqli_query($conn, $select_data_query);
                                $fetch_folder_data = mysqli_fetch_assoc($select_data_query_run);


                                //fetching folder name
                                $folder_name = $fetch_folder_data['folder'];

                                $select_image_query = "select * from `$folder_name`";
                                $select_image_query_run = mysqli_query($conn, $select_image_query);

                                $image_path = "../create-img-flip-book/img";

                                //deleteing images from the folder
                                while($fetct_image_name = mysqli_fetch_assoc($select_image_query_run)){
                                    unlink($image_path.'/'.$folder_name.'/'.$fetct_image_name['image']);
                                }

                                //deleteing folder name
                                rmdir($image_path.'/'.$folder_name);

                                $delete_folder_table = "drop table `$folder_name`";

                                $delete_query = "delete FROM `image_flipbook` WHERE id='$id'"; //query to delete
                                
                                
                                $delete_folder_table_run = mysqli_query($conn, $delete_folder_table);

                                $delete_query_run = mysqli_query($conn, $delete_query);



                                if ($delete_query_run and $delete_folder_table_run) {
                                    ?>
                                        <script type="text/javascript">
                                            window.location = "delete.php";
                                        </script>
                                    <?php
                                }
                            }
                        ?>
                        
                      </tbody>
                    </table>
                    </div>
                    <nav class="app-pagination mt-5">

                    <?php 


                        $pageination = "select * from image_flipbook";
                        $pageination_run = mysqli_query($conn, $pageination);



                        if (mysqli_num_rows($pageination_run) > 0) {
                            $total_records = mysqli_num_rows($pageination_run);
                            
                            $total_pages = ceil($total_records / $limit);


                            echo '<ul class="pagination justify-content-center">';
                            if ($page > 1) {
                                echo '<li class="page-item">
                                        <a class="page-link" href="index.php?page='.($page - 1).'" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>';
                            }
                            
                            for ($i=1; $i <= $total_pages ; $i++) { 
                                if ($i == $page) {
                                    $active = "active";
                                }
                                else{
                                    $active = "";
                                }
                                echo '<li class="page-item '.$active.'"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
                            }
                            if ($total_pages > $page) {
                                echo '<li class="page-item">
                                        <a class="page-link" href="index.php?page='.($page + 1).'">Next</a>
                                    </li>';
                            }
                            
                            echo '</ul>';
                        }
                    ?>
                    
                        <!--
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        -->
                    
                </nav><!--//app-pagination-->
                    <!--<nav aria-label="Page navigation example">
                      
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                      
                   </nav>-->
                    
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