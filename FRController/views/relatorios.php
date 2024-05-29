<?php
require"../../Configs/configs.php";
$servicosHoje = Relatorios::getServicosHoje($_SESSION['login']['filial'],true);
$servicos = Relatorios::getServicosHoje($_SESSION['login']['filial'],false);
$vendasHoje = Relatorios::getVendasHoje($_SESSION['login']['filial'],true);
$vendas = Relatorios::getVendasHoje($_SESSION['login']['filial'],false);
$freguesiaServicos = Relatorios::getFreguesiaServicos($_SESSION['login']['filial']);
$freguesiaProdutos = Relatorios::getFrueguesiaProdutos($_SESSION['login']['filial']);
// echo "<pre>";
// print_r($servicosHoje);
// echo "</pre>";
?>
<br>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/moduloRelatorios.js"></script>
<h1 class="text-center title-fr">Relatórios</h1>
<div class="col-sm-12 relatoriosDiv">
     <!--CARD 4-->
    <!--ESTATISTICAS DE PRODUTOS-->
    <div class="relPags">
        <canvas id="relPags"></canvas>
    </div>
    <div class="relSirvissosMod">
        <canvas id="relSirvissos"></canvas>
    </div>
    <div class="relCatsMod">
        <canvas id="relCatsMod"></canvas>
    </div>
    <div class="relPromos">
        <canvas id="relPromos"></canvas>
    </div>
</div>
<br>
<div class="relatoriosTables accordion">
    <div class="accordion__header acordiao">
        <h2 class="tituloVenda">Servicos Hoje</h2>
        <span class="accordion__toggle"></span>
    </div>
    <div class="accordion__body acordiao">
        <table class="table table-bordered text-center tabela table-mobile-responsive" id="servicosHoje">
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Quantidade</th>
                    <th>Arrecadado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($servicosHoje as $sh){
                ?>
                <tr>
                    <td data-content="Serviço"><?=$sh['DSTipoServico']?></td>
                    <td data-content="Quantidade"><?=$sh['Quantidade']?></td>
                    <td data-content="Arrecadado"><?=FRGeral::trataValor($sh['mobra'] + $sh['insumosBruto'],0)?> (<?=FRGeral::trataValor($sh['mobra'] + $sh['insumos'],0)?> Liquidos)</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!--SERVICOS TOTAIS-->
    <div class="accordion__header acordiao">
        <h2 class="tituloVenda">Servicos Totais</h2>
        <span class="accordion__toggle"></span>
    </div>
    <div class="accordion__body acordiao">
        <table class="table table-bordered text-center tabela table-mobile-responsive" id="servicosTotais">
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Quantidade</th>
                    <th>Arrecadado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($servicos as $s){
                ?>
                <tr>
                    <td data-content="Serviço"><?=$s['DSTipoServico']?></td>
                    <td data-content="Quantidade"><?=$s['Quantidade']?></td>
                    <td data-content="Insumos"><?=FRGeral::trataValor($s['mobra'] + $s['insumosBruto'],0)?> (<?=FRGeral::trataValor($s['mobra'] + $s['insumos'],0)?> Liquidos)</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!--VENDAS HOJE-->
    <div class="accordion__header acordiao">
        <h2 class="tituloVenda">Vendas Hoje</h2>
        <span class="accordion__toggle"></span>
    </div>
    <div class="accordion__body acordiao">
        <table class="table table-bordered text-center tabela table-mobile-responsive" id="vendasHoje">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Arrecadado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($vendasHoje as $vh){
                ?>
                <tr>
                    <td data-content="Produto"><?=$vh['NMProduto']?></td>
                    <td data-content="Quantidade"><?=$vh['Quantidade']?></td>
                    <td data-content="Arrecadado"><?=FRGeral::trataValor($vh['produtosBruto'],0)?> (<?=FRGeral::trataValor($vh['produtos'],0)?> Liquidos)</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!--VENDAS TOTAIS-->
    <div class="accordion__header acordiao">
        <h2 class="tituloVenda">Vendas Totais</h2>
        <span class="accordion__toggle"></span>
    </div>
    <div class="accordion__body acordiao">
        <table class="table table-bordered text-center tabela table-mobile-responsive" id="vendasTotais">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Arrecadado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($vendas as $v){
                ?>
                <tr>
                    <td data-content="Produto"><?=$v['NMProduto']?></td>
                    <td data-content="Quantidade"><?=$v['Quantidade']?></td>
                    <td data-content="Arrecadado"><?=FRGeral::trataValor($v['produtosBruto'],0)?> (<?=FRGeral::trataValor($v['produtos'],0)?> Liquidos)</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!--FREGUESIA DE PRODUTOS-->
    <div class="accordion__header acordiao">
        <h2 class="tituloVenda">Freguesia de Produtos</h2>
        <span class="accordion__toggle"></span>
    </div>
    <div class="accordion__body acordiao">
        <table class="table table-bordered text-center tabela table-mobile-responsive" id="freguesiaProdutos">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Quantidade</th>
                    <th>Compras</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($freguesiaProdutos as $fp){
                ?>
                <tr>
                    <td data-content="Cliente"><?=$fp['nome']?></td>
                    <td data-content="Quantidade"><?=$fp['Quantidade']?></td>
                    <td data-content="Compras"><?=FRGeral::trataValor($fp['comprasBrutas'],0)?> (<?=FRGeral::trataValor($fp['compras'],0)?> Liquido)</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!--FREGUESIA DE SERVICOS-->
    <div class="accordion__header acordiao">
        <h2 class="tituloVenda">Freguesia de Produtos</h2>
        <span class="accordion__toggle"></span>
    </div>
    <div class="accordion__body acordiao">
        <table class="table table-bordered text-center tabela table-mobile-responsive" id="freguesiaServicos">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Arrecadado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($freguesiaServicos as $fs){
                ?>
                <tr>
                    <td data-content="Produto"><?=$fs['nome']?></td>
                    <td data-content="Quantidade"><?=$fs['Quantidade']?></td>
                    <td data-content="Arrecadado"><?=FRGeral::trataValor($fs['vendasBrutas'] + $fs['mobra'],0)?> (<?=FRGeral::trataValor($fs['vendas'] + $fs['mobra'],0)?> Liquidos)</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('.accordion__header').click(function(e) {
        e.preventDefault();
        var currentIsActive = $(this).hasClass('is-active');
        $(this).parent('.accordion').find('> *').removeClass('is-active');
        if(currentIsActive != 1) {
            $(this).addClass('is-active');
            $(this).next('.accordion__body').addClass('is-active');
        }
    });
</script>

