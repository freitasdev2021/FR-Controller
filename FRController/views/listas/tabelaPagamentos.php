<?php
require"../../../Configs/configs.php";

$registros = $pagamentos->listarPagamentos($_SESSION['login']['filial']);
$registros_total = mysqli_num_rows((object)$registros);

//LISTA DE PAGAMENTOS

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $item = [];
    
        switch($DSMetodo){
            case 1:
            $metodo = "Pix";
            break;
            case 2:
            $metodo = "Cartão de crédito";
            break;
            case 3:
            $metodo = "Cartão de débito";
            break;
            case 4:
            $metodo = "Dinheiro";
            break;
            case 5:
            $metodo = "Boleto";
            break;
        }
    
        if($TPDesconto== 1){
            $desconto = $QTDesconto." %";
        }elseif($TPDesconto== 2){
            $desconto = "R$ ".FRGeral::trataValor($QTDesconto,0);
        }else{
            $desconto = "Sem desconto";
        }
    
        if($QTParcelas == 0){
            $parcelas = "A Vista";
        }else{
            $parcelas = $QTParcelas;
        }
    
        $item[] = "<strong style='cursor:pointer;' onclick='editarPagamento($IDPagamento)'>".$NMPagamento."</strong>";
        $item[] = $desconto;
        $item[] = $metodo;
        $item[] = $parcelas;
        $itensJSON[] = $item;
    }
}else{
    $itensJSON = [];
}

//RESPOSTA DO DATATABLES

$resultados = [
    "recordsTotal" => intval($registros_total),
    "recordsFiltered" => intval($registros_total),
    "data" => $itensJSON
];

echo json_encode($resultados);

?>