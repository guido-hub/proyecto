<?php

//  ../controllers/confirmacionpedido.php

require '../fw/fw.php';
require '../views/FormConfirmacionPedido.php';
require '../models/Productos.php';
require '../models/Tarjetas.php';
require '../models/Clientes.php';
require '../fw/BanderaSesion.php';


	$p = new Productos();
	$v = new FormConfirmacionPedido();
	$t = new Tarjetas();
	$c = new Clientes();

	$flag = true;

	$productos = [];				
	foreach($_POST as $key=>$value)					
	{
		if ($value != 0){
			$producto = $p->getProducto("$key");
			$producto['cantidad_pedida'] = $value;
			array_push($productos, $producto);
			$flag = false;
		}
	}

	if ($flag) {
		echo "<script>
			  alert('No hubo cargas en el carrito.');
			  </script>";
		header("Location: listadoproductos.php");
		exit;
	}

	$cliente = $c->getCliente($_SESSION['dni']);
	$dni = $cliente['dni_cliente'];

	$v->productos = $productos;
	$v->tarjetas = $t->getTarjetasPorDni($dni);
	$v->compra = true;
	$v->render();

	