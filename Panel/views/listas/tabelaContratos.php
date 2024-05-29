<?php
require"../../../Configs/configs.php";

$registros= Contratos::getContratos();
$registros_total = mysqli_num_rows($registros);
if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $inderesso = json_decode($DSEndContrato,true);
        extract($inderesso);
        $item = [];
        $item[] = "<strong style='cursor:pointer' onclick='editarContrato($IDContrato)'>".$NMContratante."</strong>";
        $item[] = FRGeral::cpfCnpj($NUCpfContratante,'###.###.###-##');
        $item[] = $NMEmailContratante;
        $item[] = FRGeral::formataTelefone($NUTelefoneContato);
        $item[] = $rua.", ".$numero.", ".$bairro." - ".$cidade."/".$uf;
        $item[] = $NMPlano;
        $item[] = ($STContrato) ? "<strong class='text-success'>Ativado</strong>" : "<strong class='text-danger'>Desativado</strong>";
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
