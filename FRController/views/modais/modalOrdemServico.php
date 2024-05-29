<div class="modal otherModal fade " id="cadastroOrdemServico" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados da Ordem</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-controls" id="formOrdemServico">
          <div class="col-sm-12 row">
            <!--TIPO DO SERVICO-->
            <div class="col-sm-6 input">
                <label for="numeroCaixa">Tipo do Serviço</label>
                <select name="tipoServico" class="form-control">
                    <option value="">Selecione</option>
                    <?php
                    foreach($servicos as $s){
                    ?>
                    <option value='<?=$s['IDServico']?>'><?=$s['DSTipoServico']?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="error-input text-danger">
                    Preenchimento incorreto!
                </div>
            </div>
            <div class="col-sm-6 ">
                <label for="numeroCaixa">Cliente</label>
                <select name="nomeCliente" class="form-control">
                    <option value="">Selecione</option>
                    <?php
                    foreach($clientes as $c){
                    ?>
                    <option value='<?=$c['IDCliente']?>'><?=$c['NMCliente']?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="error-input text-danger">
                    Preenchimento incorreto!
                </div>
            </div>
            <!---VALOR DO SERVIÇO-->
          </div>
          <div class="col-sm-12">
            <label for="numeroCaixa">Prévia do Serviço</label>
            <input type="text" name="previaServico" class="form-control" minlength="5" maxlength="50">
            <div class="error-input text-danger">
                Preenchimento incorreto!
            </div>
          </div>
          <div class="col-sm-12 textarea">
            <label for="justificativaDespesa">Descrição do Serviço</label>
            <textarea class="form-control" rows="5" name="descricaoServico" minlength="10" maxlength="2000"></textarea>
            <div class="error-input text-danger">
                Preenchimento incorreto!
            </div>
         </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_ordemservico">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>