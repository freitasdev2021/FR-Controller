<?php
require"../../Configs/configs.php";
$v_Id = $_POST["ID"];
$v_Setor = $_POST["Setor"];
// $v_Id = 1;
// $v_Setor = "Devedor";



switch($v_Setor){
    case "Contrato":
        $dados = Contratos::getContratos();
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "Fornecedor":
        $dados = $fornecedores->listarFornecedor($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "Pagamento":
        $dados = $pagamentos->listarPagamento($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "Cliente":
        $dados = $clientes->listarCliente($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "Crediario":
        $dados = $clientes->listarCrediario($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "Devedor":
        $dados = $clientes->listarDevedor($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "ContaPagar":
        $dados = $financeiro->mostrarContaPagar($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "Ponto":
        $dados = $pontos->listarPonto($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "Produto":
        $dados = $produtos->listarProduto($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "Promo":
        $dados = $promocoes->listarPromocao($v_Id);
        foreach($dados as $dado){
            echo json_encode($dado);
        }
    break;
    case "vinculoPromo":
        $dados = $promocoes->getPromocional($v_Id);
        $produtosPromo = [];
        foreach($dados as $dado){
            array_push($produtosPromo,$dado);
        }
        echo json_encode($produtosPromo);
    break;
    case "buscarDevedor":
        $dados = $clientes->getSelectDevedores($_SESSION['login']['filial']);
        $devedores = [];
        foreach($dados as $dado){
            array_push($devedores,$dado);
        }
        echo json_encode($devedores);
    break;
    case "buscarCrediario":
        $dados = $clientes->getSelectCrediarios($_SESSION['login']['filial']);
        $crediarios = [];
        foreach($dados as $dado){
            array_push($crediarios,$dado);
        }
        echo json_encode($crediarios);
    break;
    case "Reposicoes":
        $dados = $produtos->getCompras($v_Id);
        $crediarios = [];
        foreach($dados as $dado){
            array_push($crediarios,$dado);
        }
        echo json_encode($crediarios);
    break;
    case "Comissao":
        $dados = Comissoes::getComissao($v_Id);
        $comissoes = [];
        foreach($dados as $dado){
            array_push($comissoes,$dado);
        }
        echo json_encode($comissoes);
    break;
    case "Comissionados":
        $dados = Comissoes::getComissionados($v_Id);
        $comissionados = [];
        foreach($dados as $dado){
            array_push($comissionados,$dado);
        }
        echo json_encode($comissionados);
    break;
    case "Servico":
        $dados = Servicos::getServico($v_Id);
        $servicos = [];
        foreach($dados as $dado){
            array_push($servicos,$dado);
        }
        echo json_encode($servicos);
    break;
    case "Obra":
        $dados = Servicos::getCustos($v_Id);
        $servicos = [];
        foreach($dados as $dado){
            array_push($servicos,$dado);
        }
        echo json_encode($servicos);
    break;
    case "Baixa":
        $ds = array("IDOrdem" => $v_Id,"IDFilial"=> $_SESSION['login']['filial'],"Tipo"=>"saida");
        $dados = Servicos::getOrdem($ds);
        ob_start();
        $produtos = json_decode($dados['maodeobra']);
        $pagamentos = Pagamentos::listarPagamentos($_SESSION['login']['filial']);
        ?>
        <p>Mão de Obra: <strong class="mobra" data-cru="<?=FRGeral::trataValor($dados['mobra'],0)?>" data-original="<?=FRGeral::trataValor($dados['mobra'],0)?>"><?=FRGeral::trataValor($dados['mobra'],0)?></strong></p>
        <p>Total + Mão de Obra: <strong class="pressoTotau"></strong></p>
        <p class="totalPg">Total a pagar <strong class="totalPagar"></strong></p>
        <div class="col-sm-12">
        <label for="justificativaDespesa">Método de Pagamento</label>
            <select name="pagamento" class="form-control">
                <option value="">Selecione</option>
                <?php
                foreach($pagamentos as $p){
                ?>
                <option value="<?=$p['IDPagamento']?>" data-metodo="<?=$p['DSMetodo']?>" data-parcelas="<?=$p['QTParcelas']?>" data-juros="<?=$p['NUJuros']?>" data-desconto="<?=$p['QTDesconto']?>" data-tipo="<?=$p['TPDesconto']?>"><?=$p['NMPagamento']?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <hr>
        <table class="table table-bordered text-center tabela tabela-reposicoes table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Valor</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                if(isset($produtos)){
                foreach($produtos as $p){
                    $novoValorProduto = Promocoes::confProdutoPromocional($p->id,$p->valor,$_SESSION['login']['filial']);
                    if($novoValorProduto != $p->valor){
                        $novopreco = $novoValorProduto;
                        $preco = "<s class='text-danger'>".FRGeral::trataValor($p->valor,0)."</s>"."<br><p class='presso'>".FRGeral::trataValor($novoValorProduto,0)."</p>";
                    }else{
                        $novopreco = $novoValorProduto;
                        $preco = "<p class='presso'>".FRGeral::trataValor($novoValorProduto,0)."</p>";
                    }
                ?>
                <tr>
                    <td><?=$p->produto?></td>
                    <td><?=$preco?></td>
                    <td class="quantidade"><?=$p->quantidade?></td>
                </tr>
                <?php
                }
                }
                ?>
            </tbody>    
        </table>
        <?php
        echo ob_get_clean();
    break;
    case "dadosCliente":
        echo Clientes::getPendencias($v_Id);
    break;
    case "setVenda":
    ob_start();
    $clientes = Clientes::listarClientes($_SESSION['login']['filial']);
    $pagamentos = Pagamentos::listarPagamentos($_SESSION['login']['filial']);
    $produtos = mysqli_fetch_assoc($produtos->listarProduto($v_Id));
    ?>
    <div class="col-sm-12">
        <figure>
            <figcaption><?=$produtos['NMProduto']?></figcaption>
            <img src="<?=$produtos['DSImagemProduto']?>" width="100%" height="400px">
            <figcaption style="display:flex;">
                Valor da venda: &nbsp;
                <strong>R$&nbsp;</strong>
                <strong id="valProd" data-cru="<?=FRGeral::trataValor(Promocoes::confProdutoPromocional($produtos['IDProduto'],$produtos['NUValorProduto'],$_SESSION['login']['filial']),0)?>" data-original="<?=FRGeral::trataValor(Promocoes::confProdutoPromocional($produtos['IDProduto'],$produtos['NUValorProduto'],$_SESSION['login']['filial']),0)?>"><?=FRGeral::trataValor(Promocoes::confProdutoPromocional($produtos['IDProduto'],$produtos['NUValorProduto'],$_SESSION['login']['filial']),0)?></strong>
            </figcaption>
            <p class="totalPg">Total a pagar:&nbsp;<strong class="totalPagar"><?=FRGeral::trataValor(Promocoes::confProdutoPromocional($produtos['IDProduto'],$produtos['NUValorProduto'],$_SESSION['login']['filial']),0)?></strong></p>
        </figure>
    </div>
    <hr>
    <form id="vendeProduto">
        <input type="hidden" name="produto_id" value="<?=$_POST['ID']?>">
        <input type="hidden" name="promocao_id" value="<?=$_POST['IDPromocao']?>">
        <input type="hidden" name="fornecedor_id" value="<?=$_POST['IDFornecedor']?>">
        <div class="col-sm-12">
            <label>Método de pagamento</label>
            <select name="pagamento" class="form-control">
                <option value="">Selecione</option>
                <?php
                foreach($pagamentos as $p){
                ?>
                <option value='<?=$p['IDPagamento']?>' data-metodo="<?=$p['DSMetodo']?>" data-parcelas="<?=$p['QTParcelas']?>" data-juros="<?=$p['NUJuros']?>" data-desconto="<?=$p['QTDesconto']?>" data-tipo="<?=$p['TPDesconto']?>"><?=$p['NMPagamento']?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col-sm-12">
            <label>Cliente</label>
            <select name="cliente" class="form-control norequire">
                <option value="">Selecione</option>
                <?php
                foreach($clientes as $c){
                ?>
                <option data-divida='<?=$c['divida']?>' value='<?=$c['IDCliente']?>'><?=$c['NMCliente']?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col-sm-12">
            <label>Quantidade</label>
            <input type='text' value='1' name='quantidade' class='form-control'>
        </div>
    </form>
    <?php
    echo ob_get_clean();
    break;
    case "verVendasCaixa":
    $vendasCaixa = Pontos::getVendas($v_Id);
    ?>
    <!--ACCORDEON INI-->
    <div class="accordion">
        <?php
        foreach($vendasCaixa as $vc){
            //$produtos = json_decode($vc['ANCupom'],true);
            $produtos = json_decode($vc['ANCupom'],true);
            $dadosParcela = Pagamentos::getDadosParcelasPag($produtos['IDPagamento']);
            //print_r($produtos);
        ?>
            <div class="accordion__header acordiao">
                <h2 class="tituloVenda"><?=$vc['cliente']?></h2>
                <span class="dataVenda"><?=$produtos['data']?></span>
                <span class="accordion__toggle"></span>
            </div>
            <div class="accordion__body acordiao">
                <table class="table table-mobile-responsive">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>V.Un</th>
                            <th>Q.T</th>
                            <th>V.Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    //print_r($produtos['produtos'][0][0]);
                    foreach($produtos['produtos'] as $p){
                    ?>
                        <tr>
                            <td><?=$p['NMProduto']?></td>
                            <td data-content="V.Un"><?=FRGeral::trataValor($p['NUValorProduto'],0)?></td>
                            <td data-content="Q.T"><?=$p['NUUnidadesVendidas']?></td>
                            <td data-content="V.Total"><?=FRGeral::trataValor($p['VLVenda'],0)?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                if($dadosParcela['QTParcelas'] > 0){
                    $parcelado = Pagamentos::jurosParcelas(FRGeral::trataValor($produtos['valorpagar'],1),$dadosParcela['QTParcelas'],$dadosParcela['NUJuros']);
                    switch($dadosParcela['DSMetodo']){
                        case 3:
                            $vPago = FRGeral::trataValor(Pagamentos::taxaMaquininha(FRGeral::trataValor($produtos['valorpagar'],1),$dadosParcela['NUJuros']),0);
                        break;
                        case 2:
                            $vPago = FRGeral::trataValor($parcelado['valorFinal'],0)." (".$parcelado['parcelas']."x".FRGeral::trataValor($parcelado['valorParcela'],0).")";
                        break;
                        default:
                            $vPago = $produtos['valorpagar'];
                    }
                }else{
                    $vPago = $produtos['valorpagar'];
                }
                ?>
                <strong>Valor Total:&nbsp; <?=$produtos['valorpagar']?></strong>
                <br>
                <strong>Método:&nbsp; <?=$produtos['pagamento']?></strong>
                <br>
                <strong class="totalPg">Valor Pago:&nbsp; <?=$vPago?></strong>
            </div>
        <?php
        }
        ?>
    </div>
    <!--ACCORDEON FIM-->
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
    <?php
    echo ob_get_clean();
    break;
    case "ComprasCliente":
    $comprasCliente = Clientes::getCompras($v_Id);
    ob_start();
    ?>
    <!--ACCORDEON INI-->
    <div class="accordion">
        <?php
        foreach($comprasCliente as $cc){
            //$produtos = json_decode($vc['ANCupom'],true);
            $produtos = json_decode($cc['ANCupom'],true);
            $dadosParcela = Pagamentos::getDadosParcelasPag($produtos['IDPagamento']);
            //print_r($produtos['produtos'][0]);
        ?>
            <div class="accordion__header acordiao">
                <h2 class="tituloVenda"><?=$produtos['data']?></h2>
                <span class="accordion__toggle"></span>
            </div>
            <div class="accordion__body acordiao">
                <table class="table table-mobile-responsive">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>V.Un</th>
                            <th>Q.T</th>
                            <th>V.Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    //print_r($produtos['produtos'][0][0]);
                    foreach($produtos['produtos'] as $p){
                    ?>
                        <tr>
                            <td><?=$p['NMProduto']?></td>
                            <td data-content="V.Un"><?=FRGeral::trataValor($p['NUValorProduto'],0)?></td>
                            <td data-content="Q.T"><?=$p['NUUnidadesVendidas']?></td>
                            <td data-content="V.Total"><?=FRGeral::trataValor($p['VLVenda'],0)?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                if($dadosParcela['QTParcelas'] > 0){
                    $parcelado = Pagamentos::jurosParcelas(FRGeral::trataValor($produtos['valorpagar'],1),$dadosParcela['QTParcelas'],$dadosParcela['NUJuros']);
                    switch($dadosParcela['DSMetodo']){
                        case 3:
                            $vPago = FRGeral::trataValor(Pagamentos::taxaMaquininha(FRGeral::trataValor($produtos['valorpagar'],1),$dadosParcela['NUJuros']),0);
                        break;
                        case 2:
                            $vPago = FRGeral::trataValor($parcelado['valorFinal'],0)." (".$parcelado['parcelas']."x".FRGeral::trataValor($parcelado['valorParcela'],0).")";
                        break;
                        default:
                            $vPago = $produtos['valorpagar'];
                    }
                }else{
                    $vPago = $produtos['valorpagar'];
                }
                ?>
                <strong>Valor Total:&nbsp; <?=$produtos['valorpagar']?></strong>
                <br>
                <strong>Método:&nbsp; <?=$produtos['pagamento']?></strong>
                <br>
                <strong class="totalPg">Valor Pago:&nbsp; <?=$vPago?></strong>
            </div>
        <?php
        }
        ?>
    </div>
    <!--ACCORDEON FIM-->
    <?php
    echo ob_get_clean();
    break;
    case "ServicosCliente":
        ob_start();
        $servicosCliente = Clientes::getServicosCliente($v_Id);
        ?>
        <!--ACCORDEON INI-->
        <div class="accordion">
            <?php
            foreach($servicosCliente as $sc){
                //$produtos = json_decode($vc['ANCupom'],true);
                $custosordem = json_decode($sc['maodeobra']);
                //print_r($produtos);
            ?>
                <div class="accordion__header acordiao">
                    <h2 class="tituloVenda"><?=$sc['previa']?></h2>
                    <span class="accordion__toggle"></span>
                </div>
                <div class="accordion__body acordiao">
                    <table class="table table-mobile-responsive">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Valor</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($custosordem)){
                        //print_r($produtos['produtos'][0][0]);
                        foreach($custosordem as $co){
                            $novoValorProduto = Promocoes::confProdutoPromocional($co->id,$co->valor,$_SESSION['login']['filial']);
                            if($novoValorProduto != $co->valor){
                                $novopreco = $novoValorProduto;
                                $preco = "<s class='text-danger'>".FRGeral::trataValor($co->valor,0)."</s>"."<br><p class='presso'>".FRGeral::trataValor($novoValorProduto,0)."</p>";
                            }else{
                                $novopreco = $novoValorProduto;
                                $preco = "<p class='presso'>".FRGeral::trataValor($novoValorProduto,0)."</p>";
                            }
                        ?>
                            <tr>
                                <td><?=$co->produto?></td>
                                <td data-content="Valor"><?=$preco?></td>
                                <td data-content="Quantidade" class="quantidade"><?=$co->quantidade?></td>
                            </tr>
                        <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <p>Mão de Obra: <strong class="mobra"><?=Vendas::getDescontoPagamento($sc['mobra'],$sc['id_pagamento'])?></strong></p>
                    <p>Total + Mão de Obra: <strong class="pressoTotau" data-metodo="<?=$sc['metodo']?>" data-juros="<?=$sc['juros']?>" data-parcelas="<?=$sc['parcelas']?>"></strong></p>
                    <p class="totalPg">Valor pago:&nbsp; <strong class="totalPagar"></strong></p>
                </div>
            <?php
            }
            ?>
        </div>
        <script>
            $('.accordion__header').click(function(e) {
                e.preventDefault();
                var currentIsActive = $(this).hasClass('is-active');
                $(this).parent('.accordion').find('> *').removeClass('is-active');
                if(currentIsActive != 1) {
                    $(this).addClass('is-active');
                    $(this).next('.accordion__body').addClass('is-active');
                    //CALCULOS
                    //SOMA INSUMOS
                    valorSomado = []
                    $(this).next('.accordion__body').find(".presso").each(function(){
                        quantidade = $(this).parents("tr").find(".quantidade").text()
                        presso = trataValor($(this).text(),1)
                        valorSomado.push(presso*quantidade)
                    })
                    //
                    var sum = 0;
                    for(var i =0;i<valorSomado.length;i++){
                        sum+=valorSomado[i];
                    }
                    totau = parseFloat(sum) + parseFloat(trataValor($(this).next('.accordion__body').find(".mobra").text(),1))
                    $(this).next('.accordion__body').find(".pressoTotau").text(trataValor(totau,0))
                    $(this).next('.accordion__body').find(".pressoTotau").attr("data-original",trataValor(totau,0))
                    //CALCULO DE ACORDO COM O METODO DE PAGAMENTO
                    if($(this).next('.accordion__body').find(".pressoTotau").attr("data-metodo") == 2){
                        metodoParcelado = jurosParcelas(trataValor($(this).next('.accordion__body').find(".pressoTotau").text(),1),$(this).next('.accordion__body').find(".pressoTotau").attr("data-parcelas"),$(this).next('.accordion__body').find(".pressoTotau").attr("data-juros"))
                        var parcelas = metodoParcelado.parcelas;
                        var valorParcela = metodoParcelado.valorParcela;
                        var vf = metodoParcelado.valorFinal;
                        var labelVal = trataValor(vf,0)+"("+parcelas+"x "+trataValor(valorParcela,0)+")";
                        $(this).next('.accordion__body').find(".totalPagar").text(labelVal)
                    }else if($(this).next('.accordion__body').find(".pressoTotau").attr("data-metodo") == 3){
                        var totalP = taxaMaquininha(parseFloat(trataValor($(this).next('.accordion__body').find(".pressoTotau").text(),1)),$(this).next('.accordion__body').find(".pressoTotau").attr("data-juros"))
                        //
                        valorSomado = []
                        $(this).next('.accordion__body').find(".presso").each(function(){
                            quantidade = $(this).parents("tr").find(".quantidade").text()
                            presso = trataValor($(this).text(),1)
                            valorSomado.push(presso*quantidade)
                        })
                        ////
                        var sum = 0;
                        for(var i =0;i<valorSomado.length;i++){
                            sum+=valorSomado[i];
                        }
                        $(this).next('.accordion__body').find(".totalPagar").text(trataValor(totalP,0))
                    }else{
                        $(this).next('.accordion__body').find(".totalPagar").text(trataValor(totau,0))
                    }
                    //FIM DOS CALCULOS
                }
            });
        </script>
        <!--ACCORDEON FIM-->
        <?php
        echo ob_get_clean();
        break;
        case "getPag":
            $arr = array();
            foreach(Relatorios::getPags($_SESSION['login']['filial']) as $pag){
                array_push($arr,$pag);
            }
            echo json_encode($arr);
        break;
        case "getServ":
            $arr = array();
            foreach(Relatorios::getCatAndServ("filial")['SERV'] as $cat){
                array_push($arr,$cat);
            }
            echo json_encode($arr);
        break;
        case "getCat":
            $arr = array();
            foreach(Relatorios::getCatAndServ("filial")['CAT'] as $cat){
                array_push($arr,$cat);
            }
            echo json_encode($arr);
        break;
        case "getPromos":
            $arr = array();
            foreach(Relatorios::getPromos($_SESSION['login']['filial']) as $promo){
                array_push($arr,$promo);
            }
            echo json_encode($arr);
        break;
        case "getMoveFilDozeMeses":
            echo json_encode(Relatorios::getEmpresaLucroTempo("filial","M",12));
        break;
        case "getMoveFilUmMes":
            echo json_encode(Relatorios::getEmpresaLucroTempo("filial","D",30));
        break;
        case "getMoveFilSeteDias":
            echo json_encode(Relatorios::getEmpresaLucroTempo("filial","D",7));
        break;
}

