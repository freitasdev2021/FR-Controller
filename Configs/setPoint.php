<?php
require"configs.php";
if(isset($_POST['key']) && is_string($_POST['key'])){
    if(base64_decode($_POST['key']) == "MQY1159"){
        if(isset($_POST['login'])){
            $v_emailAcesso = $_POST['email'];
            $v_senhaAcesso = $_POST['senha'];
            $SQL = mysqli_query(FRController::conectarDatabase(),<<<SQL
            SELECT 
            us.NVUsuario,
            us.PMUsuario,
            us.IDColaborador,
            CASE WHEN col.NMColaborador IS NULL THEN 'Admin' ELSE col.NMColaborador END as colaborador ,
            col.NMColaborador,
            us.NMEmailUsuario,
            us.NMSenhaUsuario,
            us.NMUsuario,
            us.IDUsuario,
            con.STContrato,
            us.STUsuario as STAcesso,
            CASE WHEN us.IDColaborador > 0 THEN col.IDFilial ELSE us.LOGFilial END as filial,
            CASE WHEN us.IDColaborador > 0 THEN
            ( SELECT
            CONCAT('[',
                GROUP_CONCAT(
                    '{'
                    ,'"id":"',c.IDCaixa,'"'
                    ,',"caixa":"',c.NMPdv,'"'
                    ,'}' 
                SEPARATOR ','),
            ']') FROM caixa c INNER JOIN filiais f USING(IDFilial) INNER JOIN empresas e USING(IDEmpresa) WHERE col.IDFilial = c.IDFilial AND c.STDelete IS NULL)
            ELSE
            ( SELECT
            CONCAT('[',
                GROUP_CONCAT(
                    '{'
                    ,'"id":"',c.IDCaixa,'"'
                    ,',"caixa":"',c.NMPdv,'"'
                    ,'}' 
                SEPARATOR ','),
            ']') FROM caixa c INNER JOIN filiais f USING(IDFilial) INNER JOIN empresas e USING(IDEmpresa) WHERE us.LOGFilial = c.IDFilial AND c.STDelete IS NULL)
            END as caixa
            FROM usuarios as us 
            LEFT JOIN colaboradores as col USING(IDColaborador) 
            LEFT JOIN contratos as con USING(IDContrato)
            LEFT JOIN empresas as emp USING(IDContrato)
            LEFT JOIN filiais as fil USING(IDEmpresa)  
            WHERE NMEmailUsuario = '$v_emailAcesso' AND NMSenhaUsuario = '$v_senhaAcesso' GROUP BY IDEmpresa 
            SQL); //CONSULTA - REALIZA A CONSULTA NO BANCO DE DADOS
            $login = mysqli_fetch_assoc($SQL);
            if($login){
                switch($login['NVUsuario']){
                    case 3:
                        if($login['STContrato'] == 1){
                            $retorno['acesso'] = array(
                                'colaborador' => $login['IDColaborador'],
                                'nomeColaborador' => $login['colaborador'],
                                'caixa' => $login['caixa'],
                                'filial' => $login['filial'],
                                "dados" => array(
                                    'id' => $login['IDUsuario'],
                                    "nome" => $login['NMUsuario'],
                                    'email' => $login['NMEmailUsuario'],
                                    'senha' => $login['NMSenhaUsuario']
                                )
                            );
                            $retorno['status'] = true;
                        }else{
                            $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Suporte</strong></h5>";
                            $retorno['status'] = false;
                        }
                    break;
                    case 3.5:
                        if($login['STContrato'] == 1){
                            if($login['STAcesso'] == 1){
                                if(Autenticacao::userPermOffline(1,"PDV",$login['NVUsuario'],$login['PMUsuario'])){
                                    $retorno['acesso'] = array(
                                        'colaborador' => $login['IDColaborador'],
                                        'nomeColaborador' => $login['colaborador'],
                                        'caixa' => $login['caixa'],
                                        'filial' => $login['filial'],
                                        "dados" => array(
                                            'id' => $login['IDUsuario'],
                                            "nome" => $login['NMUsuario'],
                                            'email' => $login['NMEmailUsuario'],
                                            'senha' => $login['NMSenhaUsuario']
                                        )
                                    );
                                    $retorno['status'] = true;
                                }else{
                                    $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Você não tem permissão no PDV</strong></h5>";
                                    $retorno['status'] = false;
                                }
                            }else{
                                $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Administrador</strong></h5>";
                                $retorno['status'] = false;
                            }
                        }else{
                            $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Suporte</strong></h5>";
                            $retorno['status'] = false;
                        }
                    break;
                    default:
                        $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Suporte</strong></h5>";
                        $retorno['status'] = false;
                }
            }else{
                $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Credenciais Incorretas</strong></h5>";
                $retorno['status'] = false;
            }
            echo json_encode($retorno);
        }
        if(isset($_POST['caixa'])){
            $nome = $_POST['pdv'];
            $senha = $_POST['senha'];
            $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM caixa WHERE IDCaixa = '$nome' AND NMSenhaPDV = '$senha' AND STDelete IS NULL ");
            $caixa = mysqli_fetch_assoc($SQL);
            if($caixa){
                $ID = $caixa['IDCaixa'];
                mysqli_query(FRController::conectarDatabase(),"UPDATE caixa SET STCaixa = 1, DTAberturaCaixa = NOW() WHERE IDCaixa = $ID");
                $retorno['id'] = $ID;
                $retorno['status'] = true;
            }else{
                $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Credenciais Incorretas</strong></h5>";
                $retorno['status'] = false;
            }
            echo json_encode($retorno);
        }
        if(isset($_POST['sinccliente'])){
            Clientes::sincronizaCliente($_POST);
        }
        if(isset($_POST['sinccupom'])){
            Cupons::sincronizaCupons($_POST);
        }
        if(isset($_POST['sincvendas'])){
            Vendas::sincronizaVendas($_POST);
        }
        if(isset($_POST['sincprodutos'])){
            Produtos::sincronizaProdutos($_POST['IDProduto'],$_POST['NUEstoque']);
        }
        if(isset($_POST['fechacaixa'])){
            $ID = $_POST['ID'];
            mysqli_query(FRController::conectarDatabase(),"UPDATE caixa SET STCaixa = 0, DTFechamentoCaixa = NOW() WHERE IDCaixa = $ID");
            $retorno['status'] = true;
            echo json_encode($retorno);
        }
        if(isset($_POST['adccliente'])){
            $dados = [
                "IDCliente" => $_POST['IDCliente'],
                "nomeCliente" => $_POST['nomeCliente'],
                "emailCliente" => $_POST['emailCliente'],
                "telefoneCliente" => $_POST['telefoneCliente'],
                "cpfCliente" => $_POST['cpfCliente'],
                "filial" => $_POST['filial']
            ];
            $clientes->salvarCliente($dados);
        }
        if(isset($_POST['vender'])){
            //DADOS DO CORPO DO CUPOM
            $headerCupom = mysqli_fetch_assoc(Cupons::getHeaderCupom($_POST['IDFilial']));
            $endereco = json_decode($headerCupom['DSEnderecoJSON']);
            $formaPagamento = mysqli_fetch_assoc(Pagamentos::listarPagamento($_POST['IDPagamento']));
            $produtosVendidos = json_decode($_POST['listaProdutosVendidos'],true);
            if($formaPagamento['TPDesconto'] == "1"){
                $forma = $formaPagamento['QTDesconto']."%";
            }elseif($formaPagamento['TPDesconto'] == "2"){
                $forma = "R$ ".$formaPagamento['QTDesconto'];
            }else{
                $forma = "0,00";
            }
            switch($formaPagamento['DSMetodo']){
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
            //$produtosArray[] = $produtosVendidos;
            $ANCupom = array(
                "empresa" => $headerCupom['NMRazaoEmpresa'],
                "filial" => $headerCupom['NMFilial'],
                "cnpj" => $headerCupom['NUCnpjEmpresa'],
                "data" => date('d/m/Y - H:i:s'),
                "produtos" => $produtosVendidos,
                "valorpagar" => FRGeral::trataValor($_POST['VLVenda'],0),
                "pagamento" => $metodo,
                "IDPagamento" => $_POST['IDPagamento']
            );
            //DADOS DO RESTO DO CUPOM
            foreach($produtosVendidos as $pv){
                if($formaPagamento['TPDesconto'] == "1"){
                    $vf = $pv['VLVenda'] - ($formaPagamento['QTDesconto']*$pv['VLVenda'])/100 ;
                }elseif($formaPagamento['TPDesconto'] == "2"){
                    $vf = $pv['VLVenda'] - $formaPagamento['QTDesconto'];
                }else{
                    $vf = $pv['VLVenda'];
                }
                $produto = array(
                    "IDProduto" => $pv['IDProduto'],
                    "IDFornecedor" => $pv['IDFornecedor'],
                    "IDPromocao" => $pv['IDPromocao'],
                    "IDCliente" => $pv['IDCliente'],
                    "IDColaborador" => $pv['IDColaborador'],
                    "IDCaixa" => $pv['IDCaixa'],
                    "NUUnidadesVendidas" => $pv['NUUnidadesVendidas'],
                    "IDFilial" => $pv['IDFilial'],
                    "IDPagamento" => $pv['IDPagamento'],
                    'VLVenda' => $vf,
                    'CDVenda' => $pv['CDVenda']
                );
                Vendas::setVenda($produto);
            }
            $envCupom = array(
                "IDCaixa" => $_POST['IDCaixa'],
                "CDVenda" => $_POST['CDVenda'],
                "ANCupom" => json_encode($ANCupom),
                "IDCliente" => $_POST['IDCliente'],
                "IDFilial" => $_POST['IDFilial']
            );
            if(Cupons::setCupom($envCupom)){
                $dadosParcela = Pagamentos::getDadosParcelasPag($_POST['IDPagamento']);
                if($dadosParcela['QTParcelas'] > 0){
                    $parcelado = Pagamentos::jurosParcelas($_POST['VLVenda'],$dadosParcela['QTParcelas'],$dadosParcela['NUJuros']);
                    switch($dadosParcela['DSMetodo']){
                        case 3:
                            $vPago = FRGeral::trataValor(Pagamentos::taxaMaquininha($_POST['VLVenda'],$dadosParcela['NUJuros']),0);
                        break;
                        case 2:
                            $vPago = FRGeral::trataValor($parcelado['valorFinal'],0)." (".$parcelado['parcelas']."x".FRGeral::trataValor($parcelado['valorParcela'],0).")";
                        break;
                        default:
                            $vPago = FRGeral::trataValor($_POST['VLVenda'],0);
                    }
                }else{
                    $vPago = FRGeral::trataValor($_POST['VLVenda'],0);
                }
                ob_start();
            ?>
            <table class="printer-ticket">
                <thead style="background:white">
                <tr>
                    <th class="title" colspan="3"><?=$headerCupom['NMRazaoEmpresa']?></th>
                </tr>
                <tr>
                    <th colspan="3"><?=date('d/m/Y - H:i:s')?></th>
                </tr>
                <tr>
                    <th colspan="3">
                        CNPJ <br />
                        <?=FRGeral::cpfCnpj($headerCupom['NUCnpjEmpresa'],'##.###.###/####-##')?>
                    </th>
                </tr>
                <tr>
                    <th class="ttu" colspan="3">
                        <b>Data:&nbsp;<?=date('d/m/Y - H:i:s')?></b>
                    </th>
                </tr>
                <tr>
                    <th class="ttu" colspan="3">
                        <b>Cupom não fiscal</b>
                    </th>
                </tr>
                <tr>
                    <th class="ttu" colspan="3">
                        <hr>
                        <b>Produtos</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <!--PRODUTO 1-->
                <tr class="top">
                    <td colspan="1"><b>Produto</b></td>
                    <td colspan="1"><b>CD</b></td>
                    <td colspan="1"><b>V.Un</b></td>
                    <td colspan="1"><b>QT</b></td>
                    <td colspan="1"><b>VT</b></td>
                </tr>
                <?php
                foreach($produtosVendidos as $pvc){
                ?>
                <tr>
                    <!--NOME-->
                    <td><?=$pvc['NMProduto']?></td>
                    <!--CODIGO-->
                    <td><?=$pvc['DSCodigoProduto']?></td>
                    <!--VALOR UNITARIO-->
                    <td><?=FRGeral::trataValor($pvc['NUValorProduto'],0)?></td>
                    <!--QUANTIDADE-->
                    <td><?=$pvc['NUUnidadesVendidas']?></td>
                    <!--VALOR TOTAL-->
                    <td><?=FRGeral::trataValor($pvc['VLVenda'],0)?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="sup ttu p--0" align="center">
                    <td colspan="4">
                        <b>Pagamento</b>
                    </td>
                </tr>
                <tr class="ttu">
                    <td colspan="2">Forma de Pagamento</td>
                    <td align="right"><?=$metodo?></td>
                </tr>
                <tr class="ttu">
                    <td colspan="2">Desconto</td>
                    <td align="right"><?=$forma?></td>
                </tr>
                <tr class="ttu">
                    <td colspan="2">Total</td>
                    <td align="right"><?=$vPago?></td>
                </tr>
                <tr class="sup">
                    <td colspan="3" align="center">
                        <b>Endereço:</b>
                    </td>
                </tr>
                <tr class="sup">
                    <td colspan="3" align="center">
                        <?=$endereco->rua.", ".$endereco->numero.", ".$endereco->bairro." - ".$endereco->cidade."/".$endereco->uf;?>
                    </td>
                </tr>
            </tfoot>
            </table>
            <?php
            echo ob_get_clean();
            }
        }
    }else{
        echo "CREDENCIAIS INCORRETAS";
    }
}