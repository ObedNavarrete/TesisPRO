$(document).ready(function () {
  $('.tablaVentasVendedorAnterior thead tr:eq(1) th').each(function() {
  var title = $(this).text();
  $(this).html('<input type="text" placeholder="Buscar" class="column_search" />');
  });
  var table = $('.tablaVentasVendedorAnterior').DataTable({
    orderCellsTop: true,
    deferRender: true,
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
      filename: "Recibos",
      text: '<i class="far fa-file-excel"></i>',
      className: "btn col-2 btn-success",
    },
          {
        extend: "pdfHtml5",
        download: "open",
        text: '<i class="far fa-file-pdf"></i>',
        className: "btn col-2 btn-danger",
        messageTop: "Recibos del Sorteo Anterior",
        title: "RIFA DÍAZ",
        exportOptions: {
          columns: [1, 2, 3, 4, 5],
        },
        customize: function (doc) {
          var now = new Date();
					var jsDate = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();

          doc.content[2].table.widths = ["20%", "25%", "20%", "12.5%", "17.5%"];
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
            color: "blue",
            fontSize: "30",
            alignment: "center",
          };
          doc.styles["td:nth-child(2)"] = {
            width: "auto",
            "max-width": "auto",
            fontSize: "20",
            alignment: "center",
          };
        },
      },
    ]
  });
  $('.tablaVentasVendedorAnterior thead').on('keyup', ".column_search", function() {
    table
      .column($(this).parent().index())
      .search(this.value)
      .draw();
  });
});

$(document).on("click", ".btnVerRecibo", function () {
  $(".btnVerRecibo").attr("disabled", true);
  var idVer = $(this).attr("id-ver");
  //console.log(idVer);

  $(".verNum").remove();
  $(".verMonto").remove();
  $(".verPremio").remove();
  $(".txt-rcb").remove();
  $(".txt-rcbf").remove();

  var datos = new FormData();
  datos.append("idVer", idVer);

  $.ajax({
    url: "ajax/edit.updateVender.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      //console.log(respuesta["id"]);
      var lo = JSON.parse(respuesta);
      let suma = 0;

      //console.log(lo);

      $("#cod-rcba").append(
          
        '<div class="text-center font-weight-bold text-primary txt-rcbf">' + lo[0][6] + ' / ' + lo[0][1] + '</div>' +
        '<div class="text-center font-weight-bold text-warning txt-rcb">cod: ' + lo[0][2] + '</div>' 
      );

      for (let index = 0; index < lo.length; index++) {
        const element = lo[index];
        //console.log(element);
        suma = suma + lo[index][3];

        $("#viendoRecibo").append(
          '<input type="number" class="text-center col-4 form-control shadow-none border-0 verNum" name="regNumero" value="' +
            lo[index][3] +
            '">' +
            '<input type="number" class="text-center col-4 form-control shadow-none border-0 verMonto" name="regMonto" value="' +
            lo[index][4] +
            '">' +
            '<input type="number" class="text-center col-4 form-control shadow-none border-0 verPremio" name="regPremio" value="' +
            lo[index][5] +
            '">'
        );
      $(".btnVerRecibo").attr("disabled", false);
      }
    },
  });
});
