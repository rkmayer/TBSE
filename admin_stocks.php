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

<body class="grey_background">
	<?php
	include 'includes/header_logged_in.html'; 
	require('mysqli_connect.php'); 

	//Use database
	$query= "use TBSE";
	$run_query = @mysqli_query($data_con, $query);
	
	$query = "Select stock_code, stock_name, stock_price from stocks"; 
	$run_query = @mysqli_query($data_con, $query); // Run the query.						
							
	//Stocks list
	echo "<center>";

	if($run_query->num_rows > 0){	
		// Table header.
		echo '
		<p>Current Stocks:</p>
		
		
		';
		echo '<table width="80%">
			  <thead><tr>
			  
				<th>Stock code</th>
				<th>Company name</th>
				<th>Price per stock</th>
			  </tr></thead><tbody>
			';				
		while($row = $run_query->fetch_assoc()){ //While there are rows in the table not fetched 
			//Display their data
			echo '<tr><td>' .$row["stock_code"] 
			.'</td><td>' .$row["stock_name"] 
			.'</td><td>'. $row["stock_price"]
			.'</td></tr>';			
		}
		echo '</tbody></table>'; // Close the table.
	}else{
		echo "No stocks listed";	
	}			
	echo "</center>";			

	include '../includes/footer_admin.html';
	?>
	<!-- HTML Code -->

</body>
</html>