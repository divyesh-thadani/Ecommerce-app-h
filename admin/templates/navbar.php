<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}
	.nav{
		padding: 0 1rem;
	}
	.nav li{
		list-style: none;
	}
	.nav > li {
		position: relative;
		display: inline-block;
	}
	.nav > li .dropdown-check{
		display: none;
	}
	.nav > li > a{
		color: #fff;
		font-size: 1.5rem;
		padding: 1rem 0;
		display: inline-block;
		cursor: pointer;
	}
	.nav > li:hover > .dropdown{
		visibility: visible;
		opacity: 1;
	}
	.nav li .dropdown{
		position: absolute;
		top: 100%;
		left: -110px;
		background-color: #ffffff;
		border: 1px solid #ccc;
		padding: 1rem;
		visibility: hidden;
		opacity: 0;
		width: 300px;
		transition: 0.3s;
	}
	.nav li .dropdown li {
		margin-bottom: 1rem;
		border-bottom: 1px solid #ccc;
		padding-bottom: 1rem;
	}
	.nav li .dropdown li:last-child{
		margin-bottom: 0;
		padding-bottom: 0;
		border-bottom: 0;
	}
	.nav > li > a .count {
		position: absolute;
		right: -7px;
		top: 16px;
		border-radius: 50%;
		font-size: 14px;
		display: flex;
		justify-content: center;
		align-items: center;
		background-color: white;
		color: #716b6a;
		width: 16px;
		height: 15px;
	}
</style>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
 	<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../admin/index.php">Ecommerce</a>
 	<input class="form-control form-control-dark w-80" type="text" placeholder="Search" aria-label="Search">
 	<ul class="navbar-nav px-3">
 		<li class="nav-item text-nowrap">
 			<?php

				if (isset($_SESSION['admin_id'])) {
				?>
 				<a class="nav-link" href="../admin/admin-logout.php">Sign out</a>
 				<?php
				} else {
					$uriAr = explode("/", $_SERVER['REQUEST_URI']);
					$page = end($uriAr);
					if ($page === "login.php") {
					?>
 					<a class="nav-link" href="../admin/register.php">Register</a>
 				<?php
					} else {
					?>
 					<a class="nav-link" href="../admin/login.php">Login</a>
 			<?php
					}
				}

				?>

 		</li>
 	</ul>

	<ul class='nav px-3'>
<li>
	<?php  $conn = mysqli_connect("localhost", "root", "", "ecommerceapp");
		$sql="SELECT * FROM notifications WHERE is_active='0' ORDER BY id DESC";
		$result = mysqli_query($conn, $sql);?>
	<input type="checkbox" class="dropdown-check" id="check">
	<a href="#" id="notifications"><label for="check"><i class="fa-regular fa-bell" ></i><span class="count"><?php echo mysqli_num_rows($result); ?></span></label>
</a>
	<ul class="dropdown">
	<?php
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0){
			foreach ($result as $item){

				?>

<li><?php echo $item["notification"]; ?></li>
<?php } ?>
</ul>
<?php } ?>
</li>
</ul>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $("#notifications").on("click", function (){
    // console.log(success);
		  $.ajax({
        url: "./readNotifications.php",
        success: function(result){
           console.log(result);
        }
      });
    });
  });
</script>