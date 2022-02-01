<?php

class Relatorio {

    // public function __construct($params = "") {
    //     parent::__construct(strtolower(get_class()), $params);
    // }

    private function select($ano = 2020, $natureza_conta = 'D', $tipo_valor)
    {
        return "SELECT conta_contabil, cod_ibge, mes_referencia, SUM(valor) AS valor
        FROM teste_tesouro_lancamento_msc_{$ano}_cod_12
        WHERE tipo_valor  = '{$tipo_valor}'
        AND natureza_conta = '{$natureza_conta}'
        GROUP BY conta_contabil, cod_ibge, mes_referencia";
    }

    public static function filtrar($post="", $filtroExtra="") {
        $relatorio = new Relatorio();
        $filtro = " ";
        
        $sql = "SELECT conta.*, (inicial_credito.valor - inicial_debito.valor) AS inicial, (movimento_credito.valor - movimento_debito.valor) AS movimento, (final_credito.valor - final_debito.valor) AS final
        FROM 
        (
            {$relatorio->select($post["exercicio"], 'D', 'beginning_balance')}
        ) AS inicial_debito,
        (
            {$relatorio->select($post["exercicio"], 'C', 'beginning_balance')}
        ) AS inicial_credito,
        (
            {$relatorio->select($post["exercicio"], 'D', 'period_change')}
        ) AS movimento_debito,
        (
            {$relatorio->select($post["exercicio"], 'C', 'period_change')}
        ) AS movimento_credito,
        (
            {$relatorio->select($post["exercicio"], 'D', 'ending_balance')}
        ) AS final_debito,
        (
            {$relatorio->select($post["exercicio"], 'C', 'ending_balance')}
        ) AS final_credito, teste_tesouro_conta AS conta
        WHERE inicial_credito.cod_ibge = inicial_debito.cod_ibge
        AND inicial_credito.conta_contabil = inicial_debito.conta_contabil
        AND inicial_credito.mes_referencia = inicial_debito.mes_referencia
        AND inicial_credito.cod_ibge = {$post['cidade_id']}
        AND inicial_credito.mes_referencia = {$post['mes']}
        AND conta.id = inicial_credito.conta_contabil
        
        AND movimento_credito.cod_ibge = movimento_debito.cod_ibge
        AND movimento_credito.conta_contabil = movimento_debito.conta_contabil
        AND movimento_credito.mes_referencia = movimento_debito.mes_referencia
        AND movimento_credito.cod_ibge = {$post['cidade_id']}
        AND movimento_credito.mes_referencia = {$post['mes']}
        AND conta.id = movimento_credito.conta_contabil
        
        AND final_credito.cod_ibge = final_debito.cod_ibge
        AND final_credito.conta_contabil = final_debito.conta_contabil
        AND final_credito.mes_referencia = final_debito.mes_referencia
        AND final_credito.cod_ibge = {$post['cidade_id']}
        AND final_credito.mes_referencia = {$post['mes']}
        AND conta.id = final_credito.conta_contabil";

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
    
}
