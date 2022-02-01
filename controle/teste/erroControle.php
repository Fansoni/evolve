<?php

switch ($metodo){
    case 'badrequest';
        header("HTTP/1.0 400 Not Found"); 
        header("Status: 400 Not Found");
        $mensagem = "Requisição inválida";
    break;
    case 'authreqd';
        header("HTTP/1.0 401 Não autorizado"); 
        header("Status: 401 Não autorizado");
        $mensagem = 'Não autorizado';
    break;
    case 'forbid';
        header("HTTP/1.0 403 Acesso Proibido"); 
        header("Status: Acesso Proibido");
        $mensagem = "Acesso Proibido";
    break;
    case 'server';
        header("HTTP/1.0 500 Not Found"); 
        header("Status: 500 Not Found");
        $mensagem = 'Erro interno do servidor';
    break;
    default;
        header("HTTP/1.0 404 Not Found"); 
        header("Status: 404 Not Found");
        $mensagem = "Não encontrado";
        $ddPagina['seo_title'] = "Pagina não encontrada";
    break;
}

$view = "404";

