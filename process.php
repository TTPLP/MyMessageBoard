<?php
    include 'message.php';
    ini_set('date.timezone','Asia/Taipei');

    if($_POST){
        $post_data = array($_POST["username"], $_POST["useremail"], $_POST["messagetitle"], $_POST["message"]);
        $file_save_name = "message/" . date("y-m-d-H-i-s", time()) . ".csv";
        $fh = fopen($file_save_name, 'w');
        fputcsv($fh, $post_data);
        fclose($fh);
    }
    header('Location:index.php');
    exit;
?>