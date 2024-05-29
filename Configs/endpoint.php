<?php
require"configs.php";
header("Access-Control-Allow-Origin: *");
if(isset($_GET['key']) && is_string($_GET['key'])){
    if(base64_decode($_GET['key']) == "MQY1159"){
        if(isset($_GET['produtos'])){
            $produtos = Produtos::listarProdutos(base64_decode($_GET['filial']));
            $listaProdutos = array();
            foreach($produtos as $p){
                $listaProdutos[] = array(
                    "IDProduto" => $p['IDProduto'],
                    "NMProduto" => $p['NMProduto'],
                    "NUEstoqueProduto" => $p['NUEstoqueProduto'],
                    "DSCodigoProduto" => $p['DSCodigoProduto'],
                    "DSImagemProduto" => $p['DSImagemProduto'],
                    "NUEstoqueMinimo" => $p['NUEstoqueMinimo'],
                    "IDPromocao" => $p['IDPromocao'],
                    "NUValorProduto" => Promocoes::confProdutoPromocional($p['IDProduto'],$p['NUValorProduto'],base64_decode($_GET['filial'])),
                    "IDFornecedor" => $p['IDFornecedor'],
                    "DSUnidadeProduto" => $p['DSUnidadeProduto']
                );
            }
            
            echo json_encode($listaProdutos);
        }
        if(isset($_GET['pagamentos'])){
            $pagamentos = Pagamentos::listarPagamentos(base64_decode($_GET['filial']));
            $listaPagamentos = array();
            foreach($pagamentos as $pag){
                $listaPagamentos[] = array(
                    "IDPagamento" => $pag['IDPagamento'],
                    "NMPagamento" => $pag['NMPagamento'],
                    "QTDesconto" => $pag['QTDesconto'],
                    "DSMetodo" => $pag['DSMetodo'],
                    "QTParcelas" => $pag['QTParcelas'],
                    "TPDesconto" => $pag['TPDesconto'],
                    "IDFilial" => $pag['IDFilial'],
                    "NUJuros" => $pag['NUJuros']
                );
            }
            echo json_encode($listaPagamentos);
        }
        if(isset($_GET['caixa'])){
            $pontos = Pontos::listarPontos(base64_decode($_GET['filial']));
            $listaPontos = array();
            foreach($pontos as $pon){
                $listaPontos[] = array(
                    "IDCaixa"  => $pon['IDCaixa'],
                    "NMPdv"    => $pag['NMPdv'],
                    "IDFilial" => $pag['IDFilial']
                );
            }
            echo json_encode($listaPontos);
        }
        if(isset($_GET['clientes'])){
            $listaClientes = array();
            $clientes = Clientes::listarClientes(base64_decode($_GET['filial']));
            foreach($clientes as $c){
                $listaClientes[] = array(
                    "IDCliente" => $c['IDCliente'],
                    "VLDivida" => $c['divida'],
                    "NMCliente" => $c['NMCliente'],
                    "NMEmailCliente" => $c['NMEmailCliente'],
                    "NUTelefoneCliente" =>$c['NUTelefoneCliente'],
                    "NUCpfCliente" => $c['NUCpfCliente'] 
                );
            }
            echo json_encode($listaClientes);
        }
        if(isset($_GET['cabecalhos'])){
            $header = mysqli_fetch_assoc(Cupons::getHeaderCupom(base64_decode($_GET['filial'])));
            echo json_encode($header);
        }
    }else{
        echo "CREDENCIAIS INCORRETAS";
    }
}