<!-- Buy Stock Page -->
	
<?php
	include 'includes/header_logged_in.html';
	
	//to do:
	// - calculate (amount)*(price) for stock selected
	// - remove total from portfolio of user
	// - add amount of stock to portfolio
	
?>
<head>
	<link rel="stylesheet" type="text/css" href="includes/TBSE_styles.css">
	<link href='https://fonts.googleapis.com/css?family=Glegoo' rel='stylesheet'>
</head>
<style>
	div.centered-element{
		margin:auto;
		width: 50%;
		border: 2px solid lightgrey;
		padding: 15px;
	}
	
	input.submit-btn{
		margin:center;
		width:25%;
	}
	
	*{
		font-family: 'Glegoo';
		font-size: 20px;
	}
</style>
<body style="background: #999999; color:black;">
	<center>
	<h1>Buy Stocks</h1>
	<!-- TO DO 
	- retrieve stock code from stocks.php
	- retrieve stock price from stocks.php
	-->
	<p>How many of [this stock] would you like to buy [for this price]?</p>
	<div class="form-group centered-element">
		<form action="buy_stocks.php" method="post">
			<p>Amount (max 100): <input type="number" style="background: #999999; color:black;" class="form-control grey_background" name="stock_amount" min="1" max="100"></p>
			<p><input type="submit" class="submit-btn nice_button_blue " name="Enter" value="Enter"></p>
		</form>
	</div>
	</center>
</body>

<?php
	require('mysqli_connect.php'); 
	session_start();//Start session array to load data
	$username = $_SESSION['username'];
	$errors = []; //If this isn't empty don't add to database
	
	//Use database
	$query= "use TBSE";
	$run_query = @mysqli_query($data_con, $query);
	
	echo "
	<br>
	<center>
		<p>
			<button type='button' class='nice_button_green' onclick=location.href='stocks.php'>Return to Stocks</button>
		</p>
	</center>
	";
	
	mysqli_close($data_con); //close connection	
?>