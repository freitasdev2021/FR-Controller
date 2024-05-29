<div class="modal otherModal fade " id="cadastroDevedor" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span>
        <h5 class="modal-title">Dados do Devedor</h5>
        <hr style='color:white;'>
        <p id="nomeDevedor" style='color:white;'></p>
        </span>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroDevedores" class="form-controls">
          <input type="hidden" name="IDDevedor" val="">
            <div class="row">
                <div class="col-sm-6 select">
                    <label for="devedorNome">Nome</label>
                    <select class="form-control" name="devedorNome">
                      <option value="">Selecione</option>
                        
                    </select>
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-6 money">
                    <label for="devedorDivida">Dívida</label>
                    <input type="text" name="devedorDivida" class="form-control" minlength="1" maxlength="10">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
      <?php if(Autenticacao::userPerm(2,"CLI")):?><button type="button" class="btn btn-fr bt_salvar_devedor">Salvar</button><?php endif;?>
      <?php if(Autenticacao::userPerm(3,"CLI")):?><button type="button" class="btn btn-danger bt_excluir_devedor">Excluir</button><?php endif;?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
