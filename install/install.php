<?php
    include __DIR__ . "/../autoload.php";

    $db = new Database\Database();

    $db->createMemberTable();
    $db->createMailTable();
    $db->createMessageTable();
    $db->createResponseTable();

    $db->loadDataToTableFromCSV("member", "member.csv");
    $db->loadDataToTableFromCSV("mail", "mail.csv");
    $db->loadDataToTableFromCSV("message", "message.csv");
    $db->loadDataToTableFromCSV("response", "response.csv");

    $hash = new Hash\Hash("abc");

?>