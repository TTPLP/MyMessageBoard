<?php

    if(!session_id())
        session_start();

    echo"<link href='/css/layout.css' rel='stylesheet' type='text/css' />";

    if(!@$_SESSION["username"]){
        echo "<div class='center_box_text_center'>您尚未登入</div>";
        header("Refresh:3; url=" . url("/index.php"));
        exit();
    }