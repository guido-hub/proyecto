// ../css-js-extra/script/ModificacionProductos.js

$(document).ready(function(){	
	$("#inpProducto").change(function(){

		cargaInputs();

	}); 	

});


function cargaInputs() {
	var objAjax = $.ajax({
		type:"POST",
		url:"../controllers/consultaproductos.php",
		data:{id: $("#inpProducto").val()},
		success:function(respuestaDelServer, estado){
			objJson = JSON.parse(respuestaDelServer);

			$("#inpCategoria").val(objJson.categoria);
			$("#inpMarca").val(objJson.marca);
			$("#inpDescripcion").val(objJson.descripcion);
			$("#inpCantidad").val(objJson.cantidad_stock);
			$("#inpPrecio").val(objJson.costo_unitario);
			$("#inpGanancia").val(objJson.porcentaje_ganancia);
			$("#id_producto").val(objJson.id_producto);
				
		}
	});
};