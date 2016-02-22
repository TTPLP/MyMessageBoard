<!DOCTYPE html>
<html>
<head>
    <title>登入頁面</title>
    <link href='/css/layout.css' rel='stylesheet' type='text/css' />
</head>
<body>
    <form class='center_box_text_center' action="/process/login.php" method='post'>
        請輸入帳號、密碼 <br />
        帳號：<input type='text' name='username' /> <br />
        密碼：<input type='password' name='password' /> <br />
        <input type='submit' value='送出'>&nbsp <a href="/register">註冊</a>
    </form>
</body>
</html>

<?php
    include "autoload.php";

    if(!session_id()){
        session_start();

        if(@$_SESSION['username'] !== NULL){
            header("Location:" . url("/guestbook"));
        }
    }