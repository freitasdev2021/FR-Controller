<?php
require"../../Configs/configs.php";
$selectFornecedores = $fornecedores->listarFornecedores($_SESSION['login']['filial']);
include"modais/modalProdutos.php";
include"modais/modalVenda.php";
include"modais/modalTroco.php";
include"modais/modalAlert.php";
include"modais/modalCupomVenda.php";
$IDFilial = base64_encode($_SESSION['login']['filial']);
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/produtos.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Produtos</a>
        </nav>
    </div>

    <div class="tab-content p-3" id="myTabContent">
        <!--ABA DE PRODUTOS-->
    <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
        <div class="col-sm-12 cabecalho-qt2">
        <?php if(Autenticacao::userPerm(2,"PRO")):?><button class="btn btn-fr adicionarProduto elementHeader"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif;?>
            <a target="_blank" href="views/catalogo.php?ID=<?=$IDFilial?>&setor=produtos" class="btn btn-fr linkHeader elementHeader"><i class="fa-solid fa-file"></i></i>&nbsp;Catálogo</a>
        </div>
        <hr width="100%">
        <table id="example10" class="table table-bordered text-center tabela table-mobile-responsive ">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Valor(R$)</th>
                <th>Nome</th>
                <th>Estoque/Estoque Minimo</th>
                <th>Entrada/Validade</th>
                <th>Vendas/Custo(R$)</th>
                <th style="width:100px;">Vender</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>    
        </table>
    </div>
        <!---->
    </div>

</div>
<script>
$("#alerta").on("hide.bs.modal",function(){
    $(".modal-body p").text('');
})

function venderProduto(ID,IDFornecedor,IDPromocao){
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID"           : ID,
            "Setor"        : "setVenda",
            "IDFornecedor" : IDFornecedor,
            "IDPromocao"   : IDPromocao
        }
    }).done(function(prod){
        //CALCULAR PAGAMENTO PELO SERVIÇO
        $("#setVenda").find(".modal-body").html(prod)
        $("input[name=quantidade]").on("keyup",function(){
            valorTotal = trataValor($("#valProd").attr("data-cru").trim(),1)
            //valorTotal = trataValor($("#valProd").text().trim(),1)
            if($(this).val() > 0 || $(this).val() != ""){
                quantidade = $(this).val()
                totalProd = trataValor(valorTotal * quantidade,0)
                $("#valProd").text(totalProd)
                $("#valProd").attr("data-original",totalProd)
                $(".totalPagar").text(totalProd)
            }else{
                totalProd = trataValor(valorTotal,0)
                $("#valProd").text(totalProd)
                $("#valProd").attr("data-original",totalProd)
                $(".totalPagar").text(totalProd)
            }
        })
        $("select[name=cliente]").on("change",function(){
            if($(this).find('option:selected').attr("data-divida") > 0){
                aviso("Esse cliente tem uma divida de: R$ "+trataValor($(this).find('option:selected').attr("data-divida"),0))
            }
        })
        $("select[name=pagamento]").on("change",function(){
            var v_mobra = trataValor($("#valProd").attr("data-cru").trim(),1) * $("input[name=quantidade]").val();
            //var v_mobra = trataValor($("#valProd").text().trim(),1);
            //PERGUNTA O TIPO DE PAGAMENTO
            switch($(this).find('option:selected').attr("data-metodo")){
                case "2":
                    var metodoParcelado = jurosParcelas(trataValor($("#valProd").text(),1),$(this).find('option:selected').attr("data-parcelas"),$(this).find('option:selected').attr("data-juros"))
                    var parcelas = metodoParcelado.parcelas;
                    var valorParcela = metodoParcelado.valorParcela;
                    var vf = metodoParcelado.valorFinal;
                    var labelVal = trataValor(vf,0)+"("+parcelas+"x "+trataValor(valorParcela,0)+")";
                    $(".totalPagar").text(labelVal)
                    $("#valProd").text($("#valProd").attr("data-original"))
                    $("#valProd").attr("data-original",$("#valProd").text())
                break;
                case "3":
                    var totalP = taxaMaquininha(parseFloat(trataValor($("#valProd").text(),1)),$(this).find('option:selected').attr("data-juros"))
                    $("#valProd").text($("#valProd").attr("data-original"))
                    $("#valProd").attr("data-original",$("#valProd").text())
                    $(".totalPagar").text(trataValor(totalP,0))
                break;
                default:
                //PAGAMENTO EM DINHEIRO
                if($(this).find("option:selected").attr("data-metodo") == 4){
                    $("#getTroco").modal("show")
                    $("input[name=valorDado]").on("keyup",function(){
                        valorTotal = trataValor($("#valProd").text(),1)
                        valorDado = trataValor($(this).val(),1)
                        $("#trocoVolta").text(trataValor(valorDado - valorTotal,0))
                    })
                }
                //PERGUNTA SE TEM DESCONTO
                if($(this).find('option:selected').attr("data-desconto") > 0){
                    if($(this).find('option:selected').attr("data-tipo") == "1"){
                        var v_desconto = $(this).find('option:selected').attr("data-desconto");
                        var v_pct = (v_desconto/100)*v_mobra;
                        var v_preco = parseFloat(v_mobra) - parseFloat(v_pct);
                        $("#valProd").text(trataValor(v_preco,0))
                        $(".totalPagar").text(trataValor(v_preco,0))
                    }else if($(this).find('option:selected').attr("data-tipo") == "2"){
                        var v_desconto = $(this).find('option:selected').attr("data-desconto");
                        var v_preco = parseFloat(v_mobra) - parseFloat(v_desconto);
                        $("#valProd").text(trataValor(v_preco,0))
                        $(".totalPagar").text(trataValor(v_preco,0))
                    }else{
                        $("#valProd").text(trataValor(v_mobra,0))
                        $(".totalPagar").text(trataValor(v_mobra,0))
                    }
                }else{
                    $("#valProd").text(trataValor(v_mobra,0))
                    $(".totalPagar").text(trataValor(v_mobra,0))
                }

            }
        })
        $("#setVenda").modal("show")
    })
}

function editarProduto(IDProduto){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDProduto);
    // return false;
    var modal = "#cadastroProdutos";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDProduto,
            "Setor" : "Produto"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $(modal).find("input[name=codigoProduto],select[name=identificacao],input[name=categoriaProduto],input[name=insumo],select[name=fornecedorProduto]").parent().hide()
            $(".bt_excluir_produto").show()
            garantia = jQuery.parseJSON(rs['DSGarantiaProduto'])
            $('input[name=IDProduto]').val(rs['IDProduto'])
            $('input[name=nomeProduto]').val(rs['NMProduto'])
            $('input[name=codigoProduto]').val(rs['NUCodigoProduto'])
            $('input[name=categoriaProduto]').val(rs['IDCategoria'])
            $('select[name=fornecedorProduto]').val(rs['IDFornecedor']).change()
            $('input[name=validadeProduto]').val(rs['DTValidadeProduto'])
            $('select[name=promocaoProduto]').val(rs['IDPromocional']).change()
            $('input[name=estoqueProduto]').val(rs['NUEstoqueProduto'])
            $('input[name=estoqueProduto]').attr("data-original",rs['NUEstoqueProduto'])
            $('input[name=custoProduto]').val(trataValor(rs['NUCustoProduto'],0))
            $('select[name=tipoProduto]').val(rs['DSUnidadeProduto'])
            $("select[name=garantiaProduto]").val(garantia['Tempo'])
            $("input[name=qtValidade]").val(garantia['Quantidade'])
            $("input[name=estoqueMinimo]").val(rs['NUEstoqueMinimo'])
            if(rs['DSImagemProduto']){
                $("input[name=imagemProduto]").val(rs['DSImagemProduto'])
                $(".imagemProduto").attr("src",rs['DSImagemProduto'])
            }
            getReposicoes(rs['IDProduto'])
            $("input[name=lucroProduto]").val(new Intl.NumberFormat('default', {style:'percent', minimumFractionDigits: 2, maximumFractionDigits: 2, }).format(
                rs['NULucroProduto']/100,
            ))
            $("input[name=valorProduto]").val(rs['NUValorProduto'])
            $(".valorProduto").text(trataValor(rs['NUValorProduto'],0))
        }
    })
}

function getReposicoes(IDProduto){
    $(".tabela-reposicoes tbody").html("")
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID"            : IDProduto,
            "Setor"         : "Reposicoes"
        },
        success : function(response){
            console.log(response)
            var rs = JSON.parse(response)
            rs.forEach((pro)=>{

                trPromo = $("<tr></tr>");
    
                trPromo.append("<td data-content='Quantidade'>"+pro.QTCompra+"</td>")
                trPromo.append("<td data-content='Custo'>"+trataValor(pro.NUCustoReposicao,0)+"</td>")
                trPromo.append("<td data-content='Data'>"+pro.DTRep+"</td>")

                $(".tabela-reposicoes tbody").append(trPromo)

            })

            $("#cadastroProdutos").modal("show")
        }
    })
}
</script>

