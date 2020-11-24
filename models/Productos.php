<?php

//  ../models/Productos.php

/*Lista de funciones
	public function ValidarId($id)					
	public function ValidarNombre($nombre)			->return string
	public function ValidarCategoria($categoria)	->return string
	public function ValidarMarca($marca)			->return string
	public function ValidarDescripcion($descripcion)->return string
	public function ValidarCantidad($cantidad)		
	public function ValidarCostoUnitario($costo)	
	public function ValidarPorcentajeGanancia($ganancia)
	public function ValidarImagen($imagen)			->return array()

	public function EsAplicablePrecioConCosto(
	$id_producto, $precio)							->return boolean
	public function ExisteNombre($nombre_producto)	->return boolean
	public function ExisteId($id)					->return boolean
	public function ExisteCantidadEnStock(
	$id_producto,$cantidad_stock)					->return boolean

	public function getTodos()						->return array()
	public function getCategorias()					->return array()
	public function getMarcas()						->return array()
	public function getProducto($id)				->return array()
	public function getProductoDeNombre($nombre)	->return array()
	public function GuardarImagen($id, $imagen)
	public function RedefinirRutaImagen($id, $imagen)
	public function EliminarImagen($id)

	public function AltaProducto($nombre_producto, 
	$categoria, $marca, $descripcion, 
	$cantidad_stock, $costo_unitario)

	public function ActualizarProducto($id_producto, 
	$nombre_producto, $categoria, $marca, 
	$descripcion, $cantidad_stock, $costo_unitario)

	public function BajaProducto($id_producto)
*/

class Productos extends Model{

	public function ValidarId($id){
		if(!ctype_digit($id)) throw new ValidacionException("error validar id producto");
		if($id<1) throw new ValidacionException("error validar id producto");
	}

	public function ValidarNombre($nombre){
		if(strlen($nombre)<1) throw new ValidacionException("error validar nombre producto");
		$nombre = $this->db->escape($nombre);
		$nombre = $this->db->escapeWildcards($nombre);

		return $nombre;
	}

	public function ValidarCategoria($categoria){
		if(strlen($categoria)<0) throw new ValidacionException("error validar categoria producto");
		$categoria = $this->db->escape($categoria);
		$categoria = $this->db->escapeWildcards($categoria);

		return $categoria;
	}

	public function ValidarMarca($marca){
		if(strlen($marca)<1) throw new ValidacionException("error validar marca producto");
		$marca = $this->db->escape($marca);
		$marca = $this->db->escapeWildcards($marca);

		return $marca;
	}

	public function ValidarDescripcion($descripcion){
		if(strlen($descripcion)<0) throw new ValidacionException("error validar descripcion producto");
		$descripcion = $this->db->escape($descripcion);
		$descripcion = $this->db->escapeWildcards($descripcion);

		return $descripcion;
	}

	public function ValidarCantidad($cantidad){
		if(!is_numeric($cantidad)) throw new ValidacionException("error validar cantidad producto");
		if($cantidad<0) throw new ValidacionException("error validar cantidad producto");
	}

	public function ValidarCostoUnitario($costo){
		if(!is_numeric($costo)) throw new ValidacionException("error validar costo producto");
		if($costo<0) throw new ValidacionException("error validar costo producto");
	}	

	public function ValidarPorcentajeGanancia($ganancia){
		if(!is_numeric($ganancia)) throw new ValidacionException("error validar porcentaje ganancia");
		if($ganancia<0) throw new ValidacionException("error validar porcentaje ganancia");		
	}

	public function ValidarImagen($imagen){				
		if($imagen['name'] != ''){
		$imagen['type'] = str_replace("image/", ".", $imagen['type']);		
		if($imagen['size'] > 2000000) throw new ValidacionException("error validar imagen");		
		if($imagen['type'] != '.jpeg' && $imagen['type'] != '.jpg' && $imagen['type'] != '.png') throw new ValidacionException("error validar imagen");
		}		
		return $imagen;
	}

	public function EsAplicablePrecioConCosto($id_producto, $precio){
		$this->ExisteId($id_producto);

		$this->db->query("SELECT *
						  FROM productos
						  WHERE id_producto = $id_producto
						  ");
		$fila = $this->db->fetch();
		if($precio<$fila['costo_unitario']) return false;

		return true;
	}

	public function ExisteNombre($nombre_producto){
		$nombre_producto = $this->ValidarNombre($nombre_producto);
		$this->db->query("SELECT *
						  FROM productos
						  WHERE nombre_producto = '$nombre_producto'
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExisteId($id){
		$this->ValidarId($id);
		$this->db->query("SELECT *
						  FROM productos
						  WHERE id_producto = $id
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExisteCantidadEnStock($id_producto,$cantidad_stock){
		$this->ValidarId($id_producto);
		$this->ValidarCantidad($cantidad_stock);

		$this->db->query("SELECT *
						  FROM productos
						  WHERE id_producto = $id_producto
						  ");
		$fila = $this->db->fetch();
		if($cantidad_stock>$fila['cantidad_stock']) return false;

		return true;
	}

	public function getTodos(){
		$this->db->query("SELECT * 
						  FROM productos
						  ");
		return $this->db->fetchAll();
	}

	public function getCategorias(){
		$this->db->query("SELECT DISTINCT categoria 
						  FROM productos
						  ");
		return $this->db->fetchAll();
	}

	public function getMarcas(){
		$this->db->query("SELECT DISTINCT marca 
						  FROM productos
						  ");
		return $this->db->fetchAll();
	}

	public function getProducto($id){
		$this->ValidarId($id);
		$this->db->query("SELECT * 
						  FROM productos 
						  WHERE id_producto = $id
						  ");
		return $this->db->fetch();
	}

	public function getCantidad($id){
		$this->ValidarId($id);
		$this->db->query("SELECT cantidad_stock 
						  FROM productos 
						  WHERE id_producto = $id
						  ");
		$fila = $this->db->fetch();
		return $fila['cantidad_stock'];
	}


	public function getProductoDeNombre($nombre){
		$nombre = $this->ValidarNombre($nombre);
		$this->db->query("SELECT * 
						  FROM productos 
						  WHERE nombre_producto = '$nombre'
						  ");
		return $this->db->fetch();
	}

	public function GuardarImagen($id, $imagen){
		$this->ValidarId($id);
		$this->ValidarImagen($imagen);
		if($imagen['name'] != ''){
			$tipo = $imagen['type'];		
			$ruta_destino = '../imagenes/imagen'.$id.$tipo;
			move_uploaded_file($imagen['tmp_name'], $ruta_destino);		
		}		
	}	

	public function RedefinirRutaImagen($id, $imagen){
		if($imagen['name'] != ''){
			$tipo = $imagen['type'];		
			$this->db->query("UPDATE productos
							  SET imagen = '../imagenes/imagen$id$tipo'
							  WHERE id_producto = $id");	
		}
		else{
			$this->db->query("UPDATE productos
							  SET imagen = '../imagenes/sin-imagen.jpeg'
							  WHERE id_producto = $id");		
		}
	}

	public function EliminarImagen($id){
		$this->ValidarId($id);
		$fila = $this->getProducto($id);					
		$ruta_imagen = $fila['imagen'];
		if(substr($ruta_imagen, -15, 15) != 'sin-imagen.jpeg') unlink($ruta_imagen);
	}

	public function AltaProducto($nombre_producto, $categoria, $marca, $descripcion, $cantidad_stock, $costo_unitario, $porcentaje_ganancia, $imagen){
		if(!$this->ExisteNombre($nombre_producto)){
			$nombre_producto = $this->ValidarNombre($nombre_producto);
			$categoria = $this->ValidarCategoria($categoria);
			$marca = $this->ValidarMarca($marca);
			$descripcion = $this->ValidarDescripcion($descripcion);
			$this->ValidarCantidad($cantidad_stock);
			$this->ValidarCostoUnitario($costo_unitario);
			$this->ValidarPorcentajeGanancia($porcentaje_ganancia);
			$imagen = $this->ValidarImagen($imagen);				

			$this->db->query("INSERT INTO productos
							  (nombre_producto, categoria, marca, descripcion, cantidad_stock, costo_unitario, porcentaje_ganancia)
							  VALUES
							  ('$nombre_producto', '$categoria', '$marca', '$descripcion', $cantidad_stock, $costo_unitario, $porcentaje_ganancia)"
							);			
			$fila = $this->getProductoDeNombre($nombre_producto);
			$this->GuardarImagen($fila['id_producto'], $imagen);
			$this->RedefinirRutaImagen($fila['id_producto'], $imagen);
		}
		else{throw new ValidacionException("error existencia producto");}
	}

	public function ActualizarProducto($id_producto, $nombre_producto, $categoria, $marca, $descripcion, $cantidad_stock, $costo_unitario, $porcentaje_ganancia, $imagen){
		if($this->ExisteId($id_producto)){
			$this->ValidarId($id_producto);
			$nombre_producto = $this->ValidarNombre($nombre_producto);
			$categoria = $this->ValidarCategoria($categoria);
			$marca = $this->ValidarMarca($marca);
			$descripcion = $this->ValidarDescripcion($descripcion);
			$this->ValidarCantidad($cantidad_stock);
			$this->ValidarCostoUnitario($costo_unitario);
			$this->ValidarPorcentajeGanancia($porcentaje_ganancia);
			$this->EliminarImagen($id_producto);
			$imagen = $this->ValidarImagen($imagen);

			$this->db->query("UPDATE productos
							  SET nombre_producto = '$nombre_producto',
							  categoria = '$categoria', 
							  marca = '$marca', 
							  descripcion = '$descripcion', 
							  cantidad_stock = $cantidad_stock, 
							  costo_unitario = $costo_unitario,
							  porcentaje_ganancia = $porcentaje_ganancia
							  WHERE id_producto = $id_producto
							  LIMIT 1
							  ");
			$this->EliminarImagen($id_producto);
			$this->GuardarImagen($id_producto, $imagen);
			$this->RedefinirRutaImagen($id_producto, $imagen);			
		}
		else{throw new ValidacionException("error existencia producto");}
	}	

	public function BajaProducto($id_producto){
		if($this->ExisteId($id_producto)){
			$this->ValidarId($id_producto);			
			$this->EliminarImagen($id_producto);
			$this->db->query("DELETE
							  FROM productos
							  WHERE id_producto = $id_producto
							  LIMIT 1
							  ");
		}
		else{throw new ValidacionException("error existencia producto");}
	}


	public function VentaProducto($id_producto, $cantidad_vendida){
		if($this->ExisteId($id_producto)){
			$this->ValidarId($id_producto);			
			if($this->ExisteCantidadEnStock($id_producto, $cantidad_vendida)){
				$nuevo_stock = $this->getCantidad($id_producto) - $cantidad_vendida;
				$this->db->query("UPDATE productos
								  SET  
								  cantidad_stock = $nuevo_stock
								  WHERE id_producto = $id_producto
								  LIMIT 1
								  ");
			}
			else{throw new ValidacionException("error existencia cantidad en stock");
			}
		}
		else{throw new ValidacionException("error existencia producto");}
	}
}

?>