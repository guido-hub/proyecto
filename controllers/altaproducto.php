<?php

// ../controllers/altaproducto.php

require '../fw/fw.php';
require '../models/Productos.php';
require '../views/FormAltaArticulo.php';
require '../fw/BanderaSesion.php';

$p = new Productos();


if(count($_POST) > 0){

	if(!isset($_POST['nombre_producto'])) throw new ValidacionException("error falta carga en nombre del producto");
	if(!isset($_POST['marca'])) throw new ValidacionException("error falta carga en marca");
	if(!isset($_POST['cantidad_stock'])) throw new ValidacionException("error falta carga en cantidad de stock");
	if(!isset($_POST['costo_unitario'])) throw new ValidacionException("error falta carga en costo unitario");
	if(!isset($_POST['porcentaje_ganancia'])) throw new ValidacionException("error falta carga en porcentaje de ganancia");

	$p->AltaProducto($_POST['nombre_producto'], $_POST['categoria'], $_POST['marca'], $_POST['descripcion'], $_POST['cantidad_stock'], $_POST['costo_unitario'], $_POST['porcentaje_ganancia'], $_FILES['imagen']);

		echo "<script>
			  alert('Producto dado de alta exitosamente!');
			  </script>";
}

$v = new FormAltaArticulo();
$v->marcas = $p->getMarcas();
$v->categorias = $p->getCategorias();
$v->render();


