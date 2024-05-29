<div class="modal otherModal fade " id="cadastroFilial" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados da filial</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroFilial" class="form-controls">
            <input type="hidden" name="IDFilial" value="">
            <input type="hidden" name="empresa" value="<?=$_SESSION['login']['empresa']?>">
            <div class="col-sm-12 row">
              <div class="col-sm-6">
                <label>Nome</label>
                <input type="name" name="nome" class="form-control" minlength="9" maxlength="100">
                <div class="error-input text-danger">
                  Preenchimento incorreto!
                </div>
              </div>
              <div class="col-sm-6">
                <label>Telefone</label>
                <input type="tel" name="telefone" class="form-control" minlength="1" maxlength="16">
                <div class="error-input text-danger">
                  Preenchimento incorreto!
                </div>
              </div>
            </div>
            <div class="col-sm-12 row">
              <div class="col-sm-4">
                  <label>CEP</label>
                  <input type="text" name="cep" class="form-control" minlength="9">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-4">
                  <label>UF</label>
                  <select name="uf" class="form-control">
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                  </select>
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-4">
                  <label>Cidade</label>
                  <input type="name" name="cidade" class="form-control"  minlength="3" maxlength="50">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
            </div>
            <div class="col-sm-12 row">
              <div class="col-sm-4">
                  <label>Bairro</label>
                  <input type="name" name="bairro" class="form-control"  minlength="3" maxlength="50">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-4">
                  <label>Rua</label>
                  <input type="name" name="rua" class="form-control" minlength="3" maxlength="50">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-4">
                  <label>Numero</label>
                  <input type="text" name="numero" class="form-control" minlength="1" maxlength="5">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_filial">Salvar</button>
        <!-- <button type="button" class="btn btn-danger bt_excluir_filial">Excluir</button> -->
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
