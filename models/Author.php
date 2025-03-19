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

            $query = "SELECT author, id
                    FROM authors
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
                return $this->conn->lastInsertId();
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

    }

?>