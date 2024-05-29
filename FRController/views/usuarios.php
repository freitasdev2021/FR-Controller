
<script src="js/usuarios.js"></script>
<script src="js/datatablesGeral.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Usuários</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <!--TAB USUARIOS-->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
            <div class="col-sm-6">
                <button class="btn btn-primary adicionarUsuario"><i class="fa fa-plus"></i>&nbsp;Adicionar</button>
                <button class="btn btn-success xlsx"><i class="fa-solid fa-file-excel"></i>&nbsp;Exportar XLSX</button>
                <button class="btn btn-danger pdf"><i class="fa-solid fa-file-pdf"></i></i>&nbsp;Gerar PDF</button>
            </div>
            <hr width="100%">
            <table id="example13" class="table table-bordered text-center tabela table-mobile-responsive ">
                <thead  >
                    <tr>
                        <th>Usuário</th>
                        <th>Email</th>
                        <th>Último acesso</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>    
            </table>
            <?php include"modais/modalUsuarios.php"?>
            <?php include"modais/modalAlert.php" ?>
        </div>
        <!--FIM DAS TABS-->
    </div>
</div>
<script>
$("#alerta").on("hide.bs.modal",function(){
    $(".modal-body p").text('');
})
function editarUsuario(ID,IDEmpresa){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroUsuario";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : ID,
            "Setor" : "Usuario"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $(".empresaUsuario").hide()
            $('input[name=nomeUsuario]').val(rs['nomeUsuario'])
            $('input[name=emailUsuario]').val(rs['emailUsuario'])
            $('input[name=senhaUsuario]').val(rs['senhaUsuario'])
            $('input[name=confSenhaUsuario]').val(rs['senhaUsuario'])
            $('input[name=confSenhaUsuario]').val(rs['senhaUsuario'])
            $("select[name=permissaoUsuario]").val(rs['permissaoUsuario']).change()
            $('input[name=IDUsuario]').val(ID)
            $('input[name=IDEmpresaVinculo]').val(IDEmpresa)
        }
    })
}

function changeUsuario(IDUsuario,STUsuario){
    // alert(IDUsuario)
    // return false
    //CONFERE SE O USUARIO ESTA ATIVADO OU NÃO
    if(STUsuario == 1){
       botaotxt = "Desativar";
       botaoclass = "botao btn btn-warning"
       titlemodal = "Desativação do usuario"
       conteudomodal = "Deseja desativar o usuario? o usuario não terá mais acesso ao sistema"
    }else{
       botaotxt = "Ativar";
       botaoclass = "botao btn btn-success"
       titlemodal = "Ativação do usuario"
       conteudomodal = "Deseja ativar o usuario? o usuario terá acesso ao sistema"
    }
    //MODAL
    $modal = {
        titulo : titlemodal,
        conteudo : conteudomodal,
        botao : {
            class : botaoclass,
            texto : botaotxt,
            funcao : ()=>{
                $.ajax({
                    method : "POST",
                    url : "./processamento/changeStatus.php",
                    data : {
                        setor : 'Usuario',
                        atualStatus : STUsuario,
                        ID   : IDUsuario
                    },
                    success : function(){
                    $("#example13").DataTable().ajax.reload( null, false );
                    $("#alerta").modal("hide") 
                    }
                })
            } 
        }
    }
    //
    abreModal($modal)
}

function excluirUsuario(IDUsuario){
    // alert(IDUsuario)
    // return false
    $modal = {
        titulo : "Excluir Usuário",
        conteudo : "Deseja excluir o usuário?",
        botao : {
            class : "botao btn btn-danger",
            texto : "Excluir",
            funcao : ()=>{
                $.ajax({
                    method : "POST",
                    url : "./processamento/exclusaoDado.php",
                    data : {
                        setor : 'Usuario',
                        ID   : IDUsuario
                    },
                    success : function(){
                    $("#example13").DataTable().ajax.reload( null, false );
                    $("#alerta").modal("hide") 
                    }
                })
            } 
        }
    }
    abreModal($modal)
}
</script>

