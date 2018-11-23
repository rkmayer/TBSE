<?php
	//Registration form for new customers
	//Add header
	include 'includes/header.html'; 
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		//Connect to database
		require('mysqli_connect.php'); 
	
		$errors = []; //If this isn't empty don't add to database

		//Check for username
		if (empty($_POST['username'])){
			$errors[] = 'Please enter a username!';
		}else{
			$username = mysqli_real_escape_string($data_con, trim($_POST['username']));
		}

		//Check for  email
		if (empty($_POST['email'])){
			$errors[] = 'Please enter an email address!';
		}else{
			$email = mysqli_real_escape_string($data_con, trim($_POST['email']));
		}

		//Check for valid password
		if (!empty($_POST['pass'])){
			if ($_POST['pass'] != $_POST['confirm']) {
				$errors[] = 'Passwords do not match';
			}else{
				$password = mysqli_real_escape_string($data_con, trim($_POST['pass']));
			}
		}else{
			$errors[] = 'Please enter a password!';
		}
	
		if(empty($errors)){
			//Add to customer table
			
			$query= "use TBSE";
			$run_query = @mysqli_query($data_con, $query);
			$query = "insert into customer (username, email, password) VALUES ('$username', '$email', '$password')"; //Add to table
			$run_query = @mysqli_query($data_con, $query); // Run the query.

			if ($run_query) {//If it ran
				echo '<center><h1>Thank you! Your new account is now registered.</h1>
				<h2>Have $10,000 on us!</h2></center>';
			} else {
				echo '<center><h1>Error!</h1> <p class="error">Registration unsuccessful due to system errors!</p></center>'; //System Error
				echo '<p>' . mysqli_error($data_con) . '<br><br>Query: ' . $query . '</p>'; //Show Debug
			}
			
			mysqli_close($data_con); //close connection

			//add the footer and quit the script:
			include('includes/footer_logged_out.html');
			exit();

		} else { //Report user errors
			echo '<center><h1>Error!</h1> <p class="error">';
			foreach ($errors as $message) { echo " - $message<br>\n";}
			echo '</p><p>Fill in all data properly and try again.</p><p><br></p></center>';
		} 
	
		mysqli_close($data_con); //close connection
	}//End of registration
	
?>

<head>
<link rel="stylesheet" type="text/css" href="includes/TBSE_styles.css">
<link href='https://fonts.googleapis.com/css?family=Glegoo' rel='stylesheet'>
</head>
<style>
	*{
		font-family: 'Glegoo';
		font-size: 20px;
	}

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
</style>

<body class="grey_background">
<center>
<h1>Register New Account</h1>

<!-- Have to allign the fields still-->
<div class="form-group centered-element">
<form action="register_form.php" method="post">
	<p>Username: <input type="text" style="background: #999999; color:black;" class="form-control grey_background" name="username" size="20" maxlength="30" <?php if (isset($_POST['username'])) echo $_POST['username']; ?>></p>
	<p>Email Address: <input type="email" style="background: #999999; color:black;" class="form-control grey_background" name="email" size="15" maxlength="50" <?php if (isset($_POST['email'])) echo $_POST['email']; ?>></p>
	<p>Password: <input type="password" style="background: #999999; color:black;" class="form-control grey_background" name="pass" size="20" maxlength="30" <?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>></p>
	<p>Confirm Password: <input type="password" style="background: #999999; color:black;" class="form-control grey_background" name="confirm" size="12" maxlength="30" <?php if (isset($_POST['confirm'])) echo $_POST['confirm']; ?>></p>
	<p><input type="submit" class="nice_button_blue submit-btn" name="submit" value="Register"></p>
</form>
</center>
<br>
</div>
</body>
<?php include('includes/footer_logged_out.html'); ?>