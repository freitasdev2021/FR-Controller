<?php
require"../../../Configs/configs.php";

$IDContrato = (isset($_SESSION['login']['contrato']) ? $_SESSION['login']['contrato'] : 0 );
$IDEmpresa = Contratos::getEmpresa($IDContrato);

$registros= Usuarios::getUsuarios($IDEmpresa);
$registros_total = mysqli_num_rows($registros);
if($registros_total > 0){
    foreach($registros as $registro){
        extract($registro);
        $nvuser = json_decode($PMUsuario,true);

        $item = [];
        $item[] = "<strong style='cursor:pointer' onclick='editarUsuario($IDUsuario)'>".$NMUsuario."</strong>";
        $item[] = $NMEmailUsuario;
        if(isset($nvuser)){
            $permUs = array();
            foreach($nvuser[$NVUsuario] as $key => $val){
                if($key == "USU" && count($val) > 0){
                    array_push($permUs,"Usuarios");
                }
                if($key == "CON" && count($val) > 0){
                    array_push($permUs,"Contratos");
                }
            }
            $item[] = implode(",",$permUs);
        }else{
            $item[] = "Super ADM";
        }
        $item[] = (isset($DTUltimoAcesso))?FRGeral::data($DTUltimoAcesso,"d/m/Y - H:i"): '';
        $item[] = ($STUsuario) ? "<strong class='text-success'>Ativado</strong>" : "<strong class='text-danger'>Desativado</strong>";
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
