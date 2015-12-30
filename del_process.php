<?php


    if($_POST){
        $del = $_POST['del'];
        foreach ($del as $key => $value) {
            if($all_data[$value] !== null){
                unset($all_data[$value]);
            }
        }
    }

    $sql = "DELETE FROM message_tb "
    . "WHERE title='$_SESSION[]'";

    if($_GET){
        $del_index = $_GET['del'];
        if($all_data[$del_index] !== null){
            unset($all_data[$del_index]);
        }
        Message::storeJSON("data.json", $all_data);
    }

    header('Location:message_board.php');
    exit;


    function deleteDataAtIndex($index){

    }
?>

