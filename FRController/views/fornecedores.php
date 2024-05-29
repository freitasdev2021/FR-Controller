<?php
require"../../Configs/configs.php";
include"modais/modalFornecedores.php";
include"modais/modalAlert.php";
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/fornecedores.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Fornecedores</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <!--TAB USUARIOS-->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
            <div class="col-sm-12">
                <button class="btn btn-fr adicionarFornecedor elementHeader btn-one"><i class="fa fa-plus"></i>&nbsp;Adicionar</button>
            </div>
            <hr width="100%">
            <table id="example7" class="table table-bordered text-center tabela table-mobile-responsive ">
                <thead  >
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th>Opções</th>
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
function editarFornecedor(IDFornecedor){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroFornecedor";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDFornecedor,
            "Setor" : "Fornecedor"
        },
        success : function(response){
            // console.log(response)
            // return false;
            var rs = JSON.parse(response)
            inderesso = JSON.parse(rs['DSEndFornecedor'])
            $(modal).modal("show");
            $('input[name=IDFornecedor]').val(rs['IDFornecedor'])
            $('input[name=nomeFornecedor]').val(rs['NMFornecedor'])
            $('input[name=emailFornecedor]').val(rs['DSEmailFornecedor'])
            $('input[name=telefone]').val(formataTelefone(rs['DSTelefoneFornecedor']))
            //ENDEREÇO
            $(".bt_excluir_fornecedor").show()
            $('input[name=cepFornecedor]').val(inderesso['cep'])
            $('input[name=ufFornecedor]').val(inderesso['uf'])
            $('input[name=cidadeFornecedor]').val(inderesso['cidade'])
            $('input[name=bairroFornecedor]').val(inderesso['bairro'])
            $('input[name=ruaFornecedor]').val(inderesso['rua'])
            $('input[name=numeroFornecedor]').val(inderesso['numero'])
            $('input[name=complementoFornecedor]').val(inderesso['complemento'])
        }
    })
}
</script>

