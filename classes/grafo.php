<?php
/** OS DADOS SERÃO INSERIDOS DESSE JEITO NO GRAFO */
// class Tipo {
//     int id;
//     int id_pai;
//     String codigo;
//     String nome;
//     double inicial;
//     double movimento;
//     double final;
// }

class Grafo {
    private $vertices = [];
    private $arestas = [];

    public function getAllVertices()
    {
        return $this->vertices;
    }

    public function adicionarVertice($dado)
    {
        $novoVertice = new Vertice($dado);
        array_push($this->vertices, $novoVertice);
    }

    public function adicionarAresta($peso = 0.0, $dadoInicio, $dadoFim)
    {
        $inicio = $this->getVertice($dadoInicio);
        $fim = $this->getVertice($dadoFim);
        if($inicio != null && $fim != null){
            $aresta = new Aresta($peso, $inicio, $fim);
            $inicio->adicionarArestaSaida($aresta);
            $fim->adicionarArestaEntrada($aresta);
            array_push($this->arestas, $aresta);
        }
    }

    public function getVertice($dado)
    {
        $vertice = null;
        for ($i=0; $i < count($this->vertices); $i++) {
            if ($this->vertices[$i]->getDado()["id"] == $dado) {
                $vertice = $this->vertices[$i];
                break;
            }
        }
        return $vertice;
    }

    public function actualizarVertice($from, $to)
    {
        $search = array_search($from, $this->vertices);
        if($search){
            $this->vertices[$search]->setDado($to);
        }
    }

    private $marcar = [];
    private $counter = 0;

    public function recursividade($actual)
    {
        if(!in_array($actual, $this->marcar)){
            array_push($this->marcar, $actual);
            $dado = $actual->getDado();
            $space = "";
            for ($i=0; $i < $this->counter; $i++) { 
                $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$space;
            }
            echo "<tr class='filho0 filho filho-hide nivel0 nivelPadrao'>
                    <td>{$space}<i class='fa fa-minus-circle js-abre-filhos' id='{$dado['id']}'></i> {$dado['codigo']} - {$dado['nome']} </td>
                    <td align='right' data-saldo='6934738458.98' data-nat='D'>R$ ".(($dado['inicial'] < 0) ?($dado['inicial']*-1):$dado['inicial'])." ".(($dado['inicial'] < 0) ?'D':'C')."</td>
                    <td align='right' data-saldo='6934738458.98' data-nat='C'>R$ ".(($dado['movimento'] < 0) ?($dado['movimento']*-1):$dado['movimento'])." ".(($dado['movimento'] < 0) ?'D':'C')."</td>
                    <td align='right' data-saldo='6934738458.98' data-nat='D'>R$ ".(($dado['final'] < 0) ?($dado['final']*-1):$dado['final'])." ".(($dado['final'] < 0) ?'D':'C')."</td>
                </tr>";
            for ($i=0; $i < count($actual->getArestasSaida()); $i++) {
                $proximo = $actual->getArestasSaida()[$i]->getFim();
                $this->counter++;
                $this->recursividade($proximo);
                $this->counter--;
            }
        }
    }

    public function buscaLargura()
    {
        $actual = $this->getVertice(100000000);
        if($actual != null){
            $this->recursividade($actual);
        }
    }
}

class Vertice {
    private $dado;
    private $arestasEntrada = []; //Tipo Aresta
    private $arestasSaida = []; //Tipo Aresta

    public function getArestasEntrada()
    {
        return $this->arestasEntrada;
    }
    public function getArestasSaida()
    {
        return $this->arestasSaida;
    }

    public function __construct($valor) {
        $this->dado = $valor;
    }

    public function getDado()
    {
        return $this->dado;
    }

    public function setDado($dado)
    {
        $this->dado = $dado;
    }

    public function adicionarArestaEntrada(Aresta $aresta)
    {
        array_push($this->arestasEntrada, $aresta);
    }

    public function adicionarArestaSaida(Aresta $aresta)
    {
        array_push($this->arestasSaida, $aresta);
    }
}

class Aresta {
    private $peso = 0.0;
    private Vertice $inicio;
    private Vertice $fim;

    public function __construct($peso = 0.0, Vertice $inicio, Vertice $fim) {
        $this->peso = $peso;
        $this->inicio = $inicio;
        $this->fim = $fim;
    }

    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso($peso = 0.0)
    {
        $this->peso = $peso;
    }

    public function getInicio()
    {
        return $this->inicio;
    }

    public function setInicio(Vertice $inicio)
    {
        $this->inicio = $inicio;
    }

    public function getFim()
    {
        return $this->fim;
    }

    public function setFim(Vertice $fim)
    {
        $this->fim = $fim;
    }
}