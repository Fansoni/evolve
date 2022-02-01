

<form class="pd10 mt20">
    <div class="row form-group">
        <div class="col-3">
            <label>Nome</label>
            <input type="text" class="form-control" />
        </div>
        <div class="col-3">
            <label>Tipo Pessoa</label>
            <select type="text" class="form-control">
                <option value="">Selecione</option>
                <option value="F">Física</option>
                <option value="J">Jurídica</option>
            </select>
        </div>
        <div class="col-3">
            <label>Estado</label>
            <select type="text" class="form-control">
                <option value="">Selecione</option>
                <?php
                if($arrEstados){
                    foreach($arrEstados as $idEstado => $ddEstado){
                        ?>
                        <option value="<?=$idEstado?>"><?=$ddEstado['sigla']." - ".$ddEstado['nome']?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-3">
            <label>&nbsp;</label>
            <input class="left w100 btn btn-primary" type="submit" value="FILTRAR" >
        </div>
    </div>
</form>
<hr>
<a href="" class="right btn btn-sm btn-success mb10">NOVO</a>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($arrUsuario){
            foreach($arrUsuario as $idUsuario => $ddUsuario){
                ?>
                <tr>
                    <td><?=$idUsuario?></td>
                    <td><?=$ddUsuario['nome']?></td>
                    <td><?=$ddUsuario['email']?></td>
                    <td><?=$ddUsuario['telefone']?></td>
                    <td><?=$ddUsuario['id_estado']?></td>
                    <td>
                        <a href="<?=URLRAIZ?>teste/usuario/gerenciar/<?=$idUsuario?>">Editar</a>
                        <a href="<?=URLRAIZ?>teste/usuario/excluir/<?=$idUsuario?>">Excluir</a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>




