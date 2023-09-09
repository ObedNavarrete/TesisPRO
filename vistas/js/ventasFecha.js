if (localStorage.getItem("capturarRango") != null) {
  $("#daterange-btn span").html(localStorage.getItem("capturarRango"));
}

$(document).ready(function () {
  $(".tablaVentaVendedor thead tr")
    .clone(true)
    .addClass("filters")
    .appendTo(".tablaVentaVendedor thead");

  var table = $(".tablaVentaVendedor").DataTable({
    deferRender: true,
    searching: true,
    retrieve: true,
    procesing: true,
    pageLength: 25,
    ordering: true,
    dom: "Bfrtip",
    buttons: [
      {
        //Botón para Excel
        extend: "copy",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<i class="fas fa-copy"></i>',
        className: "btn-warning",
      },
      {
        //Botón para Excel
        extend: "excel",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<i class="far fa-file-excel"></i>',
        className: "btn-success",
      },
      {
        extend: "pdfHtml5",
        orientation: 'landscape',
        download: "open",
        text: '<i class="far fa-file-pdf"></i>',
        className: "btn-danger",
        messageTop: "Ventas en rango de fecha",
        title: "RIFA DÍAZ",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
        },
        customize: function (doc) {
          var now = new Date();
					var jsDate = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();

          doc.content[2].table.widths = ["12%", "12%", "21%", "10%", "15%", "15%", "15%" ];
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
            color: "black",
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
      {
        //Botón para Excel
        extend: "print",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<i class="fas fa-print"></i>',
        className: "btn-secondary",
      },
    ],
    orderCellsTop: true,
    fixedHeader: true,
    initComplete: function () {
      var api = this.api();

      // For each column
      api
        .columns()
        .eq(0)
        .each(function (colIdx) {
          // Set the header cell to contain the input element
          var cell = $(".filters th").eq(
            $(api.column(colIdx).header()).index()
          );
          var title = $(cell).text();
          $(cell).html(
            '<input type="text" class="form-control shadow-none border text-center p-0 border-0" placeholder="Buscar..." style="height:25px" />'
          );

          // On every keypress in this input
          $(
            "input",
            $(".filters th").eq($(api.column(colIdx).header()).index())
          )
            .off("keyup change")
            .on("keyup change", function (e) {
              e.stopPropagation();

              // Get the search value
              $(this).attr("title", $(this).val());
              var regexr = "({search})"; //$(this).parents('th').find('select').val();

              var cursorPosition = this.selectionStart;
              // Search the column for that value
              api
                .column(colIdx)
                .search(
                  this.value != ""
                    ? regexr.replace("{search}", "(((" + this.value + ")))")
                    : "",
                  this.value != "",
                  this.value == ""
                )
                .draw();

              $(this)
                .focus()[0]
                .setSelectionRange(cursorPosition, cursorPosition);
            });
        });
    },
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
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
});

$(document).ready(function () {
  $(".tablaVentaVendedorFecha thead tr")
    .clone(true)
    .addClass("filters")
    .appendTo(".tablaVentaVendedorFecha thead");

  var table = $(".tablaVentaVendedorFecha").DataTable({
    deferRender: true,
    searching: true,
    retrieve: true,
    procesing: true,
    pageLength: 25,
    ordering: true,
    dom: "Bfrtip",
    buttons: [
      {
        //Botón para Excel
        extend: "copy",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<i class="fas fa-copy"></i>',
        className: "btn-warning",
      },
      {
        //Botón para Excel
        extend: "excel",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<i class="far fa-file-excel"></i>',
        className: "btn-success",
      },
      {
        extend: "pdfHtml5",
        orientation: 'landscape',
        download: "open",
        text: '<i class="far fa-file-pdf"></i>',
        className: "btn-danger",
        messageTop: "Ventas en rango de fecha",
        title: "RIFA DÍAZ",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
        },
        customize: function (doc) {
          var now = new Date();
					var jsDate = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();

          doc.content[2].table.widths = ["12%", "12%", "21%", "10%", "15%", "15%", "15%" ];
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
            color: "black",
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
      {
        //Botón para Excel
        extend: "print",
        footer: true,
        title: "Archivo",
        filename: "Export_File",

        //Aquí es donde generas el botón personalizado
        text: '<i class="fas fa-print"></i>',
        className: "btn-secondary",
      },
    ],
    orderCellsTop: true,
    fixedHeader: true,
    initComplete: function () {
      var api = this.api();

      // For each column
      api
        .columns()
        .eq(0)
        .each(function (colIdx) {
          // Set the header cell to contain the input element
          var cell = $(".filters th").eq(
            $(api.column(colIdx).header()).index()
          );
          var title = $(cell).text();
          $(cell).html(
            '<input type="text" class="form-control shadow-none border text-center p-0 border-0" placeholder="Buscar..." style="height:25px" />'
          );

          // On every keypress in this input
          $(
            "input",
            $(".filters th").eq($(api.column(colIdx).header()).index())
          )
            .off("keyup change")
            .on("keyup change", function (e) {
              e.stopPropagation();

              // Get the search value
              $(this).attr("title", $(this).val());
              var regexr = "({search})"; //$(this).parents('th').find('select').val();

              var cursorPosition = this.selectionStart;
              // Search the column for that value
              api
                .column(colIdx)
                .search(
                  this.value != ""
                    ? regexr.replace("{search}", "(((" + this.value + ")))")
                    : "",
                  this.value != "",
                  this.value == ""
                )
                .draw();

              $(this)
                .focus()[0]
                .setSelectionRange(cursorPosition, cursorPosition);
            });
        });
    },
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
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
});

/*=============================================
RANGO DE FECHAS
=============================================*/
$("#daterange-btn").daterangepicker(
  {
    ranges: {
      Hoy: [moment(), moment()],
      Ayer: [moment().subtract(1, "days"), moment().subtract(1, "days")],
      "Últimos 7 días": [moment().subtract(6, "days"), moment()],
      "Últimos 30 días": [moment().subtract(29, "days"), moment()],
      "Este mes": [moment().startOf("month"), moment().endOf("month")],
      "Último mes": [
        moment().subtract(1, "month").startOf("month"),
        moment().subtract(1, "month").endOf("month"),
      ],
    },
    locale: {
      format: "DD/MM/YYYY",
      separator: " / ",
      applyLabel: "Aplicar",
      cancelLabel: "Cancelar",
      fromLabel: "From",
      toLabel: "To",
      customRangeLabel: "Personalizar",
      weekLabel: "W",
      daysOfWeek: ["Do", "Lu", "Ma", "Mie", "Jue", "Vie", "Sa"],
      monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      firstDay: 6,
    },
    startDate: moment(),
    endDate: moment(),
  },
  function (start, end) {
    var fechaInicial = start.format("YYYY/MM/DD");
    var fechaFinal = end.format("YYYY/MM/DD");

    if (fechaInicial == fechaFinal) {
      $("#daterange-btn span").html(start.format("D MMMM, YYYY "));
    } else {
      $("#daterange-btn span").html(
        start.format("D MMMM, YYYY ") + " - " + end.format("D MMMM, YYYY ")
      );
    }

    var capturarRango = $("#daterange-btn span").html();

    localStorage.setItem("capturarRango", capturarRango);

    window.location =
      "index.php?ruta=ventasFecha&fechaInicial=" +
      fechaInicial +
      "&fechaFinal=" +
      fechaFinal;
  }
);

/*CANCELAR RANGO DE FECHAS*/
$(".daterangepicker.opensright .range_inputs .cancelBtn").on(
  "click",
  function () {
    localStorage.removeItem("capturarRango");
    localStorage.clear();
    window.location = "ventasFecha";
  }
);

/*Hoy*/

$(".daterangepicker .ranges li").on("click", function () {
  var textoHoy = $(this).attr("data-range-key");

  if (textoHoy == "Hoy") {
    var d = new Date();

    var dia = d.getDate();
    var mes = d.getMonth() + 1;
    var anio = d.getFullYear();

    console.log(dia);
    console.log(mes);
    console.log(anio);

    if (mes < 10) {
      var fechaInicial = anio + "-0" + mes + "-" + dia;
      var fechaFinal = anio + "-0" + mes + "-" + dia;
    } else if (dia < 10) {
      var fechaInicial = anio + "-" + mes + "-0" + dia;
      var fechaFinal = anio + "-" + mes + "-0" + dia;
    } else if (mes < 10 && dia < 10) {
      var fechaInicial = anio + "-0" + mes + "-0" + dia;
      var fechaFinal = anio + "-0" + mes + "-0" + dia;
    } else {
      var fechaInicial = anio + "-" + mes + "-" + dia;
      var fechaFinal = anio + "-" + mes + "-" + dia;
    }

    localStorage.setItem("capturarRango", "Hoy");
    window.location =
      "index.php?ruta=ventasFecha&fechaInicial=" +
      fechaInicial +
      "&fechaFinal=" +
      fechaFinal;
  }
});

window.onload = actualizarPagina();

function actualizarPagina() {
  let actualizar = false;
  momentoActual = new Date();
  hora = momentoActual.getHours();
  minuto = momentoActual.getMinutes();
  segundo = momentoActual.getSeconds();

  str_segundo = new String(segundo);
  if (str_segundo.length == 1) {
    segundo = "0" + segundo;
  }
  str_minuto = new String(minuto);
  if (str_minuto.length == 1) {
    minuto = "0" + minuto;
  }
  str_hora = new String(hora);
  if (str_hora.length == 1) {
    hora = "0" + hora;
  }
  horaImprimible = hora + ":" + minuto + ":" + segundo;
  if (horaImprimible == "21:10:00") {
    actualizar = true;
  }
  setTimeout("actualizarPagina()", 1000);
  if (actualizar == true) {
    //Comprueba que la hora es igual a la que quieres y actualiza
    location.reload();
  }
}
