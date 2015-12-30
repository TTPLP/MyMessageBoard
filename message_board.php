<?php
    include("login_check.ini.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo "我的留言版"?></title>
</head>
<body>
    您好：<?=$_SESSION['username']?> <br>
    歡迎使用 <br>
    <a href="logout.php">登出</a>

    <hr />

    <p align="center"><label>留言列表</label></p>
    <p>
        <?php
            if($_SESSION['message'] != null){ ?>
                <form action="del_process.php" method="post">
                    <?php foreach ($_SESSION['message'] as $key => $value) {?>
                        <li>
                            <?php if($_SESSION['username'] === $value['username']){?>
                                <input type="checkbox" name="del[]" value="<?= $key?>" />
                            <?php }?>
                            <label> 主題：<a href="show.php?index=<?= $key?>"><?= $value['title']?> </a></label>
                            留言人：<?= $value['username']?>
                            信箱：<?= $value['email']?>
                        </li>
                    <?php }?>
                    <br>
                    <input type="submit" value="刪除">
                </form>
        <?php } else {
                echo "目前無任何留言！";
            }
        ?>
    </p>

    <hr />

    <p align="center"><label>新增留言</label></p>
    <form method='post' action="message_add_process.php">
        <p>
            留言人：<?=$_SESSION['username']?><br>
            <!-- <input type="text" name="userName" size="10"><br> -->
            Email：<?=$_SESSION['email']?><br>
            <!-- <input type="text" name="userEmail" size="20"><br> -->
            留言主題：<input type="text" name="title" size="20"> <br>
            留言： <br>
            <textarea name="content" cols="60" rows="30"></textarea><br>
            <input type="submit" value="送出">
        </p>
    </form>
</body>
</html>
