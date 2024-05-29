<div class="modal otherModal fade " id="cadastroFuncionario" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cadastrar cliente</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-controls">
        <input type="hidden" name="IDEmpresaVinculo" value="1">
        <input type="hidden" name="IDUsuario" value="">
          <input type="hidden" name="statusUsuario" value="1">
            <div class="row">
                <div class="col-sm-6 usuario">
                    <label for="nomeUsuario">Usuário</label>
                    <input type="name" name="nomeUsuario" class="form-control" maxlength="45">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-6 emailUsuario">
                    <label for="emailUsuario">Email</label>
                    <input type="email" name="emailUsuario" class="form-control" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
            <div class="col-sm-12 senhaUsuario">
                    <label for="senhaUsuario">Senha</label>
                    <input type="password" name="senhaUsuario" class="form-control" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
            </div>
            <div class="col-sm-12 confirmarSenha">
                    <label for="confSenhaUsuario">Confirmar senha</label>
                    <input type="password" name="confSenhaUsuario" class="form-control" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_funcionario">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
