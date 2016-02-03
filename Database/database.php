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
                $sql = 'set charset \'utf8\'';
                $this->dbh->executeQueryWithPrepare('connect to database:', );
            }
            catch (PDOException $e)
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
                $sql .=  $column->getField() . " " . $column->getType() . " ";

                if($column->getExtra() !== false){
                    $sql .= $column->getExtra() . " ";
                }

                if($column->getNotNull() === true){
                    $sql .= "NOT NULL";
                }

                $sql .= ",";

                if($column->getPK() !== false){
                    $sql .= "PRIMARY KEY (" . $column->getField() . "),";
                }

                if($column->getFK() !== false){
                    $sql .= "FOREIGN KEY (" . $column->getField() . ") ";
                    $sql .= "REFERENCES " . $column->getFK()->refTable . "(";
                    $sql .= $column->getFK()->refCol . "),";
                }

                if($column->getUK() !== false){
                    $sql .= "UNIQUE KEY (" . $column->getField() . "),";
                }
            }

            $sql = rtrim($sql, ",");

            $sql .= ");"; //en

            $this->executeQueryWithPrepare("createBasicTable()", $sql);
        }

        function insertSingleIntoTableIfNotExists($tableName, $data)
        {
            $sql = "INSERT INTO " . $tableName . " (";

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

        function insertIntoTable_batch($tableName, $datafields, $datas)
        {
            $sql = "INSERT INTO " . $tableName . " (" . implode(',', $datafields) . ') VALUES ';

            //INSERT INTO table (...., ...., .....) VALUES

            foreach ($datas as $index => $data)
            {
                foreach ($data as $key => $value) {
                    $data[$key] = trim($value);
                }
                $sql .= "('" . implode("','", $data) . "'),";
                //(...., ...., ....),
            }

            $sql = rtrim($sql, ",");

            $this->executeQueryWithPrepare("insertIntoTable_batch()", $sql);
        }

        function addForeignKeyIntoTable($tableName, $colName, $refTable, $refCol)
        {
            $sql = "ALTER TABLE " . $tableName . " ADD FOREIGN KEY (" . $colName . ") REFERENCES " . $refTable . " (" . $refCol . ");";
            $this->dbh->query($sql);
        }

        function createMemberTable()
        {
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
                $error =  $from . ": " . $stmt->errorInfo()[0] . ":(" . $stmt->errorInfo()[1] . ") " . $stmt->errorInfo()[2] . "\n";
                throw new Exception($serror, 1);
            }
        }

        function loadDataToTableFromCSV($tableName, $filename){
            $datas = []; //ther storage for datas;
            if (($handle = fopen("data_csv/" . $filename, "r")) !== FALSE) {
                $datafields = fgetcsv($handle, 1000, ",");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    array_push($datas, $data);
                }
                fclose($handle);
                $this->insertIntoTable_batch($tableName, $datafields, $datas);
            }else{
                throw new Exception("loadDataToTableFromCSV(): this file can't open!", 1);
            }
        }
    }
?>