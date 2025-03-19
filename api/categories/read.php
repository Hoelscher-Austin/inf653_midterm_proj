<?php
    require_once '../../config/Database.php';
    require_once '../../models/Category.php';

    header('Content-Type: application/json');

    try{
        $database = new Database();
        $db = $database->connect();

        $category = new Category($db);
        $categories = $category->getCategories();

        echo json_encode([
            'success' => true,
            'data' => $categories
        ]);
    }
    catch(Excpetion $e){
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

    exit;
?>

