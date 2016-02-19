<?php
    include __DIR__ . "/../autoload.php";

    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];

    $filled_check = 

    if($username !== NULL && $password !== NULL && $password2 !== null && $email !== NULL){
    }

    if(){

    }

    $db = new \Database\Database();
    insertMemberData($db->dbh, $username, $password, $email);
    header("Location:" . url("/index.php"));

    function insertMemberData($dbh, $username, $password, $email){
        $stmt = $dbh->prepare('insert into member (username, password, create_at, update_at) values (:username, :password, :create_at, :update_at);');
        $hashcode = hash('sha512', $password);

        var_dump($hashcode);

        $data = [
        ':username' => $username,
        ':password' => $hashcode,
        ':create_at' => date('y-m-d h:i:s'),
        ':update_at' => date('y-m-d h:i:s')
        ];

        $stmt->execute($data);

        if($stmt->errorInfo()[0] !== "00000"){
            echo $stmt->errorInfo()[2];
        }
    }