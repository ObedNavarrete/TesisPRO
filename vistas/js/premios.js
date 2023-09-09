$(document).ready(function () {
  $(".tablaPremios thead tr")
    .clone(true)
    .addClass("filters")
    .appendTo(".tablaPremios thead");

  var table = $(".tablaPremios").DataTable({
    ajax: "ajax/tablaPremios.ajax.php",
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
        download: "open",
        text: '<i class="far fa-file-pdf"></i>',
        className: "btn-danger",
        messageTop: "Catálogo de Números",
        title: "RIFA DÍAZ",
        exportOptions: {
          columns: [0, 1],
        },
        customize: function (doc) {
          var now = new Date();
					var jsDate = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();

          doc.content[2].table.widths = ["50%", "50%"];
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

  //Editar Usuario
  $(document).on("click", ".editarInversion", function () {
    var idInversion = $(this).attr("idInversion");
    //console.log(idInversion);

    var datos = new FormData();
    datos.append("idInve", idInversion);

    $.ajax({
      url: "ajax/updatePremios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        //console.log(respuesta);
        $('input[name="editarId"]').val(respuesta["id"]);
        $('input[name="editarInversion"]').val(respuesta["inversion"]);
        $('input[name="editarPremio"]').val(respuesta["premio"]);
      },
    });
  });

  //Eliminar Usuario
  $(document).on("click", ".btnEliminar", function () {
    var idNumero = $(this).attr("id-inversion");

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
        datos.append("idEliminar", idNumero);

        $.ajax({
          url: "ajax/updatePremios.ajax.php",
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
                title: "Eliminado Exitosamente",
                showConfirmButton: false,
                timer: 2000,
              });
              tablaPremios.ajax.reload(null, false);
              window.location.reload();
            }
          },
        });
      }
    });
  });
});
