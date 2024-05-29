jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
    //ENVIAR DADOS DA EMPRESA
        var modalComissoes = "#cadastroComissao";
        var formComissao = "#formCadastroComissao";
        var formCadastroComissionados = "#formCadastroComissionados";
        //MODAL DE ADICIONAR EMPRESA
        $(".adicionarComissao").on("click",function(){
            $(modalComissoes).modal("show");
        })

        $(".bt_salvar_comissionado").on("click",function(){
            salvarComissionado(formCadastroComissionados)
        })
    
        $(".bt_excluir_comissao").hide()
        $(modalComissoes).on("hide.bs.modal",function(){
            $(".bt_excluir_comissao").hide()
            $("input[name=IDComissao]").val("")
            $('select[name=tipoComissao]').parent().show()
        })
        //SALVA Comissao
        $(".bt_salvar_comissao").on("click",function(e){
            salvarComissao(formComissao)
        })
        $(".bt_excluir_comissao").on("click",function(){
            excluirComissao($("input[name=IDComissao]").val())
        })
        //EXPORTA PARA XLS
        $(".xlsx").on("click",function(){
            window.location.href="./processamento/exportExcel.php?Setor=Promocoes"
        })
        //PDF
        $(".pdf").on("click",function(){
            window.location.href="./processamento/exportPdf.php?Setor=Promocoes"
        })
        //FIM DA FUNÇÃO
    }
    //
    function salvarComissionado(form){
        var criarComissionados = [];
        $("input[name=colaborador]:checked",form).each(function(){
            criarComissionados.push($(this).val())
        })

        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                'IDComissao' : $("input[name=IDComissao]",form).val(),
                'IDColaborador' : criarComissionados
            },
            success : function(){
                $("#cadastroComissionados").modal("hide")
            }
        }).done(function(response){
            console.log(response)
        })

    }
    //
    function excluirComissao(IDComissao){
        // alert(IDPromo)
        // return false
        $modal = {
            titulo : "Excluir Comissão",
            conteudo : "Deseja excluir a comissão?",
            botao : {
                class : "botao btn btn-danger",
                texto : "Excluir",
                funcao : ()=>{
                    $.ajax({
                        method : "POST",
                        url : "./../Configs/exclusaoDado.php",
                        data : {
                            setor : 'Comissao',
                            ID   : IDComissao
                        },
                        success : function(res){
                            console.log(res)
                        $("#example16").DataTable().ajax.reload( null, false );
                        $("#alerta").modal("hide")
                        $("#cadastroComissao").modal("hide") 
                        }
                    })
                } 
            }
        }
        abreModal($modal)
    }
    //
    function salvarComissao(form){
        // alert($("input[name=nomeComissao]").val())
        // return false
        var modalComissoes = "#cadastroComissao";            
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDComissao             : $("input[name=IDComissao]",form).val(),
                tipoComissao           : $("select[name=tipoComissao]",form).val(),
                nomeComissao           : $("input[name=nomeComissao]",form).val(),
                porcentagemComissao    : $("input[name=porcentagemComissao]",form).val(),
            }
        }).done(function(resultado){
            console.log(resultado);
            // return false
            var Comissoes = $("#example16").DataTable();
            Comissoes.ajax.reload( null, false )
            $(modalComissoes).modal("hide")
        })
    }
    //FIM DA PAGINA
})


