<div class="modal otherModal fade " id="cadastroProdutoPromo" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Produtos e Serviços Participantes</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroPromoProdutos" class="form-controls">
          <input type='hidden' name='IDPromo'>
            <table class="table table-bordered text-center ">
                <thead>
                    <tr>
                        <th class="col-sm-1">Vinculado</th>
                        <th>Produto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td class="text-break">Produto de teste</td>
                    </tr>
                </tbody>    
            </table>
        </form>
        <!-- <script src="js/datatablesGeral.js"></script> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_vincular_promocao">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
