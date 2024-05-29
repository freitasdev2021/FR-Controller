<?php
require"../../../Configs/configs.php";

$registros = $pontos->listarPontos($_SESSION['login']['filial']);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $item = [];
        $item[] = "<strong style='cursor:pointer;' onclick='editarCaixa($IDCaixa)'>".$NMPdv."</strong>";
        $item[] = FRGeral::trataValor($vendas,0);
        $item[] = ($STCaixa == 1) ? 'Aberto' : 'Fechado';
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