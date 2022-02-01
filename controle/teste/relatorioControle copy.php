<?php
################################################################################
#### GERAL
################################################################################
$arrEstados = Exec::listar('cidadeibge', 'WHERE cod_estado_ibge = 0 AND id <> 1');

################################################################################
#### LISTAR
################################################################################
if($metodo=="listar" || $metodo==""){
    
    $contas = Exec::listarBy('tesouroconta', 'ORDER BY id ASC');
    
    $contas_associadas = Relatorio::filtrar($post);

    $grafo = new Grafo();

    $arest = array();

    for ($i=0; $i < count($contas); $i++) { 
        $conta = $contas[$i];
        $vertice = array(
            'id' => $conta['id'],
            'codigo' => $conta['codigo'],
            'nome' => $conta['nome'],
            'inicial' => 0.0,
            'movimento' => 0.0,
            'final' => 0.0,
        );
        $grafo->adicionarVertice($vertice);
        array_push($arest, array(
            'origem' => ($conta['id_pai'] != 0)?$conta['id_pai']:$conta['id'],
            'destino' => $conta['id'],
        ));
        
    }
    for ($i=0; $i < count($arest); $i++) { 
        $grafo->adicionarAresta($i, $arest[$i]['origem'], $arest[$i]['destino']);
    }
    for ($j=0; $j < count($contas_associadas); $j++) { 
        $aux = $contas_associadas[$j];

        //Actualizar o vértice
        $result = $grafo->getVertice($aux['id']);
        $vertice = array(
            'id' => $result->getDado()['id'],
            'codigo' => $result->getDado()['codigo'],
            'nome' => $result->getDado()['nome'],
            'inicial' => $result->getDado()['inicial'],
            'movimento' => $result->getDado()['movimento'],
            'final' => $result->getDado()['final'],
        );
        $grafo->actualizarVertice($result, $vertice);
        
        //PAI - actualizar ao valor do pai
        $result = $grafo->getVertice($aux['id_pai']);
        $vertice = array(
            'id' => $result->getDado()['id'],
            'codigo' => $result->getDado()['codigo'],
            'nome' => $result->getDado()['nome'],
            'inicial' => $result->getDado()['inicial'] + $aux['inicial'],
            'movimento' => $result->getDado()['movimento'] + $aux['movimento'],
            'final' => $result->getDado()['final'] + $aux['final'],
        );
        $grafo->actualizarVertice($result, $vertice);
    }

    $grafo->buscaLargura();
    
    $view = "relatorio_listar";
    
}




