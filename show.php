<?php
    include 'message.php';
    $message = new Message;

    $fh = fopen('data.json', 'r');

    $data_str = "";
    $tmp = "";

    while (($tmp = fgets($fh)) !== null) {
        $data_str .= $tmp;
    }

    fclose($fh);

    $filename = $_GET['filename'];
    $path = 'message/' . $filename;
    if($file = fopen($path, 'r+') != null){
        $message->filename = $filename;
        while (($data = fgetcsv($file, 1000)) != null) {
            if(count($data) >= 4){
                $message->setUserName($date[0]);
                $message->setUserEmail($date[1]);
                $message->setMessageTitle($data[2]);
                $message->setContent($data[3]);
            }
        }
        fclose($file);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?echo $message->messagetitle?></title>
</head>
<body>
    <p>
        <?php
            echo "留言人：$message->username";
        ?>
    </p>
    <p>
        <?php
            echo "email: $message->useremail";
        ?>
    </p>
    <p>
        <?php
            echo "標題: $message->messagetitle";
        ?>
    </p>
    <p>
        <?php
            echo "內容: <p>$message->getContent()</p>";
        ?>
    </p>
    <p>
        <a href="index.php">返回</a>
        <a href="del_process.php?del=<?=$filename?>">刪除</a>
    </p>
</body>
</html>
