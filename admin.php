<!DOCTYPE html>
<!-- Admin page -->
<html>
	<style>
	div.left-element{
		margin:absolute;
		left:10px;
		width: 50%;
		border: 2px solid lightgrey;
		padding: 15px;
	}
	*{
		font-family: 'Glegoo';
		font-size: 20px;
	}
	</style>
	<head>
	<!-- to do -->
		<link href='https://fonts.googleapis.com/css?family=Glegoo' rel='stylesheet'>
		<link rel="stylesheet" type="text/css" href="includes/TBSE_styles.css">
	</head>
	<body class="grey_background">
		
	<?php
			
		include 'includes/header_logged_in.html'; 
		require('mysqli_connect.php'); 

		session_start();//Start session array to load data
		$username = $_SESSION['username'];
		//Use database
		$query= "use TBSE";
		$run_query = @mysqli_query($data_con, $query);
		echo "<center><h3>Welcome, administrator [$username] </h3>";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Check if a request was made
			//Check if code is empty 
			if (empty($_POST['code'])){
				$errors[] = 'Empty code!';
			}else{
				$code = mysqli_real_escape_string($data_con, trim($_POST['code']));
			}
		
		
			if (isset($_POST['delete'])){//If the admin wants to delete
				//Check nothing else
			}else{
				//Otherwise check if price is empty 
				if (empty($_POST['price'])){
					$errors[] = 'Empty price!';
				}else{
					$price = mysqli_real_escape_string($data_con, trim($_POST['price']));
				}	
			}
		
			if(empty($errors)){//If error free
				//Update
				if (isset($_POST['delete'])){//If the admin wants to delete
					$query = "DELETE from stocks where stock_code like '$code'"; 
				}else{//Update
					$query = "update stocks set stock_price='$price' where stock_code like '$code'"; 
				}
				$run_query = @mysqli_query($data_con, $query); // Run the query.			
				if ($run_query) {//If it ran	
					echo '<h1>Thank you the stock list has been updated!</h1>';
				} else {
					echo '<center><h1>Error!</h1> <p class="error">Stock list change unsuccessful due to system errors!</p></center>'; //System Error
					echo '<p>' . mysqli_error($data_con) . '<br><br>Query: ' . $query . '</p>'; //Show Debug
				}
				mysqli_close($data_con); //close connection
				include 'includes/footer.html';
				exit();
			
			} else { //Report user errors
				echo '<center><h1>Error!</h1> <p class="error">';
				foreach ($errors as $message) { echo " - $message<br>\n";}
				echo '</p></center>';
			} 
		}
		mysqli_close($data_con); //close connection		
		?>
		
		<div class="form-group left-element">
		<form action="admin.php" method="post">
			<p>Stock Code: <input type="text" style="background: #999999; color:black;" class="form-control grey_background" name="code" size="3" maxlength="3" value="<?php if (isset($_POST['code'])) echo $_POST['code']; ?>"></p>
			<p>New Price: <input type="number" style="background: #999999; color:black;" class="form-control grey_background" name="price" size="20" maxlength="12" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>" ></p>
			<p>Remove from Active Trading <input type="checkbox" class="form-control" name="delete" value="yes"></p>
			<p><input type="submit" class="nice_button_green" name="Update Stock" value="Update/Remove Stock"></p>
		</form>
		</div>
		<br>
			
		<!--<p><button type='button' class='btn btn-caution'onclick=location.href='admin/update.php'>Update stock</button></p>-->
		<p><button type='button' class='nice_button_blue' onclick=location.href='admin/add.php'>Add Stock</button></p>
		<p><button type="button" class="nice_button_green" onclick=location.href="admin/admin_stocks.php">View Stocks</button></p>
			
			<!-- HTML Code -->

	</body>
</html>