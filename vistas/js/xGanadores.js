let inputGanador = document.querySelector("#xRegistroGanadorLoteria");
inputGanador.addEventListener("input", (e) => {
  let idNumero = e.target.value;
  if (idNumero >= 0 && idNumero < 100) {
    var datos = new FormData();
    datos.append("idNumero", idNumero);

    $.ajax({
      url: "ajax/xUpdateGanador.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $('input[name="xRegistroPremioLoteria"]').val(respuesta["premio"]);
        $('input[name="xRegistroInversionLoteria"]').val(
          respuesta["inversion"]
        );
      },
    });
  } else {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "ERROR: El número ganador debe estar entre 00 y 99!",
      showConfirmButton: false,
      timer: 1500,
    });
    $('input[name="xRegistroGanadorLoteria"]').val("");
    $('input[name="xRegistroInversionLoteria"]').val("");
    $('input[name="xRegistroPremioLoteria"]').val("");
  }
});

$(document).ready(function () {
  $(".tablaGanadoresLoteria thead tr")
    .clone(true)
    .addClass("filters")
    .appendTo(".tablaGanadoresLoteria thead");

  var table = $(".tablaGanadoresLoteria").DataTable({
    ajax: "ajax/xGanadores.ajax.php",
    deferRender: true,
    searching: true,
    retrieve: true,
    order: [[0, "desc"]],
    pageLength: 25,
    procesing: true,
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
        download: "open",
        text: '<i class="far fa-file-pdf"></i>',
        className: "btn-danger",
        messageTop: "Listado de Premios Máximos de Números por Vendedor",
        title: "RIFA DÍAZ",
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7],
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
