<?php

session_start();
if(!isset($_SESSION["uid"])){
	header("location:index.php");
}

if (isset($_POST["payment_id"]) && isset($_POST["amt"]) && isset($_POST["name"])) {
	$payment_id = $_POST["payment_id"];
		$name = $_POST["name"];
		$amt = $_POST["amt"];
	if ($p_st == "Completed") {

		

		include_once("db.php");
		$sql = "SELECT p_id,qty FROM cart WHERE user_id = '$payment_id'";
		$query = mysqli_query($con,$sql);
		if (mysqli_num_rows($query) > 0) {
			# code...
			while ($row=mysqli_fetch_array($query)) {
			$product_id[] = $row["p_id"];
			$qty[] = $row["qty"];
			}

			for ($i=0; $i < count($product_id); $i++) { 
				$sql = "INSERT INTO orders (user_id,product_id,qty,payment_id,p_status) VALUES ('".$product_id[$i]."','".$qty[$i]."','$payment_id','$p_st')";
				mysqli_query($con,$sql);
			}

			$sql = "DELETE FROM cart WHERE user_id = '$cm_user_id'";
			if (mysqli_query($con,$sql)) {
				?>

				<?php
			}
		}else{
			header("location:index.php");
		}
		
	}
}



?>

















































