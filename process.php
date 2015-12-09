<?php
    include 'message.php';
    ini_set('date.timezone','Asia/Taipei');

    if($_POST["username"] == null){
    }else if($_POST["useremail"] == null){
    }else if($_POST["messagetitle"] == null){
    }else if($_POST["message"] == null){
    }else if($_POST){
        $post_data = array($_POST["username"], $_POST["useremail"], $_POST["messagetitle"], $_POST["message"]);
        $file_save_name = "message/" . date("y-m-d-H-i-s", time()) . ".csv";
        $fh = fopen($file_save_name, 'w');
        fputcsv($fh, $post_data);
        fclose($fh);

        header('Location:index.php');
        exit;
    }

    echo "<meta charset=\"UTF-8\">" . "您有資訊尚未填寫，請填寫所有的資訊！<br>";
    echo "<input type=\"submit\" value=\"返回\" onClick=\"window.history.go(-1)\">";
?>