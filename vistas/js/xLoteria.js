let inputNumero = document.querySelector("#registroNumeroLoteria");
inputNumero.addEventListener("change", (e) => {
  let idNumero = $("#registroNumeroLoteria").val();

  let diadehoy = $("#diadehoy").val();
  var ajaxEnviado;
  if (diadehoy == 2) {
    ajaxEnviado = "ajax/admin.updateVentasLimiteLoteria.ajax.php";
  } else {
    ajaxEnviado = "ajax/admin.updateVentasLimite.ajax.php";
  }


  //console.log(idNumero);
  var datos = new FormData();
  datos.append("idNumero", idNumero);

  $.ajax({
    url: "ajax/xLoteria.updateVender.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      let soluc = respuesta["inversion"];
      /* console.log(soluc); */
      if (soluc != undefined) {
        $('input[name="registroActualNumLoteria"]').val(soluc);
        //console.log(soluc);
      } else {
        $('input[name="registroActualNumLoteria"]').val(0);
      }
    },
  }),
    $.ajax({
      url: String(ajaxEnviado),
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
          $('input[name="registroMaximoLoteria"]').val(maxim);
        } else {
          $('input[name="registroMaximoLoteria"]').val("");
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
          $('input[name="registroPasivoLoteria"]').val(pas);
        } else {
          $('input[name="registroPasivoLoteria"]').val("");
        }
      },
    });
});

// let inputInversion = document.querySelector("#registroInversionLoteria");
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
//         $('input[name="registroPremioLoteria"]').val(premioCorresponde);
//         $('input[name="regIdInversionLoteria"]').val(idInv);
//       } else {
//         $('input[name="registroPremioLoteria"]').val("");
//       }
//     },
//   });
// });

$("#agregarElementoLoteria").click(function () {
  let idInversion = $("#registroInversionLoteria").val();
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
      let premioCorresponde = respuesta["premio"];
      let idInv = respuesta["id"];

      if (premioCorresponde != undefined) {
        let pasivo = $("#registroPasivoLoteria").val();
  let numero = $("#registroNumeroLoteria").val();
  let inversion = $("#registroInversionLoteria").val();
  let sorteo = $("#registroSorteoLoteria").val();
  let actualNum = $("#registroActualNumLoteria").val();
  let maximo = $("#registroMaximoLoteria").val();
  let premio = premioCorresponde;
  let usuario = $("#registroUsuarioLoteria").val();

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
    var numeItem = $(".arrayNumeroLoteria");
    var arrayNumeroLoteria = [];
    var ultimo = $("#registroNumeroLoteria").val();
    for (var i = 0; i < numeItem.length; i++) {
      arrayNumeroLoteria.push($(numeItem[i]).val());
    }
    var resulta = arrayNumeroLoteria.includes(ultimo);

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
        '<input type="number" class="text-center col-4 form-control shadow-none border-0 arrayNumeroLoteria" readonly name="regNumero" value="' +
          numero +
          '">' +
          '<input type="number" class="text-center col-4 form-control shadow-none border-0 arrayMontoLoteria" readonly name="regMonto" value="' +
          inversion +
          '">' +
          '<input type="number" class="text-center col-4 form-control shadow-none border-0 arrayPremioLoteria" readonly name="regPremio" value="' +
          premio +
          '">' +
          '<input type="hidden" class="text-center col-4 form-control shadow-none border-0 arrayUsuarioLoteria" readonly name="regUsuario" value="' +
          usuario +
          '">' +
          '<input type="hidden" class="text-center col-4 form-control shadow-none border-0 arraySorteoLoteria" readonly name="regSorteo" value="' +
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
        $('input[name="registroPremioLoteria"]').val("");
      }
    },
  });
});

function sumarTotalRecibo() {
  var precioItem = $(".arrayMontoLoteria");
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
  var listaVentaLoteria = [];
  var okNumero = $(".arrayNumeroLoteria");
  var okMonto = $(".arrayMontoLoteria");
  var okPremio = $(".arrayPremioLoteria");
  var okUsuario = $(".arrayUsuarioLoteria");
  var okSorteo = $(".arraySorteoLoteria");
  var okRecibo = $("#regReciboLoteria");

  for (var i = 0; i < okNumero.length; i++) {
    listaVentaLoteria.push({
      numero: $(okNumero[i]).val(),
      inversion: $(okMonto[i]).val(),
      premio: $(okPremio[i]).val(),
      idUsuario: $(okUsuario[i]).val(),
      idSorteo: $(okSorteo[i]).val(),
      recibo: $(okRecibo).val(),
    });
  }

  //console.log(listaVentaLoteria);
  $("#arrayParaVenderLoteria").val(JSON.stringify(listaVentaLoteria));
}

function limpiarPantalla() {
  $("#registroPasivoLoteria").val("");
  $("#registroNumeroLoteria").val("");
  $("#registroInversionLoteria").val("");
  $("#registroActualNumLoteria").val("");
  $("#registroMaximoLoteria").val("");
  $("#registroPremioLoteria").val("");
}

function limpiarReciboLoteria() {
  var nu = $(".arrayNumeroLoteria");
  var mo = $(".arrayMontoLoteria");
  var pre = $(".arrayPremioLoteria");
  var us = $(".arrayUsuarioLoteria");
  var sor = $(".arraySorteoLoteria");
  var to = $(".totalisimoLoteria");

  nu.remove();
  mo.remove();
  pre.remove();
  us.remove();
  sor.remove();
  $(".totalisimo").val(0);
}

$("#limpiarReciboLoteria").click(function () {
  limpiarReciboLoteria();
});
