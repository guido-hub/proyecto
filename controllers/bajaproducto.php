<?php

//  ../controllers/bajaproducto.php

require '../fw/fw.php';
require '../fw/BanderaSesion.php';
require '../models/Productos.php';

if(count($_POST)>0){
	if(!isset($_POST['id_producto'])) throw new ValidacionException("error falta carga id producto");
	
	$p = new Productos();

	$p->BajaProducto($_POST['id_producto']);

	echo "<script>
	alert('El producto se ha dado de baja exitosamente!');
	window.location.href='listadoproductos.php';
	</script>";
}

?>