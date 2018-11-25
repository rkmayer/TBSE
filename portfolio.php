
<?php
	include 'includes/header_logged_in.html';
	require_once ('mysqli_connect.php'); 
	session_start();//Start session array to load data
		
	//Check that a user is logged in 
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$colour =null;
		
		//Use database
		$query= "use TBSE";
		$run_query = @mysqli_query($data_con, $query);
		
		//Get the customers balance
		$query= "Select balance from customer where customer.username like '$username'";
		$run_query = @mysqli_query($data_con, $query); // Run the query.			
	
		$balance = $run_query->fetch_assoc();	
		echo "<center><h2>Welcome $username </h2><p> Your account balance is currently: $".
		$balance["balance"]."<p> Here is your current stock portfolio: </p> </center>";
		
		//###Paginiation###
		$display = 5; //How many results to display at once
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
		//$asc = (isset($_GET['asc'])) ?  $_GET['asc'] : 'asc';		
		$sort = (isset($_GET['sort'])) ?  $_GET['sort'] : 'stock_code';
		//$sort = $sort .' '. $asc;
		
		//Query to select stocks owned by user
		$query = "Select portfolio.stock_code, bought_price, num_stocks, stock_price, balance, order_id from portfolio, customer, stocks where customer.username like '$username' 
			and customer.customer_id = portfolio.customer_id and portfolio.stock_code = stocks.stock_code order by $sort limit $start, $display"; 			
		$run_query = @mysqli_query($data_con, $query); //Run the query
		
				
		//###Display Table###
		echo "<center>";

		if($run_query->num_rows > 0){	
			// Table header.
			//Probably an easier way to do this but... (Switching from asc to desc)
			//if($asc == 'asc'){
				echo '
				<div style="overflow-x:auto;">
				<table class="nice_table">
					<thead>
						<tr class="nice_table_head">  
							<th><a href="portfolio.php?sort=num_stocks& asc=desc">Amount owned</a></th> 
							<th ><a href="portfolio.php?sort=stock_code& asc=desc">Stock Code</a></th>
							<th><a href="portfolio.php?sort=bought_price& asc=desc">Bought price</a></th>
							<th><a href="portfolio.php?sort=stock_price& asc=desc">Current price</a></th>
							<th>Possible Gain/loss ($)</th>
							<th>Sell stock</th>
						</tr>
					</thead>
				<tbody>
				';		
			while($row = $run_query->fetch_assoc()){ //While there are rows in the table not fetched 
				$colour = ($colour=='#eeeeee' ? '#ffffff' :'#eeeeee');//Switch colours at each row
				//Display their data
				$profit = (($row["num_stocks"] * $row["stock_price"]) - ($row["num_stocks"] * $row["bought_price"]));
				echo '<tr class="nice_table_data"><td>' .$row["num_stocks"] .'</td><td>' .$row["stock_code"] .'</td><td>'. $row["bought_price"] .'</td><td>'. $row["stock_price"]
					.'</td><td>'. $profit.'</td><td>';
				//Sell form action acts as a button that allows the transfer of the rows data
				echo "<form action='step/sale_code.php'> 
						 <input name='code' type='hidden' value='".$row["stock_code"]."';>
						 <input name='profit' type='hidden' value='".$profit."';> 
						 <input name='num' type='hidden' value='".$row["num_stocks"]."';>
						 <input name='order_id' type='hidden' value='".$row["order_id"]."';>
						 <input type='submit' class='nice_button_red' name='submit' value='Sell'> </form></td>"; 	
				echo '</tr>';	
				
			}
			echo '</tbody></table></div>'; // Close the table.
		}else{
			echo "No stocks owned";	
		}	
		//Last Page button
		if($current > 1){
		echo "<div class='container'><form action=portfolio.php> 
			 <input name=num type=hidden value='".$pages."';>
			 <input name=start type=hidden value='".($start-$display)."';>
			 <input name=sort type=hidden value='".$sort."';>

			 <input name=current type=hidden value='".($current-1)."';>
			 <input type=submit name=submit value = Last_Page> </form>"; 
		}
	
		//Next Page Button
		if($current < $pages){
		echo "<form action=portfolio.php> 
			 <input name=num type=hidden value='".$pages."';>
			 <input name=start type=hidden value='".($start+$display)."';>
			 <input name=sort type=hidden value='".$sort."';>
			
			 <input name=current type=hidden value='".($current+1)."';>
			 <input type=submit name=submit value = Next_Page> </form></div>"; 
		}
	
		echo "</center>";			
		include 'includes/footer.html'; 
	}else{
		echo "<center><h2>Error user is not logged in! </h2> </center>";		
		exit;
	}
	mysqli_close($data_con); //close connection		
?>

