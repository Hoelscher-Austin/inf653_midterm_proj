<?php
    require_once '../../config/Database.php';
    require_once '../../models/Author.php';

    header('Content-Type: application/json');

    try{
        $database = new Database();
        $db = $database->connect();
    
        $author = new Author($db);
        $result = $author->getAuthor();

        
        if(!$result){
           echo json_encode(
                'message' => 'author_id Not Found');
        }
        else{
            echo json_encode(
                $result
            );
        }
    }
    catch(Exception $e){
        echo json_encode([
            'success' => false,
            'message' => $e->message()
        ]);
    }



?>
