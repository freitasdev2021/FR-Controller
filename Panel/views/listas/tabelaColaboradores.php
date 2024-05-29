<?php
require"../../../Configs/configs.php";

$IDContrato = (isset($_SESSION['login']['contrato']) ? $_SESSION['login']['contrato'] : 0 );
$IDEmpresa = Contratos::getEmpresa($IDContrato);

$registros= Contratos::getColaboradores($IDEmpresa);
$registros_total = mysqli_num_rows($registros);
if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);

        $item = [];
        $item[] = "<strong style='cursor:pointer' onclick='editarColaborador($IDColaborador)'>".$NMColaborador."</strong>";
        $item[] = $NMCargoColaborador;
        $item[] = FRGeral::trataValor($VLSalario,0);
        $item[] = FRGeral::cpfCnpj($NUCpfColaborador,'###.###.###-##');
        $item[] = FRGeral::data($DTAdmissao,"d/m/Y");
        $item[] = $NMFilial;
        $item[] = ($STAcesso) ? "<strong class='text-success'>Ativado</strong>" : "<strong class='text-danger'>Desativado</strong>";
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
