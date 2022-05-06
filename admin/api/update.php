<?php
    
    include_once './config/database.php';
    include_once './class/products.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Products($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->product_id = $data->product_id;
    
    // employee values
    $item->product_cat = $data->product_cat;
    $item->product_brand = $data->product_brand;
    $item->product_title = $data->product_title;
    $item->product_price = $data->product_price;
    $item->product_qty = $data->product_qty;
    $item->product_desc = $data->product_desc;
    $item->product_image = $data->product_image;
    $item->product_keywords = $data->product_keywords;
    
    if($item->updateProducts()){
        echo json_encode("Product updated.");
    } else{
        echo json_encode("Product couldn't be updated");
    }
?>