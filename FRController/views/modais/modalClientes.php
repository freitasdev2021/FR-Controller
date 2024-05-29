<div class="modal otherModal fade " id="cadastroCliente" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do Cliente</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="w-100">
            <!--HEADER NAV-->
            <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
            <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
            <div class="wrapper-nav">
                <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
                    <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#dados" role="tab" aria-controls="public" aria-selected="true">Dados</a>
                    <a class="nav-item nav-link pointer text-black" data-bs-target="#compras" role="tab" data-bs-toggle="tab">Compras</a>
                    <a class="nav-item nav-link pointer text-black" data-bs-target="#servicos" role="tab" data-bs-toggle="tab">Serviços</a>
                </nav>
            </div>
            <!--BODY-->
            <div class="tab-content" id="myTabContent">
                <!--CADASTRO DO CLLIENTE-->
                <div role="tabpanel" class="tab-pane fade active show mt-2" id="dados" aria-labelledby="public-tab" >
                  <form id="formCadastroClientes" class="form-controls">
                    <input type="hidden" name="IDCliente">
                      <div class="row">
                          <div class="col-sm-6 input">
                              <label for="nomeCliente">Nome</label>
                              <input name="nomeCliente" type="name" class="form-control" minlength="10" maxlength="45">
                              <div class="error-input text-danger">
                                Preenchimento incorreto!
                              </div>
                          </div>
                          <div class="col-sm-6 input">
                              <label for="emailCliente">Email( Não Obrigatório)</label>
                              <input type="email" name="emailCliente" class="form-control norequire" minlength="5" maxlength="60">
                              <div class="error-input text-danger">
                                Preenchimento incorreto!
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-sm-6 input">
                              <label for="telefoneCliente">Telefone</label>
                              <input type="tel" name="telefoneCliente" class="form-control" minlength="16">
                              <div class="error-input text-danger">
                                Preenchimento incorreto!
                              </div>
                          </div>
                          <div class="col-sm-6 cpfCnpj">
                              <label for="cpfCliente">CPF( Não Obrigatório)</label>
                              <input type="text" name="cpfCliente" class="form-control norequire" minlength="14">
                              <div class="error-input text-danger">
                                Preenchimento incorreto!
                              </div>
                          </div>
                      </div>
                  </form>
                </div>
                <!--COMPRAS FEITAS-->
                <div class="tab-pane fade mt-2" id="compras" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
                 
                </div>
                <!--SERVICOS CONSUMIDOS-->
                <div class="tab-pane fade mt-2" id="servicos" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
                 
                </div>
                <!---->
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <?php if(Autenticacao::userPerm(2,"CLI")):?><button type="button" class="btn btn-fr bt_salvar_cliente">Salvar</button><?php endif;?>
        <?php if(Autenticacao::userPerm(3,"CLI")):?><button type="button" class="btn btn-danger bt_excluir_cliente">Excluir</button><?php endif;?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
