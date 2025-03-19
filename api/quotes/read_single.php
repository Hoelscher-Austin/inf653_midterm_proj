<?php
    require_once '../../config/Database.php';
    require_once '../../models/Quote.php';



    try{
        $database = new Database();
        $db = $database->connect();
    
    
        $quote = new Quote($db);
    
        if(isset($_GET['id'])){
            $result = $quote->getQuote();
        }
        elseif(isset($_GET['author_id']) && isset($_GET['category_id'])){
            $result = $quote->getQuoteCA();
        }
        elseif(isset($_GET['author_id'])){
            $result = $quote->getQuotesByAuthor();
    
        }
        else{
            $result = $quote->getQuotesByCategory();
        }

        if(!$result){
            echo json_encode([
                'success' => false,
                'message' => 'No Quotes Found'
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