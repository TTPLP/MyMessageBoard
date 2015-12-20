<?php
    include('message.php');

    $all_data = Message::analyze("data.json");

    if($_POST){
        $del = $_POST['del'];
        foreach ($del as $key => $value) {
            unset($all_data[$value]);
            // $del_path = "message/" . $value;
            // if(file_exists($del_path)){
            //     unlink($del_path);
            // }
        }
        Message::storeJSON("data.json", $all_data);
    }

    if($_GET){
        $del = $_GET['del'];
        $del_path = "message/" . $del;
        if(file_exists($del_path)){
            unlink($del_path);
        }
    }

    header('Location:index.php');
    exit;
?>