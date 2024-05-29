<div class="modal otherModal fade " id="cadastroPromo" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados da Promoção</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroPromo" class="form-controls">
          <input type="hidden" name="IDPromocao">
            <div class="row">
                <div class="col-sm-12 input">
                    <label for="nomePromo">Nome</label>
                    <input type="name" name="nomePromo" class="form-control" minlength="3" maxlength="20">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 input">
                    <label for="inicioPromo">Inicio</label>
                    <input type="datetime-local" name="inicioPromo" class="form-control" minlength="10" maxlength="10">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-4 input">
                    <label for="fimPromo">FIM</label>
                    <input type="datetime-local" name="fimPromo" class="form-control" minlength="10" maxlength="10">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-2 select">
                    <label for="tipoPromo" style="visibility:hidden;">tipo</label>
                    <select class="form-control" name="tipoPromo">
                        <option value="">Selecione</option>
                        <option value="R$">R$</option>
                        <option value="%">%</option>
                    </select>
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-2 input">
                    <label for="descontoPromo">Desconto</label>
                    <input type="text" name="descontoPromo" class="form-control" minlength="1" maxlength="10">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <?php if(Autenticacao::userPerm(2,"PRM")):?><button type="button" class="btn btn-fr bt_salvar_promocao">Salvar</button><?php endif?>
        <?php if(Autenticacao::userPerm(3,"PRM")):?> <button type="button" class="btn btn-danger bt_excluir_promocao">Excluir</button><?php endif?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
