<?php
    include('db_server.ini.php');

    $dsn = "mysql:host=$host_name;dbname=$db_name";

    $db = new PDO($dsn, $db_user, $db_password);

    $sql = "CREATE TABLE member_tb ("
                ."id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,"
                ."username VARCHAR(30) NOT NULL,"
                ."password VARCHAR(30) NOT NULL,"
                ."email VARCHAR(50) NOT NULL"
                .")";

    $db->exec($sql);
