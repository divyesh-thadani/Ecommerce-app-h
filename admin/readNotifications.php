<?php
$conn = mysqli_connect("localhost", "root", "", "ecommerceapp");

$sql = "UPDATE notifications SET is_active='1' ";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Success...";
}

else {
    echo "Failed!";
}
?>