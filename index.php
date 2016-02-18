<?php
    include __DIR__ . "/autoload.php";

    echo "<head>";
    echo"<link href='/css/layout.css' rel='stylesheet' type='text/css' />";
    echo "<title>登入頁面</title>";
    echo "</head>";

    echo "<body>";
    echo "<div class='BOX' style='line-height:40px'>";
    echo "<form action=" . url("process/login.php") . " method='post'>";
    echo "請輸入帳號、密碼 <br />";
    echo "帳號：<input type='text' name='username' /> <br />";
    echo "密碼：<input type='password' name='password' /> <br />";
    echo "<input type='submit' value='送出'>";
    echo "&nbsp <a href=" . url("/register") . ">註冊</a>";
    echo "</form>";
    echo "</div>";

// <body>
//     <form action='process\login.php' method='post'>
//         帳號：<input type="text" name="username" /> <br />
//         密碼：<input type="password" name="password" /> <br />
//         <input type="submit" value="送出"> &nbsp <a href="<?php echo url("/register")?//>">註冊</a>
//     </form>
// </body>
// </html>