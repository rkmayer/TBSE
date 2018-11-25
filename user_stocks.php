<!DOCTYPE html>
<!--User stock view -->
<html>
<head>
<link href='https://fonts.googleapis.com/css?family=Glegoo' rel='stylesheet'>
<style>
	*{
		font-family: 'Glegoo';
		font-size: 20px;
	}
	
	
	.container form,
	.container form div {
		display: inline;
	}

</style>
</head>

<body class="grey_background">
	<?php
	include 'includes/header_logged_in.html'; 
	require_once ('mysqli_connect.php'); 
	
	$display = 5; //How many results to display at once
	//Use database
	$query= "use TBSE";
	$run_query = @mysqli_query($data_con, $query);
	$colour =null;
		
	//###Paginiation###
	//Get current page
	if (isset($_GET['current']) && is_numeric($_GET['current'])) {
		$current = $_GET['current'];	
	}else{
		$current=1;
	}
	//Find number of pages to display
	if (isset($_GET['num']) && is_numeric($_GET['num'])) {
		$pages = $_GET['num'];	
	}else{
		$query = "select count(stock_code) from stocks";
		$run_query = @mysqli_query($data_con, $query); // Run the query.		
		$row = $run_query->fetch_assoc();
		$results = $row['count(stock_code)'];
		//echo "$results";
		if($results > $display){
			$pages = ceil($results/$display);
			
		}else{
			$pages =1;
		}
	}
	
	//Find starting point of database
	if(isset($_GET['start']) && is_numeric($_GET['start'])){
		$start = $_GET['start'];	
	}else{
		$start = 0;
	}
	
	
	//###Sorting###
	//$asc = (isset($_GET['asc'])) ?  $_GET['asc'] : 'desc';		
	$sort = (isset($_GET['sort'])) ?  $_GET['sort'] : 'stock_code';
	//$sort = $sort .' '. $asc;	

	
	$query = "Select stock_code, stock_name, stock_price from stocks order by $sort limit $start, $display";
	$run_query = @mysqli_query($data_con, $query); // Run the query.	
			
	//###Display###
	echo "<center>";

	if($run_query->num_rows > 0){	
		// Table header.
		echo '
		<p>Current Stocks:</p>
		
		
		';
		//if($asc == 'asc'){		
			echo '<table width="100%" >
				<thead><tr>
					<th><a href="user_stocks.php?sort=stock_code& asc=desc">Stock code</a></th>
					<th><a href="user_stocks.php?sort=stock_name& asc=desc">Company name</a></th>
					<th><a href="user_stocks.php?sort=stock_price& asc=desc">Price per stock</a></th>
					<th>Buy Stock</th>
				</tr></thead><tbody>
			';	
		/*}else{
			echo '<table width="100%" >
				<thead><tr>
					<th><a href="user_stocks.php?sort=stock_code& asc=asc">Stock code</a></th>
					<th><a href="user_stocks.php?sort=stock_name& asc=asc">Company name</a></th>
					<th><a href="user_stocks.php?sort=stock_price& asc=asc">Price per stock</a></th>
					<th>Buy Stock</th>
				</tr></thead><tbody>
			';	
		}//End of asc vs desc	*/		
		while($row = $run_query->fetch_assoc()){ //While there are rows in the table not fetched 
			$colour = ($colour=='#eeeeee' ? '#ffffff' :'#eeeeee');//Switch colours at each row
			//Display their data
			echo '<tr bgcolor='.$colour.'><td>' .$row["stock_code"] .'</td><td>' .$row["stock_name"] .'</td><td>'. $row["stock_price"] .'</td><td>';
			//Buy form action acts as a button that allows the transfer of the rows data
			echo "<form action=step/store_code.php> 
					<input name=code type=hidden value='".$row["stock_code"]."';> 
					<input type=submit name=submit value = Buy> </form></td>"; 	
			echo '</tr>';			
		}
		echo '</tbody></table>'; // Close the table.
		
	}else{
		echo "No stocks listed";	
	}
	
	//Last Page button
	if($current > 1){
	echo "<div class='container'><form action=user_stocks.php> 
					 <input name=num type=hidden value='".$pages."';>
					 <input name=start type=hidden value='".($start-$display)."';>
					 <input name=current type=hidden value='".($current-1)."';>
					 <input name=sort type=hidden value='".$sort."';>
					 <input type=submit name=submit value = Last_Page> </form>"; 
	}
	
	//Next Page Button
	if($current < $pages){
	echo "<form action=user_stocks.php> 
					 <input name=num type=hidden value='".$pages."';>
					 <input name=start type=hidden value='".($start+$display)."';>
					 <input name=current type=hidden value='".($current+1)."';>
					 <input name=sort type=hidden value='".$sort."';>
					 <input type=submit name=submit value = Next_Page> </form></div>"; 
	}

	echo "</center>";			

	include 'includes/footer_back.php'; 
	?>


</body>
</html>