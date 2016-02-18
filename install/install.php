<?php
    namespace Database;
    include __DIR__ . "/../autoload.php";

    $db = new Database();

    createMemberTable($db);
    createMailTable($db);
    createMessageTable($db);
    createResponseTable($db);

    try {
        loadDataToTableFromCSV($db, "member", "member.csv");
        loadDataToTableFromCSV($db, "mail", "mail.csv");
        loadDataToTableFromCSV($db, "message", "message.csv");
        loadDataToTableFromCSV($db, "response", "response.csv");
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    function createMessageTable($db)
    {
        $tableName = "message";

        $COLUMNS = [
            //          field       type                extra            nn     pk     uk     fk
            new Column( "id",       "bigint unsigned",  'auto_increment',true,  true,  false, false),
            new Column( "user_id",  "bigint unsigned",  false,           true,  false, false, new FKData("member", "id")),
            new Column( "title",    "VARCHAR(16)",      false,           true,  false, false, false),
            new Column( "content",  "TEXT",             false,           true,  false, false, false),
            new Column( "create_at","TIMESTAMP",        false,           true,  false, false, false),
            new Column( "update_at","TIMESTAMP",        false,           true,  false, false, false),
            new Column( "delete_at","DATETIME",         false,           false, false, false, false)
        ];

        $db->createBasicTable($tableName, $COLUMNS);
    }

    function createResponseTable($db)
    {
        $tableName = "response";
        $COLUMNS = [
            //          field       type                extra            nn     pk     uk     fk
            new Column( "id",       "bigint unsigned",  'auto_increment',true,  true,  false, false),
            new Column( "user_id",  "bigint unsigned",  false,           true,  false, false, new FKData("member", "id")),
            new Column( "message_id","bigint unsigned", false,           true,  false, false, new FKData("message", "id")),
            new Column( "title",    "VARCHAR(16)",      false,           true,  false, false, false),
            new Column( "content",  "TEXT",             false,           true,  false, false, false),
            new Column( "create_at","TIMESTAMP",        false,           true,  false, false, false),
            new Column( "update_at","TIMESTAMP",        false,           true,  false, false, false),
            new Column( "delete_at","DATETIME",         false,           false, false, false, false)
        ];

        $db->createBasicTable($tableName, $COLUMNS);
    }

    function createMemberTable($db){
        $tableName = "member";

        $COLUMNS = [
            //          field       type                extra            nn     pk     uk     fk
            new Column( "id",       "bigint unsigned",  'auto_increment',true,  true,  false, false),
            new Column( "username", "VARCHAR(16)",      false,           true,  false, true,  false),
            new Column( "password", "VARCHAR(64)",      false,           true,  false, false, false),
            new Column( "create_at","TIMESTAMP",        false,           true,  false, false, false),
            new Column( "update_at","TIMESTAMP",        false,           true,  false, false, false),
            new Column( "delete_at","DATETIME",         false,           false, false, false, false)
        ];


        $db->createBasicTable($tableName, $COLUMNS);
    }

    function createMailTable($db){
        $tableName = "mail";

        $COLUMNS = [
            //          field       type                extra            nn     pk     uk     fk
            new Column( "id",       "bigint unsigned",  'auto_increment',true,  true,  false, false),
            new Column( "user_id",  "bigint unsigned",  false,           true,  false, false, new FKData("member", "id")),
            new Column( "email",    "VARCHAR(64)",      false,           true,  false, true,  false),
            new Column( "delete_at","DATETIME",         false,           false, false, false, false),
            new Column( "prim",     "BOOLEAN",          false,           true,  false, false, false)
        ];

        $db->createBasicTable($tableName, $COLUMNS);
    }

    function loadDataToTableFromCSV($db, $tableName, $filename){
        $datas = []; //ther storage for datas;
        if (($handle = fopen("data_csv/" . $filename, "r")) !== FALSE) {
            $datafields = fgetcsv($handle, 1000, ",");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                array_push($datas, $data);
            }
            fclose($handle);
            try {
                $db->insertIntoTable_batch($tableName, $datafields, $datas);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }else{
            throw new Exception("loadDataToTableFromCSV(): this file can't open!", 1);
        }
    }
?>