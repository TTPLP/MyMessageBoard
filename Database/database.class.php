<?php
    namespace Database;
    use \PDO;
    use \Exception;

    class Database{

        public $dbh;

        function __construct(){
            require __DIR__ . "/database_config.php";

            try {
                $this->dbh = new PDO("mysql:host=$server_name;dbname=$database_name", $username, $password);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        function createBasicTable($tableName, $colArr_Type, $primaryCol, $foreignKeydata){

            $isPrimary = false;

            $sql = "CREATE TABLE IF NOT EXISTS " . $tableName ." (";
            foreach ($colArr_Type as $colName => $colType) {

                $sql .= " ";

                if($colName === $primaryCol){
                    $sql .= $colName . " BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
                    $isPrimary = true;
                }else{
                    $sql .= ($colName . " " . $colType . ",");
                }
            }

            if($isPrimary === false){
                throw new Exception("Database: Create Table: You did't give correct 'primaryCol'", 1);
            }

            if($foreignKeydata !== null){
                foreach ($foreignKeydata as $colName => $refData) {
                    if(array_key_exists("tableName", $refData) && array_key_exists("colName", $refData)){
                        $sql .= " FOREIGN KEY (" . $colName . ") REFERENCES " . $refData['tableName'] . " (" . $refData['colName'] . "),";
                    }else{
                        throw new Exception("Your 'foreignKeydata' of $tableName.", 1);
                    }
                }
            }

            $sql = rtrim($sql, ",");

            $sql .= ");"; //end

            $stmt = $this->dbh->prepare($sql);

            $stmt->execute();

            if($stmt->errorInfo()[0] !== "00000"){  //if error occur?
                echo $stmt->errorInfo()[2];
            }
        }

        function addForeignKeyIntoTable($tableName, $colName, $refTable, $refCol){
            $sql = "ALTER TABLE " . $tableName . " ADD FOREIGN KEY (" . $colName . ") REFERENCES " . $refTable . " (" . $refCol . ");";
            echo $sql;
            $this->dbh->query($sql);
        }

        function createMemberTable(){
            $tableName = "member";
            $colArr_Type = [
                "id" => "BIGINT UNSIGNED NOT NULL AUTO_INCREMENT",
                "username" => "VARCHAR(64) NOT NULL UNIQUE",
                "password" => "VARCHAR(64) NOT NULL",
                "create_at" => "TIMESTAMP",
                "update_at" => "TIMESTAMP",
                "delete_at" => "TIMESTAMP"];
            $primaryCol = "id";
            $foreignKeydata = null;

            $this->createBasicTable($tableName, $colArr_Type, $primaryCol, $foreignKeydata);
        }

        function createMailTable(){
            $tableName = "mail";
            $colArr_Type = [
                "id" => "BIGINT UNSIGNED NOT NULL AUTO_INCREMENT",
                "user_id" => "BIGINT UNSIGNED NOT NULL",
                "email" => "VARCHAR(64) NOT NULL",
                "delete_at" => "TIMESTAMP",
                "prim" => "BOOLEAN",
                ];
            $primaryCol = "id";
            $foreignKeydata = [
                "user_id" => ["tableName" => "member", "colName" => "id"]
            ];

            $this->createBasicTable($tableName, $colArr_Type, $primaryCol, $foreignKeydata);
        }

        function createMessageTable(){
            $tableName = "message";
            $colArr_Type = [
                "id" => "BIGINT UNSIGNED NOT NULL AUTO_INCREMENT",
                "user_id" => "BIGINT UNSIGNED NOT NULL",
                "title" => "VARCHAR(64) NOT NULL",
                "content" => "TEXT",
                "create_at" => "TIMESTAMP",
                "update_at" => "TIMESTAMP",
                "delete_at" => "TIMESTAMP"
                ];
            $primaryCol = "id";
            $foreignKeydata = [
                "user_id" => ["tableName" => "member", "colName" => "id"]
            ];

            $this->createBasicTable($tableName, $colArr_Type, $primaryCol, $foreignKeydata);
        }

        function createResponseTable(){
            $tableName = "response";
            $colArr_Type = [
                "id" => "BIGINT UNSIGNED NOT NULL AUTO_INCREMENT",
                "user_id" => "BIGINT UNSIGNED NOT NULL",
                "message_id" => "BIGINT UNSIGNED NOT NULL",
                "title" => "VARCHAR(64) NOT NULL",
                "content" => "TEXT",
                "create_at" => "TIMESTAMP",
                "update_at" => "TIMESTAMP",
                "delete_at" => "TIMESTAMP"
                ];
            $primaryCol = "id";
            $foreignKeydata = [
                "user_id" => ["tableName" => "member", "colName" => "id"],
                "message_id" => ["tableName" => "message", "colName" => "id"]
            ];

            $this->createBasicTable($tableName, $colArr_Type, $primaryCol, $foreignKeydata);
        }
    }
?>