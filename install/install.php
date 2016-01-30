<?php
    include __DIR__ . "/../autoload.php";


    $db = new Database\Database();

    $db->createMemberTable();
    $db->createMailTable();
    $db->createMessageTable();
    $db->createResponseTable();

?>