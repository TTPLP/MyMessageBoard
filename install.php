<?php
    include("database_config.php");

    try {
        $dbh = new PDO("mysql:host=$server_name;dbname=$database_name", $username, $password);
    } catch (Exception $e) {
        $dbh = new PDO("mysql:host=$server_name", $username, $password);
        $dbh->query("CREATE DATABASE IF NOT EXISTS $database_name CHARACTER SET = 'utf8'");
        echo $e->getMessage();
    }

    //////////Table prepare

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

    $dbh->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS mail
    (
        id BIGINT NOT NULL AUTO_INCREMENT,
        user_id BIGINT NOT NULL,
        email VARCHAR(64) NOT NULL,
        delete_at TIMESTAMP,
        PRIMARY KEY (id),
        unique (email),
        FOREIGN KEY (primary_mail) REFERENCES member (id)
    );";

    $dbh->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS message
    (
        id BIGINT NOT NULL AUTO_INCREMENT,
        user_id BIGINT NOT NULL,
        title VARCHAR(64) NOT NULL,
        content TEXT,
        create_at TIMESTAMP NOT NULL,
        update_at TIMESTAMP,
        delete_at TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES member (id)
    );";

    $dbh->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS response
    (
        id BIGINT NOT NULL AUTO_INCREMENT,
        user_id BIGINT NOT NULL,
        message_id BIGINT NOT NULL,
        title VARCHAR(64) NOT NULL,
        content TEXT,
        create_at TIMESTAMP NOT NULL,
        update_at TIMESTAMP,
        delete_at TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES member (id),
        FOREIGN KEY (message_id) REFERENCES message (id)
    );";

    $dbh->query($sql);

    ////////////////load intial data

    $insert_mail_stmt = $dbh->prepare("insert into mail (user_id, email, delete_at) values (:user_id, :email, :delete_at)");    //prepare query

    if (($handle = fopen("mail.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $insert_mail_stmt->execute(array(":user_id" => $data[1], ":email" => $data[2], ":delete_at" => $data[3]));
        }
        fclose($handle);
    }

    $insert_member_stmt = $dbh->prepare("insert into member (username, password, create_at, update_at, delete_at, primary_mail) values (:username, :password, :create_at, :update_at, :delete_at, :primary_mail)");

    if (($handle = fopen("member.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $insert_member_stmt->execute(array(":username" => $data[1], ":password" => $data[2], ":create_at" => $data[3], ":update_at" => $data[4], ":delete_at" => $data[5], ":primary_mail" => $data[6]));
        }
        fclose($handle);
    }

    $insert_message_stmt = $dbh->prepare("insert into message (user_id, title, content, create_at, update_at, delete_at) values (:user_id, :title, :content, :create_at, :update_at, :delete_at)");

    if (($handle = fopen("message.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $insert_member_stmt->execute(array(":user_id" => $data[1], ":title" => $data[2], ":content" => $data[3], ":create_at" => $data[4], ":update_at" => $data[5], ":delete_at" => $data[6]));
        }
        fclose($handle);
    }