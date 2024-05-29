<?php
require"../../Configs/configs.php";
$selectFornecedores = $fornecedores->listarFornecedores($_SESSION['login']['filial']);
$servicos = Servicos::getServicos($_SESSION['login']['filial']);
$clientes = Clientes::listarClientes($_SESSION['login']['filial']);
include"modais/modalInsumos.php";
include"modais/modalServicos.php";
include"modais/modalBaixaOrdem.php";
include"modais/modalCustos.php";
include"modais/modalOrdemServico.php";
include"modais/modalAlert.php";
include"modais/modalTroco.php";
$IDFilial = base64_encode($_SESSION['login']['filial']);
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/servicos.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#servicos" role="tab" aria-controls="public" aria-selected="true">Serviços</a>
            <a class="nav-item nav-link pointer text-black" data-bs-target="#ordens" role="tab" data-bs-toggle="tab">Ordens de Serviço</a>
            <a class="nav-item nav-link pointer text-black insumusNav" data-bs-target="#insumos" role="tab" data-bs-toggle="tab">Insumos</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <!-----SERVIÇOS---->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="servicos" aria-labelledby="public-tab">
            <div class="col-sm-12 cabecalho-qt2">
            <?php if(Autenticacao::userPerm(2,"SER")):?><button class="btn btn-fr adicionarServico elementHeader"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif;?>
                <a target="_blank" href="views/catalogo.php?ID=<?=$IDFilial?>&setor=servicos" class="btn btn-fr linkHeader elementHeader"><i class="fa-solid fa-file"></i></i>&nbsp;Catálogo</a>
            </div>
            <hr width="100%">
            <table id="example18" class="table table-bordered text-center tabela table-mobile-responsive ">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Mão de Obra(R$)</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>    
            </table>
        </div>
        <!-----ORDENS DE SERVIÇO---->
        <div class="tab-pane fade mt-2" id="ordens" role="tabpanel" aria-labelledby="group-dropdown2-tab">
        <div class="col-sm-12">
        <?php if(Autenticacao::userPerm(2,"SER")):?><button class="btn btn-fr adicionarOrdemServico btn-one"><i class="fa fa-plus"></i>&nbsp;Criar ordem</button><?php endif;?>
        </div>
        <hr width="100%">
        <table id="example19" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Servico</th>
                    <th>Cliente</th>
                    <th>Atendente</th>
                    <th>Codigo</th>
                    <th>Data e Hora</th>
                    <th>Status</th>
                    <th>Ordem</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>

            </tbody>    
        </table>
        </div>
        <!-----INSUMOS---->
        <div class="tab-pane fade mt-2" id="insumos" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
        <div class="col-sm-12">
        <?php if(Autenticacao::userPerm(2,"SER")):?><button class="btn btn-fr adicionarInsumo btn-one"><i class="fa fa-plus"></i>&nbsp;Adicionar</button><?php endif;?>
        </div>
        <hr width="100%">
        <table id="example20" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Valor(R$)</th>
                    <th>Descrição</th>
                    <th>Estoque/Estoque Minimo</th>
                    <th>Entrada</th>
                    <th>Vendas/Custo(R$)</th>
                </tr>
            </thead>
            <tbody>

            </tbody>    
        </table>
        </div>
        <!-----FIM---->
    </div>
</div>
<script>
$("#alerta").on("hide.bs.modal",function(){
    $(".modal-body p").text('');
})

function cancelarOrdem(IDOrdem,DSGarantiaServico,DTServico){
    garantia = DSGarantiaServico
    var devolve = false
    var hoje = new Date();
    var compra = new Date(DTServico);
    if(garantia.Tipo == "A"){
        if(Math.abs(hoje.getFullYear() - compra.getFullYear()) > garantia.Tempo){
            devolve = false
        }else{
            devolve = true
        }
    }else if(garantia.Tipo == "M"){
        if(Math.abs(hoje.getMonth() - compra.getMonth()) > garantia.Tempo){
            devolve = false
        }else{
            devolve = true
        }
    }else if(garantia.Tipo == "D"){
        if(Math.abs(hoje.getTime() - compra.getTime())/(1000 * 3600 * 24) > garantia.Tempo){
            devolve = false
        }else{
            devolve = true
        }
    }
    //
    if(!devolve){
        alert("Serviço fora do prazo de Garantia")
    }else{
        if(confirm("Deseja cancelar o serviço?")){
            $.ajax({
                method : "POST",
                url : "./../Configs/changeStatus.php",
                data : {
                    setor : 'OrdemServico',
                    atualStatus : "",
                    ID   : IDOrdem
                },
                success : function(r){
                    console.log(r)
                    $("#example19").DataTable().ajax.reload( null, false );
                }
            })
        }
    }
}

function editarServico(IDServico){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDEmpresa);
    // return false;
    var modal = "#cadastroServicos";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDServico,
            "Setor" : "Servico"
        },
        success : function(response){
            // console.log(response)
            // return false
            var rs = JSON.parse(response)[0]
            // console.log(rs[0])
            // return false
            $(modal).modal("show");
            $('input[name=IDServico]').val(rs['IDServico'])
            $('input[name=tipoServico]').parent().hide()
            garantiaServico = jQuery.parseJSON(rs['DSGarantiaServico'])
            $('select[name=tipoGarantia]').val(garantiaServico['Tipo'])
            $('input[name=tempoGarantia]').val(garantiaServico['Tempo'])
            $("input[name=valorBase]").val(trataValor(rs['VLBase'],0))
            if(rs['STHora'] == 1){
                $("input[name=hasHora]").prop("checked",true)
            }
            $(".bt_excluir_servico").show()
        }
    })
}

function abrirCustos(ID){
    $(".tabela-custos tbody").html("")
    $("input[name=IDOrdem]").val(ID)
    var modal = "#cadastroCustos";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : ID,
            "Setor" : "Obra"
        },
        success : function(response){
            // console.log(response)
            // return false
            var rs = JSON.parse(response)
            rs.forEach((pro)=>{
                trCusto = $("<tr>",{
                    class: 'produto_'+pro.IDProduto
                },"</tr>")
                if(pro.vinculo == 1){
                    checked = 'checked'
                }else{
                    checked = ''
                }
                if(!pro.NUQuantidade || pro.NUQuantidade == 1){
                    qt = 1
                }else{
                    qt = pro.NUQuantidade
                }
                trCusto.append("<td><input type='checkbox' "+checked+" name='produto' value="+pro.IDProduto+"></td>")
                trCusto.append("<td>"+pro.NMProduto+"</td>")
                trCusto.append("<td><input type='text' value="+qt+"></td>")

                $(".tabela-custos tbody").append(trCusto)

            })
            $(modal).modal("show")
        }
    })
}

function finalizaOrdem(ID,IDColaborador,IDCliente){
    var modal = "#baixaOrdem";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : ID,
            "IDColaborador" : IDColaborador,
            "IDCliente" : IDCliente,
            "Setor" : "Baixa"
        },
        success : function(response){
            //var rs = JSON.parse(response)
            $("#formBaixaOrdem input[name=IDOrdem]").val(ID)
            $("#formBaixaOrdem input[name=IDColaborador]").val(IDColaborador)
            $("#formBaixaOrdem input[name=IDCliente]").val(IDCliente)
            $(".finalisassao").html(response)
            //CALCULAR PAGAMENTO PELO SERVIÇO
            $("select[name=pagamento]").on("change",function(){
                var v_mobra = trataValor($(".mobra").attr("data-cru").trim(),1);
                //PERGUNTA O TIPO DE PAGAMENTO
                switch($(this).find('option:selected').attr("data-metodo")){
                    case "2":
                        //
                        valorSomado = []
                        $(".presso").each(function(){
                            quantidade = $(this).parents("tr").find(".quantidade").text()
                            presso = trataValor($(this).text(),1)
                            valorSomado.push(presso*quantidade)
                        })
                        ////
                        var sum = 0;
                        for(var i =0;i<valorSomado.length;i++){
                            sum+=valorSomado[i];
                        }
                        var metodoParcelado = jurosParcelas(trataValor($(".pressoTotau").attr("data-cru"),1),$(this).find('option:selected').attr("data-parcelas"),$(this).find('option:selected').attr("data-juros"))
                        var parcelas = metodoParcelado.parcelas;
                        var valorParcela = metodoParcelado.valorParcela;
                        var vf = metodoParcelado.valorFinal;
                        var labelVal = trataValor(vf,0)+"("+parcelas+"x "+trataValor(valorParcela,0)+")";
                        $(".totalPagar").text(labelVal)
                        $(".pressoTotau").text($(".pressoTotau").attr("data-cru"))
                        $(".pressoTotau").attr("data-original",$(".pressoTotau").attr("data-cru"))
                    break;
                    case "3":
                        var totalP = taxaMaquininha(parseFloat(trataValor($(".pressoTotau").attr("data-cru"),1)),$(this).find('option:selected').attr("data-juros"))

                        //
                        valorSomado = []
                        $(".presso").each(function(){
                            quantidade = $(this).parents("tr").find(".quantidade").text()
                            presso = trataValor($(this).text(),1)
                            valorSomado.push(presso*quantidade)
                        })
                        ////
                        var sum = 0;
                        for(var i =0;i<valorSomado.length;i++){
                            sum+=valorSomado[i];
                        }

                        //totau = parseFloat(sum) + parseFloat(totalP)
                        $(".pressoTotau").text($(".pressoTotau").attr("data-cru"))
                        $(".pressoTotau").attr("data-original",$(".pressoTotau").attr("data-cru"))
                        $(".totalPagar").text(trataValor(totalP,0))
                    break;
                    default:
                        //PERGUNTA SE TEM DESCONTO
                        if($(this).find("option:selected").attr("data-metodo") == 4){
                            $("#getTroco").modal("show")
                            $("input[name=valorDado]").on("keyup",function(){
                                valorTotal = trataValor($(".pressoTotau").text(),1)
                                valorDado = trataValor($(this).val(),1)
                                $("#trocoVolta").text(trataValor(valorDado - valorTotal,0))
                            })
                        }
                        if($(this).find('option:selected').attr("data-desconto") > 0){
                            if($(this).find('option:selected').attr("data-tipo") == "1"){
                                var v_desconto = $(this).find('option:selected').attr("data-desconto");
                                var v_pct = (v_desconto/100)*v_mobra;
                                var v_preco = parseFloat(v_mobra) - parseFloat(v_pct);
                                $(".mobra").text(trataValor(v_preco,0))
                                var totaul = trataValor(v_preco,0)
                            }else if($(this).find('option:selected').attr("data-tipo") == "2"){
                                var v_desconto = $(this).find('option:selected').attr("data-desconto");
                                var v_preco = parseFloat(v_mobra) - parseFloat(v_desconto);
                                $(".mobra").text(trataValor(v_preco,0))
                                var totaul = trataValor(v_preco,0)
                            }else{
                                $(".mobra").text(trataValor(v_mobra,0))
                                var totaul = trataValor(v_mobra,0)
                            }
                        }else{
                            $(".mobra").text(trataValor(v_mobra,0))
                            var totaul = trataValor(v_mobra,0)
                        }
                        //
                        valorSomado = []
                        $(".presso").each(function(){
                            quantidade = $(this).parents("tr").find(".quantidade").text()
                            presso = trataValor($(this).text(),1)
                            valorSomado.push(presso*quantidade)
                        })
                        ////
                        var sum = 0;
                        for(var i =0;i<valorSomado.length;i++){
                            sum+=valorSomado[i];
                        }

                        totau = parseFloat(sum) + parseFloat(trataValor(totaul,1))
                        $(".totalPagar").text(trataValor(totau,0))
                        $(".pressoTotau").text(trataValor(totau,0))
                        $(".pressoTotau").attr("data-original",trataValor(totau,0))
                }
                
                // $(".pressoTotau").text(trataValor(totau,0))
                // $(".pressoTotau").attr("data-original",trataValor(totau,0))
            })
            $(modal).modal("show");
            // $('input[name=IDOrdem]').val(rs['IDOrdem'])
        }
    })
}

function apagaOrdem(IDOrdem){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDOrdem);
    // return false;
    $modal = {
        titulo : "Excluir Serviço",
        conteudo : "Deseja excluir a ordem de serviço?",
        botao : {
            class : "botao btn btn-danger",
            texto : "Excluir",
            funcao : ()=>{
                $.ajax({
                    method : "POST",
                    url : "./../Configs/exclusaoDado.php",
                    data : {
                        setor : 'OrdemServico',
                        ID   : IDOrdem
                    },
                    success : function(ret){
                        console.log(ret)
                    $("#example19").DataTable().ajax.reload( null, false );
                    $("#alerta").modal("hide")
                    }
                })
            } 
        }
    }
    abreModal($modal)
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

            $("#cadastroInsumos").modal("show")
        }
    })
}

function editarInsumo(IDInsumo){
    // var dados = await fetch('view.php?Setor=Empresa&ID='+ID);
    // var response = await dados.json()
    // console.log(response)
    // alert(IDProduto);
    // return false;
    var modal = "#cadastroInsumos";
    $.ajax({
        method : "POST",
        url : "views/view.php",
        data : {
            "ID" : IDInsumo,
            "Setor" : "Produto"
        },
        success : function(response){
            var rs = JSON.parse(response)
            $(modal).modal("show");
            $(modal).find("input[name=codigoInsumo],select[name=identificacao],input[name=categoriaInsumo],select[name=fornecedorInsumo]").parent().hide()
            $(".bt_excluir_produto").show()
            garantia = jQuery.parseJSON(rs['DSGarantiaProduto'])
            $('input[name=IDInsumo]').val(rs['IDProduto'])
            $('input[name=nomeInsumo]').val(rs['NMProduto'])
            $('input[name=codigoInsumo]').val(rs['NUCodigoProduto'])
            $('input[name=categoriaInsumo]').val(rs['IDCategoria'])
            $('select[name=fornecedorInsumo]').val(rs['IDFornecedor']).change()
            $('input[name=validadeInsumo]').val(rs['DTValidadeProduto'])
            $('select[name=promocaoInsumo]').val(rs['IDPromocional']).change()
            $('input[name=estoqueInsumo]').val(rs['NUEstoqueProduto'])
            $('input[name=estoqueInsumo]').attr("data-original",rs['NUEstoqueProduto'])
            $('input[name=custoInsumo]').val(trataValor(rs['NUCustoProduto'],0))
            $('select[name=tipoInsumo]').val(rs['DSUnidadeProduto'])
            $("select[name=garantiaInsumo]").val(garantia['Tempo'])
            $("input[name=qtValidade]").val(garantia['Quantidade'])
            $("input[name=estoqueMinimo]").val(rs['NUEstoqueMinimo'])
            if(rs['DSImagemProduto']){
                $("input[name=imagemInsumo]").val(rs['DSImagemProduto'])
                $(".imagemInsumo").attr("src",rs['DSImagemProduto'])
            }
            getReposicoes(rs['IDProduto'])
            $("input[name=lucroInsumo]").val(new Intl.NumberFormat('default', {style:'percent', minimumFractionDigits: 2, maximumFractionDigits: 2, }).format(
                rs['NULucroProduto']/100,
            ))
            $("input[name=valorInsumo]").val(rs['NUValorProduto'])
            $(".valorInsumo").text(trataValor(rs['NUValorProduto'],0))
            $(".bt_excluir_Insumo").show()
        }
    })
}

</script>

