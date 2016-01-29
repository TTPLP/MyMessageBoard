<?php
    //refer to http://justericgg.logdown.com/posts/196891-php-series-autoload;

    spl_autoload_register(function ($className){

        $className = ltrim($className, "\\");   //remove the leftest symbol '\'

        $fileName = ""; //create empty storage for filename to include

        $namespace = "";

        if($lastPos = strrpos($className, "\\")){    //find possition of '\'
            $namespace = substr($className, 0, $lastPos);
            $className = substr($className, $lastPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        //echo $fileName . "\n";

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.class.php';

        if($namespace == "Database") require __DIR__ . "/Database/database.class.php"; //require $fileName;

        //echo "$namespace";
    });
?>