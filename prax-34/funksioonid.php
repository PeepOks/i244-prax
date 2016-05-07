<?php

	function connect_db(){
		global $connection;
		$test="proov";
		$host="localhost";
		$user="test";
		$pass="t3st3r123";
		$db="test";
		$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
		mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
	}
	
	function lisa() {
		if (isset($_POST['kaup'], $_POST['kogus']) && $_POST['kaup']!="" && $_POST['kogus']>0) {
						global $connection;	
						$kaup=mysqli_real_escape_string($connection, $_POST['kaup']);
						$kogus=mysqli_real_escape_string($connection, $_POST['kogus']);
					 	//$kaup=$_POST['kaup'];
						//$kogus=$_POST['kogus'];
					 	
						$query = "INSERT INTO PPLadu (kaup, kogus) VALUES ('".$kaup."', '".$kogus."');";
						//echo $query;
						$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
    		
			
		}
	}
	function kuva(){
		global $connection;
		$query = "SELECT * FROM PPLadu;";
		echo $query;
		$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
		
	}
?>