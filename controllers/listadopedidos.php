<?php

//  ../controllers/listadopedidos.php

require '../fw/fw.php';
require '../views/FormListadoPedidos.php';
require '../models/Pedidos.php';
require '../models/Clientes.php';
require '../fw/BanderaSesion.php';

$p = new Pedidos();
$v = new FormListadoPedidos();

if(count($_POST)>0){
	if(!isset($_POST['id_pedido'])) throw new ValidacionException("error falta carga id pedido");
	if(!isset($_POST['pagado'])) throw new ValidacionException("error falta carga estado de pago");
	if(!isset($_POST['entregado'])) throw new ValidacionException("error falta carga estado de entrega");
	if(!isset($_POST['forma_de_pago'])) throw new ValidacionException("error falta carga forma de pago");

	$id_pedido = $_POST['id_pedido'];
	$pagado = $_POST['pagado'];
	$entregado = $_POST['entregado'];
	$forma_de_pago = $_POST['forma_de_pago'];
	
	$pe = new Pedidos();

	for ($i=0; $i < sizeof($id_pedido) ; $i++) {
	$pe->ActualizarEstadoPedido($id_pedido[$i], $pagado[$i], $entregado[$i], $forma_de_pago[$i]);
	}

	echo "<script>alert('Se han guardado los cambios con éxito!');</script>";
}

if($_SESSION['persona'] == "cliente"){
	$v->Pedidos = $p->getPedidosDeCliente($_SESSION['dni']);
}
if($_SESSION['persona'] == "usuario"){
	$v->Pedidos = $p->getTodos();	
}

$v->render();

?>