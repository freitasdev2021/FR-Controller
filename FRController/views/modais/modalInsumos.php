<div class="modal otherModal fade " id="cadastroInsumos" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do Insumo</h5>
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
                    <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Cadastro</a>
                    <a class="nav-item nav-link pointer text-black menu-reposicoes" data-bs-target="#tab2" role="tab" data-bs-toggle="tab">Reposições</a>
                </nav>
            </div>
            <div class="tab-content p-3" id="myTabContent">
                <!-----CADASTRO---->
                <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
                  <form class="form-group" id="formCadastroInsumos">
                    <input type="hidden" name="IDInsumo">
                        <!--PERGUNTA SOBRE O CODIGO DE BARRAS-->
                        <div class="row">

                        <div class="col-sm-4">
                            <label for="possuiCodigo">Identificação</label>
                            <select name="identificacao" class="form-control">
                                <option value="">Selecione</option>
                                <option value="CB">Código de barras</option>
                                <option value="ID">Identificador</option>
                            </select>
                        </div>

                        <div class="col-sm-8 input">
                        <label for="codigoInsumo" style="visibility:hidden;">Identificação do Insumo</label>
                            <input type="text" class="form-control numbers" name="codigoInsumo" minlength='13' maxlength='13'>
                            <div class="error-input text-danger">
                                Preenchimento incorreto!
                            </div>
                        </div>
                        </div>
                        <!--LINHA DIVISORIA-->
                        <hr>
                        <!--LINHA 1-->
                        <div class="row">
                            <div class="col-sm-6 input">
                                <label for="nomeInsumo">Insumo</label>
                                <input type="text" class="form-control" name="nomeInsumo" minlength='5' maxlength="20">
                                <div class="error-input text-danger">
                                    Preenchimento incorreto!
                                </div>
                            </div>
                            <div class="col-sm-6 input">
                                <label for="categoriaInsumo">Categoria</label>
                                <input type="name" class="form-control" list="categorias" name="categoriaInsumo" minlength='5' maxlength="20">
                                <datalist id="categorias">
                                    <?php
                                    foreach(Produtos::getCategorias($_SESSION['login']['filial']) as $c){
                                    extract($c);
                                    ?>
                                    <option value="<?=$DSCategoria?>">
                                    <?php
                                    }
                                    ?>
                                </datalist>
                                <div class="error-input text-danger">
                                Preenchimento incorreto!
                                </div>
                            </div>
                        </div>
                        <!---LINHA 2--->
                        <div class="row">
                            <div class="col-sm-6 select">
                                <label for="fornecedorInsumo">Fornecedor</label>
                                <select name="fornecedorInsumo" class="form-control">
                                    <option value="">Selecione</option>
                                    <?php
                                    foreach($selectFornecedores as $forn){
                                    ?>
                                    <option value="<?=$forn['IDFornecedor'];?>"><?=$forn['NMFornecedor'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="error-input text-danger">
                                    Preenchimento incorreto!
                                </div>
                            </div>
                            <div class="col-sm-3 input">
                                <label for="garantiaInsumo">Garantia</label>
                                <select name="garantiaInsumo" class="form-control norequire" minlength="1">
                                    <option value="">Selecione</option>
                                    <option value="D">Dias</option>
                                    <option value="M">Meses</option>
                                    <option value="A">Anos</option>
                                </select>
                            </div>
                            <div class="col-sm-1 input">
                                <label for="entradaInsumo" style="visibility:hidden">A</label>
                                <input type="text" class="form-control numbers norequire" name="qtValidade" minlength='1'>
                            </div>
                            <div class="col-sm-2 input">
                                <label for="estoqueInsumo">Estoque.min</label>
                                <input type="text" minlength="1" maxlength="5" class="form-control numbers" name="estoqueMinimo">
                                <div class="error-input text-danger">
                                    P.incorreto!
                                </div>
                            </div>
                            <div class="col-sm-12 input row">
                                <!---->
                                <div class="col-sm-2 input">
                                    <label for="estoqueInsumo">Estoque</label>
                                    <input type="text" minlength="1" maxlength="5" class="form-control numbers" name="estoqueInsumo">
                                    <div class="error-input text-danger">
                                        P.incorreto!
                                    </div>
                                </div>
                                <!---->
                                <div class="col-sm-3 tipoInsumo">
                                    <label for="tipoInsumo">Tipo</label>
                                    <select name="tipoInsumo" class="form-control">
                                    <option value="UN">UN</option>
                                    <option value="KG">KG</option>
                                    <option value="M">M</option>
                                    </select>
                                    <div class="error-input text-danger">
                                        P.incorreto!
                                    </div>
                                </div>
                                <!---->
                                <div class="col-sm-2 money">
                                    <label for="custoInsumo">Custo</label>
                                    <input type="text" minlength='1' class="form-control" name="custoInsumo">
                                    <div class="error-input text-danger">
                                        P.incorreto!
                                    </div>
                                </div>
                                <!---->
                                <div class="col-sm-2 money">
                                    <label for="lucroProduto">Valor(R$)</label>
                                    <input type="text" minlength='1' class="form-control numbers norequire" name="valorFixo">
                                    <div class="error-input text-danger">
                                        P.incorreto!
                                    </div>
                                </div>
                                <!---->
                                <div class="col-sm-3 input">
                                    <label for="lucroInsumo">Lucro(%)</label>
                                    <input type="text" minlength='1' class="form-control numbers" name="lucroInsumo">
                                    <div class="error-input text-danger">
                                        P.incorreto!
                                    </div>
                                </div>
                                <!---->
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-12">
                            <input type="file" id="imagem-usuario" accept=".jpg,.png,.jpeg">
                        </div>
                        <!--LINHA 3-->
                        <input type="hidden" name="valorInsumo">
                        <input type="hidden" name="imagemInsumo">
                        <hr>
                        <div class="d-flex justify-content-center">
                        <img class="imagemInsumo" src="../img/noproduct.png" class="" width="100%" height="400px">
                        </div>
                        <!---->
                        <div class="col-sm-4">
                            <br>
                        <b class="text-right">Valor(R$):&nbsp;<b class="valorInsumo">0,00</b></b>
                        </div>
                    </form>
                </div>
                <!-----REPOSIÇÕES---->
                <div class="tab-pane fade mt-2" id="tab2" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
                <table class="table table-bordered text-center tabela tabela-reposicoes table-mobile-responsive ">
                    <thead>
                        <tr>
                            <th>Quantidade</th>
                            <th>Custo(R$)</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>    
                </table>
                </div>
                <!-----FIM---->
            </div>
        </div>
      </div>
      <div class="modal-footer">
       <?php if(Autenticacao::userPerm(2,"SER")):?><button type="button" class="btn btn-fr bt_salvar_Insumo">Salvar</button><?php endif?>
       <?php if(Autenticacao::userPerm(3,"SER")):?><button type="button" class="btn btn-danger bt_excluir_Insumo">Excluir</button><?php endif?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>