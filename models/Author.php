<?php

    class Author{
        private $conn;
        private $table = 'authors';

        // Properties
        public $id;
        public $author;

        // Constructor
        public function __construct($db){
            $this->conn = $db;
        }


        // Get All Authors

        public function getAuthors(){
            $query = "SELECT a.id, a.author
                    FROM authors a
                    ORDER BY a.id ASC
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

        // Get One Author by id

        public function getAuthor(){

            if(!isset($_GET['id'])){
                return json_encode([
                    'message' => 'author_id Not Found'
                ]);
            }

            $id = $_GET['id'];

            $query = "SELECT id, author
                    FROM authors
                    WHERE id = ?
            ";

            try{
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$id]);

                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();
            }

        }

        // Create New Author
        public function createAuthor(){

            $rawData = file_get_contents("php://input");
            $data = json_decode($rawData, true);

            $author = $data['author'];

            $query = "INSERT INTO authors(author)
                    VALUES(?)
            ";

            try{
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$author]);
                return $stmt->fetch(PDO::FETCH_ASSOC);

            }
            catch(PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();
            }


        }

        // Update Exisiting Author
        public function updateAuthor(){

            $rawData = file_get_contents("php://input");
            $data = json_decode($rawData, true);

            $author = $data['author'];
            $id = $data['id'];

            $query = "UPDATE authors
                    SET author = ?
                    WHERE id = ?
            ";

            try{
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$author,$id]);
                return $data;
            }
            catch(PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();
            }
        }



    // Delete Author
    public function deleteAuthor(){

        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $id = $data['id'];

        // Check if id Exist
        $query = "SELECT 
            EXISTS(
                SELECT 1
                FROM authors
                WHERE id = ?
            )
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $idExist = $stmt->fetchColumn();

        if(!$idExist){
            echo json_encode([
                'message' => 'No Author Found'
            ]);
            exit;
        }

        $query = "DELETE
            FROM authors
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