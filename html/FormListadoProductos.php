<!-- ../html/FormListadoProductos.php   -->

<!DOCTYPE html>
<html>
<head>
	<title>Página Principal</title>
	<link rel="stylesheet" type="text/css" href="../css-js-extra/FormListadoProductos.css">
</head>
<body>
<div class="contenedor">
<header>
	<h1>Listado de productos y stock</h1>
</header>
<div class="cuerpo">
	

<?php if($_SESSION['persona'] == "usuario") { ?>
<table>
	<thead>	
		<tr>			
		<th campo='Nombre'>Nombre</th>
		<th campo='Nombre'>Categoría</th>
		<th campo='Nombre'>Marca</th>
		<th campo='Descripcion'>Descripción</th>				
		<th campo='Numero'>Stock</th>
		<th campo='Numero'>Costo Unitario</th>
		<th campo='Numero'>Porcentaje Ganancia</th>		
		<th campo='Numero'>Precio venta</th>
		<th campo='Imagen'>Imagen</th>		
		</tr> 
	</thead>
	
	<tbody>
		<?php foreach($this->productos as $p) { ?>
		<tr>			
			<td campo='Nombre'><?= $p["nombre_producto"] ?></td>
			<td campo='Nombre'><?= $p["categoria"] ?></td>
			<td campo='Nombre'><?= $p["marca"] ?></td>
			<td campo='Descripcion'><?= $p["descripcion"] ?></td>
			<td campo='Numero'><?= $p["cantidad_stock"] ?></td>
			<td campo='Numero'>$ <?= $p["costo_unitario"] ?></td>
			<td campo='Numero'><?= $p["porcentaje_ganancia"] ?> %</td>
			<td campo='Numero'> $ 
				<?= $p["costo_unitario"]*(1+$p["porcentaje_ganancia"]/100) ?>
			</td>
			<td campo='Imagen'><?= '<img src="'.$p['imagen'].'">' ?></td>	
		</tr> 
		<?php } ?>
	</tbody>	
</table>
<?php } ?>

<?php if($_SESSION['persona'] == "cliente") { ?>
<form action="../controllers/confirmacionpedido.php" method="POST">
<table>
	<thead>	
		<tr>		
		<th campo='Detalle'>Nombre</th>
		<th campo='Nombre'>Categoría</th>
		<th campo='Nombre'>Marca</th>
		<th campo='Descripcion'>Descripción</th>
		<th campo='Numero'>Stock</th>
		<th campo='Numero'>Precio venta</th>
		<th campo='Imagen'>Imagen</th>				
		<th campo='Pedido'>Cantidad solicidata</th>						
		</tr> 
	</thead>
	
	<tbody>
		<?php foreach($this->productos as $p) { ?>
		<tr>
			<td campo='Detalle'><?= $p["nombre_producto"] ?></td>
			<td campo='Nombre'><?= $p["categoria"] ?></td>
			<td campo='Nombre'><?= $p["marca"] ?></td>
			<td campo='Descripcion'><?= $p["descripcion"] ?></td>	
			<td campo='Numero'><?= $p["cantidad_stock"] ?></td>	
			<td campo='Numero'>$ 
				<?= $p["costo_unitario"]*(1+$p["porcentaje_ganancia"]/100) ?>
			</td>
			<td campo='Imagen'><?= '<img src="'.$p['imagen'].'">' ?></td>	
			<td campo='Pedido'>
			<input campo="pedido" type="number" min="0" name="<?=$p['id_producto']?>">
			</td>
		</tr> 
		<?php } ?>		
	</tbody>
	
</table>	

<?php } ?>
</div>

<footer>
	<?php if($_SESSION['persona'] == "cliente") { ?>
	<input class="boton" type="submit" value="Revisar carrito">	
	</form>
	<?php } ?>
	<?php if($_SESSION['persona'] == "usuario") { ?>	
	<a class="boton" href="../controllers/modificarproducto.php">Modificar producto</a>	
	<a class="boton" href="../controllers/altaproducto.php">Alta de producto</a>
	<?php } ?>
	<a class="boton" href="../controllers/listadopedidos.php">Revisar pedidos</a>
	<a class="boton" href="../controllers/logout.php">Cerrar sesión</a>
</footer>

</div>
</body>
</html>