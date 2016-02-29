<?php
    include dirname( dirname(__FILE__) ) . "/autoload.php";
    include path("/logincheck.php");

    $username = $_SESSION['username'];

    //link css file
    echo "<link href='/css/layout.css' rel='stylesheet' type='text/css' />";

    echo "<link rel=stylesheet href='/public/default.css' type='text/css'>";

    echo "<link rel=stylesheet href='/public/Semantic-UI/semantic.min.css' type='text/css'>";

    echo "<script type='text/javascript' src='/public/Semantic-UI/semantic.min.js'></script>";

    //create the message div
    echo "<div id='error-info' class='ui container'>";
    echo "<div class='ui secondary top attached segment'>訊息</div>";
    echo "<div class='ui bottom attached segment'>";

    //prepare variable
    $content = nl2br(htmlentities($_POST['content']));  //anti xss

    $db = new Database\Database();
    $dbh = $db->dbh;

    $dbh->query("BEGIN;");

    $stmt = $dbh->prepare("SELECT id FROM member WHERE username = '" . $_SESSION['username'] . "';");
    $stmt->execute();

    //if can't find the user.
    if($stmt->errorInfo()[0] !== "00000"){
        echo $stmt->errorInfo()[2] . "</div></div>";
        $dbh->query("ROLLBACK");    //roll back the command.
        header("Refresh: 3; url=" . url("/message?message_id=" . $message_id));
        exit;
    }

    $u_id = $stmt->fetch()['id'];

    $message_id = $_POST['message_id'];

    $stmt = $dbh->prepare("INSERT INTO response (user_id, message_id, content, create_at) VALUES ( :u_id, :message_id, :content, NOW() );");
    $stmt->execute([":u_id" =>  $u_id, ":message_id" => $message_id, ":content" => $content]);

    //if can't insert the message;
    if($stmt->errorInfo()[0] !== "00000"){
        echo $stmt->errorInfo()[2] . "</div></div>";
        $dbh->query("ROLLBACK");    //roll back the command.
        header("Refresh: 3; url=" . url("/message?message_id=" . $message_id));
        exit;
    }

    $dbh->query("COMMIT;");

    echo "留言新增成功！</div></div>";
    header("Refresh: 3; url=" . url("/message?message_id=" . $message_id));