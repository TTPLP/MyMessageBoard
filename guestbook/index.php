<?php
    include __DIR__ . "/../autoload.php";
    include path("logincheck.php");

    // preparing message.
    $db = new Database\Database();
    $dbh = $db->dbh;

    $stmt = $dbh->prepare("SELECT * FROM message;");
    $stmt->execute();

    $messages = $stmt->fetchAll();
    // end of preparing message

    echo"<link href='/css/layout.css' rel='stylesheet' type='text/css' />";

    //member_bar
    echo "<title>留言板</title>";
    echo "<div class='member_bar'>";
    {
        echo "您好：" . $_SESSION['username'] . "<br />";
        echo "歡迎使用！<br />";
        echo " <a href='" . url("/process/logout.php") . "'>登出</a>";
    }
    echo "</div><hr />";
    //member_bar

    //message_list
    echo "<form class='message_list'>";
    $stmt = $dbh->prepare("SELECT username FROM member WHERE id = :user_id");
    foreach ($messages as $key => $value) {

        echo "<li>";
        {
            $stmt->execute([":user_id" => $value['user_id']]);
            $author = $stmt->fetch()["username"];

            if($_SESSION['username'] === $author)
                echo "<input type='checkbox' />";

            echo "主題：<a href='" . url("message?message_id=" . $value["id"]) . "'>" . $value["title"] . "</a>" . "&nbsp";
            echo "留言時間：" . $value['create_at'] . "&nbsp";
            echo "留言人：" . $author;
            echo "<br />";
        }
        echo "</li>";
    }
    echo "</form>";
    //message_list