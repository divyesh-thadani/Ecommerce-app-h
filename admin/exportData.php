<?php
$db = mysqli_connect("localhost", "root", "", "ecommerceapp");

$query = $db->query("SELECT * FROM user_info ORDER BY user_id ASC"); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "members-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('user_id', 'first_name', 'last_name', 'email', 'mobile', 'address1', 'address2'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['user_id'], $row['first_name'], $row['last_name'], $row['email'], $row['mobile'], $row['address1'], $row['address2']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 

?>