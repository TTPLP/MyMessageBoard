<?php
    include __DIR__ . "/../autoload.php";
    include path("logincheck.php");

    echo "<link rel='stylesheet' type='text/css' href='css/layout.css'>";

    $message_id = $_GET["message_id"];
    $db = new Database\Database();
    $stmt = $db->dbh->prepare("SELECT * FROM message WHERE id = :message_id");
    $stmt->execute([":message_id" => $message_id]);

    $message = $stmt->fetch();

    $title = $message["title"];

    $db->prepare();
    $author = $message[""];

    $content = nl2br($stmt->fetch()["content"]);

    echo ""