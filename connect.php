<?php
    include("member_tb.ini.php");

    session_start();    //start use session

    $id = $_POST['id']; //GET POST ID FROM LAST LOGIN PAGE
    $pw = $_POST['pw']; //GET POST PW FROM LAST LOGIN PAGE

    $result = $db->query("SELECT * FROM member_tb where username = '$id'");

    $row = $result->fetch();

    if($id != null && $pw != null && $row['username'] == $id && $row['password'] == $pw){
        $_SESSION['username'] = $id;        //store $id because id is correct
        $_SESSION['email'] = $row['email']; //store email because id is correct

        echo '登入成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=prepare_data.php>';    //change page with html header
    }else{
        echo '登入失敗!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';   //change page with html header
    }
?>