<?php
require_once('Mysqliconn.php');
require_once('ResultSet.php');

class BancoCLS{

	/**
	* usuario do banco de dados
	*
	* @var string
	*/
	var $usuario;
	
	/**
	* senha do banco de dados
	*
	* @var string
	*/
	var $senha;
	
	/**
	* servidor do banco de dados
	*
	* @var string
	*/
	var $servidor;
	
	/**
	* base (schema) a ser acessado
	*
	* @var string
	*/
	var $base;
	
	/**
	* Identifica se a classe est� com alguma erro
	* 
	* @var boolean
	*/
	var $erro;

	/**
	* Mensagem escrita pela classe
	* 
	* @var string
	*/	
	var $msg;

	/**
	* define o banco de dados
	*
	* @var string
	*/
	var $tipo;
	
	/**
	* define a porta de conex�o com o banco de dados
	*
	* @var int
	*/
	var $porta;      
	
	/**
	* string de conexão no banco de dados
	*
	* @var string
	*/
	var $conn;

	/**
	* objeto instanciado conforme tipo de banco de dados
	*
	* @var object
	*/	
	var $SGBD;

	/**
	* Seta erro=true e escreve mensagem
	*
	* @param int $msg
	* 
	* @return void
	*/
	function setErro($msg){
		$this->erro = true;
		$this->msg  = $msg;
	}

	/**
	* Retorna mensagem do banco
	*
	* @return string
	*/
	function getMensagem(){
		return $this->msg;
	}

	/**
	* Retorna mensagem do objeto SGBD instanciado
	*
	* @return string
	*/
	function getMessage(){
		return $this->SGBD->getMensagem();
	}

	/**
	* Método construtor da classe
	*
	* @param string $usuario
	* @param string $senha
	* @param string $servidor
	* @param string $base
	* @param string $tipo
	* @param string $porta
	*
	* @return void
	*/
	function BancoCLS($usuario='', $senha='', $servidor='', $base='', $tipo='mysqli', $porta=''){
		$this->usuario 	= $usuario;
		$this->senha 	= $senha;
		$this->tipo     = $tipo;
		$this->servidor = $servidor;
		$this->base	= $base;
		$this->porta	= $porta;
		$this->erro 	= false;

		switch($this->tipo){
                    case 'mysql': 
                        $this->SGBD = new Mysql($this->usuario, $this->senha, $this->servidor, $this->base, $this->porta); 
                    break;
                    case 'mysqli': 
                        $this->SGBD = new Mysqliconn($this->usuario, $this->senha, $this->servidor, $this->base, $this->porta); 
                    break;
		}
	}

	/**
	* Conecta o objeto SGBD instanciado
	*
	* @return string
	*/
	function connect(){
		return $this->SGBD->connect();
	}

	/**
	* Executa uma query no objeto SGBD instanciado
	*
	* @param string $sql
	* @param boolean $autoCommit
	*
	* @return string
	*/
	function query($sql, $autoCommit = false){
		return new ResultSet($this->SGBD, $sql, $autoCommit);
	}

	/**
	* Fecha conexão do objeto SGBD instanciado
	*
	* @return void
	*/
	function close(){
		$this->SGBD->close();
	}

}
