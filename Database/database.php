<?php
    namespace Database;

    use \PDO;
    use \Exception;

    class Database{

        public $dbh;

        function __construct()
        {
            try
            {
                $ini_array = parse_ini_file(path('/database_config.ini'));

                $dsn = "mysql:host=" . $ini_array["server_name"];
                $dsn .= ";dbname=" . $ini_array["database_name"];

                $this->dbh = new PDO($dsn, $ini_array['username'], $ini_array['password']);
                $sql = 'set charset \'utf8\'';
                $this->executeQueryWithPrepare($sql);
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

            $this->executeQueryWithPrepare($sql);
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
                    //trim the space and tab;
                    $data[$key] = trim($value);
                }
                $sql .= "('" . implode("','", $data) . "'),";
                //(...., ...., ....),
            }

            $sql = rtrim($sql, ",");

            try {
                $this->executeQueryWithPrepare($sql);
            } catch (Exception $e) {
                throw new Exception("", code);
            }

        }

        function addForeignKeyIntoTable($tableName, $colName, $refTable, $refCol)
        {
            $sql = "ALTER TABLE " . $tableName . " ADD FOREIGN KEY (" . $colName . ") REFERENCES " . $refTable . " (" . $refCol . ");";
            $this->dbh->query($sql);
        }

        function executeQueryWithPrepare($sql){
            $stmt = $this->dbh->prepare($sql);      //prepare sql query

            $stmt->execute();                       //execute query

            if($stmt->errorInfo()[0] !== "00000"){  //if error occur?
                //$error =  $stmt->errorInfo()[0] . ":(" . $stmt->errorInfo()[1] . ") " . $stmt->errorInfo()[2] . "\n";
                // throw new $stmt->errorInfo();
            }
        }
    }
?>