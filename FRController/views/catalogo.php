<?php
require"../../Configs/configs.php";
if(is_string($_GET['ID'])){
    $IDFilial = base64_decode($_GET['ID']);
    $empresa = mysqli_fetch_assoc(Cupons::getHeaderCupom($IDFilial));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel='stylesheet' href='../../css/catalogo.css'>
</head>
<body>
    <header class="cabecalho">
        <a href="#" class="logo"><?=$empresa['NMRazaoEmpresa']." - ".$empresa['NMFilial']?></a>
        <?php
        if(isset($_SESSION['login'])){
        ?>
        <nav class="opcoes">
            <button class='btn btn-success' id='copiarCatalogo'>Compartilhar</button>
            <a href='../../FRController/index.php' class='btn btn-warning'>Voltar</a>
        </nav>
        <?php
        }
        ?>
    </header>
    <?php
    if(is_string($_GET['ID']) && $_GET['setor'] == "produtos"){
    ?>
    <div class="grid">
    <?php
        $produtos = Produtos::listarProdutos($IDFilial);
        foreach($produtos as $p){
        $novoValorProduto = Promocoes::confProdutoPromocional($p['IDProduto'],$p['NUValorProduto'],$IDFilial);
        if($novoValorProduto != $p['NUValorProduto']){
            $novopreco = $novoValorProduto;
            $preco = "<s class='text-danger'>".FRGeral::trataValor($p['NUValorProduto'],0)."</s>"."<br>".FRGeral::trataValor($novoValorProduto,0);
        }else{
            $novopreco = $novoValorProduto;
            $preco = FRGeral::trataValor($novoValorProduto,0);
        }
    ?>
        <div class="item">
                <img src="<?=$p['DSImagemProduto']?>">
                <br>
                <strong class="nm"><?=$p['NMProduto']?></strong>
                <br>
                <b>Estoque:&nbsp;<?=$p['NUEstoqueProduto']." (".$p['DSUnidadeProduto'].")"?></b>
                <hr>
                <b><?=$preco?></b>
        </div>
    </div>
    <?php
        }
    }elseif(is_string($_GET['ID']) && $_GET['setor'] == "servicos"){
    $servicos = Servicos::getServicos($IDFilial);
    ?>
    <div class="lista">
        <h5 align="center">Serviços Oferecidos</h5>
        <ul>
            <?php
            foreach($servicos as $s){
            ?>
            <li><?=$s['DSTipoServico']?></li>
            <?php
            }
            ?>
        </ul>
    </div>
    <?php
    }
    ?>
    <script src="../../js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="../../js/produtos.js"></script>
    <script src="../../js/scripts.js"></script>
</body>
</html>