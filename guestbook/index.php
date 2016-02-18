<?php
    include __DIR__ . "/../autoload.php";
    include path("logincheck.php");

    echo "<title>留言板</title>";
    echo "您好：" . $_SESSION['username'];