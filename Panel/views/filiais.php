<?=include"../../Configs/configs.php"?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/filiais.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Filiais</a>
            <a class="nav-item nav-link pointer text-black" data-bs-target="#tab2" role="tab" data-bs-toggle="tab">Relatórios</a>
        </nav>
    </div>
    <input type="hidden" name="IDEmpresa" value="<?=$_SESSION['login']['empresa']?>">
    <div class="tab-content p-3" id="myTabContent">
        <!--TAB DE EMPRESAS-->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab">
           <!--cabecalho da tabela-->
           <div class="col-sm-12">
                <button class="btn btn-fr adicionarFilial btn-one elementHeader"><i class="fa fa-plus"></i>&nbsp;Adicionar</button>
            </div>
            <!--tabela-->
        <hr width="100%">
        <table id="example11" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Nome da filial</th>
                    <th>Endereço da Filial</th>
                    <th>Folha Salarial</th>
                    <th>Telefone</th>
                    <th style="text-align:center;">Opções</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <?php include "modais/modalFiliais.php" ?>
        <?php include "modais/modalAlert.php" ?>
    </div>
    <div class="tab-pane fade mt-2" id="tab2" role="tabpanel" aria-labelledby="group-dropdown2-tab">
    <h1 class='title-fr text-center'>Entradas</h1>
        <div class="relBar">
            <div class="rb">
                <canvas id="relFiliais"></canvas>
            </div>
            <div class="rb">
                <canvas id="relMeses"></canvas>
            </div>
            <div class="rb">
                <canvas id="relTrintaDias"></canvas>
            </div>
            <div class="rb">
                <canvas id="relSeteDias"></canvas>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="table table-bordered text-center tabela table-mobile-responsive">
                <thead>
                    <tr style="text-align:center;">
                        <th colspan="3">Filial</th>
                        <th colspan="2">Produtos</th>
                        <th colspan="2">Serviços</th>
                    </tr>
                    <tr style="text-align:center;">
                        <th>Filial</th>
                        <th>Sairam</th>
                        <th>Entraram</th>
                        <th>Faturamento</th>
                        <th>Lucro</th>
                        <th>Faturamento</th>
                        <th>Lucro</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach(Relatorios::getFiliaisLucro() as $gf){
                ?>
                    <tr>
                        <td><strong><?=$gf['Nome']?></strong></td>
                        <td data-content="Faturamento(Filial)"><?=FRGeral::trataValor($gf['faturamentoTotal'],0)?></td>
                        <td data-content="Lucro (Filial)"><?=FRGeral::trataValor($gf['lucroTotal'],0)?></td>
                        <td data-content="Faturamento(Produtos)"><?=FRGeral::trataValor($gf['faturamentoVendas'],0)?></td>
                        <td data-content="Lucro(Produtos)"><?=FRGeral::trataValor($gf['lucroVendas'],0)?></td>
                        <td data-content="Faturamento(Serviços)"><?=FRGeral::trataValor($gf['faturamentoServicos'],0)?></td>
                        <td data-content="Lucro(Serviços)"><?=FRGeral::trataValor($gf['lucroServicos'],0)?></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--TAB DE EMPRESAS-->
</div>
</div>
<script>
function editarFilial(IDFilial){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDFilial);
    // return false;
    var modal = "#cadastroFilial";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDFilial,
            "Setor" : "Filial"
        },
        success : function(response){
            var rs = JSON.parse(response)
            var en = JSON.parse(rs['DSEnderecoJSON']);
            $(modal).modal("show")
            $(modal).find("select[name=uf]").val(en['uf'].toUpperCase())
            $(modal).find("input[name=IDFilial]").val(rs['IDFilial'])
            $(modal).find("input[name=cidade]").val(en['cidade'])
            $(modal).find("input[name=rua]").val(en['rua'])
            $(modal).find("input[name=bairro]").val(en['bairro'])
            $(modal).find("input[name=numero]").val(en['numero'])
            $(modal).find("input[name=cep]").val(formataCep(en['cep']))
            $(modal).find("input[name=nome]").val(rs['NMFilial'])
            $(modal).find("input[name=telefone]").val(rs['NUTelefoneFilial'])
            $(".bt_excluir_filial").show()
        }
    })
}
</script>