<?php
    require_once '../../config/Database.php';
    require_once '../../models/Category.php';


    header('Content-Type: application/json');

    try{
        $database = new Database();
        $db = $database->connect();

        $category = new Category($db);
        $result = $category->getCategory();

        if(!$result){
            echo json_encode([
                'success' => false,
                'message' => 'category_id Not Found'
            ]);
        }
        else{
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
        }
    }
    catch(Exception $e){
        echo json_encode([
            'success' => false,
            'message' => $e->message()
        ]);
    }




?>


