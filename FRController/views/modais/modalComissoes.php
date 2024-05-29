<div class="modal otherModal fade " id="cadastroComissao" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados da Comissão</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroComissao" class="form-controls">
          <input type="hidden" name="IDComissao">
            <div class="row">
                <div class="col-sm-5">
                    <label for="inicioPromo">Nome da comissão</label>
                    <input type="name" name="nomeComissao" class="form-control" minlength="5" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="inicioPromo">Tipo da comissão</label>
                    <select name="tipoComissao" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Produto">Produto</option>
                        <option value="Servico">Servico</option>
                    </select>
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="fimPromo">Porcentagem</label>
                    <input type="text" name="porcentagemComissao" class="form-control numbers" minlength="1" maxlength="3">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_comissao">Salvar</button>
        <button type="button" class="btn btn-danger bt_excluir_comissao">Excluir</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
