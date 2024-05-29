<?php
require"../../Configs/configs.php";
$selectDevedores = $clientes->getSelectDevedores($_SESSION['login']['filial']);
$selectCrediarios = $clientes->getSelectCrediarios($_SESSION['login']['filial']);
include"modais/modalClientes.php";
include"modais/modalDevedores.php";
include"modais/modalCrediarios.php";
include"modais/modalAlert.php";
?>
<script src="../js/clientes.js"></script>
<script src="../js/datatablesGeral.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Clientes</a>
            <a class="nav-item nav-link pointer text-black" data-bs-target="#tab3" role="tab" data-bs-toggle="tab">Devedores</a>
            <!-- <a class="nav-item nav-link pointer text-black" data-bs-target="#tab4" role="tab" data-bs-toggle="tab">Crediário</a> -->
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <!-----CLIENTES---->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
            <div class="col-sm-12">
                <?php if(Autenticacao::userPerm(2,"CLI")):?><button class="btn btn-fr adicionarCliente elementHeader btn-one"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif;?>
            </div>
            <hr width="100%">
            <table id="example14" class="table table-bordered text-center tabela table-mobile-responsive ">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th style='width:100px;'>Contato</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>    
            </table>
        </div>
        <!-----DEVEDORES---->
        <div class="tab-pane fade mt-2" id="tab3" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
        <div class="col-sm-12">
        <?php if(Autenticacao::userPerm(2,"CLI")):?><button class="btn btn-fr adicionarDevedor elementHeader"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif;?>
        </div>
        <hr width="100%">
        <table id="example6" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Dívida total</th>
                    <th>Desde</th>
                    <th style='width:100px;'>Cobrança</th>
                </tr>
            </thead>
            <tbody>

            </tbody>    
        </table>
        </div>
        <!-----CREDIARIOS---->
        <div class="tab-pane fade mt-2" id="tab4" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
        <div class="col-sm-12 cabecalho">
            <button class="btn btn-primary adicionarCrediario elementHeader"><i class="fa fa-plus"></i>&nbsp;Adicionar</button>
            <button class="btn btn-success xlsx elementHeader"><i class="fa-solid fa-file-excel"></i>&nbsp;Exportar XLSX</button>
            <button class="btn btn-danger pdf elementHeader"><i class="fa-solid fa-file-pdf"></i></i>&nbsp;Gerar PDF</button>
            <button class="btn btn-warning pdf elementHeader"><i class="fa-solid fa-chart-simple"></i></i>&nbsp;Gerar Relatório</button>
        </div>
        <hr width="100%">
        <table id="example5" class="table table-bordered text-center tabela table-mobile-responsive ">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Crédito total</th>
                <th>Desde</th>
                <th>Até</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>    
        </table>
        </div>
        <!-----FIM---->
    </div>
</div>
<script>
$("#alerta").on("hide.bs.modal",function(){
    $(".modal-body p").text('');
})
function editarCliente(IDCliente,confirmacao){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroCliente";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDCliente,
            "Setor" : "Cliente"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $('input[name=IDCliente]').val(rs['IDCliente'])
            $('input[name=nomeCliente]').val(rs['NMCliente'])
            $('input[name=emailCliente]').val(rs['NMEmailCliente'])
            $('input[name=telefoneCliente]').val(formataTelefone(rs['NUTelefoneCliente']))
            $(".bt_excluir_cliente").show()
            verCompras(rs['IDCliente'])
            verServicos(rs['IDCliente'])
            $('input[name=cpfCliente]').parent().hide()
        }
    })
}

function editarDevedor(IDDevedor){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroDevedor";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDDevedor,
            "Setor" : "Devedor"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $('input[name=IDDevedor]').val(rs['IDDevedor'])
            $('select[name=devedorNome]').parent().hide()
            $('input[name=devedorDivida]').val(trataValor(rs['VLDivida'],0))
            $(".bt_excluir_devedor").show()
            $("#nomeDevedor").show()
            $("#nomeDevedor").text(rs['NMCliente'])
        }
    })
}

function verCompras(IDCliente){
    var modal = "#cadastroCliente";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDCliente,
            "Setor" : "ComprasCliente"
        },
        success : function(response){
            console.log(response)
            $(modal).find("#compras").html(response)
        }
    })
}

function verServicos(IDCliente){
    var modal = "#cadastroCliente";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDCliente,
            "Setor" : "ServicosCliente"
        },
        success : function(response){
            console.log(response)
            $(modal).find("#servicos").html(response)
        }
    })
}

function editarCrediario(IDCrediario){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroCrediario";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDCrediario,
            "Setor" : "Crediario"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $('input[name=IDCrediario]').val(rs['IDCrediario'])
            $('select[name=nomeCrediario]').parent().hide()
            $('input[name=creditoCrediario]').val(trataValor(rs['NUCredito'],0))
            $('input[name=creditoAte]').val(rs['DTTerminoCredito'])
            $("#nomeCrediario").show()
            $(".bt_excluir_crediario").show()
            $("#nomeCrediario").text(rs['NMCliente'])
        }
    })
}

</script>

