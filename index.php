<?php
    include __DIR__ . "/autoload.php";


    if(!session_id()){
        session_start();

        if(@$_SESSION['username'] !== NULL){
            header("Location:" . url("/guestbook"));
        }
    }

    echo "<head>";
    echo"<link href='/css/layout.css' rel='stylesheet' type='text/css' />";
    echo "<title>登入頁面</title>";
    echo "</head>";

    echo "<body>";
    echo "<div class='BOX'>";
    echo "<form action=" . url("process/login.php") . " method='post'>";
    echo "請輸入帳號、密碼 <br />";
    echo "帳號：<input type='text' name='username' /> <br />";
    echo "密碼：<input type='password' name='password' /> <br />";
    echo "<input type='submit' value='送出'>";
    echo "&nbsp <a href=" . url("/register") . ">註冊</a>";
    echo "</form>";
    echo "</div>";