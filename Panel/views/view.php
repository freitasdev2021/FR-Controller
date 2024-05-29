<?php
require"../../Configs/configs.php";
$v_Id = $_POST["ID"];
$v_Setor = $_POST["Setor"];



switch($v_Setor){
    case "Contrato":
        $dados = Contratos::getContrato($v_Id);
        echo json_encode($dados);
    break;
    case "Usuario":
        $dados = Usuarios::getUsuario($v_Id);
        echo json_encode($dados);
    break;
    case "Filial":
        $dados = Contratos::getFilial($v_Id);
        echo json_encode($dados);
    break;
    case "Colaborador":
        $dados = Contratos::getColaborador($v_Id);
        echo json_encode($dados);
    break;
    case "getPlanos":
        $relatorios = Relatorios::getAdminPanel();
        $ret[] = $relatorios['starter'];
        $ret[] = $relatorios['ecommerce'];
        $ret[] = $relatorios['fiscal'];
        $ret[] = $relatorios['ecommercefiscal'];
        echo json_encode($ret);
    break;
    case "getCat":
        $arr = array();
        foreach(Relatorios::getCatAndServ("empresa")['CAT'] as $cat){
            array_push($arr,$cat);
        }
        echo json_encode($arr);
    break;
    case "getServ":
        $arr = array();
        foreach(Relatorios::getCatAndServ("empresa")['SERV'] as $cat){
            array_push($arr,$cat);
        }
        echo json_encode($arr);
    break;
    case "getMovFil":
        echo json_encode(Relatorios::getFiliaisLucro());
    break;
    case "getMoveFilDozeMeses":
        echo json_encode(Relatorios::getEmpresaLucroTempo("empresa","M",12));
    break;
    case "getMoveFilUmMes":
        echo json_encode(Relatorios::getEmpresaLucroTempo("empresa","D",30));
    break;
    case "getMoveFilSeteDias":
        echo json_encode(Relatorios::getEmpresaLucroTempo("empresa","D",7));
    break;
}

