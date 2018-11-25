
		<?php
		//include 'includes/header_logged_in.html';
		//require('mysqli_connect.php'); 

		session_start();//Start session array to load data		
		$_SESSION['code'] = $_GET['code'];
		header("location: ../buy_stocks.php"); //go to the portfolio page
		
		?>
