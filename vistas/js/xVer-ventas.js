$(document).ready(function () {
  $(".tablaVentasVendedorLoteria thead tr")
    .clone(true)
    .addClass("filters")
    .appendTo(".tablaVentasVendedorLoteria thead");

  var table = $(".tablaVentasVendedorLoteria").DataTable({
    deferRender: true,
    searching: true,
    retrieve: true,
    pageLength: 25,
    order: [[0, "desc"]],
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
          columns: [0, 1, 2, 3, 4],
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

//Eliminar Recibo Loteria
$(document).on("click", ".btnEliminar", function () {
  var idVenta = $(this).attr("id-venta");
  console.log(idVenta);

  Swal.fire({
    title: "Estás seguro?",
    text: "No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, elimínalo!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      var datos = new FormData();
      datos.append("idEliminar", idVenta);

      $.ajax({
        url: "ajax/xLoteria.updateVender.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Registro Eliminado Correctamente",
              showConfirmButton: false,
              timer: 2000,
            });

            window.location.reload();
          }
        },
      });
    }
  });
});

$(document).on("click", ".btnVerReciboLoteria", function () {
  $(".btnVerReciboLoteria").attr("disabled", true);
  var idVer = $(this).attr("id-ver");
  //console.log(idVer);

  $(".verNum").remove();
  $(".verMonto").remove();
  $(".verPremio").remove();

  var datos = new FormData();
  datos.append("idVer", idVer);

  $.ajax({
    url: "ajax/xLoteria.updateVender.ajax.php",
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

      for (let index = 0; index < lo.length; index++) {
        const element = lo[index];
        console.log(element);
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
        $(".btnVerReciboLoteria").attr("disabled", false);
      }
    },
  });
});
