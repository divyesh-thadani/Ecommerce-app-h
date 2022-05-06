<?php
    
    include_once './config/database.php';
    include_once './class/products.php';
    $database = new Database();
    $db = $database->getConnection();
    $items = new Products($db);
    $stmt = $items->getproducts();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);
    if($itemCount > 0){
        
        $productsArr = array();
        $productsArr["body"] = array();
        $productsArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "product_cat" => $product_cat,
                "product_brand" => $product_brand,
                "product_title" => $product_title,
                "product_price" => $product_price,
                "product_qty" => $product_qty,
                "product_desc" => $product_desc,
                "product_image" => $product_image,
                "product_keywords" => $product_keywords
            );
            array_push($productsArr["body"], $e);
        }
        echo json_encode($productsArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>