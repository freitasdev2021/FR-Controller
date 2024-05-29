
<?php
header("Access-Control-Allow-Origin: *");
require"../Configs/configs.php";

if($token->conferirLogin() == 0){
        header("location:../login.html");
}else{
    $_SESSION['login']['empresa'] = Contratos::getEmpresa($_SESSION['login']['contrato']);
    if($_SESSION['login']['nivel'] == 3){
        if($_SESSION['login']['empresa'] == 0){
            header("location:criaempresa.php");
        }
    }
}

if(isset($_GET["sair"])){
    session_destroy();
    header("location:../login.html");
}

if($token->conferirAcesso($_SESSION['login']['dados']['id']) == 0){
    session_destroy();
    header("location:../login.html");
}

// echo "<pre>";
// print_r(Relatorios::getFiliaisLucro());
// echo "</pre>";
// echo "<pre>";
// print_r($_SESSION['login']);
// echo "</pre>";
$dadosfilial = Contratos::getDadosFilial($_SESSION['login']['filial'],$_SESSION['login']['dados']['id']);
$relatoriosvendas = Relatorios::getVendas("filial","","");
$relatoriosservicos = Relatorios::getServicos("filial","","");
$relatorioscolaboradores = Relatorios::getColaboradores("filial");
$relatoriosdespesas = Relatorios::getDespesas("filial");
$relatoriosreps = Relatorios::getReposicoes("filial","","");
$relatorioscomissoesvendas= Relatorios::getComissoesVendas("filial");
$relatoriosComissoesServicos= Relatorios::getComissoesServicos("filial");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>FR Controller</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="../img/fricon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/libs/styles.css?<?=rand(1,10000000)?>" rel="stylesheet" />
        <link href="../bibliotecas/tabsScroll/src/css/scrollable-tabs.css?<?=rand(1,10000000)?>" rel="stylesheet" />
        <link href="../bibliotecas/tabsScroll/src/css/scrollable-tabs.min.css?<?=rand(1,10000000)?>" rel="stylesheet" />
         <!--jQuery-->
         <script src="https://code.jquery.com/jquery-3.6.1.min.js?<?=rand(1,10000000)?>" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
         <!--LOAD-->
         <link rel="stylesheet" href="../css/libs/load.css?<?=rand(1,10000000)?>">
         <link rel="stylesheet" href="../css/lateralBar.css?<?=rand(1,10000000)?>">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
         <!--DATATABLES-->
         <link href="../css/libs/datatables.css" rel="stylesheet"/>
         <link rel="stylesheet" href="../css/libs/responsive.bootstrap4.min.css?<?=rand(1,10000000)?>">
         <link rel="stylesheet" href="../css/libs/Responsive-Table.css">
         <link rel="stylesheet" href="../css/cupomCss.css">
         <link rel="stylesheet" href="../css/accordeon.css">
         <link rel="stylesheet" href="../css/relatorios.css">
    </head>
    <body>
        <style>
            thead{
                background:#234D9D;
                color:white;
            }
            textarea{
                resize:none;
            }
        </style>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end" id="sidebar-wrapper" style="background:#234D9D;">
                <div class="sidebar-heading text-white" style="background:#234D9D;">
                <?php
                echo $dadosfilial['filial']['NMFilial'];
                if($_SESSION['login']['nivel'] == 3.5){
                    echo "<hr>";
                    echo "<i class='fa fa-user'></i> ".$dadosfilial['usuario']['NMUsuario'];
                }
                ?>
                </div>
                <div class="list-group list-group-flush navegacao">
                <?php if(Autenticacao::userPerm(1,"PRO")):?><a class="list-group-item list-group-item-action p-3 produtos border-bottom white" data-value="produtos.php" style="cursor:pointer;"><i class="fa-solid fa-shop"></i>&nbsp;Produtos</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"SER")):?><a class="list-group-item list-group-item-action p-3 servicos border-bottom white"  data-value="servicos.php" style="cursor:pointer;"><i class="fa-solid fa-wrench"></i>&nbsp;Serviços</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"COM")):?><a class="list-group-item list-group-item-action p-3 comissoes border-bottom white"  data-value="comissoes.php" style="cursor:pointer;"><i class="fa-solid fa-usd"></i>&nbsp;Comissões</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"VEN")):?><a class="list-group-item list-group-item-action p-3 relatorios border-bottom white"  data-value="vendas.php" style="cursor:pointer;"><i class="fa-brands fa-sellsy"></i></i>&nbsp;Vendas</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"REL")):?><a class="list-group-item list-group-item-action p-3 relatorios border-bottom white"  data-value="relatorios.php" style="cursor:pointer;"><i class="fa-solid fa-chart-simple"></i>&nbsp;Relatórios</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"PDV")):?><a class="list-group-item list-group-item-action p-3 pontosdevenda border-bottom white"  data-value="pontosdevenda.php" style="cursor:pointer;"><i class="fa-solid fa-location-pin"></i>&nbsp;Pontos de venda</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"FOR")):?><a class="list-group-item list-group-item-action p-3 fornecedores border-bottom white"  data-value="fornecedores.php" style="cursor:pointer;"><i class="fa-solid fa-truck"></i>&nbsp;Fornecedores</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"PAG")):?><a class="list-group-item list-group-item-action p-3 pagamentos border-bottom white"  data-value="pagamentos.php" style="cursor:pointer;"><i class="fa-solid fa-barcode"></i>&nbsp;Pagamentos</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"PRM")):?><a class="list-group-item list-group-item-action p-3 promocoes border-bottom white"  data-value="promocoes.php" style="cursor:pointer;"><i class="fa-solid fa-bullhorn"></i>&nbsp;Promoções</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"CLI")):?><a class="list-group-item list-group-item-action p-3 clientes border-bottom white"  data-value="clientes.php" style="cursor:pointer;"><i class="fa-solid fa-users"></i>&nbsp;Clientes</a><?php endif?>
                <?php if(Autenticacao::userPerm(1,"FIN")):?><a class="list-group-item list-group-item-action p-3 financeiro border-bottom white"  data-value="financeiro.php" style="cursor:pointer;"><i class="fa-solid fa-money-bill"></i>&nbsp;Financeiro</a><?php endif?>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light border-bottom" style="background:#234D9D;">
                    <div class="container-fluid" >
                        <button class="btn btn-light" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link text-white" href="">Home</a></li>
                                <?php
                                if($_SESSION['login']['nivel'] == 3){
                                ?>
                                <li class="nav-item active"><a class="nav-link text-white" href="../Panel/">Painel de controle</a></li>
                                <?php
                                }
                                ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usuário</a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item " href="#!">Ajuda</a>
                                        <a class="dropdown-item " href="#!">Suporte</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item " href="index.php?sair">Sair</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <!-- <div class="logoCentral">
                    <img src="../img/logo.png" width="500px" height="250px">
                </div> -->
                
                <div class="carregamento">
                <div class="loader"></div>
                </div>
                <div class="container-fluid conteudo">
                    <!---AQUI FICAM OS RELATORIOS-->
                <?php
                if(Autenticacao::userPerm(1,"REL")){
                ?>
                    <div class="relatoriospanel">
                    <!--CARD 1-->
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Caixa total</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            Sairam <?=FRGeral::trataValor($relatoriosreps['comprasMercadoria'] + $relatoriosdespesas['VLDespesas'] +$relatorioscolaboradores['salarios'] + ($relatorioscomissoesvendas['sumPorcentagem']*$relatorioscomissoesvendas['totalVendas'])/100 + ($relatorioscomissoesvendas['sumPorcentagem']*$relatoriosComissoesServicos['totalServicos'])/100,0)?>
                                        </h2>
                                        <hr>
                                        <h2 class="d-flex align-items-center mb-0">
                                            Entraram <?=FRGeral::trataValor($relatoriosservicos['lucroservicos_total'] + $relatoriosvendas['lucrovendastotal'],0)?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                        <!--CARD 1-->
                                        <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Esse mês</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            Sairam <?=FRGeral::trataValor($relatoriosreps['comprasMercadoriaMes'] + $relatoriosdespesas['VLDespesasMes'] +$relatorioscolaboradores['salarios'],0)?>
                                        </h2>
                                        <hr>
                                        <h2 class="d-flex align-items-center mb-0">
                                            Entraram <?=FRGeral::trataValor($relatoriosservicos['lucroservicos_total'] + $relatoriosvendas['lucrovendastotal'],0)?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------>
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Caixa hoje</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            Sairam <?=FRGeral::trataValor($relatoriosreps['comprasMercadoriaHoje'] ,0)?>
                                        </h2>
                                        <hr>
                                        <h2 class="d-flex align-items-center mb-0">
                                            Entraram <?=FRGeral::trataValor($relatoriosservicos['lucroservicos_hoje'] + $relatoriosvendas['lucrovendashoje'],0)?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--CARD 3-->
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Vendas totais</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?=FRGeral::trataValor($relatoriosvendas['faturamentovendastotal'],0)?> de Faturamento
                                        </h2>
                                        <hr>
                                        <h2 class="align-items-center mb-0">
                                        <?=FRGeral::trataValor($relatoriosvendas['lucrovendastotal'],0)?> de Lucro
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--CARD 4-->
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Vendas hoje</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                        <?=FRGeral::trataValor($relatoriosvendas['faturamentovendashoje'],0)?> de Faturamento
                                        </h2>
                                        <hr>
                                        <h2 class="d-flex align-items-center mb-0">
                                        <?=FRGeral::trataValor($relatoriosvendas['lucrovendashoje'],0)?> de Lucro
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Serviços totais</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?=FRGeral::trataValor($relatoriosservicos['faturamentoservicos_total'],0)?> de Faturamento
                                        </h2>
                                        <hr>
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?=FRGeral::trataValor($relatoriosservicos['lucroservicos_total'],0)?> de Lucro
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Serviços hoje</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                        <?=FRGeral::trataValor($relatoriosservicos['faturamentoservico_hoje'],0)?> de Faturamento
                                        </h2>
                                        <hr>
                                        <h2 class="d-flex align-items-center mb-0">
                                        <?=FRGeral::trataValor($relatoriosservicos['lucroservicos_hoje'],0)?> de Lucro
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Folha salarial</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?=FRGeral::trataValor($relatorioscolaboradores['salarios'],0)?>
                                        </h2>
                                        <hr>
                                        <h2 class="d-flex align-items-center mb-0">
                                        <?=$relatorioscolaboradores['qtColaboradores']?> Colaborador<?=($relatorioscolaboradores['qtColaboradores'] > 0)?'es' : ''?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Despesas (<?=$relatoriosdespesas['QTContas']?>)</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?=FRGeral::trataValor($relatoriosdespesas['VLDespesas'] +$relatorioscolaboradores['salarios'] + ($relatorioscomissoesvendas['sumPorcentagem']*$relatorioscomissoesvendas['totalVendas'])/100 + ($relatorioscomissoesvendas['sumPorcentagem']*$relatoriosComissoesServicos['totalServicos'])/100,0)?>
                                        </h2>
                                        <hr>
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?=$relatoriosdespesas['contasvencer']?> A Vencer em 3 Dias
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 relatoriopanel">
                        <div class="card l-bg-fr">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Comissões a pagar</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?=FRGeral::trataValor(($relatorioscomissoesvendas['sumPorcentagem']*$relatorioscomissoesvendas['totalVendas'])/100 + ($relatorioscomissoesvendas['sumPorcentagem']*$relatoriosComissoesServicos['totalServicos'])/100,0)?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--CARD 4-->
                <div class="relBarIndex">
                    <div class="rbfi">
                        <canvas id="relMeses"></canvas>
                    </div>
                    <div class="rbfi">
                        <canvas id="relTrintaDias"></canvas>
                    </div>
                    <div class="rbfi">
                        <canvas id="relSeteDias"></canvas>
                    </div>
                </div>
                <?php
                }else{
                    echo "<div class='logoCentral'>
                    <img src='../img/logo.png' width='500px' height='250px'>
                </div>";
                }
                ?>
                <!--ESTATISTICAS DE PRODUTOS-->
                <!---->
                    <!--FIM DOS RELATORIOS-->
                </div>
                
            </div>
            
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js?<?=rand(1,10000000)?>"></script>
        <!-- Core theme JS-->
        <script src="../js/jquery.min.js"></script>
        <script src="../js/login.js"></script>
        <script src="../js/libs/maskmoney.js"></script>
        <script src="../js/scripts.js"></script>
        <script src="../js/libs/jquery.mask.js"></script>
        <script src="../js/libs/pagination.js"></script>
        <script src="../bibliotecas/tabsScroll/src/js/scrollable-tabs.js"></script>
        <script src="../bibliotecas/tabsScroll/src/js/scrollable-tabs.min.js"></script>
        <script src="../js/libs/responsive.bootstrap4.min.js"></script>
        <script src="../js/libs/datatables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js "></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <script src="../js/relatoriosfil.js"></script>
    </body>
</html>
