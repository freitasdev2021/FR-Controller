jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
    //ENVIAR DADOS DA EMPRESA
        var modalPromocoes = "#cadastroPromo";
        var formPromo = "#formCadastroPromo";
        var formProdutoPromo = "#formCadastroPromoProdutos";
        //MODAL DE ADICIONAR EMPRESA
        $(".adicionarPromo").on("click",function(){
            $(modalPromocoes).modal("show");
        })

        $(".bt_vincular_promocao").on("click",function(){
            vincularPromocao(formProdutoPromo)
        })
        //COMPORTAMENTO PELO TIPO DE DESCONTO
        $("input[name=descontoPromo]").keyup(function(){
            if($("select[name=tipoPromo]").val() == "R$"){
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
        $(".bt_excluir_promocao").hide()
        $(modalPromocoes).on("hide.bs.modal",function(){
            $(".bt_excluir_promocao").hide()
        })
        //SALVA PROMOCAO
        $(".bt_salvar_promocao").on("click",function(e){
            salvarPromocao(formPromo)
        })
        $(".bt_excluir_promocao").on("click",function(){
            excluirPromo($("input[name=IDPromocao]").val())
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
    function vincularPromocao(form){
        var vincularProdutos = [];
        $("input[name=produto]:checked",form).each(function(){
            vincularProdutos.push($(this).val())
        })

        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                'IDPromo' : $("input[name=IDPromo]",form).val(),
                'IDProduto' : vincularProdutos
            },
            success : function(){
                $("#cadastroProdutoPromo").modal("hide")
            }
        }).done(function(response){
            console.log(response)
        })

    }
    //
    function excluirPromo(IDPromo){
        // alert(IDPromo)
        // return false
        $modal = {
            titulo : "Excluir Promoção",
            conteudo : "Deseja excluir a promoção?",
            botao : {
                class : "botao btn btn-danger",
                texto : "Excluir",
                funcao : ()=>{
                    $.ajax({
                        method : "POST",
                        url : "./../Configs/exclusaoDado.php",
                        data : {
                            setor : 'Promo',
                            ID   : IDPromo
                        },
                        success : function(){
                        $("#example12").DataTable().ajax.reload( null, false );
                        $("#alerta").modal("hide")
                        $("#cadastroPromo").modal("hide") 
                        }
                    })
                } 
            }
        }
        abreModal($modal)
    }
    //
    function salvarPromocao(form){
        // alert($("input[name=IDEmpresaVinculo]").val())
        // return false
        var modalPromocoes = "#cadastroPromo";            
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./../Configs/enviaDados.php",
            data   : {
                IDEmpresa      : $("input[name=IDEmpresaVinculo]").val(),
                IDPromocao     : $("input[name=IDPromocao]",form).val(),
                nomePromo      : $("input[name=nomePromo]",form).val(),
                inicioPromo    : $("input[name=inicioPromo]",form).val(),
                fimPromo       : $("input[name=fimPromo]",form).val(),
                tipoPromo      : $("select[name=tipoPromo]",form).val(),
                descontoPromo  : $("input[name=descontoPromo]",form).val()
            }
        }).done(function(resultado){
            //console.log(resultado);
            // return false
            var Promocoes = $("#example12").DataTable();
            Promocoes.ajax.reload( null, false )
            $(modalPromocoes).modal("hide")
        })
    }
    //FIM DA PAGINA
})


