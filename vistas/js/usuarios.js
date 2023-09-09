$(document).ready(function () {
    $(".tablaUsuarios thead tr")
    .clone(true)
    .addClass("filters")
    .appendTo(".tablaUsuarios thead");

  var table = $(".tablaUsuarios").DataTable({
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
        alignment: "center",
        messageTop: "Listado de Usuarios",
        title: "RIFA DÍAZ",
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
        customize: function (doc) {
          var now = new Date();
          var jsDate =
            now.getDate() +
            "/" +
            (now.getMonth() + 1) +
            "/" +
            now.getFullYear();

          doc.content[2].table.widths = ["30%", "20%", "20%", "10%", "20%"];
          doc.defaultStyle.alignment = "center";
          doc.styles.tableHeader.fontSize = 13;
          doc.defaultStyle.fontSize = 11;
          doc["footer"] = function (page, pages) {
            return {
              columns: [
                {
                  alignment: "left",
                  text: [{ text: jsDate.toString() }],
                },
                {
                  alignment: "right",
                  text: [
                    "Página ",
                    { text: page.toString() },
                    " de ",
                    { text: pages.toString() },
                  ],
                },
              ],
              margin: 15,
            };
          };
          doc.styles.title = {
            color: "black",
            fontSize: "30",
            alignment: "center",
          };
          doc.styles["td:nth-child(2)"] = {
            width: "100px",
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
  //Editar Usuario
  $(document).on("click", ".editarUsuario", function () {
    var idUsuario = $(this).attr("idUsuario");
    console.log(idUsuario);

    var datos = new FormData();
    datos.append("idUsuario", idUsuario);

    //La solicitud ajax se hace desde aqui porque el otro ajax ya esta retornando algo
    //Sirve para llenar los campos con el id seleccionado en el actual
    $.ajax({
      url: "ajax/updateUsuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        console.log(respuesta);
        $('input[name="editarId"]').val(respuesta["id"]);
        $('input[name="editarNombre"]').val(respuesta["nombre"]);
        $('input[name="editarUsuario"]').val(respuesta["usuario"]);
        $('input[name="editarPassword"]').val("");

        $(".editarTablaOption").val(respuesta["idTabla"]);
        if (respuesta["idTabla"] == 1) {
          $(".editarTablaOption").html("400 x 5");
        } else {
          $(".editarTablaOption").html("350 x 5");
        }

        $(".editarPerfilOption").val(respuesta["idRol"]);
        $(".editarPerfilOption").html(respuesta["rol"]);

        $(".editarRutaOption").val(respuesta["idRuta"]);
        $(".editarRutaOption").html(respuesta["ruta"]);

        /* nueva seccion 01112021*/
        if (respuesta["idRol"] == 2) {
          $(".body-form-edit").append(
            "<div class='etpremio'>" +
              '<div class="text-center">Desea modificar el límite de Ventas?</div>' +
              "</div>" +
              '<div class="input-group mb-3">' +
              '<select class="form-control shadow-none border text-center" id="eLim" required>' +
              '<option value="1" default>NO</option>' +
              '<option value="2">SI</option>' +
              "</select>" +
              "</div>"
          );
        } else {
          if ($(".etpremio").length) {
            document.querySelector(".etpremio").remove();
          }
          if ($("#eLim").length) {
            document.querySelector("#eLim").remove();
          }
        }
        /* nueva seccion */
      },
    });
  });

    $(document).on("change", "#eLim", function () {
    var modificar = $(this).val();
    console.log(modificar);

    if (modificar == 2) {
      $(".body-form-edit").append(
        '<div class="input-group mb-3 seccEditLim">' +
          '<input type="number" class="form-control shadow-none border text-center" name="editarLimite" placeholder="Nuevo Límite" require>' +
          "</div>"
      );
    } else {
      if ($(".seccEditLim").length) {
        $(".seccEditLim").remove();
      }
    }
  });

  //Eliminar Usuario
  $(document).on("click", ".btnEliminar", function () {
    var idUsuario = $(this).attr("id-usuario");

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
        if (idUsuario == 1) {
          Swal.fire({
            icon: "error",
            title: "Oye...",
            text: "Este usuario no puede ser eliminado!",
            showConfirmButton: false,
            timer: 1500,
          });

          return;
        }

        var datos = new FormData();
        datos.append("idEliminar", idUsuario);

        $.ajax({
          url: "ajax/updateUsuarios.ajax.php",
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

  $("#registroRol").change(function () {
    let idRol = $(this).val();
    //console.log(idRol);
    let im = document.querySelector("#inputmodal");

    if (idRol != 2) {
      if ($("#agr").length) {
        document.querySelector("#agr").remove();
      }
      if ($(".dentroTabla").length) {
        document.querySelector(".dentroTabla").remove();
      }
    } else {
      let z = document.createElement("div");
      z.classList.add("input-group");
      z.classList.add("mb-3");
      z.id = "agr";

      let inp =
        "<input type='number' class='form-control shadow-none border text-center' name='registroLimite' placeholder='Límite de ventas' require>";
      z.innerHTML = inp;

      im.appendChild(z);

      $("#tablaDePremio").append(
        "<select class='form-control shadow-none border text-center dentroTabla' id='registroTabla' name='registroTabla' required>" +
          "<option value='default' selected='selected'>Seleccione la tabla de Premios del usuario</option>" +
          "<option value='1'>400 x 5</option>" +
          "<option value='2'>350 x 5</option>" +
          "</select>"
      );
    }
  });
});
