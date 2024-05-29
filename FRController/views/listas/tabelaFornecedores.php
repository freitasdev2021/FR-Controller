<?php
require"../../../Configs/configs.php";

$registros = $fornecedores->listarFornecedores($_SESSION['login']['filial']);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $inderesso = json_decode($DSEndFornecedor,true);
        extract($inderesso);
        $item = [];
        $zapZap = $DSTelefoneFornecedor;
        $item[] = "<strong style='cursor:pointer' onclick='editarFornecedor($IDFornecedor)'>".$NMFornecedor."</strong>";
        $item[] = $DSEmailFornecedor;
        $item[] = FRGeral::formataTelefone($DSTelefoneFornecedor);
        $item[] = $rua.", ".$complemento.", ".$numero.", ".$bairro." - ".$cidade."/".$uf;
        $item[] = "
        <a class='btn btn-secondary btn-xs btn-sm' target='_blank' href='mailto:$DSEmailFornecedor'><i class='fa-solid fa-envelope'></i></a>
        <a class='btn btn-success btn-xs btn-sm' target='_blank' href='https://api.whatsapp.com/send/?phone=".str_replace('-','',$zapZap)."&text&type=phone_number'><i class='fa-brands text-white fa-whatsapp'></i></a>
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