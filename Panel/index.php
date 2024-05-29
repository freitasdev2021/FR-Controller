
<?php
//session_start();
require"../Configs/configs.php";

if($token->conferirLogin() == 0){
        header("location:../login.html");
}else{
    if($token->conferirArea($_SESSION['login']['nivel']) == 3.5 ){
        header("location:../FRController/index.php");
    }elseif($token->conferirArea($_SESSION['login']['nivel']) == 3){
        $_SESSION['login']['empresa'] = Contratos::getEmpresa($_SESSION['login']['contrato']);
        if($_SESSION['login']['empresa'] == 0){
            header("location:criaempresa.php");
        }
    }
}

if(isset($_GET["sair"])){
    session_destroy();
    header("location:../login.html");
}

if($_SESSION['login']['nivel'] == 1.5 || $_SESSION['login']['nivel'] == 3 || $_SESSION['login']['nivel'] == 1){
    if($token->conferirAcesso($_SESSION['login']['dados']['id']) == 0){
        session_destroy();
        header("location:../login.html");
    }
}

// echo "<pre>";
// print_r(Relatorios::getFiliaisLucro());
// echo "</pre>";
$dadosempresa = Contratos::getDadosEmpresa((isset($_SESSION['login']['empresa']))?$_SESSION['login']['empresa'] : 0,$_SESSION['login']['dados']['id']);
$relatorios = Relatorios::getAdminPanel();
$relatoriosvendas = Relatorios::getVendas("empresa","","");
$relatoriosservicos = Relatorios::getServicos("empresa","","");
$relatorioscolaboradores = Relatorios::getColaboradores("empresa");
$relatoriosdespesas = Relatorios::getDespesas("empresa");
$relatoriosreps = Relatorios::getReposicoes("empresa","","");
$relatorioscomissoesvendas= Relatorios::getComissoesVendas("empresa");
$relatoriosComissoesServicos= Relatorios::getComissoesServicos("empresa");
//echo $relatoriosreps;
// echo "<pre>";
// print_r($_SESSION['login']);
// echo "</pre>";
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
        <link href="../css/libs/styles.css" rel="stylesheet" />
        <link href="../css/libs/scrollable-tabs.css" rel="stylesheet" />
        <link href="../css/libs/scrollable-tabs.min.css" rel="stylesheet" />
         <!--jQuery-->
         <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
         <!--LOAD-->
         <link rel="stylesheet" href="../css/libs/load.css">
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
                if($_SESSION['login']['nivel'] == 1.5){
                    echo "Painel de controle";
                    echo "<hr>";
                    echo "<i class='fa fa-user'></i> ".$dadosempresa['usuario']['NMUsuario'];
                }elseif($_SESSION['login']['nivel'] == 3.0){
                    echo $dadosempresa['empresa']['NMRazaoEmpresa'];
                }else{
                    echo "Painel de controle";
                }
                ?>
                </div>
                <div class="list-group list-group-flush navegacao">
                    <?php
                    if($_SESSION['login']['nivel'] == 1 || $_SESSION['login']['nivel'] == 1.5 || $_SESSION['login']['nivel'] == 2 || $_SESSION['login']['nivel'] == 2.5){
                    ?>
                    <?php if(Autenticacao::userPerm(1,"CON")):?><a class="list-group-item list-group-item-action list-group-item-light p-3 produtos border-bottom white" data-value="contratos.php" style="cursor:pointer;"><i class="fa-solid fa-file-contract"></i>&nbsp;Contratos</a><?php endif?>
                    <?php if(Autenticacao::userPerm(1,"USU") && $_SESSION['login']['nivel'] == 1.5 || $_SESSION['login']['nivel'] == 3 || $_SESSION['login']['nivel'] == 1):?><a class="list-group-item list-group-item-action list-group-item-light p-3 pontosdevenda border-bottom white"  data-value="usuarios.php" style="cursor:pointer;"><i class="fa-solid fa-users"></i>&nbsp;Usuários</a><?php endif?>
                    <?php
                    }else{
                    ?>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 produtos border-bottom white" data-value="filiais.php" style="cursor:pointer;"><i class="fa-solid fa-building"></i>&nbsp;Filiais</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 produtos border-bottom white" data-value="colaboradores.php" style="cursor:pointer;"><i class="fa-solid fa-people-roof"></i>&nbsp;Colaboradores</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 pontosdevenda border-bottom white"  data-value="usuarioscli.php" style="cursor:pointer;"><i class="fa-solid fa-users"></i>&nbsp;Usuários</a>
                    <?php
                    }
                    ?>
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
                                <li class="nav-item active"><a class="nav-link text-white" href="index.php">Home</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usuário</a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item " href="index.php?sair">Sair</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                
                <div class="carregamento">
                <div class="loader"></div>
                </div>
                <div class="container-fluid conteudo">
                <!-----------INICIO DOS RELATORIOS------------->
                <?php
                if($_SESSION['login']['nivel'] == 1){
                ?>
                <div class="col-sm-12 relatoriosadmin">
                    <div class="row ">
                        <!--CARD 1-->
                        <div class="col-xl-3 col-lg-6 relatorioadmin">
                            <div class="card l-bg-fr">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-solid fa-file-contract"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0">Contratos</h5>
                                    </div>
                                    <div class="row align-items-center mb-2 d-flex">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?=$relatorios['qtContratos']?>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--CARD 2-->
                        <div class="col-xl-3 col-lg-6 relatorioadmin">
                            <div class="card l-bg-fr">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0">MRR</h5>
                                    </div>
                                    <div class="row align-items-center mb-2 d-flex">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?=FRGeral::trataValor($relatorios['mrr'],0)?>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--CARD 3-->
                        <div class="col-xl-3 col-lg-6 relatorioadmin">
                            <div class="card l-bg-fr">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0">ARR</h5>
                                    </div>
                                    <div class="row align-items-center mb-2 d-flex">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                            <?=FRGeral::trataValor($relatorios['arr'],0)?>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--CARD 4-->
                        <div class="col-xl-3 col-lg-6 relatorioadmin">
                            <div class="card l-bg-fr">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0">Revendedores</h5>
                                    </div>
                                    <div class="row align-items-center mb-2 d-flex">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                0
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--CARD 5-->
                        <div class="col-xl-3 col-lg-6 relatorioadmin">
                            <div class="card l-bg-fr">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0">Inadimplentes</h5>
                                    </div>
                                    <div class="row align-items-center mb-2 d-flex">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                            <?=$relatorios['qtInativos']?>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--FIM DOS CARDS-->
                    </div>
                </div>
                <canvas id="relPlanos">

                </canvas>
                <?php
                }elseif($_SESSION['login']['nivel'] == 3.0){
                ?>
                <!-- <h1 style="text-align:center">Estatisticas</h1> -->
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
                <!--ESTATISTICAS DE PRODUTOS-->
                <!-- <h2 style="text-align:center">Categorias Mais Vendidas</h2> -->
                <div class="relCats">
                    <canvas id="relCats"></canvas>
                </div>
                <div class="relSirvissos">
                    <canvas id="relSirvissos"></canvas>
                </div>
                <!---->
                <!-- <h1 style="text-align:center">Financeiro</h1> -->

                <!--FILIAL 2-->
                <?php
                }
                ?>
                <!----------------FIM DOS RELATORIOS---------------------------->
                </div>
                
            </div>
            
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
        <script src="../js/relatorios.js"></script>
    </body>
</html>
