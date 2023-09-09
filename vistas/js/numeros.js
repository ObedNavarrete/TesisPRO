$(document).ready(function () {
  //Editar Usuario
  $(document).on("click", ".editarNumero", function () {
    var idNumero = $(this).attr("idNumero");
    console.log(idNumero);

    var datos = new FormData();
    datos.append("idNumero", idNumero);

    //La solicitud ajax se hace desde aqui porque el otro ajax ya esta retornando algo
    //Sirve para llenar los campos con el id seleccionado en el actual
    $.ajax({
      url: "ajax/updateNumeros.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        console.log(respuesta);
        $('input[name="editarId"]').val(respuesta["id"]);
        $('input[name="editarNumero"]').val(respuesta["numero"]);
      },
    });
  });

  //Eliminar Usuario
  $(document).on("click", ".btnEliminar", function () {
    var idNumero = $(this).attr("id-numero");

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
          url: "ajax/updateNumeros.ajax.php",
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

              tablaNumeros.ajax.reload(null, false);
            }
          },
        });
      }
    });
  });

  /*=============================================
ACTIVAR NO
=============================================*/
  $(document).on("click", ".btnActivar", function () {
    var idNumero = $(this).attr("idNumero");
    var estadoNumero = $(this).attr("estadoNumero");

    console.log(idNumero);
    console.log(estadoNumero);

    var datos = new FormData();
    datos.append("activarId", idNumero);
    datos.append("activarNumero", estadoNumero);

    $.ajax({
      url: "ajax/updateNumeros.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "El estado del número ha cambiado",
          showConfirmButton: false,
          timer: 1000,
        });

        location.reload();
      },
    });

    if (estadoNumero == 1) {
      $(this).removeClass("btn-success");
      $(this).addClass("btn-danger");
      $(this).html("Inactivo");
      $(this).attr("estadoNumero", 1);
    } else {
      $(this).addClass("btn-success");
      $(this).removeClass("btn-danger");
      $(this).html("Activo");
      $(this).attr("estadoNumero", 0);
    }
  });
});
