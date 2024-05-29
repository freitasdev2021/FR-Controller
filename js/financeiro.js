jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalQuiz = "#alerta";
        var modalPagar = "#cadastroDespesa";
        var formPagar = "#formCadastroDespesa";
        //ENVIAR DADOS DO Pagar
        $(".bt_salvar_contapagar").on("click",function(e){
            salvarConta(formPagar);
        })
        //ADICIONAR CONTA PAGAR
        $(".adicionarContaPagar").on("click",function(){
            $(modalPagar).modal("show");
        })
        //EXPORTA PARA XLS
        //Pagar
        $(".xlsxPagar").on("click",function(){
            window.location.href="./processamento/exportExcel.php?Setor=Pagar"
        })
        $(".bt_excluir_contapagar").on("click",function(){
            excluirConta($("input[name=IDContaPagar]").val())
        })
        //
        $(".bt_excluir_contapagar").hide()
        $(modalPagar).on("hide.bs.modal",function(){
            $(".bt_excluir_contapagar").hide()
        })
        //Pagar
        $(".pdfPagar").on("click",function(){
            window.location.href="./processamento/exportPdf.php?Setor=Pagar"
        })
        //FIM DA FUNÇÃO
    }

    function excluirConta(IDConta){
        // alert(IDCliente)
        // return false
        $modal = {
            titulo : "Excluir Despesa",
            conteudo : "Deseja excluir a despesa?",
            botao : {
                class : "botao btn btn-danger",
                texto : "Excluir",
                funcao : ()=>{
                    $.ajax({
                        method : "POST",
                        url : "./../Configs/exclusaoDado.php",
                        data : {
                            setor : 'ContaPagar',
                            ID   : IDConta
                        },
                        success : function(){
                        $("#example3").DataTable().ajax.reload( null, false );
                        $("#alerta").modal("hide")
                        $("#cadastroDespesa").modal("hide") 
                        }
                    })
                } 
            }
        }
        abreModal($modal)
    }

    function salvarConta(form){
        var modalPagar = "#cadastroDespesa";
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDContaPagar             : $("input[name=IDContaPagar]",form).val(),
                nomeContaPagar           : $("input[name=nomeContaPagar]",form).val(),
                valorContaPagar          : trataValor($("input[name=valorContaPagar]",form).val(),1),
                vencimentoContaPagar     : $("input[name=vencimentoContaPagar]",form).val(),
                justificativaContaPagar  : $("textarea[name=justificativaContaPagar]",form).val(),
            }
        }).done(function(resultado){
            //console.log(resultado);
            // return false
            $("#example3").DataTable().ajax.reload( null, false )
            $(modalPagar).modal("hide")
        })
    }

    //FIM DA PAGINA
})


