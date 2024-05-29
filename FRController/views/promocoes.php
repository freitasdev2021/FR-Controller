<?php 
require"../../Configs/configs.php";
include"modais/modalPromo.php";
include"modais/modalProdutoPromo.php";
include"modais/modalAlert.php";
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/promocoes.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Promoções</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
    <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
        <div class="col-sm-12">
        <?php if(Autenticacao::userPerm(2,"PRM")):?><button class="btn btn-fr adicionarPromo elementHeader btn-one"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif?>
        </div>
        <hr width="100%">
        <table id="example12" class="table table-bordered text-center table-mobile-responsive ">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Desconto</th>
                <th>Inicio</th>
                <th>Fim</th>
                <th>Status</th>
                <th>Produtos e Serviços</th>
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

function listarProdutoPromo(IDPromo){
    $("#formCadastroPromoProdutos tbody").html("")
    $("input[name=IDPromo]").val(IDPromo)
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID"            : IDPromo,
            "Setor"         : "vinculoPromo"
        },
        success : function(response){
            // console.log(response)
            // return false
            var rs = JSON.parse(response)
            rs.forEach((pro)=>{

                trPromo = $("<tr>",{
                    class: 'produto_'+pro.IDProduto
                },"</tr>")
                if(pro.vinculo == 1){
                    checked = 'checked'
                }else{
                    checked = ''
                }
                trPromo.append("<td><input type='checkbox' "+checked+" name='produto' value="+pro.IDProduto+"></td>")
                trPromo.append("<td>"+pro.NMProduto+"</td>")

                $("#formCadastroPromoProdutos tbody").append(trPromo)

            })

            $("#cadastroProdutoPromo").modal("show")
        }
    })
    
}

function editarPromo(IDPromo){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroPromo";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDPromo,
            "Setor" : "Promo"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $('input[name=IDPromocao]').val(rs['IDPromocao'])
            $('input[name=nomePromo]').val(rs['NMPromo'])
            $('input[name=inicioPromo]').val(rs['DTInicioPromo'])
            $('input[name=fimPromo]').val(rs['DTTerminoPromo'])
            $('select[name=tipoPromo]').val(rs['TPDesconto']).change()
            $(".bt_excluir_promocao").show()
            if(rs['tipoDesconto'] == "%"){
                $('input[name=descontoPromo]').val(rs['NUDescontoPromo'])
            }else{
                $('input[name=descontoPromo]').val(trataValor(rs['NUDescontoPromo'],0))
            }
        }
    })
}

</script>
