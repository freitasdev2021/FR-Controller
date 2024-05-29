jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
       $(".bt_mudar_usuario,.bt_excluir_usuario").hide()
       //alert($("input[name=permissao]").val())
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalAlert = "#alerta";
        var modalUsuarios = "#cadastroUsuario";
        var modalUsuarioscli = "#cadastroUsuariocli";
        var formUsuario = "#formCadastroUsuario";
        var formUsuariocli = "#formCadastroUsuariocli";
        //ENVIAR DADOS DO Pagar
        $(".bt_salvar_usuario").on("click",function(e){
            setRegistro(formUsuario);
        })
        //
        $("select[name=colaborador]",formUsuario).on("change",function(){
            $("input[name=email]",formUsuario).val($(this).find('option:selected').attr("data-email"))
        })
        //BREADCUMBS
        $(".adicionarUsuario").on("click",function(){
            $(".ctrato").show()
            if($("#cadastroUsuario").length == 1){
                $(modalUsuarios).modal("show");
            }else{
                $(modalUsuarioscli).modal("show");
            }
        })
        //FIM DA FUNÇÃO

        if($(".getDados tr").length == 0){
            $(".pagination").hide()
        };

        $("#cadastroUsuario").on("hide.bs.modal",function(){
            $(".bt_excluir_usuario").hide()
            $(".bt_mudar_usuario").hide()
            $(".permissoes,.permTitle").show()
            $("#cadastroUsuario").find("select[name=nivel]").parent().show()
        })

        $("#cadastroUsuariocli").on("hide.bs.modal",function(){
            $("#cadastroUsuariocli").find("select[name=colaborador]").attr("disabled",false)
            $("#cadastroUsuariocli").find("select[name=colaborador]").removeClass("norequire")
        })

        $(".bt_excluir_usuario").on("click",function(){
            if(confirm("Deseja mesmo excluir este usuário?")){
                delUsuario("#formCadastroUsuario");
            }
        })

        $(".bt_mudar_usuario").on("click",function(){
            if($("input[name=status]").val() == 1){
                if(confirm("Deseja mesmo desativar este usuário?")){
                    changeStatus()
                }
            }else{
                if(confirm("Deseja mesmo ativar este usuário?")){
                    changeStatus()
                }
            }
        })

        $(".ctrato").hide()
        $("select[name=nivel]").on("change",function(){
            if($(this).val() == "3"){
                $(".ctrato").show()
                $(".permissoes,.permTitle").hide()
            }else if($(this).val() == "1.5"){
                $(".ctrato").hide()
                $(".permissoes,.permTitle").show()
            }else if($(this).val() == "2"){
                $(".ctrato").hide()
                $(".permissoes,.permTitle").hide()
            }
        })

    }

    function changeStatus(form){
        //alert($("input[name=usuario_id]",form).val())
        $.ajax({
            method : "POST",
            url : "../Configs/changeStatus.php",
            data : {
                ID: $("input[name=usuario_id]",form).val(),
                atualStatus: $("input[name=status]",form).val(),
                setor: "Usuario"
            }
        }).done(function(resultado){
            console.log(resultado);
            $("#example13").DataTable().ajax.reload( null, false );
            $("#cadastroUsuario").modal("hide")
        })
    }

    function delUsuario(form){
        $.ajax({
            method : "POST",
            url : "../Configs/exclusaoDado.php",
            data : {
                IDUsuario: $("input[name=usuario_id]",form).val(),
                setor: "Usuario"
            }
        }).done(function(resultado){
            $("#example13").DataTable().ajax.reload( null, false );
            $("#example8").DataTable().ajax.reload( null, false );
            console.log(resultado);
            $("#cadastroUsuario").modal("hide")
        })
    }

    $("#cadastroUsuario").on("show.bs.modal",function(){
        IDUsuario = $(this).find("input[name=usuario_id]").val()
        //alert(IDUsuario)
    })

    function setRegistro(form){
        //INICIA VALIDACAO DOS CAMPOS
        permissoes = []
        switch($("select[name=nivel],input[name=nivel]",form).val()){
            case "1.5":
                permUsuario = []
                permContratos = []
                $("input[name=USU]:checked").each(function(){
                    permUsuario.push($(this).val())
                })
                $("input[name=CON]:checked").each(function(){
                    permContratos.push($(this).val())
                })
                if(permContratos.length == 0 && permUsuario.length == 0){
                    $(".permTitle").addClass("text-danger")
                    alert("Marque pelo menos uma permissão")
                }else{
                    permissoes = {
                        "1.5" : {
                            "CON" : permContratos,
                            "USU" : permUsuario
                        }
                    }
                    //
                    env = {
                        IDUsuario    : $("input[name=usuario_id]",form).val(),
                        nivel        : $("select[name=nivel]",form).val(),
                        nome         : $("input[name=nome]",form).val(),
                        email        : $("input[name=email]",form).val(),
                        senha        : $("input[name=senha]",form).val(),
                        permissoes   : JSON.stringify(permissoes)
                    }
                }
            break;
            case "2":
                env = {
                    IDUsuario    : $("input[name=usuario_id]",form).val(),
                    nivel        : $("select[name=nivel]",form).val(),
                    nome         : $("input[name=nome]",form).val(),
                    email        : $("input[name=email]",form).val(),
                    senha        : $("input[name=senha]",form).val()
                }
            break;
            case "2.5":
                permUsuario = []
                permContratos = []
                $("input[name=USU]:checked").each(function(){
                    permUsuario.push($(this).val())
                })
                $("input[name=CON]:checked").each(function(){
                    permContratos.push($(this).val())
                })
                if(permContratos.length == 0 && permUsuario.length == 0){
                    $(".permTitle").addClass("text-danger")
                    alert("Marque pelo menos uma permissão")
                }else{
                    permissoes = {
                        "2.5" : {
                            "CON" : permContratos,
                            "USU" : permUsuario
                        }
                    }
                    //
                    env = {
                        IDUsuario    : $("input[name=usuario_id]",form).val(),
                        nivel        : $("select[name=nivel]",form).val(),
                        nome         : $("input[name=nome]",form).val(),
                        email        : $("input[name=email]",form).val(),
                        senha        : $("input[name=senha]",form).val(),
                        permissoes   : JSON.stringify(permissoes)
                    }
                }
            break;
            case "3":
                env = {
                    IDUsuario    : $("input[name=usuario_id]",form).val(),
                    nivel        : $("select[name=nivel]",form).val(),
                    nome         : $("input[name=nome]",form).val(),
                    email        : $("input[name=email]",form).val(),
                    senha        : $("input[name=senha]",form).val(),
                    contrato     : $("select[name=contrato]",form).val()
                }
            break;
            case "3.5":
                permProdutos = [];
                permServicos = [];
                permComissoes = [];
                permRelatorios = [];
                permPdv = [];
                permFornecedores = [];
                permPagamentos = [];
                permPromocoes = [];
                permClientes = [];
                permFinanceiro = [];
                permVendas = [];
                $("input[name=PRO]:checked").each(function(){
                    permProdutos.push($(this).val())
                })
                $("input[name=VEN]:checked").each(function(){
                    permVendas.push($(this).val())
                })
                $("input[name=SER]:checked").each(function(){
                    permServicos.push($(this).val())
                })
                $("input[name=COM]:checked").each(function(){
                    permComissoes.push($(this).val())
                })
                $("input[name=REL]:checked").each(function(){
                    permRelatorios.push($(this).val())
                })
                $("input[name=PDV]:checked").each(function(){
                    permPdv.push($(this).val())
                })
                $("input[name=FOR]:checked").each(function(){
                    permFornecedores.push($(this).val())
                })
                $("input[name=PAG]:checked").each(function(){
                    permPagamentos.push($(this).val())
                })
                $("input[name=CLI]:checked").each(function(){
                    permClientes.push($(this).val())
                })
                $("input[name=FIN]:checked").each(function(){
                    permFinanceiro.push($(this).val())
                })
                if(
                    permProdutos.length ==0 &&
                    permServicos.length ==0 &&
                    permComissoes.length ==0 &&
                    permRelatorios.length ==0 &&
                    permPdv.length ==0 &&
                    permFornecedores.length ==0 &&
                    permPagamentos.length ==0 &&
                    permPromocoes.length ==0 &&
                    permClientes.length ==0 &&
                    permFinanceiro.length == 0 &&
                    permVendas.length == 0
                ){
                    $(".permTitle").addClass("text-danger")
                    alert("Marque pelo menos uma permissão")
                }else{
                    permissoes = {
                        "3.5" : {
                            "PRO" : permProdutos,
                            "SER" : permServicos,
                            "COM" : permComissoes,
                            "REL" : permRelatorios,
                            "PDV" : permPdv,
                            "FOR" : permFornecedores,
                            "PAG" : permPagamentos,
                            "PRM" : permPromocoes,
                            "CLI" : permClientes,
                            "FIN" : permFinanceiro,
                            "VEN" : permVendas
                        }
                    }
                    //
                    env = {
                        IDUsuario    : $("input[name=usuario_id]",form).val(),
                        nivel        : $("input[name=nivel]",form).val(),
                        nome         : $("input[name=nome]",form).val(),
                        email        : $("input[name=email]",form).val(),
                        senha        : $("input[name=senha]",form).val(),
                        contrato     : $("input[name=contrato]",form).val(),
                        colaborador  : $("select[name=colaborador]",form).val(),
                        permissoes   : JSON.stringify(permissoes)
                    }
                }
            break;
        }
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "../Configs/enviaDados.php",
            data   : env
        }).done(function(resultado){
            console.log(resultado)
            $("#example13").DataTable().ajax.reload( null, false );
            $("#example8").DataTable().ajax.reload( null, false );
            $("#cadastroUsuariocli").modal("hide")
            $("#cadastroUsuario").modal("hide")
        })
    }

    //FIM DA PAGINA
})


