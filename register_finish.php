<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");

$id = $_POST['id'];
$pw = $_POST['pw'];
$pw2 = $_POST['pw2'];
$email = $_POST['email'];

//判斷帳號密碼是否為空值
//確認密碼輸入的正確性
if($id != null && $pw != null && $pw2 != null && $email != null)
{
        $sql = "SELECT * FROM member_table where username = '$id'";
        $result = mysql_query($sql);
        $row = @mysql_fetch_array($result);

        if($row['username'] == $id){
            echo "該帳號已有使用者使用，請重新填寫資料！";
            echo '<meta http-equiv=REFRESH CONTENT=3;url=register.php>';
        }else if(strlen($id) < 6){
            echo "您的帳號長度小於 6 字元，請重新填寫資料！";
            echo '<meta http-equiv=REFRESH CONTENT=3;url=register.php>';
        }else if(strlen($pw) < 6){
            echo "您的密碼長度小於 6 字元，請重新填寫資料！";
            echo '<meta http-equiv=REFRESH CONTENT=3;url=register.php>';
        }else if($pw !== $pw2){
            echo "您重新輸入的密碼有誤，請重新填寫資料！";
            echo '<meta http-equiv=REFRESH CONTENT=3;url=register.php>';
        }else{
            //新增資料進資料庫語法
            $sql = "insert into member_table (username, password, email)" .
                    " values ('$id', '$pw', '$email')";
            if(mysql_query($sql))
            {
                    echo '新增成功!';
                    echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
            }
            else
            {
                    echo '新增失敗!';
                    echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
            }
        }
}
else
{
        echo '您有欄位尚未填寫!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
}
?>