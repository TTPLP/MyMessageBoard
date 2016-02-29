<?php
    include dirname( dirname(__FILE__) ) . "/autoload.php";
    include path("logincheck.php");

    // preparing message.
    $db = new Database\Database();
    $dbh = $db->dbh;

    $stmt = $dbh->prepare("SELECT * FROM message ORDER BY create_at DESC;");
    $stmt->execute();

    $messages = $stmt->fetchAll();
    // end of preparing message
?>

    <title>留言板</title>

    <!-- member bar -->
    <div class='normal_box_text_center'>
        您好： <?= $_SESSION["username"]?> <br />
        歡迎使用！<br />
        <a href= '<?= url("/process/logout.php")?>'>登出</a>
    </div>

    <hr />

    <!-- add new message -->
    <form class='normal_box_text_left' action='<?= url("/process/add_message.php")?>' method='post'>
        <div align='center'>新增留言</div>
        留言主題：<input type='text' name='title' style='max-width:100%;'/> <br />
        留言內容：<br />
        <div align='center'><textarea name='content'></textarea></div>
        <div align='center'><input type='submit' value='送出' /></div>
    </form>

    <hr />


<?php
    //message_list
    echo "<form class='normal_box_text_left'>";
    echo "<div align='center'>留言列表</div>";
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