<?php
//Connect to the data base
				
			$servername = "localhost";
			$username = "root";
			$password = "";
			$databasename = "TBSE";
			
			//create connection
			$data_con=  @mysqli_connect($servername, $username, $password, $databasename) OR die('Could not connect to MySQL: ' . mysqli_connect_error() );

?>