jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalFornecedores = "#cadastroFornecedor";
        var formFornecedores = "#formCadastroFornecedores";
        //MASCARA DE TELEFONE E CEP
        $("input[name=cepFornecedor]",formFornecedores).mask("00000-000");
        $("input[name=telefoneFornecedor]",formFornecedores).mask("(00) 0 0000-0000");
        //BUSCA O CEP
        $('input[name=cepFornecedor]').on("change",function(e){
            if( $(this).val().length == 9){
                var cep = $(this).val();
                var url = "https://viacep.com.br/ws/"+cep+"/json/";
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function(dados){
                        $("input[name=ufFornecedor]").val(dados.uf).change();
                        $("input[name=cidadeFornecedor]").val(dados.localidade);
                        $("input[name=bairroFornecedor]").val(dados.bairro);
                        $("input[name=ruaFornecedor]").val(dados.logradouro);
                    }
                })
            }            
        })
        $(".bt_excluir_fornecedor").hide()
        $(modalFornecedores).on("hide.bs.modal",function(){
            $(".bt_excluir_fornecedor").hide()
        })

        $(".bt_excluir_fornecedor").on("click",function(){
            excluirFornecedor($("input[name=IDFornecedor]",formFornecedores).val())
        })

        function excluirFornecedor(ID){
            $.ajax({
                method : "POST",
                url : "./../Configs/exclusaoDado.php",
                data : {
                    setor : 'Fornecedor',
                    ID   : ID,
                    confirmacao : 0
                },
                success : function(ret){
                    retfor = jQuery.parseJSON(ret)
                    // console.log(ret)
                    // return false
                    $modal = {
                        titulo : "Excluir Caixa",
                        conteudo : retfor['mensagem'],
                        botao : {
                            
                        }
                    }
                    if(retfor['erro']){
                        $modal.botao.class = "botao btn btn-light"
                        $modal.botao.texto = "Ok"
                        $(".botoes button:last-child").hide()
                        $modal.botao.funcao = (()=>{
                            $("#alerta").modal('hide')
                        })
                    }else{
                        $(".botoes button:last-child").show()
                        $modal.botao.class = "botao btn btn-danger";
                        $modal.botao.texto = "Excluir";
                        $modal.botao.funcao = (()=>{
                            //alert("aquiii")
                            $.ajax({
                                method : "POST",
                                url : "./../Configs/exclusaoDado.php",
                                data : {
                                    setor : 'Fornecedor',
                                    ID   : ID,
                                    confirmacao : 1
                                },
                                success : function(){
                                $("#example7").DataTable().ajax.reload( null, false );
                                $(modalFornecedores).modal('hide')
                                $("#alerta").modal("hide") 
                                }
                            })
                        })
                    }
                    abreModal($modal)
                }
            })
        }

        //MODAL DE ADICIONAR EMPRESA
        $(".adicionarFornecedor").on("click",function(){
            $(modalFornecedores).modal("show");
        })
        //ENVIAR DADOS DA EMPRESA
        $(".bt_salvar_fornecedor").on("click",function(e){
            salvaFornecedor(formFornecedores)
        })
        //EXPORTA PARA XLS
        $(".xlsx").on("click",function(){
            window.location.href="./processamento/exportExcel.php?Setor=Fornecedores"
        })
        //EXPORTA PARA PDF
        $(".pdf").on("click",function(){
            window.location.href="./processamento/exportPdf.php?Setor=Fornecedores"
        })
    //FIM DA FUNÇÃO
    }

    function salvaFornecedor(form){
        var modalFornecedores = "#cadastroFornecedor";            
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDFornecedor            : $("input[name=IDFornecedor]",form).val(),
                nomeFornecedor          : $("input[name=nomeFornecedor]",form).val(),
                emailFornecedor         : $("input[name=emailFornecedor]",form).val(),
                telefoneFornecedor      : $("input[name=telefone]",form).val().replace(/[^0-9]+/g,''),
                cepFornecedor           : $("input[name=cepFornecedor]",form).val(),
                ufFornecedor            : $("input[name=ufFornecedor]",form).val(),
                cidadeFornecedor        : $("input[name=cidadeFornecedor]",form).val(),
                bairroFornecedor        : $("input[name=bairroFornecedor]",form).val(),
                ruaFornecedor           : $("input[name=ruaFornecedor]",form).val(),
                numeroFornecedor        : $("input[name=numeroFornecedor]",form).val(),
                complementoFornecedor   : $("input[name=complementoFornecedor]",form).val(),
            }
        }).done(function(resultado){
            console.log(resultado);
            // return false
            $("#example7").DataTable().ajax.reload( null, false )
            $(modalFornecedores).modal("hide")
        })
    }

    //FIM DA PAGINA
})


