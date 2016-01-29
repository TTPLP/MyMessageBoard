<?php
    namespace Database;
    use \PDO as PDO;
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

        function createBasicTable($tableName, $colArr_Type, $primaryCol, $foreignKey ){

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
                throw new \Exception("Database: Create Table: You did't give correct 'primaryCol'", 1);
            }

            $sql = rtrim($sql, ",");

            $sql .= ");"; //end

            if(!$dbh->query($sql)){
                echo "Create Table Failure!"
            }
        }

        function addForeignKeyIntoTable($tableName, $colName, $refTable, $refCol){
            $sql = "ALTER TABLE " . $tableName . " ADD FOREIGN KEY (" . $colName . ") REFERENCES " . $refTable . " (" . $refCol . ");";
            echo $sql;
            $this->dbh->query($sql);
        }
    }
?>