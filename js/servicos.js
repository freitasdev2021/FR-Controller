jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalInsumos = "#cadastroInsumos";
        var modalServicos = "#cadastroServicos";
        var modalOrdemServico = "#cadastroOrdemServico";
        var formInsumo = "#formCadastroInsumos";
        var formServicos = "#formCadastroServicos";
        var formOrdemServico = "#formOrdemServico";
        $("#cadastroInsumos").on("hide.bs.modal",function(){
            $("#cadastroInsumos").find("input[name=codigoInsumo],select[name=identificacao],input[name=categoriaInsumo],input[name=insumo],select[name=fornecedorInsumo]").parent().show()
            $("input[name=codigoInsumo]").attr("disabled",true)
            $("input[name=codigoInsumo]").attr("placeholder","")
            $(".imagemInsumo",modalInsumos).attr("src",'../img/noproduct.png')
            $(".bt_excluir_Insumo").hide()
            $(".menu-reposicoes").show()
        })

        $("#baixarOrdem").on("click",function(){
            print()
        })

        $(".nav-tabs .insumusNav").on("click",function(){
            $("#example20").DataTable().ajax.reload( null, false )
        })

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

        totau = parseFloat(sum) + parseFloat(trataValor($(".mobra").text(),1))
        $(".pressoTotau").text(trataValor(totau,0))
        if($(".pressoTotau").attr("data-metodo") == 2){
            metodoParcelado = jurosParcelas(trataValor($(".pressoTotau").text(),1),$(".pressoTotau").attr("data-parcelas"),$(".pressoTotau").attr("data-juros"))
            var parcelas = metodoParcelado.parcelas;
            var valorParcela = metodoParcelado.valorParcela;
            var vf = metodoParcelado.valorFinal;
            var labelVal = trataValor(vf,0)+"("+parcelas+"x "+trataValor(valorParcela,0)+")";
            $(".pressoTotau").text(labelVal)
        }else if($(".pressoTotau").attr("data-metodo") == 3){
            var totalP = taxaMaquininha(parseFloat(trataValor($(".pressoTotau").text(),1)),$(".pressoTotau").attr("data-juros"))
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
            $(".pressoTotau").text(trataValor(totalP,0))
        }else{
            $(".pressoTotau").text(trataValor(totau,0))
        }

        $(".pressoTotau").attr("data-original",trataValor(totau,0))
        ///
        $(".adicionarServico").on("click",function(){
            $(modalServicos).modal("show")
        })

        $("#baixaOrdem").on("show.bs.modal",function(){
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
            totau = parseFloat(sum) + parseFloat(trataValor($(".mobra").text(),1))
            $(".pressoTotau").text(trataValor(totau,0))
            $(".totalPagar").text(trataValor(totau,0))
            $(".pressoTotau").attr("data-original",trataValor(totau,0))
            $(".pressoTotau").attr("data-cru",trataValor(totau,0))
        ///
        })

        $("#cadastroInsumos").on("show.bs.modal",function(){
            $("input[name=valorFixo]").attr("disabled",true)
            $("input[name=lucroInsumo]").attr("disabled",true)
        })

        $(".bt_excluir_Insumo").on("click",function(){
            var IDInsumo = $("input[name=IDInsumo]",formInsumo).val()
            // alert(IDInsumo)
            $modal = {
                titulo : "Excluir Insumo",
                conteudo : "Deseja excluir o Insumo?",
                botao : {
                    class : "botao btn btn-danger",
                    texto : "Excluir",
                    funcao : ()=>{
                        $.ajax({
                            method : "POST",
                            url : "./../Configs/exclusaoDado.php",
                            data : {
                                setor : 'Produto',
                                ID   : IDInsumo
                            },
                            success : function(s){
                                console.log(s)
                            $("#example19").DataTable().ajax.reload( null, false );
                            $("#alerta").modal("hide")
                            $("#cadastroInsumo").modal("hide") 
                            }
                        })
                    } 
                }
            }
            abreModal($modal)
        })

        // $("#baixaOrdem").on("hide.bs.modal",function(){
        //     $(".finalisassao").html("")
        // })

        $(".bt_excluir_servico").hide()
        $(modalServicos).on("hide.bs.modal",function(){
            $(".bt_excluir_servico").hide()
            $('input[name=tipoServico]').parent().show()
        })

        $(".adicionarOrdemServico").on("click",function(){
            $(modalOrdemServico).modal("show")
        })

        $(".bt_salvar_servico").on("click",function(){
            setServico(formServicos)
        })

        $(".bt_salvar_ordemservico").on("click",function(){
            setOrdemServico(formOrdemServico)
        })
        $("input[name=codigoInsumo]").attr("disabled",true)
        $("select[name=identificacao]").on("change",function(){
            $("input[name=codigoInsumo]").attr("disabled",false)
            if($(this).val() == "CB"){
                $("input[name=codigoInsumo]").attr("placeholder","Codigo EAN-13")
                $("input[name=codigoInsumo]").attr("minlength",13)
                $("input[name=codigoInsumo]").attr("maxlength",13)
                $('input[name=codigoInsumo]').on("change",function(e){
                    if( $(this).val().length == 13){
                        var Insumo = $(this).val();
                        //
                        const settings = {
                            "async": true,
                            "crossDomain": true,
                            "url": "https://barcodes1.p.rapidapi.com/?query="+Insumo+"",
                            "method": "GET",
                            "headers": {
                                "X-RapidAPI-Key": "876f3e156bmsh79541acb2766591p1950a4jsnc1bd46bf269b",
                                "X-RapidAPI-Host": "barcodes1.p.rapidapi.com"
                            }
                        };
        
                        $.ajax(settings).done(function (response) {
                            //
                            $("input[name=nomeInsumo]",modalInsumos).val(response.product.title.replace(/[\\"]/g, ''))
                            $("input[name=imagemInsumo]",modalInsumos).val(response.product.images[0].replace(/[\\"]/g, ''))
                            $(".imagemInsumo",modalInsumos).attr("src",response.product.images[0].replace(/[\\"]/g, ''))
                            //
                        });
                        //
                    }            
                })
            }else if($(this).val() == "ID"){
                $("input[name=codigoInsumo]").attr("placeholder","Codigo Aleatório de 6 Números")
                $("input[name=codigoInsumo]").attr("minlength",6)
                $("input[name=codigoInsumo]").attr("maxlength",6)
            }else{
                $("input[name=codigoInsumo]").attr("disabled",true)
                $("input[name=codigoInsumo]").attr("placeholder","")
            }
        })

        $("input[name=valorFixo]").attr("disabled",true)
        $("input[name=lucroInsumo]").attr("disabled",true)
        $("input[name=custoInsumo]").on("keyup",function(){
            if(trataValor($(this).val(),1) > 0){
                $("input[name=valorFixo]").attr("disabled",false)
                $("input[name=lucroInsumo]").attr("disabled",false)
            }else{
                $("input[name=valorFixo],input[name=valorFixo]").attr("disabled",true)
                $("input[name=valorFixo],input[name=lucroInsumo]").attr("disabled",true)
            }
        })

        $('input[name=lucroInsumo]').on("keyup",function(e){
            var v_lucro = $(this).val();
            var v_custo = trataValor($('input[name=custoInsumo]').val(),1);
            var v_pct = (v_lucro/100)*v_custo;
            var v_preco = parseFloat(v_pct) + parseFloat(v_custo);
            $('input[name=valorInsumo]').val(v_preco);
            $('.valorInsumo').text(trataValor(v_preco,0));
        });

        $('input[name=valorFixo]').on("keyup",function(e){
            //alert("mudou")
            var precoFixo = trataValor($(this).val(),1);
            var custoo = trataValor($('input[name=custoInsumo]').val(),1);
            var calculo1 = precoFixo - custoo
            var calculo2 = calculo1 * 100
            var resultado = calculo2/custoo
            $('input[name=lucroInsumo]').val(new Intl.NumberFormat('default', {style:'percent', minimumFractionDigits: 2, maximumFractionDigits: 2, }).format(
                resultado/100,
            ))
            //alert($(this).val())
            $(".valorInsumo").text($(this).val())
        });


        //BAIXAR ORDEM
        $(".bt_baixar_ordem").on("click",function(){
            baixaOrdem("#formBaixaOrdem")
        })
        $("#getTroco").on("hide.bs.modal",function(){
            $("input[name=valorDado]").val("")
            $("#trocoVolta").text("")
        })
        //MODAL DE ADICIONAR EMPRESA
        $(".adicionarInsumo").on("click",function(){
            $(".menu-reposicoes").hide()
            $(modalInsumos).modal("show");
        })
        //SALVAR CUSTO
        $(".bt_salvar_custos").on("click",function(){
            setCusto("#formCadastroCustos")
        })

        $(".bt_excluir_servico").on("click",function(){
            var IDServico = $("input[name=IDServico]",formServicos).val()
            //alert(IDServico)
            $modal = {
                titulo : "Excluir Serviço",
                conteudo : "Deseja excluir o serviço?",
                botao : {
                    class : "botao btn btn-danger",
                    texto : "Excluir",
                    funcao : ()=>{
                        $.ajax({
                            method : "POST",
                            url : "./../Configs/exclusaoDado.php",
                            data : {
                                setor : 'Servico',
                                ID   : IDServico
                            },
                            success : function(){
                            $("#example18").DataTable().ajax.reload( null, false );
                            $("#alerta").modal("hide")
                            $("#cadastroServicos").modal("hide") 
                            }
                        })
                    } 
                }
            }
            abreModal($modal)
        })

        //ENVIAR DADOS DA EMPRESA
        $(".bt_salvar_Insumo").on("click",function(e){
            salvarInsumo(formInsumo)
        })
        
        //EXPORTA PARA XLS
        $(".xlsx").on("click",function(){
            window.location.href="./processamento/exportExcel.php?Setor=Insumos"
        })

        $(".pdf").on("click",function(){
            window.location.href="./processamento/exportPdf.php?Setor=Insumos"
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
                   $(".imagemInsumo").attr("src",imagemBase64)
                   $("input[name=imagemInsumo]").val(imagemBase64)
                }  
    
                // O metodo readAsDataURL e usado para ler o conteudo
                lerArquivo.readAsDataURL(carregarImagem);
            }
        })

    }

    window.jsPDF = window.jspdf.jsPDF;
    var docPDF = new jsPDF();

    function print(){
        var elementHTML = document.querySelector(".ordem");
        docPDF.html(elementHTML, {
        callback: function(docPDF) {
        docPDF.save('Ordem de serviço.pdf');
        },
        x: 15,
        y: 15,
        width: 170,
        windowWidth: 650
        });
    }

    function setOrdemServico(form){
        if(!validaCampos(form))return false
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data : {
                tipoOrdemServico      : $("select[name=tipoServico]",form).val(),
                nomeClienteServico      : $("select[name=nomeCliente]",form).val(),
                previaServico    : $("input[name=previaServico]",form).val(),
                descricaoServico : $("textarea[name=descricaoServico]",form).val()
            }
        }).done(function(ord){
            $("#example19").DataTable().ajax.reload( null, false )
            $("#cadastroOrdemServico").modal("hide")
        })
    }

    function baixaOrdem(form){
        if(!validaCampos(form))return false
        if($("select[name=pagamento]").val() == ""){
            alert("Selecione um método de pagamento!")
            return false
        }
        if($("textarea[name=ultimatoServico]").val() == ""){
            alert("Deixe uma mensagem na ordem de saída!")
            return false
        }
       envio = {
            ordem       : $("input[name=IDOrdem]",form).val(),
            colaborador : $("input[name=IDColaborador]",form).val(),
            cliente     : $("input[name=IDCliente]",form).val(),
            pagamento   : $("select[name=pagamento]",".finalisassao").val(),
            nota        : $("textarea[name=ultimatoServico]",form).val()
        }
        // console.log(envio)
        // return false
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data : envio
        }).done(function(ord){
            console.log(ord)
            $("#example19").DataTable().ajax.reload( null, false )
            $("#baixaOrdem").modal("hide")
        })
    }

    function setCusto(form){
        var custo = [];
        $("input[name=produto]:checked",form).each(function(){
            custo.push({'produto' : $(this).val(),'quantidade':$(this).parents("tr").find("input[type=text]").val()})
        })
        
        // console.log(custo)
        // return false

        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                'IDOrdem' : $("input[name=IDOrdem]",form).val(),
                'IDProduto' : custo
            },
            success : function(){
                $("#cadastroCustos").modal("hide")
            }
        }).done(function(response){
            console.log(response)
        })

    }

    function setServico(form){
        if($("input[name=valorBase]",form).val() == "" || $("input[name=valorBase]",form).val() == 0 ){
            vBase = 0
        }else{
            vBase = trataValor($("input[name=valorBase]",form).val(),1)
        }
        if(!validaCampos(form))return false
        //SE O SERVIÇO E POR HORA
        //ENVIO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data : {
                IDServico     : $("input[name=IDServico]",form).val(),
                tipoServico   : $("input[name=tipoServico]",form).val(),
                tipoGarantia  : $("select[name=tipoGarantia]",form).val(),
                tempoGarantia : $("input[name=tempoGarantia]",form).val(),
                valorBase     : vBase
            }
        }).done(function(result){
            console.log(result)
            abrirPagina("views/servicos.php")
            $("#example18").DataTable().ajax.reload( null, false )
            $("#cadastroServicos").modal("hide")
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

    function salvarInsumo(form){
        var modalInsumos = "#cadastroInsumos";
        //INICIA VALIDACAO DOS CAMPOS

        if($("input[name=IDInsumo]",form).val()){
            if(parseInt($("input[name=estoqueInsumo]",form).val()) < parseInt($("input[name=estoqueInsumo]",form).attr("data-original"))){
                aviso("A Reposição e Menor que a Quantidade já Existente")
                return false
            }
        }

        if(parseInt($("input[name=estoqueMinimo]",form).val()) > parseInt($("input[name=estoqueInsumo]",form).val()) || parseInt($("input[name=estoqueMinimo]",form).val()) > parseInt($("input[name=estoqueInsumo]",form).val()) ){
            aviso("O Estoque Minimo e maior do que o estoque existente, talvez seja a hora de fazer uma reposição, ou insirá um valor maior do que o estoque mínimo")
            return false
        }
        if($("input[name=validadeInsumo]",form).length > 0){
            var validadd = $("input[name=validadeInsumo]",form).val()
        }else{
            validadd = ""
        }
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                identificacao : $("select[name=identificacao]",form).val(),
                IDProduto     : $("input[name=IDInsumo]",form).val(),
                codigo        : $("input[name=codigoInsumo]",form).val(),
                nome          : $("input[name=nomeInsumo]",form).val(),
                categoria     : $("input[name=categoriaInsumo]",form).val(),
                fornecedor    : $("select[name=fornecedorInsumo]",form).val(),
                garantia      : $("select[name=garantiaInsumo]",form).val(),
                qtGarantia    : $("input[name=qtValidade]",form).val(),
                estoque       : $("input[name=estoqueInsumo]",form).val(),
                estoqueMinimo : $("input[name=estoqueMinimo]",form).val(),
                custo         : trataValor($("input[name=custoInsumo]",form).val(),1),
                tipo          : $("select[name=tipoInsumo]",form).val(),
                validade      : validadd,
                valor         : trataValor($(".valorInsumo",form).text(),1),
                imagem        : $("input[name=imagemInsumo]",form).val(),
                lucro         : $("input[name=lucroInsumo]",form).val().replace('%',''),
                insumo        : 1
            }
        }).done(function(resultado){
            console.log(resultado);
            // return false
            if($("input[name=IDInsumo]",form).val()){
                if($("input[name=estoqueInsumo]",form).val() != $("input[name=estoqueInsumo]",form).attr("data-original")){
                    //
                    var VLRep = $("input[name=estoqueInsumo]",form).val() - $("input[name=estoqueInsumo]",form).attr("data-original")
                    var VLCusto =  trataValor($("input[name=custoInsumo]",form).val(),1) * VLRep
                    setReposicao({
                        Quantidade : $("input[name=estoqueInsumo]",form).val() - $("input[name=estoqueInsumo]",form).attr("data-original"),
                        Insumo : $("input[name=IDInsumo]",form).val(),
                        Custo : VLCusto
                    })
                    //
                }
            }
            $("#example20").DataTable().ajax.reload( null, false )
            $(modalInsumos).modal("hide")
        })
    }
    //FIM DA PAGINA
})


