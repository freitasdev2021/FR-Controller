<?php
require"../../../Configs/configs.php";


$registros= $financeiro->listarPagar($_SESSION['login']['filial']);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        //var_dump($v_fornecedor);
        extract($registro);
        $item = [];
        
        $venc = date('Y-m-d',strtotime($DTVencimentoConta));
        $hoje = date('Y-m-d');

        //INDICADOR DE DATA DE VALIDADE
        $datadivenssimento = date_create($DTVencimentoConta);
        $oje = date_create(date('Y-m-d H:i:s'));
        $intervalo = date_diff($oje,$datadivenssimento);
        //echo $intervalo->d;
        //echo $intervalo->format('%a%');
        $intervall = $intervalo->format('%a%')+1;
        if($intervall <= 3 && date('Y-m-d H:i:s') <=$DTVencimentoConta){
            $STVenc = "<strong class='text-danger'> A VENCER! </strong>";
        }else{
            $STVenc = "";
        }
        //////////
        $stbotao = "";
        if($venc < $hoje){
            if($STConta == 1){
                $statusPagar = "<b class='text-success'>Paga</b>";
                $STVenc = "";
                $stbotao = "disabled";
            }else{
                $statusPagar = "<b class='text-danger'>Atrasada</b>";
            }
        }else{
            if($STConta == 0){
                $statusPagar = "<b class='text-warning'>Pendente</b>";
            }elseif($STConta == 1){
                $statusPagar = "<b class='text-success'>Paga</b>";
                $STVenc = "";
                $stbotao = "disabled";
            }
        }
    
        $item[] = "<strong style='cursor:pointer;' onclick='editarContaPagar($IDConta)'>".$NMConta."</strong>";
        $item[] = date('d/m/Y H:i',strtotime($DTExpedicaoConta));
        $item[] = date('d/m/Y H:i',strtotime($DTVencimentoConta))." ".$STVenc;
        $item[] = "R$ ".FRGeral::trataValor($VLConta,0);
        $item[] = $statusPagar;
        $item[] = "
        <button class='btn btn-success btn-xs btn-sm' $stbotao onclick='pagarConta($IDConta)'>Pagar</button>
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