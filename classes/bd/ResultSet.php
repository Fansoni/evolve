<?php

class ResultSet{
	var $rs;
	var $SGBD;
	//var $erro;
	//var $msg;

	function ResultSet($SGBD, $sql,  $autoCommit){
		$this->SGBD = $SGBD;
		$this->rs = $this->SGBD->query($sql, $autoCommit);
	}

	function fetchRow(){
		return $this->SGBD->fetchRow($this->rs);
	}

	function numRows(){
		return $this->SGBD->numRows($this->rs);
	}
	
	function getMessage(){
		return $this->SGBD->getMensagem();
	}

	function isError(){
		return $this->SGBD->isError();
	}

	function ultimoId(){
		return $this->SGBD->ultimoId();
	}
}
