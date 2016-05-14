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
	} else {
		include_once('views/login.html');
	}
		
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}


function display_gallery(){
	
	if (!isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=login");
	} else {
		// siia on vaja funktsionaalsust
		global $connection;
		include_once('views/galerii.html');
	}
}

function add_picture(){
	if (!isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=login");
	} else {
		// siia on vaja funktsionaalsust
		global $connection;
		include_once('views/lisapilt.html');
	}
		
}

function change_picture(){
	if (!isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=login");
	} else {
		// siia on vaja funktsionaalsust
		global $connection;

		include_once('views/muudapilti.html');
	}
}

function add_user(){
		include_once('views/lisakasutaja.html');
		
}

function change_user(){
	if (!isset($_SESSION['logged_in_user'])){
    	header("Location: ?page=login");
	} else {
		// siia on vaja funktsionaalsust
		global $connection;

		include_once('views/muudakasutajat.html');
	}
}

function tingimused(){
	include_once('views/tingimused.html');
}

function upload_picture($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	//$extension = end(explode(".", $_FILES[$name]["name"]));
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