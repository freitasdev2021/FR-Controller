<?php
include"../../Configs/configs.php";
$fils = $empresas->getFiliais($_SESSION['login']['empresa']);
$relVendasServicos = Relatorios::getVendasServicos($_SESSION['login']['empresa']);
$relVendasProdutos = Relatorios::getVendasProdutos($_SESSION['login']['empresa']);
// echo "<pre>";
// print_r($relVendasProdutos);
// echo "</pre>";
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/colaboradores.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Colaboradores</a>
            <a class="nav-item nav-link pointer text-black" data-bs-target="#tab2" role="tab" data-bs-toggle="tab">Vendas</a>
        </nav>
    </div>
    <input name="IDEmpresa" type="hidden" value="<?=$_SESSION['login']['empresa']?>">
    <div class="tab-content p-3" id="myTabContent">
    <!--TAB DE EMPRESAS-->
    <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab">
        <!--cabecalho da tabela-->
        <div class="col-sm-12">
            <button class="btn btn-fr adicionarColaborador elementHeader btn-one"><i class="fa fa-plus"></i>&nbsp;Adicionar</button>
        </div>
        <!--tabela-->
        <hr width="100%">
        <table id="example4" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Salário</th>
                    <th>CPF</th>
                    <th>Admissão</th>
                    <th>Filial</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <?php include "modais/modalColaboradores.php" ?>
        <?php include "modais/modalAlert.php" ?>
    </div>
    <!--TAB EMPRESAS-->
    <div class="tab-pane fade mt-2" id="tab2" role="tabpanel" aria-labelledby="group-dropdown2-tab">
        <div class="col-sm-12 row">
            <div class="col-sm-6">
                <table class="table table-bordered text-center tabela table-mobile-responsive ">
                    <thead>
                        <tr>
                            <th colspan="4">Produtos</th>
                        </tr>
                        <tr>
                            <th>Colaborador</th>
                            <th>Filial</th>
                            <th>Vendas</th>
                            <th>Comissão</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($relVendasProdutos as $rvp){
                        ?>
                        <tr>
                            <td><?=$rvp['NMColaborador']?></td>
                            <td><?=$rvp['NMFilial']?></td>
                            <td><?=FRGeral::trataValor($rvp['produtos'],0)?></td>
                            <td><?=FRGeral::trataValor((($rvp['produtos'])*$rvp['NUPorcentagem'])/100,0)." (".$rvp['NUPorcentagem']."%)"?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="table table-bordered text-center tabela table-mobile-responsive ">
                    <thead>
                        <tr>
                            <th colspan="4">Serviços</th>
                        </tr>
                        <tr>
                            <th>Colaborador</th>
                            <th>Filial</th>
                            <th>Vendas</th>
                            <th>Comissão</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($relVendasServicos as $rvs){
                        ?>
                        <tr>
                            <td><?=$rvs['nome']?></td>
                            <td><?=$rvs['NMFilial']?></td>
                            <td><?=FRGeral::trataValor($rvs['vendas'] + $rvs['produtos'],0)?></td>
                            <td><?=FRGeral::trataValor((($rvs['vendas'] + $rvs['produtos'])*$rvs['porcentagem'])/100,0)." (".$rvs['porcentagem']."%)"?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--TAB DE EMPRESAS-->
</div>
</div>
<script>
function editarColaborador(IDColaborador){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDFilial);
    // return false;
    var modal = "#cadastroColaborador";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDColaborador,
            "Setor" : "Colaborador"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show")
            $(modal).find("input[name=nome]").val(rs['NMColaborador'])
            $(modal).find("input[name=cargo]").val(rs['NMCargoColaborador'])
            $(modal).find("input[name=salario]").val(trataValor(rs['VLSalario'],0))
            $(modal).find("select[name=filial]").val(rs['IDFilial'])
            $(modal).find("input[name=email]").val(rs['NMEmailColaborador'])
            $(modal).find("input[name=status]").val(rs['STAcesso'])
            $(modal).find("input[name=colaborador_id]").val(rs['IDColaborador'])
            //ESCONDER
            $(modal).find("input[name=admissao]").parent().hide()
            $(modal).find("input[name=cpf]").parent().hide()
            //
            $(".bt_excluir_colaborador").show()
            $(".bt_mudar_colaborador").show()
            if(rs['STAcesso'] == 1){
                $(".bt_mudar_colaborador").text("Bloquear")
                $(".bt_mudar_colaborador").addClass("btn-warning")
                $(".bt_mudar_colaborador").removeClass("btn-success")
            }else{
                $(".bt_mudar_colaborador").text("Desbloquear")
                $(".bt_mudar_colaborador").removeClass("btn-warning")
                $(".bt_mudar_colaborador").addClass("btn-success")
            }
        }
    })
}
</script>