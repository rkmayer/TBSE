
		<?php
		//include 'includes/header_logged_in.html';
		//require('mysqli_connect.php'); 

		session_start();//Start session array to load data	
		//Unsets variables		
		unset($_SESSION['username']);
		unset($_SESSION['admin']);
		unset($_SESSION['code']);
		unset($_SESSION['profit']);
		unset($_SESSION['order_id']);
		unset($_SESSION['total_possible']);
		header("location: index.php"); //go to the portfolio page

		?>
