<?php
    namespace Database;
    class Column{

        private $field;

        private $type;

        private $extra;

        private $not_null;

        private $primary_key;

        private $unique_key;

        private $foreign_key;

        function __construct($field, $type, $extra, $not_null, $primary_key, $unique_key, $foreign_key){
            $this->field = $field;
            $this->type = $type;
            $this->not_null = $not_null;
            $this->primary_key = $primary_key;
            $this->foreign_key = $foreign_key;
            $this->unique_key = $unique_key;
            $this->extra = $extra;
        }


        function getField(){
            return $this->field;
        }

        function getType(){
            return $this->type;
        }

        function getExtra(){
            return $this->extra;
        }

        function getNotNull(){
            return $this->not_null;
        }

        function getPK(){
            return $this->primary_key;
        }

        function getUK(){
            return $this->unique_key;
        }

        function getFK(){
            return $this->foreign_key;
        }
    }