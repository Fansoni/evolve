<?php include 'header.php' ?>

<section>
    <h3>Configuração</h3>
    <p>
        Salve a pasta do teste no seu diretório de projetos. (Ex: C:/wamp64/www/evolve-teste2)<br>
        Crie uma base de dados e importe o banco base_teste.sql que está na raiz do projeto(banco_teste/teste_modelo.rar).<br>
        No arquivo define_db.php (C:/wamp64/www/evolve-teste2/config/define_db.php):<br>
        &nbsp;&nbsp;- configure a pasta local do projeto (No exemplo estamos utilizando a pasta evolve-teste2)<br>
        &nbsp;&nbsp;- configure os dados do seu banco de dados local<br>
        Acesse o link do projeto (http://localhost/evolve-teste2/teste).<br>
        configurações php:<br>
            - testado com versão 7.4.9
            - short_open_tag = On<br>
            - error_reporting = E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED<br>
        configurações mysql:<br>
            - sql-mode=""<br>
    </p>
</section>

<section>
    
    <h3>Teste</h3>
    <p>
        Acesse o modulo teste, controle relatorio (http://localhost/evolve-teste2/teste/relatorio).<br>
        Este link carrega o arquivo relatorioControle.php na pasta controle/teste/<br><br>
        
        O link http://localhost/evolve-teste2/teste/ajax por exemplo <br>
        carrega o arquivo ajaxControle.php na pasta controle/teste/<br><br>
        
        O HTML fica na pasta public/views/teste/<br>
        O CSS fica na pasta public/css/<br>
        O JS fica na pasta public/js/<br>
        Utilizar estes arquivos caso necessário<br>
        
        <br>
        
        ###RELATORIO CONTABIL###<br>
        - Criar relatório contábil<br>
        - Filtro:<br>
        - Exercício: colocar opções de seleção de 2018 a 2020
        - Mês Referência: colocar opções de seleção de 1 a 12
        - Entidade Federativa: carregar opções de Estados ou Municipios por ajax consultando a tabela
        "teste_cidade_ibge" conforme usuário vai digitando<br>
        - Relatório:<br>
        - Criar listagem de contas de acordo com tabela "teste_tesouro_conta" 
        para substituir a tabela estática de exemplo no relatório atual por uma tabela carregada com os dados do banco de acordo com o filtro.<br>
        - Ao utilizar o filtro popular o resultado no relatório de contas contábeis a 
        partir de consulta na tabela "teste_tesouro_lancamento_msc_ANO_cod_12"<br>
        - O exemplo atual da tabela é o resultado da consula pela entidade federativa de cod_ibge 12 (Acre) no exercício
        de 2020 e mês de referência 12, notar que os valores das contas são obtidos com a soma dos lançamentos das
        subcontas, os lançamentos podem ser a Débito ou Crédito, a informação está na coluna natureza_conta como
        D (débito) e C (crédito)<br>
		- O valor total dos níveis superiores é a diferença do valor dos lançamentos nos seus respectivos subniveis, Ex:<br><br>
		
		- - Conta 1.0.0.0.00.10 Lançamento 1 = 100,00 (D)<br>
		- - Conta 1.0.0.0.00.10 Lançamento 2 =  50,00 (C)<br>
		- - Conta 1.0.0.0.00.10 Valor Total  =  50,00 (D)<br><br>
		
		- - Conta 1.0.0.0.00.20 Lançamento 1 = 200,00 (D)<br>
		- - Conta 1.0.0.0.00.20 Lançamento 2 = 250,00 (C)<br>
		- - Conta 1.0.0.0.00.20 Valor Total  =  50,00 (C)<br><br>
		
		- - Conta 1.0.0.1.00.00 (Soma lançamentos das contas inferiores)<br>
		- - Conta 1.0.0.0.00.10 Valor Total  =  50,00 (D)<br>
		- - Conta 1.0.0.0.00.20 Valor Total  =  50,00 (C)<br>
		- - Conta 1.0.0.1.00.00 Valor Total  =   0,00 (-)<br><br>
		
        - As colunas Inicial, Movimento e Final do relatório se referem 
        respectivamente as informações beginning_balance, period_change e ending_balance na coluna tipo_valor<br>
        - A tabela de lançamentos contém apenas dados do Acre (cod_ibge=12), 
        a tarefa é buscar os dados no banco e organizar para exibir com PHP a mesma tabela do exemplo que está em html no relatório
        <br>
    </p>
    
</section>

<section>
    <h3>Ajuda</h3>
    <p>
        <b>exemplos de parâmetros da url</b><br>
        http://localhost/evolve-teste2/teste/usuario/listar<br>
        $modulo = "teste";<br>
        $controle = "usuario";<br>
        $metodo = "listar";<br><br>
        http://localhost/evolve-teste2/teste/usuario/gerenciar/1<br>
        $modulo = "teste";<br>
        $controle = "usuario";<br>
        $metodo = "gerenciar";<br>
        $registro = "1";<br>
    </p>
    <p>
        <b>listar array registros da tabela (utilize o nome da tabela removendo prefixo e _)</b><br>
        Função: Exec::listar('tabela','filtro');<br>
        Exemplo: Listar registro id = 12 da tabela teste_cidade_ibge:<br>
         - $arrCidade = Exec::listar('cidadeibge','where id = 12 order by nome');<br>
        Nota: a chave de cada registro será o id <br>
        Nota 2: retorna o array de registros ou false caso não encontre 
    </p>
    <p>
        <b>ações com objeto (utilize o nome da tabela removendo prefixo e _ e iniciais em maiúsculo)</b><br>
        Exemplo:<br>
        INSERIR<br>
        $objCidadeIbge = new CidadeIbge();<br>
        $objCidadeIbge->carga(array('nome'=>'Teste','populacao'=>'12345678')); (seta dados no objeto)<br>
        $objCidadeIbge->inserir();<br>
        após $objCidadeIbge->inserir(); o $objUsuario->id estará atualizado com o id inserido<br><br>
        
        CARREGAR<br>
        $objUsuario = new Usuario();<br>
        $objUsuario->id = ID; (seta id)<br>
        $objUsuario->carregar(); (carrega dados do banco no objeto pelo ID)<br><br>
        
        EDITAR<br>
        $objUsuario = new Usuario();<br>
        $objUsuario->id = ID; (seta id)<br>
        $objUsuario->carregar(); (carrega dados do banco)<br>
        $objUsuario->carga(array('nome'=>'Teste Edita','email'=>'testeedita@mail.com')); (seta dados no objeto)<br>
        $objUsuario->alterar();<br><br>
        
        EXCLUIR<br>
        $objUsuario = new Usuario();<br>
        $objUsuario->id = ID; (seta id)<br>
        $objUsuario->excluir(); (carrega dados do banco)<br><br>
        
        <b>estes métodos são herdados da classe Exec (classes/Exec.php)</b><br>
        <b>podem ser sobrescritos ou pode-se criar novas funções na classe</b>
    </p>
   
    <p>
        Dúvidas enviar para suporte@segundoandar.com.br<br>
        Um Abraço!
        Equipe Evolve
    </p>
</section>


<?php include 'footer.php' ?>