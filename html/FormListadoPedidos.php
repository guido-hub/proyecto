<!-- ../html/FormListadoPedidos.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Listado de pedidos</title>
	<link rel="stylesheet" type="text/css" href="../css-js-extra/FormListadoPedidos.css">
</head>
<body>
	<h1>Listado de pedidos</h1>
<div class="cuerpo">
<?php if($_SESSION['persona'] == "usuario") { $i = 0; ?>
<form action="../controllers/listadopedidos.php" method="POST" class="detalle">
<table>
	<thead>
		<tr>
		<th campo="ID">ID</th>		
		<th campo="Numero">DNI Cliente</th>			
		<th campo="Numero">Fecha pedido</th>			
		<th campo="Numero">Fecha entrega</th>			
		<th campo="Nombre">Pagado</th>			
		<th campo="Nombre">Entregado</th>			
		<th campo="Forma de Pago">Forma de pago</th>			
		<th campo="Tarjeta">Tarjeta usada</th>	
		<th campo="Nombre">Cambiar pago</th>	
		<th campo="Nombre">Cambiar entrega</th>	
		<th campo="Forma de Pago">Cambiar forma de pago</th>				
		<th campo="ID">Baja</th>	
		</tr>
	</thead>
	<tbody>
	<?php foreach($this->Pedidos as $p) { ?>	
		<tr>
		<td campo="ID" onclick="MostrarPedido(<?=$p['id_pedido']?>)"> 
			<?= $p['id_pedido'] ?> 
		</td> 
		<td campo="Numero"> <?= $p['dni_cliente'] ?> </td>			
		<td campo="Numero"> <?= substr($p['fecha_pedido'], 8, 2)."/".substr($p['fecha_pedido'], 5, 2)."/".substr($p['fecha_pedido'], 0, 4) ?> </td>
		<td campo="Numero"> <?= substr($p['fecha_entrega'], 8, 2)."/".substr($p['fecha_entrega'], 5, 2)."/".substr($p['fecha_entrega'], 0, 4) ?> </td>
		<td campo="Nombre"> <?= $p['pagado'] ?> </td>			
		<td campo="Nombre"> <?= $p['entregado'] ?> </td>			
		<td campo="Forma de Pago"> <?= $p['forma_de_pago'] ?> </td>			
		<td campo="Tarjeta"> <?= $p['tarjeta_usada'] ?> </td>		
		<input type="hidden" name="id_pedido[<?=$i?>]" value="<?= $p['id_pedido'] ?>">
		<td campo="Nombre"> <select name="pagado[<?=$i?>]">
			<?php if($p['pagado'] == "Pagado") { ?>
			<option selected="selected">Pagado</option>
			<option>Impago</option>
			<?php }
			else{ ?>
			<option>Pagado</option>
			<option selected="selected">Impago</option>
			<?php } ?>
		</select></td>	
		<td campo="Nombre"><select name="entregado[<?=$i?>]">
			<?php if($p['entregado'] == "Entregado") { ?>
			<option selected="selected">Entregado</option>
			<option>Pendiente</option>
			<?php }
			else{ ?>
			<option>Entregado</option>
			<option selected="selected">Pendiente</option>
			<?php } ?>
		</select></td>
		<td campo="Forma de Pago"><select name="forma_de_pago[<?=$i?>]">
			<?php if($p['forma_de_pago'] == "Contado") { ?>
			<option selected="selected">Contado</option>
			<option>Tarjeta de crédito</option>
			<?php }
			else{ ?>
			<option>Contado</option>
			<option selected="selected">Tarjeta de crédito</option>
			<?php } ?>							
		</select></td>
		<td campo="ID">
		<input type="button" id="idInpBaja" value="Baja" onclick="Baja(<?=$p['id_pedido']?>)">
		</td>	
		</tr>
	<?php $i++; } ?>		
	</tbody>
	<tfoot>	
		<input type="submit" value="Actualizar">	
	</tfoot>
</table>
</form>	
<?php } ?>

<?php if($_SESSION['persona'] == "cliente") { ?>
<table>
	<thead>
		<tr>
		<th campo="ID">ID</th>				
		<th campo="Fecha">Fecha pedido</th>			
		<th campo="Fecha">Fecha entrega</th>			
		<th campo="Detalle">Pagado</th>			
		<th campo="Detalle">Entregado</th>			
		<th campo="Detalle">Forma de pago</th>			
		<th campo="Tarjeta cliente">Tarjeta usada</th>					
		</tr>
	</thead>
	<tbody>
	<?php foreach($this->Pedidos as $p) { ?>	
		<tr>
		<td campo="ID" onclick="MostrarPedido(<?=$p['id_pedido']?>)"> 
			<?= $p['id_pedido'] ?> 
		</td> 	
		<td campo="Fecha"> <?= substr($p['fecha_pedido'], 8, 2)."/".substr($p['fecha_pedido'], 5, 2)."/".substr($p['fecha_pedido'], 0, 4) ?> </td>
		<td campo="Fecha"> <?= substr($p['fecha_entrega'], 8, 2)."/".substr($p['fecha_entrega'], 5, 2)."/".substr($p['fecha_entrega'], 0, 4) ?> </td>
		<td campo="Detalle"> <?= $p['pagado'] ?> </td>			
		<td campo="Detalle"> <?= $p['entregado'] ?> </td>			
		<td campo="Detalle"> <?= $p['forma_de_pago'] ?> </td>			
		<td campo="Tarjeta cliente"> <?= $p['tarjeta_usada'] ?> </td>		
		</tr>
	<?php } ?>		
	</tbody>
</table>
<?php } ?>
</div>

<footer>
<form action="../controllers/carritoanterior.php" method="POST" name="muestra">
<input type="hidden" name="id_pedido" id="idMostrar">
</form>	

<br/><br/>

<form action="../controllers/bajapedido.php" method="POST" name="bajada">
	<input type="hidden" id="idBaja" name="id_pedido">	
</form>	
<br/><br>
<a href="../controllers/listadoproductos.php" type="button">Volver</a>
</footer>

<script type="text/javascript">
	var bajas = document.getElementById("idBaja");
	var mostrado = document.getElementById("idMostrar");
	function Baja(id){
		bajas.value = id;
		if(confirm('Está seguro que desea dar de baja el pedido seleccionado?'))
			document.bajada.submit();
	}

	function MostrarPedido(id){
		mostrado.value = id;
		document.muestra.submit();
	}

</script>

</body>
</html>