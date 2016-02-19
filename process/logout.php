<?php
    include __DIR__ . "/../autoload.php";
    include path("logincheck.php");

    unset($_SESSION["username"]);
    unset($_SESSION["database"]);

    header("Location:" . url("index.php"));