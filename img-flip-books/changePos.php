<?php 
    session_start();

    require('../dbcon.php');


    $position = $_POST['position'];
    $folder_name = $_SESSION['folder_name'];

    
        $post_order = isset($_POST["post_order_ids"]) ? $_POST["post_order_ids"] : [];
 
            if(count($post_order)>0){
                for($order_no= 0; $order_no < count($post_order); $order_no++)
                {
                    $query = "update `$folder_name` SET `position` = '".($order_no+1)."' WHERE id = '".$post_order[$order_no]."'";
                    mysqli_query($conn, $query);
                }
                    echo true; 
                }else{
                    echo false; 
                }
        


?>