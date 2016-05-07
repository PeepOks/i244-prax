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

function logi(){
	// siia on vaja funktsionaalsust (13. nädalal)
	if (isset($_SESSION['user'])){
    			header("Location: ?page=loomad");
			} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if (isset($_POST['user']) && $_POST['user']!="" && isset($_POST['pass']) && $_POST['pass']!=""){
					global $connection;
					$username=mysqli_real_escape_string($connection, $_POST['user']);
					$password=mysqli_real_escape_string($connection, $_POST['pass']);
					
					$query = "select id from poks_kylastajad where username='".$username."' and passw=sha1('".$password."');";
					$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
					if(mysqli_num_rows($result) > 0 )
        				{
        					echo "sai sisse";
            				$_SESSION["user"] = $username; 
							header("Location: ?page=loomad");
        				}
				}
			} else
			{
				include_once('views/login.html');	
			}
	include_once('views/login.html');	
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}


function kuva_puurid(){
	
	if (!isset($_SESSION['user']))
			{
    			header("Location: ?page=login");
			} else {
	// siia on vaja funktsionaalsust
	global $connection;
	$query = "select distinct(puur) as puur from poks_loomaaed order by puur asc;";
	$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connect));
	//loome tühja massiivi
	$puurid = array();
	// hangime tulemusest andmed
	//$puurid = mysqli_fetch_assoc($result) or die(mysql_error());

	while($puurinimed = mysqli_fetch_assoc($result)){
		$uus_result = mysqli_query($connection, "SELECT * FROM poks_loomaaed WHERE  puur=".mysqli_real_escape_string($connection, $puurinimed['puur']));
		while ($loomarida=mysqli_fetch_assoc($uus_result)) {
			$puurid[$puurinimed['puur']][]=$loomarida;
		}
	}
	include_once('views/puurid.html');
	
	}
}

function lisa(){
	// siia on vaja funktsionaalsust (13. nädalal)
		if (!isset($_SESSION['user']))
			{
    			header("Location: ?page=login");
			} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$lisatudfail = upload("liik");
				if (isset($_POST['nimi'], $_POST['puur'], $_FILES['liik']) && $lisatudfail!="" && $_POST['nimi']!="" && $_POST['puur']!="" && $_FILES['liik']['name']!=""){
					
						global $connection;	
						$nimi=mysqli_real_escape_string($connection, $_POST['nimi']);
						$puur=mysqli_real_escape_string($connection, $_POST['puur']);
						$liik=mysqli_real_escape_string($connection, $lisatudfail);
					 
						$query = "INSERT INTO poks_loomaaed (nimi, puur, liik) VALUES ('".$nimi."', ".$puur.", '".$liik."');";
						echo $query;
						$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
						if(mysqli_insert_id($connection) > 0 )
        					{       
								header("Location: ?page=loomad");
        					}
					
				}
			}
	
	include_once('views/loomavorm.html');	
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>