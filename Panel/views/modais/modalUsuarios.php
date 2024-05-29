<div class="modal otherModal fade " id="cadastroUsuario" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do usuário</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroUsuario" class="form-controls">
          <!---->
          <input type="hidden" name="usuario_id" value="">
          <input type="hidden" name="status" value="">
          <div class="col-sm-12">
              <label>Nivel</label>
              <select name="nivel" class="form-control">
                <option value="">Selecione</option>
                <option value="1.5">Auxiliar FR</option>
                <option value="3">Cliente</option>
                <option value="2">Revendedor</option>
              </select>
              <div class="error-input text-danger">
                Preenchimento incorreto!
              </div>
          </div>
          <div class="col-sm-12 ctrato">
              <label>Contrato</label>
              <select name="contrato" class="form-control">
                <option value="">Contrato</option>
                <?php
                foreach(Contratos::getAllContratos() as $c){
                  echo "<option value=".$c['IDContrato']."'>".$c['NMContratante']." - ".$c['NUCpfContratante']."</option>";
                }
                ?>
              </select>
              <div class="error-input text-danger">
                Preenchimento incorreto!
              </div>
          </div>
          <div class="col-sm-12 row">
            <div class="col-sm-6">
                  <label>Usuário</label>
                  <input type="text" name="nome" class="form-control" minlength="3" maxlength="100">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-6">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" minlength="10" maxlength="100">
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
              <!--CONTRATOS-->
              <div class="col-sm-4">
                <strong>Contratos</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="CON" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--adicionar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="CON" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="CON" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--USUÁRIOS-->
              <div class="col-sm-4">
                <strong>Usuários</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="USU" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--adicionar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="USU" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="USU">
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
        <?php
        if(Autenticacao::userPerm(2,"USU")){
        ?>
        <button type="button" class="btn btn-primary bt_salvar_usuario">Salvar</button>
        <?php if(Autenticacao::userPerm(3,"USU")):?><button type="button" class="btn btn-danger bt_excluir_usuario">Excluir</button><?php endif?>
        <button type="button" class="btn btn-primary bt_mudar_usuario"></button>
        <?php
        }
        ?>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
