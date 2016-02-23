<?php
    include __DIR__ . "/../autoload.php";

    $username = @$_POST['username'];
    $password = @$_POST['password'];
    $password2 = @$_POST['password2'];
    $email1 = @$_POST['email1'];
    $email2 = @$_POST['email2'];

    echo "<link rel='stylesheet' type='text/css' href='" . url("css/layout.css") . "'>";

    echo "<div class=center_box_text_center>";

    if(!$username || !$password || !$password2 || !$email1){
        echo "您有欄位尚未填寫。</div>";
        header("Refresh:3; url=" . url("register"));
        exit();
    }else if($password !== $password2){
        echo "您的重複輸入密碼是不相符的。</div>";
        header("Refresh:3; url=" . url("register"));
        exit();
    }else if(!filter_var($email1, FILTER_VALIDATE_EMAIL)){
        echo "您的信箱輸入不符格式。</div>";
        header("Refresh:3; url=" . url("register"));
        exit();
    }else if(!preg_match('/^\w*$/', $username)){ //字體允許小寫與大寫英文字母和阿拉伯數字，字數限制最小8個字，最多16字
        echo "您的帳號輸入不符格式。</div>";
        header("Refresh:3; url=" . url("register"));
        exit();
    }else{
        $db = new \Database\Database();
        insertMemberData($db->dbh, $username, $password, $email1);
    }

    function insertMemberData($dbh, $username, $password, $email1){
        //hash password generation.
        $hashcode = hash('sha512', $password);
        $contentValue = [
        ':username' => $username,
        ':password' => $hashcode,
        ':create_at' => date('y-m-d h:i:s'),
        ':update_at' => date('y-m-d h:i:s'),
        ];

        //交易開始
        $dbh->query("START TRANSACTION;");

        $stmt = $dbh->prepare("INSERT INTO member (username, password, create_at, update_at) VALUES (:username, :password, :create_at, :update_at);");
        $stmt->execute($contentValue);

        if($stmt->errorInfo()[0] !== "00000"){
            $dbh->query("ROLLBACK");    //roll back the command.
            echo "該帳號已被註冊！</div>";
            header("Refresh:3; url=" . url("/register"));
            exit();
        }

        $contentValue = [
        ':username' => $username,
        ':email1' => $email1
        ];

        $stmt = $dbh->prepare('INSERT INTO mail (email, user_id ,prim) SELECT :email1, id, true FROM member WHERE username = :username;');
        $stmt->execute($contentValue);

        if($stmt->errorInfo()[0] !== "00000"){
            $dbh->query("ROLLBACK");    //roll back the command.
            echo "該信箱已被註冊！</div>";
            header("Refresh:3; url=" . url("/register"));
            exit();
        }

        $dbh->query("COMMIT;");

        if($stmt->errorInfo()[0] === "00000"){
            echo "註冊成功！</div>";
            header("Refresh:3; url=" . url(""));
        }
    }