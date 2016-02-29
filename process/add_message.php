<?php
    include dirname( dirname(__FILE__) ) . "/autoload.php";
    include path("/logincheck.php");

    $username = $_SESSION['username'];

    //link css file
    echo "<link href='/css/layout.css' rel='stylesheet' type='text/css' />";

    //create the message div
    echo "<div class='center_box_text_center'>";

    //prepare variable
    $title = $_POST['title'];
    $content = htmlentities(nl2br($_POST['content']));  //anti xss

    $db = new Database\Database();
    $dbh = $db->dbh;

    $dbh->query("BEGIN;");

    $stmt = $dbh->prepare("SELECT id FROM member WHERE username = '" . $_SESSION['username'] . "';");
    $stmt->execute();

    //if can't find the user.
    if($stmt->errorInfo()[0] !== "00000"){
        echo $stmt->errorInfo()[2] . "</div>";
        $dbh->query("ROLLBACK");    //roll back the command.
        header("Refresh: 3; url=" . url("/guestbook"));
        exit;
    }

    $u_id = $stmt->fetch()['id'];

    $stmt = $dbh->prepare("INSERT INTO message (user_id, title, content, create_at) VALUES ( :u_id, :title, :content, NOW() );");
    $stmt->execute([":u_id" =>  $u_id, ":title" => $title, ":content" => $content]);

    //if can't insert the message;
    if($stmt->errorInfo()[0] !== "00000"){
        echo $stmt->errorInfo()[2] . "</div>";
        $dbh->query("ROLLBACK");    //roll back the command.
        header("Refresh: 3; url=" . url("/guestbook"));
        exit;
    }

    $dbh->query("COMMIT;");

    echo "留言新增成功！</div>";
    header("Refresh: 3; url=" . url("/guestbook"));