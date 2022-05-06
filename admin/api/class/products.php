<?php
    class Products{
        // Connection
        private $conn;
        // Table
        private $db_table = "products";
        // Columns
        public $product_cat;
        public $product_brand;
        public $product_title;
        public $product_price;
        public $product_qty;
        public $product_desc;
        public $product_image;
        public $product_keywords;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getproducts(){
            $sqlQuery = "SELECT product_cat, product_brand, product_title, product_price, product_qty, product_desc, product_image, product_keywords FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createproducts(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET 
                    product_cat = :category, 
                    product_brand = :brand, 
                    product_title = :title, 
                    product_price = :price,
                    product_qty = :quantity,
                    product_desc = :description,
                    product_image = :image,
                    product_keywords = :keywords";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->product_cat=htmlspecialchars(strip_tags($this->product_cat));
            $this->product_brand=htmlspecialchars(strip_tags($this->product_brand));
            $this->product_title=htmlspecialchars(strip_tags($this->product_title));
            $this->product_price=htmlspecialchars(strip_tags($this->product_price));
            $this->product_qty=htmlspecialchars(strip_tags($this->product_qty));
            $this->product_desc=htmlspecialchars(strip_tags($this->product_desc));
            $this->product_image=htmlspecialchars(strip_tags($this->product_image));
            $this->product_keywords=htmlspecialchars(strip_tags($this->product_keywords));
        
            // bind data
            $stmt->bindParam(":category", $this->product_cat);
            $stmt->bindParam(":brand", $this->product_brand);
            $stmt->bindParam(":title", $this->product_title);
            $stmt->bindParam(":price", $this->product_price);
            $stmt->bindParam(":quantity", $this->product_qty);
            $stmt->bindParam(":description", $this->product_desc);
            $stmt->bindParam(":image", $this->product_image);
            $stmt->bindParam(":keywords", $this->product_keywords);
        
            if($stmt->execute()){
               return true;
            }
            else{
            return false;
            }
        }
        // READ single
        public function getSingleProduct(){
            $sqlQuery = "SELECT
                        product_cat, 
                        product_brand, 
                        product_title, 
                        product_price, 
                        product_qty,
                        product_desc,
                        product_image,
                        product_keywords
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       product_id = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            // $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->product_cat = $dataRow['product_cat'];
            $this->product_brand = $dataRow['product_brand'];
            $this->product_title = $dataRow['product_title'];
            $this->product_price = $dataRow['product_price'];
            $this->product_qty = $dataRow['product_qty'];
            $this->product_desc = $dataRow['product_desc'];
            $this->product_image = $dataRow['product_image'];
            $this->product_keywords = $dataRow['product_keywords'];
        }        
        // UPDATE
        public function updateProducts(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET 
                    product_cat, 
                    product_brand, 
                    product_title, 
                    product_price, 
                    product_qty,
                    product_desc,
                    product_image,
                    product_keywords
                    WHERE 
                        product_id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->product_cat=htmlspecialchars(strip_tags($this->product_cat));
            $this->product_brand=htmlspecialchars(strip_tags($this->product_brand));
            $this->product_title=htmlspecialchars(strip_tags($this->product_title));
            $this->product_price=htmlspecialchars(strip_tags($this->product_price));
            $this->product_qty=htmlspecialchars(strip_tags($this->product_qty));
            $this->product_desc=htmlspecialchars(strip_tags($this->product_desc));
            $this->product_image=htmlspecialchars(strip_tags($this->product_image));
            $this->product_keywords=htmlspecialchars(strip_tags($this->product_keywords));
        
            // bind data
            $stmt->bindParam(":category", $this->product_cat);
            $stmt->bindParam(":brand", $this->product_brand);
            $stmt->bindParam(":title", $this->product_title);
            $stmt->bindParam(":price", $this->product_price);
            $stmt->bindParam(":quantity", $this->product_qty);
            $stmt->bindParam(":description", $this->product_desc);
            $stmt->bindParam(":image", $this->product_image);
            $stmt->bindParam(":keywords", $this->product_keywords);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // DELETE
        function deleteproducts(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE product_id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        
            $stmt->bindParam(1, $this->product_id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>