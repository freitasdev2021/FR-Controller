<div class="modal otherModal fade " id="cadastroColaborador" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do colaborador</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroColaborador" class="form-controls">
            <input type="hidden" name="colaborador_id" value="">
            <input type="hidden" name="status" value="">
            <div class="col-sm-12 row">
                <div class="col-sm-6">
                    <label>Filial</label>
                    <select class="form-control" name="filial">
                        <option value="">Selecione</option>
                        <?php
                        foreach($fils as $f){
                            echo "<option value='".$f['IDFilial']."'>".$f['NMFilial']."</option>";
                        }
                        ?>
                    </select>
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-6">
                    <label>Nome</label>
                    <input type="name" name="nome" class="form-control" minlength="3" maxlength="50">
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="col-sm-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" minlength="3" maxlength="50">
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-6">
                    <label>Cargo</label>
                    <input type="name" name="cargo" class="form-control"  minlength="3" maxlength="50">
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>
            </div>
            <div class="col-sm-12 row">
                <div class="col-sm-4 cpfCnpj">
                    <label>CPF</label>
                    <input type="text" name="cpf" class="form-control"  minlength="3" maxlength="50">
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-4">
                    <label>Admissão</label>
                    <input type="date" name="admissao" class="form-control" minlength="10">
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>
                <div class="col-sm-4 money">
                    <label>Salário</label>
                    <input type="text" name="salario" class="form-control" minlength="1" maxlength="10">
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-fr bt_salvar_colaborador">Salvar</button>
        <button type="button" class="btn btn-danger bt_excluir_colaborador">Excluir</button>
        <button type="button" class="btn btn-primary bt_mudar_colaborador"></button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
