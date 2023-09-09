let inputGanador = document.querySelector("#registroGanador");
inputGanador.addEventListener("input", (e) => {
  let idNumero = e.target.value;
  if (idNumero >= 0 && idNumero < 100) {
    var datos = new FormData();
    datos.append("idNumero", idNumero);

    $.ajax({
      url: "ajax/updateGanador.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $('input[name="registroPremio"]').val(respuesta["premio"]);
        $('input[name="registroInversion"]').val(respuesta["inversion"]);
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
    $('input[name="registroGanador"]').val("");
    $('input[name="registroInversion"]').val("");
    $('input[name="registroPremio"]').val("");
  }
});

$(document).ready(function () {
  $('.tablaGanadores thead tr:eq(1) th').each(function() {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Buscar" class="column_search" />');
  });
  var table = $('.tablaGanadores').DataTable({
    ajax: "ajax/ganadores.ajax.php",
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
        columns: [1, 2, 3, 4, 5, 6],
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
  $('.tablaGanadores thead').on('keyup', ".column_search", function() {
    table
      .column($(this).parent().index())
      .search(this.value)
      .draw();
  });
});


$(document).on("click", ".btnResumen", function () {
  var idnumero = $(this).attr("idnumero");
  var fecha = $(this).attr("fecha");
  var idsorteo = $(this).attr("idsorteo");
  //console.log(idVer);
/*   console.log(idnumero);
  console.log(fecha);
  console.log(idsorteo); */

  var fechass = fecha.substring(0, 10);
  if (idsorteo == 1) {
    var ts = "Mañana";
  }
  if (idsorteo == 2) {
    var ts = "Tarde";
  }
  if (idsorteo == 3) {
    var ts = "Noche";
  }
  /*   $(".btnVerRecibo").attr("disabled", true); */

  $(".verNum").remove();
  $(".verMonto").remove();
  $(".verPremio").remove();
  $(".txt-rcb").remove();

  var datos = new FormData();
  datos.append("idnumero", idnumero);
  datos.append("fecha", fecha);
  datos.append("idsorteo", idsorteo);

  $.ajax({
    url: "ajax/resumenGana.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      //console.log(respuesta["id"]);
      /* $(".btnVerRecibo").attr("disabled", false); */
      var res = JSON.parse(respuesta);
      //console.log(res);
      /* let suma = 0; */

      //console.log(respuesta);
      $("#sorteo").append(
        '<div class="text-center font-weight-bold text-warning txt-rcb">' +
          fechass +
          "</div>"
      );

      $("#sorteo").append(
        '<div class="text-center font-weight-bold text-warning txt-rcb">' +
          ts +
          "</div>"
      );

      $("#sorteo").append(
        '<div class="text-center font-weight-bold text-warning txt-rcb">' +
          idnumero +
          "</div>"
      );

      for (let index = 0; index < res.length; index++) {
        const element = res[index];
        //console.log(element);
        //suma = suma + lo[index][3];

        $("#viendoLista").append(
          '<input type="number" class="text-center col-4 form-control shadow-none border-0 verNum" name="regNumero" value="' +
            res[index]["ruta"] +
            '">' +
            '<input type="number" class="text-center col-4 form-control shadow-none border-0 verMonto" name="regMonto" value="' +
            res[index]["ventas"] +
            '">' +
            '<input type="number" class="text-center col-4 form-control shadow-none border-0 verPremio" name="regPremio" value="' +
            res[index]["premio"] +
            '">'
        );
      }
    },
  });
});