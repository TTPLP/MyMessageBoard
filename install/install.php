<?php
    include __DIR__ . "/../autoload.php";


    $db = new Database\Database();

    //$db = new Database\Member\Member();
    //
    $db->createMemberTable();
    $db->createMailTable();
    $db->createMessageTable();
    $db->createResponseTable();

?>