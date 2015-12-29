<?php
    include("member_tb.ini.php");

    echo "<pre>";
    session_start();    //start use session

    $id = $_POST['id']; //GET POST ID FROM LAST LOGIN PAGE
    $pw = $_POST['pw']; //GET POST PW FROM LAST LOGIN PAGE

    $result = $db->query("SELECT * FROM member_tb where username = '$id'");

    $row = $result->fetch();

    // //判斷帳號與密碼是否為空白
    // //以及MySQL資料庫裡是否有這個會員
    if($id != null && $pw != null && $row['username'] == $id && $row['password'] == $pw){
        //將帳號寫入session，方便驗證使用者身份
        $_SESSION['username'] = $id;
        $_SESSION['email'] = $row['email'];
        echo '登入成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=message_board.php>';
    }else{
        echo '登入失敗!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
    }
?>