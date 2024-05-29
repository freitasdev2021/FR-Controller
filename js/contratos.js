jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
        $(".bt_excluir_contrato,.bt_mudar_contrato").hide()
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalAlert = "#alerta";
        var modalContrato = "#cadastroContrato";
        var formContrato = "#formCadastroContrato";
        var formEmpresa = "#form_cria_empresa";
        //ENVIAR DADOS DO Pagar
        $(".bt_salvar_contrato").on("click",function(e){
            setRegistro(formContrato);
        })
        $(".bt_criar_empresa").on("click",function(e){
            setEmpresa(formEmpresa);
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
        $(".adicionarContrato").on("click",function(){
            $(modalContrato).modal("show");
        })
        //FIM DA FUNÇÃO

        if($(".getDados tr").length == 0){
            $(".pagination").hide()
        }

        $("#cadastroContrato").on("hide.bs.modal",function(){
            $(".bt_excluir_contrato").hide()
            $(".bt_mudar_contrato").hide()
            $("input[name=cpf]").prop("disabled",false)
        })

        $(".bt_excluir_contrato").on("click",function(){
            if(confirm("Deseja mesmo excluir este contrato?")){
                delContrato("#formCadastroContrato");
            }
        })

        $(".bt_mudar_contrato").on("click",function(){
            if($("input[name=status]").val() == 1){
                if(confirm("Deseja mesmo desativar este contrato?")){
                    changeStatus()
                }
            }else{
                if(confirm("Deseja mesmo ativar este contrato?")){
                    changeStatus()
                }
            }
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
                IDContrato   : $("input[name=contrato_id]",form).val(),
                contratante  : $("input[name=contratante]",form).val(),
                plano        : $("select[name=plano]",form).val(),
                email        : $("input[name=email]",form).val(),
                cpf          : $("input[name=cpf]",form).val().replace(/[^0-9]+/g,''),
                cep          : $("input[name=cep]",form).val().replace(/[^0-9]+/g,''),
                uf           : $("select[name=uf]",form).val(),
                cidade       : $("input[name=cidade]",form).val(),
                bairro       : $("input[name=bairro]",form).val(),
                rua          : $("input[name=rua]",form).val(),
                numero       : $("input[name=numero]",form).val(),
                complemento  : $("input[name=complemento]",form).val(),
                telefone     : $("input[name=telefone]",form).val().replace(/[^0-9]+/g,'')
            }
        }).done(function(resultado){
            console.log(resultado);
            $("#example2").DataTable().ajax.reload( null, false );
            $("#cadastroContrato").modal("hide")
        })
    }

    function changeStatus(form){
        $.ajax({
            method : "POST",
            url : "../Configs/changeStatus.php",
            data : {
                ID: $("input[name=contrato_id]",form).val(),
                atualStatus: $("input[name=status]",form).val(),
                setor: "Contrato"
            }
        }).done(function(resultado){
            $("#example2").DataTable().ajax.reload( null, false );
            $("#cadastroContrato").modal("hide")
        })
    }

    function delContrato(form){
        $.ajax({
            method : "POST",
            url : "../Configs/exclusaoDado.php",
            data : {
                IDContrato: $("input[name=contrato_id]",form).val(),
                setor: "Contrato"
            }
        }).done(function(resultado){
            $("#example2").DataTable().ajax.reload( null, false );
            $("#cadastroContrato").modal("hide")
        })
    }

    function setEmpresa(form){
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "../Configs/enviaDados.php",
            data   : {
                contrato     : $("input[name=IDContrato]",form).val(),
                fantasia     : $("input[name=fantasia]",form).val(),
                razao        : $("input[name=razao]",form).val(),
                cnpj         : $("input[name=cnpj]",form).val().replace(/[^0-9]+/g,'')
            }
        }).done(function(resultado){
            // console.log(resultado)
            // return false
            var json = jQuery.parseJSON(resultado);
            if(json['status']){
                window.location.href='index.php';
            }else{
                alert("Empresa já Existente!");
            }
            
        })
    }

    //FIM DA PAGINA
})


