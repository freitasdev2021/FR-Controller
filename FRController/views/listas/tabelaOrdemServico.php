<?php
require"../../../Configs/configs.php";


$registros= Servicos::getOrdens($_SESSION['login']['filial']);
$registros_total = mysqli_num_rows($registros);
if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        if($STServico == 1){
            $situacao = "Finalizado";
            $ord = "saida";
        }else{
            $situacao = "Em Execução";
            $ord = "entrada";
        }
        $id_base64 = base64_encode($IDOrdem);
        $item = [];
        $item[] = "<strong>".$DSTipoServico."</strong>";
        $item[] = $NMCliente;
        $item[] = $NMColaborador;
        $item[] = $IDOrdem;
        $item[] = FRGeral::data($DTServico,'d/m/Y H:i:s');
        $item[] = ($STServico) ? 'Finalizado' : 'Em Execução';
        $item[] = "<a href='../FRController/views/ordemdeservico.php?ID=$id_base64&ordem=$ord' target='_blank'>$ord</a>";
        ob_start();
        if(Autenticacao::userPerm(2,"SER")){
        ?>
        <?php if($STServico == 0):?><button class='btn btn-primary btn-xs btn-sm' onclick='finalizaOrdem(<?=$IDOrdem?>,<?=$IDColaborador?>,<?=$IDCliente?>)'><i class='fa-solid fa-circle-down'></i></button><?php endif?>
        <?php if($STServico == 0):?><button class='btn btn-danger btn-xs btn-sm' onclick='apagaOrdem(<?=$IDOrdem?>)'><i class='fa-solid fa-trash'></i></button><?php endif?>
        <?php if($STServico == 0):?><a class='btn btn-warning btn-xs btn-sm' onclick='abrirCustos(<?=$IDOrdem?>)'><i class='fa fa-wrench'></i></a><?php endif?>
        <?php if($STServico == 1):?><button class="btn btn-fr btn-sm" onclick='cancelarOrdem(<?=$IDOrdem?>,<?=strval($DSGarantiaServico)?>,"<?=$DTSaida?>")'>Cancelar</button><?php endif?>
        <?php
        }
        ?>
        <a class='btn btn-secondary btn-sm' target='_blank' href='mailto:<?=$NMEmailCliente?>'><i class='fa-solid fa-envelope'></i></a>
        <a class='btn btn-success btn-sm' target='_blank' href='https://api.whatsapp.com/send/?phone=<?=$NUTelefoneCliente?>&text&type=phone_number'><i class='fa-brands text-white fa-whatsapp'></i></a>
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


?>