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
        $query = "SELECT q.id, q.quote, a.author, q.category
                FROM quotes q
                JOIN authors a ON q.author_id = a.id
                JOIN categories c ON q.category_id = c.id
                ORDER BY q.id ASC
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

    // Create quote
    public function createQuote(){
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $newQuote = $data['quote'];
        $author_id = $data['author_id'];
        $category_id = $data['category_id'];

        // Check if author_id exists
        $query = "SELECT 
            EXISTS(
                SELECT 1 
                FROM authors 
                WHERE id = ?
            )
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$author_id]);
        $authorExists = $stmt->fetchColumn();

        if (!$authorExists) {
            echo json_encode([
                'message' => 'author_id Not Found'
            ]);
            exit;
        }

        // Check if category_id exists
        $query = "SELECT 
            EXISTS(
                SELECT 1 
                FROM categories 
                WHERE id = ?
            )
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$category_id]);
        $categoryExists = $stmt->fetchColumn();

        if (!$categoryExists) {
            echo json_encode([
                'message' => 'category_id Not Found'
            ]);
            exit;
        }

        $query = "INSERT INTO quotes(quote,author_id,category_id)
                VALUES(?,?,?)
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$newQuote,$author_id,$category_id]);
            return $this->conn->lastInsertId();
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }

    }

    // Update Existing Quote

    public function updateQuote(){

        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $quote = $data['quote'];
        $author_id = $data['author_id'];
        $category_id = $data['category_id'];
        $id = $data['id'];

        // Check if author_id exists
        $query = "SELECT 
            EXISTS(
                SELECT 1 
                FROM authors 
                WHERE id = ?
            )
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$author_id]);
        $authorExists = $stmt->fetchColumn();

        if (!$authorExists) {
            echo json_encode([
                'message' => 'author_id Not Found'
            ]);
            exit;
        }

        // Check if category_id exists
        $query = "SELECT 
            EXISTS(
                SELECT 1 
                FROM categories 
                WHERE id = ?
            )
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$category_id]);
        $categoryExists = $stmt->fetchColumn();

        if (!$categoryExists) {
            echo json_encode([
                'message' => 'category_id Not Found'
            ]);
            exit;
        }

        // Check if quote id exist
        $query = "SELECT 
            EXISTS(
                SELECT 1
                FROM quotes
                WHERE id = ?
            )
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $idExists = $stmt->fetchColumn();

        if(!$idExists){
            echo json_encode([
                'message' => 'No Quotes Found'
            ]);
            exit;
        }

        $query = "UPDATE quotes 
                SET quote = ?, author_id = ?, category_id = ?
                WHERE id = ?
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$quote,$author_id,$category_id,$id]);
            return $data;
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }

    }


    // Delete Quote
    public function deleteQuote(){

        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $id = $data['id'];

        // Check if id Exist
        $query = "SELECT 
            EXISTS(
                SELECT 1
                FROM quotes
                WHERE id = ?
            )
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $idExist = $stmt->fetchColumn();

        if(!$idExist){
            echo json_encode([
                'message' => 'No Quotes Found'
            ]);
            exit;
        }

        $query = "DELETE
            FROM quotes
            WHERE id = ?
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $data;
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }


    }


}

?>