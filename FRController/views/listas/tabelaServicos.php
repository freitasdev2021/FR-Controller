<?php
require"../../../Configs/configs.php";


$registros= Servicos::getServicos($_SESSION['login']['filial']);
$registros_total = mysqli_num_rows($registros);
if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);

        $item = [];
        $item[] = "<strong style='cursor:pointer' onclick='editarServico($IDServico)'>".$DSTipoServico."</strong>";
        $item[] = FRGeral::trataValor($VLBase,0);
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