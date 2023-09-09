$(document).ready(function () {
  $(document).on("click", ".btnDarPermiso", function () {
    var user = $(this).attr("user");
    var estado = $(this).attr("estado");

    console.log(user);
    console.log(estado);

    var datos = new FormData();
    datos.append("user", user);
    datos.append("estado", estado);

    $.ajax({
      url: "ajax/permiso-impresion.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "El permiso ha cambiado",
          showConfirmButton: false,
          timer: 1000,
        });

        location.reload();
      },
    });

    if (estado == 1) {
      $(this).removeClass("btn-success");
      $(this).addClass("btn-danger");
      $(this).html("SI");
      $(this).attr("estado", 0);
    } else {
      $(this).addClass("btn-success");
      $(this).removeClass("btn-danger");
      $(this).html("NO");
      $(this).attr("estado", 1);
    }
  });
});
