<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="includes/TBSE_styles.css">
	<link href='https://fonts.googleapis.com/css?family=Glegoo' rel='stylesheet'>
	
	<style>
		*{
			font-family: 'Glegoo';
			font-size: 20px;
		}
	</style>
</head>
<body class="grey_background">
	<footer class="footer">
		<center>
		<div class="container">
			
			<?php
			//session_start();//Start session array to load data
			$admin = $_SESSION['admin'];
			echo "<br>";
			if($admin == false){
				echo "<body><p><button type='button' class='nice_button_blue' onclick=location.href='portfolio.php' >Return to Portfolio</button></p></body>";
			}else{
				echo "<br><body><button type='button' class='nice_button_green' onclick=location.href='admin.php' >Return to Admin Page</button></body>";	
			}
			?>
			
		</div>
		</center>
	</footer>
</body>
</html>