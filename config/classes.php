<?php

#***********************************
# INCLUI AS CLASSES DO SISTEMA
#***********************************
include PATHCLASSES.'ini.php';
function __autoload($nomeClasse) {
	include PATHCLASSES.$nomeClasse.'.php';
}
?>