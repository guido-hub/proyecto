<!-- ../html/ModificacionProducto.php   -->

<!DOCTYPE html>
<html>
<head>
	<title>Modificación de Producto</title>
	<script src="../css-js-extra/jquery.js"></script>
	<script src="../css-js-extra/scriptModificacionProductos.js"></script>

	<style>
		html{
			background-color: aquamarine;
		}
		html, body{			
			margin: 0;
			padding: 0;
			border: 0 none;
			box-sizing: border-box;
			height: 900px;
		}		
		div.bloque{		
			position: relative;
			left: 5%;	
			display: block;
			float: left;
			width: 45%;
			height: 300px;			
		}
		label, select{
			display: inline-block;
  			width: 180px;
		}		
		div.footer{			
			padding-left: 5%;			
			display: block;
			width: 500px;
		}
		input.descripcion{
			width: 353px;
		}
		div.contenedor{
			border: solid 1px black;
			border-radius: 15px;
			width: 330px;
			height: 230px;			
		}
		div.contenedor, img{
			border-radius: 25px;
			background-color: white;
		}
		img{			
			display: flex;			
			margin: auto;
			max-width: 330px;
			max-height: 230px;
			height: auto;
			width: auto;			
		}
		h1, h2{
			justify-content: center;
			text-align: center;
			margin: auto;
		}		
	</style>
</head>
	<body>
		
		<h1>Modificación de Producto</h1>
		<br/><br/>

		<div class="bloque">
		<label for="inpProducto">Nombre de Producto: </label>
		<select id="inpProducto">
			<option disabled="disabled" selected="true">Seleccione producto</option>
			<?php foreach($this->producto as $p) { ?>
				<option value="<?= $p['id_producto'] ?>"><?= $p['nombre_producto']?></option>
			<?php } ?>
		</select>
		<br/><br/>

		<label for="inpCategoria">Categoría: </label>
		<input id="inpCategoria" type="text" disabled="disabled" value="Categoría">
		<br/><br/>

		<label for="inpMarca">Marca: </label>
		<input id="inpMarca" type="text" disabled="disabled" value="Marca">
		<br/><br/>

		<label for="inpDescripcion">Descripción: </label>
		<input class="descripcion" id="inpDescripcion" type="text" disabled="disabled" value="Breve detalle">
		<br/><br/>

		<label for="inpCantidad">Cantidad: </label>
		<input id="inpCantidad" type="text" disabled="disabled" value="Stock">
		<br/><br/>

		<label for="inpPrecio">Precio Unitario: $ </label>
		<input id="inpPrecio" type="text" disabled="disabled" value="Costo unitario">
		<br/><br/>

		<label for="inpGanancia">Porcentaje de Ganancia: % </label>
		<input id="inpGanancia" type="text" disabled="disabled" value="Porcentaje de ganancia">
		<br/><br/>	
		</div>

		<div class="bloque">
			<label>Imagen existente:</label><br>
			<div class="contenedor">
				<img id="inpImagen">				
			</div>
		</div>

		<h2>Actualización</h2>
		<br><br>

		<form action="../controllers/modificarproducto.php" method="POST" enctype="multipart/form-data">
			<div class="bloque">			
			<label for="id_producto">Id de Producto: </label>
			<input type="text" name="id_producto" id="id_producto" readonly>
			<br/><br/>

			<label for="nombre_producto">Nombre de Producto: </label>
			<input type="text" name="nombre_producto" required="required">
			<br/><br/>

			<label for="categoria">Categoría: </label>
			<input type="text" name="categoria" id="idInputCategoria" >
			<select id="idSelectCategoria"> 
				<option disabled="disabled" selected="true">Seleccione categoría</option>
				<?php foreach($this->categorias as $c) { ?>
					<option><?= $c['categoria']?></option>
				<?php } ?>
			</select>
			<br/><br/>

			<label for="marca">Marca: </label>
			<input type="text" name="marca" id="idInputMarca" required="required">
			<select id="idSelectMarca">
				<option disabled="disabled" selected="true">Seleccione marca</option>
				<?php foreach($this->marcas as $m) { ?>
					<option><?= $m['marca']?></option>
				<?php } ?>
			</select>
			<br/><br/>

			<label for="descripcion">Descripción: </label>
			<input class="descripcion" type="text" name="descripcion">
			<br/><br/>

			<label for="cantidad_stock">Cantidad: </label>
			<input type="number" name="cantidad_stock" required="required">
			<br/><br/>

			<label for="costo_unitario">Precio Unitario: $ </label>
			<input type="number" name="costo_unitario" required="required">
			<br/><br/>

			<label for="porcentaje_ganancia">Porcentaje de Ganancia: % </label>
			<input type="number" name="porcentaje_ganancia" required="required">
			<br/><br/>
			
			</div>
			<div class="bloque">
			<label>Imagen a agregar:</label><br>
			<div class="contenedor" id="idContenedor"></div>
			<input type="file" name="imagen" id="idInputImagen" accept="image/*">
			</div>

			<div class="footer">
			<br/><br/>
			<input type="submit" value="Modificar">
			</div>

		</form>

		<div class="footer">
		<br/><br/>
		<form action="../controllers/bajaproducto.php" method="POST" name="baja">
			<input type="hidden" name="id_producto" id="idInpBaja">
			<input type="button" value="Baja producto" id="idSubmitBaja">
		</form>

		<br/><br/>
		<a href="../controllers/listadoproductos.php">Volver</a>	
		</div>		
		
	</body>


	<script>
	window.onload = function(){
		idBaja.type = "hidden";
	}
	
	var idSelPro = document.getElementById("inpProducto");
	
	idSelPro.onchange = function(){
		idBaja.type = "submit";
	}	

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

	var idBaja = document.getElementById("idSubmitBaja");

	idBaja.onclick = function(){
		if(confirm('Está seguro que desea dar de baja al producto seleccionado?'))
			document.baja.submit();
	}

	</script>

</html>