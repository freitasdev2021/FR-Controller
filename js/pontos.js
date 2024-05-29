jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalPontos = "#cadastroPonto";
        var formPonto = "#formCadastroPonto";
        //MODAL DE ADICIONAR EMPRESA
        $(".adicionarPonto").on("click",function(){
            $("#cadastroPonto").modal("show");
            $(".bt_excluir_ponto").hide()
        })
        //ENVIAR DADOS DA EMPRESA
        $(".bt_salvar_ponto").on("click",function(e){
            salvarPonto(formPonto)
        })
        //FIM DA FUNÇÃO
        $(".bt_excluir_ponto").on("click",function(){
            $modal = {
                titulo : "Excluir Caixa",
                conteudo : "Deseja excluir o caixa?",
                botao : {
                    class : "botao btn btn-danger",
                    texto : "Excluir",
                    funcao : ()=>{
                        $.ajax({
                            method : "POST",
                            url : "./../Configs/exclusaoDado.php",
                            data : {
                                setor : 'Ponto',
                                ID   : $("input[name=IDPonto]",formPonto).val()
                            },
                            success : function(){
                            $("#example15").DataTable().ajax.reload( null, false );
                            $(modalPontos).modal('hide')
                            $("#alerta").modal("hide") 
                            }
                        })
                    } 
                }
            }
            abreModal($modal)
        })
    }
    //
    function salvarPonto(form){
        var modalPontos = "#cadastroPonto";            
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDCaixa : $("input[name=IDPonto]",form).val(),
                nomePdv    : $("input[name=nomePonto]",form).val(),
                senhaPdv   : $("input[name=senhaPonto]",form).val()
            }
        }).done(function(resultado){
            console.log(resultado);
            // return false
            $("#example15").DataTable().ajax.reload( null, false )
            $(modalPontos).modal("hide")
        })
    }
    //FIM DA PAGINA
})


