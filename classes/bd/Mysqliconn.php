<?php
/**
 * Classe com as funções para manipular o acesso ao mysql
 */
class Mysqliconn extends BancoCLS{


	function Mysqliconn($usuario, $senha, $servidor, $base, $porta){
		if($porta == ''){
			$porta = 3306;
		}
		$this->usuario 		= $usuario;
		$this->senha 		= $senha;
		$this->servidor 	= $servidor;
		$this->base 		= $base;
		$this->porta		= $porta;
	}

	function connect(){
		if(!$this->conn = mysqli_connect(	$this->servidor , $this->usuario, $this->senha	) ){
			$this->setErro('Erro ao conectar no servidor mysql.<br />'.mysqli_error($this->conn));
			return false;
		} elseif(!mysqli_select_db($this->conn,$this->base) ){
			$this->setErro('Erro ao conectar no servidor mysql.<br />'.mysqli_error($this->conn));
			return false;
		}
		mysqli_query($this->conn, "SET NAMES 'utf8';");
		return true;
	}
	
	function query($sql, $autoCommit = false){
		if(	!$rs = mysqli_query(	$this->conn, $sql	) )
			$this->setErro('<p>'.$sql.'</p>Erro-> '.mysqli_error($this->conn));

		return $rs;
	}
	
	function fetchRow(&$rs){
		return mysqli_fetch_assoc($rs);
	}
	
	function close(){
		mysqli_close($this->conn);
	}
	
	function numRows(&$rs){
		return mysqli_num_rows(	$rs	);
	}
	
	function isError(){
		return $this->erro;
	}
	
	function ultimoId(){
		return mysqli_insert_id();
	}
}
