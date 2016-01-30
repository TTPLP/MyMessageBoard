<?php
    namespace Database;
    class Column{

        public $field;

        public $type;

        public $not_null;

        public $primary_key;

        public $foreign_key;

        public $unique_key;

        public $extra;

        function __construct($field, $type, $extra, $not_null, $primary_key, $unique_key, $foreign_key){
            $this->field = $field;
            $this->type = $type;
            $this->not_null = $not_null;
            $this->primary_key = $primary_key;
            $this->foreign_key = $foreign_key;
            $this->unique_key = $unique_key;
            $this->extra = $extra;
        }
    }