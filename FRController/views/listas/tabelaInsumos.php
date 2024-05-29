<?php
require"../../../Configs/configs.php";

$registros= Servicos::getInsumos($_SESSION['login']['filial']);
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
        }else{
            $vld = FRGeral::data($DTEntradaProduto,'d/m/Y');;
        }
        //INDICADOR DE ESTOQUE
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
        //
        $item = [];
        $item[] = ($DSImagemProduto) ? "<img style='cursor:pointer;' src='$DSImagemProduto' width='100px' height='100px' onclick='editarInsumo($IDProduto)'>" : "<img style='cursor:pointer;' src='../img/noproduct.png' width='100px' onclick='editarInsumo($IDProduto)' height='100px'>";
        $item[] = $preco;
        $item[] = $NMProduto;
        $item[] = $Estoque;
        $item[] = FRGeral::data($DTEntradaProduto,'d/m/Y');
        $item[] = $Vendas;
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