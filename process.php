<?php
    include 'message.php';
    ini_set('date.timezone','Asia/Taipei');

    if($_POST["userName"] === "" ||
        $_POST["userEmail"] === "" ||
        $_POST["messageTitle"] === "" ||
        $_POST["content"] === ""){
        echo "<meta charset=\"UTF-8\">" . "您有資訊尚未填寫，請填寫所有的資訊！<br>";
        echo "<input type=\"submit\" value=\"返回\" onClick=\"window.history.go(-1)\">";
    }else{

        $all_data = Message::analyze("data.json");

        if($all_data === null) $all_data = array();

        $array_to_store = array(
            'userName' => $_POST["userName"],
            'userEmail' => $_POST["userEmail"],
            'messageTitle' => $_POST["messageTitle"],
            'content' => $_POST["content"],
            'time' => date("y-m-d-H-i-s", time())
        );

        array_push($all_data, $array_to_store);

        Message::storeJSON("data.json", $all_data);

        // $post_data = [$_POST["username"], $_POST["useremail"], $_POST["messagetitle"], $_POST["message"]];
        // $file_save_name = "message/" . date("y-m-d-H-i-s", time()) . ".csv";
        // $fh = fopen($file_save_name, 'w');
        // fputcsv($fh, $post_data);

        header('Location:message_board.php');
        exit;
    }