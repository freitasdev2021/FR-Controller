<?php
require"configs.php";
$v_setor = $_POST["setor"];
$ID = $_POST["ID"];
$atualStatus = $_POST["atualStatus"];
switch($v_setor){
    case "Contrato":
        $empresas->changeStatus($ID,$atualStatus);
    break;
    case "Usuario":
        $usuarios->changeUsuario($ID,$atualStatus);
    break;
    case "Conta":
        $financeiro->pagarConta($ID);
    break;
    case "Colaborador":
       echo $empresas->changeColaborador($_POST);
    break;
    case "OrdemServico":
        echo Servicos::cancelaOrdem($_POST);
    break;
}