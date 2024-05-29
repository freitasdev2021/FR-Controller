jQuery(function($){
    var db = openDatabase('dbtips','1.0','FR Pdv',1024*1024*1024)
    db.transaction(function(database){
        database.executeSql('CREATE TABLE produtos (IDProduto INT,IDPromocao INT,IDFornecedor INT,DSCodigoProduto VARCHAR(13),NMProduto VARCHAR(50),VLProduto INT,DSUnidadeProduto INT,NUEstoqueProduto INT,NUEstoqueMinimo INT,DSImagemProduto TEXT)')
        database.executeSql('CREATE TABLE pagamentos (IDPagamento PRIMARY KEY,NMPagamento VARCHAR(50),QTDesconto INT,DSMetodo INT,QTParcelas INT,TPDesconto INT,IDFilial INT,NUJuros FLOAT)')
        database.executeSql('CREATE TABLE clientes (IDCliente PRIMARY KEY,VLDivida INT,NMCliente VARCHAR(50),NUCpfCliente VARCHAR(50),NMEmailCliente VARCHAR(100),NUTelefoneCliente VARCHAR(20))')
        database.executeSql('CREATE TABLE caixa (IDCaixa PRIMARY KEY,IDProduto INT,DSCodigoProduto VARCHAR(13),NMProduto VARCHAR(50),VLUnitario INT,DSUnidade INT,IDPromocao INT,IDFornecedor INT,DSQuantidadeProduto FLOAT,VLTotal INT,DSImagemProduto VARCHAR(50))')
        database.executeSql('CREATE TABLE vendas (IDProduto INT,IDFornecedor INT,IDPromocao INT,IDCliente INT,IDColaborador INT,NUUnidadesVendidas INT,IDCaixa INT,IDFilial INT,DTVenda DATETIME default current_timestamp,IDPagamento INT,VLVenda FLOAT,CDVenda VARCHAR(20))')
        database.executeSql('CREATE TABLE cupons (IDCaixa INT,ANCupom TEXT,CDVenda VARCHAR(20),IDCliente INT,IDFilial INT)')
    })
    montaActions()
    var timeDisplay = document.getElementById("datahora");

    function refreshTime() {
        var dateString = new Date().toLocaleString("pt-br", {timeZone: "America/Sao_Paulo"});
        var formattedString = dateString.replace(", ", " - ");
        timeDisplay.innerHTML = formattedString;
    }

    //TRATA OS FORMULARIOS
    function validaCampos(form){
        var inputs = [];
        $("input").parent().find(".error-input").hide()
        $("label").removeClass("text-danger")
        $("input").removeClass("border-danger")

        $("select").parents(".select").find(".error-input").hide()
        $("label").removeClass("text-danger")
        $("select").removeClass("border-danger")

        $("textarea").parent().find(".error-input").hide()
        $("label").removeClass("text-danger")
        $("textarea").removeClass("border-danger")

        $("input:visible",form).each(function(){
            if(!$(this).hasClass("norequire")){
                if($(this).val().length < $(this).attr("minlength")){
                    inputs.push($(this).attr("name"))
                }
            }
        })

        $("input[type=email]:visible",form).each(function(){
            if(!$(this).hasClass("norequire")){
                if($(this).val().length < $(this).attr("minlength") || !is_email($(this).val())){
                    inputs.push($(this).attr("name"))
                }
            }
        })

        $(".cpfCnpj input:visible",form).each(function(){
            if(!$(this).hasClass("norequire")){
                if($(this).val().length < $(this).attr("minlength") || !is_cpfcnpj($(this).val())){
                    inputs.push($(this).attr("name"))
                }
            }
        })

        $(".data input:visible",form).each(function(){
            if(!$(this).hasClass("norequire")){
                if($(this).val().length < $(this).attr("minlength")){
                    inputs.push($(this).attr("name"))
                }
            }
        })

        $("select:visible",form).each(function(){
            if(!$(this).hasClass("norequire")){
                if($(this).val() == ""){
                    inputs.push($(this).attr("name"))
                }
            }
        })

        $("textarea:visible",form).each(function(){
            if(!$(this).hasClass("norequire")){
                if($(this).val() == ""){
                    inputs.push($(this).attr("name"))
                }
            }
        })

        if(inputs.length > 0){
            $(inputs).each(function(index,val){
                $("input[name='"+val+"']").parent().find(".error-input").show()
                $("input[name='"+val+"']").parent().find("label").addClass("text-danger")
                $("input[name='"+val+"']").addClass("border-danger")
                //
                $("select[name='"+val+"']").parent().find(".error-input").show()
                $("select[name='"+val+"']").parent().find("label").addClass("text-danger")
                $("select[name='"+val+"']").addClass("border-danger")
                //
                $("textarea[name='"+val+"']").parent().find(".error-input").show()
                $("textarea[name='"+val+"']").parent().find("label").addClass("text-danger")
                $("textarea[name='"+val+"']").addClass("border-danger")
            })
            return false
        }
        return true
    }

    function setCliente(form){
        //INICIA VALIDACAO DOS CAMPOS
        var acesso = jQuery.parseJSON(localStorage.getItem('login'))
        var modalClientes = "#cadastroCliente";
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "https://www.frcontroller.com.br/Configs/setPoint.php",
            data   : {
                IDCliente            : $("input[name=IDCliente]",form).val(),
                nomeCliente          : $("input[name=nomeCliente]",form).val(),
                emailCliente         : $("input[name=emailCliente]",form).val(),
                telefoneCliente      : $("input[name=telefone]",form).val().replace(/[^0-9]+/g,''),
                cpfCliente           : $("input[name=cpf]",form).val().replace(/[^0-9]+/g,''),
                key                  : "TVFZMTE1OQ==",
                adccliente           : true,
                filial               : acesso.filial
            },
            error : function(r){
                nomeCliente  = $("input[name=nomeCliente]",form).val(),
                emailCliente  = $("input[name=emailCliente]",form).val(),
                telefoneCliente = $("input[name=telefone]",form).val().replace(/[^0-9]+/g,''),
                cpfCliente  = $("input[name=cpf]",form).val().replace(/[^0-9]+/g,'')
                alert("sem nett")
                db.transaction(function(stc){
                    stc.executeSql("INSERT INTO clientes (IDCliente,NMCliente,NUCpfCliente,NMEmailCliente,NUTelefoneCliente) VALUES(0,'"+nomeCliente+"','"+cpfCliente+"','"+emailCliente+"','"+telefoneCliente+"')")
                })
                window.location.reload()
            }
        }).done(function(resultado){
            //console.log(resultado)
            window.location.reload()
        })
    }

    function is_email(email){
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function formataCep(cep){
        var str = "";
        cep = cep.replace(/[^0-9]+/g,'');
        cep = cep.substring(0,8);
        for(i=0;i < cep.length; i++){
            if(i==5){str = str +'-'};
            str = str+ (cep[i].toString());
        }
        return str;
    }

    function formataTelefone(num){
        var str = "";
        num = num.replace(/[^0-9]+/g,'');
        num = num.substring(0,11);
        for(i=0;i < num.length; i++){
            if(i==0){str = str +'('};
            if(i==2){str = str +') '};
            if(num.length == 10)
                if(i==6){str = str +'-'};
            if(num.length == 11)
                if(i==7){str = str +'-'};
            str = str+ (num[i].toString());
        }
        return str;
    }

    function formataCnpj(num){
        var str = "";
        num = num.replace(/[^0-9]+/g,'');
        num = num.substring(0,14);
        for(i=0;i < num.length; i++){
            if(i==2 || i==5){str = str +'.'};
            if(i==8){str = str +'/'};
            if(i==12){str = str +'-'};
            str = str+ (num[i].toString());
        }
        return str;
    }

    function formataData(num){
        var str = "";
        num = num.replace(/[^0-9]+/g,'');
        num = num.substring(0,8);
        for(i=0;i < num.length; i++){
            if(i==2){str = str +'/'};
            if(i==4){str = str +'/'};
            str = str+ (num[i].toString());
        }
        return str;
    }

    function formataCpf(num){
        var str = "";
        num = num.replace(/[^0-9]+/g,'');
        num = num.substring(0,11);
        for(i=0;i < num.length; i++){
            if(i==3 || i==6){str = str +'.'};
            if(i==9){str = str +'-'};
            str = str+ (num[i].toString());
        }
        return str;
    }

    function is_cpfcnpj(num){
        num = num.replace(/[^0-9]+/g,'');
        // CNPJ
        if( num.length == 14 ){
            cnpj = num;
            // Elimina CNPJs invalidos conhecidos
            if (cnpj == "00000000000000" || 
            cnpj == "11111111111111" || 
            cnpj == "22222222222222" || 
            cnpj == "33333333333333" || 
            cnpj == "44444444444444" || 
            cnpj == "55555555555555" || 
            cnpj == "66666666666666" || 
            cnpj == "77777777777777" || 
            cnpj == "88888888888888" || 
            cnpj == "99999999999999")
            return false;
            
            // Valida DVs
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0,tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                return false;
                
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                return false;
                    
            return true;
        }
        if( num.length == 11 ){
            strCPF = num;
            var Soma;
            var Resto;
            Soma = 0;
            if (strCPF == "00000000000" || 
            strCPF == "11111111111" || 
            strCPF == "22222222222" || 
            strCPF == "33333333333" || 
            strCPF == "44444444444" || 
            strCPF == "55555555555" || 
            strCPF == "66666666666" || 
            strCPF == "77777777777" || 
            strCPF == "88888888888" || 
            strCPF == "99999999999")
            return false;

            for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

            Soma = 0;
            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
            return true;
        } 
        return 0;
    }

    function jurosParcelas(valor,parcelas,juros){
        var x = valor/parcelas
        var y = x + (juros/100)*x
        var z = {
            parcelas : parcelas,
            valorParcela : y,
            valorFinal : y*parcelas
        }
        return z
    }
    
    function taxaMaquininha(valor,taxa){
        var x = valor + (taxa/100)*valor
        return x
    }

    function montaActions(){
        db.transaction(function(cx){
            cx.executeSql("SELECT * FROM caixa",[],function(i,v){
                retorno = v.rows
                for(qt=0;qt<retorno.length;qt++){
                    console.log(retorno[qt].IDProduto)
                    $(".barraPedidos").find("tbody").append("<tr data-fornecedor="+retorno[qt].IDFornecedor+" data-promo="+retorno[qt].IDPromocao+" data-produto="+retorno[qt].IDProduto+" data-codigoproduto="+retorno[qt].DSCodigoProduto+" class='prod_"+retorno[qt].DSCodigoProduto+"' data-valor="+retorno[qt].VLUnitario+"><td>"+retorno[qt].NMProduto+"</td><td class='val'>"+trataValor(retorno[qt].VLUnitario,0)+"</td><td class='qt'>"+retorno[qt].DSQuantidadeProduto+"</td><td class='valtotallinha'>"+trataValor(retorno[qt].VLTotal,0)+"</td><td><button class='btn btn-xs cancelarProduto' data-id='"+retorno[qt].IDProduto+"'>X</td></tr>")
                    $(".imagemProduto").attr("src",localStorage.getItem("imagemProduto"))
                }
            });
            cx.executeSql("SELECT SUM(VLTotal) as totalCompra FROM caixa",[],function(i,v){
                quantidadeTtl = v.rows
                $("#subtotalval").text(trataValor(v.rows[0].totalCompra,0))
            })
        })

        $("#modalCupom").on("hide.bs.modal",function(){
            window.location.reload()
        })

        //FUNÇÃO QUE MANTEM O RELÓGIO ATIVO
        var assessu = jQuery.parseJSON(localStorage.getItem('login'))
        setInterval(refreshTime, 1000);
        $(".pesquisaProduto").on("keyup",function(){
            filterFunction()
        })
        $(".pesquisaProduto").on("change",function(){
            if(typeof parseInt($(this).val()) != 'string'){
                $(this).parent().find("a[data-codigo="+$(this).val()+"]").trigger("click")
                $(this).val("")
            }
        })
        $(document).ready(function(){

           // alert(assessu.filial)
           //console.log(new Date())
            $(".pesquisaProduto").focus()
            var listaProdutosVendidos = []
            var codigodaVenda = genCodigoVenda();
            $(".pesquisaProduto").val("")
            $(".bt_finalizar_venda").on("click",function(){
                var venda = [];
                $(".barraPedidos").find("tbody tr").each(function(){
                    listaProdutosVendidos.push({
                        IDProduto    : $(this).attr("data-produto"),
                        IDFornecedor : $(this).attr("data-fornecedor"),
                        IDPromocao   : $(this).attr("data-promo"),
                        CDVenda      : genCodigoVenda(),
                        IDCliente    : $("select[name=cliente]").val(),
                        IDColaborador: assessu.colaborador,
                        NMProduto    : $(this).find("td:first-child").text(),
                        DSCodigoProduto : $(this).attr("data-codigoproduto"),
                        IDCaixa : localStorage.getItem("caixa"),
                        NUUnidadesVendidas : $(this).find(".qt").text(),
                        IDFilial : assessu.filial,
                        NUValorProduto : $(this).attr("data-valor"),
                        IDPagamento : $("select[name=pagamento]").val(),
                        VLVenda : $(this).attr("data-valor") * parseFloat($(this).find(".qt").text())
                    })
                })
                listaProdutosVendidos.CDVenda = codigodaVenda
                venda.IDPagamento = $("select[name=pagamento]").val()
                venda.IDFilial = assessu.filial
                venda.VLVenda = trataValor($("#valorModal").text(),1)
                venda.Vendas = listaProdutosVendidos
                venda.IDCaixa = localStorage.getItem("caixa")
                venda.CDVenda = codigodaVenda
                venda.IDCliente = $("select[name=cliente]").val()
                setVenda(venda)
            })

            $("input[name=qtUn]").on("keyup",function(){
                $(this).attr("value",$(this).val())
            })

            $(".barraPedidos").on("click",".cancelarProduto",function(){
                cancelaProduto($(this).attr("data-id"))
                window.location.reload()
            })

            $(".cancelarVenda").on("click",function(){
                cancelaVenda()
                window.location.reload()
            })

            $("#modalVenda").on("show.bs.modal",function(){
                $("#valorModal").text($("#subtotalval").text())
                $("#valorPago").text($("#subtotalval").text())
                $("#valorModal").attr("data-original",$("#subtotalval").text())
                $("#valorModal").attr("data-cru",$("#subtotalval").text())
            })
            $(".troko").hide()
            $(".troko input").on("keyup",function(){
                totau = trataValor($("#valorModal").text(),1)
                val = trataValor($(this).val(),1)
                $("#trokoVal").text(trataValor(val - totau,0))
            })
            //SELECIONA O CLIENTE
            $("select[name=cliente]").on("change",function(){
                if($(this).find('option:selected').attr("data-divida") > 0){
                    alert("Este cliente possui uma divida de R$"+trataValor($(this).find('option:selected').attr("data-divida"),0))
                }
            })
            //SELECIONA O METOD ODE PAGAMENTO
            $("select[name=pagamento]").on("change",function(){
                //PERGUNTA SE E EM DINHEIRO
                var v_mobra = trataValor($("#valorModal").attr("data-cru").trim(),1);
                if($(this).find('option:selected').attr("data-metodo") == 2){
                    var metodoParcelado = jurosParcelas(trataValor($("#valorModal").text(),1),$(this).find('option:selected').attr("data-parcelas"),$(this).find('option:selected').attr("data-juros"))
                    var parcelas = metodoParcelado.parcelas;
                    var valorParcela = metodoParcelado.valorParcela;
                    var vf = metodoParcelado.valorFinal;
                    var labelVal = trataValor(vf,0)+"("+parcelas+"x "+trataValor(valorParcela,0)+")";
                    $("#valorPago").text(labelVal)
                    $("#valorModal").text($("#valorModal").attr("data-original"))
                    $("#valorModal").attr("data-original",$("#valorModal").text())
                }else if($(this).find('option:selected').attr("data-metodo") == 3){
                    var totalP = taxaMaquininha(parseFloat(trataValor($("#valorModal").text(),1)),$(this).find('option:selected').attr("data-juros"))
                    $("#valorModal").text($("#valorModal").attr("data-original"))
                    $("#valorModal").attr("data-original",$("#valorModal").text())
                    $("#valorPago").text(trataValor(totalP,0))
                }else{
                    if($(this).find('option:selected').attr("data-metodo") == 4){
                        $(".troko").show()
                    }else{
                        $(".troko").hide()
                    }
                    //
                    if($(this).find('option:selected').attr("data-tipodesconto") == 1){
                        var v_desconto = $(this).find('option:selected').attr("data-desconto");
                        var v_pct = (v_desconto/100)*v_mobra;
                        var v_preco = parseFloat(v_mobra) - parseFloat(v_pct);
                        $("#valorModal").text(trataValor(v_preco,0))
                        $("#valorPago").text(trataValor(v_preco,0))
                    }else{
                        var v_desconto = $(this).find('option:selected').attr("data-desconto");
                        var v_preco = parseFloat(v_mobra) - parseFloat(v_desconto);
                        $("#valorModal").text(trataValor(v_preco,0))
                        $("#valorPago").text(trataValor(v_preco,0))
                    }
                }
            })
            //
            $(".otherModal").on("hide.bs.modal",function(){
                if(!$(this).hasClass("alerta")){
                    $("select").val("")
                    $("input[type=text],input[type=email],input[type=name],input[type=password],input[type=hidden]",this).val("")
                    $("select").val("")
                    $("input",this).css("border-color","")
                    $("label").removeClass("text-danger")
                    $("input").parents().find(".error-input").hide()
                    $("label").removeClass("text-danger")
                    $("input").removeClass("border-danger")
                    $(".permTitle").removeClass("text-danger")
                    $("select").parents(".select").find(".error-input").hide()
                    $("label").removeClass("text-danger")
                    $("select").removeClass("border-danger")
                    $("input[type=checkbox]").prop("checked",false)
                    $("input[type=datetime-local]").val("")
                    $("input[type=date]").val("")
                    $("textarea").removeClass("border-danger")
                    $("label").removeClass("text-danger")
                    $("textarea").parents(".textarea").find(".error-input").hide()
                    $("textarea").val("")
                    $('.valorProduto').text("");
                }else{

                }
            })

            $(".modal").on("show.bs.modal",function(){
                $(".error-input").hide()
            })

            $("input[name=cpf]").keyup(function(){
                $(this).val(formataCpf($(this).val()))
            })

            $(".data input").keyup(function(){
                $(this).val(formataData($(this).val()))
            })

            $(".money input").maskMoney({ 
                allowNegative: false,
                thousands:'.',
                decimal:',',
                affixesStay: true
            })

            $(".peso").inputmask("9.999")

            $("input[name=cep]").keyup(function(){
                $(this).val(formataCep($(this).val()))
            })
            $("input[name=telefone]").keyup(function(){
                $(this).val(formataTelefone($(this).val()))
            })

            $(".bt_baixar_cupom").on("click",function(e){
                e.preventDefault()
                print()
            })

            $('input[type=name]').bind('input',function(){
                str = $(this).val().replace(/[^A-Za-z\u00C0-\u00FF\-\/\s]+/g,'');
                str = str.replace(/[\s{ \2 }]+/g,' ');
                if(str == " ")str = "";
                $(this).val( str );
            });

            $('input[name=numero],.numbers').bind('input',function(){
                str = $(this).val().replace(/[^0-9]+/g,'');
                str = str.replace(/[\s{ \2 }]+/g,' ');
                if(str == " ")str = "";
                $(this).val( str );
            });

            $("input[type=email]").bind('input',function(){
                str = $(this).val().replace(/[^A-Za-z0-9\-\_\.\@]+/g,'');
                if(str == " ")str = "";
                $(this).val( str );
            })

            $('textarea').bind('textarea',function(){
                str = $(this).val().replace(/[^A-Za-z\u00C0-\u00FF\-\/\s]+/g,'');
                str = str.replace(/[\s{ \2 }]+/g,' ');
                if(str == " ")str = "";
                $(this).val( str );
            });
            //CONFERE O LOGIN E O CAIXA
            if(!localStorage.getItem('login')){
                $("#modalLogin").modal('show')
            }else{
                var acesso = jQuery.parseJSON(localStorage.getItem('login'))
                var caixas = jQuery.parseJSON(acesso.caixa)
                var IDFilial = acesso.filial;
                $("#operadorname").text(acesso.nomeColaborador)
                var IDUser = acesso.dados.id
                $("select[name=pdv]").append("<option value=''>Selecione</option>")
                if(caixas){
                    caixas.forEach((f)=>{
                        $("select[name=pdv]").append("<option value="+f.id+">"+f.caixa+"</option>")
                    })
                }else{
                    alert("Você não Cadastrou Pontos de Venda, Cadastre Pontos de Venda para poder abrir o Caixa ")
                }
                //getCaixas(localStorage.getItem('filial'))
                if(!localStorage.getItem('caixa')){
                    $("#modalAbreCaixa").modal('show')
                }else{
                    //SINCRONIZAÇÃO DE PRODUTOS
                    $(".bt_sincronizar_produtos").unbind("click")
                    $(".bt_sincronizar_produtos").on("click",function(){
                        alert("Vendas Sincronizadas com sucesso")
                        db.transaction(function(sql){
                            sql.executeSql("SELECT * FROM produtos",[],function(i,v){
                                retorno = v.rows
                                for(qt=0;qt<retorno.length;qt++){
                                    sincronizaProdutos(retorno[qt].IDProduto,retorno[qt].NUEstoqueProduto)   
                                }
                            })
                        })
                    })
                    //
                    //////////////SINCRINIZACAO DAS VENDAS
                    db.transaction(function(sql){
                        sql.executeSql("SELECT * FROM vendas",[],function(i,v){
                            retorno = v.rows
                            for(qt=0;qt<retorno.length;qt++){
                                if(retorno.length > 0){
                                    sincronizaVendas({
                                        IDProduto           : retorno[qt].IDProduto,
                                        IDFornecedor        : retorno[qt].IDFornecedor,
                                        IDPromocao          : retorno[qt].IDPromocao,
                                        IDCliente           : retorno[qt].IDCliente,
                                        IDColaborador       : retorno[qt].IDColaborador,
                                        NUUnidadesVendidas  : retorno[qt].NUUnidadesVendidas,
                                        IDCaixa             : retorno[qt].IDCaixa,
                                        IDFilial            : retorno[qt].IDFilial,
                                        DTVenda             : retorno[qt].DTVenda,
                                        IDPagamento         : retorno[qt].IDPagamento,
                                        VLVenda             : retorno[qt].VLVenda,
                                        CDVenda             : retorno[qt].CDVenda,
                                        sincvendas          : true,
                                        key                 : "TVFZMTE1OQ==",
                                    })
                                }
                            }
                        })
                    })
                    //////////////////////////////////////
                    getProdutos(IDFilial)
                    //PEGA A ADIÇÃO DE NOVOS
                    produtos = jQuery.parseJSON(localStorage.getItem("produtos"))
                    db.transaction(function(sql){
                        produtos.forEach((p)=>{
                            sql.executeSql("SELECT * FROM produtos WHERE IDProduto = '"+p.IDProduto+"'",[],function(i,v){
                                retorno = v.rows
                                if(retorno.length == 0){
                                    sql.executeSql("INSERT INTO produtos (IDProduto,IDPromocao,IDFornecedor,DSCodigoProduto,NMProduto,VLProduto,DSUnidadeProduto,NUEstoqueProduto,NUEstoqueMinimo,DSImagemProduto) VALUES('"+p.IDProduto+"','"+p.IDPromocao+"','"+p.IDFornecedor+"','"+p.DSCodigoProduto+"','"+p.NMProduto+"','"+p.NUValorProduto+"','"+p.DSUnidadeProduto+"','"+p.NUEstoqueProduto+"','"+p.NUEstoqueMinimo+"','"+p.DSImagemProduto+"')");
                                }
                            })
                        })
                    })
                    //
                    
                    getPagamentos(IDFilial)
                    //PEGA A ADIÇÃO DE NOVOS
                    pagamentos = jQuery.parseJSON(localStorage.getItem("pagamentos"))
                    db.transaction(function(sql){
                        pagamentos.forEach((p)=>{
                            sql.executeSql("SELECT * FROM pagamentos WHERE IDPagamento = '"+p.IDPagamento+"'",[],function(i,v){
                                retorno = v.rows
                                if(retorno.length == 0){
                                    sql.executeSql("INSERT INTO pagamentos (IDPagamento,NMPagamento,QTDesconto,DSMetodo,QTParcelas,TPDesconto,IDFilial,NUJuros) VALUES('"+p.IDPagamento+"','"+p.NMPagamento+"','"+p.QTDesconto+"','"+p.DSMetodo+"','"+p.QTParcelas+"','"+p.TPDesconto+"','"+p.IDFilial+"','"+p.NUJuros+"')")
                                }
                            })
                        })
                    })
                    
                    getClientes(IDFilial)
                    //PEGA A ADIÇÃO DE UM NOVO CLIENTE
                    clientes = jQuery.parseJSON(localStorage.getItem("clientes"))
                    db.transaction(function(sql){
                        clientes.forEach((c)=>{
                            //console.log("INSERT INTO clientes (IDCliente,VLDivida,NMCliente,NMEmailCliente,NUTelefoneCliente,NUCpfCliente) VALUES('"+c.IDCliente+"','"+c.VLDivida+"','"+c.NMCliente+"','"+c.NMEmailCliente+"','"+c.NUTelefoneCliente+"','"+c.NUCpfCliente+"')")
                            sql.executeSql("SELECT * FROM clientes WHERE IDCliente = '"+c.IDCliente+"'",[],function(i,v){
                                retorno = v.rows
                                if(retorno.length == 0){
                                    sql.executeSql("INSERT INTO clientes (IDCliente,VLDivida,NMCliente,NMEmailCliente,NUTelefoneCliente,NUCpfCliente) VALUES('"+c.IDCliente+"','"+c.VLDivida+"','"+c.NMCliente+"','"+c.NMEmailCliente+"','"+c.NUTelefoneCliente+"','"+c.NUCpfCliente+"')")
                                }
                                //
                            })
                            //SINCRONIZACAO SERVIDOR-CLIENTE
                            sql.executeSql("SELECT * FROM clientes",[],function(i,v){
                                retorno = v.rows
                                for(qt=0;qt<retorno.length;qt++){
                                    sincronizaClientes({
                                        IDCliente : retorno[qt].IDCliente,
                                        NMCliente : retorno[qt].NMCliente,
                                        NMEmailCliente : retorno[qt].NMEmailCliente,
                                        NUTelefoneCliente : retorno[qt].NUTelefoneCliente,
                                        NUCpfCliente : retorno[qt].NUCpfCliente
                                    })
                                }
                            })
                        })
                    })
                    //PEGA O CABECALHO DO CUPOM
                    getCabecalhoCupom(IDFilial)
                    //SINCRONIZA OS CUPONS
                    db.transaction(function(sql){
                        sql.executeSql("SELECT * from cupons",[],function(i,v){
                            retorno = v.rows
                            if(retorno.length > 0){
                                for(qt=0;qt<retorno.length;qt++){
                                    sincronizaCupons({
                                        IDCaixa : retorno[qt].IDCaixa,
                                        ANCupom : retorno[qt].ANCupom,
                                        CDVenda : retorno[qt].CDVenda,
                                        IDCliente : retorno[qt].IDCliente,
                                        IDFilial : retorno[qt].IDFilial
                                    })
                                }
                            }
                        })
                    })
                    //
                }
            }
            //AÇÃO DO BOTÃO DE LOGIN
            $(".bt_fazer_login").on("click",function(){
                fazLogin({
                    login : true,
                    key   : "TVFZMTE1OQ==",
                    email : $("input[name=email]","#modalLogin").val(),
                    senha : $("input[name=senha]","#modalLogin").val()
                })
            })
            //AÇÃO DO BOTÃO DE ABRIR CAIXA
            $(".bt_abrir_caixa").on("click",function(){
                abreCaixa({
                    caixa : true,
                    key   : "TVFZMTE1OQ==",
                    pdv : $("select[name=pdv]","#modalAbreCaixa").val(),
                    senha : $("input[name=senhaPdv]","#modalAbreCaixa").val()
                })
            })
            //AÇÃO DO BOTÃO DE FECHAR CAIXA
            $(".bt_fechar_caixa").on("click",function(){
                fecharCaixa(IDFilial,IDUser,localStorage.getItem('caixa').replace('',''))
            })
            $(".bt_logout").on("click",function(){
                localStorage.removeItem('login')
                window.location.href="https://www.frcontroller.com.br/Configs/abreFilial.php?key=TVFZMTE1OQ==&open&user="+window.btoa(IDUser)+"&filial="+window.btoa(IDFilial);
            })
            //AÇÃO DO BOTÃO QUE ABRE O MODAL DE FINALIZAÇÃO
            $(".finalizacao").on("click",function(){
                $("#modalVenda").modal("show")
            })
            //AÇÃO DO BOTÃO QUE ADICIONA CLIENTES
            $(".bt_adicionar_clientes").on("click",function(){
                $("#cadastroCliente").modal("show")
            })
            //AÇÃO DO BOTÃO DE SALVAR CLIENTE
            $(".bt_salvar_cliente").on("click",function(e){
                setCliente("#formCadastroClientes");
            })
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

    function cancelaProduto(ID){
        db.transaction(function(dtb){
            dtb.executeSql("DELETE FROM caixa WHERE IDProduto = "+ID+" ")
        })
    }

    function getCabecalhoCupom(ID){
        $.ajax({
            method : "POST",
            url : "https://www.frcontroller.com.br/Configs/endpoint.php?key=TVFZMTE1OQ==&cabecalhos&filial="+window.btoa(ID)
        }).done(function(retDados){
            //console.log(retDados)
            localStorage.setItem('headerCupom',retDados)
        })
    }

    function cancelaVenda(){
        db.transaction(function(dtb){
            dtb.executeSql("DELETE FROM caixa WHERE IDProduto")
        })
    }

    function setCupomOffline(cupom){
        db.transaction(function(c){
            c.executeSql("INSERT INTO cupons (IDCaixa,ANCupom,CDVenda,IDCliente,IDFilial) VALUES('"+cupom.IDCaixa+"','"+cupom.ANCupom+"','"+cupom.CDVenda+"','"+cupom.IDCliente+"','"+cupom.IDFilial+"')")
        })
    }

    function setVenda(venda){
        if(!validaCampos("#formVenda"))return false
        valorCmpra = trataValor($("#valorModal").text(),1);
        // console.log(venda)
        // return false
        $.ajax({
            method : "POST",
            url : "https://www.frcontroller.com.br/Configs/setPoint.php",
            async : true,
            crossDomain : true,
            data : {
                key                   : "TVFZMTE1OQ==",
                vender                : true,
                listaProdutosVendidos : JSON.stringify(venda.Vendas),
                IDPagamento           : venda.IDPagamento,
                IDFilial              : venda.IDFilial,
                VLVenda               : valorCmpra,
                IDCaixa               : venda.IDCaixa,
                IDCliente             : venda.IDCliente,
                CDVenda               : venda.CDVenda
            },
            success: function(r){
                console.log(r)
                $("#modalCupom").find(".modal-body").html(r)
                $("#modalCupom").modal("show")
                db.transaction(function(ts){
                    ts.executeSql("DELETE FROM caixa WHERE rowid > 0")
                })
                //window.location.reload();
            },
            error : function(e){
                //
                valorCompra = parseFloat(trataValor($("#valorModal").text(),1));
                cabecalhoCupom = jQuery.parseJSON(localStorage.getItem("headerCupom"))
                enderecoCupom = jQuery.parseJSON(cabecalhoCupom.DSEnderecoJSON);
                venda.Vendas.forEach((f)=>{
                    db.transaction(function(ins){
                        ins.executeSql("UPDATE produtos SET NUEstoqueProduto = NUEstoqueProduto - "+f.NUUnidadesVendidas+" WHERE DSCodigoProduto = '"+f.DSCodigoProduto+"' ")
                        ins.executeSql("SELECT * FROM pagamentos WHERE IDPagamento ='"+venda.IDPagamento+"'",[],function(i,v){
                            retorno = v.rows[0]
                            if(retorno.TPDesconto == 1){
                                preco = f.VLVenda - (retorno.QTDesconto*f.VLVenda)/100;
                            }else if(retorno.TPDesconto == 2){
                                preco = f.VLVenda - retorno.QTDesconto;
                            }else{
                                preco = f.VLVenda
                            }
                            ins.executeSql("INSERT INTO vendas (IDProduto,IDFornecedor,IDPromocao,IDCliente,IDColaborador,NUUnidadesVendidas,IDCaixa,IDFilial,IDPagamento,VLVenda,CDVenda) VALUES('"+f.IDProduto+"','"+f.IDFornecedor+"','"+f.IDPromocao+"','"+venda.IDCliente+"','"+f.IDColaborador+"','"+f.NUUnidadesVendidas+"','"+venda.IDCaixa+"','"+venda.IDFilial+"','"+venda.IDPagamento+"','"+preco+"','"+venda.CDVenda+"')")
                        })
                    })
                })
                db.transaction(function(dtb){
                    dtb.executeSql("DELETE FROM caixa ")
                })
                //
                db.transaction(function(desc){
                    desc.executeSql("SELECT * FROM pagamentos WHERE IDPagamento = '"+venda.IDPagamento+"'",[],function(i,v){
                        retorno = v.rows[0]

                        if(retorno.QTParcelas > 0){
                            switch(retorno.DSMetodo){
                                case 3:
                                    var totalP = taxaMaquininha(valorCompra,f.NUJuros)
                                    vPago = totalP
                                break;
                                case 2:
                                    metodoParcelado = jurosParcelas(valorCompra,retorno.QTParcelas,retorno.NUJuros)
                                    var parcelas = metodoParcelado.parcelas;
                                    var valorParcela = metodoParcelado.valorParcela;
                                    var vf = metodoParcelado.valorFinal;
                                    var labelVal = trataValor(vf,0)+"("+parcelas+"x "+trataValor(valorParcela,0)+")";
                                    vPago = labelVal
                                break;
                                default:
                                    var vPago = trataValor(valorCompra,0)
                            }
                        }else{
                            var vPago = trataValor(valorCompra,0)
                        }

                        NMPagamento = retorno.NMPagamento
                        if(retorno.TPDesconto == 1){
                           tipoDesconto = retorno.QTDesconto+"%"
                        }else if(retorno.TPDesconto == 2){
                            tipoDesconto = "R$ "+trataValor(retorno.QTDesconto,0)
                        }else{
                            tipoDesconto = 0;
                        }
                        //
                        var ANCupom = {
                            empresa    : cabecalhoCupom.NMRazaoEmpresa,
                            filial     : cabecalhoCupom.NMFilial,
                            cnpj       : cabecalhoCupom.NUCnpjEmpresa,
                            data       : refreshTime(),
                            produtos   : venda.Vendas,
                            valorpagar : valorCmpra,
                            pagamento  : NMPagamento,
                            IDPagamento: venda.IDPagamento
                        }
                        //
                        var envCupom = {
                            IDCaixa   : venda.IDCaixa,
                            ANCupom   : JSON.stringify(ANCupom),
                            CDVenda   : venda.CDVenda,
                            IDCliente : venda.IDCliente,
                            IDFilial  : venda.IDFilial
                        }
                        setCupomOffline(envCupom)
                        ///////
                        tableHtml = $("<table class='printer-ticket'>");
                        tableHtml.append("<thead style='background:white'>")
                        tableHtml.append("<tr align='center'<th class='title' colspan='3'>"+cabecalhoCupom.NMRazaoEmpresa+"</th></tr>")
                        tableHtml.append("<tr align='center'><th class='title' colspan='3'>"+cabecalhoCupom.NMFilial+"</th></tr>")
                        tableHtml.append("<tr align='center'><th class='title' colspan='3'>CNPJ<br>"+cabecalhoCupom.NUCnpjEmpresa+"</th></tr>")
                        tableHtml.append("<tr align='center'><th class='ttu' colspan='3'><b>Data: "+refreshTime()+"</b></th></tr>")
                        tableHtml.append("<tr align='center'><th class='ttu' colspan='3'><b>Cupom não fiscal</b></th></tr>")
                        tableHtml.append("<tr align='center'><th class='ttu' colspan='3'><hr><b>Produtos</b></th></tr>")
                        tableHtml.append("</thead>")
                        tableHtml.append("<body>")
                        //TBODY
                        tableHtml.append("<tr class='top'>")
                        tableHtml.append("<td colspan='1'><b>Produto</b></td>")
                        tableHtml.append("<td colspan='1'><b>CD</b></td>")
                        tableHtml.append("<td colspan='1'><b>V.Un</b></td>")
                        tableHtml.append("<td colspan='1'><b>Q.T</b></td>")
                        tableHtml.append("<td colspan='1'><b>V.T</b></td>")
                        tableHtml.append("</tr>")
                         //
                         venda.Vendas.forEach((f)=>{
                            tableHtml.append("<tr>")
                            tableHtml.append("<td>"+f.NMProduto+"</td>")
                            tableHtml.append("<td>"+f.DSCodigoProduto+"</td>")
                            tableHtml.append("<td>"+trataValor(f.NUValorProduto,0)+"</td>")
                            tableHtml.append("<td>"+f.NUUnidadesVendidas+"</td>")
                            tableHtml.append("<td>"+trataValor(f.VLVenda,0)+"</td>")
                            tableHtml.append("</tr>")
                        })
                        //
                        tableHtml.append("</body>")
                        //TFOOT
                        tableHtml.append("<tfoot>")
                        tableHtml.append("<tr><td class='sup ttu p--0' align='center' colspan='4'><b>Pagamento</b></td></tr>")
                        tableHtml.append("<tr><td class='ttu' colspan='2'>Forma de Pagamento</td><td align='right'>"+NMPagamento+"</td></tr>")
                        tableHtml.append("<tr><td class='ttu' colspan='2'>Desconto</td><td align='right'>"+tipoDesconto+"</td></tr>")
                        tableHtml.append("<tr><td class='ttu' colspan='2'>Total</td><td align='right'>"+vPago+"</td></tr>")
                        tableHtml.append("<tr><td class='sup' colspan='3'>Endereço</td><td align='right'></td></tr>")
                        tableHtml.append("<tr><td class='sup' colspan='3' align='center'>"+enderecoCupom.rua+", "+enderecoCupom.numero+", "+enderecoCupom.bairro+" - "+enderecoCupom.cidade+"/"+enderecoCupom.uf+"</td></tr>")
                        tableHtml.append("</tfoot>")
                        //TFOOT
                        tableHtml.append("</table>")
        
                        $("#modalCupom").find(".modal-body").html(tableHtml)
                        ///////
                    })
                })
                //
                
                $("#modalCupom").modal("show")
                alert("sem internet")
            }
        })
    }

    function fecharCaixa(filial,user,caixa){
        $.ajax({
            method : "POST",
            url : "https://www.frcontroller.com.br/Configs/setPoint.php",
            async : true,
            crossDomain : true,
            data : {
                ID : caixa,
                user : user,
                key   : "TVFZMTE1OQ==",
                fechacaixa : true
            }
        }).done(function(r){
            localStorage.removeItem('login')
            localStorage.removeItem('caixa')
            localStorage.removeItem('produtos')
            localStorage.removeItem('clientes')
            localStorage.removeItem('pagamentos')
            window.location.href="https://www.frcontroller.com.br/Configs/abreFilial.php?key=TVFZMTE1OQ==&open&user="+window.btoa(user)+"&filial="+window.btoa(filial);
        })
    }

    function fazLogin(credenciais){
        $.ajax({
            method : "POST",
            url : "https://www.frcontroller.com.br/Configs/setPoint.php",
            async : true,
            crossDomain : true,
            success : function(success){
                // console.log(success)
                // return false
                login = jQuery.parseJSON(success)
                if(!login['status']){
                    $("#modalLogin").find(".erroLogin").html("<h5 style='text-align:center;' class='text-danger'><strong>"+login['error']+"</strong></h5>")
                }else{
                    console.log(JSON.stringify(login['acesso']))
                    var accessJson = JSON.stringify(login['acesso']);
                    localStorage.setItem('login',accessJson)
                    window.location.reload()
                }
            },
            error : function(error){
                $("#modalLogin").find(".erroLogin").html("<h5 style='text-align:center;' class='text-danger'><strong>Sem Acesso a internet, para logar e nescessário estar conectado a internet, apenas para essa função, poderá ser utilizado sua rede movel</strong></h5>")
            },
            data : credenciais
        })
    }

    function abreCaixa(credenciais){
        $.ajax({
            method : "POST",
            url : "https://www.frcontroller.com.br/Configs/setPoint.php",
            async : true,
            crossDomain : true,
            success : function(success){
                caixa = jQuery.parseJSON(success)
                // console.log(parseInt(caixa['id']))
                // return false
                if(!caixa['status']){
                    $("#modalAbreCaixa").find(".erroLogin").html("<h5 style='text-align:center;' class='text-danger'><strong>"+caixa['error']+"</strong></h5>")
                }else{
                    localStorage.setItem('caixa',parseInt(caixa['id']))
                    window.location.reload()
                }
            },
            error : function(error){
                console.log(error)
                $("#modalAbreCaixa").find(".erroLogin").html("<h5 style='text-align:center;' class='text-danger'><strong>Sem Acesso a internet, para logar e nescessário estar conectado a internet, apenas para essa função, poderá ser utilizado sua rede movel</strong></h5>")
            },
            data : credenciais
        })
    }

    function trataValor(valor,tratamento){
        if(tratamento == 0){
            //TRATAENTO PARA EXIBIR NA TELA
            return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(valor).replace("R$","").trim()
        }else{
            //TRATAMENTO PARA PROCESSAR NO BACKEND
            var quantidade = 0;
            for (var i = 0; i < valor.length; i++) {
                if (valor[i] == "," || valor[i] == "." ) {
                    quantidade++
                }
            }
            //PERGUNTA SE A QUANTIDADE DE VIRGULAS E IGUAL A DOIS
            if(quantidade == 2){
                val = valor.replace(",",".").replace(".","")
            }else{
                val = valor.replace(",",".").trim()
            }
            return val.replace(",",".")
        }
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

    function getProdutos(filial){
        dadosCaixa = {}
        $.ajax({
            method : "GET",
            url : "https://www.frcontroller.com.br/Configs/endpoint.php?key=TVFZMTE1OQ==&produtos&filial="+window.btoa(filial),
            async : true,
            crossDomain : true,
            success : function(response){
                produtos = jQuery.parseJSON(response)
                localStorage.setItem("produtos",response)
                    //ATUALIZA DO BANCO A QUANTIDADE
                    db.transaction(function(dtb){
                        dtb.executeSql("SELECT * FROM produtos",[],function(i,v){
                            retorno = v.rows
                            if(retorno.length == 0){
                                produtos.forEach(function(p){
                                    dtb.executeSql("INSERT INTO produtos (IDProduto,IDPromocao,IDFornecedor,DSCodigoProduto,NMProduto,VLProduto,DSUnidadeProduto,NUEstoqueProduto,NUEstoqueMinimo,DSImagemProduto) VALUES('"+p.IDProduto+"','"+p.IDPromocao+"','"+p.IDFornecedor+"','"+p.DSCodigoProduto+"','"+p.NMProduto+"','"+p.NUValorProduto+"','"+p.DSUnidadeProduto+"','"+p.NUEstoqueProduto+"','"+p.NUEstoqueMinimo+"','"+p.DSImagemProduto+"')");
                                })
                            }else{
                                produtos.forEach((p)=>{
                                    dtb.executeSql("UPDATE produtos SET IDPromocao = '"+p.IDPromocao+"', IDFornecedor = '"+p.IDFornecedor+"', VLProduto = '"+p.NUValorProduto+"', NUEstoqueProduto = '"+p.NUEstoqueProduto+"', NUEstoqueMinimo = '"+p.NUEstoqueMinimo+"', DSImagemProduto = '"+p.DSImagemProduto+"' WHERE DSCodigoProduto = '"+p.DSCodigoProduto+"' ")
                                })
                            }
                        })
                        ///
                    })
                    //INSERE O SELECT
                    produtos.forEach(function(pr){
                        $("<a href='#' data-unidade="+pr.DSUnidadeProduto+" data-nome="+pr.NMProduto+" data-image="+pr.DSImagemProduto+" data-codigo="+pr.DSCodigoProduto+" data-val="+pr.NUValorProduto+" data-produto='"+pr.IDProduto+"' data-promo="+pr.IDPromocao+" data-fornecedor="+pr.IDFornecedor+"><img src="+pr.DSImagemProduto+" width='50px' height='50px'>&nbsp;"+pr.NMProduto+" - "+pr.DSCodigoProduto+"<br>Estoque/Estoque Minimo: "+pr.NUEstoqueProduto+"/"+pr.NUEstoqueMinimo+"</a>").insertAfter("#myDropdown .pesquisaProduto")
                    })
                //CARREGA OS PRODUTOS NO SELECT PARA VENDA
                $(".dropdown-content a").on("click",function(){
                    var codigo = $(this).attr("data-codigo")
                    var valorProduto = $(this).attr("data-val")
                    var nomeProduto = $(this).attr("data-nome")
                    var dsUnidade = $(this).attr("data-unidade")
                    var idProduto = $(this).attr("data-produto")
                    var idPromo = $(this).attr("data-promo")
                    var idFornecedor = $(this).attr("data-fornecedor")
                    dadosCaixa.DSCodigoProduto = codigo;
                    dadosCaixa.NMProduto = nomeProduto;
                    dadosCaixa.DSUnidade = dsUnidade;
                    dadosCaixa.IDProduto = idProduto;
                    dadosCaixa.IDPromocao = idPromo;
                    dadosCaixa.IDFornecedor = idFornecedor;
                    dadosCaixa.VLUnitario = valorProduto;
                    dadosCaixa.DSImagemProduto = $(this).attr("data-image")
                    localStorage.setItem("imagemProduto",$(this).attr("data-image"))
                    valAtual = parseFloat(trataValor($("#subtotalval").text(),1))
                    //ADICIONA NA LISTA
                    $(".barraPedidos").find("tbody").each(function(){
                        totalProd =+ trataValor($(".valtotallinha").text(),1)
                        if($(".prod_"+codigo).length > 0){
                            updt = true;
                            //alert("aqu1")
                            valorLinha = parseFloat(trataValor($(".prod_"+codigo).find(".val").text(),0))
                            valorTotalLinha = trataValor($(".prod_"+codigo).find(".valtotallinha").text(),1)
                            quantidadeLinha = parseFloat($(".prod_"+codigo).find(".qt").text())

                            if(dsUnidade == "UN"){
                                dadosCaixa.DSQuantidadeProduto = 1;
                                dadosCaixa.VLTotal = valorProduto
                                setCaixa(dadosCaixa,true) 
                            }else{
                                $("#modalQt").modal("show")
                                quantidadeLinha = $(".prod_"+codigo).find(".qt").text().trim()
                                $(".bt_somar_quantidade").on("click",function(){
                                    qtUn = parseFloat(trataValor($("input[name=qtUn]").attr("value"),1))
                                    dadosCaixa.DSQuantidadeProduto = qtUn;
                                    dadosCaixa.VLTotal = valorProduto
                                    setCaixa(dadosCaixa,true)
                                    $("#modalQt").modal("hide")
                                })
                            }
                        }else{
                            updt = false;
                            // alert("aquii")
                            if(dsUnidade == "UN"){
                                qtUn = 1.0
                                dadosCaixa.DSQuantidadeProduto = qtUn;
                                dadosCaixa.VLTotal = valorProduto
                                setCaixa(dadosCaixa,false)
                            }else{
                                $("#modalQt").modal("show")
                                $(".bt_somar_quantidade").on("click",function(){
                                    qtUn = parseFloat(trataValor($("input[name=qtUn]").attr("value"),1))
                                    dadosCaixa.DSQuantidadeProduto = qtUn;
                                    dadosCaixa.VLTotal = valorProduto * qtUn
                                    setCaixa(dadosCaixa,false)    
                                    $("#modalQt").modal("hide")
                                })
                            }
                        }
                    })
                    $(".dropdown-content a").hide()
                    //COMPORTAMENTO FINAL
                    $(".pesquisaProduto").val("")
                    //FIM
                })
                $(".dropdown-content a").hide()
                //alert($(".barraPedidos").find("tbody tr").length)
                if($(".barraPedidos").find("tbody tr").length == 0){
                    $(".finalizacao").attr("disabled",true)
                    $(".cancelarVenda").attr("disabled",true)
                }else{
                    $(".finalizacao").removeAttr("disabled",false)
                    $(".cancelarVenda").attr("disabled",false)
                }
            },
            error : function(response){
                //SEM INTERNET
                db.transaction(function(cx){
                    cx.executeSql("SELECT * FROM produtos",[],function(i,v){
                        retorno = v.rows
                        //console.log(retorno)
                        for(qt=0;qt<retorno.length;qt++){
                            $("<a href='#' data-unidade="+retorno[qt].DSUnidadeProduto+" data-nome="+retorno[qt].NMProduto+" data-image="+retorno[qt].DSImagemProduto+" data-codigo="+retorno[qt].DSCodigoProduto+" data-val="+retorno[qt].VLProduto+" data-produto='"+retorno[qt].IDProduto+"' data-promo="+retorno[qt].IDPromocao+" data-fornecedor="+retorno[qt].IDFornecedor+"><img src="+retorno[qt].DSImagemProduto+" width='50px' height='50px'>&nbsp;"+retorno[qt].NMProduto+" - "+retorno[qt].DSCodigoProduto+"<br>Estoque/Estoque Minimo: "+retorno[qt].NUEstoqueProduto+"/"+retorno[qt].NUEstoqueMinimo+"</a>").insertAfter("#myDropdown .pesquisaProduto")
                            //
                            $(".dropdown-content a").on("click",function(){
                                var codigo = $(this).attr("data-codigo")
                                var valorProduto = $(this).attr("data-val")
                                var nomeProduto = $(this).attr("data-nome")
                                var dsUnidade = $(this).attr("data-unidade")
                                var idProduto = $(this).attr("data-produto")
                                var idPromo = $(this).attr("data-promo")
                                var idFornecedor = $(this).attr("data-fornecedor")
                                dadosCaixa.DSCodigoProduto = codigo;
                                dadosCaixa.NMProduto = nomeProduto;
                                dadosCaixa.DSUnidade = dsUnidade;
                                dadosCaixa.IDProduto = idProduto;
                                dadosCaixa.IDPromocao = idPromo;
                                dadosCaixa.IDFornecedor = idFornecedor;
                                dadosCaixa.VLUnitario = valorProduto;
                                dadosCaixa.DSImagemProduto = $(this).attr("data-image")
                                localStorage.setItem("imagemProduto",$(this).attr("data-image"))
                                valAtual = parseFloat(trataValor($("#subtotalval").text(),1))
                                //ADICIONA NA LISTA
                                $(".barraPedidos").find("tbody").each(function(){
                                    totalProd =+ trataValor($(".valtotallinha").text(),1)
                                    if($(".prod_"+codigo).length > 0){
                                        updt = true;
                                        //alert("aqu1")
                                        valorLinha = parseFloat(trataValor($(".prod_"+codigo).find(".val").text(),0))
                                        valorTotalLinha = trataValor($(".prod_"+codigo).find(".valtotallinha").text(),1)
                                        quantidadeLinha = parseFloat($(".prod_"+codigo).find(".qt").text())

                                        if(dsUnidade == "UN"){
                                            dadosCaixa.DSQuantidadeProduto = 1;
                                            dadosCaixa.VLTotal = valorProduto
                                            setCaixa(dadosCaixa,true) 
                                        }else{
                                            $("#modalQt").modal("show")
                                            quantidadeLinha = $(".prod_"+codigo).find(".qt").text().trim()
                                            $(".bt_somar_quantidade").on("click",function(){
                                                qtUn = parseFloat(trataValor($("input[name=qtUn]").attr("value"),1))
                                                dadosCaixa.DSQuantidadeProduto = qtUn;
                                                dadosCaixa.VLTotal = valorProduto
                                                setCaixa(dadosCaixa,true)
                                                $("#modalQt").modal("hide")
                                            })
                                        }
                                    }else{
                                        updt = false;
                                        //alert("aqui2")
                                        if(dsUnidade == "UN"){
                                            qtUn = 1
                                            dadosCaixa.DSQuantidadeProduto = qtUn;
                                            dadosCaixa.VLTotal = valorProduto
                                            setCaixa(dadosCaixa,false)
                                        }else{
                                            $("#modalQt").modal("show")
                                            $(".bt_somar_quantidade").on("click",function(){
                                                qtUn = parseFloat(trataValor($("input[name=qtUn]").attr("value"),1))
                                                dadosCaixa.DSQuantidadeProduto = qtUn;
                                                dadosCaixa.VLTotal = valorProduto
                                                setCaixa(dadosCaixa,false)    
                                                $("#modalQt").modal("hide")
                                            })
                                        }
                                    }
                                })
                                $(".dropdown-content a").hide()
                                //COMPORTAMENTO FINAL
                                $(".pesquisaProduto").val("")
                                //FIM
                            })
                            $(".dropdown-content a").hide()
                        }
                    });
                })
                if($(".barraPedidos").find("tbody tr").length == 0){
                    $(".finalizacao").attr("disabled",true)
                }else{
                    $(".finalizacao").removeAttr("disabled",false)
                }
            }
        })
    }

    function sincronizaClientes(dados){
        //console.log(dados)
        var acesso = jQuery.parseJSON(localStorage.getItem('login'))
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "https://www.frcontroller.com.br/Configs/setPoint.php",
            data   : {
                IDCliente          : dados.IDCliente,
                NMCliente          : dados.NMCliente,
                NMEmailCliente     : dados.NMEmailCliente,
                NUTelefoneCliente  : dados.NUTelefoneCliente.replace(/[^0-9]+/g,''),
                NUCpfCliente       : dados.NUCpfCliente.replace(/[^0-9]+/g,''),
                key                : "TVFZMTE1OQ==",
                sinccliente        : true,
                IDFilial           : acesso.filial
            }
        }).done(function(resultado){
            console.log(resultado)
        })
    }

    function sincronizaCupons(dados){
        $.ajax({
            method : "POST",
            url : "https://www.frcontroller.com.br/Configs/setPoint.php",
            data : {
                IDCaixa     : dados.IDCaixa,
                ANCupom     : dados.ANCupom,
                CDVenda     : dados.CDVenda,
                IDCliente   : dados.IDCliente,
                IDFilial    : dados.IDFilial,
                key         : "TVFZMTE1OQ==",
                sinccupom   : true,
            },
            success : function(s){
                db.transaction(function(sql){
                    sql.executeSql("DELETE FROM cupons WHERE CDVenda = '"+dados.CDVenda+"'")
                })
            }
        })
    }

    function sincronizaProdutos(IDProduto,NUEstoque){
        $.ajax({
            method : "POST",
            url : "https://www.frcontroller.com.br/Configs/setPoint.php",
            data : {
                IDProduto    : IDProduto,
                NUEstoque    : NUEstoque,
                key          : "TVFZMTE1OQ==",
                sincprodutos : true
            }
        }).done(function(resultado){
            console.log(resultado)
        })
    }

    function sincronizaVendas(dados){
        $.ajax({
            method : "POST",
            url    : "https://www.frcontroller.com.br/Configs/setPoint.php",
            data   : dados,
            success : function(s){
                db.transaction(function(sql){
                    sql.executeSql("DELETE FROM vendas WHERE CDVenda = '"+dados.CDVenda+"'")
                })
            }
        })
    }
    
    function setCaixa(dados,update){
        // alert(update)
        // return false
        if(!update){
            db.transaction(function(caixa){
                caixa.executeSql("INSERT INTO caixa (IDProduto,DSCodigoProduto,NMProduto,VLUnitario,DSUnidade,IDPromocao,IDFornecedor,DSQuantidadeProduto,VLTotal,DSImagemProduto) VALUES('"+dados.IDProduto+"','"+dados.DSCodigoProduto+"','"+dados.NMProduto+"','"+dados.VLUnitario+"','"+dados.DSUnidade+"','"+dados.IDPromocao+"','"+dados.IDFornecedor+"','"+dados.DSQuantidadeProduto+"','"+dados.VLTotal+"','"+dados.DSImagemProduto+"')")
            })
        }else{
            db.transaction(function(caixa){
                caixa.executeSql("UPDATE caixa SET DSQuantidadeProduto = DSQuantidadeProduto + '"+dados.DSQuantidadeProduto+"', VLTotal = VLTotal + '"+dados.VLUnitario+"' WHERE DSCodigoProduto = '"+dados.DSCodigoProduto+"' ")
            })
        }
        window.location.reload()
    }

    function getPagamentos(filial){
        $.ajax({
            method : "GET",
            url : "https://www.frcontroller.com.br/Configs/endpoint.php?key=TVFZMTE1OQ==&pagamentos&filial="+window.btoa(filial),
            async : true,
            crossDomain : true,
            success : function(response){
                pagamentos = jQuery.parseJSON(response)
                localStorage.setItem("pagamentos",response)
                $("select[name=pagamento]").append("<option value='' data-desconto='0' data-metodo='0' data-tipodesconto='0'>Selecione</option>")
                db.transaction(function(sql){
                    sql.executeSql("SELECT * FROM pagamentos",[],function(i,v){
                        retorno = v.rows
                        if(retorno.length == 0){
                            pagamentos.forEach((p)=>{
                                //CARREGAMENTO LOCAL
                                sql.executeSql("INSERT INTO pagamentos (IDPagamento,NMPagamento,QTDesconto,DSMetodo,QTParcelas,TPDesconto,IDFilial,NUJuros) VALUES('"+p.IDPagamento+"','"+p.NMPagamento+"','"+p.QTDesconto+"','"+p.DSMetodo+"','"+p.QTParcelas+"','"+p.TPDesconto+"','"+p.IDFilial+"','"+p.NUJuros+"')")
                                //
                            })
                        }else{
                            pagamentos.forEach((p)=>{
                                sql.executeSql("UPDATE pagamentos SET NMPagamento = '"+p.NMPagamento+"', QTDesconto = '"+p.QTDesconto+"', DSMetodo = '"+p.DSMetodo+"',QTParcelas = '"+p.QTParcelas+"', TPDesconto = '"+p.TPDesconto+"', NUJuros = '"+p.NUJuros+"' WHERE IDPagamento = '"+p.IDPagamento+"' ")
                            })
                        }
                    })
                })
                pagamentos.forEach((pr)=>{
                    $("select[name=pagamento]").append("<option value="+pr.IDPagamento+" data-desconto='"+pr.QTDesconto+"' data-metodo='"+pr.DSMetodo+"' data-parcelas='"+pr.QTParcelas+"' data-juros='"+pr.NUJuros+"' data-tipodesconto='"+pr.TPDesconto+"'>"+pr.NMPagamento+"</option>")
                })
            },
            error : function(response){
                //SEM INTERNET
                db.transaction(function(cx){
                    cx.executeSql("SELECT * FROM pagamentos",[],function(i,v){
                        retorno = v.rows
                        for(qt=0;qt<retorno.length;qt++){
                            $("select[name=pagamento]").append("<option value="+retorno[qt].IDPagamento+" data-desconto='"+retorno[qt].QTDesconto+"' data-metodo='"+retorno[qt].DSMetodo+"' data-parcelas='"+retorno[qt].QTParcelas+"' data-juros='"+retorno[qt].NUJuros+"' data-tipodesconto='"+retorno[qt].TPDesconto+"'>"+retorno[qt].NMPagamento+"</option>")
                        }
                    });
                })
                //
            }
        })
    }

    function getClientes(filial){
        $("select[name=cliente]").append("<option value='' selected data-divida='0'>Selecione</option>")
        $.ajax({
            method : "GET",
            url : "https://www.frcontroller.com.br/Configs/endpoint.php?key=TVFZMTE1OQ==&clientes&filial="+window.btoa(filial),
            async : true,
            crossDomain : true,
            success : function(response){
                clientes = jQuery.parseJSON(response)
                localStorage.setItem("clientes",response)
                    db.transaction(function(sql){
                        //ATUALIZA DO BANCO A QUANTIDADE
                        sql.executeSql("SELECT * FROM clientes",[],function(i,v){
                            retorno = v.rows
                            if(retorno.length == 0){
                                clientes.forEach((c)=>{
                                    sql.executeSql("INSERT INTO clientes (IDCliente,VLDivida,NMCliente,NMEmailCliente,NUTelefoneCliente,NUCpfCliente) VALUES('"+c.IDCliente+"','"+c.VLDivida+"','"+c.NMCliente+"','"+c.NMEmailCliente+"','"+c.NUTelefoneCliente+"','"+c.NUCpfCliente+"')")
                                })
                            }else{
                                sql.executeSql("DELETE FROM clientes WHERE IDCliente = 0 ")
                                clientes.forEach((c)=>{
                                    sql.executeSql("UPDATE clientes SET VLDivida = '"+c.VLDivida+"', IDCliente = '"+c.IDCliente+"', NMCliente = '"+c.NMCliente+"', NMEmailCliente = '"+c.NMEmailCliente+"', NUTelefoneCliente = '"+c.NUTelefoneCliente+"' WHERE NuCpfCliente = '"+c.NUCpfCliente+"'  ")
                                })
                            }
                        })
                    })
                    //INSERÇÃO DOS SELECTS
                    clientes.forEach((c)=>{
                        $("select[name=cliente]").append("<option value="+c.IDCliente+" data-divida='"+c.VLDivida+"'>"+c.NMCliente+"</option>")
                    })
                    //
            },
            error : function(response){
                //SEM INTERNET
                db.transaction(function(cx){
                    cx.executeSql("SELECT * FROM clientes",[],function(i,v){
                        retorno = v.rows
                        for(qt=0;qt<retorno.length;qt++){
                            $("select[name=cliente]").append("<option value="+retorno[qt].IDCliente+" data-divida='"+retorno[qt].VLDivida+"'>"+retorno[qt].NMCliente+"</option>")
                        }
                    });
                })
                //
            }
        })
    }

    $(".dropdown-content a").hide()
    function filterFunction(){
        var input, filter, ul, li, a, i;
        input = document.querySelector(".pesquisaProduto");
        $(".dropdown-content a").show()
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
        if($(".pesquisaProduto").val() == ""){
            $(".dropdown-content a").hide()
        }
    }

    // $(".pesquisaProduto").on("focusout",function(){
    //     $(".dropdown-content a").hide()
    // })

})
