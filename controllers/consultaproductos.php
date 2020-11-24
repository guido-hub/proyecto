<?php

// ../controllers/consultaproducto.php

	require '../fw/fw.php';
	require '../models/Productos.php';
	require '../fw/BanderaSesion.php';

	$id = $_POST['id'];
	$p = new Productos();


	$Producto = $p->getProducto($id);


	$jsonProducto = json_encode($Producto);

	echo $jsonProducto;

?>