<?php
include"../../Configs/configs.php";
$planos = Contratos::getPlanos();
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/contratos.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Contratos</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <!--TAB DE EMPRESAS-->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab">
            <!--cabecalho da tabela-->
            <div class="col-sm-12">
                <button class="btn btn-fr btn-one adicionarContrato elementHeader btn-one"><i class="fa fa-plus"></i>&nbsp;Adicionar</button>
            </div>
            <!--tabela-->
        </div>
        <hr>
        <table id="example2" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Contratante</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Plano</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <?php include "modais/modalContratos.php" ?>
        <?php include "modais/modalAlert.php" ?>
    </div>
    <!--TAB DE EMPRESAS-->
</div>
</div>

<script>
    function editarContrato(IDContrato){
        // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
        // var response = await dados.json()
        // console.log(response)
        // alert(IDProduto);
        // return false;
        var modal = "#cadastroContrato";
        $.ajax({
            method : "POST",
            url : "views/view.php",
            data : {
                "ID" : IDContrato,
                "Setor" : "Contrato"
            },
            success : function(response){
                var rs = JSON.parse(response)
                var en = JSON.parse(rs['DSEndContrato']);
                $(modal).modal("show");
                $(modal).find("input[name=contratante]").val(rs['NMContratante'])
                $(modal).find("select[name=plano]").val(rs['IDPlano'])
                $(modal).find("input[name=email]").val(rs['NMEmailContratante'])
                $(modal).find("input[name=cpf]").val(formataCpf(rs['NUCpfContratante']))
                $(modal).find("input[name=telefone]").val(formataTelefone(rs['NUCpfContratante']))
                $(modal).find("select[name=uf]").val(en['uf'].toUpperCase())
                $(modal).find("input[name=cidade]").val(en['cidade'])
                $(modal).find("input[name=rua]").val(en['rua'])
                $(modal).find("input[name=bairro]").val(en['bairro'])
                $(modal).find("input[name=numero]").val(en['numero'])
                $(modal).find("input[name=cep]").val(formataCep(en['cep']))
                $(modal).find("input[name=status]").val(rs['STContrato'])
                $(modal).find("input[name=contrato_id]").val(rs['IDContrato'])
                $(".bt_excluir_contrato,.bt_mudar_contrato").show()
                $("input[name=cpf]").prop("disabled",true)
                if(rs['STContrato'] == 1){
                    $(".bt_mudar_contrato").text("Desativar")
                    $(".bt_mudar_contrato").addClass("btn-warning")
                    $(".bt_mudar_contrato").removeClass("btn-success")
                }else{
                    $(".bt_mudar_contrato").text("Ativar")
                    $(".bt_mudar_contrato").removeClass("btn-warning")
                    $(".bt_mudar_contrato").addClass("btn-success")
                }
            }
        })
    }
</script>