<?php

    class Author{
        private $conn;
        private $table = 'authors';

        // Properties
        public $id;
        public $author;

        // Constructor
        public function __constructor($db){
            $this->conn = $db;
        }

    }

?>