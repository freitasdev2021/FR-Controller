<div class="modal otherModal fade " id="cadastroUsuario" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cadastrar usuário</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroUsuarios" class="form-controls">
        <input type="hidden" name="IDUsuario" value="">
          <input type="hidden" name="statusUsuario" value="1">
            <label>Permissão do usuário:</label>
            <div class="col-sm-12 select">
              <select name="permissaoUsuario" class="form-control">
                <option value="">Selecione</option>
                <option value="3">Vendas</option>
                <option value="4">Marketing</option>
                <option value="5">Financeiro</option>
              </select>
              <div class="error-input text-danger">
                    Preenchimento incorreto!
              </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6 input">
                    <label for="nomeUsuario">Usuário</label>
                    <input type="name" name="nomeUsuario" class="form-control" minlength="5" maxlength="45">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-6 input">
                    <label for="emailUsuario">Email</label>
                    <input type="email" name="emailUsuario" class="form-control" minlength="5" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
            <div class="col-sm-12 input">
                  <label for="senhaUsuario">Senha</label>
                  <input type="password" name="senhaUsuario" class="form-control" minlength="5" maxlength="50">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
            </div>
            <div class="col-sm-12 confirmarSenha input">
                  <label for="confSenhaUsuario">Confirmar senha</label>
                  <input type="password" name="confSenhaUsuario" class="form-control" minlength="5" maxlength="50">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_usuario">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
