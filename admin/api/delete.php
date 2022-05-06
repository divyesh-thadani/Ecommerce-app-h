<?php
    
    include_once './config/database.php';
    include_once './class/products.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Products($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->product_id = $data->product_id;
    
    if($item->deleteproducts()){
        echo json_encode("Product deleted.");
    } else{
        echo json_encode("Product could not be deleted");
    }
?>