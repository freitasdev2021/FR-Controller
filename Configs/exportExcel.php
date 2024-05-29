<?php
require"class_Processamento.php";
require"SimpleXLSXGen.php";
$v_Setor = $_GET["Setor"];

switch($v_Setor){
    case "Empresas":
        $table = [
            ["Nome fantasia","Razão social","CNPJ","Status"]
        ];
        $dados = $empresas->listarEmpresas();
        foreach($dados as $dado){
            if($dado['statusEmpresa'] == 1){
                $status = "Ativa";
            }else{
                $status = "Inativa";
            }
            $table[] = [$dado['nomeFantasia'],$dado['razaoSocial'],$dado['cnpjEmpresa'],$status];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Empresas.xlsx');
    break;
    case "Usuarios":
        $table = [
            ["Usuario","Email","Empresa","Status"]
        ];
        $dados = $usuarios->listarUsuarios($_SESSION["permUser"],$_SESSION["empresa"]);
        foreach($dados as $dado){
            if($dado['statusUser'] == 1){
                $status = "Ativo";
            }else{
                $status = "Inativo";
            }
            $table[] = [$dado['nomeUsuario'],$dado['emailUsuario'],$dado['razaoSocial'],$status];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Usuarios.xlsx');
    break;
    case "UsuariosEmpresa":
        $table = [
            ["Usuario","Email","Status"]
        ];
        $dados = $usuarios->listarUsuarios($_SESSION["permUser"],$_SESSION["empresa"]);
        foreach($dados as $dado){
            if($dado['statusUser'] == 1){
                $status = "Ativo";
            }else{
                $status = "Inativo";
            }
            $table[] = [$dado['nomeUsuario'],$dado['emailUsuario'],$status];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Usuarios.xlsx');
    break;
    case "Fornecedores":
        $table = [
            ["Usuario","Email","Telefone","Cep","Endereço"]
        ];
        $dados = $fornecedores->listarFornecedores($_SESSION["empresa"]);
        foreach($dados as $dado){
            $table[] = [$dado['nomeFornecedor'],$dado['emailFornecedor'],$dado['telefoneFornecedor'],$dado['cepFornecedor'],$dado['ruaFornecedor'].", ".$dado['complementoFornecedor'].", ".$dado['numeroFornecedor'].", ".$dado['bairroFornecedor']." - ".$dado['cidadeFornecedor']."/".$dado['ufFornecedor']];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Fornecedores.xlsx');
    break;
    case "Pagamentos":
        $table = [
            ["Nome","Desconto","Metodo","Parcelas"]
        ];
        $dados = $pagamentos->listarPagamentos($_SESSION["empresa"]);
        foreach($dados as $dado){

            switch($dado['metodoPagamento']){
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
        
            if($dado['tipoDesconto'] == 1){
                $desconto = $dado['descontoPagamento']." %";
            }elseif($dado['tipoDesconto'] == 2){
                $desconto = $dado['descontoPagamento']." R$";
            }else{
                $desconto = "Sem desconto";
            }
        
            if($dado['parcelasPagamento'] == 0){
                $parcelas = "A Vista";
            }else{
                $parcelas = $dado['parcelasPagamento'];
            }

            $table[] = [$dado['nomePagamento'],$desconto,$metodo,$parcelas];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Pagamentos.xlsx');
    break;
    case "Clientes":
        $table = [
            ["Nome","Email","Telefone","Cpf"]
        ];
        $dados = $clientes->listarClientes($_SESSION["empresa"]);
        foreach($dados as $dado){
            $table[] = [$dado['nomeCliente'],$dado['emailCliente'],$dado['telefoneCliente'],$dado['cpfCliente']];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Clientes.xlsx');
    break;
    case "Devedor":
        $table = [
            ["Nome","Email","Telefone","Cpf","Divida","Divida desde"]
        ];
        $dados = $clientes->listarDevedores($_SESSION["empresa"]);
        foreach($dados as $dado){
            $table[] = [$dado['nomeCliente'],$dado['emailCliente'],$dado['telefoneCliente'],$dado['cpfCliente'],$dado['valorDivida'],$dado['dividaDesde']];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Devedores.xlsx');
    break;
    case "Crediario":
        $table = [
            ["Nome","Email","Telefone","Cpf","Credito","Credito desde","Credito ate"]
        ];
        $dados = $clientes->listarCrediarios($_SESSION["empresa"]);
        foreach($dados as $dado){
            $table[] = [$dado['nomeCliente'],$dado['emailCliente'],$dado['telefoneCliente'],$dado['cpfCliente'],$dado['NUCredito'],$dado['creditoDesde'],$dado['creditoAte']];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Crediarios.xlsx');
    break;
    case "Pagar":
        $table = [
            ["Nome da conta","Expedição","Vencimento","Valor","Status"]
        ];
        $dados = $financeiro->listarPagar($_SESSION["empresa"]);
        foreach($dados as $dado){
            switch($dado['statusConta']){
                case 0:
                    $statusPagar = "Pendente";
                break;
                case 1:
                    $statusPagar = "Paga";
                break;
                case 2:
                    $statusPagar = "Atrasada";
                break;
            }
            $table[] = [$dado['nomeContaPagar'],$dado['expedicaoConta'],$dado['vencimentoConta'],$dado['valorConta'],$statusPagar];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Contas a pagar.xlsx');
    break;
    case "Produtos":
        $table = [
            ["Nome","Categoria","Estoque","Entrada","Validade","Custo Unitario","Valor Final"]
        ];
        $dados = $produtos->listarProdutos($_SESSION["empresa"]);
        foreach($dados as $dado){
            $table[] = [$dado['nomeProduto'],$dado['categoriaProduto'],$dado['estoqueProduto'],$dado['entradaProduto'],$dado['validadeProduto'],$dado['custoProduto'],$dado['valorProduto']];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Produtos.xlsx');
    break;
    case "Promocoes":
        $table = [
            ["Nome","Desconto","Inicio","Fim","Status"]
        ];
        $dados = $promocoes->listarPromocoes($_SESSION["empresa"]);
        foreach($dados as $dado){
            $table[] = [$dado['nomePromo'],$dado['descontoPromo'],$dado['inicioPromo'],$dado['terminoPromo'],"-"];
        }
        Shuchkin\SimpleXLSXGen::fromArray( $table )->downloadAs('Promoçoes.xlsx');
    break;
}