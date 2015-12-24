<?php
    session_start();
    include 'message.php';
    ini_set('date.timezone','Asia/Taipei'); //php.ini
    //
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo "我的留言版"?></title>
</head>
<body>
    您好：<?=$_SESSION['username']?> <br>
    歡迎使用


    <hr />

    <p align="center"><label>留言列表</label></p>
    <p>
        <?php
            if(file_exists("data.json") === false){
                $fh = fopen("data.json", 'w');
                fclose($fh);
            }

            $fh = fopen('data.json', 'r');
            $data = "";
            $tmp = "";
            while (($tmp = fgets($fh, 4096)) !== false) {
                $data .= $tmp;
            }

            $tmp_data = json_decode($data);

            fclose($fh);

            if($tmp_data != null){ ?>
                <form action="del_process.php" method="post">
                    <?php foreach ($tmp_data as $key => $value) {?>
                        <li>
                            <input type="checkbox" name="del[]" value="<?= $key?>">
                            <label> 主題：<a href="show.php?index=<?= $key?>"><?= $value->messageTitle?> </a></label>
                            留言人：<?= $value->userName?>
                            信箱：<?= $value->userEmail?>
                        </li>
                    <?php }?>
                    <br>
                    <input type="submit" value="刪除">
                </form>

        <?php } else {
                echo "目前無任何留言！";
            }
        ?>
        <?php
            // while ($file = readdir($dir)) {


            //     if($this_file_name = strstr($file, '.csv', true)){
            //         $tmp_path = "message/" . $this_file_name . '.csv';
            //         if($file = fopen($tmp_path, 'r+')){
            //             $tmp_message = new Message("", "", "", "", "", "");
            //             //
            //             $tmp_message->setFileName($this_file_name . '.csv');
            //             //
            //             while (($data = fgetcsv($file, 1000)) != null) {
            //                 if(count($data) >= 4){
            //                     $tmp_message->setUserName($date[0]);
            //                     $tmp_message->setUserEmail($data[1]);
            //                     $tmp_message->setMessageTitle($date[2]);
            //                 }
            //             }
            //             array_push($MESSAGES, $tmp_message);
            //             fclose($file);
            //         }
            //     }
            // }
            // closedir($dir);
        ?>


    </p>

    <hr />

    <p align="center"><label>新增留言</label></p>
    <form method='post' action="process.php">
        <p>
            留言人：<input type="text" name="userName" size="10"><br>
            Email：<input type="text" name="userEmail" size="20"><br>
            留言主題：<input type="text" name="messageTitle" size="20"> <br>
            留言： <br>
            <textarea name="content" cols="60" rows="30"></textarea><br>
            <input type="submit" value="送出">
        </p>
    </form>
</body>
</html>
