<?php
    include __DIR__ . "/../autoload.php";


    $db = new Database\Database();

    $db->createMemberTable();
    $db->createMailTable();
    $db->createMessageTable();
    $db->createResponseTable();

    $a = [
    ["username" => "ericmina83", "password" => "fasdlkfjklej"],
    ["username" => "ericmina84", "password" => "fsdafsaf"],
    ["username" => "ericmina85", "password" => "sdfsdafeadvhf"],
    ["username" => "ericmina86", "password" => "fedgfgrthtyhyyj"]
    ];

    $db->insertIntoTable_batch("member", $a);



?>