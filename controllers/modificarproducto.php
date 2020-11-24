<?php

// ../controllers/modificarproducto.php

require '../fw/fw.php';
require '../models/Productos.php';
require '../views/ModificacionProducto.php';
require '../fw/BanderaSesion.php';

$p = new Productos();

if(count($_POST) > 0){

	if(!isset($_POST['id_producto'])) throw new ValidacionException("error falta carga el id del producto");
	if(!isset($_POST['nombre_producto'])) throw new ValidacionException("error falta carga en nombre del producto");
	if(!isset($_POST['marca'])) throw new ValidacionException("error falta carga en marca");
	if(!isset($_POST['cantidad_stock'])) throw new ValidacionException("error falta carga en cantidad de stock");
	if(!isset($_POST['costo_unitario'])) throw new ValidacionException("error falta carga en costo unitario");
	if(!isset($_POST['porcentaje_ganancia'])) throw new ValidacionException("error falta carga en porcentaje de ganancia");

	$p->ActualizarProducto($_POST['id_producto'], $_POST['nombre_producto'], $_POST['categoria'], $_POST['marca'], $_POST['descripcion'], $_POST['cantidad_stock'], $_POST['costo_unitario'], $_POST['porcentaje_ganancia']);

		echo "<script>
			  alert('Producto modificado exitosamente!');
			  </script>";

}


$v = new ModificacionProducto();
$v->producto = $p->getTodos();
$v->marcas = $p->getMarcas();
$v->categorias = $p->getCategorias();
$v->render();


