<!-- ../html/FormLogin.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Ingreso al sistema</title>
	<link rel="stylesheet" type="text/css" href="../css-js-extra/FormLogin.css">
</head>
<body>

<div class="contenedor">
	<form action="../controllers/login.php" method="POST">
		<h1 class="login">Ingreso al sistema</h1>
		<label class="login">Correo: </label>
		<input class="login" type="text" name="correo"><br>
		<label class="login">Contraseña: </label>
		<input class="login" type="password" name="contrasenia">		
		<input class="dato" type="submit" name="ingreso">
		<a href="../controllers/altacliente.php" class="dato">Registrarse</a>
	</form>
</div>

</body>
</html>