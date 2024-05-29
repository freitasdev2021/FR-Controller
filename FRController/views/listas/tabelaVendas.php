<?php
require"../../../Configs/configs.php";


$registros= Vendas::getListaVendas($_SESSION['login']['filial']);
$registros_total = mysqli_num_rows($registros);
if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $lucro = $NUCustoProduto * $NUUnidadesVendidas;

        if($TPDesconto > 0){
            if($TPDesconto == 1){
                $desconto = $QTDesconto."% de Desconto";
            }else{
                $desconto = "R$ ".$QTDesconto;
            }
        }else{
            $desconto = "Sem desconto";
        }

        $item = [];
        $item[] = $NMProduto;
        $item[] = FRGeral::trataValor($VLVenda,0)." (".FRGeral::trataValor($VLVenda-$lucro,0)." de Lucro)";
        $item[] = $NUUnidadesVendidas;
        $item[] = $NMPagamento." (".$desconto.")";
        $item[] = (!empty($NMPromo))?$NMPromo : 'Sem Promoção';
        $item[] = (!empty($NMCliente))?$NMCliente : 'Cliente não identificado';
        $item[] = (!empty($NMPdv))?$NMPdv : 'Balcão';
        $item[] = FRGeral::data($DTVenda,'d/m/Y - H:i:s');
        $item[] = (!empty($NMColaborador))?$NMColaborador : 'Admin';
        ob_start();
        ?>
        <button class='btn btn-fr btn-xs' onclick='devolveProduto(<?=$IDVenda?>,<?=$DSGarantiaProduto?>,"<?=$DTVenda?>",<?=$NUUnidadesVendidas?>)'>Cancelar</button>
        <?php
        $item[] = ob_get_clean();
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