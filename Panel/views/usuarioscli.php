<?php
include"../../Configs/configs.php";
$col =Contratos::getSelectColUser($_SESSION['login']['empresa']);
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/usuarios.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Usuários</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <!--TAB DE EMPRESAS-->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab">
            <!--cabecalho da tabela-->
            <div class="col-sm-12">
                <button class="btn btn-fr btn-one adicionarUsuario elementHeader btn-one"><i class="fa fa-plus"></i>&nbsp;Adicionar</button>
            </div>
            <!--tabela-->
            <hr width="100%">
            <input type="hidden" name="permissao" value="<?=$_SESSION['login']['nivel']?>">
            <input type="hidden" name="IDEmpresa" value="<?=$_SESSION['login']['empresa']?>">
            <table id="example8" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Permissões</th>
                    <th>Colaborador</th>
                    <th>Filial</th>
                    <th>Ultimo acesso</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        </div>
        <?php include "modais/modalUsuarioscli.php" ?>
        <?php include "modais/modalAlert.php" ?>
    </div>
    <!--TAB DE EMPRESAS-->
</div>
</div>
<script>
    function editarUsuario(IDUsuario){
        $.ajax({
            method : "POST",
            url : "views/view.php",
            data : {
                "ID" : IDUsuario,
                "Setor" : "Usuario"
            },
            success : function(response){
                var rs = JSON.parse(response)
                if($("#cadastroUsuario").length == 1){
                    cd = "#cadastroUsuario"
                    $(cd).find("select[name=nivel]").val(rs['NVUsuario'])
                }else{
                    cd = "#cadastroUsuariocli";
                    $(cd).find("select[name=colaborador]").attr("disabled",true)
                    $(cd).find("select[name=colaborador]").addClass("norequire")
                    $(cd).find("input[name=nivel]").val(rs['NVUsuario'])
                }
                $(cd).modal("show")
                $(cd).find("input[name=nome]").val(rs['NMUsuario'])
                $(cd).find("input[name=email]").val(rs['NMEmailUsuario'])
                $(cd).find("input[name=status]").val(rs['STUsuario'])
                $(cd).find("input[name=usuario_id]").val(rs['IDUsuario'])
                $(cd).find("input[name=senha]").val(rs['NMSenhaUsuario'])
                $(cd).find("select[name=nivel]").parent().hide()
                if(rs['NVUsuario'] == 3){
                    $(".bt_excluir_usuario,.bt_mudar_usuario").hide()
                }else{
                    $(".bt_excluir_usuario,.bt_mudar_usuario").show()
                }

                $("input[name=USU][value=3]").on("click",function(){
                    if($(this).is(":checked")){
                        $("input[name=USU][value=2]").prop("checked",true)
                    }else{
                        $("input[name=USU][value=2]").prop("checked",false)
                    }
                })

                $("input[name=CON][value=3]").on("click",function(){
                    if($(this).is(":checked")){
                        $("input[name=CON][value=2]").prop("checked",true)
                    }else{
                        $("input[name=CON][value=2]").prop("checked",false)
                    }
                })

                if(rs['NVUsuario'] == 1.5 || rs['NVUsuario'] == 3.5){
                    var permissoes = jQuery.parseJSON(rs['PMUsuario'])[rs['NVUsuario']]
                    $(".permissoes").find("input[type=checkbox]").each(function(){
                        for (var [key, value] of Object.entries(permissoes)){
                            if($(this).attr("name") == key){
                                value.forEach((i)=>{
                                if($(this).val() == i){
                                    $(this).prop("checked",true)
                                }
                                })
                            }
                        }
                    })
                }else{
                    $(".permissoes,.permTitle").hide()
                }

                $(".ctrato").hide()
                // $("#cadastroUsuario").find("input[name=email]").val($(this).parents("tr").find("#permissoes").text())
                if(rs['STUsuario'] == 1){
                    $(".bt_mudar_usuario").text("Bloquear")
                    $(".bt_mudar_usuario").addClass("btn-warning")
                    $(".bt_mudar_usuario").removeClass("btn-success")
                }else{
                    $(".bt_mudar_usuario").text("Desbloquear")
                    $(".bt_mudar_usuario").removeClass("btn-warning")
                    $(".bt_mudar_usuario").addClass("btn-success")
                }
            }
        })
    }
</script>