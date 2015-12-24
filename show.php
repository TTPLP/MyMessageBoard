<?php
    session_start();
    include 'message.php';

    $all_data = Message::analyze("data.json");

    $key = $_GET['index'];

    $message = $all_data[$key];

    // $message = new Message("", "", "", "", "", "");

    // $fh = fopen('data.json', 'r');

    // $data_str = "";
    // $tmp = "";

    // while (($tmp = fgets($fh)) !== null) {
    //     $data_str .= $tmp;
    // }

    // fclose($fh);

    // $filename = $_GET['filename'];
    // $path = 'message/' . $filename;
    // if($file = fopen($path, 'r+') != null){
    //     $message->filename = $filename;
    //     while (($data = fgetcsv($file, 1000)) != null) {
    //         if(count($data) >= 4){
    //             $message->setUserName($date[0]);
    //             $message->setUserEmail($date[1]);
    //             $message->setMessageTitle($data[2]);
    //             $message->setContent($data[3]);
    //         }
    //     }
    //     fclose($file);
    // }
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
            echo "留言人：$message[userName]";
        ?>
    </p>
    <p>
        <?php
            echo "email: $message[userEmail]";
        ?>
    </p>
    <p>
        <?php
            echo "標題: $message[messageTitle]";
        ?>
    </p>
    <p>
        <?php
            echo "時間: $message[date]";
        ?>
    </p>
    <p>
        <?php
            echo "內容: <pre>$message[content]</pre>";
        ?>
    </p>
    <p>
        <a href="message_board.php">返回</a>&nbsp;&nbsp;
        <?php if($_SESSION['username'] === $message['userName']){?>
            <a href="del_process.php?del=<?=$key?>">刪除</a>&nbsp;&nbsp;
            <a href="message_edit.php?key=<?=$key?>">修改</a>
        <?php }?>
    </p>
</body>
</html>
