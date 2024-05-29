<?php
require"../../../Configs/configs.php";

$registros= $clientes->listarDevedores($_SESSION['login']['filial']);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $item = [];
    
        $item[] = "<strong style='cursor:pointer' onclick='editarDevedor($IDDevedor)'>".$NMCliente."</strong>";
        $item[] = $NMEmailCliente;
        $item[] = FRGeral::formataTelefone($NUTelefoneCliente);
        $item[] = FRGeral::cpfCnpj($NUCpfCliente,'###.###.###-##');
        $item[] = "R$ ".FRGeral::trataValor($VLDivida,0);;
        $item[] = $DTInicioDivida;
        $item[] = "
        <a class='btn btn-secondary btn-xs btn-sm' target='_blank' href='mailto:$NMEmailCliente'><i class='fa-solid fa-envelope'></i></a>
        <a class='btn btn-success btn-xs btn-sm' target='_blank' href='https://api.whatsapp.com/send/?phone=$NUTelefoneCliente&text&type=phone_number'><i class='fa-brands text-white fa-whatsapp'></i></a>
        ";
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