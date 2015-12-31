<?php
    include("login_check.ini.php");     //checking if the user login or not
    include("message_tb.ini.php");      //initialize message_tb and get database object

    $result = $db->query("SELECT * FROM message_tb");   //query the resukt

    $MESSAGES = $result->fetchAll();    //get all result with array type

    $_SESSION['message'] = $MESSAGES;   //store result for next page using