<div class="modal otherModal fade " id="cadastroDespesa" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados da Despesa</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroDespesa" class="form-controls">
        <input type="hidden" name="IDContaPagar">
            <div class="row">
                <div class="col-sm-4 input">
                    <label for="contaDespesa">Nome da conta</label>
                    <input type="name" name="nomeContaPagar" class="form-control" minlength="5" maxlength="45">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
                </div>
                <div class="col-sm-4 money">
                    <label for="nomeDespesa">Valor(R$)</label>
                    <input type="text" name="valorContaPagar" class="form-control" minlength="1" maxlength="15">
                    <div class="error-input text-danger">
                      P.incorreto!
                    </div>
                </div>
                <div class="col-sm-4 input">
                  <label for="vencimentoDespesa">Vencimento</label>
                  <input type="datetime-local" name="vencimentoContaPagar" class="form-control" minlength="10" maxlength="10">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
                </div>
            </div>
            <div class="col-sm-12 textarea">
                <label for="justificativaDespesa">Sobre a despesa</label>
                <textarea class="form-control" rows="5" name="justificativaContaPagar" minlength="10"></textarea>
                <div class="error-input text-danger">
                  Preenchimento incorreto!
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_contapagar">Salvar</button>
        <button type="button" class="btn btn-danger bt_excluir_contapagar">Excluir</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
