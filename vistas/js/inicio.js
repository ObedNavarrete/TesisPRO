// let inputNumero = document.querySelector("#registroNumero");
// inputNumero.addEventListener("input", (e) => {
//   let idNumero = e.target.value;
//   var datos = new FormData();
//   datos.append("idNumero", idNumero);

//   $.ajax({
//     url: "ajax/edit.updateVender.ajax.php",
//     method: "POST",
//     data: datos,
//     cache: false,
//     contentType: false,
//     processData: false,
//     dataType: "json",
//     success: function (respuesta) {
//       //console.log(respuesta);
//       let soluc = respuesta["inversion"];
//       /* console.log(soluc); */
//       if (soluc != undefined) {
//         $('input[name="registroActualNum"]').val(soluc);
//         console.log(soluc);
//       } else {
//         $('input[name="registroActualNum"]').val(0);
//       }
//     },
//   }),
//     $.ajax({
//       url: "ajax/admin.updateVentasLimite.ajax.php",
//       method: "POST",
//       data: datos,
//       cache: false,
//       contentType: false,
//       processData: false,
//       dataType: "json",
//       success: function (respuesta) {
//         let maxim = respuesta["limite"];
//         //console.log(respuesta);
//         if (maxim != undefined) {
//           $('input[name="registroMaximo"]').val(maxim);
//         } else {
//           $('input[name="registroMaximo"]').val("");
//         }
//       },
//     }),
//     $.ajax({
//       url: "ajax/updateNumeros.ajax.php",
//       method: "POST",
//       data: datos,
//       cache: false,
//       contentType: false,
//       processData: false,
//       dataType: "json",
//       success: function (respuesta) {
//         //console.log(respuesta);
//         let pas = respuesta["pasivo"];
//         if (pas != undefined) {
//           $('input[name="registroPasivo"]').val(pas);
//         } else {
//           $('input[name="registroPasivo"]').val("");
//         }
//       },
//     });
// });

$("#registroNumero").change(function () {
  let idNumero = $("#registroNumero").val();
  var datos = new FormData();
  datos.append("idNumero", idNumero);

  $.ajax({
    url: "ajax/edit.updateVender.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      //console.log(respuesta);
      let soluc = respuesta["inversion"];
      /* console.log(soluc); */
      if (soluc != undefined) {
        $('input[name="registroActualNum"]').val(soluc);
        //console.log(soluc);
      } else {
        $('input[name="registroActualNum"]').val(0);
      }
    },
  }),
    $.ajax({
      url: "ajax/admin.updateVentasLimite.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        let maxim = respuesta["limite"];
        //console.log(respuesta);
        if (maxim != undefined) {
          $('input[name="registroMaximo"]').val(maxim);
        } else {
          $('input[name="registroMaximo"]').val(0);
        }
      },
    }),
    $.ajax({
      url: "ajax/updateNumeros.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        //console.log(respuesta);
        let pas = respuesta["pasivo"];
        if (pas != undefined) {
          $('input[name="registroPasivo"]').val(pas);
        } else {
          $('input[name="registroPasivo"]').val("");
        }
      },
    });
});

// let inputInversion = document.querySelector("#registroInversion");
// inputInversion.addEventListener("input", (e) => {
//   let idInversion = e.target.value;
//   //console.log("xx: ", idInversion);
//   var datos = new FormData();
//   datos.append("idInversion", idInversion);

//   $.ajax({
//     url: "ajax/updatePremios.ajax.php",
//     method: "POST",
//     data: datos,
//     cache: false,
//     contentType: false,
//     processData: false,
//     dataType: "json",
//     success: function (respuesta) {
//       let premioCorresponde = respuesta["premio"];
//       let idInv = respuesta["id"];

//       if (premioCorresponde != undefined) {
//         $('input[name="registroPremio"]').val(premioCorresponde);
//         $('input[name="regIdInversion"]').val(idInv);
//       } else {
//         $('input[name="registroPremio"]').val("");
//       }
//     },
//   });
// });

$("#agregarElemento").click(function () {
  let idInversion = $("#registroInversion").val();
  var datos = new FormData();
  datos.append("idInversion", idInversion);
  $.ajax({
    url: "ajax/updatePremios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      let premioCorresponde = respuesta["premio"];
      let idInv = respuesta["id"];

      if (premioCorresponde != undefined) {
          let pasivo = $("#registroPasivo").val();
  let numero = $("#registroNumero").val();
  let inversion = $("#registroInversion").val();
  let sorteo = $("#registroSorteo").val();
  let actualNum = $("#registroActualNum").val();
  let maximo = $("#registroMaximo").val();
  let premio = premioCorresponde;
  let usuario = $("#registroUsuario").val();

  let aactualNum = Number(actualNum);
  let apremio = Number(premio);
  let amaximo = Number(maximo);

  if (pasivo == 1) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "ERROR: El number seleccionado no está disponible!",
      showConfirmButton: false,
      timer: 1500,
    });

    limpiarPantalla();
  } else {
    var numeItem = $(".arrayNumero");
    var arrayNumero = [];
    var ultimo = $("#registroNumero").val();
    for (var i = 0; i < numeItem.length; i++) {
      arrayNumero.push($(numeItem[i]).val());
    }
    var resulta = arrayNumero.includes(ultimo);

    if (
      inversion.match(/^[0-9]+$/) &&
      premio.match(/^[0-9]+$/) &&
      numero.match(/^[0-9]+$/) &&
      inversion != "" &&
      premio != "" &&
      numero != "" &&
      actualNum != "" &&
      maximo != "" &&
      Number(aactualNum + apremio) <= Number(amaximo) &&
      resulta == false
    ) {
      $(".nuevaVenta").append(
        '<input type="number" class="text-center col-4 form-control shadow-none border-0 arrayNumero" readonly name="regNumero" value="' +
          numero +
          '">' +
          '<input type="number" class="text-center col-4 form-control shadow-none border-0 arrayMonto" readonly name="regMonto" value="' +
          inversion +
          '">' +
          '<input type="number" class="text-center col-4 form-control shadow-none border-0 arrayPremio" readonly name="regPremio" value="' +
          premio +
          '">' +
          '<input type="hidden" class="text-center col-4 form-control shadow-none border-0 arrayUsuario" readonly name="regUsuario" value="' +
          usuario +
          '">' +
          '<input type="hidden" class="text-center col-4 form-control shadow-none border-0 arraySorteo" readonly name="regSorteo" value="' +
          sorteo +
          '">'
      );

      sumarTotalRecibo();
      listarVentas();

      limpiarPantalla();
    } else {
      if (Number(aactualNum + apremio) > Number(amaximo)) {
        Swal.fire({
          position: "center",
          icon: "error",
          title:
            "ERROR: Con este premio, sobrepasa el límite de ventas de este número!",
          showConfirmButton: false,
          timer: 1500,
        });

        limpiarPantalla();
      } else if (Number(aactualNum) > Number(amaximo)) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "ERROR: Ha superado su límite de ventas para este número!",
          showConfirmButton: false,
          timer: 1500,
        });

        limpiarPantalla();
      } else if (numero < 0 || numero > 99) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "ERROR: El número debe ser mayor a 0 y menor a 100!",
          showConfirmButton: false,
          timer: 1500,
        });

        limpiarPantalla();
      } else if (resulta == true) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "ERROR: El número ya existe en este recibo!",
          showConfirmButton: false,
          timer: 1500,
        });

        limpiarPantalla();
      } else {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "ERROR: Hay campos vacíos!",
          showConfirmButton: false,
          timer: 1500,
        });

        limpiarPantalla();
      }
    }
  }
      } else {
        $('input[name="registroPremio"]').val("");
      }
    },
  });



});

function sumarTotalRecibo() {
  var precioItem = $(".arrayMonto");
  var arraySumaPrecio = [];
  var suma = 0;
  //console.log(precioItem);
  for (var i = 0; i < precioItem.length; i++) {
    arraySumaPrecio.push(Number($(precioItem[i]).val()));
    suma = suma + Number($(precioItem[i]).val());
  }
  /* console.log(arraySumaPrecio);
  console.log(suma); */
  $(".totalisimo").val(suma);
}

function listarVentas() {
  var listaVenta = [];
  var okNumero = $(".arrayNumero");
  var okMonto = $(".arrayMonto");
  var okPremio = $(".arrayPremio");
  var okUsuario = $(".arrayUsuario");
  var okSorteo = $(".arraySorteo");
  var okRecibo = $("#regRecibo");

  for (var i = 0; i < okNumero.length; i++) {
    listaVenta.push({
      numero: $(okNumero[i]).val(),
      inversion: $(okMonto[i]).val(),
      premio: $(okPremio[i]).val(),
      idUsuario: $(okUsuario[i]).val(),
      idSorteo: $(okSorteo[i]).val(),
      recibo: $(okRecibo).val(),
    });
  }

  //console.log(listaVenta);
  $("#arrayParaVender").val(JSON.stringify(listaVenta));
}

function limpiarPantalla() {
  $("#registroPasivo").val("");
  $("#registroNumero").val("");
  $("#registroInversion").val("");
  $("#registroActualNum").val("");
  $("#registroMaximo").val("");
  $("#registroPremio").val("");
}

function limpiarRecibo() {
  var nu = $(".arrayNumero");
  var mo = $(".arrayMonto");
  var pre = $(".arrayPremio");
  var us = $(".arrayUsuario");
  var sor = $(".arraySorteo");
  var to = $(".totalisimo");

  nu.remove();
  mo.remove();
  pre.remove();
  us.remove();
  sor.remove();
  $(".totalisimo").val(0);
}

$("#limpiarRecibo").click(function () {
  limpiarRecibo();
});
