<?php

function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function login(){
	if (isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=gallery");
		echo "pole sisse logitud";
	} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if (isset($_POST['user']) && $_POST['user']!="" && isset($_POST['pass']) && $_POST['pass']!=""){
					global $connection;
					
					$username=mysqli_real_escape_string($connection, $_POST['user']);
					$password=mysqli_real_escape_string($connection, $_POST['pass']);
					//Kysime kas baasis on selline 
					$query = "select id from poks_projekt_kasutajad where knimi='".$username."' and parool=sha1('".$password."');";
					$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
					if(mysqli_num_rows($result) > 0 ){
            			//uuendame visit counterit
						$query = "update poks_projekt_kasutajad set kylastusi=kylastusi+1 where knimi='".$username."';";
						mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
						echo "pole sisse logitud";
						//Küsime kasutaja rolli
						$query = "select roll from poks_projekt_kasutajad where knimi='".$username."';";
						$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
						$roll = mysqli_fetch_assoc($result);
						//Määrame sessioonis kasutaja rollid
						if ($roll['roll']=='admin'){
							$_SESSION['user_role'] = 'admin';
						} else {
							$_SESSION['user_role'] = 'user';
						}
						
						$_SESSION["logged_in_user"] = $username;
						header("Location: ?page=gallery");
        			} else {
						include_once('views/login.html');
        			}
				} else {
					include_once('views/login.html');
				}
	} else {
		include_once('views/login.html');
	}
		
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}

function fetch_user_data($uname) {
	global $connection;
	
	$uname = mysqli_real_escape_string($connection, $uname);
	$query = "SELECT * from poks_projekt_kasutajad WHERE knimi='".$uname."';";
	$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connect));
	
	if(mysqli_num_rows($result) > 0 ){
			$kasutajainfo = array();
			$kasutajainfo = mysqli_fetch_assoc($result);
			return $kasutajainfo;
	} else {
		header("Location: ?page=change_u");
	}
}

function fetch_picture_data($p_id) {
	global $connection;
	$p_id = mysqli_real_escape_string($connection, $p_id);
	$query = "SELECT * from poks_projekt_pildid WHERE id='".$p_id."';";
	$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connect));
	
	if(mysqli_num_rows($result) > 0 ){
			$pildiinfo = array();
			$pildiinfo = mysqli_fetch_assoc($result);
			return $pildiinfo;
	} else {
		header("Location: ?page=change_p");
	}
}

function display_gallery(){
	
	if (!isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=login");
	} else {
		global $connection;
		$kasutajainfo = fetch_user_data($_SESSION['logged_in_user']);
		$query = "select * from poks_projekt_pildid where omaniku_id='".$kasutajainfo["id"]."';";
		$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connect));
		//loome tühja massiivi
		$pildid = array();
		// hangime tulemusest andmed
		//$puurid = mysqli_fetch_assoc($result) or die(mysql_error());
	
		while($pilt = mysqli_fetch_assoc($result)){
			$pildid[] = $pilt;
		}
		
		include_once('views/galerii.html');
	}
}

function add_picture(){
	if (!isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=login");
	} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$lisatudfail = upload_picture("pfile");
		$kasutajainfo = fetch_user_data($_SESSION['logged_in_user']);
		if (isset($_POST['pnimi'], $_FILES['pfile']) && $lisatudfail!="" && $_POST['pnimi']!="" && $_FILES['pfile']['name']!=""){
			global $connection;
			$pnimi=mysqli_real_escape_string($connection, $_POST['pnimi']);
			$pfail=mysqli_real_escape_string($connection, $lisatudfail);
			$pkomm=mysqli_real_escape_string($connection, $_POST['pkomm']);
			
			$query = "INSERT INTO poks_projekt_pildid (omaniku_id, pildinimi, pildifail, pildikomm) VALUES ('".$kasutajainfo["id"]."', '".$pnimi."', '".$pfail."', '".$pkomm."');";
			echo $query;
			$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
			if(mysqli_insert_id($connection) > 0 ){       
				header("Location: ?page=gallery");
        	}
		}
		include_once('views/lisapilt.html');
	} else {
		include_once('views/lisapilt.html');
	}
		
}

function change_picture(){
	if (!isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=login");
	} else {
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
			$pildiinfo = fetch_picture_data($_GET['id']);
			include_once('views/muudapilti.html');	
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
			global $connection;
			$pildiinfo = fetch_picture_data($_POST['id']);
			
			if ($_FILES["pfile"]["name"]==""){
				$lisatudfail = $pildiinfo['pildifail'];
			} else {
				$lisatudfail = upload_picture("pfile");
			}
			
			$pid=mysqli_real_escape_string($connection, $_POST['id']);
			$pnimi=mysqli_real_escape_string($connection, $_POST['pnimi']);
			$pfail=mysqli_real_escape_string($connection, $lisatudfail);
			$pkomm=mysqli_real_escape_string($connection, $_POST['pkomm']);
			
			$query = "UPDATE poks_projekt_pildid SET pildinimi='".$pnimi."', pildifail='".$pfail."', pildikomm='".$pkomm."' WHERE id='".$pid."';";			
			$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
			if(mysqli_affected_rows($connection) > 0 ){
				//Kui saime kasutaja loodud oleme ka sisse logitud ja lähme galeriisse.
				header("Location: ?page=gallery");
			}
			include_once('views/muudakasutajat.html');
		} else {
			header("Location: ?page=gallery");
		}

	}
}

function add_user(){
	
	if (isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=gallery");
	} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_POST['knimi'],$_POST['parool'],$_POST['enimi'],$_POST['pnimi'],$_POST['vanus'],$_POST['nousolek']) 
		&& $_POST['knimi']!="" && $_POST['parool']!="" && $_POST['enimi']!="" && $_POST['pnimi']!="" && $_POST['vanus']!="" && $_POST['nousolek']=="on" ){	
			global $connection;
			//kontrollime esimesena kasutajanime olemasolu
			$username = strtolower(mysqli_real_escape_string($connection, $_POST['knimi']));
			$query = "select * from poks_projekt_kasutajad where knimi='".$username."';";
			$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
			if(mysqli_num_rows($result) == 0 ) {
				//Kui sama nimelisi kasutajaid polnud lähme edasi.
				$parool = mysqli_real_escape_string($connection, $_POST['parool']);
				$enimi = mysqli_real_escape_string($connection, $_POST['enimi']);
				$pnimi = mysqli_real_escape_string($connection, $_POST['pnimi']);
				$vanus = mysqli_real_escape_string($connection, $_POST['vanus']);
				
				$query = "INSERT INTO `poks_projekt_kasutajad` (knimi, parool, enimi, pnimi, vanus, roll) VALUES('".$username."', SHA1('".$parool."'),'".$enimi."','".$pnimi."',".$vanus.",'user');";
				$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
				if(mysqli_insert_id($connection) > 0 ){
					//Kui saime kasutaja loodud oleme ka sisse logitud ja lähme galeriisse.
					$_SESSION['logged_in_user']=$username;
					$_SESSION['user_role'] = 'user';
					header("Location: ?page=gallery");
				}
				
			} else {
				echo "Selline kasutaja nagu ".$username." eksisteerib";
			}
		} else {
			echo "Kõik väljad peavad täidetud olema.";	
		}
	}
			
	include_once('views/lisakasutaja.html');	
}

function change_user(){
	if (!isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=login");
	} else {
		$kasutajainfo = fetch_user_data($_SESSION['logged_in_user']);
		if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['logged_in_user'])){
					include_once('views/muudakasutajat.html');	
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
				global $connection;
				
					//Kui sama nimelisi kasutajaid polnud lähme edasi.
					$username = mysqli_real_escape_string($connection, $_POST['knimi']);
					$parool = mysqli_real_escape_string($connection, $_POST['parool']);
					$enimi = mysqli_real_escape_string($connection, $_POST['enimi']);
					$pnimi = mysqli_real_escape_string($connection, $_POST['pnimi']);
					$vanus = mysqli_real_escape_string($connection, $_POST['vanus']);
					
					if (isset($_POST['parool'])){
						$query = "UPDATE poks_projekt_kasutajad SET knimi='".$username."',parool=SHA1('".$parool."'),enimi='".$enimi."', pnimi='".$pnimi."', vanus='".$vanus."' WHERE id='".$_POST['id']."';";
						
					} else {
						$query = "UPDATE poks_projekt_kasutajad SET knimi='".$username."',enimi='".$enimi."', pnimi='".$pnimi."', vanus='".$vanus."' WHERE id='".$_POST['id']."';";
					}
					$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
					if(mysqli_affected_rows($connection) > 0 ){
						//Kui saime kasutaja loodud oleme ka sisse logitud ja lähme galeriisse.
						header("Location: ?page=gallery");
					}
			include_once('views/muudakasutajat.html');
		}
	}
}

function tingimused(){
	include_once('views/tingimused.html');
}

function upload_picture($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$parts = explode(".", $_FILES[$name]["name"]);
	$extension = end($parts);
	
	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pictures/".$_SESSION['logged_in_user']."_".$_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pictures/".$_SESSION['logged_in_user']."_".$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pictures/".$_SESSION['logged_in_user']."_".$_FILES[$name]["name"]);
				return "pictures/".$_SESSION['logged_in_user']."_".$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>