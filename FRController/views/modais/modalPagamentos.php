<div class="modal otherModal fade " id="cadastroPagamento" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do Método de Pagamento</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroPagamento" class="form-controls">
          <input type="hidden" name="IDPagamento" value="">
            <div class="row">
                <div class="col-sm-3 nomeMetodo">
                    <label for="nomeMetodo">Nome</label>
                    <input type="text" class="form-control" name="nomeMetodo" minlength="1" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-3 metodoMetodo">
                    <label for="metodoMetodo">Método</label>
                    <select class="form-control" name="metodoMetodo">
                        <option value="1">Pix</option>
                        <option value="2">Cartão de crédito</option>
                        <option value="3">Cartão de débito</option>
                        <option value="4">Dinheiro</option>
                        <option value="5">Boleto</option>
                    </select>
                </div>
                <div class="col-sm-2 descontoMetodo">
                    <label for="descontoMetodo">Desconto</label>
                    <input type="text" name="descontoMetodo" class="form-control">
                </div>
                <div class="col-sm-2 tipoMetodo">
                    <label for="tipoMetodo" style="visibility:hidden;">tipo</label>
                    <select class="form-control" name="tipoMetodo">
                        <option value="0"></option>
                        <option value="1">%</option>
                        <option value="2">R$</option>
                    </select>
                </div>
                <div class="col-sm-2 parcelasMetodo">
                    <label for="parcelasMetodo">Parcelas</label>
                    <input type="text" name="parcelasMetodo" class="form-control numbers">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-2 jurosMetodo">
                    <label for="parcelasMetodo">Juros/Taxas(%)</label>
                    <input type="text" name="jurosMetodo" class="form-control juros" value="0">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
      <?php if(Autenticacao::userPerm(2,"PAG")):?><button type="button" class="btn btn-fr bt_salvar_pagamento">Salvar</button><?php endif;?>
      <?php if(Autenticacao::userPerm(3,"PAG")):?><button type="button" class="btn btn-danger bt_excluir_pagamento">Excluir</button><?php endif;?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
