<!-- Admin add page -->

		
<?php
			
	include '../includes/header_logged_in.html'; 
	require('../mysqli_connect.php'); 
	session_start();//Start session array to load data
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
	
			if(empty($errors)){//If error free
			
				//Insert
				$query = "insert into stocks (stock_code, stock_name, stock_price) VALUES ('$code', '$name', '$price')"; 
				$run_query = @mysqli_query($data_con, $query); // Run the query.			
				if ($run_query) {//If it ran	
					echo '<h1>Thank you the stock has been added!</h1>';
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
<body class="grey_background">
	<center>
	<h1>Add New Stock</h1>
	<p>Please fill in the form to add a new stock to the market</p>
	<div class="form-group centered-element">
		<form action="add.php" method="post">
			<p>Stock Code: <input type="text" class="form-control" name="code" size="3" maxlength="3" value="<?php if (isset($_POST['code'])) echo $_POST['code']; ?>"></p>
			<p>Company Name: <input type="text" class="form-control" name="name" size="20" maxlength="30" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" ></p>
			<p>Initial Price: <input type="number" class="form-control" name="price" size="20" maxlength="12" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>" ></p>
			<p><input type="submit" class="submit-btn nice_button_blue " name="Enter" value="Enter"></p>
		</form>
	</div>
	</center>
</body>

<?php include '../includes/footer_admin.html'; ?>