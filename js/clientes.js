jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalQuiz = "#alerta";
        var modalCrediarios = "#cadastroCrediario";
        var modalDevedores = "#cadastroDevedor";
        var modalClientes = "#cadastroCliente";
        var formClientes = "#formCadastroClientes";
        var formDevedores = "#formCadastroDevedores";
        var formCrediarios = "#formCadastroCrediarios";
        var Clientes = $("#example1").DataTable();
        var Crediarios = $("#example5").DataTable();
        var Devedores = $("#example6").DataTable();
        //MASCARA DE CPF E TELEFONE
        $("input[name=cpfCliente]",modalClientes).mask("000.000.000-00");
        $("input[name=telefoneCliente]",modalClientes).mask("(00) 0 0000-0000");

        $(modalDevedores).on("show.bs.modal",function(){
            $.ajax({
                method : "POST",
                url    : "./views/view.php",
                data : {
                    Setor : "buscarDevedor",
                    ID    : ""
                } 
            }).done(function(response){
                var rs = JSON.parse(response)
                $("select[name=devedorNome] option").each(function(){
                    if($(this).text() != "Selecione"){
                        $(this).remove()
                    }
                })
                rs.forEach((dev)=>{
                    $("select[name=devedorNome]").append("<option value="+dev.IDCliente+">"+dev.NMCliente+"</option>")
                })
                if($("input[name=IDDevedor]").val() != ""){
                    $("select[name=devedorNome]").val($("select[name=devedorNome]").attr("data-original")).change()
                }
            })
        })

        $(modalCrediarios).on("show.bs.modal",function(){
            $.ajax({
                method : "POST",
                url    : "./views/view.php",
                data : {
                    Setor : "buscarCrediario",
                    ID    : ""
                } 
            }).done(function(response){
                var rs = JSON.parse(response)
                $("select[name=nomeCrediario] option").each(function(){
                    if($(this).text() != "Selecione"){
                        $(this).remove()
                    }
                })
                rs.forEach((dev)=>{
                    $("select[name=nomeCrediario]").append("<option value="+dev.IDCliente+">"+dev.NMCliente+"</option>")
                })
                if($("input[name=IDCrediario]").val() != ""){
                    $("select[name=nomeCrediario]").val($("select[name=nomeCrediario]").attr("data-original")).change()
                }
            })
        })

        $(".bt_excluir_cliente").hide()
        $(modalClientes).on("hide.bs.modal",function(){
            $('input[name=cpfCliente]').parent().show()
            $(".bt_excluir_cliente").hide()
        })
        $(".bt_excluir_crediario").hide()
        $(modalCrediarios).on("hide.bs.modal",function(){
            $('select[name=nomeCrediario]').parent().show()
            $("#nomeCrediario").hide()
            $("#nomeCrediario").text("")
            $(".bt_excluir_crediario").hide()
        })
        $(".bt_excluir_devedor").hide()
        $(modalDevedores).on("hide.bs.modal",function(){
            $('select[name=devedorNome]').parent().show()
            $("#nomeDevedor").hide()
            $("#nomeDevedor").text("")
            $(".bt_excluir_devedor").hide()
        })

        //MODAL DE ADICIONAR CLIENTE
        $(".adicionarCliente").on("click",function(){
            $(modalClientes).modal("show");
        })
        //MODAL DE ADICIONAR DEVEDOR
        $(".adicionarDevedor").on("click",function(){
            $(modalDevedores).modal("show");
        })
        //ADICIONAR CREDIARIO
        $(".adicionarCrediario").on("click",function(){
            $(modalCrediarios).modal("show");
        })
        //ENVIAR DADOS DO CLIENTE
        $(".bt_salvar_cliente").on("click",function(e){
            salvarCliente(formClientes);
        })
        //ENVIAR DADOS DO DEVEDOR
        $(".bt_salvar_devedor").on("click",function(e){
            salvarDevedor(formDevedores)
        })
        //ENVIAR DADOS DO CREDIARIO
        $(".bt_salvar_crediario").on("click",function(e){
            salvarCrediario(formCrediarios)
        })
        //EXCLUIR CREDIARIO
        $(".bt_excluir_crediario").on("click",function(){
            excluirCrediario($("input[name=IDCrediario]").val())
        })
        //EXCLUIR CLIENTE
        $(".bt_excluir_cliente").on("click",function(){
            excluirCliente($("input[name=IDCliente]").val(),0)
        })
        //EXCLUIR DEVEDOR
        $(".bt_excluir_devedor").on("click",function(){
            excluirDevedor($("input[name=IDDevedor]").val())
        })
        //EXPORTA PARA XLS
        $(".xlsx").on("click",function(){
            window.location.href="./processamento/exportExcel.php?Setor=Clientes"
        })
        //Devedor
        $(".xlsxDevedor").on("click",function(){
            window.location.href="./processamento/exportExcel.php?Setor=Devedor"
        })
        //Crediario
        $(".xlsxCrediario").on("click",function(){
            window.location.href="./processamento/exportExcel.php?Setor=Crediario"
        })
        ///EXPORTA PARA PDF
        $(".pdf").on("click",function(){
            window.location.href="./processamento/exportPdf.php?Setor=Clientes"
        })
        //Devedor
        $(".pdfDevedor").on("click",function(){
            window.location.href="./processamento/exportPdf.php?Setor=Devedor"
        })
        //Crediario
        $(".pdfCrediario").on("click",function(){
            window.location.href="./processamento/exportPdf.php?Setor=Crediario"
        })
        //FIM DA FUNÇÃO
    }

    function salvarCliente(form){
        //INICIA VALIDACAO DOS CAMPOS
        var modalClientes = "#cadastroCliente";
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDCliente            : $("input[name=IDCliente]",form).val(),
                nomeCliente          : $("input[name=nomeCliente]",form).val(),
                emailCliente         : $("input[name=emailCliente]",form).val(),
                telefoneCliente      : $("input[name=telefoneCliente]",form).val().replace(/[^0-9]+/g,''),
                cpfCliente           : $("input[name=cpfCliente]",form).val().replace(/[^0-9]+/g,'')
            }
        }).done(function(resultado){
            console.log(resultado);
            // return false
            $("#example1").DataTable().ajax.reload( null, false )
            $(modalClientes).modal("hide")
            abrirPagina("views/clientes.php")
        })
    }

    function salvarDevedor(form){
        var modalDevedores = "#cadastroDevedor";
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos(form))return false
        if($("input[name=IDDevedor]").val() != ""){
            if($("select[name=devedorNome]").val() != $("select[name=devedorNome]").attr("data-original") ){
                devedor = $("select[name=devedorNome]",form).val()
            }else{
                devedor = $("select[name=devedorNome]",form).attr("data-original")
            }
        }else{
            devedor = $("select[name=devedorNome]",form).val()
        }
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDDevedor        : $("input[name=IDDevedor]",form).val(),
                nomeDevedor      : devedor,
                dividaDevedor    : trataValor($("input[name=devedorDivida]",form).val(),1)
            }
        }).done(function(resultado){
            console.log(resultado);
            // return false
            $("#example6").DataTable().ajax.reload( null, false )
            $(modalDevedores).modal("hide")
        })
    }

    function excluirCliente(IDCliente,confirmacao){
        // alert(IDFornecedor)
        // return false
        $.ajax({
            method : "POST",
            url : "./../Configs/exclusaoDado.php",
            data : {
                setor       : 'Cliente',
                ID          : IDCliente,
                confirmacao : confirmacao
            }
        }).done(function(exclusao){
            // console.log(exclusao)
            // return false
            e = jQuery.parseJSON(exclusao)
            if(e['podeExcluir']){
                $modal = {
                    titulo : "Excluir Cliente",
                    conteudo : "Deseja excluir o Cliente?",
                    botao : {
                        class : "botao btn btn-danger",
                        texto : "Excluir",
                        funcao : ()=>{
                           excluirCliente(IDCliente,1)
                           $("#example1").DataTable().ajax.reload( null, false );
                           $("#alerta").modal("hide") 
                           $("#cadastroCliente").modal("hide")
                        } 
                    }
                }
                abreModal($modal)
            }else{
                aviso(e['msg'])
            }
        })
    }
    
    function excluirCrediario(IDCrediario){
        // alert(IDCliente)
        // return false
        $modal = {
            titulo : "Excluir Crediario",
            conteudo : "Deseja excluir o crediario?",
            botao : {
                class : "botao btn btn-danger",
                texto : "Excluir",
                funcao : ()=>{
                    $.ajax({
                        method : "POST",
                        url : "./../Configs/exclusaoDado.php",
                        data : {
                            setor : 'Crediario',
                            ID   : IDCrediario
                        },
                        success : function(){
                        $("#example5").DataTable().ajax.reload( null, false );
                        $("#alerta").modal("hide")
                        $("#cadastroCrediario").modal("hide")
                        }
                    })
                } 
            }
        }
        abreModal($modal)
    }
    
    function excluirDevedor(IDDevedor){
        // alert(IDCliente)
        // return false
        $modal = {
            titulo : "Excluir Devedor",
            conteudo : "Deseja excluir o devedor?",
            botao : {
                class : "botao btn btn-danger",
                texto : "Excluir",
                funcao : ()=>{
                    $.ajax({
                        method : "POST",
                        url : "./../Configs/exclusaoDado.php",
                        data : {
                            setor : 'Devedor',
                            ID   : IDDevedor
                        },
                        success : function(exclusai){
                        console.log(exclusai)
                        $("#example6").DataTable().ajax.reload( null, false );
                        $("#alerta").modal("hide")
                        $("#cadastroDevedor").modal("hide") 
                        }
                    })
                } 
            }
        }
        abreModal($modal)
    }

    function salvarCrediario(form){
        var modalCrediarios = "#cadastroCrediario";
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos("#formCadastroCrediarios"))return false
        if($("input[name=IDCrediario]").val() != ""){
            if($("select[name=nomeCrediario]").val() != $("select[name=nomeCrediario]").attr("data-original") ){
                crediario = $("select[name=nomeCrediario]",form).val()
            }else{
                crediario = $("select[name=nomeCrediario]",form).attr("data-original")
            }
        }else{
            crediario = $("select[name=nomeCrediario]",form).val()
        }
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDCrediario      : $("input[name=IDCrediario]",form).val(),
                nomeCrediario    : crediario,
                creditoCrediario : trataValor($("input[name=creditoCrediario]",form).val(),1),
                creditoAte       : $("input[name=creditoAte]",form).val()
            }
        }).done(function(resultado){
            //console.log(resultado);
            // return false
            $("#example5").DataTable().ajax.reload( null, false )
            $(modalCrediarios).modal("hide")
        })
    }

    //FIM DA PAGINA
})


