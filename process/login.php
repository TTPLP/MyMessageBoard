<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/autoload.php";

    if(!session_id())
        session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $db = new \Database\Database();

    echo "<link href='/css/layout.css' rel='stylesheet' type='text/css' />";
    echo "<div class='center_box_text_center'>";

    if($username === '' || $password === ''){
        echo "您的帳號或密碼未填寫！</div>";
        header("Refresh:3; url=" . url(""));
        exit();
    } else{
        if (checkMemberData($db->dbh, $username, $password) !== true){
            echo "您的帳號或密碼錯誤！</div>";
            header("Refresh:3; url=" . url(""));
            exit();
        }else{
            echo "登入成功！</div>";
            header("Refresh:3; url=" . url("/guestbook"));
            exit();
        }
    }

    function checkMemberData($dbh, $username, $password){
        $stmt = $dbh->prepare('SELECT password FROM member WHERE username = :username;');
        $hashcode = substr(hash('sha512', $password), 0, 64);
        $stmt->execute([':username' => $username]);

        if($hashcode === $stmt->fetch()['password']){   //checl password correct or not
            $_SESSION['username'] = $username;
            return true;
        }else{
            return false;
        }
    }