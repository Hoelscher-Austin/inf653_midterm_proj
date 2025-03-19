<?php

    require_once '../../config/Database.php';
    require_once '../../models/Quote.php';





    header('Content-Type: application/json');

    try{

        $database = new Database();
        $db = $database->connect();

        $quote = new Quote($db);
        $quotes = $quote->getQuotes();

        echo json_encode([
            'success' => true,
            'data' => $quotes
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
