<?php
header("Access-Control-Allow-Origin: *");
require"../../Configs/configs.php";

if($token->conferirLogin() == 0){
        header("location:../login.html");
}else{
    $_SESSION['login']['empresa'] = Contratos::getEmpresa($_SESSION['login']['contrato']);
    if($_SESSION['login']['nivel'] == 3){
        if($_SESSION['login']['empresa'] == 0){
            header("location:criaempresa.php");
        }
    }
}

if(isset($_GET["sair"])){
    session_destroy();
    header("location:../login.html");
}

if($token->conferirAcesso($_SESSION['login']['dados']['id']) == 0){
    session_destroy();
    header("location:../login.html");
}

// echo "<pre>";
// print_r($_SESSION['login']);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de serviço</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/nota.css">
</head>
<body>
<?php
if(is_string($_GET['ID'])){
    $ID = base64_decode($_GET['ID']);
    $ordem = Servicos::getOrdem(array(
        "IDOrdem" => $ID,
        "IDFilial" => $_SESSION['login']['filial'],
        "Tipo" => $_GET['ordem']
    ));
    $endereco = json_decode($ordem['endereco']);
if($_GET['ordem'] == "entrada"){
?>
<header class="cabecalho">
    <a href="#" class="logo"><img src="../../assets/logofr.png" alt=""></a>
    <nav class="opcoes">
        <button class='btn btn-danger' id='baixarOrdem'>Baixar</button>
        <a href='../../FRController/index.php' class='btn btn-warning'>Voltar</a>
    </nav>
</header>
<br>
<div class="ordem">
<span class='orderTitle'>
    <h1><?=$ordem['empresa']?></h1>
    <strong><?=$endereco->rua.", ".$endereco->numero.", ".$endereco->bairro." - ".$endereco->cidade."/".$endereco->uf;?></strong>
    <p>CNPJ: <?=FRGeral::cpfCnpj($ordem['cnpj'],'##.###.###/####-##')?></p>
    <hr>
</span>
    <h2>Serviço: <?=$ordem['servico']?></h2>
    <hr>
    <span class='dadosOrdem'>
        <p>Codigo: <strong><?=$ordem['codigo']?></strong></p>
        <p>Atendente: <strong><?=$ordem['atendente']?></strong></p>
        <p>Entrada: <strong><?=FRGeral::data($ordem['dataHora'],'d/m/Y H:i:s')?></strong></p>
        <p>Cliente: <strong><?=$ordem['cliente']?></strong></p>
    </span>
    <hr>
    <span class="dadosServico">
        <p class="leibel">Previa: <strong><?=$ordem['previa']?></strong></p>
        <h3 class="leibel">Descrição</h3>
        <p>
            <?=$ordem['descricao']?>
        </p>
    </span>
</div>
<?php
}elseif($_GET['ordem'] == "saida"){
    // echo "<pre>";
    // print_r($ordem);
    // echo "</pre>";
    $maodeobra = json_decode($ordem['maodeobra']);
?>
<!---------------ORDEM DE SAIDA DO SERVIÇO--------------------->
<header class="cabecalho">
    <a href="#" class="logo"><img src="../../assets/logofr.png" alt=""></a>
    <nav class="opcoes">
        <button class='btn btn-danger' id='baixarOrdem'>Baixar</button>
        <a href='../../FRController/index.php' class='btn btn-warning'>Voltar</a>
    </nav>
</header>
<br>
<div class="ordem">
<span class='orderTitle'>
    <h1><?=$ordem['empresa']?></h1>
    <strong><?=$endereco->rua.", ".$endereco->numero.", ".$endereco->bairro." - ".$endereco->cidade."/".$endereco->uf;?></strong>
    <p>CNPJ: <?=FRGeral::cpfCnpj($ordem['cnpj'],'##.###.###/####-##')?></p>
    <hr>
</span>
    <h2>Serviço: <?=$ordem['servico']?></h2>
    <hr>
    <span class='dadosOrdem'>
        <p>Codigo: <strong><?=$ordem['codigo']?></strong></p>
        <p>Atendente: <strong><?=$ordem['atendente']?></strong></p>
        <p>Entrada: <strong><?=FRGeral::data($ordem['dataHora'],'d/m/Y H:i:s')?></strong></p>
        <p>Saida: <strong><?=FRGeral::data($ordem['saida'],'d/m/Y H:i:s')?></strong></p>
        <p>Cliente: <strong><?=$ordem['cliente']?></strong></p>
    </span>
    <hr>
    <span class="dadosServico">
        <p class="leibel">Previa: <strong><?=$ordem['previa']?></strong></p>
        <h3 class="leibel">Descrição</h3>
        <p>
            <?=$ordem['descricao']?>
        </p>
        <hr>
        <h2>O Que foi feito:</h2>
        <p>
            <?=$ordem['mensagem']?>
        </p>
        <table border class="tabelaMobra">
            <tr>
                <th>Produto</th>
                <th>Valor</th>
                <th>Quantidade</th>
            </tr>
            <tbody>
            <?php
            if(isset($maodeobra)){
            foreach($maodeobra as $mb){
                $novoValorProduto = Promocoes::confProdutoPromocional($mb->id,$mb->valor,$_SESSION['login']['filial']);
                if($novoValorProduto != $mb->valor){
                    $novopreco = $novoValorProduto;
                    $preco = "<s class='text-danger'>".FRGeral::trataValor($mb->valor,0)."</s>"."<br><p class='presso'>".FRGeral::trataValor($novoValorProduto,0)."</p>";
                }else{
                    $novopreco = $novoValorProduto;
                    $preco = "<p class='presso'>".FRGeral::trataValor($novoValorProduto,0)."</p>";
                }
            ?>
            <tr>
                <td><?=$mb->produto?></td>
                <td><?=$preco?></td>
                <td class="quantidade"><?=$mb->quantidade?></td>
            </tr>
            <?php
            }
            }
            ?>
            </tbody>
        </table>
        <p>Mão de Obra: <strong class="mobra"><?=Vendas::getDescontoPagamento($ordem['mobra'],$ordem['id_pagamento'])?></strong></p>
        <p>Total + Mão de Obra: <strong class="pressoTotau" data-metodo="<?=$ordem['metodo']?>" data-juros="<?=$ordem['juros']?>" data-parcelas="<?=$ordem['parcelas']?>"></strong></p>
    </span>
</div>
<?php
}else{
        echo "o que tu quer parceiro";
}
}else{
    echo "Acesso negado, corno querendo hackear";
}
?>    
</body>
<script src="../../js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="../../js/servicos.js"></script>
<script src="../../js/scripts.js"></script>
</html>