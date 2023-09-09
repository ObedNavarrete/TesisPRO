$(document).ready(function () {
  $('.tablaListas thead tr:eq(1) th').each(function() {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Buscar" class="column_search" />');
  });
  var table = $('.tablaListas').DataTable({
    order: [[0, "desc"]],
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
      messageTop: "Detalle de No Ganadores por sorteo",
      title: "RIFA DÍAZ",
      exportOptions: {
        columns: [1, 2, 3, 4],
      },
      customize: function (doc) {
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
    },]
  });
  $('.tablaListas thead').on('keyup', ".column_search", function() {
    table
      .column($(this).parent().index())
      .search(this.value)
      .draw();
  });
});

// $(document).ready(function () {
//   $(".tablaListas thead tr")
//     .clone(true)
//     .addClass("filters")
//     .appendTo(".tablaListas thead");

//   var table = $(".tablaListas").DataTable({
//     deferRender: true,
//     searching: true,
//     retrieve: true,
//     pageLength: 25,
//     order: [[0, "desc"]],
//     stateSave: false,
//     procesing: true,
//     ordering: true,
//     dom: "Bfrtip",
//     buttons: [
//       {
//         //Botón para Excel
//         extend: "copy",
//         footer: true,
//         title: "Archivo",
//         filename: "Export_File",

//         //Aquí es donde generas el botón personalizado
//         text: '<i class="fas fa-copy"></i>',
//         className: "btn-warning",
//       },
//       {
//         //Botón para Excel
//         extend: "excel",
//         footer: true,
//         title: "Archivo",
//         filename: "Export_File",

//         //Aquí es donde generas el botón personalizado
//         text: '<i class="far fa-file-excel"></i>',
//         className: "btn-success",
//       },
//       {
//         extend: "pdfHtml5",
//         download: "open",
//         text: '<i class="far fa-file-pdf"></i>',
//         className: "btn-danger",
//         messageTop: "Listado de Premios Máximos de Números por Vendedor",
//         title: "RIFA DÍAZ",
//         exportOptions: {
//           columns: [0, 1, 2, 3, 4],
//         },
//         customize: function (doc) {
//           var now = new Date();
//           var jsDate =
//             now.getDate() +
//             "/" +
//             (now.getMonth() + 1) +
//             "/" +
//             now.getFullYear();

//           doc.content[2].table.widths = ["20%", "20%", "20%", "20%", "20%"];
//           doc.defaultStyle.alignment = "center";
//           doc.styles.tableHeader.fontSize = 13;
//           doc.defaultStyle.fontSize = 11;
//           doc["footer"] = function (page, pages) {
//             return {
//               columns: [
//                 {
//                   alignment: "left",
//                   text: [{ text: jsDate.toString() }],
//                 },
//                 {
//                   alignment: "right",
//                   text: [
//                     "Página ",
//                     { text: page.toString() },
//                     " de ",
//                     { text: pages.toString() },
//                   ],
//                 },
//               ],
//               margin: 15,
//             };
//           };
//           doc.styles.title = {
//             color: "blue",
//             fontSize: "30",
//             alignment: "center",
//           };
//           doc.styles["td:nth-child(2)"] = {
//             width: "auto",
//             "max-width": "auto",
//             fontSize: "20",
//             alignment: "center",
//           };
//         },
//       },
//       {
//         //Botón para Excel
//         extend: "print",
//         footer: true,
//         title: "Archivo",
//         filename: "Export_File",

//         //Aquí es donde generas el botón personalizado
//         text: '<i class="fas fa-print"></i>',
//         className: "btn-secondary",
//       },
//     ],
//     orderCellsTop: true,
//     fixedHeader: true,
//     initComplete: function () {
//       var api = this.api();

//       // For each column
//       api
//         .columns()
//         .eq(0)
//         .each(function (colIdx) {
//           // Set the header cell to contain the input element
//           var cell = $(".filters th").eq(
//             $(api.column(colIdx).header()).index()
//           );
//           var title = $(cell).text();
//           $(cell).html(
//             '<input type="text" class="form-control shadow-none border text-center p-0 border-0" placeholder="Buscar..." style="height:25px" />'
//           );

//           // On every keypress in this input
//           $(
//             "input",
//             $(".filters th").eq($(api.column(colIdx).header()).index())
//           )
//             .off("keyup change")
//             .on("keyup change", function (e) {
//               e.stopPropagation();

//               // Get the search value
//               $(this).attr("title", $(this).val());
//               var regexr = "({search})"; //$(this).parents('th').find('select').val();

//               var cursorPosition = this.selectionStart;
//               // Search the column for that value
//               api
//                 .column(colIdx)
//                 .search(
//                   this.value != ""
//                     ? regexr.replace("{search}", "(((" + this.value + ")))")
//                     : "",
//                   this.value != "",
//                   this.value == ""
//                 )
//                 .draw();

//               $(this)
//                 .focus()[0]
//                 .setSelectionRange(cursorPosition, cursorPosition);
//             });
//         });
//     },
//     language: {
//       sProcessing: "Procesando...",
//       sLengthMenu: "Mostrar _MENU_",
//       sZeroRecords: "No hay resultados para esa búsqueda",
//       sEmptyTable: "No hay datos disponibles",
//       sInfo: "Registros del _START_ al _END_",
//       sInfoEmpty: "0 al 0",
//       sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
//       sInfoPostFix: "",
//       sSearch: "Buscar:",
//       sUrl: "",
//       sInfoThousands: ",",
//       sLoadingRecords: "Cargando...",
//       oPaginate: {
//         sFirst: "Primero",
//         sLast: "Último",
//         sNext: ">",
//         sPrevious: "<",
//       },
//       oAria: {
//         sSortAscending:
//           ": Activar para ordenar la columna de manera ascendente",
//         sSortDescending:
//           ": Activar para ordenar la columna de manera descendente",
//       },
//     },
//   });
// });

$(document).on("click", ".btnVerLista", function () {
  var vende = $(this).attr("idvendidopor");
  var fecha = $(this).attr("fecha");
  var idsorteo = $(this).attr("idsorteo");
  //console.log(idVer);
  console.log(vende);
  console.log(fecha);
  console.log(idsorteo);

  $(".btnVerLista").attr("disabled", true);

  $(".verNum").remove();
  $(".verMonto").remove();
  $(".verPremio").remove();
  $(".txt-rcb").remove();

  var datos = new FormData();
  datos.append("vende", vende);
  datos.append("fecha", fecha);
  datos.append("idsorteo", idsorteo);

  $.ajax({
    url: "ajax/listas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      //console.log(respuesta["id"]);
      $(".btnVerLista").attr("disabled", false);
      var res = JSON.parse(respuesta);
      console.log(res);
      /* let suma = 0; */

      //console.log(respuesta);
      $("#elvende").append(
        '<div class="text-center font-weight-bold text-warning txt-rcb">Vendedor: ' +
          res[0]["nombre"] +
          "</div>"
      );

      $("#elvende").append(
        '<div class="text-center font-weight-bold text-warning txt-rcb">Fecha: ' +
          res[0]["fechax"] +
          "</div>"
      );

      $("#elvende").append(
        '<div class="text-center font-weight-bold text-warning txt-rcb">Sorteo: ' +
          res[0]["sorteo"] +
          "</div>"
      );

      for (let index = 0; index < res.length; index++) {
        const element = res[index];
        //console.log(element);
        //suma = suma + lo[index][3];

        $("#viendoLista").append(
          '<input type="number" class="text-center col-4 form-control shadow-none border-0 verNum" name="regNumero" value="' +
            res[index]["numero"] +
            '">' +
            '<input type="number" class="text-center col-4 form-control shadow-none border-0 verMonto" name="regMonto" value="' +
            res[index]["monto"] +
            '">' +
            '<input type="number" class="text-center col-4 form-control shadow-none border-0 verPremio" name="regPremio" value="' +
            res[index]["premio"] +
            '">'
        );
      }
    },
  });
});
