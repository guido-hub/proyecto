<?php

//  ../controllers/carritoanterior.php

require '../fw/fw.php';
require '../views/FormConfirmacionPedido.php';
require '../models/Carrito.php';
require '../models/Productos.php';
require '../models/Clientes.php';
require '../models/Pedidos.php';
require '../fw/BanderaSesion.php';

$v = new FormConfirmacionPedido();

if(count($_POST)>0){
	if(!isset($_POST['id_pedido'])) throw new ValidacionException("falta carga de número de pedido");

	$c = new Carrito();
	$v->productos = $c->getCarritoConProductos($_POST['id_pedido']);
	$v->compra = false;
	$v->tarjetas = 'NULL';
}

$v->render();

?>