<?php
require"../../../Configs/configs.php";

$registros = Comissoes::getComissoes($_SESSION['login']['filial']);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);

        $item = [];
        $item[] = "<strong style='cursor:pointer;' onclick='editarComissao($IDComissao)'>".$NMComissao."</strong>";
        $item[] = $TPComissao;
        $item[] = $NUPorcentagem;
        if(Autenticacao::userPerm(2,"COM")){
        $item[] = "
        <button class='btn btn-success btn-xs btn-sm' onclick='listarComissionados($IDComissao)' ><i class='fa-solid fa-bag-shopping'></i></button>
        ";
        }
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