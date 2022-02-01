<?php
#*****************************
# CONECTA COM BANCO DE DADOS
#*****************************
include PATHCLASSES.'bd/Banco.php';
$db = new BancoCLS(BD_USUARIO,BD_SENHA,BD_SERVIDOR,BD_BASE);
if(!$db->connect()){
	exit("ERRO<br />".$db->getMessage());
}
?>