<?php

// ../controllers/altacliente.php

require '../fw/fw.php';
require '../models/Clientes.php';
require '../models/Tarjetas.php';
require '../views/FormAltaCliente.php';

if(count($_POST) > 0){
	$c = new Clientes();
	$t = new Tarjetas();

	if(!isset($_POST['dni_cliente'])) throw new ValidacionException("error falta carga del dni");
	if(!isset($_POST['correo'])) throw new ValidacionException("error falta carga del correo");
	if(!isset($_POST['contrasenia'])) throw new ValidacionException("error falta carga de la contraseña");
	if(!isset($_POST['nombre'])) throw new ValidacionException("error falta carga del nombre");
	if(!isset($_POST['apellido'])) throw new ValidacionException("error falta carga del apellido");
	if(!isset($_POST['calle'])) throw new ValidacionException("error falta carga de la calle");
	if(!isset($_POST['numeroCalle'])) throw new ValidacionException("error falta carga del numero de la calle");

	if(!isset($_POST['nombre_tarjeta'])) throw new ValidacionException("error falta carga de la entidad emisora");
	if(!isset($_POST['numero_tarjeta'])) throw new ValidacionException("error falta carga del número de la tarjeta");
	if(!isset($_POST['clave_tarjeta'])) throw new ValidacionException("error falta carga de la clave de la tarjeta");
	if(!isset($_POST['vencimiento_tarjeta'])) throw new ValidacionException("error falta carga del vencimiento de la tarjeta");
	

	$c->AltaCliente($_POST['dni_cliente'], $_POST['correo'], $_POST['contrasenia'], $_POST['nombre'], $_POST['apellido'], $_POST['calle'], $_POST['numeroCalle'], $_POST['datos_adicionales'], $_POST['telefono']);

	$mes = substr($_POST['vencimiento_tarjeta'],0,2);
	$anio = substr($_POST['vencimiento_tarjeta'],3,4);

	$t->AltaTarjeta($_POST['dni_cliente'], $_POST['nombre_tarjeta'], $_POST['numero_tarjeta'], $_POST['clave_tarjeta'], $mes, $anio);

	echo "<script>
			alert('Cliente dado de alta exitosamente!');
		  </script>";
}

$v = new FormAltaCliente();

$v->render();