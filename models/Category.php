<?php

class Category{
    private $conn;
    private $table = 'categories';

    // Properties
    public $id;
    public $category;

    // Constructor
    public function __constructor($db){
        $this->conn = $db;
    }

}

?>