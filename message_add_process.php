<?php
    include("login_check.ini.php");
    include("message_tb.ini.php");

    $id = $_SESSION['username'];
    $email = $_SESSION['email'];

    $title = $_POST["title"];
    $content = $_POST["content"];

    if($title == null || $content == null){
        echo "您有資訊尚未填寫，請填寫所有的資訊！";
        echo '<meta http-equiv=REFRESH CONTENT=3;url=message_board.php>';
    }else{

        $sql = "INSERT INTO message_tb (username, email, title, content) VALUES ('$id', '$email', '$title', '$content')";

        $db->query($sql);

        header('Location:prepare_data.php');
        exit;
    }