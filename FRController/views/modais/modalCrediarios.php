<div class="modal otherModal fade " id="cadastroCrediario" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span>
        <h5 class="modal-title">Dados do Crediário</h5>
        <hr style='color:white;'>
        <p id="nomeCrediario" style='color:white;'></p>
        </span>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroCrediarios" class="form-controls">
        <input type="hidden" name="IDCrediario" val="">
            <div class="row">
                <div class="col-sm-4 select">
                    <label for="crediarioNome">Nome</label>
                    <select class="form-control" name="nomeCrediario">
                    <option value="">Selecione</option>
                    
                    </select>
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-4 money">
                    <label for="creditoCrediario">Crédito</label>
                    <input type="text" name="creditoCrediario" class="form-control" minlength="1" maxlength="10">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-4 input">
                      <label for="crediarioAte">Até</label>
                      <input type="datetime-local" name="creditoAte" class="form-control" minlength="10">
                      <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_crediario">Salvar</button>
        <button type="button" class="btn btn-danger bt_excluir_crediario">Excluir</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
