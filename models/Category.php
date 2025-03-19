<?php

class Category{
    private $conn;
    private $table = 'categories';

    // Properties
    public $id;
    public $category;

    // Constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // Get All Categories
    public function getCategories(){
        $query = "SELECT c.id, c.category
                FROM categories c
                ORDER BY c.id ASC
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

    // Get One Category by id

    public function getCategory(){

        if(!isset($_GET['id'])){
            return json_encode([
                'message' => 'category_id Not Found'
            ]);
        }

        $id = $_GET['id'];

        $query = "SELECT category, id
                FROM categories
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


    // Create Category
    public function createCategory(){

        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true); 

        $category = $data['category'];

        $query = "INSERT INTO categories(category)
                VALUES (?)
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$category]);
            return $this->conn->lastInsertId();
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    // Update Category
    public function updateCategory(){

        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true); 

        $category = $data['category'];
        $id = $data['id'];

        $query = "UPDATE categories
                SET category = ?
                WHERE id = ?
        ";

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$category,$id]);
            return $data;
        }
        catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

}




?>