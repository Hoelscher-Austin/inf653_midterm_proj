<?php

class Quote{
    private $conn;
    private $table = 'quotes';

    // Properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    // Constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // Get All Quotes

    public function getQuotes(){
        $query = "SELECT quote
                FROM quotes 
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    // Get Specific quote
    public function getQuote(){
        $id = $_GET['id'];
        
        $query = "SELECT quote
                FROM quotes
                WHERE id = ?
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }
    }


    // Get quotes by author
    public function getQuotesByAuthor(){
        $author_id = $_GET['author_id'];

        $query = "SELECT quote
                FROM quotes
                WHERE author_id = ?
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$author_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    // Get quotes by category
    public function getQuotesByCategory(){
        $category_id = $_GET['category_id'];

        $query = "SELECT quote
                FROM quotes
                WHERE category_id = ?
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$category_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }


    }




    // Get quotes from an author in a specific category
    public function getQuoteCA(){
        $author_id = $_GET['author_id'];
        $category_id = $_GET['category_id'];

        $query ="SELECT quote
                FROM quotes
                WHERE author_id = ? AND category_id = ?
        ";
        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$author_id,$category_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }

    }




}

?>