<?php
    include __DIR__ . "/../autoload.php";


    $db = new Database\Database();

    $db->createMemberTable();
    $db->createMailTable();
    $db->createMessageTable();
    $db->createResponseTable();

    $hash = new Database\Hash("abc");

    var_dump($hash->rotateRight(16, 2));


    var_dump(0x0000000000000004);

?>