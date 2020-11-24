<!-- ../html/FormAltaArticulo.php   -->

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Alta artículo</title>
	<link rel="stylesheet" type="text/css" href="../css-js-extra/FormAltaArticulo.css">
</head>
	<body>
		<h1>Alta de nuevo artículo</h1>
		<br/><br/>
		
		<form action="../controllers/altaproducto.php" method="POST" enctype="multipart/form-data">
			<div class="bloque">
			<label for="nombre_producto">Nombre de Producto: </label>
			<input type="text" name="nombre_producto" id="nombre_producto">
			<br/><br/>

			<label for="categoria">Categoría: </label>
			<input type="text" name="categoria" id="idInputCategoria">
			<select id="idSelectCategoria">
				<option disabled="disabled" selected="true">Seleccione categoría</option>
				<?php foreach($this->categorias as $c) { ?>
					<option><?= $c['categoria']?></option>
				<?php } ?>
			</select>
			<br/><br/>

			<label for="marca">Marca: </label>
			<input type="text" name="marca" id="idInputMarca">
			<select id="idSelectMarca">
				<option disabled="disabled" selected="true">Seleccione marca</option>
				<?php foreach($this->marcas as $m) { ?>
					<option><?= $m['marca']?></option>
				<?php } ?>
			</select>
			<br/><br/>

			<label for="descripcion">Descripción: </label>
			<input type="text" name="descripcion" id="descripcion">
			<br/><br/>

			<label for="cantidad_stock">Cantidad: </label>
			<input type="number" name="cantidad_stock" id="cantidad_stock">
			<br/><br/>

			<label for="costo_unitario">Precio Unitario: $ </label>
			<input type="number" name="costo_unitario" id="costo_unitario">
			<br/><br/>

			<label for="costo_unitario">Porcentaje de Ganancia: % </label>
			<input type="number" name="porcentaje_ganancia" id="porcentaje_ganancia">
			<br/><br/>
			</div>

			<div class="bloque">
			<div class="contenedor" id="idContenedor"></div>
			<input type="file" name="imagen" id="idInputImagen" accept="image/*">
			<br/><br/>

			</div>
			<div class="footer">
			<input type="submit" name="enviar">
			</div>
		</form>		
		
		<div class="footer">
		<br/><br/>
		<a href="../controllers/listadoproductos.php" type="button">Volver</a>	
		</div>
		
	</body>

	<script>
		
	var idSelCat = document.getElementById("idSelectCategoria");
	var idInpCat = document.getElementById("idInputCategoria");

	idSelCat.onchange=function(){
		idInpCat.value = idSelCat.value;
	}

	var idSelMar = document.getElementById("idSelectMarca");
	var idInpMar = document.getElementById("idInputMarca");

	idSelMar.onchange=function(){
		idInpMar.value = idSelMar.value;
	}

	var idInpImg = document.getElementById("idInputImagen");
	var idCon = document.getElementById("idContenedor");

	idInpImg.onchange = function(){
		while( idCon.childNodes.length > 0 ){
			idCon.removeChild(idCon.childNodes[0]);
		}

		if(idInpImg.files.length > 0){
			var image = document.createElement('img');
			image.src = URL.createObjectURL(idInpImg.files[0]);			

			idCon.appendChild(image);	
		}		
	}

	</script>
</html>