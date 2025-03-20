<?php
    require_once '../../config/Database.php';
    require_once '../../models/Author.php';


    header('Content-Type: application/json');


    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if(!isset($data['id'])){
        echo json_encode([
            'message' => 'Missing Required Parameters'
        ]);
        exit;
    }

    try{
        $database = new Database();
        $db = $database->connect();

        $author = new Author($db);
        $author->deleteAuthor();

        
        echo json_encode([
            'id' => $data['id']
        ]);

    }
    catch(Excpetion $e){
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

?>

