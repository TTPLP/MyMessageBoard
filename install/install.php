<?php
    include __DIR__ . "/../autoload.php";


    $db = new Database\Database();

    //$db = new Database\Member\Member();


    $db->createBasicTable("mytest2", ["id" => "BIGINT UNSIGNE NOT NULL", "name" => "VARCHAR(16)", "sex" => "BOOLEAN"], "id");

    $db->createBasicTable("mytest4", ["id" => "BIGINT UNSIGNE NOT NULL", "name" => "VARCHAR(16)", "sex" => "BOOLEAN"], "id");

    $db->addForeignKeyIntoTable("mytest2", "name", "mytest4", "name");

?>