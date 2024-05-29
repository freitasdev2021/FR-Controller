$(function () {
  var tableClientes = $("#example14").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaClientes.php",
  });

  tableClientes.on("draw",function(){
    $("#example14 tbody tr td:nth-child(2)").attr("data-content","Email")
    $("#example14 tbody tr td:nth-child(3)").attr("data-content","Telefone")
    $("#example14 tbody tr td:nth-child(4)").attr("data-content","CPF")
    $("#example14 tbody tr td:nth-child(5)").attr("data-content","Marketing")
  })

  var tableListaServicos = $("#example22").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaListaServicos.php"
  });

  $("#vendasHoje,#vendasTotais,#servicosHoje,#servicosTotais,#freguesiaServicos,#freguesiaProdutos").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true
  })

  tableListaServicos.on("draw",function(){
    $("#example22 tbody tr td:nth-child(2)").attr("data-content","Serviço")
    $("#example22 tbody tr td:nth-child(3)").attr("data-content","Cliente")
    $("#example22 tbody tr td:nth-child(4)").attr("data-content","Pagamento")
    $("#example22 tbody tr td:nth-child(5)").attr("data-content","Total")
  })

  var tableContasPagar = $("#example3").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaContasPagar.php",
  });

  tableContasPagar.on("draw",function(){
    $("#example6 tbody tr td:nth-child(2)").attr("data-content","Expedição")
    $("#example6 tbody tr td:nth-child(3)").attr("data-content","Vencimento")
    $("#example6 tbody tr td:nth-child(4)").attr("data-content","Valor")
    $("#example6 tbody tr td:nth-child(5)").attr("data-content","Status")
    $("#example6 tbody tr td:nth-child(6)").attr("data-content","Opções")
  })

  var tableColaboradores = $("#example4").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaColaboradores.php",
  });

  tableColaboradores.on("draw",function(){
    $("#example4 tbody tr td:nth-child(2)").attr("data-content","Cargo")
    $("#example4 tbody tr td:nth-child(3)").attr("data-content","Salário")
    $("#example4 tbody tr td:nth-child(4)").attr("data-content","CPF")
    $("#example4 tbody tr td:nth-child(5)").attr("data-content","Admissão")
    $("#example4 tbody tr td:nth-child(6)").attr("data-content","Filial")
  })

  $("#example5").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "bDestroy": true,
  });

  var tableDevedores= $("#example6").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaDevedoresClientes.php",
  });

  tableDevedores.on("draw",function(){
    $("#example6 tbody tr td:nth-child(2)").attr("data-content","Email")
    $("#example6 tbody tr td:nth-child(3)").attr("data-content","Telefone")
    $("#example6 tbody tr td:nth-child(4)").attr("data-content","CPF")
    $("#example6 tbody tr td:nth-child(5)").attr("data-content","Divida Total")
    $("#example6 tbody tr td:nth-child(6)").attr("data-content","Desde")
    $("#example6 tbody tr td:nth-child(7)").attr("data-content","Cobrança")
  })

  var tableCrediarios= $("#example5").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaCrediarioClientes.php",
  });

  tableCrediarios.on("draw",function(){
    $("#example5 tbody tr td:nth-child(2)").attr("data-content","Nome")
    $("#example5 tbody tr td:nth-child(3)").attr("data-content","Email")
    $("#example5 tbody tr td:nth-child(4)").attr("data-content","CPF")
    $("#example5 tbody tr td:nth-child(5)").attr("data-content","Crédito total")
    $("#example5 tbody tr td:nth-child(6)").attr("data-content","Desde")
    $("#example5 tbody tr td:nth-child(7)").attr("data-content","Até")
  })

  var tableFornecedores = $("#example7").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaFornecedores.php",
  });

  var tableServicos = $("#example18").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaServicos.php",
  })

  tableServicos.on("draw",function(){
    $("#example18 tbody tr td:nth-child(2)").attr("data-content","Mão de Obra")
  })

  var tableInsumos = $("#example20").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaInsumos.php",
  })

  var tableContratos = $("#example2").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaContratos.php",
  })

  tableContratos.on("draw",function(){
    $("#example2 tbody tr td:nth-child(2)").attr("data-content","CPF")
    $("#example2 tbody tr td:nth-child(3)").attr("data-content","Email")
    $("#example2 tbody tr td:nth-child(4)").attr("data-content","Telefone")
    $("#example2 tbody tr td:nth-child(5)").attr("data-content","Endereço")
    $("#example2 tbody tr td:nth-child(6)").attr("data-content","Plano")
    $("#example2 tbody tr td:nth-child(7)").attr("data-content","Situação")
  })

  var tableOrdens = $("#example19").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaOrdemServico.php",
  })

  tableOrdens.on("draw",function(){
    $("#example19 tbody tr td:nth-child(2)").attr("data-content","Cliente")
    $("#example19 tbody tr td:nth-child(3)").attr("data-content","Atendente")
    $("#example19 tbody tr td:nth-child(4)").attr("data-content","Codigo")
    $("#example19 tbody tr td:nth-child(5)").attr("data-content","Data e Hora")
    $("#example19 tbody tr td:nth-child(6)").attr("data-content","Status")
    $("#example19 tbody tr td:nth-child(7)").attr("data-content","Ordem")
  })

  var tablePagamentos = $("#example9").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaPagamentos.php",
  });

  tablePagamentos.on("draw",function(){
    $("#example9 tbody tr td:nth-child(2)").attr("data-content","Desconto")
    $("#example9 tbody tr td:nth-child(3)").attr("data-content","Método")
    $("#example9 tbody tr td:nth-child(4)").attr("data-content","Parcelas")
  })

  var tableProdutos = $("#example10").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaProdutos.php",
  });

  var tableFiliais = $("#example11").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaFiliais.php",
  });

  tableFiliais.on("draw",function(){
    $("#example11 tbody tr td:nth-child(2)").attr("data-content","Nome")
    $("#example11 tbody tr td:nth-child(3)").attr("data-content","Endereço")
    $("#example11 tbody tr td:nth-child(4)").attr("data-content","Faturamento")
    $("#example11 tbody tr td:nth-child(5)").attr("data-content","Folha Salarial")
    $("#example11 tbody tr td:nth-child(6)").attr("data-content","Opções")
  })

  var tablePromo = $("#example12").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaPromo.php",
  });

  var tableUsuarios = $("#example13").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaUsuarios.php",
  });

  tableUsuarios.on("draw",function(){
    $("#example13 tbody tr td:nth-child(2)").attr("data-content","Email")
    $("#example13 tbody tr td:nth-child(3)").attr("data-content","Permissões")
    $("#example13 tbody tr td:nth-child(4)").attr("data-content","Último Acesso")
    $("#example13 tbody tr td:nth-child(5)").attr("data-content","Situação")
  })

  var tableUsuarioscli = $("#example8").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaUsuarioscli.php",
  });

  tableUsuarioscli.on("draw",function(){
    $("#example8 tbody tr td:nth-child(2)").attr("data-content","Email")
    $("#example8 tbody tr td:nth-child(3)").attr("data-content","Permissões")
    $("#example8 tbody tr td:nth-child(4)").attr("data-content","Colaborador")
    $("#example8 tbody tr td:nth-child(5)").attr("data-content","Filial")
    $("#example8 tbody tr td:nth-child(6)").attr("data-content","Último Acesso")
    $("#example8 tbody tr td:nth-child(7)").attr("data-content","Situação")
  })



  tableVendas = $("#example21").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaVendas.php",
  });

  tableVendas.on("draw",function(){
    $("#example21 tbody tr td:nth-child(2)").attr("data-content","Valor")
    $("#example21 tbody tr td:nth-child(3)").attr("data-content","Quantidade")
    $("#example21 tbody tr td:nth-child(4)").attr("data-content","Pagamento")
    $("#example21 tbody tr td:nth-child(5)").attr("data-content","Promoção")
    $("#example21 tbody tr td:nth-child(6)").attr("data-content","Cliente")
    $("#example21 tbody tr td:nth-child(7)").attr("data-content","PDV")
    $("#example21 tbody tr td:nth-child(8)").attr("data-content","Data")
    $("#example21 tbody tr td:nth-child(9)").attr("data-content","Opções")
  })

  tableVendasServicos = $("#example17").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaVendasServicos.php",
  });

  tableVendasServicos.on("draw",function(){
    $("#example17 tbody tr td:nth-child(2)").attr("data-content","Valor")
    $("#example17 tbody tr td:nth-child(3)").attr("data-content","Quantidade")
    $("#example17 tbody tr td:nth-child(4)").attr("data-content","Pagamento")
    $("#example17 tbody tr td:nth-child(5)").attr("data-content","Promoção")
    $("#example17 tbody tr td:nth-child(6)").attr("data-content","Cliente")
    $("#example17 tbody tr td:nth-child(7)").attr("data-content","Serviço")
    $("#example17 tbody tr td:nth-child(8)").attr("data-content","Colaborador")
    $("#example17 tbody tr td:nth-child(9)").attr("data-content","Data")
    $("#example17 tbody tr td:nth-child(10)").attr("data-content","Opções")
  })

  var tablePontos = $("#example15").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaPontosVenda.php",
  });

  tablePontos.on("draw",function(){
    $("#example15 tbody tr td:nth-child(2)").attr("data-content","Caixa")
    $("#example15 tbody tr td:nth-child(3)").attr("data-content","Status")
  })

  tableComissoes = $("#example16").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaComissoes.php",
  });

  tableComissoes.on("draw",function(){
    $("#example16 tbody tr td:nth-child(2)").attr("data-content","Tipo")
    $("#example16 tbody tr td:nth-child(3)").attr("data-content","Porcentagem")
    $("#example16 tbody tr td:nth-child(4)").attr("data-content","Participantes")
  })

  tableProdutos.on("draw",function(){
    $("#example10 tbody tr td:nth-child(2)").attr("data-content","Valor(R$)")
    $("#example10 tbody tr td:nth-child(3)").attr("data-content","Codigo")
    $("#example10 tbody tr td:nth-child(4)").attr("data-content","Estoque/Estoque Minimo")
    $("#example10 tbody tr td:nth-child(5)").attr("data-content","Entrada/Validade")
    $("#example10 tbody tr td:nth-child(6)").attr("data-content","Vendas/Custos")
  })
  
  tableInsumos.on("draw",function(){
    $("#example20 tbody tr td:nth-child(2)").attr("data-content","Valor(R$)")
    $("#example20 tbody tr td:nth-child(3)").attr("data-content","Vendas/Estoque")
    $("#example20 tbody tr td:nth-child(4)").attr("data-content","Entrada/Validade")
    $("#example20 tbody tr td:nth-child(5)").attr("data-content","Vendas/Custos")
  })

  //
  tableFornecedores.on("draw",function(){
    $("#example7 tbody tr td:nth-child(2)").attr("data-content","Email")
    $("#example7 tbody tr td:nth-child(3)").attr("data-content","Telefone")
    $("#example7 tbody tr td:nth-child(4)").attr("data-content","Endereço")
  })

  tablePromo.on("draw",function(){
    $("#example12 tbody tr td:nth-child(2)").attr("data-content","Desconto")
    $("#example12 tbody tr td:nth-child(3)").attr("data-content","Inicio")
    $("#example12 tbody tr td:nth-child(4)").attr("data-content","Termino")
    $("#example12 tbody tr td:nth-child(5)").attr("data-content","Status")
    $("#example12 tbody tr td:nth-child(6)").attr("data-content","Produtos e Serviços")
  })

});
