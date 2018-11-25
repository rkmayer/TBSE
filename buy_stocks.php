<!-- Buy Stock Page -->
	
<?php
	include 'includes/header_logged_in.html';
	
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

<?php
	require_once('mysqli_connect.php'); 
	session_start();//Start session array to load data
	
	$username = $_SESSION['username'];
	//$code = $_GET['code']; //Taken from session now
	$code = $_SESSION['code'];
	$errors = []; //If this isn't empty don't add to database
	
	//Use database
	$query= "use TBSE";
	$run_query = @mysqli_query($data_con, $query);
	
	//Get price for stock
	$query= "Select stock_price from stocks where stock_code like '$code'";
	$run_query = @mysqli_query($data_con, $query);
	$price = $run_query->fetch_assoc();	
	
	echo "<p>How much of: $code would you like to buy for: $$price[stock_price] per stock?</p>";
	
	//Get balance for stock
	$query= "Select balance from customer where customer.username like '$username'";
	$run_query = @mysqli_query($data_con, $query);
	$balance = $run_query->fetch_assoc();	
	
	echo "<p>Your balance is currently $$balance[balance]</p>";
	
	//Get account number
	$query= "Select customer_id  from customer where username like '$username'";
	$run_query = @mysqli_query($data_con, $query);
	$id = $run_query->fetch_assoc();		

	//echo "<p>Your id is currently $$id[customer_id]</p>";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Check if a request was made
	
		
		if (empty($_POST['stock_amount'])){
			$errors[] = 'Empty purchase amount!';
		}else{
			$amount = mysqli_real_escape_string($data_con, trim($_POST['stock_amount']));
		}
	
		if(empty($errors)){
			//Calculate if there user has enough balance
			$total = ($amount * $price['stock_price']);
			$new_balance = ($balance['balance'] - $total);
			if($new_balance < 0){
				$errors[] = 'Purchase would bring your balance lower than $0!';
			}
			//Insert
			if(empty($errors)){//If still error free
				
					$query = "insert into portfolio (customer_id, stock_code, bought_price, num_stocks) VALUES ('$id[customer_id]', '$code', '$price[stock_price]', '$amount')"; 
					$run_query = @mysqli_query($data_con, $query); // Run the query.		
					
					$query = "update customer SET balance = $new_balance where username like '$username'";
					$query_ran = @mysqli_query($data_con, $query); // Run the query.
				
					if ($run_query && $query_ran) {//If both run	
							echo '<center><h1>The stocks have been purchased for a total of: '.$total.'!</h1></center>';
							echo '<center><h1>You now have a balance of: '.$new_balance.'!</h1></center>';
						} else {
							echo '<center><h1>Error!</h1> <p class="error">Stock purchase unsuccessful due to system errors!</p></center>'; //System Error
							echo '<p>' . mysqli_error($data_con) . '<br><br>Query: ' . $query . '</p>'; //Show Debug
						}
						mysqli_close($data_con); //close connection
						include 'includes/footer_user.php'; 
						exit();
		
			}else { //Report user errors
				echo '<center><h1>Error!</h1> <p class="error">';
				foreach ($errors as $message) { echo " - $message<br>\n";}
				echo '</p></center>';
			} 
		}else { //Report user errors
				echo '<center><h1>Error!</h1> <p class="error">';
				foreach ($errors as $message) { echo " - $message<br>\n";}
				echo '</p></center>';
		} 
	}

	
	mysqli_close($data_con); //close connection	
?>

	
	<div class="form-group centered-element">
		<form action="buy_stocks.php" method="post">
			<p>Amount (max 10000): <input type="number" style="background: #999999; color:black;" class="form-control grey_background" name="stock_amount" min="1" max="10000" value="<?php if (isset($_POST['stock_amount'])) echo $_POST['stock_amount']; ?>" ></p>
			<p><input type="submit" class="submit-btn nice_button_blue " name="Enter" value="Enter"></p>
		</form>
	</div>
	</center>
	
<?php	
	include 'includes/footer_user.php'; 
?>	
</body>