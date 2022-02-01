<?php

class Usuario extends Exec {

    public function __construct($params = "") {
        parent::__construct(strtolower(get_class()), $params);
    }

    public static function filtrar($post="", $filtroExtra="") {
        
        $filtro = " WHERE id IS NOT NULL ";
        
        $sql = "SELECT * FROM ".DB_PREFIX."_usuario ".$filtro;

        $rs = executaSql($sql);
        $arrLista = array();
        while($rg = $rs->fetchRow()){
            $arrLista[$rg['id']] = $rg;
        }
        return (count($arrLista) > 0) ? $arrLista : false;
        
        /*
        Obs: note que o id da tabela no banco será a key do array
             e será retornado false ou o array a fim de facilitar o teste no reotorno
             como pode ser visto na view deste controle
        */
        
        
    }
    
    
    
}
