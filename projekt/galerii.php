<?php
require_once('funksioonid.php');
session_start();
connect_db();

$page="pealeht";
if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}

include_once('views/header.html');

switch($page){
	case "login":
		login();
	break;
	case "logout":
		logout();
	break;
	case "add_p":
		add_picture();
	break;
	case "change_p":
		change_picture();
	break;
	case "add_u":
		add_user();
	break;
	case "change_u":
		change_user();
	break;
	case "gallery":
		display_gallery();
	break;
	case "tingimused":
		tingimused();
	break;
	default:
		include_once('views/pealeht.html');
	break;
}

include_once('views/footer.html');

?>