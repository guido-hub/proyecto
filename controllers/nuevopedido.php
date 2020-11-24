<?php

//  ../controllers/nuevopedido.php

require '../fw/fw.php';
require '../models/Productos.php';
require '../models/Carrito.php';
require '../models/Pedidos.php';
require '../models/Clientes.php';
require '../models/Tarjetas.php';
require '../fw/BanderaSesion.php';
require '../views/FormConfirmacionPedido.php';


	$p = new Productos();
	
	if(count($_POST)>0){

	
	$pedido = unserialize($_POST['array']);
	

	if(!isset($_POST['forma_de_pago'])) throw new ValidacionException("error falta carga de forma de pago");

	$c = new Clientes();
	$cliente = $c->getCliente($_SESSION['dni']);
	$entrega = date('d-m-Y',strtotime('+ 2 days'));		
	$pagado = "Impago";
	$entregado = "Pendiente";
	$forma_de_pago = $_POST['forma_de_pago'];

	$pe = new Pedidos();
	$id_pedido = $pe->AltaPedido($cliente['dni_cliente'], date('d'), date('m'), date('Y'), subStr(date($entrega), 0, 2) , subStr(date($entrega), 3, 2) , subStr(date($entrega), 6, 4), $pagado, $entregado, $forma_de_pago, $_POST['numero_tarjeta']);

	$carrito = new Carrito();

	foreach($pedido as $ped)	{
		$carrito->AltaCarrito($id_pedido, $ped['id_producto'], $ped['cantidad_pedida'], $ped['costo_unitario'] * (1 + $ped['porcentaje_ganancia']/100) * $ped['cantidad_pedida'] );
		$p->VentaProducto($ped['id_producto'], $ped['cantidad_pedida']);
	}



	echo "<script>
			  alert('Pedido cargado exitosamente! \\nSerá redireccionado a la página principal');
			  </script>
			  <script>
			  window.location.href='listadoproductos.php';
			  </script>
			  ";		
	}

			 

	
	