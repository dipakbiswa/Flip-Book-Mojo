<?php

    include '../dbcon.php';


    $link = $_GET['link'];

    //Getting data from image_flipbook
    $image_flipbook_query = "select * from `image_flipbook` where link = '$link'";
    $image_flipbook_query_run = mysqli_query($conn, $image_flipbook_query);

    //fetch data
    $fetch_data = mysqli_fetch_assoc($image_flipbook_query_run);
    $folder = $fetch_data['folder'];

    //Getting folder data
    $folder_data_query = "select * from `$folder` order by position";
    $folder_data_query_run = mysqli_query($conn, $folder_data_query);

    //update views
    if (!isset($_COOKIE['visit'])) {
        setcookie('visit', 'yes', time()+(60*60*24*30));
        mysqli_query($conn,"update `image_flipbook` SET `views` = views+1 WHERE `link` = '$link'");
    }


?>
<!DOCTYPE html>
<html>

<head>
<title><?php echo $fetch_data['name']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css">

<script src="js/flipbook.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        $("#container").flipBook({
            pages:[

                <?php
                    while($row = mysqli_fetch_assoc($folder_data_query_run)) {
                        ?>
                            {src:"<?php echo 'img/'.$folder.'/'.$row['image']; ?>", thumb:"<?php echo 'img/'.$folder.'/'.$row['image']; ?>", title:"Cover"},
                        <?php
                    }
                ?>
                    
                    

                
                /*{src:"images/book2/page2.jpg", thumb:"images/book2/thumb2.jpg", title:"Page two"},
                {src:"images/book2/page3.jpg", thumb:"images/book2/thumb3.jpg", title:"Page three"},
                {src:"images/book2/page4.jpg", thumb:"images/book2/thumb4.jpg", title:""},
                {src:"images/book2/page5.jpg", thumb:"images/book2/thumb5.jpg", title:"Page five"},
                {src:"images/book2/page6.jpg", thumb:"images/book2/thumb6.jpg", title:"Page six"},
                {src:"images/book2/page7.jpg", thumb:"images/book2/thumb7.jpg", title:"Page seven"},
                {src:"images/book2/page8.jpg", thumb:"images/book2/thumb8.jpg", title:"Last"}*/
                
            ]
        });

    })
</script>

</head>

<body>
<div id="container">



</div>
</body>

</html>
