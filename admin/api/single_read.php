<?php
    include_once './config/database.php';
    include_once './class/products.php';
    $database = new Database();
    $db = $database->getConnection();
    $item = new Products($db);
    $item->product_id = isset($_GET['product_id']) ? $_GET['product_id'] : die();
  
    $item->getSingleProduct();
    if($item->name != null){
        // create array
        $prd_arr = array(
            "product_cat" => $item->product_cat,
            "product_brand" => $item->product_brand,
            "product_title" => $item->product_title,
            "product_price" => $item->product_price,
            "product_qty" => $item->product_qty,
            "product_desc" => $item->product_desc,
            "product_image" => $item->product_image,
            "product_keywords" => $item->product_keywords
        );
      
        http_response_code(200);
        echo json_encode($prd_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Product not found.");
    }
?>