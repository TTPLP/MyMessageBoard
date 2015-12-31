<?php
    include("login_check.ini.php");
    include("message_tb.ini.php");

    $MESSAGES = $_SESSION['message'];

    if($_POST){
        $del = $_POST['del'];


        foreach ($del as $key => $value) {
            $message_to_delete = $MESSAGES[$value];

                $username = $message_to_delete['username'];

            if($_SESSION['username'] != $username){

                $title = $message_to_delete['title'];

                $time = $message_to_delete['time'];

                $sql  = "DELETE FROM message_tb WHERE username='$username' AND title='$title' AND time='$time'";

                $db->query($sql);
            }
        }
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

