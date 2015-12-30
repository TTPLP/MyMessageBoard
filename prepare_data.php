<?php
    session_start();
    include("message_tb.ini.php");

    if($_SESSION['username'] == null) {
        echo "您沒有登入！";
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        die();
    }

    $result = $db->query("SELECT * FROM message_tb");

    $MESSAGES = $result->fetchAll();

    $_SESSION['message'] = $MESSAGES;

    echo '<meta http-equiv=REFRESH CONTENT=2;url=message_board.php>';