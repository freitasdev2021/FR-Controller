<?php
require"class_Processamento.php";
$selectEmpresasVinculo = $empresas->listarEmpresas();
$selectClientes = $clientes->listarClientes($_SESSION['empresa']);
$select = $_POST['select'];
// $select = "clientes";

switch($select){
    case "empresaVinculo":
        foreach($selectEmpresasVinculo as $vinculoEmpresa){
            echo "<option value=".$vinculoEmpresa['IDEmpresa'].">".$vinculoEmpresa['razaoSocial']."</option>";
        }
    break;
    case "clientes":
        foreach($selectClientes as $cli){
            echo "<option value=".$cli['IDCliente'].">".$cli['nomeCliente']."</option>";
        }
    break;
}

?>