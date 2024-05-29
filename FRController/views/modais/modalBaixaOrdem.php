<div class="modal otherModal fade " id="baixaOrdem" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Finalizar Serviço</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="w-100">
            <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
            <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
            <div class="wrapper-nav">
                <nav class="nav nav-tabs list mt-2 navegassaum" id="myTab" role="tablist">
                    <a class="nav-item nav-link pointer active text-black finalnav" data-bs-target="#finalizassao" data-bs-toggle="tab" role="tab" aria-controls="public" aria-selected="true">Finalização</a>
                    <a class="nav-item nav-link pointer text-black notanav" data-bs-target="#nota" role="tab" data-bs-toggle="tab">Nota</a>
                    <a class="nav-item nav-link pointer text-black dadosdoclientenav" data-bs-target="#dadoscliente" role="tab" data-bs-toggle="tab">Dados do Cliente</a>
                </nav>
            </div>
            <div class="tab-content p-3" id="myTabContent">
                <!-----CADASTRO---->
                <div role="tabpanel" class="tab-pane fade active show mt-2 finalisassao" id="finalizassao" aria-labelledby="public-tab" >
                  
                </div>
                <!-----REPOSIÇÕES---->
                <div class="tab-pane fade mt-2" id="nota" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
                    <form class="form-group" id="formBaixaOrdem">
                      <input type="hidden" name="IDOrdem">
                      <input type="hidden" name="IDColaborador">
                      <input type="hidden" name="IDCliente">
                      <br>
                      <div class="col-sm-12">
                      <label for="justificativaDespesa">Descrição do Serviço</label>
                        <textarea class="form-control" rows="5" name="ultimatoServico" minlength="10" maxlength="2000"></textarea>
                        <div class="error-input text-danger">
                            Preenchimento incorreto!
                        </div>
                      </div>
                    </form>
                </div>
                <!-----DADOS DO CLIENTE---->
                <div class="tab-pane fade mt-2 dadoscli" id="dadoscliente" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
                    
                </div>
                <!-------------------------->
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_baixar_ordem">Finalizar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>