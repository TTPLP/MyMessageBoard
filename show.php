<?php
    include("login_check.ini.php");
    $MESSAGES = $_SESSION['message'];
    if($MESSAGES == null){
        include("prepare_data.php");
    }

    $key = $_GET['index'];

    $message = $MESSAGES[$key];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>留言：<?=$message[messageTitle]?></title>
</head>
<body>
    <p>
        <?php
            echo "留言人：$message[username]";
        ?>
    </p>
    <p>
        <?php
            echo "email: $message[email]";
        ?>
    </p>
    <p>
        <?php
            echo "標題: $message[title]";
        ?>
    </p>
    <p>
        <?php
            echo "時間: $message[time]";
        ?>
    </p>
    <p>
        <?php
            echo "內容: <pre>$message[content]</pre>";
        ?>
    </p>
    <p>
        <a href="message_board.php">返回</a>
        &nbsp;&nbsp;
        <?php if($_SESSION['username'] === $message['username']){?>
            <a href="del_process.php?del=<?=$key?>">刪除</a>
            &nbsp;&nbsp;
            <a href="message_edit.php?key=<?=$key?>">修改</a>
        <?php }?>
    </p>
</body>
</html>
