jQuery(function(e){
    $(document).ready(function(){
        getMeses()
        getTrintaDias()
        getSeteDias()
    })

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
                        label: 'Faturamento',
                        fill:false,
                        data: aDatasets1,
                        backgroundColor: 'blue',
                        borderWidth: 1
                    },{
                        label: 'Lucro',
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
                                    backgroundColor: 'blue'
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
                        label: 'Faturamento',
                        fill:false,
                        data: faturamentoTrintaDias,
                        backgroundColor: 'blue',
                        borderWidth: 1
                    },{
                        label: 'Lucro',
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
                                    backgroundColor: 'blue'
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
                        label: 'Faturamento',
                        fill:false,
                        data: faturamentoSeteDias,
                        backgroundColor: 'blue',
                        borderWidth: 1
                    },{
                        label: 'Lucro',
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
                                    backgroundColor: 'blue'
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

})