<?php
    require_once '../../config/Database.php';
    require_once '../../models/Quote.php';


    header('Content-Type: application/json');


    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if(!isset($data['quote']) || !isset($data['author_id']) || !isset($data['category_id'])){
        echo json_encode([
            'message' => 'Missing Required Parameters'
        ]);
        exit;
    }

    try{
        $database = new Database();
        $db = $database->connect();

        $quote = new Quote($db);
        $newQuote = $quote->updateQuote();

        
        echo json_encode(
            $data
        );

    }
    catch(Excpetion $e){
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

?>

