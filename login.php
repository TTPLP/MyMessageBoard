<?php
    include "autoload.php";

    if($_POST !== null){
        echo $_POST['username'] . "<br />" . $_POST['password'];
    }

