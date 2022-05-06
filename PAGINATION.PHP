<?php
$db = mysqli_connect('localhost', 'root', '', 'ecommerceapp');

$record_per_page = 5;
$page = '';
$output = '';

if(isset($_POST["page"])){
    $page = $_POST["page"];
}
else{
    $page = 1;
}

$start_from = ($page - 1) * $record_per_page;
$query = "SELECT * FROM products ORDER BY product_id DESC LIMIT $start_from, $record_per_page";
$result = mysqli_query($db, $query);
$output .= "<table> <tr> <th width='50%'> Brand </th> <th width='50%'> Title </th> <th width='50%'> Price </th> <th width='50%'> Description </th> <th width='50%'> Image </th> </tr>";

while ($row = mysqli_fetch_array($result)){
    $output .= '<tr> <td>'. $row["product_brand"] .'</td> <td>'. $row["product_title"] .'</td> <td>'. $row["product_price"] .'</td> <td>'. $row["product_desc"] .'</td> <td>'. $row["product_image"] .'</td> </tr>';
}

$output .= '</table> <br> <div align="center">';

$page_query = "SELECT * FROM products ORDER BY product_id DESC";
$page_result = mysqli_query($db, $page_query);
$total_records = mysqli_num_rows($page_result);
$total_pages = ceil($total_records / $record_per_page);

for ($i=1; $i<= $total_pages; $i++){
    $output .= "<span class='pagination_link' style='cursor:pointer; padding:6px; border:1px solid #ccc; id='".$i."'>".$i."</span>";
}

echo $output;
?>