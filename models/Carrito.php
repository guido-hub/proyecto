<?php

// ../models/Carrito.php

/*Lista de funciones
	public function ValidarCantidadPedida($cantidad)
	public function ValidarPrecioVenta($id_producto, $precio)

	public function ExisteCarrito($id_pedido, 
	$id_producto)										->return boolean

	public function getTodos()							->return array()
	public function getCarrito($id_pedido, 
	$id_producto)										->return array()	

	public function AltaCarrito($id_pedido, 
	$id_producto, $cantidad_pedida, $precio_venta)

	public function ActualizarCarrito($id_pedido, 
	$id_producto, $cantidad_pedida, $precio_venta)

	public function BajaCarrito($id_pedido, $id_producto)
*/

class Carrito extends Model{

	public function ValidarCantidadPedida($cantidad){
		if(!is_numeric($cantidad)) throw new ValidacionException("error validar cantidad carrito");
		if($cantidad<1) throw new ValidacionException("error validar cantidad carrito");		
	}

	public function ValidarPrecioVenta($id_producto, $precio){
		if(!is_numeric($precio)) throw new ValidacionException("error validar precio venta");
		$p = new Productos();		
		if(!$p->EsAplicablePrecioConCosto($id_producto, $precio)) throw new ValidacionException("error validar precio venta");
	}

	public function ExisteCarrito($id_pedido, $id_producto){
		$pe = new Pedidos();
		$p = new Productos();
		$pe->ExisteId($id_pedido);
		$p->ExisteId($id_producto);

		$this->db->query("SELECT *
						  FROM carrito
						  WHERE id_pedido 	= $id_pedido
						  AND 	id_producto = $id_producto");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function getTodos(){
		$this->db->query("SELECT * 
						  FROM carrito
						  ");
		return $this->db->fetchAll();
	}

	public function getCarrito($id_pedido){
		$pe = new Pedidos();		
		$pe->ExisteId($id_pedido);		
		$this->db->query("SELECT *
						  FROM carrito
						  WHERE id_pedido 	= $id_pedido");
		return $this->db->fetchAll();
	}

	public function getCarritoConProductos($id_pedido){
		$pe = new Pedidos();
		if($_SESSION['persona'] == "cliente"){
			if(!$pe->ExistePedidoParaCliente($id_pedido, $_SESSION['dni'])) throw new ValidacionException("Error existencia pedido para cliente");}
		$this->db->query("SELECT *
						  FROM carrito c, productos p
						  WHERE c.id_producto 	= p.id_producto
						  AND 	c.id_pedido 	= $id_pedido");
		return $this->db->fetchAll();
	}

	public function AltaCarrito($id_pedido, $id_producto, $cantidad_pedida, $precio_venta){
		$pe = new Pedidos();
		$p = new Productos();
		if(!$this->ExisteCarrito($id_pedido, $id_producto)){
			if($p->ExisteCantidadEnStock($id_producto,$cantidad_pedida)){
				$pe->ValidarId($id_pedido);
				$p->ValidarId($id_producto);
				$this->ValidarCantidadPedida($cantidad_pedida);
				$this->ValidarPrecioVenta($id_producto, $precio_venta);

				$this->db->query("INSERT INTO carrito
								  (id_pedido, id_producto, cantidad_pedida, precio_venta)
								  VALUES
								  ($id_pedido, $id_producto, $cantidad_pedida, $precio_venta)
								  ");
				}
			else{throw new ValidacionException("error existencia producto");}			
		}
		else{throw new ValidacionException("error existencia pedido");}
	}

	public function ActualizarCarrito($id_pedido, $id_producto, $cantidad_pedida, $precio_venta){
		if($this->ExisteCarrito($id_pedido, $id_producto)){
			$p = new Productos();
			if($p->ExisteCantidadEnStock($id_producto,$cantidad_pedida)){
				$pe = new Pedidos();
				$pe->ValidarId($id_pedido);
				$p->ValidarId($id_producto);
				$this->ValidarCantidadPedida($cantidad_pedida);
				$this->ValidarPrecioVenta($id_producto, $precio_venta);

				$this->db->query("UPDATE carrito
								  SET cantidad_pedida 	= $cantidad_pedida,
								  		precio_venta 	= $precio_venta
								  WHERE id_pedido = $id_pedido
								  AND 	id_producto = $id_producto
								  LIMIT 1
								  ");
			}
			else{throw new ValidacionException("error cantidad pedida excedente a stock");}
		}
		else{throw new ValidacionException("error existencia carrito para pedido");}
	}

	public function BajaCarrito($id_pedido, $id_producto){
		if($this->ExisteCarrito($id_pedido, $id_producto)){

			$this->db->query("DELETE
							  FROM carrito
							  WHERE id_pedido 	= $id_pedido
							  AND 	id_producto = $id_producto
							  LIMIT 1
							  ");
		}
		else{throw new ValidacionException("error existencia carrito");}
	}	

}

?>