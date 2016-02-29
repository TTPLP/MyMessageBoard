<?php
    include dirname( dirname(__FILE__) ) . "/autoload.php";
    include path("logincheck.php");

    $message_id = $_GET["message_id"];
    $db = new Database\Database();
    $dbh = $db->dbh;

    $stmt = $dbh->prepare("SELECT message.title, message.content, message.create_at, member.username FROM message RIGHT JOIN member ON member.id = message.user_id WHERE message.id = :message_id;");
    $stmt->execute([":message_id" => $message_id]);

    $message = $stmt->fetch();

    $title = $message["title"];
    $content = $message["content"];
    $create_at = $message["create_at"];
    $author = $message["username"];

    if($stmt->errorInfo()[0] !== "00000")
        echo "<div class='center_box_text_center'>" . $stmt->errorInfo()[2] . "</div>";

    $stmt = $dbh->prepare("SELECT response.content, response.create_at, member.username FROM response RIGHT JOIN member ON member.id = response.user_id WHERE response.message_id = :message_id;");
    $stmt->execute([":message_id" => $message_id]);

    $responses = $stmt->fetchAll();

    //data has already been prepared now.
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?=$title?></title>

        <!-- Default -->
        <link rel=stylesheet href='./public/default.css' type='text/css'>

        <!-- jQuery -->
        <script type="text/javascript" src="./public/jQuery/jquery-2.2.1.min.js"></script>

        <!-- Semantic UI -->
        <link rel=stylesheet href='./public/Semantic-UI/semantic.min.css' type='text/css'>
        <script type="text/javascript" src="./public/Semantic-UI/semantic.min.js"></script>

        <!-- Font online -->
        <link href='https://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>

        <!-- ** Fun time below ** -->
        <!-- Typed.js -->
        <script type="text/javascript" src="./public/Typed/typed.js"></script>

    </head>

    <!-- body start from here -->
    <body  style="background-color: #EEE;">
        <!-- header start from here -->
        <header class="header">
            <div id="site-title" class="ui basic segment">
                Guestbook
            </div>
        </header>

        <!-- content -->
        <div id='message-page' class="ui container">
            <div class="ui two column doubling stackable grid container">
                <div class='column'>
                    <div class="ui secondary top attached segment">留言人</div>
                    <div id='user-name' class="ui bottom attached segment"><?= $_SESSION['username']?></div>
                </div>
                <div class='column'>
                    <div class="ui secondary top attached segment">留言日期</div>
                    <div id='user-name' class="ui bottom attached segment"><?= $create_at?></div>
                </div>
            </div>

            <!-- divider -->
            <div class="ui hirizontal divider"></div>

            <!-- message -->
            <div class="ui container">
                <div class="ui secondary top attached segment"><?= $title?></div>
                <div id='user-name' class="ui bottom attached segment">
                    <?= $content?>
                    <div><a class="ui green button" href="">修改</a><a href="" class="ui red button">刪除</a></div>

                    <!-- response message -->
                    <div class="ui hirizontal divider"></div>
                    <form action="/message/add_response.php" method="POST">
                        <div align="center" style="line-height: 1.5em;">回覆</div>
                        <textarea style="resize: none;" rows="5" name="content"></textarea>
                        <input type="hidden" name="message_id" value="<?= $message_id?>">
                        <div align="center"><input type="submit" class="ui blue button" /></div>
                    </form>
                </div>
            </div>


            <!-- divider -->
            <div class="ui hirizontal divider"></div>

            <!-- show responses -->
            <div style="text-align: center; font-size: 1.75em; line-height: 1.75em;">回覆</div>
<?php
    foreach ($responses as $key => $value) {
?>
            <div class="ui container">
                <div class="ui secondary top attached segment"><?= $value["username"]?>@[<?= $value['create_at']?>]</div>
                <div id='user-name' class="ui bottom attached segment"><?= $value['content']?></div>
            </div>
<?php
    }
?>
        </div>
    </body>
</html>