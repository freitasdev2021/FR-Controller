<?php
require"configs.php";
if(isset($_POST["nomeUsuario"])){
    $dados = [
        "IDEmpresaVinculo" => $_POST["IDEmpresaVinculo"],
        "IDUsuario"        => $_POST["IDUsuario"],
        "Permissao"        => $_POST["permissaoUsuario"],
        "Usuario"          => $_POST["nomeUsuario"],
        "Email"            => $_POST["emailUsuario"],
        "Senha"            => $_POST["senhaUsuario"],
        "Status"           => $_POST["statusUsuario"],
    ];
    $usuarios->salvarUsuario($dados);
}elseif(isset($_POST["contratante"])){
    echo $empresas->setContrato($_POST);
}elseif(isset($_POST["nomeFornecedor"])){
    $dados = [
        "IDFornecedor" => $_POST["IDFornecedor"],
        "nomeFornecedor" => $_POST["nomeFornecedor"],
        "emailFornecedor" => $_POST["emailFornecedor"],
        "telefoneFornecedor" => $_POST["telefoneFornecedor"],
        "cepFornecedor" => $_POST["cepFornecedor"],
        "ufFornecedor" => $_POST["ufFornecedor"],
        "cidadeFornecedor" => $_POST["cidadeFornecedor"],
        "bairroFornecedor" => $_POST["bairroFornecedor"],
        "ruaFornecedor" => $_POST["ruaFornecedor"],
        "numeroFornecedor" => $_POST["numeroFornecedor"],
        "complementoFornecedor" => $_POST["complementoFornecedor"],
    ];
    // echo json_encode($dados);
    $fornecedores->salvarFornecedor($dados);
}elseif(isset($_POST["nomeMetodo"])){
    $dados = [
        "IDPagamento" => $_POST["IDPagamento"],
        "nomeMetodo" => $_POST["nomeMetodo"],
        "descontoMetodo" => $_POST["descontoMetodo"],
        "tipoMetodo" => $_POST["tipoMetodo"],
        "metodoMetodo" => $_POST["metodoMetodo"],
        "parcelasMetodo" => $_POST["parcelasMetodo"],
        "jurosMetodo" => $_POST['jurosMetodo']
    ];
    // echo json_encode($dados);
    $pagamentos->salvarPagamento($dados);
}elseif(isset($_POST['nomeCliente'])){
    $dados = [
        "IDCliente" => $_POST['IDCliente'],
        "nomeCliente" => $_POST['nomeCliente'],
        "emailCliente" => $_POST['emailCliente'],
        "telefoneCliente" => $_POST['telefoneCliente'],
        "cpfCliente" => $_POST['cpfCliente']
    ];
    $clientes->salvarCliente($dados);
}elseif(isset($_POST['nomeCrediario'])){
    $dados = [
        "IDCrediario" => $_POST['IDCrediario'],
        "nomeCrediario" => $_POST['nomeCrediario'],
        "creditoCrediario" => $_POST['creditoCrediario'],
        "creditoAte" => $_POST['creditoAte']
    ];
    $clientes->salvarCrediario($dados);
}elseif(isset($_POST['nomeDevedor'])){
    $dados = [
        "IDDevedor" => $_POST['IDDevedor'],
        "nomeDevedor" => $_POST['nomeDevedor'],
        "valorDivida" => $_POST['dividaDevedor']
    ];
    echo $clientes->salvarDevedor($dados);
}elseif(isset($_POST['nomeContaPagar'])){
    $dados = [
        "IDContaPagar" => $_POST['IDContaPagar'],
        "nomeContaPagar" => $_POST['nomeContaPagar'],
        "valorContaPagar" => $_POST['valorContaPagar'],
        "vencimentoContaPagar" => $_POST['vencimentoContaPagar'],
        "justificativaContaPagar" => $_POST['justificativaContaPagar'],
    ];
    $financeiro->salvarContaPagar($dados);
}elseif(isset($_POST['nomePdv'])){
    $pontos->salvarPonto($_POST);
}elseif(isset($_POST['categoria']) && $_POST['insumo'] == 0){
    $produtos->salvarProduto($_POST);
}elseif(isset($_POST['nomePromo'])){
    $dados = [
        "IDPromocao" => $_POST['IDPromocao'],
        "nomePromo" => $_POST['nomePromo'],
        "inicioPromo" => $_POST['inicioPromo'],
        "fimPromo" => $_POST['fimPromo'],
        "descontoPromo" => $_POST['descontoPromo'],
        "tipoPromo" => $_POST['tipoPromo'],
    ];
    $promocoes->salvarPromocao($dados);
}elseif(isset($_POST['IDPromo'])){
    
    if($promocoes->delPromocional($_POST['IDPromo'])){
        if(isset($_POST['IDProduto'])){
            foreach($_POST['IDProduto'] as $prod){
                $dados = [
                    'IDPromocao' => $_POST['IDPromo'],
                    'IDProduto' => $prod
                ];
                $promocoes->setPromocional($dados);
            }
        }
    }

}elseif(isset($_POST['senha'])){
    $usuarios->setRegistro($_POST);
}elseif(isset($_POST['fantasia'])){
    echo $empresas->setEmpresa($_POST);
}elseif(isset($_POST['empresa'])){
    $empresas->setFilial($_POST);
}elseif(isset($_POST['cargo'])){
    $empresas->setColaborador($_POST);
}elseif(isset($_POST['Produto'])){
    $produtos->setCompra($_POST);
}elseif(isset($_POST['tipoComissao'])){
    Comissoes::setComissao($_POST);
}elseif(isset($_POST['IDComissao'])){
    
    if(Comissoes::delComissionado($_POST['IDComissao'])){
        if(isset($_POST['IDColaborador'])){
            foreach($_POST['IDColaborador'] as $col){
                $dados = [
                    'IDComissao' => $_POST['IDComissao'],
                    'IDColaborador' => $col
                ];
                Comissoes::setComissionado($dados);
            }
        }
    }

}elseif(isset($_POST['categoria']) && $_POST['insumo'] == 1){
    $produtos->salvarProduto($_POST);
}elseif(isset($_POST['Insumo'])){
    Servicos::setCompra($_POST);
}elseif(isset($_POST['tipoServico'])){
    Servicos::setServico($_POST);
}elseif(isset($_POST['tipoOrdemServico'])){
    Servicos::setOrdemServico($_POST);
}elseif(isset($_POST['IDOrdem'])){
    
    if(Servicos::delCusto($_POST['IDOrdem'])){
        if(isset($_POST['IDProduto'])){
            foreach($_POST['IDProduto'] as $col){
                $dados = [
                    'IDOrdem' => $_POST['IDOrdem'],
                    'IDProduto' => $col['produto'],
                    'NUQuantidade' => $col['quantidade']
                ];
                Servicos::setCusto($dados);
            }
        }
    }

}elseif(isset($_POST['nota'])){
    Servicos::baixaServico($_POST);
}elseif(isset($_POST['NUUnidadesVendidas'])){
    $_POST['IDFilial'] = $_SESSION['login']['filial'];
    $_POST['IDColaborador'] = Contratos::getColaboradorByUser($_SESSION['login']['dados']['id']);
    $produtos = mysqli_fetch_assoc($produtos->listarProduto($_POST['IDProduto']));
    //DADOS DO CORPO DO CUPOM
    $headerCupom = mysqli_fetch_assoc(Cupons::getHeaderCupom($_SESSION['login']['filial']));
    $endereco = json_decode($headerCupom['DSEnderecoJSON']);
    $formaPagamento = mysqli_fetch_assoc(Pagamentos::listarPagamento($_POST['IDPagamento']));
    if($formaPagamento['TPDesconto'] == "1"){
        $forma = $formaPagamento['QTDesconto']."%";
    }elseif($formaPagamento['TPDesconto'] == "2"){
        $forma = "R$ ".$formaPagamento['QTDesconto'];
    }else{
        $forma = "0,00";
    }
    switch($formaPagamento['DSMetodo']){
        case 1:
            $metodo = "Pix";
        break;
        case 2:
            $metodo = "Cartão de crédito";
        break;
        case 3:
            $metodo = "Cartão de débito";
        break;
        case 4:
            $metodo = "Dinheiro";
        break;
        case 5:
            $metodo = "Boleto";
        break;
    }
    $produtosArray = array(
        "NMProduto" => $produtos['NMProduto'],
        'DSCodigoProduto' => $produtos['DSCodigoProduto'],
        'NUValorProduto' => Promocoes::confProdutoPromocional($produtos['IDProduto'],$produtos['NUValorProduto'],$_SESSION['login']['filial']),
        'NUUnidadesVendidas' => $_POST['NUUnidadesVendidas'],
        'VLVenda' => $_POST['VLVenda']
    );
    $ANCupom = array(
        "empresa" => $headerCupom['NMRazaoEmpresa'],
        "filial" => $headerCupom['NMFilial'],
        "cnpj" => $headerCupom['NUCnpjEmpresa'],
        "data" => date('d/m/Y - H:i:s'),
        "produtos" => array($produtosArray),
        "valorpagar" => FRGeral::trataValor($_POST['VLVenda'],0),
        "pagamento" => $metodo,
        "IDPagamento" => $_POST['IDPagamento']
    );
    //DADOS DO RESTO DO CUPOM
    if(Vendas::setVenda($_POST)){
        $envCupom = array(
            "IDCaixa" => 0,
            "CDVenda" => $_POST['CDVenda'],
            "ANCupom" => json_encode($ANCupom),
            "IDCliente" => $_POST['IDCliente'],
            "IDFilial" => $_SESSION['login']['filial']
        );
        if(Cupons::setCupom($envCupom)){
            $dadosParcela = Pagamentos::getDadosParcelasPag($_POST['IDPagamento']);
            if($dadosParcela['QTParcelas'] > 0){
                $parcelado = Pagamentos::jurosParcelas($_POST['VLVenda'],$dadosParcela['QTParcelas'],$dadosParcela['NUJuros']);
                switch($dadosParcela['DSMetodo']){
                    case 3:
                        $vPago = FRGeral::trataValor(Pagamentos::taxaMaquininha($_POST['VLVenda'],$dadosParcela['NUJuros']),0);
                    break;
                    case 2:
                        $vPago = FRGeral::trataValor($parcelado['valorFinal'],0)." (".$parcelado['parcelas']."x".FRGeral::trataValor($parcelado['valorParcela'],0).")";
                    break;
                    default:
                        $vPago = FRGeral::trataValor($_POST['VLVenda'],0);
                }
            }else{
                $vPago = FRGeral::trataValor($_POST['VLVenda'],0);
            }
        ?>
        <table class="printer-ticket">
            <thead style="background:white">
            <tr>
                <th class="title" colspan="3"><?=$headerCupom['NMRazaoEmpresa']?></th>
            </tr>
            <tr>
                <th colspan="3"><?=date('d/m/Y - H:i:s')?></th>
            </tr>
            <tr>
                <th colspan="3">
                    CNPJ <br />
                    <?=FRGeral::cpfCnpj($headerCupom['NUCnpjEmpresa'],'##.###.###/####-##')?>
                </th>
            </tr>
            <tr>
                <th class="ttu" colspan="3">
                    <b>Data:&nbsp;<?=date('d/m/Y - H:i:s')?></b>
                </th>
            </tr>
            <tr>
                <th class="ttu" colspan="3">
                    <b>Cupom não fiscal</b>
                </th>
            </tr>
            <tr>
                <th class="ttu" colspan="3">
                    <hr>
                    <b>Produtos</b>
                </th>
            </tr>
        </thead>
        <tbody>
            <!--PRODUTO 1-->
            <tr class="top">
                <td colspan="1"><b>Produto</b></td>
                <td colspan="1"><b>CD</b></td>
                <td colspan="1"><b>V.Un</b></td>
                <td colspan="1"><b>QT</b></td>
                <td colspan="1"><b>VT</b></td>
            </tr>
            <tr>
                <!--NOME-->
                <td><?=$produtos['NMProduto']?></td>
                <!--CODIGO-->
                <td><?=$produtos['DSCodigoProduto']?></td>
                <!--VALOR UNITARIO-->
                <td><?=FRGeral::trataValor($produtos['NUValorProduto'],0)?></td>
                <!--QUANTIDADE-->
                <td><?=$_POST['NUUnidadesVendidas']?></td>
                <!--VALOR TOTAL-->
                <td><?=FRGeral::trataValor($_POST['VLVenda'],0)?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="sup ttu p--0" align="center">
                <td colspan="4">
                    <b>Pagamento</b>
                </td>
            </tr>
            <tr class="ttu">
                <td colspan="2">Forma de Pagamento</td>
                <td align="right"><?=$metodo?></td>
            </tr>
            <tr class="ttu">
                <td colspan="2">Desconto</td>
                <td align="right"><?=$forma?></td>
            </tr>
            <tr class="ttu">
                <td colspan="2">Total</td>
                <td align="right"><?=$vPago?></td>
            </tr>
            <tr class="sup">
                <td colspan="3" align="center">
                    <b>Endereço:</b>
                </td>
            </tr>
            <tr class="sup">
                <td colspan="3" align="center">
                    <?=$endereco->rua.", ".$endereco->numero.", ".$endereco->bairro." - ".$endereco->cidade."/".$endereco->uf;?>
                </td>
            </tr>
        </tfoot>
        </table>
        <?php
        }
    }
}elseif(isset($_POST['QTDevolucao'])){
    Vendas::cancelaVenda($_POST);
}