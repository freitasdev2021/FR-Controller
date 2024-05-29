jQuery(function(e){
    $(document).ready(function(){
      getPlanos()
      getCategorias()
      getSirvissos()
    })
    //DESENHA O GRÁFICO DOS PLANOS

  function getSirvissos(){
    yValues = []
    xValues = []
    $.ajax({
        method : "POST",
        url    : "./views/view.php",
        data : {
            Setor : "getServ",
            ID    : ""
        } 
    }).done(function(retorno){
        // console.log(retorno)
        // return false
        var ret = jQuery.parseJSON(retorno)
        ret.forEach((i)=>{
            xValues.push(i.nome)
            yValues.push(i.quantidade)
        })
        var barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
            "#e8c3b9"
          ];
          
          var rp = $("#relSirvissos")
    
          new Chart(rp, {
            type: "pie",
            data: {
              labels: xValues,
              datasets: [{
                backgroundColor: barColors,
                data: yValues
              }]
            },
            options: {
              title: {
                display: true,
                text: "Serviços mais realizados"
              }
            }
        })
    })
  }
  function getPlanos(){
      var xValues = ["Starter", "Ecommerce", "Fiscal", "Ecommerce Fiscal"];
      var yValues = [];
      $.ajax({
        method : "POST",
        url    : "./views/view.php",
        data : {
            Setor : "getPlanos",
            ID    : ""
        } 
      }).done(function(retorno){
        //console.log(retorno)
        ret = jQuery.parseJSON(retorno)
        ret.forEach(function(v){
            yValues.push(v)
        })
        var barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
            "#e8c3b9"
          ];
          
          var rp = $("#relPlanos")
    
          new Chart(rp, {
            type: "pie",
            data: {
              labels: xValues,
              datasets: [{
                backgroundColor: barColors,
                data: yValues
              }]
            },
            options: {
              title: {
                display: true,
                text: "Planos"
              }
            }
          })
      })
  }
  //MOSTRA AS CATEGORIAS MAIS VENDIDAS DE CADA FILIAL
  function getCategorias(){
    zValues = []
    oValues = []
    $.ajax({
        method : "POST",
        url    : "./views/view.php",
        data : {
            Setor : "getCat",
            ID    : ""
        } 
    }).done(function(retorno){
        // console.log(retorno)
        // return false
        var ret = jQuery.parseJSON(retorno)
        ret.forEach((i)=>{
            zValues.push(i.categoria)
            oValues.push(i.vendas)
        })
        var barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
            "#e8c3b9"
          ];
          
          var rp = $("#relCats")
    
          new Chart(rp, {
            type: "pie",
            data: {
              labels: zValues,
              datasets: [{
                backgroundColor: barColors,
                data: oValues
              }]
            },
            options: {
              title: {
                display: true,
                text: "Categorias mais vendidas"
              }
            }
        })
    })
  } 

})