<?php
require"../../Configs/configs.php";
include"modais/modalPagamentos.php";
include"modais/modalAlert.php";
?>
<script src="../js/pagamentos.js"></script>
<script src="../js/datatablesGeral.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Pagamentos</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <!--TAB USUARIOS-->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
            <div class="col-sm-12">
            <?php if(Autenticacao::userPerm(2,"PAG")):?><button class="btn btn-fr btn-one adicionarMetodo elementHeader"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif;?>
            </div>
            <hr width="100%">
            <table id="example9" class="table table-bordered text-center tabela table-mobile-responsive ">
                <thead  >
                    <tr>
                        <th>Nome</th>
                        <th>Desconto</th>
                        <th>Metodo</th>
                        <th>Parcelas</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <?php //include"listas/tabelaUsuarios.php"?> -->
                </tbody>    
            </table>
        </div>
        <!--FIM DAS TABS-->
    </div>
</div>
<script>
$("#alerta").on("hide.bs.modal",function(){
    $(".modal-body p").text('');
})
function editarPagamento(IDPagamento){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroPagamento";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDPagamento,
            "Setor" : "Pagamento"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $('input[name=IDPagamento]').val(rs['IDPagamento'])
            $('input[name=nomeMetodo]').val(rs['NMPagamento'])
            $('select[name=metodoMetodo]').val(rs['DSMetodo']).change()
            $('select[name=tipoMetodo]').val(rs['TPDesconto']).change()
            $(".bt_excluir_pagamento").show()
            if(rs['TPDesconto'] == "2"){
                $('input[name=descontoMetodo]').val(trataValor(rs['QTDesconto'],0))
            }else{
                $('input[name=descontoMetodo]').val(rs['QTDesconto'])
            }
            $("input[name=jurosMetodo]").val(rs['NUJuros'])
            $('input[name=parcelasMetodo]').val(rs['QTParcelas'])
        }
    })
}

</script>

