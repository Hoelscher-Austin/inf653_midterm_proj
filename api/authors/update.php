<?php
    require_once '../../config/Database.php';
    require_once '../../models/Author.php';



    header('Content-Type: application/json');

    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if(!isset($data['author'])){
        echo json_encode([
            'message' => 'Missing Required Parameters'
        ]);
        exit;
    }

    try{
        $database = new Database();
        $db = $database->connect();

        $author = new Author($db);
        $newAuthor = $author->updateAuthor();

        echo json_encode([
                'id' => $data['id'],
                'author' => $data['author']
        ]);
    }
    catch(Excpetion $e){
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    
?>

