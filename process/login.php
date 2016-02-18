<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/autoload.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username !== '' && $password !== ''){
        $db = new \Database\Database();
        if(checkMemberData($db->dbh, $username, $password) === true){
            $_SESSION['username'] = $username;  //Store the correct username in session.
            header("Location:" . url("/guestbook"));    //Change page.
        }else{
            showAlertView("登入失敗！");
            header("Location:" . url());
        }
    }else{
        showAlertView("您沒有輸入帳號或是密碼！");
        header("Location:" . url());
    }

    function checkMemberData($dbh, $username, $password){
        $stmt = $dbh->prepare('SELECT password FROM member WHERE username = :username;');
        $hashcode = substr(hash('sha512', $password), 0, 64);
        $stmt->execute([':username' => $username]);

        if($hashcode === $stmt->fetch()['password']){   //checl password correct or not
            return true;
        }else{
            return false;
        }
    }

    function showAlertView($message){
        echo "<script type='text/javascript'>";
        echo "alert(\"". $message ."\")";
        echo "</script>";
    }

