<?php
    include('db_server.ini.php');

    $sql = "CREATE TABLE message_tb ("
                ."id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,"
                ."username VARCHAR(30) NOT NULL,"
                ."email VARCHAR(50) NOT NULL,"
                ."title VARCHAR(30) NOT NULL,"
                ."content TEXT NOT NULL,"
                ."time VARCHAR(50) NOT NULL"
                .")";

    $db->exec($sql);