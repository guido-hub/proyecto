<?php

//  ../controllers/login.php

require '../fw/fw.php';
require '../views/FormLogin.php';
require '../models/Clientes.php';
require '../models/Usuarios.php';

session_start();

if(count($_POST)>0){
	$correo = $_POST['correo'];
	$contrasenia = $_POST['contrasenia'];
	if(!isset($correo)) throw new ValidacionException("error falta carga correo");
	if(!isset($contrasenia)) throw new ValidacionException("error falta carga contraseña");
	$u = new Usuarios();	
	$c = new Clientes();
	if($u->ExisteCorreoParaContrasenia($correo, $contrasenia)){
		$usuario = $u->getUsuarioDeCorreoMasContrasenia($correo, $contrasenia);
		$_SESSION['logueado'] 	= true;
		$_SESSION['persona'] 	= "usuario";
		$_SESSION['dni']		= $usuario['dni_usuario'];
		header("Location: ../controllers/listadoproductos.php");
		exit;
	}
	if($c->ExisteCorreoParaContrasenia($correo, $contrasenia)){
		$cliente = $c->getClienteDeCorreoMasContrasenia($correo, $contrasenia);
		$_SESSION['logueado'] 	= true;
		$_SESSION['persona'] 	= "cliente";
		$_SESSION['dni']		= $cliente['dni_cliente'];
		header("Location: ../controllers/listadoproductos.php");
		exit;
	}		
	echo "<script>
		  alert('No se pudo ingresar al sistema.');
		  </script>";
}

$v = new FormLogin();
$v->render();

?>