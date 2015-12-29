<?php
	include('db.conf.php');

    if(!@mysql_connect($host_name, $db_user, $db_password))
        die('can\'t connect the mysql server');

    mysql_query("SET NAMES utf8");

    if(!@mysql_query("CREATE DATABASE IF NOT EXISTS $db_name"))
        die('can\'t create database, "member_db"');
