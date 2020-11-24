<!-- ../html/FormAltaArticulo.php   -->

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Alta Cliente</title>
	<style>
		html{
			background-color: aquamarine;
		}
		div.bloque{
			position: relative;
			left: 5%;	
			display: block;
			float: left;
			width: 45%;
			height: 370px;			

		}	
		div.footer{			
			padding-left: 5%;			
			display: block;
			width: 500px;
		}
		h1, h2{
			justify-content: center;
			text-align: center;
			margin: auto;
		}	
		label{
			display: inline-block;
  			width: 150px;
		}
	</style>
</head>
	<body>
		<h1>Alta de nuevo Cliente</h1>
		<br/><br/>

		<form action="../controllers/altacliente.php" method="POST">
			<div class="bloque">
			<label for="nombre">Nombre: </label>
			<input type="text" name="nombre" id="nombre" required="required" title="Completa este campo">
			<br/><br/>

			<label for="apellido">Apellido: </label>
			<input type="text" name="apellido" id="apellido" required="required" title="Completa este campo">
			<br/><br/>

			<label for="dni_cliente">N° Documento: </label>
			<input type="text" name="dni_cliente" id="dni_cliente" required="required" title="Completa este campo">
			<br/><br/>

			<label for="correo">Dirección de correo: </label>
			<input type="email" name="correo" id="correo" required="required" title="Completa este campo" placeholder="texto@texto">
			<br/><br/>

			<label for="contrasenia">Contraseña: </label>
			<input type="password" name="contrasenia" id="contrasenia" required="required" title="Completa este campo">
			<br/><br/>

			<label for="telefono">Teléfono: </label>
			<input type="text" name="telefono" id="telefono" pattern="[([5][4][1][1][0-9]{8}" placeholder="5411xxxxxxxx" required="required" title="5411xxxxxxxx">
			<br/><br/>

			<label for="calle">Calle: </label>
			<input type="text" name="calle" id="calle" required="required" title="Completa este campo">
			<br/><br/>

			<label for="numeroCalle">Número de calle: </label>
			<input type="number" name="numeroCalle" id="numeroCalle" required="required" title="Completa este campo">
			<br/><br/>

			<label for="datos_adicionales">Datos Adicionales: </label>
			<input type="text" name="datos_adicionales" id="datos_adicionales" title="Completa este campo">
			<br/><br/>	
			</div>
			
			<div class="bloque">
			<h2>Datos Tarjeta: </h2>
			<br><br>

			<label for="nombre_tarjeta">Entidad emisora: </label>
			<input type="text" name="nombre_tarjeta" id="nombre_tarjeta" required="required" readonly="readonly">
			<select id="idSelectEntidad">
				<option disabled="disabled" selected="true">Seleccione entidad</option>
				<option>VISA</option>
				<option>MasterCard</option>
				<option>AmEx</option>
				<option>Maestro</option>					
			</select>
			<br/><br/>

			<label for="numero_tarjeta">Número: </label>
			<input type="text" name="numero_tarjeta" id="numero_tarjeta" required="required" title="Completa los 16 dígitos" pattern="[0-9]{16}">
			<br/><br/>

			<label for="clave_tarjeta">Clave: </label>
			<input type="text" name="clave_tarjeta" id="clave_tarjeta" required="required" title="Completa los 3 dígitos" pattern="[0-9]{3}">
			<br/><br/>

			<label for="vencimiento_tarjeta">Vencimiento: </label>
			<input type="text" name="vencimiento_tarjeta" id="vencimiento_tarjeta" pattern="[0-9]{2}[/][0-9]{4}" required="required" placeholder="mm/aaaa">
			<br/><br/>
			</div>

			<div class="footer">
			<br/><br/>
			<input type="submit" name="enviar" value="Alta cliente">	
			</div>
			
		</form>
		<br/><br/>
		<div class="footer">
		<a href="../controllers/login.php" type="button">Volver</a>	
		</div>
		
	</body>


	<script>
		
		var idSelEnt = document.getElementById("idSelectEntidad");
		var idInpEnt = document.getElementById("nombre_tarjeta");
		var Clave = document.getElementById("clave_tarjeta");
		var Numero = document.getElementById("numero_tarjeta");

		var idClave = document.getElementById("clave_tarjeta");
		idSelEnt.onchange=function(){
			idInpEnt.value = idSelEnt.value;
			if (idSelEnt.value == "AmEx"){		
				Clave.pattern = '[0-9]{4}';
				Clave.title = 'Completa los 4 dígitos';
				Numero.pattern = '[0-9]{15}';
				Numero.title = 'Completa los 15 dígitos';
			}
			else{		
				Clave.pattern = '[0-9]{3}';
				Clave.title = 'Completa los 3 dígitos';
				Numero.pattern = '[0-9]{16}';
				Numero.title = 'Completa los 16 dígitos';
			}
		}
	</script>
</html>