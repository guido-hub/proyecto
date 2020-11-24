<!-- ../html/FormConfirmacionPedido.php   -->

<!DOCTYPE html>
<html>
<head>
	<title>Carrito</title>
	<link rel="stylesheet" type="text/css" href="../css-js-extra/FormConfirmacionPedido.css">
</head>
<body>
<div class="contenedor">
<header>
<?php if($this->compra == false) { ?>	
	<h1>Carrito</h1>
<?php } ?>
<?php if($this->compra == true) { ?>	
	<h1>Confirmación de compra</h1>
<?php } ?>
</header>
<div class="cuerpo">	

<?php if($this->compra == false) { $total = 0; ?>
<table>
	<thead>	
		<tr>		
		<th campo='Detalle'>Nombre</th>
		<th campo='Nombre'>Categoría</th>
		<th campo='Nombre'>Marca</th>
		<th campo='Descripcion'>Descripción</th>
		<th campo='Numero'>Precio venta</th>
		<th campo='Imagen'>Imagen</th>				
		<th campo='Numero'>Cantidad solicidata</th>
		<th campo='Numero'>Subtotal</th>						
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($this->productos as $p) { ?>
		<tr>
			<td campo='Detalle'> <?= $p["nombre_producto"] ?></td>
			<td campo='Nombre'> <?= $p["categoria"] ?></td>
			<td campo='Nombre'> <?= $p["marca"] ?></td>
			<td campo='Descripcion'><?= $p["descripcion"] ?></td>		
			<td campo='Numero'> $ <?= $p["precio_venta"] ?>
			</td>
			<td campo='Imagen'> <?= '<img src="'.$p['imagen'].'">' ?></td>
			<td campo='Numero'> <?= $p['cantidad_pedida'] ?></td>
			<td campo='Numero'> $
			<?= $p["costo_unitario"]*(1+$p["porcentaje_ganancia"]/100)*$p['cantidad_pedida'] ?>
			</td>
		</tr>
		<?php $total = $total + ($p["costo_unitario"]*(1+$p["porcentaje_ganancia"]/100)*$p['cantidad_pedida']); } ?>
	</tbody>
</table>
<?php } ?>

<?php if($this->compra == true) { $total = 0; ?>
<form action="../controllers/nuevopedido.php" method="POST" class="cliente">
<table>
	<thead>	
		<tr>		
		<th campo='Detalle'>Nombre</th>
		<th campo='Nombre'>Categoría</th>
		<th campo='Nombre'>Marca</th>
		<th campo='Descripcion'>Descripción</th>
		<th campo='Numero'>Precio venta</th>
		<th campo='Imagen'>Imagen</th>				
		<th campo='Numero'>Cantidad solicidata</th>						
		<th campo='Numero'>Subtotal</th>		
		</tr> 
	</thead>
	
	<tbody>
		<?php foreach($this->productos as $p) { ?>
		<tr>
			<td campo='Detalle'><?= $p["nombre_producto"] ?></td>
			<td campo='Nombre'><?= $p["categoria"] ?></td>
			<td campo='Nombre'><?= $p["marca"] ?></td>
			<td campo='Descripcion'><?= $p["descripcion"] ?></td>		
			<td campo='Numero'> $ 
			<?= $p["costo_unitario"]*(1+$p["porcentaje_ganancia"]/100)?>
			</td>
			<td campo='Imagen'><?= '<img src="'.$p['imagen'].'">' ?></td>	
			<td campo='Numero'><?= $p["cantidad_pedida"] ?></td>
			<td campo='Numero'>$<?= $p["costo_unitario"]*(1+$p["porcentaje_ganancia"]/100)*$p["cantidad_pedida"] ?></td>
			<input type='hidden' name='array' value="<?php echo htmlentities(serialize($this->productos)); ?>" />
		</tr> 
		<?php $total = $total + ($p["costo_unitario"]*(1+$p["porcentaje_ganancia"]/100)*$p["cantidad_pedida"]); } ?>
	</tbody>
</table>
	<div class="interno">
	<select name="numero_tarjeta">
		<option disabled="disabled" selected="true">Seleccione Tarjeta</option>
		<?php foreach($this->tarjetas as $t) { ?>
			<option><?= $t['numero_tarjeta']?></option>
		<?php } ?>
	</select>
	<select name="forma_de_pago">
		<option disabled="disabled" selected="true">Seleccione forma de pago</option>
		<option>Contado</option>
		<option>Tarjeta de crédito</option>		
	</select>
	<input class="boton" type="submit" value="Confirmar compra">
	</div>
</form>
<?php } ?>
</div>
<footer>
	<label class="apartado">Total: $ <?=$total?></label>
	<br/><br>
	<a href="../controllers/listadoproductos.php" type="button">Volver</a>
</footer>

</div>
</body>
</html>