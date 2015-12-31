<?php
    session_start();
    include("message.php");

    if($_GET){
        $key = $_GET['key'];
        $all_data = Message::analyze("data.json");
        $now_message = $all_data[$key];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>留言修改頁</title>
</head>
<body>
    <p align="center"><label>修改留言</label></p>
    <form method='post' action="edit_process.php?key=<?=$key?>">
        <p>
            留言人：<?=$_SESSION['username']?><br>
            Email：<?=$_SESSION['email']?><br>
            留言主題：<input type="text" name="messageTitle" size="20" value="<?=$now_message[messageTitle]?>"/> <br>
            留言： <br>
            <textarea name="content" cols="60" rows="30"><?=$now_message[content]?></textarea><br>
            <input type="submit" value="送出">
        </p>
    </form>
</body>
</html>