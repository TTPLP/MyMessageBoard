<?php
	include('db.conf.php');

    try {
        $db = new PDO("mysql:host=$host_name", $db_user, $db_password);
        $db->query("CREATE DATABASE IF NOT EXISTS $db_name");
        $db->query("USE $db_name");
        $db->query("SET NAMES utf8");
    } catch (PDOException $e) {     //when ther error occur, the thread will stop and jump here to stop error thread
        echo $e->getMessage();
    }