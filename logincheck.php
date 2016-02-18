<?php
    if(!session_id())
        session_start();

    if(!$_SESSION["username"]){
        echo "<script type='text/javascript'>";
        echo "alert('您未登入');";
        echo "</script>";
        header("Location:index.php");
    }