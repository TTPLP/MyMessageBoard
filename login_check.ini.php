<?php
    session_start();
    if($_SESSION['username'] == null){
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        die("您沒有登入！");
    }
?>