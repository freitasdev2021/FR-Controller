<div class="modal fade " id="devolucaoProduto" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title titulo text-white">Devolver produto</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formDevolucao">
                <input type="hidden" name="QTVendas" value="">
                <input type="hidden" name="IDVenda" value="">
                <div class="col-sm-12">
                    <label>Quantidade</label>
                    <input type="number" class="form-control" name="QTDevolucao">
                </div>
            </form>
      </div>
      <div class="modal-footer botoes">
      <button class="btn btn-fr bt-repor">Repor</button>
        <button class="btn btn-fr bt-descartar">Descartar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
