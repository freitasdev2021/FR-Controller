jQuery(function(){
    $(document).ready(function(){
        montaBotoes()
    })

    function montaBotoes(){
        var formDevolucao = "#formDevolucao";
        $(".bt-repor").on("click",function(){
            devolver("Repor",$(formDevolucao).find("input[name=QTVendas]").val(),$(formDevolucao).find("input[name=IDVenda]").val(),$(formDevolucao).find("input[name=QTDevolucao]").val())
        })
        $(".bt-descartar").on("click",function(){
            devolver("Descartar",$(formDevolucao).find("input[name=QTVendas]").val(),$(formDevolucao).find("input[name=IDVenda]").val(),$(formDevolucao).find("input[name=QTDevolucao]").val())
        })
    }
    
    function devolver(Acao,Vendas,IDVenda,QTDevolucao){
        // alert(Acao)
        // return false
        if(QTDevolucao > Vendas){
            alert("Quantidade de Devolução Superior a Quantidade Vendida")
        }else{
            $.ajax({
                method : "POST",
                url : "./../Configs/enviaDados.php",
                data : {
                    Acao : Acao,
                    Vendas : Vendas,
                    IDVenda : IDVenda,
                    QTDevolucao : QTDevolucao
                }
            }).done(function(retorno){
                console.log(retorno)
                $("#example21").DataTable().ajax.reload( null, false )
                $("#devolucaoProduto").modal('hide')
            })
        }
    }

})