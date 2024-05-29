<div class="modal otherModal fade " id="cadastroUsuariocli" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cadastrar Usuário</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroUsuario" class="form-controls">
          <!---->
          <input type="hidden" name="usuario_id" value="">
          <input type="hidden" name="status" value="">
          <input type="hidden" name="nivel" value="3.5">
          <input type="hidden" name="email">
          <input type="hidden" name="contrato" value="<?=$_SESSION['login']['contrato']?>">
          <div class="col-sm-12 row">
            <div class="col-sm-6">
              <label>Colaborador</label>
              <select name="colaborador" class="form-control">
                <option value="">Selecione</option>
                <?php
                foreach($col as $c){
                  echo "<option value=".$c['IDColaborador']." data-email=".$c['NMEmailColaborador'].">".$c['NMColaborador']."</option>";
                }
                ?>
              </select>
              <div class="error-input text-danger">
                Preenchimento incorreto!
              </div>
            </div>
            <div class="col-sm-6">
                <label>Usuário</label>
                <input type="text" name="nome" class="form-control" minlength="3" maxlength="100">
                <div class="error-input text-danger">
                  Preenchimento incorreto!
                </div>
            </div>
          </div>
          <div class="col-sm-12">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" minlength="5" maxlength="100">
                <div class="error-input text-danger">
                  Preenchimento incorreto!
                </div>
          </div>
          <hr>
          <h3 align="center" class="permTitle">Permissões</h3>
            <div class="col-sm-12 row permissoes">
              <!--PRODUTOS-->
              <div class="col-sm-4">
                <strong>Produtos</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="PRO" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="PRO" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="PRO" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--SERVICOS-->
              <div class="col-sm-4">
                <strong>Serviços</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="SER" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="SER">
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="SER" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--COMISSOES-->
              <div class="col-sm-4">
                <strong>Comissões</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="COM" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="COM">
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="COM" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--RELATORIOS-->
              <div class="col-sm-4">
                <strong>Relatórios</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="REL" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!---->
              </div>
              <!--VENDAS-->
              <div class="col-sm-4">
                <strong>Vendas</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="VEN" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="VEN" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Cancelar
                  </label>
                </div>
                <!---->
              </div>
              <!--PDV-->
              <div class="col-sm-4">
                <strong>PDV</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="PDV" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--adicionar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="PDV" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="PDV" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--FORNECEDORES-->
              <div class="col-sm-4">
                <strong>Fornecedores</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="FOR" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--adicionar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="FOR" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="FOR" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--PAGAMENTOS-->
              <div class="col-sm-4">
                <strong>Pagamentos</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="PAG" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="PAG">
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="PAG" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--PROMOCOES-->
              <div class="col-sm-4">
                <strong>Promocoes</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="PRM" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="PRM">
                  <label class="form-check-label" for="flexCheckDefault">
                    Editar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="PRM" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--CLIENTES-->
              <div class="col-sm-4">
                <strong>Clientes</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="CLI" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="CLI">
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="CLI" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--FINANCEIRO-->
              <div class="col-sm-4">
                <strong>Financeiro</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="FIN" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="FIN">
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="FIN" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--FIM PERMS-->
            </div>
          <!---->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_usuario">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
