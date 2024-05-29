jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
        $(".bt_excluir_filial").hide()
        montaBotoes();
        getFiliais()
        getMeses()
        getTrintaDias()
        getSeteDias()
    })

      //DESENHA O RELATORIO DAS FILIAIS
  function getFiliais(){
    $.ajax({
        method : "POST",
        url    : "./views/view.php",
        data : {
            Setor : "getMovFil",
            ID    : ""
        } 
    }).done(function(retorno){
        console.log(retorno)
        aDatasets1 = [];  
        aDatasets2 = [];
        labels = []
        parse = jQuery.parseJSON(retorno)
        parse.forEach((i)=>{
            labels.push(i.Nome)
            aDatasets1.push(i.faturamentoTotal)
            aDatasets2.push(i.lucroTotal)
        })
        var ctx = document.getElementById("relFiliais");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                
                datasets: [{
                      label: 'Sairam',
                      fill:false,
                    data: aDatasets1,
                    backgroundColor: 'red',
                    borderWidth: 1
                },{
                    label: 'Entraram',
                      fill:false,
                    data: aDatasets2,
                    backgroundColor: 'green',
                    borderWidth: 1
                }
              ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback : (value,index,values) => {
                                return trataValor(value,0)
                            }
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Movimentação por filial'
                },
                responsive: true,
                
              tooltips: {
                    callbacks: {
                        labelColor: function(tooltipItem, chart) {
                            return {
                                borderColor: 'green',
                                backgroundColor: 'transparent'
                            }
                        },
                        label : function(tooltipItem,data) {
                            return trataValor(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index],0)
                        }
                    }
                },
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontColor: 'black',
                      
                    }
                }
            }
        });
    })
      
  }

      //DESENHA OS RELATORIOS DOS MESES
  function getMeses(){
    $.ajax({
        method : "POST",
        url    : "./views/view.php",
        data : {
            Setor : "getMoveFilDozeMeses",
            ID    : ""
        } 
    }).done(function(retorno){
        console.log(retorno)
        parse = jQuery.parseJSON(retorno)
        aDatasets1 = [];  
        aDatasets2 = [];
        labels = []
        parse.forEach((i)=>{
            labels.push(i.tempo)
            aDatasets1.push(i.faturamentoTotal)
            aDatasets2.push(i.lucroTotal)
        })
        var ctx = document.getElementById("relMeses");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                
                datasets: [{
                    label: 'Sairam',
                    fill:false,
                    data: aDatasets1,
                    backgroundColor: 'red',
                    borderWidth: 1
                },{
                    label: 'Entraram',
                    fill:false,
                    data: aDatasets2,
                    backgroundColor: 'green',
                    borderWidth: 1
                }
              ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback : (value,index,values) => {
                                return trataValor(value,0)
                            }
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Ultimos 12 Meses'
                },
                responsive: true,
                
              tooltips: {
                    callbacks: {
                        labelColor: function(tooltipItem, chart) {
                            return {
                                borderColor: 'green',
                                backgroundColor: 'transparent'
                            }
                        },
                        label : function(tooltipItem,data) {
                            return trataValor(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index],0)
                        }
                    }
                },
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontColor: 'black',
                      
                    }
                }
            }
        });
    })
      
  }

  //DESENHA OS RELATORIOS DOS 30 DIAS
  function getTrintaDias(){
    $.ajax({
        method : "POST",
        url    : "./views/view.php",
        data : {
            Setor : "getMoveFilUmMes",
            ID    : ""
        } 
    }).done(function(retorno){
        trintadias = jQuery.parseJSON(retorno)
        faturamentoTrintaDias = [];  
        lucroTrintaDias = [];
        dias = []
        trintadias.forEach((i)=>{
            dias.push(i.tempo)
            faturamentoTrintaDias.push(i.faturamentoTotal)
            lucroTrintaDias.push(i.lucroTotal)
        })
        var ctx = document.getElementById("relTrintaDias");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dias,
                
                datasets: [{
                    label: 'Sairam',
                    fill:false,
                    data: faturamentoTrintaDias,
                    backgroundColor: 'red',
                    borderWidth: 1
                },{
                    label: 'Entraram',
                    fill:false,
                    data: lucroTrintaDias,
                    backgroundColor: 'green',
                    borderWidth: 1
                }
              ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback : (value,index,values) => {
                                return trataValor(value,0)
                            }
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Ultimos 30 Dias'
                },
                responsive: true,
                
              tooltips: {
                    callbacks: {
                        labelColor: function(tooltipItem, chart) {
                            return {
                                borderColor: 'green',
                                backgroundColor: 'transparent'
                            }
                        },
                        label : function(tooltipItem,data) {
                            return trataValor(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index],0)
                        }
                    }
                },
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontColor: 'black',
                      
                    }
                }
            }
        });  
    })
      
  }

  //DESENHA OS RELATORIOS DOS 7 DIAS
  function getSeteDias(){
    $.ajax({
        method : "POST",
        url    : "./views/view.php",
        data : {
            Setor : "getMoveFilSeteDias",
            ID    : ""
        } 
    }).done(function(retorno){
        setedias = jQuery.parseJSON(retorno)
        faturamentoSeteDias = [];  
        lucroSeteDias = [];
        dias = []
        setedias.forEach((i)=>{
            dias.push(i.tempo)
            faturamentoSeteDias.push(i.faturamentoTotal)
            lucroSeteDias.push(i.lucroTotal)
        })
        var ctx = document.getElementById("relSeteDias");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dias,
                
                datasets: [{
                    label: 'Sairam',
                    fill:false,
                    data: faturamentoSeteDias,
                    backgroundColor: 'red',
                    borderWidth: 1
                },{
                    label: 'Entraram',
                    fill:false,
                    data: lucroSeteDias,
                    backgroundColor: 'green',
                    borderWidth: 1
                }
              ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback : (value,index,values) => {
                                return trataValor(value,0)
                            }
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Ultimos 7 Dias'
                },
                responsive: true,
                
              tooltips: {
                    callbacks: {
                        labelColor: function(tooltipItem, chart) {
                            return {
                                borderColor: 'green',
                                backgroundColor: 'transparent'
                            }
                        },
                        label : function(tooltipItem,data) {
                            return trataValor(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index],0)
                        }
                    }
                },
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontColor: 'black',
                      
                    }
                }
            }
        });  
    })
      
  }

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalAlert = "#alerta";
        var modalFilial = "#cadastroFilial";
        var formFilial = "#formCadastroFilial";
        //ENVIAR DADOS DO Pagar
        $(".bt_salvar_filial").on("click",function(e){
            setRegistro(formFilial);
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
        $(".adicionarFilial").on("click",function(){
            $(modalFilial).modal("show");
        })
        //FIM DA FUNÇÃO;

        if($(".getDados tr").length == 0){
            $(".pagination").hide()
        }

        $("#cadastroFilial").on("hide.bs.modal",function(){
            $(".bt_excluir_filial").hide()
            $(".bt_mudar_filial").hide()
            $("input[name=cpf]").prop("disabled",false)
        })

        $(".bt_excluir_filial").on("click",function(){
            if(confirm("Deseja mesmo excluir esta filial?")){
                delContrato("#formcadastroFilial");
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
                IDFilial     : $("input[name=IDFilial]").val(),
                nome         : $("input[name=nome]").val(),
                empresa      : $("input[name=empresa]").val(),
                cep          : $("input[name=cep]",form).val().replace(/[^0-9]+/g,''),
                uf           : $("select[name=uf]",form).val(),
                cidade       : $("input[name=cidade]",form).val(),
                bairro       : $("input[name=bairro]",form).val(),
                rua          : $("input[name=rua]",form).val(),
                numero       : $("input[name=numero]",form).val(),
                telefone     : $("input[name=telefone]",form).val().replace(/[^0-9]+/g,''),
                complemento  : $("input[name=complemento]",form).val()
            }
        }).done(function(resultado){
            console.log(resultado);
            $("#example11").DataTable().ajax.reload( null, false );
           $("#cadastroFilial").modal("hide")
        })
    }
    //FIM DA PAGINA
})


