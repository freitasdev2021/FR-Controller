<?php
require"fpdf.php";
require"Configs.php";
$v_Setor = $_GET["Setor"];

switch($v_Setor){
    case "Empresas":
        class exportPDF extends FPDF{
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(58,5,'Lista de empresas parceiras',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',5);
                $this->Cell(70,6,'Nome fantasia',1,0,'C');
                $this->Cell(70,6,'Razao Social',1,0,'C');
                $this->Cell(70,6,'CNPJ',1,0,'C');
                $this->Cell(70,6,'Status',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $this->Cell(70,6,'teste',1,0,'C');
                $this->Ln();
            }
        }
    break;
    case "Usuarios":
        class exportPDF extends FPDF{
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(276,5,'Lista de usuarios',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(70,6,'Usuario',1,0,'C');
                $this->Cell(70,6,'Email',1,0,'C');
                $this->Cell(70,6,'Razão Social',1,0,'C');
                $this->Cell(70,6,'Status',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Usuarios::listarUsuarios($_SESSION["permUser"],$_SESSION["empresa"]);
                foreach($dados as $dado){
                if($dado['statusUser'] == 1){
                    $status = "Ativo";
                }else{
                    $status = "Inativo";
                }
                $this->Cell(70,6,$dado['nomeUsuario'],1,0,'C');
                $this->Cell(70,6,$dado['emailUsuario'],1,0,'L');
                $this->Cell(70,6,$dado['razaoSocial'],1,0,'L');
                $this->Cell(70,6,$status,1,0,'L');
                $this->Ln();
                }
            }
        }
    break;
    case "UsuariosEmpresa":
        class exportPDF extends FPDF{
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(276,5,'Lista de usuarios',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(70,6,'Usuario',1,0,'C');
                $this->Cell(70,6,'Email',1,0,'C');
                $this->Cell(70,6,'Status',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Usuarios::listarUsuarios($_SESSION["permUser"],$_SESSION["empresa"]);
                foreach($dados as $dado){
                if($dado['statusUser'] == 1){
                    $status = "Ativo";
                }else{
                    $status = "Inativo";
                }
                $this->Cell(70,6,$dado['nomeUsuario'],1,0,'C');
                $this->Cell(70,6,$dado['emailUsuario'],1,0,'L');
                $this->Cell(70,6,$status,1,0,'L');
                $this->Ln();
                }
            }
        }
    break;
    case "Fornecedores":
        class exportPDF extends FPDF{
            function header(){
                $this->SetFont('Helvetica','B',7);
                $this->Cell(276,5,'Lista de fornecedores',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',6);
                $this->Ln(10);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(40,6,'Nome',1,0,'C');
                $this->Cell(40,6,'Email',1,0,'C');
                $this->Cell(40,6,'Telefone',1,0,'C');
                $this->Cell(40,6,'Cep',1,0,'C');
                $this->Cell(120,6,'Endereço',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Fornecedores::listarFornecedores($_SESSION["empresa"]);
                foreach($dados as $dado){
                $this->Cell(40,6,$dado['nomeFornecedor'],1,0,'C');
                $this->Cell(40,6,$dado['emailFornecedor'],1,0,'L');
                $this->Cell(40,6,$dado['telefoneFornecedor'],1,0,'L');
                $this->Cell(40,6,$dado['cepFornecedor'],1,0,'L');
                $this->Cell(120,6,$dado['ruaFornecedor'].", ".$dado['complementoFornecedor'].", ".$dado['numeroFornecedor'].", ".$dado['bairroFornecedor']." - ".$dado['cidadeFornecedor']."/".$dado['ufFornecedor'],1,0,'L');
                $this->Ln();
                }
            }
        }
    break;
    case "Pagamentos":
        class exportPDF extends FPDF{
            
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(276,5,'Metodos de pagamento',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(70,6,'Nome',1,0,'C');
                $this->Cell(70,6,'Desconto',1,0,'C');
                $this->Cell(70,6,'Metodo',1,0,'C');
                $this->Cell(70,6,'Parcelas',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Pagamentos::listarPagamentos($_SESSION["empresa"]);
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
                $this->Cell(70,6,$dado['nomePagamento'],1,0,'C');
                $this->Cell(70,6,$desconto,1,0,'L');
                $this->Cell(70,6,$metodo,1,0,'L');
                $this->Cell(70,6,$parcelas,1,0,'L');
                $this->Ln();
                }
            }
        }
    break;
    case "Clientes":
        class exportPDF extends FPDF{
            
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(276,5,'Clientes',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(70,6,'Nome',1,0,'C');
                $this->Cell(70,6,'Email',1,0,'C');
                $this->Cell(70,6,'Telefone',1,0,'C');
                $this->Cell(70,6,'CPF',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Clientes::listarClientes($_SESSION["empresa"]);
                foreach($dados as $dado){            

                $this->Cell(70,6,$dado['nomeCliente'],1,0,'C');
                $this->Cell(70,6,$dado['emailCliente'],1,0,'L');
                $this->Cell(70,6,$dado['telefoneCliente'],1,0,'L');
                $this->Cell(70,6,$dado['cpfCliente'],1,0,'L');
                $this->Ln();

                }
            }
        }
    break;
    case "Devedor":
        class exportPDF extends FPDF{
            
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(140,5,'Clientes devedores',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(40,6,'Nome',1,0,'C');
                $this->Cell(40,6,'Email',1,0,'C');
                $this->Cell(40,6,'Telefone',1,0,'C');
                $this->Cell(40,6,'CPF',1,0,'C');
                $this->Cell(40,6,'Divida',1,0,'C');
                $this->Cell(40,6,'Divida desde',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Clientes::listarDevedores($_SESSION["empresa"]);
                foreach($dados as $dado){            

                $this->Cell(40,6,$dado['nomeCliente'],1,0,'C');
                $this->Cell(40,6,$dado['emailCliente'],1,0,'L');
                $this->Cell(40,6,$dado['telefoneCliente'],1,0,'L');
                $this->Cell(40,6,$dado['cpfCliente'],1,0,'L');
                $this->Cell(40,6,$dado['valorDivida'],1,0,'L');
                $this->Cell(40,6,$dado['dividaDesde'],1,0,'L');
                $this->Ln();

                }
            }
        }
    break;
    case "Crediario":
        class exportPDF extends FPDF{
            
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(140,5,'Clientes com crédito',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(40,6,'Nome',1,0,'C');
                $this->Cell(40,6,'Email',1,0,'C');
                $this->Cell(40,6,'Telefone',1,0,'C');
                $this->Cell(40,6,'CPF',1,0,'C');
                $this->Cell(40,6,'Credito',1,0,'C');
                $this->Cell(40,6,'Credito desde',1,0,'C');
                $this->Cell(40,6,'Credito ate',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Clientes::listarCrediarios($_SESSION["empresa"]);
                foreach($dados as $dado){            

                $this->Cell(40,6,$dado['nomeCliente'],1,0,'C');
                $this->Cell(40,6,$dado['emailCliente'],1,0,'L');
                $this->Cell(40,6,$dado['telefoneCliente'],1,0,'L');
                $this->Cell(40,6,$dado['cpfCliente'],1,0,'L');
                $this->Cell(40,6,$dado['NUCredito'],1,0,'L');
                $this->Cell(40,6,$dado['creditoDesde'],1,0,'L');
                $this->Cell(40,6,$dado['creditoAte'],1,0,'L');
                $this->Ln();

                }
            }
        }
    break;
    case "Pagar":
        class exportPDF extends FPDF{
            
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(140,5,'Despesas',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(70,6,'Nome da conta',1,0,'C');
                $this->Cell(40,6,'Expedição',1,0,'C');
                $this->Cell(40,6,'Vencimento',1,0,'C');
                $this->Cell(40,6,'Valor',1,0,'C');
                $this->Cell(40,6,'Status',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Financeiro::listarPagar($_SESSION["empresa"]);
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
                $this->Cell(70,6,$dado['nomeContaPagar'],1,0,'L');
                $this->Cell(40,6,$dado['expedicaoConta'],1,0,'L');
                $this->Cell(40,6,$dado['vencimentoConta'],1,0,'L');
                $this->Cell(40,6,$dado['valorConta'],1,0,'L');
                $this->Cell(40,6,$statusPagar,1,0,'L');
                $this->Ln();

                }
            }
        }
    break;
    case "Produtos":
        class exportPDF extends FPDF{
            
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(100,5,'Produtos',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(90,6,'Nome',1,0,'C');
                $this->Cell(50,6,'Categoria',1,0,'C');
                $this->Cell(20,6,'Estoque',1,0,'C');
                $this->Cell(30,6,'Entrada',1,0,'C');
                $this->Cell(30,6,'Validade',1,0,'C');
                $this->Cell(20,6,'Custo',1,0,'C');
                $this->Cell(20,6,'Valor',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Produtos::listarProdutos($_SESSION["empresa"]);
                foreach($dados as $dado){            
                $this->Cell(90,6,$dado['nomeProduto'],1,0,'C');
                $this->Cell(50,6,$dado['categoriaProduto'],1,0,'L');
                $this->Cell(20,6,$dado['estoqueProduto'],1,0,'L');
                $this->Cell(30,6,$dado['entradaProduto'],1,0,'L');
                $this->Cell(30,6,$dado['validadeProduto'],1,0,'L');
                $this->Cell(20,6,$dado['custoProduto'],1,0,'L');
                $this->Cell(20,6,$dado['valorProduto'],1,0,'L');
                $this->Ln();

                }
            }
        }
    break;
    case "Promocoes":
        class exportPDF extends FPDF{
            
            function header(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(100,5,'Promocoes',0,0,'C');
                $this->Ln();
                $this->setFont('Times','',12);
                $this->Ln(20);
            }
            function headerTable(){
                $this->SetFont('Helvetica','B',14);
                $this->Cell(90,6,'Nome',1,0,'C');
                $this->Cell(30,6,'Desconto',1,0,'C');
                $this->Cell(30,6,'Inicio',1,0,'C');
                $this->Cell(30,6,'Fim',1,0,'C');
                $this->Cell(30,6,'Status',1,0,'C');
                $this->Ln();
            }
            function bodyTable(){
                $this->SetFont('Helvetica','B',10);
                $dados = Promocoes::listarPromocoes($_SESSION["empresa"]);
                foreach($dados as $dado){            
                $this->Cell(90,6,$dado['nomePromo'],1,0,'C');
                $this->Cell(30,6,$dado['descontoPromo'],1,0,'L');
                $this->Cell(30,6,$dado['inicioPromo'],1,0,'L');
                $this->Cell(30,6,$dado['terminoPromo'],1,0,'L');
                $this->Cell(30,6,"-",1,0,'L');
                $this->Ln();

                }
            }
        }
    break;

}

$exportPdf = new exportPDF();
$exportPdf->AliasNbPages();
$exportPdf->AddPage('P','A4',0);
$exportPdf->headerTable();
$exportPdf->bodyTable();
$exportPdf->Output();
