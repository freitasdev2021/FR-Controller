<?php
require"../../../Configs/configs.php";

$registros= $produtos->listarProdutos($_SESSION['login']['filial']);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        //CALCULO DE PROMOCOES
        $novoValorProduto = Promocoes::confProdutoPromocional($IDProduto,$NUValorProduto,$IDFilial);
        if($novoValorProduto != $NUValorProduto){
            $novopreco = $novoValorProduto;
            $preco = "<s class='text-danger'>".FRGeral::trataValor($NUValorProduto,0)."</s>"."<br>".FRGeral::trataValor($novoValorProduto,0);
        }else{
            $novopreco = $novoValorProduto;
            $preco = FRGeral::trataValor($novoValorProduto,0);
        }
        //
        //CALCULO DE CUSTO TOTAL
        $custoTotal = $NUCustoProduto*$NUEstoqueProduto;
        //
        if(isset($DTValidadeProduto)){
            $vld = FRGeral::data($DTValidadeProduto,'d/m/Y');
            //INDICADOR DE DATA DE VALIDADE
            $data = date_create($DTValidadeProduto);
            $hoje = date_create(date('Y-m-d H:i:s'));
            $intervalo = date_diff($hoje,$data);
            //echo $intervalo->d;
            //echo $intervalo->format('%a%');
            $intervall = $intervalo->format('%a%')+1;
            if($intervall <= 15 && date('Y-m-d H:i:s') <=$DTValidadeProduto){
                $Vencimento = FRGeral::data($DTEntradaProduto,'d/m/Y')." - ".$vld."<strong class='text-danger'> ".$intervall." Dias para vencer</strong>";
            }elseif(date('Y-m-d H:i:s') >=$DTValidadeProduto){
                $Vencimento = FRGeral::data($DTEntradaProduto,'d/m/Y')." - ".$vld."<strong class='text-danger'> VENCEU!</strong>";
            }else{
                $Vencimento = FRGeral::data($DTEntradaProduto,'d/m/Y')." - ".$vld;
            }
            //
        }else{
           $Vencimento = $vld = FRGeral::data($DTEntradaProduto,'d/m/Y');
        }
        //INDICADOR DE ESTOQUE
        if($NUEstoqueProduto == 0){
            $disabled = 'disabled';
        }else{
            $disabled = '';
        }
        if($NUEstoqueProduto < $NUEstoqueMinimo){
            $Estoque = "<strong class='text-danger'>".$NUEstoqueProduto."/".$NUEstoqueMinimo." (".$DSUnidadeProduto.")"."</strong>";
        }elseif($NUEstoqueProduto - $NUEstoqueMinimo <= $NUEstoqueMinimo + 5  ){
            $Estoque = "<strong class='text-warning'>".$NUEstoqueProduto."/".$NUEstoqueMinimo." (".$DSUnidadeProduto.")"."</strong>";
        }elseif($NUEstoqueProduto == 0){
            $Estoque = "<strong class='text-danger'>REPOR!</strong>";
        }else{
            $Estoque = $NUEstoqueProduto."/".$NUEstoqueMinimo." (".$DSUnidadeProduto.")";
        }
        //INDICADOR DE VENDAS
        if(Vendas::getQuantidadeVendas($IDProduto)['valorVendas'] >= $NUCustoTotal ){
            $Vendas = "<strong class='t-sucesso'>".FRGeral::trataValor(Vendas::getQuantidadeVendas($IDProduto)['valorVendas'],0)."/".FRGeral::trataValor($NUCustoTotal,0)."</strong>";
        }else{
            $valVendasLiq = Vendas::getQuantidadeVendas($IDProduto)['valorVendas'];
            $valVendasBrut = Vendas::getQuantidadeVendas($IDProduto)['valorVendasBruto'];
            $Vendas = FRGeral::trataValor($valVendasBrut,0)." (".FRGeral::trataValor($valVendasLiq,0)." Liqudos) / ".FRGeral::trataValor($NUCustoTotal,0);
        }
        $item = [];
        $item[] = ($DSImagemProduto) ? "<img style='cursor:pointer;' src='$DSImagemProduto' width='100px' height='100px' onclick='editarProduto($IDProduto)'>" : "<img style='cursor:pointer;' src='../img/noproduct.png' width='100px' onclick='editarProduto($IDProduto)' height='100px'>";
        $item[] = $preco;
        $item[] = $NMProduto;
        $item[] = $Estoque;
        $item[] = $Vencimento;
        $item[] = $Vendas;
        if($DSUnidadeProduto == "KG"){
            $item[] = "<button class='btn btn-fr $disabled ' onclick='venderProduto($IDProduto,$IDFornecedor,$IDPromocao)'><strong>Vender</strong> (".number_format(Vendas::getQuantidadeVendas($IDProduto)['quantidade'], 3, '.', ' ')." Vendido)</button>";
        }else{
            $item[] = "<button class='btn btn-fr $disabled ' onclick='venderProduto($IDProduto,$IDFornecedor,$IDPromocao)'><strong>Vender</strong> (".Vendas::getQuantidadeVendas($IDProduto)['quantidade']." Vendido)</button>";
        }
        $itensJSON[] = $item;
    }
}else{
    $itensJSON = [];
}

$resultados = [
    "recordsTotal" => intval($registros_total),
    "recordsFiltered" => intval($registros_total),
    "data" => $itensJSON
];

echo json_encode($resultados);

?>