<?php
    require_once '../../config/Database.php';
    require_once '../../models/Category.php';


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

        $category = new Category($db);
        $category->deleteCategory();

        
        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $data['id'],
            ]
        ]);

    }
    catch(Excpetion $e){
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

?>

