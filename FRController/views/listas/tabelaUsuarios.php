<?php
require"../../processamento/class_Processamento.php";

$permUser = $_SESSION["permUser"];
$empresaId = $_SESSION["empresa"];

$registros = $usuarios->listarUsuarios($permUser,$empresaId);
$registros_total= mysqli_num_rows($registros);

if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $item = [];
    
        if($statusUser== 1){
            $status = "<i class='btn btn-lg fa-solid fa-toggle-on' onclick='changeUsuario($IDUsuario,$statusUser)'></i>";
        }else{
            $status = "<i class='btn btn-lg fa-solid fa-toggle-off' onclick='changeUsuario($IDUsuario,$statusUser)'></i>";
        }
        if($IDUsuario == $_SESSION['idUser']){
            $item[] = $nomeUsuario." (Você)";
        }else{
            $item[] = $nomeUsuario;
        }
        $item[] = $emailUsuario;
        $item[] = $uAcesso;
        if($IDUsuario != $_SESSION['idUser']){
        $item[] = $status;
        $item[] = "
        <button class='btn btn-primary btn-xs btn-sm bt_editar_usuario' onclick='editarUsuario($IDUsuario,$IDEmpresa)' ><i class='nav-icon fa fa-pencil-alt'></i></button>
        <button class='btn btn-danger btn-xs btn-sm' onclick='excluirUsuario($IDUsuario)' ><i class='nav-icon fa fa-trash'></i></button>
        ";
        }else{
        $item[] = "<i class='btn btn-lg fa-solid fa-toggle-on disabled'></i>";
        $item[] = "
        <button class='btn btn-primary btn-xs btn-sm bt_editar_usuario disabled' ><i class='nav-icon fa fa-pencil-alt'></i></button>
        <button class='btn btn-danger btn-xs btn-sm disabled' ><i class='nav-icon fa fa-trash'></i></button>
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
