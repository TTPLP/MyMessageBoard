<?php
    include('message.php');

    $all_data = Message::analyze("data.json");

    if($_POST){
        $del = $_POST['del'];
        foreach ($del as $key => $value) {
            if($all_data[$value] !== null){
                unset($all_data[$value]);
            }
        }
        Message::storeJSON("data.json", $all_data);
    }

    if($_GET){
        $del_index = $_GET['del'];
        if($all_data[$del_index] !== null){
            unset($all_data[$del_index]);
        }
        Message::storeJSON("data.json", $all_data);
    }

    header('Location:message_board.php');
    exit;
?>