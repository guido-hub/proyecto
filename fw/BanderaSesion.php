<?php

//  ../fw/BanderaSesion.php

session_start();

if(!isset($_SESSION['logueado'])){
	header("Location: login.php");
	exit;
}

?>