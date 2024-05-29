<?php
require"../../../Configs/configs.php";


$registros= Servicos::getListaServicos($_SESSION['login']['filial']);
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
        $item[] = $DSTipoServico;
        $item[] = $NMCliente;
        $item[] = $NMPagamento." (".$desconto.")";
        $item[] = $idord;
        $item[] = FRGeral::data($DTServico,'d/m/Y - H:i:s');
        $item[] = FRGeral::trataValor($mobra +$VLVenda,0)." (".FRGeral::trataValor($mobra + $VLVenda-$lucro,0)." de Lucro)";
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