<?php
require"../../Configs/configs.php";
include"modais/modalDevolucaoProduto.php";
?>
<script src="../js/datatablesGeral.js"></script>
<script src="../js/vendas.js"></script>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Produtos</a>
            <a class="nav-item nav-link pointer text-black" data-bs-target="#tab3" role="tab" data-bs-toggle="tab">Insumos</a>
            <a class="nav-item nav-link pointer text-black" data-bs-target="#tab4" role="tab" data-bs-toggle="tab">Serviços</a>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <!-----CLIENTES---->
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
            <table id="example21" class="table table-bordered text-center tabela table-mobile-responsive ">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th style='width:100px;'>Quantidade</th>
                        <th>Pagamento</th>
                        <th>Promoção</th>
                        <th>Cliente</th>
                        <th>PDV</th>
                        <th>Data</th>
                        <th>Colaborador</th>
                        <th style='width:100px;'>Opções</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>    
            </table>
        </div>
        <!-----DEVEDORES---->
        <div class="tab-pane fade mt-2" id="tab3" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
        <table id="example17" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Insumo</th>
                    <th>Valor</th>
                    <th style='width:100px;'>Quantidade</th>
                    <th>Pagamento</th>
                    <th>Promoção</th>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Colaborador</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>

            </tbody>    
        </table>
        </div>
        <!-----CREDIARIOS---->
        <div class="tab-pane fade mt-2" id="tab4" role="tabpanel" aria-labelledby="group-dropdown2-tab" >
        <table id="example22" class="table table-bordered text-center tabela table-mobile-responsive ">
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Cliente</th>
                    <th>Pagamento</th>
                    <th>Código</th>
                    <th>Data</th>
                    <th>Total</th>
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
    function devolveProduto(IDVenda,DSGarantiaProduto,DTVenda,NUUnidadesVendidas){
        var garantia = DSGarantiaProduto
        var devolve = false
        var hoje = new Date();
        var compra = new Date(DTVenda);
        if(garantia.Tempo.length > 0){
            if(garantia.Tempo == "A"){
                if(Math.abs(hoje.getFullYear() - compra.getFullYear()) > garantia.Quantidade){
                    devolve = false
                }else{
                    devolve = true
                }
            }else if(garantia.Tempo == "M"){
                if(Math.abs(hoje.getMonth() - compra.getMonth()) > garantia.Quantidade){
                    devolve = false
                }else{
                    devolve = true
                }
            }else if(garantia.Tempo == "D"){
                if(Math.abs(hoje.getTime() - compra.getTime())/(1000 * 3600 * 24) > garantia.Quantidade){
                    devolve = false
                }else{
                    devolve = true
                }
            }
            //alert("aqui 1")
        }else if( Math.abs(hoje.getTime() - compra.getTime())/(1000 * 3600 * 24) > 7){
            //alert("aqui 2")
            devolve = false
        }else{
            //alert("aqui 3")
            devolve = true
        }
        //
        if(!devolve){
            alert("Produto fora do prazo de Garantia")
        }else{
            $("#devolucaoProduto").find("input[name=QTVendas]").val(NUUnidadesVendidas)
            $("#devolucaoProduto").find("input[name=IDVenda]").val(IDVenda)
            $("#devolucaoProduto").modal("show")
        }
    }
</script>

