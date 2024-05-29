<?php
require"../../../Configs/configs.php";

$registros = $promocoes->listarPromocoes($_SESSION['login']['filial']);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);

        if($TPDesconto == "R$"){
            $descontoPromocao = "R$ ".FRGeral::trataValor($NUDescontoPromo,0);
        }else{
            $descontoPromocao = intval(FRGeral::trataValor($NUDescontoPromo,0))." %";
        }

        if(date('Y-m-d',strtotime($DTTerminoPromo)) < date('Y-m-d') ){
            $STPromo = "<p class='text-danger'>Terminou</p>";
        }elseif(date('Y-m-d',strtotime($DTInicioPromo)) > date('Y-m-d')){
            $STPromo = "<p class='text-warning'>Começará em breve</p>";
        }else{
            $STPromo ="<p class='text-success'>Em andamento</p>";
        }

        $item = [];
        $item[] = "<strong style='cursor:pointer;' onclick='editarPromo($IDPromocao)'>".$NMPromo."</strong>";
        $item[] = $descontoPromocao;
        $item[] = date('d/m/Y H:i',strtotime($DTInicioPromo));;
        $item[] = date('d/m/Y H:i',strtotime($DTTerminoPromo));
        $item[] = $STPromo;
        $item[] = "
        <button class='btn btn-success btn-xs btn-sm' onclick='listarProdutoPromo($IDPromocao)' ><i class='fa-solid fa-bag-shopping'></i></button>
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