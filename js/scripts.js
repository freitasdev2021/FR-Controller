

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

$("body").css("background-image","url('../img/fundoBranco.jpg')");
$(".loader").hide();
$(".navegacao a").css("background","#234D9D");

$(".navegacao a").removeClass("bg-white text-dark");

$(".navegacao a").css("color","white");

$(".navegacao a").on("mouseover",function(){
    $(this).css("background","white");
    $(this).css("color","black");
})

$(".navegacao a").on("mouseout",function(){
    $(this).css("background","#234D9D");
    $(this).css("color","white");
})

$(".navegacao a").on("click",function(){
    var pagina = "views/"+$(this).attr("data-value");
    $(this).addClass('bg-white text-dark').siblings().removeClass('bg-white text-dark');
    //alert(pagina);
    abrirPagina(pagina);
    
})

$('input[type=name]').bind('input',function(){
    str = $(this).val().replace(/[^A-Za-z\u00C0-\u00FF\-\/\s]+/g,'');
    str = str.replace(/[\s{ \2 }]+/g,' ');
    if(str == " ")str = "";
    $(this).val( str );
});

$("input[name=cnpj]").keyup(function(){
    $(this).val(formataCnpj($(this).val()))
})

$(".error-input").hide()
//TRATA OS VALORES MONETÁRIOS
function trataValor(valor,tratamento){
    if(tratamento == 0){
        //TRATAENTO PARA EXIBIR NA TELA
        return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(valor).replace("R$","").trim()
    }else{
        //TRATAMENTO PARA PROCESSAR NO BACKEND
        var quantidade = 0;
        for (var i = 0; i < valor.length; i++) {
            if (valor[i] == "," || valor[i] == "." ) {
                quantidade++
            }
        }
        //PERGUNTA SE A QUANTIDADE DE VIRGULAS E IGUAL A DOIS
        if(quantidade == 2){
            val = valor.replace(",",".").replace(".","")
        }else{
            val = valor.replace(",",".").trim()
        }
        return val.replace(",",".")
    }
}
//FUNCAO DE ABRIR O MODAL
function abreModal(dados){
    $("#alerta .titulo").text(dados.titulo)
    $("#alerta .conteudoModal").text(dados.conteudo)
    $("#alerta .botao").show()
    $("#alerta .botao").text(dados.botao.texto)
    $("#alerta .botao").removeClass().addClass(dados.botao.class)
    $("#alerta .botao").on("click",dados.botao.funcao)
    $("#alerta .botoes button ").last().text("Cancelar")
    $("#alerta .botoes button ").last().removeClass().addClass("btn btn-default")
    $("#alerta").modal("show")
    return true
}

function aviso(aviso){
    $("#alerta .titulo").text("Atenção")
    $("#alerta .conteudoModal").text(aviso)
    $("#alerta .botao").hide()
    $("#alerta .botoes button ").last().text("Ok")
    $("#alerta .botoes button ").last().removeClass().addClass("btn btn-success")
    $("#alerta").modal("show")
    return true
}

function is_email(email){
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
}

function formataCep(cep){
    var str = "";
    cep = cep.replace(/[^0-9]+/g,'');
    cep = cep.substring(0,8);
    for(i=0;i < cep.length; i++){
        if(i==5){str = str +'-'};
        str = str+ (cep[i].toString());
    }
    return str;
}

function formataTelefone(num){
    var str = "";
    num = num.replace(/[^0-9]+/g,'');
    num = num.substring(0,11);
    for(i=0;i < num.length; i++){
        if(i==0){str = str +'('};
        if(i==2){str = str +') '};
        if(num.length == 10)
            if(i==6){str = str +'-'};
        if(num.length == 11)
            if(i==7){str = str +'-'};
        str = str+ (num[i].toString());
    }
    return str;
}

function formataCnpj(num){
    var str = "";
    num = num.replace(/[^0-9]+/g,'');
    num = num.substring(0,14);
    for(i=0;i < num.length; i++){
        if(i==2 || i==5){str = str +'.'};
        if(i==8){str = str +'/'};
        if(i==12){str = str +'-'};
        str = str+ (num[i].toString());
    }
	return str;
}

function formataData(num){
    var str = "";
    num = num.replace(/[^0-9]+/g,'');
    num = num.substring(0,8);
    for(i=0;i < num.length; i++){
        if(i==2){str = str +'/'};
        if(i==4){str = str +'/'};
        str = str+ (num[i].toString());
    }
    return str;
}

function formataCpf(num){
    var str = "";
    num = num.replace(/[^0-9]+/g,'');
    num = num.substring(0,11);
    for(i=0;i < num.length; i++){
        if(i==3 || i==6){str = str +'.'};
        if(i==9){str = str +'-'};
        str = str+ (num[i].toString());
    }
    return str;
}

function is_cpfcnpj(num){
    num = num.replace(/[^0-9]+/g,'');
    // CNPJ
    if( num.length == 14 ){
        cnpj = num;
         // Elimina CNPJs invalidos conhecidos
         if (cnpj == "00000000000000" || 
         cnpj == "11111111111111" || 
         cnpj == "22222222222222" || 
         cnpj == "33333333333333" || 
         cnpj == "44444444444444" || 
         cnpj == "55555555555555" || 
         cnpj == "66666666666666" || 
         cnpj == "77777777777777" || 
         cnpj == "88888888888888" || 
         cnpj == "99999999999999")
         return false;
          
        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
            
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
                
        return true;
    }
    if( num.length == 11 ){
        strCPF = num;
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000" || 
        strCPF == "11111111111" || 
        strCPF == "22222222222" || 
        strCPF == "33333333333" || 
        strCPF == "44444444444" || 
        strCPF == "55555555555" || 
        strCPF == "66666666666" || 
        strCPF == "77777777777" || 
        strCPF == "88888888888" || 
        strCPF == "99999999999")
        return false;

        for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
        return true;
    } 
    return 0;
}

function jurosParcelas(valor,parcelas,juros){
    var x = valor/parcelas
    var y = x + (juros/100)*x
    var z = {
        parcelas : parcelas,
        valorParcela : y,
        valorFinal : y*parcelas
    }
    return z
}

function taxaMaquininha(valor,taxa){
    var x = valor + (taxa/100)*valor
    return x
}

//TRATA OS FORMULARIOS
function validaCampos(form){
    var inputs = [];
    $("input").parent().find(".error-input").hide()
    $("label").removeClass("text-danger")
    $("input").removeClass("border-danger")

    $("select").parents(".select").find(".error-input").hide()
    $("label").removeClass("text-danger")
    $("select").removeClass("border-danger")

    $("textarea").parent().find(".error-input").hide()
    $("label").removeClass("text-danger")
    $("textarea").removeClass("border-danger")

    $("input:visible",form).each(function(){
        if(!$(this).hasClass("norequire")){
            if($(this).val().length < $(this).attr("minlength")){
                inputs.push($(this).attr("name"))
            }
        }
    })

    $("input[type=email]:visible",form).each(function(){
        if(!$(this).hasClass("norequire")){
            if($(this).val().length < $(this).attr("minlength") || !is_email($(this).val())){
                inputs.push($(this).attr("name"))
            }
        }
    })

    $(".cpfCnpj input:visible",form).each(function(){
        if(!$(this).hasClass("norequire")){
            if($(this).val().length < $(this).attr("minlength") || !is_cpfcnpj($(this).val())){
                inputs.push($(this).attr("name"))
            }
        }
    })

    $(".data input:visible",form).each(function(){
        if(!$(this).hasClass("norequire")){
            if($(this).val().length < $(this).attr("minlength")){
                inputs.push($(this).attr("name"))
            }
        }
    })

    $("select:visible",form).each(function(){
        if(!$(this).hasClass("norequire")){
            if($(this).val() == ""){
                inputs.push($(this).attr("name"))
            }
        }
    })

    $("textarea:visible",form).each(function(){
        if(!$(this).hasClass("norequire")){
            if($(this).val() == ""){
                inputs.push($(this).attr("name"))
            }
        }
    })

    if(inputs.length > 0){
        $(inputs).each(function(index,val){
            $("input[name='"+val+"']").parent().find(".error-input").show()
            $("input[name='"+val+"']").parent().find("label").addClass("text-danger")
            $("input[name='"+val+"']").addClass("border-danger")
            //
            $("select[name='"+val+"']").parent().find(".error-input").show()
            $("select[name='"+val+"']").parent().find("label").addClass("text-danger")
            $("select[name='"+val+"']").addClass("border-danger")
            //
            $("textarea[name='"+val+"']").parent().find(".error-input").show()
            $("textarea[name='"+val+"']").parent().find("label").addClass("text-danger")
            $("textarea[name='"+val+"']").addClass("border-danger")
        })
        return false
    }
    return true
}

//FUNÇÃO QUE ACIONA O AJAX
function abrirPagina(pagina){
    //AJAX QUE LISTAM OS DADOS
    $.ajax({
       beforeSend: function(){
        $(".loader").show();
        $(".conteudo").hide();
       },
       url: pagina,
       cache : false
       }).done(function(resultado){
           $('.conteudo').html(resultado);
           $(".loader").hide();
           $(".conteudo").show();
           $(".logoCentral").hide();
           $("body").css("background","white");

            $(".otherModal").on("hide.bs.modal",function(){
                if(!$(this).hasClass("alerta")){
                    $("input[type=text],input[type=email],input[type=name],input[type=password],input[type=hidden],input[type=tel]",this).val("")
                    $("select",this).val("")
                    $("input",this).css("border-color","")
                    $("label").removeClass("text-danger")
                    $("input").parents().find(".error-input").hide()
                    $("label").removeClass("text-danger")
                    $("input").removeClass("border-danger")
                    $(".permTitle").removeClass("text-danger")
                    $("select").parents(".select").find(".error-input").hide()
                    $("label").removeClass("text-danger")
                    $("select").removeClass("border-danger")
                    $("input[type=checkbox]").prop("checked",false)
                    $("input[type=datetime-local]").val("")
                    $("input[type=date]").val("")
                    $("textarea").removeClass("border-danger")
                    $("label").removeClass("text-danger")
                    $("textarea").parents(".textarea").find(".error-input").hide()
                    $("textarea").val("")
                    $('.valorProduto').text("");
                }else{

                }
            })

            $(".modal").on("show.bs.modal",function(){
                $(".error-input").hide()
            })

            $("input[name=cpf]").keyup(function(){
                $(this).val(formataCpf($(this).val()))
            })

            $(".data input").keyup(function(){
                $(this).val(formataData($(this).val()))
            })

            $(".money input").maskMoney({ 
                allowNegative: false,
                thousands:'.',
                decimal:',',
                affixesStay: true
            })

            $(".juros").maskMoney({ 
                allowNegative: false,
                thousands:'.',
                decimal:'.',
                affixesStay: true
            })

            $("input[name=cep]").keyup(function(){
                $(this).val(formataCep($(this).val()))
            })
            $("input[name=telefone]").keyup(function(){
                $(this).val(formataTelefone($(this).val()))
            })

            $('input[type=name]').bind('input',function(){
                str = $(this).val().replace(/[^A-Za-z\u00C0-\u00FF\-\/\s]+/g,'');
                str = str.replace(/[\s{ \2 }]+/g,' ');
                if(str == " ")str = "";
                $(this).val( str );
            });

            $('input[name=numero],.numbers').bind('input',function(){
                str = $(this).val().replace(/[^0-9]+/g,'');
                str = str.replace(/[\s{ \2 }]+/g,' ');
                if(str == " ")str = "";
                $(this).val( str );
            });

            $("input[type=email]").bind('input',function(){
                str = $(this).val().replace(/[^A-Za-z0-9\-\_\.\@]+/g,'');
                if(str == " ")str = "";
                $(this).val( str );
            })

            $('textarea').bind('textarea',function(){
                str = $(this).val().replace(/[^A-Za-z\u00C0-\u00FF\-\/\s]+/g,'');
                str = str.replace(/[\s{ \2 }]+/g,' ');
                if(str == " ")str = "";
                $(this).val( str );
            });

       });  

       //
   }
//

