<html>
<head>
    <title>註冊頁面</title>
    <link rel="stylesheet" type="text/css" href="css/layout.css">
</head>
<body>
    <div class="center_box_text_center">
        <form action="process/register.php" method="post">
            請輸入帳號資料！<br />
            帳號：<input type="text" name="username"/> <br/>
            密碼：<input type="password" name="password"/> <br/>
            再次輸入密碼：<input type="password" name="password2"/> <br/>
            主要信箱：<input type="text" name="email1"/> <br/>
            次要信箱：<input type="text" name="email2"/> <br/>
            <input type="submit" value="送出"> <a href="/">返回</a>
        </form>
    </div>
</body>
</html>

<?php
    include __DIR__ . "/../autoload.php";

    if(!session_id()){
        session_start();

        if(@$_SESSION['username'] !== NULL){
            header("Location:" . url("/guestbook"));
        }
    }