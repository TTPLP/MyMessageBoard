<?php
	include('db.conf.php');    //include the paremter of database

    try {
        $db = new PDO("mysql:host=$host_name", $db_user, $db_password); //access sql server with PDO
        $db->query("SET character_set_server = 'utf8'");   //set the ecncoding type of database
        $db->query("CREATE DATABASE IF NOT EXISTS $db_name");   //create the database if it don't exist
        $db->query("USE $db_name"); //select database
    } catch (PDOException $e) {     //when ther error occur, the thread will stop and jump here to stop error thread
        echo $e->getMessage();  //echo the error message about mysql database
    }