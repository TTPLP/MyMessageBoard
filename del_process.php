<?php
    if($_POST){
        $del = $_POST['del'];
        foreach ($del as $key => $value) {
            $del_path = "message/" . $value;
            if(file_exists($del_path)){
                unlink($del_path);
            }
        }
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