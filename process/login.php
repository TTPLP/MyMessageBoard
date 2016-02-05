<?php
    include __DIR__ . "/../autoload.php";

    $username = '';
    $password = '';

    if($_POST !== NULL){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username !== NULL){
            if($password !== NULL){
                $db = new \Database\Database();
                checkMemberData($db->dbh, $username, $password);
            }
        }
    }

    function checkMemberData($dbh, $username, $password){
        $stmt = $dbh->prepare('SELECT password FROM member WHERE username = :username;');
        $hashcode = substr(hash('sha512', $password), 0, 64);
        $stmt->execute([':username' => $username]);
        if($hashcode === $stmt->fetch()['password']){
            echo "success";
        }
    }

