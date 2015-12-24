<?php
    session_start();
    include 'message.php';
    ini_set('date.timezone','Asia/Taipei');

    $all_data = Message::analyze("data.json");
    $key = $_GET['key'];

    if($_GET !== null){
        if($_POST !== null){
            $content = $_POST['content'];
            $messageTitle = $_POST['messageTitle'];

            $all_data[$key]['content'] = $content;
            $all_data[$key]['messageTitle'] = $messageTitle;
            $all_data[$key]['time'] = date("y-m-d-H-i-s", time());
        }
    }

    Message::storeJSON("data.json", $all_data);

    header("Location:show.php?index=$key");
