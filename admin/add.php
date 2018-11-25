<!-- Admin add page -->
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
	
	.nice_button_red{
		transition-duration:1s;
		border: 2px solid #bf2020;
		border-radius: 8px;
		background-color: #999999;
		color: black;
	}
	.nice_button_red:hover{
		transition-duration:1s;
		border-radius: 8px;
		background-color: #bf2020;
		color: white;
	}
	.nice_button_green{
		transition-duration:1s;
		border: 2px solid #048c0b;
		border-radius: 8px;
		background-color: #999999;
		color: black;
	}
	.nice_button_green:hover{
		transition-duration:1s;
		border-radius: 8px;
		background-color: #048c0b;
		color: white;
	}

	.nice_button_blue{
		transition-duration:1s;
		border-radius: 8px;
		border: 2px solid #0745af;
		background-color: #999999;
		color: black;
	}
	.nice_button_blue:hover{
		transition-duration:1s;
		border-radius: 8px;
		background-color: #0745af;
		color: white;
	}
</style>		
<?php
			
	include '../includes/header_logged_in.html'; 
	require_once ('../mysqli_connect.php'); 
	session_start();//Start session array to load data
	if (isset($_SESSION['username']) && isset($_SESSION['admin'])) {	
		$username = $_SESSION['username'];
		$admin =  $_SESSION['admin'];
		$errors = []; //If this isn't empty don't add to database
	
		//Use database
		$query= "use TBSE";
		$run_query = @mysqli_query($data_con, $query);
	
	
		if($admin == true){
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Check if a request was made
				//Check if code is empty 
				if (empty($_POST['code'])){
					$errors[] = 'Empty code!';
				}else{
					$code = mysqli_real_escape_string($data_con, trim($_POST['code']));
				}
		
				//Check if name is empty 
				if (empty($_POST['name'])){
					$errors[] = 'Empty company name!';
				}else{
					$name = mysqli_real_escape_string($data_con, trim($_POST['name']));
				}		
		
				//Check if price is empty 
				if (empty($_POST['price'])){
					$errors[] = 'Empty initial offering price!';
				}else{
					$price = mysqli_real_escape_string($data_con, trim($_POST['price']));
				}	
				$query= "Select stock_code from stocks";
				$run_query = @mysqli_query($data_con, $query); // Run the query.
		
				//Check for already used usernames
				while($row = $run_query->fetch_assoc()){ //While there are rows in the table not fetched 
					if($row["stock_code"] == $code){
						$errors[] = 'Stock already added!';
					}
				}
				if(empty($errors)){//If error free
			
					//Insert
					$query = "insert into stocks (stock_code, stock_name, stock_price) VALUES ('$code', '$name', '$price')"; 
					$run_query = @mysqli_query($data_con, $query); // Run the query.			
					if ($run_query) {//If it ran	
						echo '<center><h1>Thank you the stock has been added!</h1></center>';
					} else {
						echo '<center><h1>Error!</h1> <p class="error">Stock addition unsuccessful due to system errors!</p></center>'; //System Error
						echo '<p>' . mysqli_error($data_con) . '<br><br>Query: ' . $query . '</p>'; //Show Debug
					}
					mysqli_close($data_con); //close connection
					include '../includes/footer_admin.html';
					exit();
			
				} else { //Report user errors
					echo '<center><h1>Error!</h1> <p class="error">';
					foreach ($errors as $message) { echo " - $message<br>\n";}
					echo '</p></center>';
				} 
			}
			mysqli_close($data_con); //close connection		

			echo "</center>";
			//include '../includes/footer_back.php'; 
		}else{
			echo "<center><h2>Error you are not an admin! </h2>";
			//include '../includes/footer.html'; 
		}
	}else{
		echo "<center><h2>Error user is not logged in! </h2> </center>";		
		exit;		
	}
?>

<body style="background: #999999; color:black;">
	<center>
	<h1>Add New Stock</h1>
	<p>Please fill in the form to add a new stock to the market</p>
	<div class="form-group centered-element">
		<form action="add.php" method="post">
			<p>Stock Code: <input type="text" style="background: #999999; color:black;" class="form-control grey_background" name="code" size="3" maxlength="3" value="<?php if (isset($_POST['code'])) echo $_POST['code']; ?>"></p>
			<p>Company Name: <input type="text" style="background: #999999; color:black;" class="form-control grey_background" name="name" size="20" maxlength="30" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" ></p>
			<p>Initial Price: <input type="number" style="background: #999999; color:black;" class="form-control grey_background" name="price" size="20" maxlength="12" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>" ></p>
			<p><input type="submit" class="submit-btn nice_button_blue " name="Enter" value="Enter"></p>
		</form>
	</div>
	</center>
</body>
<br>

<?php include '../includes/footer_admin.html'; ?>