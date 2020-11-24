<?php

// ../models/Clientes.php

/*Lista de funciones
	public function ValidarDni($dni)
	public function ValidarCorreo($correo)				->return string
	public function ValidarContrasenia($contrasenia)	->return string
	public function ValidarNombre($nombre)				->return string
	public function ValidarApellido($apellido)			->return string
	public function ValidarCalle($calle)				->return string
	public function ValidarNumeroCalle($numeroCalle)
	public function ValidarDatosAdicionales($datos)		->return string
	public function ValidarTelefono($telefono)

	public function ExisteDni($dni)						->return boolean
	public function ExisteCorreo($correo)				->return boolean
	public function ExisteContrasenia($contrasenia)		->return boolean
	public function ExisteCorreoParaContrasenia(
	$correo, $contrasenia)								->return boolean
	public function getClienteDeCorreoMasContrasenia(
	$correo, $contrasenia)								->return array()
	
	public function getTodos()							->return array()
	public function getCliente($dni)					->return array()

	public function AltaCliente($dni_cliente, $correo, 
	$contrasenia, $nombre, $apellido, $calle, 
	$numeroCalle, $datos_adicionales, $telefono)

	public function ActualizarCliente($dni_cliente, 
	$correo, $contrasenia, $nombre, $apellido, 
	$calle, $numeroCalle, $datos_adicionales, $telefono)

	public function BajaCliente($dni_cliente)
*/

class Clientes extends Model{

	public function ValidarDni($dni){
		if(!ctype_digit($dni)) throw new ValidacionException("error validar dni cliente");
		if($dni<1) throw new ValidacionException("error validar dni cliente");
	}	

	public function ValidarCorreo($correo){
		if(strlen($correo)<1) throw new ValidacionException("error validar correo cliente");
		$correo = $this->db->escape($correo);
		$correo = $this->db->escapeWildcards($correo);

		return $correo;
	}

	public function ValidarContrasenia($contrasenia){
		if(strlen($contrasenia)<1) throw new ValidacionException("error validar contraseña cliente");
		$contrasenia = $this->db->escape($contrasenia);
		$contrasenia = $this->db->escapeWildcards($contrasenia);

		return $contrasenia;
	}

	public function ValidarNombre($nombre){
		if(strlen($nombre)<1) throw new ValidacionException("error validar nombre cliente");
		$nombre = $this->db->escape($nombre);
		$nombre = $this->db->escapeWildcards($nombre);

		return $nombre;
	}

	public function ValidarApellido($apellido){
		if(strlen($apellido)<1) throw new ValidacionException("error validar apellido cliente");
		$apellido = $this->db->escape($apellido);
		$apellido = $this->db->escapeWildcards($apellido);

		return $apellido;
	}

	public function ValidarCalle($calle){
		if(strlen($calle)<1) throw new ValidacionException("error validar calle cliente");
		$calle = $this->db->escape($calle);
		$calle = $this->db->escapeWildcards($calle);

		return $calle;
	}

	public function ValidarNumeroCalle($numeroCalle){
		if(!ctype_digit($numeroCalle)) throw new ValidacionException("error validar numero calle cliente");
		if($numeroCalle<1) throw new ValidacionException("error validar numero calle cliente");
	}

	public function ValidarDatosAdicionales($datos){
		if(strlen($datos)<1) throw new ValidacionException("error validar datos adicionales cliente");
		$datos = $this->db->escape($datos);
		$datos = $this->db->escapeWildcards($datos);

		return $datos;
	}

	public function ValidarTelefono($telefono){
		if(!ctype_digit($telefono)) throw new ValidacionException("error validar telefono cliente");
		if($telefono<1) throw new ValidacionException("error validar telefono cliente");		
	}

	public function ExisteDni($dni){		
		$this->ValidarDni($dni);
		$this->db->query("SELECT *			
						  FROM clientes
						  WHERE dni_cliente = $dni
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExisteCorreo($correo){
		$correo = $this->ValidarCorreo($correo);
		$this->db->query("SELECT *			
						  FROM clientes
						  WHERE correo = '$correo'
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExisteContrasenia($contrasenia){		
		$contrasenia = $this->ValidarContrasenia($contrasenia);
		$contrasenia = sha1($contrasenia);
		$this->db->query("SELECT *
						  FROM clientes
						  WHERE contrasenia = '$contrasenia'
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExisteCorreoParaContrasenia($correo, $contrasenia){
		$correo = $this->ValidarCorreo($correo);
		$contrasenia = $this->ValidarContrasenia($contrasenia);
		$contrasenia = sha1($contrasenia);

		$this->db->query("SELECT *
						  FROM clientes
						  WHERE correo = '$correo'
						  AND contrasenia = '$contrasenia'
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function getClienteDeCorreoMasContrasenia($correo, $contrasenia){
		$correo = $this->ValidarCorreo($correo);
		$contrasenia = $this->ValidarContrasenia($contrasenia);
		$contrasenia = sha1($contrasenia);

		$this->db->query("SELECT *
						  FROM clientes
						  WHERE correo = '$correo'
						  AND contrasenia = '$contrasenia'
						  ");
		
		return $this->db->fetch();
	}

	public function getTodos(){
		$this->db->query("SELECT * 
						  FROM clientes
						  ");
		return $this->db->fetchAll();
	}

	public function getCliente($dni){
		$this->ValidarDni($dni);
		$this->db->query("SELECT * 
						  FROM clientes 
						  WHERE dni_cliente = $dni
						  ");
		return $this->db->fetch();
	}

	public function AltaCliente($dni_cliente, $correo, $contrasenia, $nombre, $apellido, $calle, $numeroCalle, $datos_adicionales, $telefono){	
		if(!$this->ExisteDni($dni_cliente)){
			if(!$this->ExisteCorreo($correo)){
				if(!$this->ExisteContrasenia($contrasenia)){
					$correo = $this->ValidarCorreo($correo);
					$contrasenia = $this->ValidarContrasenia($contrasenia);
					$contrasenia = sha1($contrasenia);
					$nombre = $this->ValidarNombre($nombre);
					$apellido = $this->ValidarApellido($apellido);
					$calle = $this->ValidarCalle($calle);
					$this->ValidarNumeroCalle($numeroCalle);
					$datos_adicionales = $this->ValidarDatosAdicionales($datos_adicionales);
					$this->ValidarTelefono($telefono);

					$this->db->query("INSERT INTO clientes
									  (dni_cliente, correo, contrasenia, nombre, apellido, calle, numero_calle, datos_adicionales, telefono)
									  VALUES
									  ($dni_cliente, '$correo', '$contrasenia', '$nombre', '$apellido', '$calle', $numeroCalle, '$datos_adicionales', $telefono)
									  ");
				}
				else{throw new ValidacionException("error existencia contraseña");}
			}
			else{throw new ValidacionException("error existencia correo");}	
		}	
		else{throw new ValidacionException("error existencia dni");}
	}

	public function ActualizarCliente($dni_cliente, $correo, $contrasenia, $nombre, $apellido, $calle, $numeroCalle, $datos_adicionales, $telefono){
		if($this->ExisteDni($dni_cliente)){
			if(!$this->ExisteCorreoParaContrasenia($correo, $contrasenia)){
				$correo = $this->ValidarCorreo($correo);
				$contrasenia = $this->ValidarContrasenia($contrasenia);
				$contrasenia = sha1($contrasenia);
				$nombre = $this->ValidarNombre($nombre);
				$apellido = $this->ValidarApellido($apellido);
				$calle = $this->ValidarCalle($calle);
				$this->ValidarNumeroCalle($numeroCalle);
				$datos_adicionales = $this->ValidarDatosAdicionales($datos_adicionales);
				$this->ValidarTelefono($telefono);

				$this->db->query("UPDATE clientes
								  SET correo = '$correo'
								  contrasenia = '$contrasenia', 
								  nombre = '$nombre', 
								  apellido = '$apellido', 
								  calle = '$calle', 
								  numero_calle ='$numeroCalle', 
								  datos_adicionales = '$datos_adicionales', 
								  telefono = $telefono
								  WHERE dni_cliente = $dni_cliente
								  LIMIT 1
								  ");	
			}
			else{throw new ValidacionException("error existencia correo para contraseña");}
		}
		else{throw new ValidacionException("error existencia dni");}
	}	

	public function BajaCliente($dni_cliente){
		if($this->ExisteDni($dni_cliente)){
			$this->ValidarDni($dni_cliente);
			$this->db->query("DELETE
							  FROM clientes
							  WHERE dni_cliente = $dni_cliente
							  LIMIT 1
							");
		}
		else{throw new ValidacionException("error existencia cliente");}
	}
}

?>