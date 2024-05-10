<?php
    
    include '../dbcon.php';
    if(isset($_GET['link'])){

        $link = $_GET['link'];
        $query = "select * from flipbook where link = '$link'";
        $query_run = mysqli_query($conn, $query);

        $row = mysqli_fetch_assoc($query_run);


        //update views
        if (!isset($_COOKIE['visit'])) {
            setcookie('visit', 'yes', time()+(60*60*24*30));
            mysqli_query($conn,"update `flipbook` SET `views` = views+1 WHERE `link` = '$link'");
        }
    }


?>

<!DOCTYPE html>
<html>

<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>

<link rel="stylesheet" type="text/css" href="css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css">

<script src="js/flipbook.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        $("#container").flipBook({
            pdfUrl:"pdf/<?php echo $row['pdf_name']; ?>",
        });

    })

</script>
<title><?php echo $row['name']; ?></title>
</head>

<body>
<div id="container">
    <p>Real 3D Flipbook has lightbox feature - book can be displayed in the same page with lightbox effect.</p>
    <p>Click on a book cover to start reading.</p>
    <img src="images/book2/thumb1.jpg" />
</div>

</body>

</html>
