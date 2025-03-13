<?php

class Author{
    private $conn;
    private $table = 'quotes';

    // Properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    // Constructor
    public function __constructor($db){
        $this->conn = $db;
    }

}

?>