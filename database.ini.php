<?php
    include("database_config.php");

    $dbh = new PDO("mysql:host=$server_name", $user_name, $passeword);
    $dbh->query("CREATE DATABASE IF NOT EXISTS $database_name CHARACTER SET = 'latin1'");

    // try {
    //     $dbh = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $passeword);
    // } catch (Exception $e) {
    // }

    // $db = new PDO("mysql:host=$server_name", $user_name, $passeword);
    // $db->prepare("SET character_set_server = 'utf8'");
    // $db->query("SET character_set_server = 'utf8'");   //set the ecncoding type of database
    // $db->query("CREATE DATABASE IF NOT EXISTS $database_name");   //create the database if it don't exist
    // $db->query("USE $database_name"); //select database