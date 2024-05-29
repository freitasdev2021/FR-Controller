<div class="modal otherModal fade " id="cadastroServicos" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do Serviço</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-controls" id="formCadastroServicos">
          <input type="hidden" name="IDServico">
          <div class="col-sm-12 row">
            <!--TIPO DO SERVICO-->
            <div class="col-sm-10 input">
                <label for="numeroCaixa">Tipo do Serviço</label>
                <input type="name" name="tipoServico" class="form-control" minlength="3" maxlength="50">
                <div class="error-input text-danger">
                    Preenchimento incorreto!
                </div>
            </div>
            <div class="col-sm-2 money">
                <label for="numeroCaixa">Mão de Obra</label>
                <input type="name" name="valorBase" class="form-control norequire" minlength="1" maxlength="10">
                <div class="error-input text-danger">
                    Preenchimento incorreto!
                </div>
            </div>
            <!---VALOR DO SERVIÇO-->
          </div>
          <div class="col-sm-12 row">
            <div class="col-sm-6">
                <label for="numeroCaixa">Garantia</label>
                <select name="tipoGarantia" class="form-control">
                    <option value="D">Dias</option>
                    <option value="M">Meses</option>
                    <option value="A">Anos</option>
                </select>
                <div class="error-input text-danger">
                    Preenchimento incorreto!
                </div>
            </div>
            <div class="col-sm-6">
                <label for="numeroCaixa">Tempo</label>
                <input type="text" name="tempoGarantia" class="form-control numbers" minlength="1" maxlength="3">
                <div class="error-input text-danger">
                    Preenchimento incorreto!
                </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      <?php if(Autenticacao::userPerm(2,"SER")):?><button type="button" class="btn btn-fr bt_salvar_servico">Salvar</button><?php endif;?>
      <?php if(Autenticacao::userPerm(3,"SER")):?><button type="button" class="btn btn-danger bt_excluir_servico">Excluir</button><?php endif;?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>