<?php
require"../../../Configs/configs.php";

$IDContrato = (isset($_SESSION['login']['contrato']) ? $_SESSION['login']['contrato'] : 0 );
$IDEmpresa = Contratos::getEmpresa($IDContrato);
$registros= Contratos::getFiliais($IDEmpresa);
$registros_total = mysqli_num_rows($registros);
if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $inderesso = json_decode($DSEnderecoJSON,true);
        extract($inderesso);
        $item = [];
        $item[] = "<strong style='cursor:pointer' onclick='editarFilial($IDFilial)'>".$NMFilial."</strong>";
        $item[] = $rua.", ".$numero.", ".$bairro." - ".$cidade."/".$uf;;
        $item[] = FRGeral::trataValor($folhaSalarial,0);
        $item[] = FRGeral::formataTelefone($NUTelefoneFilial);
        ob_start();
        ?>
        <td style="text-align:center;">
            <a class="btn btn-xs btn-fr" targe="_blank" href="../Configs/abreFilial.php?filial=<?=base64_encode($IDFilial)?>&open">Entrar</a>
        </td>
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