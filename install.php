<?php
    include("database_config.php");

    try {
        $dbh = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $passeword);
    } catch (Exception $e) {
        $dbh = new PDO("mysql:host=$server_name", $user_name, $passeword);
        $dbh->query("CREATE DATABASE IF NOT EXISTS $database_name CHARACTER SET = 'utf8'");
        echo $e->getMessage();
    }

    $dbh->query("USE $database_name;");

    $sql = "CREATE TABLE IF NOT EXISTS member
    (
    id BIGINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(20) NOT NULL,
    create_at TIMESTAMP NOT NULL,
    update_at TIMESTAMP,
    delete_at TIMESTAMP,
    primary_mail BIGINT NOT NULL,
    PRIMARY KEY (id),
    unique (username)
    );";
  // -- ,FOREIGN KEY (primary_mail) REFERENCES mail (id)

    $dbh->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS mail
    (
    id BIGINT NOT NULL AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    email BIGINT NOT NULL,
    delete_at TIMESTAMP,
    PRIMARY KEY (id)
    );";

    $dbh->query($sql);


    $insert_member_stmt = $dbh->prepare("insert into member (username, password, create_at, update_at, delete_at, primary_mail) values (:username, :password, :create_at, :update_at, :delete_at, :primary_mail)");

    if (($handle = fopen("member.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $insert_member_stmt->execute(array(":username" => $data[1], ":password" => $data[2], ":create_at" => $data[3], ":update_at" => $data[4], ":delete_at" => $data[5], ":primary_mail" => $data[6]));
        }
        fclose($handle);
    }