<?php

//  ../controllers/bajapedido.php

require '../fw/fw.php';
require '../models/Pedidos.php';
require '../fw/BanderaSesion.php';
require '../models/Carrito.php';

if(count($_POST)>0){
	if(!isset($_POST['id_pedido'])) throw new ValidacionException("error falta carga id de pedido");
	
	$p = new Pedidos();
	$p->BajaPedido($_POST['id_pedido']);	

	echo "<script>
	alert('Baja del pedido realizada con éxito!');
	window.location.href='listadopedidos.php';
	</script>";
}

?>