<?php
    namespace Database;
    class FKData{
        public $refTable;
        public $refCol;

        function __construct($refTable, $refCol){
            $this->refTable = $refTable;
            $this->refCol = $refCol;
        }
    }