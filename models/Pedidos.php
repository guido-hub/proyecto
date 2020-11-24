<?php

//  ../models/Pedidos.php

/*Lista de funciones
	public function ValidarId($id)
	public function ValidarFechaPedido($dia, $mes, $anio)
	public function ValidarFechaEntrega($dia, $mes, $anio)
	public function ValidarPagado($pagado)				->return string
	public function ValidarEntregado($entregado)		->return string
	public function ValidarFormaDePago($forma)			->return string

	public function ExisteId($id)						->return boolean
	public function ExistePedidoParaCliente(
	$id_pedido, $dni_cliente)							->return boolean
	public function ExisteTarjetaParaPedido(
	$numero_tarjeta, $id_pedido)
	public function getPedidosDeCliente($dni)			->return array()

	public function getTodos()							->return array()
	public function getPedido($id)						->return array()

	public function AltaPedido($dni_cliente, 
	$diaPedido, $mesPedido, $anioPedido, $diaEntrega, 
	$mesEntrega, $anioEntrega, $pagado, $entregado, 
	$forma_de_pago, $numero_tarjeta)

	public function ActualizarPedido($id_pedido, 
	$dni_cliente, $diaPedido, $mesPedido, $anioPedido, 
	$diaEntrega, $mesEntrega, $anioEntrega, $pagado, 
	$entregado, $forma_de_pago, $tarjeta_usada)

	public function BajaPedido($id_pedido)

	public function ActualizarEstadoPedido($id_pedido, 
	$pagado, $entregado, $forma_de_pago)
*/

class Pedidos extends Model{

	public function ValidarId($id){
		if(!is_numeric($id)) throw new ValidacionException("error validar id pedido");
		if($id<1) throw new ValidacionException("error validar id pedido");
	}

	public function ValidarFechaPedido($dia, $mes, $anio){
		if(!is_numeric($dia)) throw new ValidacionException("error validar dia pedido");
		if($dia>31) throw new ValidacionException("error validar dia pedido");
		if($dia<1) throw new ValidacionException("error validar dia pedido");

		if(!is_numeric($mes)) throw new ValidacionException("error validar mes pedido");
		if($mes>12) throw new ValidacionException("error validar mes pedido");
		if($mes<1) throw new ValidacionException("error validar mes pedido");

		if(!is_numeric($anio)) throw new ValidacionException("error validar año pedido");
		if($anio>date('Y')) throw new ValidacionException("error validar año pedido");
		if($anio<date('Y')) throw new ValidacionException("error validar año pedido");

		if(!checkdate($mes, $dia, $anio)) throw new ValidacionException("error validar fecha pedido");
	}

	public function ValidarFechaEntrega($dia, $mes, $anio){
		if(!ctype_digit($dia)) throw new ValidacionException("error validar dia entrega pedido");
		if($dia>31) throw new ValidacionException("error validar dia entrega pedido");
		if($dia<1) throw new ValidacionException("error validar dia entrega pedido");

		if(!ctype_digit($mes)) throw new ValidacionException("error validar mes entrega pedido");
		if($mes>12) throw new ValidacionException("error validar mes entrega pedido");
		if($mes<1) throw new ValidacionException("error validar mes entrega pedido");
		if($mes>date('m')+1) throw new ValidacionException("error validar mes entrega pedido");
		if($mes<date('m') && date('m')!=12) throw new ValidacionException("error validar mes entrega pedido");

		if(!ctype_digit($anio)) throw new ValidacionException("error validar año entrega pedido");
		if($anio>date('Y') && date('m')!=12) throw new ValidacionException("error validar año entrega pedido");
		if($anio<date('Y')) throw new ValidacionException("error validar año entrega pedido");

		if(!checkdate($mes, $dia, $anio)) throw new ValidacionException("error validar fecha entrega pedido");
	}	

	public function ValidarPagado($pagado){
		if(!ctype_alpha($pagado)) throw new ValidacionException("error validar estado pagado");
		if(strlen($pagado)<1) throw new ValidacionException("error validar estado pagado");
		$pagado = $this->db->escape($pagado);
		$pagado = $this->db->escapeWildcards($pagado);

		return $pagado;
	}

	public function ValidarEntregado($entregado){
		if(!ctype_alpha($entregado)) throw new ValidacionException("error validar estado entregado");
		if(strlen($entregado)<1) throw new ValidacionException("error validar estado entregado");
		$entregado = $this->db->escape($entregado);
		$entregado = $this->db->escapeWildcards($entregado);

		return $entregado;
	}

	public function ValidarFormaDePago($forma){
		if(strlen($forma)<1) throw new ValidacionException("error validar forma de pago");
		$forma = $this->db->escape($forma);
		$forma = $this->db->escapeWildcards($forma);

		return $forma;
	}

	public function ExisteId($id){
		$this->ValidarId($id);
		$this->db->query("SELECT * 
						  FROM pedidos
						  WHERE id_pedido = $id
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExistePedidoParaCliente($id_pedido, $dni_cliente){
		$this->ValidarId($id_pedido);
		$c = new Clientes();
		$c->ValidarDni($dni_cliente);

		$this->db->query("SELECT *
						  FROM clientes c, pedidos p
						  WHERE c.dni_cliente 	= p.dni_cliente
						  AND 	p.id_pedido 	= $id_pedido
						  AND 	c.dni_cliente	= $dni_cliente 
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExisteTarjetaParaPedido($numero_tarjeta, $id_pedido){
		$this->ValidarId($id_pedido);
		$t = new Tarjetas();
		$t->ValidarNumero($numero_tarjeta);

		$this->db->query("SELECT *
						  FROM pedidos p, tarjetas t
						  WHERE p.tarjeta_usada = t.numero_tarjeta
						  AND 	t.tarjeta_usada = $numero_tarjeta
						  AND 	p.id_pedido		= $id_pedido
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function getPedidosDeCliente($dni){
		$c = new Clientes();
		$c->ValidarDni($dni);
		$this->db->query("SELECT *
						  FROM pedidos
						  WHERE dni_cliente = $dni
						  ");
		return $this->db->fetchAll();
	}

	public function getTodos(){
		$this->db->query("SELECT * 
						  FROM pedidos						  
						  ");
		return $this->db->fetchAll();
	}

	public function getPedido($id){
		$this->ValidarId($id);
		$this->db->query("SELECT * 
						  FROM pedidos 
						  WHERE id_pedido = $id
						  ");
		return $this->db->fetch();
	}

	public function AltaPedido($dni_cliente, $diaPedido, $mesPedido, $anioPedido, $diaEntrega, $mesEntrega, $anioEntrega, $pagado, $entregado, $forma_de_pago, $numero_tarjeta){
		$c = new Clientes();
		if($c->ExisteDni($dni_cliente)){
			$t = new Tarjetas();
			if($t->ExisteTarjetaParaCliente($numero_tarjeta, $dni_cliente)){
				$c->ValidarDni($dni_cliente);
				$this->ValidarFechaPedido($diaPedido, $mesPedido, $anioPedido);
				$this->ValidarFechaEntrega($diaEntrega, $mesEntrega, $anioEntrega);
				$t->ValidarNumero($numero_tarjeta);
				$entregado = $this->ValidarEntregado($entregado);
				$pagado = $this->ValidarPagado($pagado);
				$forma_de_pago = $this->ValidarFormaDePago($forma_de_pago);

				$this->db->query("INSERT INTO pedidos
								  (dni_cliente, fecha_pedido, fecha_entrega, pagado, entregado, forma_de_pago, tarjeta_usada)
								  VALUES
								  ($dni_cliente, '$anioPedido-$mesPedido-$diaPedido', '$anioEntrega-$mesEntrega-$diaEntrega', '$pagado', '$entregado', '$forma_de_pago', $numero_tarjeta)
								  ");
				return $this->db->ultimoId();
			}
			else{throw new ValidacionException("error existencia tarjeta para cliente");}
		}
		else{throw new ValidacionException("error existencia cliente");}

	}

	public function ActualizarPedido($id_pedido, $dni_cliente, $diaPedido, $mesPedido, $anioPedido, $diaEntrega, $mesEntrega, $anioEntrega, $pagado, $entregado, $forma_de_pago, $tarjeta_usada){
		if($this->ExistePedidoParaCliente($id_pedido, $dni_cliente)){
			$t = new Tarjetas();
			if($t->ExisteTarjetaParaCliente($tarjeta_usada, $dni_cliente)){
				$this->ValidarId($id_pedido);
				$c = new Clientes();
				$c->ValidarDni($dni_cliente);
				$this->ValidarFechaPedido($diaPedido, $mesPedido, $anioPedido);
				$this->ValidarFechaEntrega($diaEntrega, $mesEntrega, $anioEntrega);
				$pagado = $this->ValidarPagado($pagado);
				$entregado = $this->ValidarEntregado($entregado);
				$forma_de_pago = $this->ValidarFormaDePago($forma_de_pago);
				$t->ValidarNumero($tarjeta_usada);

				$this->db->query("UPDATE pedidos
								  SET fecha_pedido = '$anioPedido-$mesPedido-$diaPedido', 
								  fecha_entrega = '$diaEntrega-$mesEntrega-$anioEntrega',
								  pagado = '$pagado',
								  entregado = '$entregado',
								  forma_de_pago = '$forma_de_pago',	
								  tarjeta_usada = $tarjeta_usada
								  WHERE id_pedido = $id_pedido
								  LIMIT 1
								  ");
			}
			else{throw new ValidacionException("error existencia tarjeta para cliente");}			
		}
		else{throw new ValidacionException("error existencia pedido");}
	}

	public function BajaPedido($id_pedido){
		if($this->ExisteId($id_pedido)){
			$this->ValidarId($id_pedido);
			$this->db->query("DELETE
							  FROM pedidos
							  WHERE id_pedido = $id_pedido
							  LIMIT 1
							  ");
		}
		else{throw new ValidacionException("error existencia pedido");}
	}

	public function ActualizarEstadoPedido($id_pedido, $pagado, $entregado, $forma_de_pago){
		if($this->ExisteId($id_pedido)){
			$this->ValidarId($id_pedido);
			$this->db->query("UPDATE pedidos
							  SET 	pagado 			= '$pagado',
							  		entregado 		= '$entregado',
							  		forma_de_pago 	= '$forma_de_pago'
							  WHERE id_pedido		= $id_pedido");
		}
		else{throw new ValidacionException("error existencia id pedido");
		}
	}
}

?>