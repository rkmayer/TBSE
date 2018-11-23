<?php
	//login form
	//This would be required by other pages to show details?
	//Add header
	include 'includes/header.html'; 
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		//Connect to database
		require('mysqli_connect.php'); 
	
		$errors = []; //If this isn't empty don't add to database

		//Check for username
		if (empty($_POST['username'])){
			$errors[] = 'Invalid username!';
		}else{
			$username = mysqli_real_escape_string($data_con, trim($_POST['username']));
		}

		//Check for password
		if (empty($_POST['pass'])){
			$errors[] = 'Invalid password!';
		}else{
			$password = mysqli_real_escape_string($data_con, trim($_POST['pass']));
		}
	
		if(empty($errors)){

			$query= "use TBSE";
			$run_query = @mysqli_query($data_con, $query);
			
			//Checks if the admin checkbox is selected
			if (isset($_POST['admin'])){//Login as admin
				$query = "Select admin_id from admin where username = '$username' and password = '$password'"; 
				$admin = true;
				//echo "<center>Welcome Admin</center>";
			}else{//Login as customer
				$query = "Select customer_id from customer where username = '$username' and password = '$password'"; 
				$admin = false;
			}
			
			$run_query = @mysqli_query($data_con, $query); // Run the query.			
			if ($run_query) {//If it ran	
				//Make sure only 1 row is returned			
				$count = mysqli_num_rows($run_query);
				if($count == 1) {
					echo "<center>Welcome $username , we're directing you to your profile</center>";
					session_start(); //Start session array to save data
					$_SESSION['username'] = $username;
					//$_SESSION['id'] = $run_query;
					$_SESSION['admin'] = $admin;
					mysqli_close($data_con); //close connection
					if($admin == false){
						header("location: portfolio.php"); //go to the portfolio page
					}else{
						header("location: admin.php"); //go to the admin page
					}
					//exit script
					exit();
					}else {
					echo '<center><p>Failed to login please confirm your username and password.</p></center>';
					}
			} else {
				echo '<center><h1>Error!</h1> <p class="error">System errors!</p></center>'; //System Error
				echo '<p>' . mysqli_error($data_con) . '<br><br>Query: ' . $query . '</p>'; //Show Debug
			}
			
		} else { //Report user errors
			echo '<center><h1>Error!</h1> <p class="error">';
			foreach ($errors as $message) { echo " - $message<br>\n";}
			echo '</p></center>';
		} 
	
		mysqli_close($data_con); //close connection
	}//End of login
	
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
<h1>Login</h1>

<div class="form-group centered-element">
<form action="login_form.php" method="post">
	<p>Username: <input type="text" style="background:#999999; color:black;" class="form-control grey-background" name="username" size="20" maxlength="30" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"></p>
	<p>Password: <input type="password" style="background:#999999; color:black;" class="form-control grey-background" name="pass" size="20" maxlength="30" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" ></p>
	<p>Login as admin: <input type="checkbox" style="color:black;" class="form-control grey-background" name="admin" value="yes"></p>
	<p><input type="submit" class="nice_button_blue submit-btn" name="login" value="Login"></p>
</form>
</center>
<br>
</div>

</body>
<?php include('includes/footer_logged_out.html'); ?>