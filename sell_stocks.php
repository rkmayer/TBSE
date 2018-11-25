<!-- Sell Stock Page -->
	
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
	<h1>Selling Stock</h1>

<?php
	require_once ('mysqli_connect.php'); 
	session_start();//Start session array to load data
	
	//Transfer variables over
	$username = $_SESSION['username'];
	$code = $_SESSION['code'];
	$potential = $_SESSION['profit'];
	$total_possible = $_SESSION['total_possible'];
	$order_id = $_SESSION['order_id'];
	
	$errors = []; //If this isn't empty don't add to database
	
	echo "<p>You have $total_possible stocks in $code that you can sell.</p>";
	echo "<p>If you sell all of them you would make a profit of $potential.</p>";
	
	//Use database
	$query= "use TBSE";
	$run_query = @mysqli_query($data_con, $query);
		
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Check if a request was made

		if (empty($_POST['stock_amount'])){
			$errors[] = 'Empty sell amount!';
		}else{
			$amount = mysqli_real_escape_string($data_con, trim($_POST['stock_amount']));
		}
		//Make sure user doesn't sell more stocks than they own
		if($amount > $total_possible){
			$errors[] = "You're trying to sell more stocks than you have!";
		}
		
		if(empty($errors)){//If error free
			//Calculate new balance
			
			//Get current stock price (in case it updated)
			$query = "Select stock_price from stocks where stock_code like '$code'";
			$run_query = @mysqli_query($data_con, $query); // Run the query.	
			$current_price = $run_query->fetch_assoc();	
			
			//Get amount gained from selling 
			$income = (($amount * $current_price['stock_price']));
			
			//Get customers balance
			$query= "Select balance from customer where customer.username like '$username'";
			$run_query = @mysqli_query($data_con, $query); // Run the query.		
			$new_balance = $run_query->fetch_assoc();	
			
			//Add income to balance
			$new_balance = ($new_balance['balance']+ $income);
			
							
			//Update balance in database
			$query = "update customer set balance = '$new_balance' where username like '$username'";
			$run_query = @mysqli_query($data_con, $query); // Run the query.
			
			//Remove sold stocks from portfolio
			if($amount == $total_possible){
				//Delete row
				$query = "delete from portfolio where order_id like '$order_id'";
			}else{
				//Subtract stock amount
				$query = "update portfolio set num_stocks = ($total_possible - $amount) where order_id like '$order_id'";
			}
			$query_ran = @mysqli_query($data_con, $query); // Run the query.		
				
			if ($run_query && $query_ran) {//If both run	
				echo '<center><h1>The stocks have been sold for a total of: '.$income.'!</h1></center>';
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
	}

	mysqli_close($data_con); //close connection	
?>

	
	<div class="form-group centered-element">
		<form action="sell_stocks.php" method="post">
			<p>Amount: <input type="number" style="background: #999999; color:black;" class="form-control grey_background" name="stock_amount" min="1" max="10000" value="<?php if (isset($_POST['stock_amount'])) echo $_POST['stock_amount']; ?>" ></p>
			<p><input type="submit" class="submit-btn nice_button_blue " name="Enter" value="Enter"></p>
		</form>
	</div>
	</center>
	
<?php	
	include 'includes/footer_user.php'; 
?>	
</body>