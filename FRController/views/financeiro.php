<?php
require"../../Configs/configs.php";
include"modais/modalContaPagar.php";
include"modais/modalAlert.php";
?>
<script src="../js/financeiro.js"></script>
<script src="../js/datatablesGeral.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Despesas</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
       <!-----CLIENTES---->
       <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
            <div class="col-sm-12">
                <button class="btn btn-fr btn-one adicionarContaPagar elementHeader"><i class="fa fa-plus"></i>&nbsp;Adicionar</button>
            </div>
            <hr width="100%">
            <table id="example3" class="table table-bordered text-center tabela table-mobile-responsive ">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Expedição</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>    
            </table>
        </div>
        <div class="tab-pane fade mt-2" id="tab4" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
            Fluxo(Em desenvolvimento)
        </div>
    </div>
</div>
<script>
$("#alerta").on("hide.bs.modal",function(){
    $(".modal-body p").text('');
})

function editarContaPagar(IDContaPagar){
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroDespesa";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDContaPagar,
            "Setor" : "ContaPagar"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $(".bt_excluir_contapagar").show()
            $('input[name=IDContaPagar]').val(rs['IDConta'])
            $('input[name=nomeContaPagar]').val(rs['NMConta'])
            $('input[name=vencimentoContaPagar]').val(rs['DTVencimentoConta'])
            $('input[name=valorContaPagar]').val(trataValor(rs['VLConta'],0))
            $('textarea[name=justificativaContaPagar]').val(rs['DSJustificativaConta'])
        }
    })
}

function pagarConta(IDContaPagar){
    $modal = {
        titulo : "Quitação de despesa?",
        conteudo : "Deseja dar baixa na despesa?",
        botao : {
            class : "botao btn btn-success",
            texto : "Pagar",
            funcao : ()=>{
                $.ajax({
                    method : "POST",
                    url : "./../Configs/changeStatus.php",
                    data : {
                        setor : 'Conta',
                        atualStatus : "",
                        ID   : IDContaPagar
                    },
                    success : function(){
                    $("#example3").DataTable().ajax.reload( null, false );
                    $("#alerta").modal("hide") 
                    }
                })
            } 
        }
    }
    abreModal($modal)
}
</script>