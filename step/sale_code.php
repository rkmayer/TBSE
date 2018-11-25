
		<?php
		//include 'includes/header_logged_in.html';
		//require('mysqli_connect.php'); 

		session_start();//Start session array to load data		
		$_SESSION['code'] = $_GET['code'];
		$_SESSION['profit'] = $_GET['profit'];
		$_SESSION['total_possible'] = $_GET['num'];
		$_SESSION['order_id'] = $_GET['order_id'];
		header("location: ../sell_stocks.php"); //go to the portfolio page
		
		?>
