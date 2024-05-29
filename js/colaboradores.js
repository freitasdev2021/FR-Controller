jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
        $(".bt_excluir_colaborador").hide()
        $(".bt_mudar_colaborador").hide()
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalAlert = "#alerta";
        var modalColaborador = "#cadastroColaborador";
        var formColaborador = "#formCadastroColaborador";
        //ENVIAR DADOS DO Pagar
        $(".bt_salvar_colaborador").on("click",function(e){
            setRegistro(formColaborador);
        })

        $(modalColaborador).on("hide.bs.modal",function(){
            $(".bt_excluir_colaborador").hide()
            $(".bt_mudar_colaborador").hide()
        })
        //CEP
        $('input[name=cep]').on("change",function(e){
            if( $(this).val().length == 9){
                    var cep = $(this).val();
                    var url = "https://viacep.com.br/ws/"+cep+"/json/";
                    $.ajax({
                        url: url,
                        type: 'get',
                        dataType: 'json',
                        success: function(dados){
                            $("select[name=uf]").val(dados.uf).change();
                            $("input[name=cidade]").val(dados.localidade);
                            $("input[name=bairro]").val(dados.bairro);
                            $("input[name=rua]").val(dados.logradouro);
                        }
                    })
                }            
            })

            //ADICIONAR CONTA PAGAR
            $(".adicionarColaborador").on("click",function(){
                $(modalColaborador).modal("show");
            })
            //FIM DA FUNÇÃO

            if($(".getDados tr").length == 0){
                $(".pagination").hide()
            };

            $(".bt_excluir_colaborador").on("click",function(){
                if(confirm("Deseja mesmo excluir este colaborador? todos os usuários dele tambem serão excluidos")){
                    delColaborador("#formCadastroColaborador");
                }
            })

            $(".bt_mudar_colaborador").on("click",function(){
                if($("input[name=status]").val() == 1){
                    if(confirm("Deseja mesmo desativar este colaborador? ele perderá acesso em todos os usuários")){
                        changeStatus()
                    }
                }else{
                    if(confirm("Deseja mesmo desativar este colaborador? ele voltará a ter acesso em todos os usuários")){
                        changeStatus()
                    }
                }
            })

            $("#cadastroColaborador").on("show.bs.modal",function(){
                $("#cadastroColaborador").find("input[name=admissao]").parent().show()
                $("#cadastroColaborador").find("input[name=cpf]").parent().show()
            })

        }

        function changeStatus(form){
            //alert($("input[name=usuario_id]",form).val())
            idCol = $("input[name=colaborador_id]",form).val()
            stCol = $("input[name=status]",form).val()
    
            // alert(mtd)
            // console.log("Colunas: "+idCol)
            // console.log("Situações: "+stCol)
            // return false
            $.ajax({
                method : "POST",
                url : "../Configs/changeStatus.php",
                data : {
                    ID: idCol,
                    atualStatus: stCol,
                    setor: "Colaborador"
                }
            }).done(function(resultado){
                $("#example4").DataTable().ajax.reload( null, false );
                $("#cadastroColaborador").modal("hide")
            })
        }

        function delColaborador(form){
            $.ajax({
                method : "POST",
                url : "../Configs/exclusaoDado.php",
                data : {
                    IDColaborador: $("input[name=colaborador_id]",form).val(),
                    setor: "Colaborador"
                }
            }).done(function(resultado){
                $("#example4").DataTable().ajax.reload( null, false );
                $("#cadastroColaborador").modal("hide")
            })
        }

        function setRegistro(form){
            //INICIA VALIDACAO DOS CAMPOS
            if(!validaCampos(form))return false
            //TERMINA A VALIDACAO
            $.ajax({
                method : "POST",
                url    : "../Configs/enviaDados.php",
                data   : {
                    IDColaborador : $("input[name=colaborador_id]",form).val(),
                    nome          : $("input[name=nome]",form).val(),
                    email         : $("input[name=email]",form).val(),
                    cargo         : $("input[name=cargo]",form).val(),
                    cpf           : $("input[name=cpf]",form).val().replace(/[^0-9]+/g,''),
                    admissao      : $("input[name=admissao]",form).val(),
                    salario       : trataValor($("input[name=salario]",form).val(),1),
                    filial        : $("select[name=filial]",form).val()
                }
            }).done(function(resultado){
                console.log(resultado)
                $("#example4").DataTable().ajax.reload( null, false );
                $("#cadastroColaborador").modal("hide")
            })
        }
        
})
//FIM DA PAGINA


