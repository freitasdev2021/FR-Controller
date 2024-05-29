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
                if($key == "PRO" && count($val) > 0){
                    array_push($permUs,"Produtos");
                }
                if($key == "SER" && count($val) > 0){
                    array_push($permUs,"Servicos");
                }
                if($key == "COM" && count($val) > 0){
                    array_push($permUs,"Comissoes");
                }
                if($key == "REL" && count($val) > 0){
                    echo "Relatórios, ";
                    array_push($permUs,"Relatorios");
                }
                if($key == "PDV" && count($val) > 0){
                    array_push($permUs,"Pontos de venda");
                }
                if($key == "FOR" && count($val) > 0){
                    array_push($permUs,"Fornecedores");
                }
                if($key == "PAG" && count($val) > 0){
                    array_push($permUs,"Pagamentos");
                }
                if($key == "PRM" && count($val) > 0){
                    array_push($permUs,"Promoções");
                }
                if($key == "CLI" && count($val) > 0){
                    array_push($permUs,"Clientes");
                }
                if($key == "FIN" && count($val) > 0){
                    array_push($permUs,"Financeiro");
                }
                if($key == "VEN" && count($val) > 0){
                    array_push($permUs,"Vendas");
                }
            }
            $item[] = implode(",",$permUs);
        }else{
            $item[] = "Super ADM";
        }
        $item[] = $NMColaborador;
        $item[] = $NMFilial;
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