jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE TRATA O MODAL

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var atualSelect = $('select[name=metodoMetodo] option:selected').val()
        var modalPagamentos = "#cadastroPagamento";
        var formPagamentos = "#formCadastroPagamento";
        //MODAL DE ADICIONAR EMPRESA
        $(".adicionarMetodo").on("click",function(){
            $("#cadastroPagamento input[name=IDPagamento]").val("")
            $(modalPagamentos).modal("show");
        })
        //TRATAMENTOS A DEPENDER DO TIPO DE DESCONTO
        $("input[name=descontoMetodo]").keyup(function(){
            if($("select[name=tipoMetodo]").val() == 2){
                $(this).maskMoney({
                    allowNegative: false,
                    thousands:'.',
                    decimal:',',
                    affixesStay: true
                  });
            }else{
                $(this).maskMoney("destroy")
            }
        })
        //
        $(".bt_excluir_pagamento").hide()
        $(modalPagamentos).on("hide.bs.modal",function(){
            $(".bt_excluir_pagamento").hide()
        })
        //
        $(".bt_excluir_pagamento").on("click",function(){
            excluirPagamento($("input[name=IDPagamento]").val())
        })
        //COMPORTAMENTOS A DEPENDER DO TIPO DE PAGAMENTO
        switch(atualSelect){
            case '1':
            $("input[name=parcelasMetodo]").val("0").attr("disabled",true);
            $("input[name=jurosMetodo]").attr("disabled",true)
            $("input[name=descontoMetodo]").attr("disabled",false);
            $("select[name=tipoMetodo]").attr("disabled",false);
            break;
            case '2':
            $("input[name=parcelasMetodo]").attr("disabled",false);
            $("input[name=jurosMetodo]").attr("disabled",false);
            $("input[name=descontoMetodo]").val("").attr("disabled",true);
            $("select[name=tipoMetodo]").val("0").change().attr("disabled",true);
            break;
            case '3':
            $("input[name=parcelasMetodo]").val("0").attr("disabled",true);
            $("input[name=jurosMetodo]").attr("disabled",false)
            $("input[name=descontoMetodo]").val("0").attr("disabled",true);
            $("select[name=tipoMetodo]").attr("disabled",true);
            break;
            case '4':
            $("input[name=parcelasMetodo]").val("0").attr("disabled",true);
            $("input[name=jurosMetodo]").attr("disabled",true)
            $("input[name=descontoMetodo]").attr("disabled",false);
            $("select[name=tipoMetodo]").attr("disabled",false);
            break;
            case '5':
            $("input[name=parcelasMetodo]").val("0").attr("disabled",true);
            $("input[name=jurosMetodo]").attr("disabled",true)
            $("input[name=descontoMetodo]").attr("disabled",false);
            $("select[name=tipoMetodo]").attr("disabled",false);
            break;
        }

        $("#cadastroPagamento select[name=metodoMetodo]").on("change",function(){
            var metodo = $(this).val()
            switch(metodo){
                case '1':
                $("input[name=parcelasMetodo]").val("0").attr("disabled",true);
                $("input[name=jurosMetodo]").attr("disabled",true)
                $("input[name=jurosMetodo]").attr("disabled",true)
                $("input[name=descontoMetodo]").val("0").attr("disabled",false);
                $("select[name=tipoMetodo]").attr("disabled",false);
                break;
                case '2':
                $("input[name=parcelasMetodo]").attr("disabled",false);
                $("input[name=jurosMetodo]").attr("disabled",false)
                $("input[name=descontoMetodo]").val("0").attr("disabled",true);
                $("select[name=tipoMetodo]").val("0").change().attr("disabled",true);
                break;
                case '3':
                $("input[name=parcelasMetodo]").val("0").attr("disabled",true);
                $("input[name=jurosMetodo]").attr("disabled",false)
                $("input[name=descontoMetodo]").val("0").attr("disabled",true);
                $("select[name=tipoMetodo]").attr("disabled",true);
                break;
                case '4':
                $("input[name=parcelasMetodo]").val("0").attr("disabled",true);
                $("input[name=jurosMetodo]").attr("disabled",true)
                $("input[name=descontoMetodo]").val('0').attr("disabled",false);
                $("select[name=tipoMetodo]").attr("disabled",false);
                break;
                case '5':
                $("input[name=parcelasMetodo]").val("0").attr("disabled",true);
                $("input[name=jurosMetodo]").attr("disabled",true)
                $("input[name=descontoMetodo]").val("0").attr("disabled",false);
                $("select[name=tipoMetodo]").attr("disabled",false);
                break;
            }
        })
            //ENVIAR DADOS DA EMPRESA
            $(".bt_salvar_pagamento").on("click",function(e){
                salvarPagamento(formPagamentos)
            })
        
            //EXPORTA PARA XLS
            $(".xlsx").on("click",function(){
                window.location.href="./processamento/exportExcel.php?Setor=Pagamentos"
            })

            $(".pdf").on("click",function(){
                window.location.href="./processamento/exportPdf.php?Setor=Pagamentos"
            })
            //FIM DA FUNÇÃO
    }
    //
    function excluirPagamento(IDPagamento){
        // alert(IDPagamento)
        // return false
        $modal = {
            titulo : "Excluir Pagamento",
            conteudo : "Deseja excluir o pagamento?",
            botao : {
                class : "botao btn btn-danger",
                texto : "Excluir",
                funcao : ()=>{
                    $.ajax({
                        method : "POST",
                        url : "./../Configs/exclusaoDado.php",
                        data : {
                            setor : 'Pagamento',
                            ID   : IDPagamento
                        },
                        success : function(r){
                            console.log()
                        $("#example9").DataTable().ajax.reload( null, false );
                        $("#alerta").modal("hide")
                        $("#cadastroPagamento").modal("hide") 
                        }
                    })
                } 
            }
        }
        abreModal($modal)
    }
    //
    function salvarPagamento(form){
        var modalPagamentos = "#cadastroPagamento";
        var IDEmpresa = $("input[name=IDEmpresaVinculo]").val()
        var IDPagamento = $("input[name=IDPagamento]",form).val();
        var nomeMetodo = $("input[name=nomeMetodo]",form).val();
        var jurosMetodo = $("input[name=jurosMetodo]",form).val();
        if($("input[name=descontoMetodo]",form).val() == ""){
            var descontoMetodo = 0
        }else{
            var descontoMetodo = $("input[name=descontoMetodo]",form).val()
        }
        var tipoMetodo = $("select[name=tipoMetodo]",form).val()
        var metodoMetodo = $("select[name=metodoMetodo]",form).val()
        var parcelasMetodo = $("input[name=parcelasMetodo]",form).val();
        
        //INICIA VALIDACAO DOS CAMPOS
        if(nomeMetodo.length < 5 ){
            $(".nomeMetodo",form).find(".error-input").show();
            $(".nomeMetodo",form).find('input').css("border-color","red");
            $(".nomeMetodo",form).find('label').addClass("text-danger");
        }else{
            $(".nomeMetodo",form).find(".error-input").hide();
            $(".nomeMetodo",form).find('input').css("border-color","");
            $(".nomeMetodo",form).find('label').removeClass("text-danger");
        }

        if(parcelasMetodo.length == 0 ){
            $(".parcelasMetodo",form).find(".error-input").show();
            $(".parcelasMetodo",form).find('input').css("border-color","red");
            $(".parcelasMetodo",modalPagamentos).find('label').addClass("text-danger");
        }else{
            $(".parcelasMetodo",form).find(".error-input").hide();
            $(".parcelasMetodo",form).find('input').css("border-color","");
            $(".parcelasMetodo",form).find('label').removeClass("text-danger");
        }

        //VERIFICA OS CAMPOS
        if(
          nomeMetodo.length < 5 ||
          parcelasMetodo.length == 0
          ){
            return false
        }
        // return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDPagamento       : IDPagamento,
                nomeMetodo        : nomeMetodo,
                descontoMetodo    : descontoMetodo,
                tipoMetodo        : tipoMetodo,
                metodoMetodo      : metodoMetodo,
                parcelasMetodo    : parcelasMetodo,
                jurosMetodo       : jurosMetodo
            }
        }).done(function(resultado){
            console.log(resultado);
            // return false
            $("#example9").DataTable().ajax.reload( null, false )
            $(modalPagamentos).modal("hide")
        })
    }

    //FIM DA PAGINA
})


