<?php

function executaSql($sql){
    
    global $db;
    $rs = $db->query($sql);
    return $rs;
    if($rs->isError()){
        exit("Não foi possível processar a requisição.");
    }
    else{
        return $rs;
    }
}