<?php
require"../../../Configs/configs.php";

$registros= $clientes->listarCrediarios($_SESSION['login']['filial']);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $item = [];
    
    
        $item[] = "<strong style='cursor:pointer' onclick='editarCrediario($IDCrediario)'>".$NMCliente."</strong>";
        $item[] = $NMEmailCliente;
        $item[] = FRGeral::formataTelefone($NUTelefoneCliente);
        $item[] = FRGeral::cpfCnpj($NUCpfCliente,'###.###.###-##');
        $item[] = "R$ ".FRGeral::trataValor($NUCredito,0);
        $item[] = $DTInicioCredito;
        $item[] = $DTTerminoCredito;
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