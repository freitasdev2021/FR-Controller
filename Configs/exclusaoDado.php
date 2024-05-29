<?php
require"configs.php";
$v_setor = $_POST["setor"];
if(isset($_POST["ID"])){
    $v_id = $_POST['ID'];
}
switch($v_setor){
    case "Contrato":
        $empresas->delContrato($_POST);
    break;
    case "Usuario":
        $usuarios->excluirUsuario($_POST);
    break;
    case "Fornecedor":
        echo $fornecedores->excluirFornecedor($v_id,$_POST['confirmacao']);
        //echo $v_id;
    break;
    case "Pagamento":
        $pagamentos->excluirPagamento($v_id);
    break;
    case "Cliente":
        echo $clientes->excluirCliente($v_id,$_POST['confirmacao']);
    break;
    case "Devedor":
        $clientes->excluirDevedor($v_id);
    break;
    case "Crediario":
        $clientes->excluirCrediario($v_id);
    break;
    case "ContaPagar":
        $financeiro->excluirContaPagar($v_id);
    break;
    case "Ponto":
        $pontos->excluirPonto($v_id);
    break;
    case "Produto":
        $produtos->excluirProduto($v_id);
    break;
    case "Promo":
        $promocoes->excluirPromocao($v_id);
    break;
    case "Colaborador":
        $empresas->delColaborador($_POST);
    break;
    case "Comissao":
        Comissoes::delComissao($v_id);
    break;
    case "Servico":
        Servicos::delServico($v_id);
    break;
    case "OrdemServico":
        Servicos::delOrdemServico($v_id);
    break;
}

