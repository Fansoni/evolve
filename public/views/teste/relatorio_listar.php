<div class="alert alert-success mt20" role="alert">
  <h4 class="alert-heading">Fansoni Noé António Muzanzo</h4>
  <p>Foi com grande honra que pude fazer parte desse processo de selecção, venho então submeter o resultado do meu teste.</p>
  <hr>
  <p class="mb-0">Vale dizer que foi um bom desafio que me obrigou aprofundar mais os meus conhecimentos.</p>
</div>
<div class="card mt20">
  <div class="card-header bg-primary text-white">
    FILTRAR DADOS
  </div>
  <div class="card-body">
    <form class="pd10" method="POST" action="" autocomplete="off">
        <div class="row form-group">
            <div class="col-3">
                <label>Exercício</label>
                <select name="exercicio" class="form-control">
                    <option value="" disabled selected>-- selecione uma opção --</option>
                    <?php for ($i=2017; $i < 2020; $i++) { ?>
                        <option value="<?php echo $i+1 ?>" <?php echo isset($post['exercicio'])?(($post['exercicio'] == ($i+1))?'selected':''):''; ?>><?php echo $i+1 ?></option>
                    <?php } ?>
                </select>
                <!-- <input type="number" min="2015" max="<?=date('Y')?>" class="form-control" value="2020" /> -->
            </div>
            <div class="col-3">
                <label>Mês Referência</label>
                <select name="mes" class="form-control">
                    <option value="" disabled selected>-- selecione o mês --</option>
                    <?php for ($i=0; $i < 12; $i++) { ?>
                        <option value="<?php echo $i+1 ?>" <?php echo isset($post['mes'])?(($post['mes'] == ($i+1))?'selected':''):''; ?>><?php echo $i+1 ?></option>
                    <?php } ?>
                </select>
                <!-- <input type="number" min="1" max="12" class="form-control" /> -->
            </div>
            <div class="col-3 entidade-federativa">
                <label>Entidade Federativa</label>
                <input value="<?php echo isset($post['cidade'])?$post['cidade']:''; ?>" name="cidade" oninput="buscarCidade()" id="cidade-field" type="text" class="form-control" />
                <ul id="cidade-result"></ul>
            </div>
            <div class="col-3">
                <label>&nbsp;</label>
                <input class="left w100 btn btn-primary" type="submit" value="FILTRAR" >
            </div>
        </div>
    </form>
  </div>
</div>
<hr>
<?php if($cidade != null){ ?>
<h3>Contas Contábeis - <?php echo $cidade['nome']; ?> [<?php echo $post['mes'] ?>/<?php echo $post['exercicio'] ?>]</h3>
<table class="table table-striped table-bordered table-hover" width="100%" style="font-size: 10px">
    <thead>
        <tr class="bg-primary text-white">
            <td>Conta </td>
            <td width="200px">Inicial</td>
            <td width="200px">Movimento</td>
            <td width="200px">Final</td>
        </tr>
    </thead>
    <tbody>
        <?php $grafo->buscaLargura(); ?>
    </tbody>
</table>
<?php }else{ ?>
    <p>Sem resultados</p>
<?php } ?>




