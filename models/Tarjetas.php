<?php

//  ../models/Tarjetas.php

/*Lista de funciones
	public function ValidarNumero($numero)
	public function ValidarNombre($nombre)				->return string
	public function ValidarClave($clave)
	public function ValidarVencimiento($mes,$anio)

	public function ExisteNumero($numero)				->return boolean
	public function ExisteTarjetaParaCliente(
	$numero_tarjeta, $dni_cliente)						->return boolean

	public function getTodos()							->return array()
	public function getTarjeta($numero_tarjeta)			->return array()

	public function AltaTarjeta($dni_cliente, 
	$nombre, $numero_tarjeta, $clave, 
	$mesVencimiento, $anioVencimiento)

	public function ActualizarTarjeta($numero_tarjeta, 
	$dni_cliente, $nombre, $clave, 
	$mesVencimiento, $anioVencimiento)

	public function BajaTarjeta($numero_tarjeta)
*/

class Tarjetas extends Model{

	public function ValidarNumero($numero){		
		if(!ctype_digit($numero)) throw new ValidacionException("error validar numero tarjeta");
		if($numero<0) throw new ValidacionException("error validar numero tarjeta");
		if($numero>9999999999999999) throw new ValidacionException("error validar numero tarjeta");	
	}

	public function ValidarNombre($nombre){
		if(!ctype_alpha($nombre)) throw new ValidacionException("error validar nombre tarjeta");
		if(strlen($nombre)<1) throw new ValidacionException("error validar nombre tarjeta");
		$nombre = $this->db->escape($nombre);
		$nombre = $this->db->escapeWildcards($nombre);		

		return $nombre;
	}

	public function ValidarClave($clave){
		if(!ctype_digit($clave)) throw new ValidacionException("error validar clave tarjeta");
		if($clave<1) throw new ValidacionException("error validar clave tarjeta");
		if($clave>9999) throw new ValidacionException("error validar clave tarjeta");
	}

	public function ValidarVencimiento($mes,$anio){
		if(!ctype_digit($mes)) throw new ValidacionException("error validar mes vencimiento tarjeta");
		if($mes<1) throw new ValidacionException("error validar mes vencimiento tarjeta");
		if($mes>12) throw new ValidacionException("error validar mes vencimiento tarjeta");

		if(!ctype_digit($anio)) throw new ValidacionException("error validar año vencimiento tarjeta");
		if($anio<date('y')) throw new ValidacionException("error validar año vencimiento tarjeta");
	}


	public function ValidarDni($dni){
		if(!ctype_digit($dni)) throw new ValidacionException("error validar dni cliente");
		if($dni<1) throw new ValidacionException("error validar dni cliente");
	}


	public function ExisteNumero($numero){
		$this->ValidarNumero($numero);
		$this->db->query("SELECT *
						  FROM tarjetas
						  WHERE numero_tarjeta = $numero");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExisteTarjetaParaCliente($numero_tarjeta, $dni_cliente){
		$c = new Clientes();				
		$c->ValidarDni($dni_cliente);
		$this->ValidarNumero($numero_tarjeta);
		
		$this->db->query("SELECT *
						  FROM clientes c, tarjetas t
						  WHERE c.dni_cliente		= t.dni_cliente
						  AND 	t.numero_tarjeta 	= $numero_tarjeta 
						  AND 	c.dni_cliente 		= $dni_cliente
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function getTodos(){
		$this->db->query("SELECT * 
						  FROM tarjetas
						  ");
		return $this->db->fetchAll();
	}

	public function getTarjetasPorDni($dni){
		$this->ValidarDni($dni);
		$this->db->query("SELECT * 
						  FROM tarjetas 
						  WHERE dni_cliente = $dni
						  ");
		return $this->db->fetchAll();
	}

	public function getTarjeta($numero_tarjeta){
		$this->ValidarNumero($numero_tarjeta);
		$this->db->query("SELECT * 
						  FROM tarjetas 
						  WHERE numero_tarjeta = $numero_tarjeta
						  ");
		return $this->db->fetch();
	}

	public function AltaTarjeta($dni_cliente, $nombre, $numero_tarjeta, $clave, $mesVencimiento, $anioVencimiento){
		$c = new Clientes();
		if($c->ExisteDni($dni_cliente)){
			if(!$this->ExisteNumero($numero_tarjeta)){
				$c->ValidarDni($dni_cliente);
				$nombre_tarjeta = $this->ValidarNombre($nombre);
				$this->ValidarNumero($numero_tarjeta);
				$this->ValidarClave($clave);
				$this->ValidarVencimiento($mesVencimiento, $anioVencimiento);

				$this->db->query("INSERT INTO tarjetas
								  (dni_cliente, nombre_tarjeta, numero_tarjeta, clave, vencimiento)
								  VALUES
								  ($dni_cliente, '$nombre_tarjeta', $numero_tarjeta, $clave, '$anioVencimiento-$mesVencimiento')
								  ");
			}
			else{throw new ValidacionException("error existencia tarjeta");}
		}
		else{throw new ValidacionException("error existencia cliente");}
	}

	public function ActualizarTarjeta($numero_tarjeta, $dni_cliente, $nombre, $clave, $mesVencimiento, $anioVencimiento){
		if($this->ExisteTarjetaParaCliente($numero_tarjeta, $dni_cliente)){
			$this->ValidarNumero($numero_tarjeta);
			$c = new Clientes();
			$c->ValidarDni($dni_cliente);
			$nombre_tarjeta = $this->ValidarNombre($nombre);
			$this->ValidarNumero($numero_tarjeta);
			$this->ValidarClave($clave);
			$this->ValidarVencimiento($mesVencimiento, $anioVencimiento);

			$this->db->query("UPDATE tarjetas
							  SET nombre_tarjeta = '$nombre_tarjeta', 
							  clave = $clave, 
							  vencimiento = '$anioVencimiento-$mesVencimiento'
							  WHERE numero_tarjeta = $numero_tarjeta
							  LIMIT 1
							  ");
		}
		else{throw new ValidacionException("error existencia tarjeta para cliente");}		
	}

	public function BajaTarjeta($numero_tarjeta){
		if($this->ExisteNumero($numero_tarjeta)){
			$this->ValidarNumero($numero_tarjeta);
			$this->db->query("DELETE
							  FROM tarjetas
							  WHERE numero_tarjeta = $numero_tarjeta
							  LIMIT 1
							  ");
		}
		else{throw new ValidacionException("error existencia tarjeta");}
	}
}

?>