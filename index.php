<!DOCTYPE html>
<html>
<html lang="en">
	<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
	<link href='https://fonts.googleapis.com/css?family=Glegoo' rel='stylesheet'>
	
	<link rel="stylesheet" type="text/css" href="includes/button_styles.css">
	<style>
		*{
			font-family: 'Glegoo';
			font-size: 20px;
		}
		
		body{
			background: grey;
		}
		
		div.withpadding{
			margin:center;
			width:100%;
			padding: 50px;
		}
		
		div.login-register-buttons{
			margin:center;
			width:100%;
			padding: 5px;
		}
		
		p.withpadding{
			margin:center;
			width:100%;
			padding: 10px;
		}
		
		h1.withpadding{
			margin:center;
			width:100%;
		}
	</style>
	</head>
	
	<body>
		
			<?php
				include 'includes/header.html';
			?>
			<!-- HTML Code -->
			<div class='jumbotron jumbotron-fluid withpadding'>
				<h1 class='text-center withpadding'><b style="font-size:38px;">Thunder Bay Stock Exchange - TBSE</b></h1>
				<p class='text-center withpadding'>
					Your favourite simulated market for practice of stock buying, selling, and trading!
				</p>
				<br>
				<p class='text-center withpadding'>Please login, or register today, below:</p>
				<center>
				<div class='login-register-buttons'>
					<button type='button' class='nice_button_blue btn-lg' onclick=location.href='login_form.php'>LOGIN</button>
					<button type='button' class='nice_button_red btn-lg' onclick=location.href='register_form.php' >REGISTER</button>
				</div>
				
				</center>

	
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>