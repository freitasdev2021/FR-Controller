<div class="modal otherModal fade " id="cadastroPonto" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do PDV</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="w-100">
            <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
            <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
            <div class="wrapper-nav">
                <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
                    <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#dados" role="tab" aria-controls="public" aria-selected="true">Dados</a>
                    <a class="nav-item nav-link pointer text-black" data-bs-target="#vendas" role="tab" data-bs-toggle="tab">Vendas</a>
                    <!-- <a class="nav-item nav-link pointer text-black" data-bs-target="#tab4" role="tab" data-bs-toggle="tab">Crediário</a> -->
                </nav>
            </div>
            <div class="tab-content p-3" id="myTabContent">
                <!-----CADASTRO DO CAIXA-------->
                <div role="tabpanel" class="tab-pane fade active show mt-2" id="dados" aria-labelledby="public-tab" >
                  <form class="form-controls" id="formCadastroPonto">
                      <input type="hidden" name="IDPonto">
                      <div class="col-sm-12 row">
                          <div class="col-sm-6">
                              <label for="numeroCaixa">Nome do PDV</label>
                              <input type="text" name="nomePonto" class="form-control" minlength="3" maxlength="10">
                              <div class="error-input text-danger">
                                  Preenchimento incorreto!
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <label for="numeroCaixa">Senha do PDV</label>
                              <input type="password" name="senhaPonto" class="form-control" minlength="3" maxlength="10">
                              <div class="error-input text-danger">
                                  Preenchimento incorreto!
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
                <!-----VENDAS DO CAIXA---->
                <div class="tab-pane fade mt-2" id="vendas" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
                 
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
      <?php if(Autenticacao::userPerm(2,"PON")):?><button type="button" class="btn btn-fr bt_salvar_ponto">Salvar</button><?php endif;?>
      <?php if(Autenticacao::userPerm(3,"PON")):?><button type="button" class="btn btn-danger bt_excluir_ponto">Excluir</button><?php endif;?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>