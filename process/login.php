<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/autoload.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username !== ''){
        if($password !== ''){
            $db = new \Database\Database();
            if(checkMemberData($db->dbh, $username, $password)){
                echo "success!";
            }else{
                echo "fail!";
            }
        }else{
            echo 'you didn\'t anter your password!';
        }
    }else{
        echo 'you did\'t anter your username!';
    }

    function checkMemberData($dbh, $username, $password){
        $stmt = $dbh->prepare('SELECT password FROM member WHERE username = :username;');
        $hashcode = substr(hash('sha512', $password), 0, 64);
        $stmt->execute([':username' => $username]);
        if($hashcode === $stmt->fetch()['password']){
            return true;
        }else{
            return false;
        }
    }

