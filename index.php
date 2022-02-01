<?php
date_default_timezone_set("America/Sao_Paulo");
session_start();

ob_start("ob_gzhandler");

include "config/define.php";
include PATHCONFIG."conecta.php";
include PATHCONFIG."classes.php";
include PATHBIBLIOTECA."funcoes.php";

##################################################################
#                      FILTROS
##################################################################
$post = filter_input_array(INPUT_POST,FILTER_DEFAULT);
$get = filter_input_array(INPUT_GET,FILTER_DEFAULT);
$server = filter_input_array(INPUT_SERVER,FILTER_DEFAULT);

##################################################################
#                     PARAMETROS
##################################################################
$arrModulos = array('teste');
$modulo = $pathModulo = '';
$link = $get['url'];


if(isset($get['url'])){
    
    $arrParametro = explode("/",$get['url']);
    
    if(in_array($arrParametro[0],$arrModulos)){
        
        $modulo = $arrParametro[0];
        $pathModulo = $arrParametro[0]."/";
        $controle = $arrParametro[1];
        $metodo = $arrParametro[2];
        $registro = $arrParametro[3];
        $extra = $arrParametro[4];
        
        if($controle==""){
            $controle = "home";
        }
        
    }else{
    
        die("Módulo inexistente");
        
    }
    
}

##################################################################
#                     CONTROLES
##################################################################

if(!file_exists(PATHCONTROLE.$pathModulo.$controle.'Controle.php')){
    die("Controle inexistente (".PATHCONTROLE.$pathModulo.$controle.'Controle.php'.");");
}

//SET TOPO, CONTROLE E RODAPE - CASO NECESSARIO ALTERAR NO METODO DO CONTROLE
$topo = 'topo';
$view = $controle;
$roda = 'rodape';

//INCLUI CONTROLE PADRAO DO MODULO
include PATHCONTROLE.$pathModulo.$modulo.'Controle.php';

//CARREGA CONTROLE
include PATHCONTROLE.$pathModulo.$controle.'Controle.php';

//CARREGA VIEWS
include PATHVIEW.$pathModulo.$topo.'.php';
include PATHVIEW.$pathModulo.$view.'.php';
include PATHVIEW.$pathModulo.$roda.'.php';

ob_end_flush();
