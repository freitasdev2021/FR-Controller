<div class="modal otherModal fade " id="cadastroFornecedor" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do Fornecedor</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-controls" id="formCadastroFornecedores">
            <input type="hidden" name="IDFornecedor" value="">
            <div class="row">
                <div class="col-sm-6 input">
                    <label for="nomeFornecedor">Nome</label>
                    <input type="name" name="nomeFornecedor" class="form-control" minlength="5" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-6 input">
                    <label for="emailFornecedor">Email</label>
                    <input type="email" name="emailFornecedor" class="form-control" minlength="5" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 input">
                    <label for="telefoneFornecedor">Telefone</label>
                    <input type="text" name="telefone" class="form-control" minlength="14" maxlength="15">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-3 input">
                    <label for="cepFornecedor">CEP</label>
                    <input type="text" name="cepFornecedor" class="form-control" minlength="9" maxlength="9">
                    <div class="error-input text-danger">
                      P.incorreto!
                    </div>
                </div>
                <div class="col-sm-3 input">
                    <label for="ufFornecedor">UF</label>
                    <input type="name" name="ufFornecedor" class="form-control" minlength="2" maxlength="2">
                    <div class="error-input text-danger">
                      P.incorreto!
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 input">
                    <label for="cidadeFornecedor">Cidade</label>
                    <input type="name" name="cidadeFornecedor" class="form-control" minlength="3" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-6 input">
                    <label for="bairroFornecedor">Bairro</label>
                    <input type="name" name="bairroFornecedor" class="form-control" minlength="3" maxlength="50">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 input">
                    <label for="ruaFornecedor">Rua</label>
                    <input type="name" name="ruaFornecedor" class="form-control" minlength="2" maxlength="60">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-2 input">
                    <label for="numeroFornecedor">Número</label>
                    <input type="text" name="numeroFornecedor" class="form-control numbers" minlength="1" maxlength="4">
                    <div class="error-input text-danger">
                      P.incorreto!
                    </div>
                </div>
                <div class="col-sm-5 input">
                    <label for="complementoFornecedor">Complemento</label>
                    <input type="name" name="complementoFornecedor" class="form-control" minlength="0" maxlength="100">
                    <div class="error-input text-danger">
                      Preenchimento incorreto!
                    </div>
                </div>
            </div>
            <!-- <hr width="100%">
            <div class="col-sm-12">
            <iframe 
              src="https://maps.googleapis.com/maps/api/staticmap?size=512x512&maptype=roadmap\&markers=size:mid%7Ccolor:red%7CSan+Francisco,CA%7COakland,CA%7CSan+Jose,CA&key=AIzaSyDgzq_AMlVJCtwWjUMVA1PZOQZh8Grf4kU&signature=aa"
              width="100%" 
              height="450" 
              >
            </iframe>
            </div> -->
        </form>
      </div>
      <div class="modal-footer">
      <?php if(Autenticacao::userPerm(2,"FOR")):?><button type="button" class="btn btn-fr bt_salvar_fornecedor">Salvar</button><?php endif;?>
        <?php if(Autenticacao::userPerm(3,"FOR")):?><button type="button" class="btn btn-danger bt_excluir_fornecedor">Excluir</button><?php endif?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>