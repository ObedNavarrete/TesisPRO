$(document).ready(function() {
  $('.tablaVentasVendedor thead tr:eq(1) th').each(function() {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Buscar" class="column_search" />');
  });
  var table = $('.tablaVentasVendedor').DataTable({
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
      messageTop: "Listado de Recibos",
      title: "RIFA DÍAZ",
      exportOptions: {
        columns: [1, 2, 3, 4, 5],
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
  $('.tablaVentasVendedor thead').on('keyup', ".column_search", function() {
    table
      .column($(this).parent().index())
      .search(this.value)
      .draw();
  });
});

//Eliminar Usuario
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
        url: "ajax/edit.updateVender.ajax.php",
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

$(document).on("click", ".btnVerRecibo", function () {
  $(".btnVerRecibo").attr("disabled", true);
  var idVer = $(this).attr("id-ver");
  //console.log(idVer);

  $(".verNum").remove();
  $(".verMonto").remove();
  $(".verPremio").remove();
  $(".txt-rcb").remove();

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
      $("#cod-rcb").append(
        '<div class="text-center font-weight-bold text-warning txt-rcb">cod: ' + lo[0][2] + ' / ' + lo[0][1] + '</div>'
      );

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

        $(".btnVerRecibo").attr("disabled", false);
      }
    },
  });
});
