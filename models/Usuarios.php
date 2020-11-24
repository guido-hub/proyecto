<?php

// ../models/Usuarios.php

/*Lista de funciones
	public function ValidarDni($dni)
	public function ValidarCorreo($correo)				->return string
	public function ValidarContrasenia($contrasenia)	->return string

	public function ExisteDni($dni)						->return boolean
	public function ExisteCorreo($correo)				->return boolean
	public function ExisteContrasenia($contrasenia)		->return boolean
	public function ExisteCorreoParaContrasenia(
	$correo, $contrasenia)								->return boolean
	public function getUsuarioDeCorreoMasContrasenia(
	$correo, $contrasenia)								->return array()

	public function getTodos()							->return array()
	public function getUsuario($dni)					->return array()

	public function AltaUsuario($dni_usuario, 
	$correo, $contrasenia)

	public function ActualizarUsuario($dni_usuario, 
	$correo, $contrasenia)
	
	public function BajaUsuario($dni_usuario)
*/

class Usuarios extends Model{

	public function ValidarDni($dni){
		if(!ctype_digit($dni)) throw new ValidacionException("error validar dni usuario");
		if($dni<1) throw new ValidacionException("error validar id usuario");
	}

	public function ValidarCorreo($correo){
		if(strlen($correo)<1) throw new ValidacionException("error validar correo usuario");
		$correo = $this->db->escape($correo);
		$correo = $this->db->escapeWildcards($correo);

		return $correo;
	}

	public function ValidarContrasenia($contrasenia){
		if(strlen($contrasenia)<1) throw new ValidacionException("error validar contraseña usuario");
		$contrasenia = $this->db->escape($contrasenia);
		$contrasenia = $this->db->escapeWildcards($contrasenia);

		return $contrasenia;
	}

	public function ExisteDni($dni){
		$this->ValidarDni($dni);

		$this->db->query("SELECT *
						  FROM usuarios
						  WHERE dni_usuario = $dni
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function ExisteCorreo($correo){
		$correo = $this->ValidarCorreo($correo);
		$this->db->query("SELECT *
						  FROM usuarios
						  WHERE correo = '$correo'
						  ");
		if($this->db->numRows()!=1) return false;
		
		return true;
	}

	public function ExisteContrasenia($contrasenia){
		$contrasenia = $this->ValidarContrasenia($contrasenia);
		$contrasenia = sha1($contrasenia);
		$this->db->query("SELECT *
						  FROM usuarios
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
						  FROM usuarios
						  WHERE correo = '$correo'
						  AND contrasenia = '$contrasenia'
						  ");
		if($this->db->numRows()!=1) return false;

		return true;
	}

	public function getUsuarioDeCorreoMasContrasenia($correo, $contrasenia){
		$correo = $this->ValidarCorreo($correo);
		$contrasenia = $this->ValidarContrasenia($contrasenia);
		$contrasenia = sha1($contrasenia);
		$this->db->query("SELECT *
						  FROM usuarios
						  WHERE correo = '$correo'
						  AND contrasenia = '$contrasenia'
						  ");
		return $this->db->fetch();	
	}

	public function getTodos(){
		$this->db->query("SELECT * 
						  FROM usuarios
						  ");
		return $this->db->fetchAll();
	}

	public function getUsuario($dni){
		$this->ValidarDni($dni);
		$this->db->query("SELECT * 
						  FROM usuarios 
						  WHERE dni_usuario = $dni
						  ");
		return $this->db->fetch();		
	}

	public function AltaUsuario($dni_usuario, $correo, $contrasenia){
		if(!$this->ExisteDni($dni_usuario)){
			if(!$this->ExisteCorreo($correo)){
				if(!$this->ExisteContrasenia($contrasenia)){
					$correo = $this->ValidarCorreo($correo);
					$contrasenia = $this->ValidarContrasenia($contrasenia);
					$contrasenia = sha1($contrasenia);
					$this->db->query("INSERT INTO usuarios
									  (dni_usuario, correo, contrasenia)
									  VALUES
									  ($dni_usuario, '$correo', '$contrasenia')
									  ");
				}
				else{throw new ValidacionException("error existencia contraseña");}
			}
			else{throw new ValidacionException("error existencia correo");}
		}
		else{throw new ValidacionException("error existencia usuario");}	
	}

	public function ActualizarUsuario($dni_usuario, $correo, $contrasenia){
		if($this->ExisteDni($dni_usuario)){
			if(!$this->ExisteCorreoParaContrasenia($correo, $contrasenia)){
				$correo = $this->ValidarCorreo($correo);
				$contrasenia = $this->ValidarContrasenia($contrasenia);
				$contrasenia = sha1($contrasenia);
				$this->db->query("UPDATE usuarios
								  SET correo = '$correo',
								  contrasenia = '$contrasenia'
								  WHERE dni_usuario = $dni_usuario
								  LIMIT 1
								  ");
			}
			else{throw new ValidacionException("error existencia correo para contraseña");}
		}
		else{throw new ValidacionException("error existencia dni");}
	}

	public function BajaUsuario($dni_usuario){
		if($this->ExisteDni($dni_usuario)){
			$this->ValidarDni($dni_usuario);
			$this->db->query("DELETE
							  FROM usuarios
							  WHERE dni_usuario = $dni_usuario
							  LIMIT 1
							  ");
		}
		else{throw new ValidacionException("error existencia usuario");}
	}
}

?>