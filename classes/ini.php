<?php

$arrayDesc = array();
$sql_tables = "SHOW TABLES";
$rs_tables = $db->query($sql_tables);
while($rg_tables = $rs_tables->fetchRow()){

        # monta array config
        $table = strtolower($rg_tables['Tables_in_'.BD_BASE]);
        $table_config = str_replace("_","",$table);

        $sql_desc = "DESC ".$table;
        $rs_desc = $db->query($sql_desc);
        unset($arrayDesc);
        $arrayDesc = array();
        while($rg_desc = $rs_desc->fetchRow()){
                $bd_campo = $rg_desc['Field'];
                $classe_campo = "";
                $aux = explode("_",$bd_campo);
                $z = 0;
                foreach($aux as $aux1){
                        $z++;
                        if($z == 1){
                                $classe_campo = $aux1;
                        }
                        else{
                                $classe_campo .= ucwords($aux1);
                        }
                }
                $arrayDesc[$bd_campo] = $classe_campo;
        }

        $_SESSION[SESSAO]['tabelas'][$table_config]['infotabela'] = array(
                        'tabelanome' => $table,
                        'tabelaid'   => 'id'
                    );
        $_SESSION[SESSAO]['tabelas'][$table_config]['infocampos'] = $arrayDesc;

}

