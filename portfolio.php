<!DOCTYPE html>
<html>

<head>
<!-- to do -->
<link href='https://fonts.googleapis.com/css?family=Glegoo' rel='stylesheet'>
<style>
	*{
		font-family: 'Glegoo';
		font-size: 20px;
	}
</style>
</head>
<body>
	
		<?php
		include 'includes/header_logged_in.html';
		require('mysqli_connect.php'); 

		session_start();//Start session array to load data
		$username = $_SESSION['username'];
		//Use database
		$query= "use TBSE";
		$run_query = @mysqli_query($data_con, $query);
		
		//Get the customers balance
		$query= "Select balance from customer where customer.username like '$username'";
		$run_query = @mysqli_query($data_con, $query); // Run the query.			
		
		$balance = $run_query->fetch_assoc();	
		echo "<center><h2>Welcome $username </h2><p> Your account balance is currently: $".
		$balance["balance"]."<p> Here is your current stock portfolio. </p> </center>";
		
		
		//Query to select stocks owned by user
		$query = "Select portfolio.stock_code, bought_price, num_stocks, stock_price, balance from portfolio, customer, stocks where customer.username like '$username' 
			and customer.customer_id = portfolio.customer_id and portfolio.stock_code = stocks.stock_code"; 			
		$run_query = @mysqli_query($data_con, $query); //Run the query
		//Stocks purchased
		echo "<center>";

		if($run_query->num_rows > 0){	
			// Table header.
			echo '<table width="80%">
				  <thead><tr>
				  
					<th># of Stocks</th>
					<th>Stock Code</th>
					<th>Bought price</th>
					<th>Current price</th>
					<th>Possible Gain/loss ($)</th>
					<th>Buy stock</th>
					<th>Sell stock</th>
				  </tr></thead><tbody>
				';				
			while($row = $run_query->fetch_assoc()){ //While there are rows in the table not fetched 
				//Display their data
				$profit = (($row["num_stocks"] * $row["stock_price"]) - ($row["num_stocks"] * $row["bought_price"]));
				echo '<tr><td>' .$row["num_stocks"] .'</td><td>' .$row["stock_code"] .'</td><td>'. $row["bought_price"] .'</td><td>'. $row["stock_price"]
					.'</td><td>'. $profit 
					.'</td><td>'. '<button type="button" class="btn" onclick="buy.php">Buy</button>' 
					.'</td><td>'. '<button type="button" class="btn" onclick="sell.php">Sell</button>' 
					. '</td></tr>';
					//Tried using functions but went with opening up a new buy or sell page instead					
			}
			echo '</tbody></table>'; // Close the table.
		}else{
			echo "No stocks owned";	
		}			
		echo "</center>";			

		include 'includes/footer.html'; 
		?>
		<!-- HTML Code -->

</body>
</html>