jQuery(function(e){
    $(document).ready(function(){
        getMaisPagamentos()
        getSirvissos()
        getCat()
        getPromos()
    })

    function getPromos(){
        cValues = []
        vValues = []
        $.ajax({
            method : "POST",
            url    : "./views/view.php",
            data : {
                Setor : "getPromos",
                ID    : ""
            } 
        }).done(function(retorno){
            // console.log(retorno)
            // return false
            var ret = jQuery.parseJSON(retorno)
            ret.forEach((i)=>{
                cValues.push(i.promo)
                vValues.push(i.vendas)
            })
            var barColors = [
                "#b91d47",
                "#00aba9",
                "#2b5797",
                "#e8c3b9"
              ];
              
              var rp = $("#relPromos")
        
              new Chart(rp, {
                type: "pie",
                data: {
                  labels: cValues,
                  datasets: [{
                    backgroundColor: barColors,
                    data: vValues
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: "Vendas por promoção ativa"
                  }
                }
            })
        })
    } 

    function getCat(){
        pValues = []
        nValues = []
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
                pValues.push(i.categoria)
                nValues.push(i.vendas)
            })
            var barColors = [
                "#b91d47",
                "#00aba9",
                "#2b5797",
                "#e8c3b9"
              ];
              
              var rp = $("#relCatsMod")
        
              new Chart(rp, {
                type: "pie",
                data: {
                  labels: pValues,
                  datasets: [{
                    backgroundColor: barColors,
                    data: nValues
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

    function getMaisPagamentos(){
        zValues = []
        oValues = []
        $.ajax({
            method : "POST",
            url    : "./views/view.php",
            data : {
                Setor : "getPag",
                ID    : ""
            } 
        }).done(function(retorno){
            // console.log(retorno)
            // return false
            var ret = jQuery.parseJSON(retorno)
            ret.forEach((i)=>{
                zValues.push(i.pagamento)
                oValues.push(i.vendas)
            })
            var barColors = [
                "#b91d47",
                "#00aba9",
                "#2b5797",
                "#e8c3b9"
              ];
              
              var rp = $("#relPags")
        
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
                    text: "Pagamentos mais utilizados"
                  }
                }
            })
        })
      } 

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
})