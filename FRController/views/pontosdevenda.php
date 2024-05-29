<?php
require"../../Configs/configs.php";
include"modais/modalPontos.php";
include"modais/modalAlert.php";
?>
<script src="../js/pontos.js"></script>
<script src="../js/datatablesGeral.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Pontos</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
            <div class="col-sm-12 cabecalho-qt2">
            <?php if(Autenticacao::userPerm(2,"PON")):?><button class="btn btn-fr adicionarPonto elementHeader"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif;?>
                <a download href="../files/PDVDesktop.rar" filename="PDV" class="btn btn-fr linkHeader elementHeader"><i class="fa-solid fa-file-download"></i></i>&nbsp;Baixar PDV</a>
            </div>
            <hr width="100%">
            <table id="example15" class="table table-bordered text-center tabela table-mobile-responsive ">
                <thead>
                    <tr>
                        <th>Caixa</th>
                        <th>Vendas</th>
                        <th>Status</th>
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
function editarCaixa(IDPonto){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroPonto";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDPonto,
            "Setor" : "Ponto"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            verVendas(rs['IDCaixa']);
            $('input[name=IDPonto]').val(rs['IDCaixa'])
            $('input[name=nomePonto]').val(rs['NMPdv'])
            $("input[name=senhaPonto]").val(rs['NMSenhaPDV'])
            $(".bt_excluir_ponto").show()
        }
    })
}

function verVendas(IDPonto){
    var modal = "#cadastroPonto";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDPonto,
            "Setor" : "verVendasCaixa"
        },
        success : function(response){
            $(modal).find("#vendas").html(response)
        }
    })
}
</script>

