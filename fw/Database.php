<?php

class Database{
	private $con = false;
	private $res;
	private static $instance = false;

	private function __construct(){}

	public static function getInstance(){
		if(!self::$instance) self::$instance = new Database();		
		return self::$instance;
	}

	private function connect(){		
		$this->con=mysqli_connect("localhost","root","","ferretero");
	}

	public function query($sql){
		if(!$this->con)	$this->connect();
		$this->res = mysqli_query($this->con, $sql);
		if(!$this->res) die(mysqli_error($this->con) . " -- Consulta: " . $sql);
	}

	public function numRows(){
		return mysqli_num_rows($this->res);
	}

	public function fetch(){
		return mysqli_fetch_assoc($this->res);
	}

	public function fetchAll(){
		$aux = array();
		while($fila = $this->fetch()) $aux[] = $fila;
		return $aux;
	}

	public function escape($str){
		if(!$this->con) $this->connect();
		return mysqli_escape_string($this->con, $str);
	}

	public function escapeWildcards($str){
		$str = str_replace('%', '\%', $str);
		$str = str_replace('_', '\_', $str);
		return $str;
	}

	public function ultimoId(){
		return mysqli_insert_id($this->con);
	}	

}

?>