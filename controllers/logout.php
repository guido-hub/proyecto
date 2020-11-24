<?php

//  ../controllers/logout.php

session_start();
unset($_SESSION['logueado']);
unset($_SESSION['persona']);
unset($_SESSION['dni']);
header("Location: ../controllers/login.php")

?>