jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalProdutos = "#cadastroProdutos";
        var formProduto = "#formCadastroProdutos";

        $("#cadastroProdutos").on("hide.bs.modal",function(){
            $("#cadastroProdutos").find("input[name=codigoProduto],select[name=identificacao],input[name=categoriaProduto],input[name=insumo],select[name=fornecedorProduto]").parent().show()
            $("input[name=codigoProduto]").attr("disabled",true)
            $("input[name=codigoProduto]").attr("placeholder","")
            $(".imagemProduto",modalProdutos).attr("src",'../img/noproduct.png')
            $(".bt_excluir_produto").hide()
            $(".menu-reposicoes").show()
        })

        $("#getTroco").on("hide.bs.modal",function(){
            $("input[name=valorDado]").val("")
            $("#trocoVolta").text("")
        })

        $(".bt_excluir_produto").on("click",function(){
            var IDProduto = $("input[name=IDProduto]",formProduto).val()
            $modal = {
                titulo : "Excluir Produto",
                conteudo : "Deseja excluir o produto?",
                botao : {
                    class : "botao btn btn-danger",
                    texto : "Excluir",
                    funcao : ()=>{
                        $.ajax({
                            method : "POST",
                            url : "./../Configs/exclusaoDado.php",
                            data : {
                                setor : 'Produto',
                                ID   : IDProduto
                            },
                            success : function(){
                            $("#example10").DataTable().ajax.reload( null, false );
                            $("#alerta").modal("hide")
                            $("#cadastroProduto").modal("hide") 
                            }
                        })
                    } 
                }
            }
            abreModal($modal)
        })

        $(".bt_vender_produto").on("click",function(){
            vendeProduto("#vendeProduto")
        })

        $("input[name=codigoProduto]").attr("disabled",true)
        $("select[name=identificacao]").on("change",function(){
            $("input[name=codigoProduto]").attr("disabled",false)
            if($(this).val() == "CB"){
                $("input[name=codigoProduto]").attr("placeholder","Codigo EAN-13")
                $("input[name=codigoProduto]").attr("minlength",13)
                $("input[name=codigoProduto]").attr("maxlength",13)
                $('input[name=codigoProduto]').on("change",function(e){
                    if( $(this).val().length == 13){
                        var produto = $(this).val();
                        //
                        const settings = {
                            "async": true,
                            "crossDomain": true,
                            "url": "https://barcodes1.p.rapidapi.com/?query="+produto+"",
                            "method": "GET",
                            "headers": {
                                "X-RapidAPI-Key": "876f3e156bmsh79541acb2766591p1950a4jsnc1bd46bf269b",
                                "X-RapidAPI-Host": "barcodes1.p.rapidapi.com"
                            }
                        };
        
                        $.ajax(settings).done(function (response) {
                            //
                            $("input[name=nomeProduto]",modalProdutos).val(response.product.title.replace(/[\\"]/g, ''))
                            $("input[name=imagemProduto]",modalProdutos).val(response.product.images[0].replace(/[\\"]/g, ''))
                            $(".imagemProduto",modalProdutos).attr("src",response.product.images[0].replace(/[\\"]/g, ''))
                            //
                        });
                        //
                    }            
                })
            }else if($(this).val() == "ID"){
                $("input[name=codigoProduto]").attr("placeholder","Codigo Aleatório de 6 Números")
                $("input[name=codigoProduto]").attr("minlength",6)
                $("input[name=codigoProduto]").attr("maxlength",6)
            }else{
                $("input[name=codigoProduto]").attr("disabled",true)
                $("input[name=codigoProduto]").attr("placeholder","")
            }
        })
        
        $("input[name=valorFixo]").attr("disabled",true)
        $("input[name=lucroProduto]").attr("disabled",true)
        $("input[name=custoProduto]").on("keyup",function(){
            if(trataValor($(this).val(),1) > 0){
                $("input[name=valorFixo]").attr("disabled",false)
                $("input[name=lucroProduto]").attr("disabled",false)
            }else{
                $("input[name=valorFixo],input[name=valorFixo]").attr("disabled",true)
                $("input[name=valorFixo],input[name=lucroProduto]").attr("disabled",true)
            }
        })

        $('input[name=lucroProduto]').on("keyup",function(e){
            var v_lucro = $(this).val();
            var v_custo = trataValor($('input[name=custoProduto]').val(),1);
            var v_pct = (v_lucro/100)*v_custo;
            var v_preco = parseFloat(v_pct) + parseFloat(v_custo);
            $('input[name=valorProduto]').val(v_preco);
            $('input[name=valorFixo]').val(trataValor(v_preco,0));
            $('.valorProduto').text(trataValor(v_preco,0));
        });

        $('input[name=valorFixo]').on("keyup",function(e){
            //alert("mudou")
            var precoFixo = trataValor($(this).val(),1);
            var custoo = trataValor($('input[name=custoProduto]').val(),1);
            var calculo1 = precoFixo - custoo
            var calculo2 = calculo1 * 100
            var resultado = calculo2/custoo
            $('input[name=lucroProduto]').val(new Intl.NumberFormat('default', {style:'percent', minimumFractionDigits: 2, maximumFractionDigits: 2, }).format(
                resultado/100,
            ))
            //alert($(this).val())
            $(".valorProduto").text($(this).val())
        });

        //COPIANDO LINK DO CATALOGO
        $("#copiarCatalogo").on("click",function(){
            navigator.clipboard.writeText(window.location.href);
            alert("Copiado")
        })

        //MODAL DE ADICIONAR EMPRESA
        $(".adicionarProduto").on("click",function(){
            $(".menu-reposicoes").hide()
            $(modalProdutos).modal("show");
        })

        $(modalProdutos).on("show.bs.modal",function(){
            $(".bt_excluir_produto").hide()
        })

        $(".bt_baixar_cupom").on("click",function(){
            print()
        })

        //ENVIAR DADOS DA EMPRESA
        $(".bt_salvar_produto").on("click",function(e){
            salvarProduto(formProduto)
        })
        
        //EXPORTA PARA XLS
        $(".xlsx").on("click",function(){
            window.location.href="./processamento/exportExcel.php?Setor=Produtos"
        })

        $(".pdf").on("click",function(){
            window.location.href="./processamento/exportPdf.php?Setor=Produtos"
        })
        //FIM DA FUNÇÃO

        $("#imagem-usuario").on("change",function(){
            // Receber o arquivo do formulario
            var receberArquivo = document.getElementById("imagem-usuario").files;
            //console.log(receberArquivo);
    
            // Verificar se existe o arquivo
            if (receberArquivo.length > 0) {
    
                // Carregar a imagem
                var carregarImagem = receberArquivo[0];
                //console.log(carregarImagem);
    
                // FileReader - permite ler o conteudo do arquivo do computador do usuario
                var lerArquivo = new FileReader();
    
                // O evento onload ocorre quando um objeto he carregado
                lerArquivo.onload = function(arquivoCarregado) {
                   var imagemBase64 = arquivoCarregado.target.result;  
                   $(".imagemProduto").attr("src",imagemBase64)
                   $("input[name=imagemProduto]").val(imagemBase64)
                }  
    
                // O metodo readAsDataURL e usado para ler o conteudo
                lerArquivo.readAsDataURL(carregarImagem);
            }
        })

        $("#cadastroProdutos").on("show.bs.modal",function(){
            $("input[name=valorFixo]").attr("disabled",true)
            $("input[name=lucroProduto]").attr("disabled",true)
        })

    }

    window.jsPDF = window.jspdf.jsPDF;
    var docPDF = new jsPDF();

    function print(){
        var elementHTML = document.querySelector(".printer-ticket");
        docPDF.html(elementHTML, {
        callback: function(docPDF) {
        docPDF.save('Cupom baixado.pdf');
        },
        x: 15,
        y: 15,
        width: 170,
        windowWidth: 650
        });
    }

    function genCodigoVenda() {
        var length = 10,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal;
    }

    function vendeProduto(form){
        if(!validaCampos(form))return false
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data : {
                IDProduto          : $("input[name=produto_id]",form).val(),
                IDFornecedor       : $("input[name=fornecedor_id]",form).val(),
                IDPromocao         : $("input[name=promocao_id]",form).val(),
                IDCliente          : $("select[name=cliente]",form).val(),
                NUUnidadesVendidas : $("input[name=quantidade]",form).val(),
                IDCaixa            : 0,
                IDPagamento        : $("select[name=pagamento]",form).val(),
                VLVenda            : trataValor($("#valProd").text().trim(),1),
                CDVenda            : genCodigoVenda()
            }
        }).done(function(venda){
            $("#example10").DataTable().ajax.reload( null, false )
            $("#modalCupomVenda").modal('show')
            $("#modalCupomVenda").find(".modal-body").html(venda)
            $("#setVenda").modal("hide")
        })
    }

    function setReposicao(dados){
        $.ajax({
            method : "POST",
            url : "./../Configs/enviaDados.php",
            data : dados
        }).done(function(resultado){
            console.log(resultado)
        })
    }

    function salvarProduto(form){
        var modalProdutos = "#cadastroProdutos";
        //INICIA VALIDACAO DOS CAMPOS

        if($("input[name=IDProduto]",form).val()){
            if(parseInt($("input[name=estoqueProduto]",form).val()) < parseInt($("input[name=estoqueProduto]",form).attr("data-original"))){
                aviso("A Reposição e Menor que a Quantidade já Existente")
                return false
            }
        }

        if(parseInt($("input[name=estoqueMinimo]",form).val()) > parseInt($("input[name=estoqueProduto]",form).val()) || parseInt($("input[name=estoqueMinimo]",form).val()) > parseInt($("input[name=estoqueProduto]",form).val()) ){
            aviso("O Estoque Minimo e maior do que o estoque existente, talvez seja a hora de fazer uma reposição, ou insirá um valor maior do que o estoque mínimo")
            return false
        }

        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                identificacao : $("select[name=identificacao]",form).val(),
                IDProduto     : $("input[name=IDProduto]",form).val(),
                codigo        : $("input[name=codigoProduto]",form).val(),
                nome          : $("input[name=nomeProduto]",form).val(),
                categoria     : $("input[name=categoriaProduto]",form).val(),
                fornecedor    : $("select[name=fornecedorProduto]",form).val(),
                garantia      : $("select[name=garantiaProduto]",form).val(),
                qtGarantia    : $("input[name=qtValidade]",form).val(),
                estoque       : $("input[name=estoqueProduto]",form).val(),
                estoqueMinimo : $("input[name=estoqueMinimo]",form).val(),
                custo         : trataValor($("input[name=custoProduto]",form).val(),1),
                tipo          : $("select[name=tipoProduto]",form).val(),
                validade      : $("input[name=validadeProduto]",form).val(),
                valor         : trataValor($(".valorProduto",form).text(),1),
                imagem        : $("input[name=imagemProduto]",form).val(),
                lucro         : $("input[name=lucroProduto]",form).val().replace('%',''),
                insumo        : 0
            }
        }).done(function(resultado){
            console.log(resultado);
            // return false
            if($("input[name=IDProduto]",form).val()){
                if($("input[name=estoqueProduto]",form).val() != $("input[name=estoqueProduto]",form).attr("data-original")){
                    //
                    var VLRep = $("input[name=estoqueProduto]",form).val() - $("input[name=estoqueProduto]",form).attr("data-original")
                    var VLCusto =  trataValor($("input[name=custoProduto]",form).val(),1) * VLRep
                    setReposicao({
                        Quantidade : VLRep,
                        Produto : $("input[name=IDProduto]",form).val(),
                        Custo : VLCusto
                    })
                    //
                }
            }
            $("#example10").DataTable().ajax.reload( null, false )
            $(modalProdutos).modal("hide")
        })
    }
    //FIM DA PAGINA
})


