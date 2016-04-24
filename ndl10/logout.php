<?php   
session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
header("location:/~poks/i244-prax/ndl10/kontroller.php"); //to redirect back to "index.php" after logging out
exit();
?>