<?php 
require"../../Configs/configs.php";
include"modais/modalComissoes.php";
include"modais/modalComissionados.php";
include"modais/modalAlert.php";
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/comissoes.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Comissões</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
    <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
        <div class="col-sm-12">
        <?php if(Autenticacao::userPerm(2,"COM")):?><button class="btn btn-fr adicionarComissao elementHeader btn-one"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif;?>
        </div>
        <hr width="100%">
        <table id="example16" class="table table-bordered text-center table-mobile-responsive ">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Porcentagem</th>
                <th>Participantes</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>    
        </table>
    </div>
    </div>
</div>
<script>
$("#alerta").on("hide.bs.modal",function(){
    $(".modal-body p").text('');
})

function listarComissionados(IDComissao){
    $("#formCadastroComissionados tbody").html("")
    $("input[name=IDComissao]").val(IDComissao)
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID"            : IDComissao,
            "Setor"         : "Comissionados"
        },
        success : function(response){
            // console.log(response)
            // return false
            var rs = JSON.parse(response)
            rs.forEach((com)=>{

                trComissao = $("<tr>",{
                    class: 'colaborador_'+com.IDColaborador
                },"</tr>")
                if(com.vinculo == 1){
                    checked = 'checked'
                }else{
                    checked = ''
                }
                trComissao.append("<td><input type='checkbox' "+checked+" name='colaborador' value="+com.IDColaborador+"></td>")
                trComissao.append("<td>"+com.NMColaborador+"</td>")

                $("#formCadastroComissionados tbody").append(trComissao)

            })

            $("#cadastroComissionados").modal("show")
        }
    })
    
}

function editarComissao(IDComissao){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroComissao";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDComissao,
            "Setor" : "Comissao"
        },
        success : function(response){
            //console.log(response)
            var rs = JSON.parse(response)[0]
            //console.log(rs)
            //alert(rs['IDComissao'])
            $(modal).modal("show");
            $('input[name=IDComissao]').val(rs['IDComissao'])
            $('input[name=nomeComissao]').val(rs['NMComissao'])
            $('select[name=tipoComissao]').parent().hide()
            $('input[name=porcentagemComissao]').val(rs['NUPorcentagem'])
            $(".bt_excluir_comissao").show()
        }
    })
}

</script>
