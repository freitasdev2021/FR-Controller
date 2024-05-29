<div class="modal otherModal fade " id="cadastroCustos" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Custos</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroCustos" class="form-controls">
        <input type="hidden" name="IDOrdem" val="">
            <table class="table table-bordered text-center tabela-custos ">
                <thead>
                    <tr>
                        <th class="col-sm-1">Vinculado</th>
                        <th>Insumo</th>
                        <td>Quantidade</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td class="text-break">Produto de teste</td>
                        <td><input></td>
                    </tr>
                </tbody>    
            </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_custos">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
