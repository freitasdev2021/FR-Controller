<?php
require"../../../Configs/configs.php";


$registros= Vendas::getListaVendasInsumos($_SESSION['login']['filial']);
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

        $lucro = $NUCustoProduto * $NUUnidadesVendidas;
        $item = [];
        $item[] = $NMProduto;
        $item[] = FRGeral::trataValor($VLVenda,0)." (".FRGeral::trataValor($VLVenda-$lucro,0)." de Lucro)";
        $item[] = $NUUnidadesVendidas;
        $item[] = $NMPagamento." (".$desconto.")";
        $item[] = (!empty($NMPromo))?$NMPromo : 'Sem Promoção';;
        $item[] = $NMCliente;
        $item[] = $DSTipoServico;
        $item[] = (!empty($NMColaborador))?$NMColaborador : 'Admin';
        $item[] = FRGeral::data($DTVenda,'d/m/Y - H:i:s');
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