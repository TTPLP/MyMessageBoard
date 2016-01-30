<?php
    namespace Database;
    use \PDO;
    use \Exception;

    class Database{

        public $dbh;

        function __construct()
        {
            require __DIR__ . "/database_config.php";

            try
            {
                $this->dbh = new PDO("mysql:host=$server_name;dbname=$database_name", $username, $password);
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
                exit();
            }
        }

        function createBasicTable($tableName, $COLUMNS)
        {

            $hasPrimary = false;

            $sql = "CREATE TABLE IF NOT EXISTS " . $tableName ." (";
            foreach ($COLUMNS as $column)
            {
                $sql .=  $column->field . " " . $column->type . " ";

                if($column->extra !== false){
                    $sql .= $column->extra . " ";
                }

                if($column->not_null === true){
                    $sql .= "NOT NULL";
                }

                $sql .= ",";

                if($column->primary_key !== false){
                    $sql .= "PRIMARY KEY (" . $column->field . "),";
                }

                if($column->foreign_key !== false){
                    $sql .= "FOREIGN KEY (" . $column->field . ") REFERENCES " . $column->foreign_key->refTable . "(";
                    $sql .= $column->foreign_key->refCol . "),";
                }

                if($column->unique_key !== false){
                    $sql .= "UNIQUE KEY (" . $column->field . "),";
                }
            }

            $sql = rtrim($sql, ",");

            $sql .= ");"; //en

            $this->executeQueryWithPrepare("createBasicTable()", $sql);
        }

        function insertIntoTable_single($tableName, $data)
        {
            $sql = "INSERT INTO " . $tableName . " (";      //

            $values = " VALUES (";

            foreach ($data as $colName => $value)
            {
                $sql .= $colName . ",";
                $values .= $value . ",";
            }

            $sql = rtrim($sql, ","). ") ";
            $sql .= rtrim($values, ",") . ")";
            echo "$sql";
        }

        function insertIntoTable_batch($tableName, $datas, $datafields)
        {
            $sql = "INSERT INTO " . $tableName . " (" . implode($datafields) , 

            //INSERT INTO table (...., ...., .....


            foreach ($datas[0] as $key => $value) { //get the column
                $sql .= $key . ",";
            }

            $sql = rtrim($sql, ',');

            $sql .= ") VALUES";

            //....) VALUES

            foreach ($datas as $index => $data)
            {
                $sql .= "(";

                //....) VALUES (...., ....

                foreach ($data as $colName => $value)
                {
                    $sql .= "\"" . $value . "\",";
                }

                $sql = rtrim($sql, ",");
                $sql .= "),";

                //....),(...., ....
            }

            $sql = rtrim($sql, ",");

            //INSERT INTO table (.....) values (.....),(.....),(.....),(....

            $this->executeQueryWithPrepare("insertIntoTable_batch()", $sql);
        }

        function addForeignKeyIntoTable($tableName, $colName, $refTable, $refCol)
        {
            $sql = "ALTER TABLE " . $tableName . " ADD FOREIGN KEY (" . $colName . ") REFERENCES " . $refTable . " (" . $refCol . ");";
            echo $sql;
            $this->dbh->query($sql);
        }

        function createMemberTable()
        {
            $tableName = "member";

            $COLUMNS = [
                //          field       type                extra            nn     pk     uk     fk
                new Column( "id",       "bigint unsigned",  'auto_increment',true,  true,  false, false),
                new Column( "username", "VARCHAR(16)",      false,           true,  false, false, false),
                new Column( "password", "VARCHAR(64)",      false,           true,  false, false, false),
                new Column( "create_at","TIMESTAMP",        false,           true,  false, false, false),
                new Column( "update_at","TIMESTAMP",        false,           true,  false, false, false),
                new Column( "delete_at","DATETIME",         false,           false, false, false, false)
            ];


            $this->createBasicTable($tableName, $COLUMNS);
        }

        function createMailTable()
        {
            $tableName = "mail";

            $COLUMNS = [
                //          field       type                extra            nn     pk     uk     fk
                new Column( "id",       "bigint unsigned",  'auto_increment',true,  true,  false, false),
                new Column( "user_id",  "bigint unsigned",  false,           true,  false, false, new FKData("member", "id")),
                new Column( "email",    "VARCHAR(64)",      false,           true,  false, true,  false),
                new Column( "delete_at","DATETIME",         false,           false, false, false, false),
                new Column( "prim",     "BOOLEAN",          false,           true,  false, false, false)
            ];

            $this->createBasicTable($tableName, $COLUMNS);
        }

        function createMessageTable()
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

            $this->createBasicTable($tableName, $COLUMNS);
        }

        function createResponseTable()
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

            $this->createBasicTable($tableName, $COLUMNS);
        }

        function executeQueryWithPrepare($from, $sql)
        {
            $stmt = $this->dbh->prepare($sql);      //prepare sql query

            $stmt->execute();                       //execute query

            if($stmt->errorInfo()[0] !== "00000"){  //if error occur?
                echo $from . ": " . $stmt->errorInfo()[0] . ":(" . $stmt->errorInfo()[1] . ") " . $stmt->errorInfo()[2] . "\n";
            }
        }

        // function loadDataToTableFromCSV($tableName, $filename){
        //     $datas = [];
        //     if (($handle = fopen($filename, "r")) !== FALSE) {
        //         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        //             $data = [];
        //             $datas[]
        //             $insert_mail_stmt->execute(array(":user_id" => $data[1], ":email" => $data[2], ":delete_at" => $data[3]));
        //         }
        //         fclose($handle);
        //     }
        // }

    }
?>