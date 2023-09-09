$(document).ready(function() {
  $('.tablaGanadoresDetalle thead tr:eq(1) th').each(function() {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Buscar" class="column_search" />');
  });
  var table = $('.tablaGanadoresDetalle').DataTable({
    orderCellsTop: true,
    deferRender: true,
    order: [[0, "desc"]],
    searching: true,
    retrieve: true,
    procesing: true,
    pageLength: 25,
    ordering: true,
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_",
      sZeroRecords: "No hay resultados para esa búsqueda",
      sEmptyTable: "No hay datos disponibles",
      sInfo: "Registros del _START_ al _END_",
      sInfoEmpty: "0 al 0",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: ">",
        sPrevious: "<",
      },
      oAria: {
        sSortAscending: ": Activar para ordenar la columna de manera ascendente",
        sSortDescending: ": Activar para ordenar la columna de manera descendente",
      },
    },
    dom: "Bfrtip",
    buttons: [{
      extend: "excel",
      footer: true,
      filename: "Detalle de Ganadores",
      text: '<i class="far fa-file-excel"></i>',
      className: "btn col-2 btn-success",
    },
    {
        extend: "pdfHtml5",
        orientation: 'landscape',
        download: "open",
        text: '<i class="far fa-file-pdf"></i>',
        className: "btn col-2 btn-danger",
        alignment: "center",
        messageTop: "Listado de Detalle de Premios a Pagar",
        title: "RIFA DÍAZ",
        exportOptions: {
          columns: [1, 2, 4, 3, 5, 6, 7],
        },
        customize: function (doc) {
          var now = new Date();
					var jsDate = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();

          doc.content[2].table.widths = ["15.5%", "12.5%", "10%", "18%", "15%", "15%", "15%"];
          doc.defaultStyle.alignment = 'center';
          doc.styles.tableHeader.fontSize = 13;
          doc.defaultStyle.fontSize = 11;
          doc['footer']=(function(page, pages) {
							return {
								columns: [
									{
										alignment: 'left',
										text: [{ text: jsDate.toString() }]
									},
									{
										alignment: 'right',
										text: ['Página ', { text: page.toString() },	' de ',	{ text: pages.toString() }]
									}
								],
								margin: 15
							}
						});
          doc.styles.title = {
            color: "#084FA4",
            fontSize: "25",
            alignment: "center",
          };
          doc.styles["td:nth-child(2)"] = {
            width: "100px",
            fontSize: "20",
            alignment: "center",
          };
        },
      }]
  });
  $('.tablaGanadoresDetalle thead').on('keyup', ".column_search", function() {
    table
      .column($(this).parent().index())
      .search(this.value)
      .draw();
  });
});