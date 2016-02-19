<?php
    if(!session_id())
        session_start();

    if(!$_SESSION["username"]){
        showAlertView("登入失敗！");
        header("Location:index.php");
    }

    function showAlertView($message){
        echo "<script type='text/javascript'>";
        echo "alert(\"". $message ."\")";
        echo "</script>";
    }