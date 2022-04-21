<?php
$db = mysqli_connect("localhost", "root", "", "ecommerceapp");

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $first_name = $line[0];
                $last_name = $line[1];
                $email  = $line[2];
                $mobile  = $line[3];
                $address1 = $line[4];
                $address2 = $line[5];
                
                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT user_id FROM user_info WHERE email = '".$line[2]."'";
                $prevResult = $db->query($prevQuery);
                
                if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $db->query("UPDATE user_info SET first_name = '".$first_name."', last_name = '".$last_name."', mobile = '".$mobile."', address1 = '".$address1."', address2 = '".$address2."' WHERE email = '".$email."'");
                }else{
                    // Insert member data in the database
                    $db->query("INSERT INTO user_info (first_name, last_name, email, mobile, address1, address2) VALUES ('".$first_name."','".$last_name."', '".$email."', '".$mobile."','".$address1."', '".$address2."')");
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

header("Location: index.php".$qstring);
?>