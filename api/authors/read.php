<?php
    require_once '../../config/Database.php';
    require_once '../../models/Author.php';


    header('Content-Type: application/json');


    try{
        $database = new Database();
        $db = $database->connect();

        $author = new Author($db);
        $authors = $author->getAuthors();

        echo json_encode(
            $authors
        );
    }
    catch(Excpetion $e){
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

    exit;

?>

