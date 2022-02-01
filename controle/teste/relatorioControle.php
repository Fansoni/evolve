<?php
################################################################################
#### GERAL
################################################################################
$arrEstados = Exec::listar('cidadeibge', 'WHERE cod_estado_ibge = 0 AND id <> 1');

################################################################################
#### LISTAR
################################################################################
if($metodo=="listar" || $metodo==""){
    
    $cidade = null;
    
    if($post){
        $cidade = Exec::getFirst('cidadeibge', "WHERE nome = '".$post["cidade"]."'");
        $post["cidade_id"] = $cidade['id'];
        $contas_associadas = Relatorio::filtrar($post);

        $grafo = new Grafo();

        for ($j=0; $j < (is_array($contas_associadas) ? count($contas_associadas) : 0); $j++) { 
            $aux = $contas_associadas[$j];
            // echo $aux['nome'].' - '.$aux['inicial'].'<br>';

            //Actualizar o vértice
            $result = $grafo->getVertice($aux['id']);
            if($result == null){
                $vertice = array(
                    'id' => $aux['id'],
                    'id_pai' => $aux['id_pai'],
                    'codigo' => $aux['codigo'],
                    'nome' => $aux['nome'],
                    'inicial' => $aux['inicial'],
                    'movimento' => $aux['movimento'],
                    'final' => $aux['final'],
                );
                $grafo->adicionarVertice($vertice);
            }
        }

        for ($i=0; $i < count($grafo->getAllVertices()); $i++) {
            $v = $grafo->getAllVertices()[$i]->getDado();
            $result = $grafo->getVertice($v['id_pai']);
            if($result == null){
                $conta = Exec::getFirst('tesouroconta', "WHERE id = {$v['id_pai']}");
                if($conta){
                    $vertice = array(
                        'id' => $conta['id'],
                        'id_pai' => $conta['id_pai'],
                        'codigo' => $conta['codigo'],
                        'nome' => $conta['nome'],
                        'inicial' => $v['inicial'],
                        'movimento' => $v['movimento'],
                        'final' => $v['final'],
                    );
                    $grafo->adicionarVertice($vertice);
                    $grafo->adicionarAresta($i, $conta['id'], $v['id']);
                }
            }else{
                $vertice = array(
                    'id' => $result->getDado()['id'],
                    'id_pai' => $result->getDado()['id_pai'],
                    'codigo' => $result->getDado()['codigo'],
                    'nome' => $result->getDado()['nome'],
                    'inicial' => $result->getDado()['inicial'] + $v['inicial'],
                    'movimento' => $result->getDado()['movimento'] + $v['movimento'],
                    'final' => $result->getDado()['final'] + $v['final'],
                );
                $grafo->actualizarVertice($result, $vertice);
                $grafo->adicionarAresta($i, $v['id_pai'], $v['id']);
            }
        }
    }
    
    $view = "relatorio_listar";
    
}




