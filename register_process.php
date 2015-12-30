<?php
    include("member_tb.ini.php");

    $id = $_POST['id'];
    $pw = $_POST['pw'];
    $pw2 = $_POST['pw2'];
    $email = $_POST['email'];

    if($id !== null && $pw !== null && $pw2 !== null && $email !== null) {  //check all data we request have been ready
        try {   //cos the PDO will throw the error, so the follwing code surrond by try catch

            $sql = "SELECT * FROM member_tb where username = '$id'";
            $result = $db->query($sql);
            $row = $result->fetch();

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

                $sql = "insert into member_tb (username, password, email)" .
                        " values ('$id', '$pw', '$email')";
                $stmt = $db->query($sql);
                $result = $stmt->rowCount();

                if($result === 1) {
                    echo '新增成功!';
                    echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
                } else {
                    echo '新增失敗!';
                    echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
                }

            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo '您有欄位尚未填寫!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
    }
?>