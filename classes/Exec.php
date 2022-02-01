<?php
class Exec {

    private $tabelaNome;
    private $tabelaId;
    private $arrCampos;

    ##################################
    # MAGICOS
    ##################################
    private $attr = array();

    public function __set($atributo, $valor) {
        $this->attr[$atributo] = trim($valor);
    }

    public function __get($atributo) {
        if (array_key_exists($atributo, $this->attr)) {
            return $this->attr[$atributo];
        }
        trigger_error("Propriedade $atributo não existe");
        return null;
    }

    ##################################
    # CONSTRUTOR
    ##################################

    public function __construct($objeto, $params) {
        # inclui array de configuracoes da classe
        $this->tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $this->tabelaId = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelaid'];
        $this->arrCampos = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infocampos'];

        # seta atributos
        $verArray = (is_array($params)) ? true : false;
        foreach ($this->arrCampos as $campo => $variavel) {
            if ($verArray && isset($params[$variavel])) {
                $this->{$variavel} = $params[$variavel];
            } else {
                $this->{$variavel} = "";
            }
        }
        $this->erro = false;
    }

    ##################################
    # CARGA DE DADOS
    ##################################
    public function carga($params) {
        # seta atributos
        $verArray = (is_array($params)) ? true : false;
        foreach ($this->arrCampos as $campo => $variavel) {
            if ($verArray && isset($params[$variavel])) {
                $this->{$variavel} = $params[$variavel];
            }
        }
    }

    ##################################
    # CARREGAR (select)
    ##################################
    public function carregar() {

        $sql = "SELECT *
            FROM   " . $this->tabelaNome . "
            WHERE  " . $this->tabelaId . " = " . $this->{$this->arrCampos[$this->tabelaId]};
        // exit($sql);
        $rs = executaSql($sql);
        if ($rg = $rs->fetchRow()) {
            foreach ($this->arrCampos as $campo => $variavel) {
                $this->{$variavel} = $rg[$campo];
            }
        } else {
            return false;
        }
        return true;
    }

    ##################################
    # INSERIR (insert)
    ##################################
    public function inserir() {

        $sql = "INSERT INTO " . $this->tabelaNome . " ";
        $campos = "";
        $valores = "";
        foreach ($this->arrCampos as $campo => $variavel) {
            $campos .= $campo . ", ";
            switch ($campo) {
                case $this->tabelaId:
                    $valores .= "'', ";
                    break;
                case 'id':
                    $valores .= "NULL, ";
                    break;
                case 'dt_cadastro':
                    $valores .= "'" . DATAHORAMYSQL . "', ";
                    break;
                case 'dt_atualiza':
                    $valores .= "'" . DATAHORAMYSQL . "', ";
                    break;
                default:
                    $valores .= "'" . addslashes($this->{$variavel}) . "', ";
            }
        }
        $sql .= "(" . substr(trim($campos), 0, -1) . ") ";
        $sql .= "VALUES (" . substr(trim($valores), 0, -1) . ")";
        $rs = executaSql($sql);
        $this->atualizaId();

        return true;
    }

    ##################################
    # ALTERAR (update)
    ##################################

    public function alterar() {
        $sql = "UPDATE " . $this->tabelaNome . " ";
        $sql .= "SET ";
        $set = "";
        foreach ($this->arrCampos as $campo => $variavel) {
            switch ($campo) {
                case $this->tabelaId:
                    $set .= "";
                    break;
                case 'dt_atualiza':
                    $set .= $campo . "='" . DATAHORAMYSQL . "', ";
                    break;
                default:
                    $set .= $campo . "='" . addslashes($this->{$variavel}) . "', ";
            }
        }
        $sql .= substr(trim($set), 0, -1) . " ";
        $sql .= "WHERE  " . $this->tabelaId . " = " . $this->{$this->arrCampos[$this->tabelaId]};
        $rs = executaSql($sql);
        return true;
    }

    ##################################
    # EXCLUIR (delete)
    ##################################

    public function excluir() {
        $sql = "DELETE
                    FROM   " . $this->tabelaNome . "
                    WHERE  " . $this->tabelaId . " = " . $this->{$this->arrCampos[$this->tabelaId]};
        $rs = executaSql($sql);
        return true;
    }

    ##################################
    # LISTAR (select)
    ##################################

    public static function listar($objeto, $filtro = "", $campos = "*") {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $tabelaId = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelaid'];
        $sql = "SELECT " . $campos . " 
                    FROM   " . $tabelaNome . "
                    " . $filtro;
        $rs = executaSql($sql);
        $arrLista = array();
        while ($rg = $rs->fetchRow()) {
            foreach ($rg as $campo => $valor) {
                $arrLista[$rg[$tabelaId]][$campo] = $valor;
            }
        }
        return (count($arrLista) > 0) ? $arrLista : false;
    }

    ##################################
    # LISTAR Por Outro Campo
    ##################################

    public static function listarBy($objecto, $where = "", $campos = "*") {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objecto)]['infotabela']['tabelanome'];
        $sql = "SELECT " . $campos . " 
        FROM   " . $tabelaNome . "
        " . $where;
        $rs = executaSql($sql);
        $arrLista = array();
        $cont = 0;
        while ($rg = $rs->fetchRow()) {
            foreach ($rg as $campo => $valor) {
                $arrLista[$cont][$campo] = $valor;
            }
            $cont++;
        }
        return (count($arrLista) > 0) ? $arrLista : false;
    }

    ##################################
    # CONTAR (select)
    ##################################
    public static function contar($objeto, $filtro = "", $campos = "id",$debug=false) {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $sql = "SELECT COUNT(" . $campos . ") AS total
                    FROM   " . $tabelaNome . "
                    " . $filtro;
        if($debug){
            die($sql);
        }
        $rs = executaSql($sql);
        $rg = $rs->fetchRow();
        return $rg['total'];
    }
    
    ##################################
    # SOMAR (select)
    ##################################
    public static function somar($objeto, $filtro = "", $campos = "id",$debug=false) {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $sql = "SELECT SUM(" . $campos . ") AS total
                    FROM   " . $tabelaNome . "
                    " . $filtro;
        if($debug){
            die($sql);
        }
        $rs = executaSql($sql);
        $rg = $rs->fetchRow();
        return $rg['total'];
    }
    
    ##################################
    # MEDIA (select)
    ##################################
    public static function media($objeto, $filtro = "", $campos = "id",$debug=false) {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $sql = "SELECT AVG(" . $campos . ") AS total
                    FROM   " . $tabelaNome . "
                    " . $filtro;
        if($debug){
            die($sql);
        }
        $rs = executaSql($sql);
        $rg = $rs->fetchRow();
        return $rg['total'];
    }
    
    ##################################
    # MAIOR (select)
    ##################################
    public static function maior($objeto, $filtro = "", $campos = "id",$debug=false) {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $sql = "SELECT MAX(" . $campos . ") AS total
                    FROM   " . $tabelaNome . "
                    " . $filtro;
        if($debug){
            die($sql);
        }
        $rs = executaSql($sql);
        $rg = $rs->fetchRow();
        return $rg['total'];
    }
    
    ##################################
    # MENOR (select)
    ##################################
    public static function menor($objeto, $filtro = "", $campos = "id",$debug=false) {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $sql = "SELECT MIN(" . $campos . ") AS total
                    FROM   " . $tabelaNome . "
                    " . $filtro;
        if($debug){
            die($sql);
        }
        $rs = executaSql($sql);
        $rg = $rs->fetchRow();
        return $rg['total'];
    }

    ##################################
    # GET FIRST (select) current
    ##################################

    public static function getFirst($objeto, $filtro = "", $campos = "*") {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $tabelaId = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelaid'];
        $sql = "SELECT " . $campos . " 
                    FROM   " . $tabelaNome . "
                    " . $filtro;
        // echo '<br>'.$sql.'<br>';
        $rs = executaSql($sql);
        $arrLista = array();
        while ($rg = $rs->fetchRow()) {
            foreach ($rg as $campo => $valor) {
                $arrLista[$rg[$tabelaId]][$campo] = $valor;
            }
        }
        return (count($arrLista) > 0) ? current($arrLista) : false;
    }

    ##################################
    # GET CAMPO (select)
    ##################################

    public static function getCampo($objeto, $campo, $filtro = "", $campoAs="") {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $sql = "SELECT " . $campo . " 
                    FROM   " . $tabelaNome . "
                    " . $filtro;
        $campoAs = ($campoAs!="")?$campoAs:$campo;
        $rs = executaSql($sql);
        $rg = $rs->fetchRow();
        return $rg[$campoAs];
    }

    ##################################
    # SET CAMPO (select)
    ##################################
    public static function setCampo($objeto, $campo, $valor, $filtro = "", $calculo = false) {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        if ($calculo) {
            $sql = "UPDATE " . $tabelaNome . " SET " . $campo . " = " . $valor . " " . $filtro;
        } else {
            $sql = "UPDATE " . $tabelaNome . " SET " . $campo . " = '" . addslashes($valor) . "' " . $filtro;
        }
        if (executaSql($sql)) {
            return true;
        } else {
            return false;
        }
    }

    ##################################
    # LISTA SIMPLES (select)
    ##################################
    public static function getArrList($objeto, $campo = "", $filtro = "", $idCampo = "id") {
        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $sql = "SELECT " . $idCampo . "," . $campo . "
                    FROM   " . $tabelaNome . "
                                    " . $filtro;
        $rs = executaSql($sql);
        $arrLista = array();
        while ($rg = $rs->fetchRow()) {
            $arrLista[$rg[$idCampo]] = $rg[$campo];
        }
        return (count($arrLista) > 0) ? $arrLista : false;
    }
    
    ##################################
    # LIMPAR (delete)
    ##################################

    public static function limpar($objeto, $filtro = "") {

        $tabelaNome = $_SESSION[SESSAO]['tabelas'][DB_PREFIX.strtolower($objeto)]['infotabela']['tabelanome'];
        $sql = "DELETE FROM   " . $tabelaNome . " " . $filtro;
        $rs = executaSql($sql);
        return true;
    }

    ##################################
    # ATUALIZA ID DO OBJETO
    ##################################

    public function atualizaId() {

        $sql = "SELECT MAX(" . $this->tabelaId . ") ultimo FROM " . $this->tabelaNome;
        $rs = executaSql($sql);
        $rg = $rs->fetchRow();
        $this->{$this->arrCampos[$this->tabelaId]} = $rg['ultimo'];
        
    }

    ##################################
    # PEGA EXTENSAO DO ARQUIVO
    ##################################

    public static function getExtensao($nomeArquivo) {
        $arr = explode(".", $nomeArquivo);
        $extensao = end($arr);
        return $extensao;
    }

    

    ##################################
    # UPLOAD
    ##################################

    public static function upload($files, $dir, $name = "") {

        $extensao = Exec::getExtensao($files['name']);

        if ($name == '') {
            $nome = str_replace($extensao, '', seoLink($files['name']));
        } else {
            $nome = seoLink($name);
        }

        $novoNome = $nome . "." . $extensao;

        if (move_uploaded_file($files['tmp_name'], $dir . $novoNome)) {
            return $novoNome;
        } else {
            return false;
        }
    }

    ##################################
    # DEBUG
    ##################################

    public function debug() {
        echoArray($this);
    }

}

?>