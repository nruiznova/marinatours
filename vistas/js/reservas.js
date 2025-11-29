// boton agregar eliminar

$("#addPerson").click(function(){

  var valor = $('[name="cantidad-personas"]').val()

  $('[name="cantidad-personas"]').val(parseInt(valor) + 1)

  $('[name="cantidad-personas"]').trigger("change")

})

$("#delPerson").click(function(){

  var valor = $('[name="cantidad-personas"]').val()

  if(valor > 1){

    $('[name="cantidad-personas"]').val(parseInt(valor) - 1)

    $('[name="cantidad-personas"]').trigger("change")

  }  

})

// mostrar calendario

$("#showCalendar").click(function(){

  // console.log("hola")

  $('.datepicker').datepicker('show')

})

// fecha

$("#completarDatosReserva").click(function(){ 

  // alert("hola")

  var codigoReserva = $("#codigoReserva").val()

  listarAcompañantes()

  var kidsAnt = $("#cantidadKids").val()
  var tipo = $('#containerAcompañantes [class*="typeGuest"]')

  var kids = 0;

  for (let i = 0; i < tipo.length; i++) {
    
    if($(tipo[i]).is(":checked")){

      kids++;

    }
    
  }

  // console.log(kids, kidsAnt)

  if(Number(kids) == Number(kidsAnt)){

  }else{
    swal.fire({
      type: "error",
      title: "¡ERROR!",
      text: "La cantidad de niños no coincide con los datos de la reserva",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"	
    });

    return;
  }
  
  var acompañantes = $(".acompañantesReserva").val()
  var idReserva = $("#idReserva").val()
  var codigoReserva = $("#codigoReserva").val()

  var forms = document.getElementsByClassName('needs-validation');

  //$(".needs-validation").submit()

  // Loop over them and prevent submission
  var validation = Array.prototype.filter.call(forms, function(form) {    
    form.classList.add('was-validated');
  });

  var items = $("#containerAcompañantes input, select")

  var faltantes = 0;

  $(items).each(function(){

    var el = $(this)    

    // console.log(el, $(el).attr("required"))

    if($(el).attr("required") == "required"){      

      if($(el).val() == ''){

        faltantes++;

      }

    }

  })

  // console.log(faltantes)

  if(faltantes > 0){
    swal.fire({
      type: "error",
      title: "¡ERROR!",
      text: "Complete todos los campos obligatorios",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"	
    });

    return;

  }  

  // console.log("hola")

  listarAcompañantes()

  var datos = new FormData();
  datos.append("idCompletarDatos", idReserva)
  datos.append("acompañantes", acompañantes)

  $.ajax({ 

    url:urlPrincipal+"ajax/reservas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){

      if(respuesta == "ok"){        

        $.ajax({
          url: urlPrincipal + "ajax/enviar_pdf.ajax.php",
          method: "POST",
          data: {
            codigoReserva: codigoReserva
          },
          beforeSend: function() {
            $("#loader").fadeIn(); // Mostrar loader antes de enviar
          },
          success: function(r) {
            console.log("PDF enviado", r);
            $("#loader").fadeOut(); // Ocultar loader después de éxito
            window.location = urlPrincipal+"?pagina=reserva-exitosa&type=reserva&codigo="+codigoReserva+"&estado=completada"; 
          },
          error: function(err) {
            console.error("Error enviando PDF:", err);
            $("#loader").fadeOut(); // También ocultarlo si hay error
          }
        });

      }

    }

  })

})

var urlPrincipal = $("#urlPrincipal").val();
var urlServidor = $("#urlServidor").val()

var arrayDates = $("#arrayDates").val()

var array = arrayDates.split(';');

$('.datepicker.entrada').datepicker({
	startDate: '0d',
  datesDisabled: '0d',  
	format: 'dd-mm-yyyy',
	todayHighlight:true,
  autoclose: true,
  // beforeShowDay: function(date){
  //     var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
  //     return [ array.indexOf(string) == -1 ]
  // }
  datesDisabled: array
});

$('.datepicker.entrada').change(function(){

  $('.datepicker.salida').attr("readonly", false);
	
  var fechaEntrada = $(this).val();

	$('.datepicker.salida').datepicker({
		startDate: fechaEntrada,
		datesDisabled: fechaEntrada,
		format: 'yyyy-mm-dd'
	});

})

var disabledDates = [];

/*=============================================
SELECTS ANIDADOS
=============================================*/

// $(".selectTipoHabitacion").change(function(){

//   var ruta = $(this).val();

//   if(ruta != ""){

//     $(".selectTemaHabitacion").html("");

//   }else{

//     $(".selectTemaHabitacion").html('<option>Temática de habitación</option>')

//   }

//   var datos = new FormData();
//   datos.append("ruta", ruta);

//   $.ajax({

//     url:urlPrincipal+"ajax/habitaciones.ajax.php",
//     method: "POST",
//     data: datos,
//     cache: false,
//     contentType: false,
//     processData: false,
//     dataType:"json",
//     success:function(respuesta){

//       $("input[name='ruta']").val(respuesta[0]["ruta"]);
      
//       for(var i = 0; i < respuesta.length; i++){

//         $(".selectTemaHabitacion").append('<option value="'+respuesta[i]["id_h"]+'">'+respuesta[i]["estilo"]+'</option>')

//       }

//     }

//   })

// })

/*=============================================
CÓDIGO ALEATORIO
=============================================*/

var chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

function codigoAleatorio(chars, length){

  codigo = "";

  for(var i = 0; i < length; i++){

    rand = Math.floor(Math.random()*chars.length);
    codigo += chars.substr(rand, 1);
  
  }

  return codigo;

}

function onlyUnique(value, index, array) {
  return array.indexOf(value) === index;
}

/*=============================================
CALENDARIO
=============================================*/

if($(".infoReservas").html() != undefined){

  var idHabitacion = $(".infoReservas").attr("idHabitacion");
  var fechaIngreso = formatDate($(".infoReservas").attr("fechaIngreso"));
  var totalSolicitado = Number($(".infoReservas").attr("personas")) + Number($(".infoReservas").attr("kids"));

  verificarDisponibilidad(idHabitacion, fechaIngreso, totalSolicitado);

}

function verificarDisponibilidad(idServicio, fecha, totalSolicitado) {
  const datos = new FormData();
  datos.append("verificarDisponibilidad", true);
  datos.append("idServicio", idServicio);
  datos.append("fecha", fecha);

  $.ajax({
      url: urlPrincipal + "ajax/reservas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta) {

          let disponibles = parseInt(respuesta.disponibles || 0);

          if (disponibles < 1 || disponibles < totalSolicitado) {
              $(".infoDisponibilidad")
                  .text("LO SENTIMOS, SOLO HAY " + disponibles + " CUPOS DISPONIBLES")
                  .addClass("text-danger");

              $(".containerCodigoReserva").removeClass("d-flex").addClass("d-none");
              $(".formDataBooking").hide();
              $(".resposeBookingAvailability").show();
              $(".responsePlaces").html("Solo hay " + disponibles + " cupos disponibles");
              $("#btnPagar").hide();

          } else {
              $(".infoDisponibilidad")
                  .text("Hay " + disponibles + " cupos disponibles")
                  .removeClass("text-danger")
                  .addClass("text-success");

              $(".containerCodigoReserva").addClass("d-flex").removeClass("d-none");
              $(".formDataBooking").show();
              $(".resposeBookingAvailability").hide();
              $("#btnPagar").show();
          }
      }
  });
}

/*=============================================
FUNCIÓN COL.DERECHA RESERVAS
=============================================*/

function colDerReservas(){

   $(".colDerReservas").show(); 

   var codigoReserva = codigoAleatorio(chars, 9);
   
   var datos = new FormData();
   datos.append("codigoReserva", codigoReserva);

   $.ajax({

    url:urlPrincipal+"ajax/reservas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){      
     
       if(!respuesta){

         $(".codigoReserva").html(codigoReserva);
         var nric = codigoReserva;
         var url = 'https://api.qrserver.com/v1/create-qr-code/?data=' + nric + '&amp;size=50x50';
         $('#barcode').attr('src', url);
         $(".pagarReserva, .reservarSinPagar").attr("codigoReserva",codigoReserva );

       }else{

          $(".codigoReserva").html(codigoReserva+codigoAleatorio(chars, 3));
          $(".pagarReserva, .reservarSinPagar").attr("codigoReserva",codigoReserva+codigoAleatorio(chars, 3));

       }

        /*=============================================
        CAMBIO DE PLAN
        =============================================*/

        // $(".elegirPlan").change(function(){

        //   cambioPlanesPersonas();

           
        // })

        /*=============================================
        CAMBIO DE PERSONAS
        =============================================*/

        // $(".cantidadPersonas").change(function(){

        //  cambioPlanesPersonas();


        // })

    }

  })

}


// function cambioPlanesPersonas(){

//   switch($(".cantidadPersonas").val()){
            
//     case "2":

//        $(".precioReserva span").html($(".elegirPlan").val().split(",")[0]*dias);
//        $(".precioReserva span").number(true);
//        $(".pagarReserva").attr("pagoReserva",$(".elegirPlan").val().split(",")[0]*dias)
//        $(".pagarReserva").attr("plan",$(".elegirPlan").val().split(",")[1]);
//        $(".pagarReserva").attr("personas",$(".cantidadPersonas").val());

//     break;

//     case "3":

//      $(".precioReserva span").html(  Number($(".elegirPlan").val().split(",")[0]*0.25) + Number($(".elegirPlan").val().split(",")[0])*dias);
//      $(".precioReserva span").number(true);
//      $(".pagarReserva").attr("pagoReserva",Number($(".elegirPlan").val().split(",")[0]*0.25) + Number($(".elegirPlan").val().split(",")[0])*dias);
//       $(".pagarReserva").attr("plan",$(".elegirPlan").val().split(",")[1]);
//       $(".pagarReserva").attr("personas",$(".cantidadPersonas").val());

//     break;

//     case "4":

//      $(".precioReserva span").html(  Number($(".elegirPlan").val().split(",")[0]*0.50) + Number($(".elegirPlan").val().split(",")[0])*dias);
//      $(".precioReserva span").number(true);
//      $(".pagarReserva").attr("pagoReserva",Number($(".elegirPlan").val().split(",")[0]*0.50) + Number($(".elegirPlan").val().split(",")[0])*dias);
//       $(".pagarReserva").attr("plan",$(".elegirPlan").val().split(",")[1]);
//       $(".pagarReserva").attr("personas",$(".cantidadPersonas").val());

//     break;

//     case "5":

//      $(".precioReserva span").html(  Number($(".elegirPlan").val().split(",")[0]*0.75) + Number($(".elegirPlan").val().split(",")[0])*dias);
//      $(".precioReserva span").number(true);
//      $(".pagarReserva").attr("pagoReserva",Number($(".elegirPlan").val().split(",")[0]*0.75) + Number($(".elegirPlan").val().split(",")[0])*dias);
//       $(".pagarReserva").attr("plan",$(".elegirPlan").val().split(",")[1]);
//       $(".pagarReserva").attr("personas",$(".cantidadPersonas").val());

//     break;

//   }

// }

colDerReservas()

/*=============================================
CAPTURAR DATOS DE LA RESERVA
=============================================*/

$(".pagarReserva").click(function(e){

  e.preventDefault();

  // validar terminos
  const terminosChecked = $("[name='terminos']").is(":checked");
  const datosPersonalesChecked = $("[name='datos_personales']").is(":checked");

  if (terminosChecked && datosPersonalesChecked) {        

  }else{

    alert("Debe aceptar los términos y condiciones y el uso de datos personales para continuar")

    return;

  }

  const form = document.querySelector('.needs-validation');

  if (!form) return;

  manejarRequired('hotel_hospedado');
  manejarRequired('agencia_reserva');

  if (!form.checkValidity()) {
    form.classList.add('was-validated');
    return;
  }

  form.submit(); // Forzar envío

  listarAcompañantes()

  var firstName = $("#firstName").val()
  var lastName = $("#lastName").val()
  var tipo_identificacion = $("#tipo_identificacion").val()
  var numero_identificacion = $("#numero_identificacion").val()
  var celular = $("#celular").val()
  var correo = $("#correo").val()
  var acompañantes = $(".acompañantesReserva").val()
  // hotel_hospedado
  if($('input[name="hospedaje_hotel"]:checked').val() == "si"){
    var hospedaje = $("#hotel_hospedado").val()
  }else{
    var hospedaje = $('input[name="hospedaje_hotel"]:checked').val()
  }
  var abono = $('input[name="abono"]:checked').val() 
  var cuotas = $("#cuotas").val()
  var montoPagar = $("#montoPagar").val()
  var valorCuotas = $("#valorCuotas").val()
  var pagoCuotas = $('input[name="cuotas"]:checked').val()  

  if(firstName == ''){
    //firstName.next(".invalid-feedback").show()
  }else if(lastName == ''){
    //lastName.next(".invalid-feedback").show()
  }else if(tipo_identificacion == ''){
    //tipo_identificacion.next(".invalid-feedback").show()
  }else if(numero_identificacion == ''){
    //numero_identificacion.next(".invalid-feedback").show()
  }else if(celular == ''){
    //celular.next(".invalid-feedback").show()
  }else if(correo == ''){
    //correo.next(".invalid-feedback").show()
  }else{

    var personasTotal = Number($(this).attr("personas")) + Number($(this).attr("kids"))

    var idHabitacion = $(this).attr("idHabitacion");
    var imgHabitacion = $(this).attr("imgHabitacion");
    var infoHabitacion = $(this).attr("infoHabitacion")+" - "+personasTotal+" personas";
    var pagoReserva = $(this).attr("pagoReserva");
    var codigoReserva = $(this).attr("codigoReserva");
    var fechaIngreso = $(this).attr("fechaIngreso");
    var fechaSalida = $(this).attr("fechaSalida");  
    var pagoActual = $(this).attr("pagoActual");  

    // if(abono == "total"){
    //   pagoReserva = pagoReserva
    // }else{
    //   pagoReserva = Number(pagoReserva) / 2
    // }

    if($("#agencia_reserva")){
      var usuario = $("#agencia_reserva").val()
    }else{
      var usuario = "Público general"
    }

    crearCookie("idHabitacion", idHabitacion, 1);
    crearCookie("imgHabitacion", imgHabitacion, 1);
    crearCookie("infoHabitacion", infoHabitacion, 1);
    crearCookie("id_user", usuario, 1);
    crearCookie("pagoReserva", pagoReserva, 1);
    crearCookie("pagoActual", pagoActual, 1); 
    crearCookie("codigoReserva", codigoReserva, 1);
    crearCookie("fechaIngreso", fechaIngreso, 1); 
    crearCookie("fechaSalida", fechaSalida, 1);
    crearCookie("acompañantes", acompañantes, 1);
    crearCookie("firstName", firstName, 1);
    crearCookie("lastName", lastName, 1);
    crearCookie("tipo_identificacion", tipo_identificacion, 1);
    crearCookie("numero_identificacion", numero_identificacion, 1);
    crearCookie("celular", celular, 1);
    crearCookie("correo", correo, 1);    
    crearCookie("hospedaje", hospedaje, 1);
    crearCookie("abono", abono, 1);
    crearCookie("cuotas", cuotas, 1); 
    crearCookie("montoPagar", montoPagar, 1); 
    crearCookie("valorCuotas", valorCuotas, 1); 
    crearCookie("pagoCuotas", pagoCuotas, 1);     

    localStorage.setItem("codigoReserva", codigoReserva);

    window.location = urlPrincipal + "?pagina=perfil&codigo=" + codigoReserva;

  }  

})

$("#cantidadDePersonas").change(function(){
  var personas = $(this).val()
  var precio = $(this).attr("precio") 
  var total = precio * personas
  total = total.toLocaleString(
    undefined, // leave undefined to use the visitor's browser 
               // locale or a string like 'en-US' to override it.
    { minimumFractionDigits: 0 }
  );
  var fraccion = (precio * personas) / 2
  fraccion = fraccion.toLocaleString(
    undefined, // leave undefined to use the visitor's browser 
               // locale or a string like 'en-US' to override it.
    { minimumFractionDigits: 0 }
  );
  $("#precioTotal").text("$"+total+" COP")
  $("#fraccionTotal").text("$ "+fraccion+" COP")
})

$("#cambiarFechaReserva").click(function(){
  $("#cambiarFechaInput").removeAttr("disabled")
})

$("#cambiarFechaInput").on("change",function(){
  $("#cambiarFechaForm").submit()
})

$('[name="abono"]').change(function(){

  if($(this).val() == "credito"){

    // $(".pagoaCreditoDiv").show()

    var options = $("[name='cuotas']")

    $(options).each(function(){

      if($(this).val() == "nopago"){

        $(this).attr("checked", true)
        $(this).trigger("change")

      }

    })

    $(".pagarReserva").hide()

    $(".reservarSinPagar").show()

    // $(".reservarSinPagar").attr("disabled", true)

    // console.log("hola")

  }else{

    $(".pagoaCreditoDiv").hide()

    $(options).each(function(){

      if($(this).val() == "nopago"){

        $(this).removeAttr("checked")

      }

    })

    $(".pagarReserva, .reservarSinPagar").attr("pagoActual", $(this).attr("precio"))

    $(".pagarReserva").show()

    $(".reservarSinPagar").hide()

  }

})

$('[name="cuotas"]').change(function(){

  console.log($(this).val())

  if($(this).val() == "monto"){

    $(".montoEspecifico").show()

    $(".pagarReserva, .reservarSinPagar").attr("pagoActual", $("#montoPagar").val())  
    
    $(".reservarSinPagar").hide()

    $(".reservarSinPagar").attr("disabled", "true")

    $(".pagarReserva").show()

  }else if($(this).val() == "primera"){

    $(".montoEspecifico").hide()
 
    $("#montoPagar").val('')

    var precio = $(this).attr("precio")

    var valorCuotas = (Number(precio) - Number($("#montoPagar").val())) / $("#cuotas").val()

    $("#valorCuotas").val(valorCuotas)

    $(".pagarReserva, .reservarSinPagar").attr("pagoActual", valorCuotas)

    $(".reservarSinPagar").hide()

    $(".reservarSinPagar").attr("disabled", "true")

    $(".pagarReserva").show()

  }else{

    console.log("nopago")

    // habilitar boton de reservar sin pagar

    $(".montoEspecifico").hide()

    $("#montoPagar").val('')

    var precio = $(this).attr("precio")

    var valorCuotas = (Number(precio) - Number($("#montoPagar").val())) / $("#cuotas").val()

    $("#valorCuotas").val(valorCuotas)

    $(".pagarReserva").hide()

    $(".reservarSinPagar").show()

    $(".reservarSinPagar").removeAttr("disabled")

    // console.log("olh")

  }

})

$("#cuotas").change(function(){
  
  var precio = $(this).attr("precio")

  var valorCuotas = (Number(precio) - Number($("#montoPagar").val())) / $("#cuotas").val()

  $("#valorCuotas").val(valorCuotas)

  if($("#montoPagar").is(":visible")){

    $(".pagarReserva, .reservarSinPagar").attr("pagoActual", $("#montoPagar").val())

  }else{

    $(".pagarReserva, .reservarSinPagar").attr("pagoActual", valorCuotas)

  }

  

})

$("#montoPagar").change(function(){

  var precio = $(this).attr("precio")

  var valorCuotas = (Number(precio) - Number($(this).val())) / $("#cuotas").val()

  $("#valorCuotas").val(valorCuotas)

  $(".pagarReserva, .reservarSinPagar").attr("pagoActual", $(this).val())

})

$(".reservarSinPagar").click(function(e){

  e.preventDefault();

  // alert("h")

  // console.log($(this).attr("disabled") == "disabled")

  if($(this).attr("disabled") == "disabled"){
    swal.fire({
      type: "error",
      title: "¡ERROR!",
      text: "¡Seleccione si pagará la primera cuota, un valor diferente o reservar sin cuota inicial!",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"	
    });

  }else{

  // validar terminos
  const terminosChecked = $("[name='terminos']").is(":checked");
  const datosPersonalesChecked = $("[name='datos_personales']").is(":checked");

  if (terminosChecked && datosPersonalesChecked) {        

  }else{

    alert("Debe aceptar los términos y condiciones y el uso de datos personales para continuar")

    return;

  }
  
  const form = document.querySelector('.needs-validation');

  if (!form) return;

  manejarRequired('hotel_hospedado');
  manejarRequired('agencia_reserva');

  if (!form.checkValidity()) {
    form.classList.add('was-validated');
    return;
  }

  // form.submit(); // Forzar envío

  listarAcompañantes()

  var firstName = $("#firstName").val()
  var lastName = $("#lastName").val()
  var tipo_identificacion = $("#tipo_identificacion").val()
  var numero_identificacion = $("#numero_identificacion").val()
  var celular = $("#celular").val()
  var correo = $("#correo").val()
  var acompañantes = $(".acompañantesReserva").val()
  // console.log(acompañantes)
  // hotel_hospedado
  if($('input[name="hospedaje_hotel"]:checked').val() == "si"){
    var hospedaje = $("#hotel_hospedado").val()
  }else{
    var hospedaje = $('input[name="hospedaje_hotel"]:checked').val()
  }
  
  var abono = $('input[name="abono"]:checked').val()
  var cuotas = $("#cuotas").val()
  var montoPagar = $("#montoPagar").val()
  var valorCuotas = $("#valorCuotas").val()
  var pagoCuotas = $('input[name="cuotas"]:checked').val()

  //console.log(pagoCuotas)

  if(firstName == ''){
    //firstName.next(".invalid-feedback").show()
  }else if(lastName == ''){
    //lastName.next(".invalid-feedback").show()
  }else if(tipo_identificacion == ''){
    //tipo_identificacion.next(".invalid-feedback").show()
  }else if(numero_identificacion == ''){
    //numero_identificacion.next(".invalid-feedback").show()
  }else if(celular == ''){
    //celular.next(".invalid-feedback").show()
  }else if(correo == ''){
    //correo.next(".invalid-feedback").show()
  }else{

    var personasTotal = Number($(this).attr("personas")) + Number($(this).attr("kids"))

    var idHabitacion = $(this).attr("idHabitacion");
    var imgHabitacion = $(this).attr("imgHabitacion");
    var infoHabitacion = $(this).attr("infoHabitacion")+" - "+personasTotal+" personas";
    console.log(infoHabitacion)
    var pagoReserva = $(this).attr("pagoReserva");
    var codigoReserva = $(this).attr("codigoReserva");
    var fechaIngreso = $(this).attr("fechaIngreso");
    var fechaSalida = $(this).attr("fechaSalida");  

    //console.log(codigoReserva)
        
    // guardar reserva via ajax

    if($("#agencia_reserva")){
      var usuario = $("#agencia_reserva").val()
    }else{
      var usuario = "Público general"
    }

    var datos = new FormData();
    datos.append("codigoReservaNueva", codigoReserva);
    datos.append("idHabitacionNueva", idHabitacion);
    datos.append("imgHabitacion", imgHabitacion);
    datos.append("infoHabitacion", infoHabitacion);
    datos.append("pagoReserva", pagoReserva);
    datos.append("id_user", usuario);
    datos.append("fechaIngresoNueva", fechaIngreso);
    datos.append("fechaSalidaNueva", fechaSalida);
    datos.append("acompañantes", acompañantes);
    datos.append("firstName", firstName);
    datos.append("lastName", lastName);
    datos.append("tipo_identificacion", tipo_identificacion);
    datos.append("numero_identificacion", numero_identificacion);
    datos.append("celular", celular);
    datos.append("correo", correo);    
    datos.append("hospedaje", hospedaje);
    datos.append("abono", abono);
    datos.append("cuotas", cuotas); 
    datos.append("montoPagar", montoPagar); 
    datos.append("valorCuotas", valorCuotas);  
    datos.append("pagoCuotas", pagoCuotas); 

    $.ajax({

      url:urlPrincipal+"ajax/reservas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){ 

        // alert(respuesta)

        if(respuesta == "ok"){          
          
          document.cookie = "idHabitacion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "id_user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "imgHabitacion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "infoHabitacion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "pagoReserva=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "codigoReserva=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "fechaIngreso=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "fechaSalida=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "firstName=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "lastName=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "tipo_identificacion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "numero_identificacion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "celular=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "correo=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "hospedaje=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "abono=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "cuotas=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "montoPagar=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "valorCuotas=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";
          document.cookie = "pagoCuotas=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=<?php echo $ruta ?>;";                           
          
          $.ajax({
            url: urlPrincipal + "ajax/enviar_enlace.ajax.php",
            method: "POST",
            data: {
              correo: correo,
              codigoReserva: codigoReserva,
              nombreCliente: firstName+' '+lastName
            },
            beforeSend: function() {
              $("#loader").fadeIn(); // Mostrar loader antes de enviar
            },
            success: function(r) {
              console.log("PDF enviado", r);
              $("#loader").fadeOut(); // Ocultar loader después de éxito
              window.location = urlPrincipal+"?pagina=reserva-exitosa&type=reserva&codigo="+codigoReserva+"&estado=pagada"; 
            },
            error: function(err) {
              console.error("Error enviando PDF:", err);
              $("#loader").fadeOut(); // También ocultarlo si hay error
            }
          });          

        }else{

          $(".intro_title").text("¡Algo salió mal!");
          $(".intro_title").next("p").text("Ha ocurrido un error con el pago. Por favor vuelve a intentarlo.</p>");

        }

      }

    })

    // Llamar al backend para generar y enviar el PDF             

  }
  

  }

})

$("#addChild").click(function(){

  var valor = $('[name="cantidad-child"]').val()

  $('[name="cantidad-child"]').val(parseInt(valor) + 1)

  $('[name="cantidad-child"]').trigger("change")

})

$("#delChild").click(function(){

  var valor = $('[name="cantidad-child"]').val()

  if(valor >= 1){

    $('[name="cantidad-child"]').val(parseInt(valor) - 1)

    $('[name="cantidad-child"]').trigger("change")

  }  

})

// let previousValue = $('[name="cantidad-child"]').val();

$('[name="cantidad-child"]').on('change', function() {

  var el = $(this)

  var direction = this.defaultValue < this.value
  this.defaultValue = this.value;

  var valor = $(this).val()
  var max = $(this).attr("max")

  if(valor > max){
    swal.fire({
      type: "error",
      title: "¡ERROR!",
      text: "No puede seleccionar una cantidad mayor al número de personas de la reserva",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"	
    });

    $(el).val('')

    return;

  }

  // console.log( this.defaultValue, this.value)

  if(direction){

    var niños = $("#cantTotalNiños").attr("total")

    var totalNiños = Number(niños) + 1

    $("#cantTotalNiños").text("X " + totalNiños)

    $("#cantTotalNiños").attr("total", totalNiños)

    var valorNiños = $("#cantTotalNiños").attr("valor")    

    var precioNiños = Number(valorNiños) * totalNiños

    $("#valorTotalNiños").text("$ "+formatNumber(precioNiños)+" COP")

    // restar el de los adultos

    var adultos = $("#cantTotalAdultos").attr("total")

    var totalAdultos = Number(adultos) - 1

    $("#cantTotalAdultos").text("X " + totalAdultos)

    $("#cantTotalAdultos").attr("total", totalAdultos)

    var valorAdultos = $("#cantTotalAdultos").attr("valor")    

    var precioAdultos = Number(valorAdultos) * totalAdultos

    $("#valorTotalAdultos").text("$ "+formatNumber(precioAdultos)+" COP")

    var totalReserva = precioAdultos + precioNiños

    $("#precioTotal").text("$" + formatNumber(totalReserva) + " COP")

    $("#fraccionTotal").text("$" + formatNumber(totalReserva / 2) + " COP")    

    $(".pagarReserva, .reservarSinPagar").attr("pagoReserva", totalReserva)

    $(".pagarReserva, .reservarSinPagar").attr("pagoActual", totalReserva)

    $('[name="abono"]').attr("precio", totalReserva / 2)

    $("#valorCuotas").val(totalReserva)

    $("#cuotas").attr("precio", totalReserva)

    $('[name="cuotas"]').attr("precio", totalReserva)

  }else{

    var niños = $("#cantTotalNiños").attr("total")

    var totalNiños = Number(niños) - 1

    $("#cantTotalNiños").text("X " + totalNiños)

    $("#cantTotalNiños").attr("total", totalNiños)

    var valorNiños = $("#cantTotalNiños").attr("valor")    

    var precioNiños = Number(valorNiños) * totalNiños

    $("#valorTotalNiños").text("$ "+formatNumber(precioNiños)+" COP")

    // restar el de los adultos

    var adultos = $("#cantTotalAdultos").attr("total")

    var totalAdultos = Number(adultos) + 1

    $("#cantTotalAdultos").text("X " + totalAdultos)

    $("#cantTotalAdultos").attr("total", totalAdultos)

    var valorAdultos = $("#cantTotalAdultos").attr("valor")    

    var precioAdultos = Number(valorAdultos) * totalAdultos

    $("#valorTotalAdultos").text("$ "+formatNumber(precioAdultos)+" COP")

    var totalReserva = precioAdultos + precioNiños

    $("#precioTotal").text("$" + formatNumber(totalReserva) + " COP")

    $("#fraccionTotal").text("$" + formatNumber(totalReserva / 2) + " COP") 

    $(".pagarReserva, .reservarSinPagar").attr("pagoReserva", totalReserva)

    $(".pagarReserva, .reservarSinPagar").attr("pagoActual", totalReserva)

    $('[name="abono"]').attr("precio", totalReserva / 2)

    $("#valorCuotas").val(totalReserva)

    $("#cuotas").attr("precio", totalReserva)

    $('[name="cuotas"]').attr("precio", totalReserva)

  }

})


$('[name="hospedaje_hotel"]').change(function(){

  if($(this).val() == "si"){

    $(".hotel").show()
    $(".nohotel").hide()

  }else{

    $(".hotel").hide()
    $(".nohotel").show()

  }

})

function listarAcompañantes(){  

	var listaAcompañantes = [];

	var nombre = $('#containerAcompañantes [class*="nameGuest"]')
	var tipo_documento = $('#containerAcompañantes [class*="typeDocGuest"]')
	var documento = $('#containerAcompañantes [class*="docGuest"]')
  var tipo = $('#containerAcompañantes [class*="typeGuest"]')
  var nacionalidad = $('#containerAcompañantes [class*="nacGuest"]')

  //console.log(nombre)

	for(var i = 0; i < tipo.length; i++){

    var kids = $("#cantidadKids").val()

    if($(tipo[i]).is(":visible")){

      if($(tipo[i]).is(":checked")){
        var type = "kid";
      }else{
        var type = "adulto";
      }

    }else{

      if(i < Number(kids)){
        var type = "kid";
      }else{
        var type = "adulto";
      }

    }            

		listaAcompañantes.push({ "nombre" : $(nombre[i]).val(), 
							"tipo_documento" : $(tipo_documento[i]).val(),
							"documento" : $(documento[i]).val(),
              "tipo": type,
              "nacionalidad": $(nacionalidad[i]).val()})

	}

	console.log(JSON.stringify(listaAcompañantes))
	$(".acompañantesReserva").val(JSON.stringify(listaAcompañantes));

}

$(".typeGuest").change(function(){

  listarAcompañantes()

  if($(this).is(":checked")){

    

  }else{

    

  }

})


function formatNumber(number)
{
    number = number.toFixed(0) + '';
    x = number.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

$(".datepicker").change(function(){

  var fechaIngreso = $(this).val()

  var items = $("[name='id-habitacion']")

  $(items).each(function(){

    if($(this).is(":visible")){

      var idHabitacion = $(this).val()

      if(idHabitacion != ''){

        console.log(fechaIngreso)

        // validarDisponibilidadFechaServicio(idHabitacion, fechaIngreso)

      }

    }

  })      

})

// seleccionar la nacionalidad

$(".nacionalidad").change(function(){

  var country = $(this).val()

  $(".nacGuest:not(.nacionalidad)").val(country)

  $(".nacGuest:not(.nacionalidad)").trigger("change")  

})

function formatDate(dateString) {
  const parts = dateString.split('-');
  if (parts.length === 3) {
    const day = parts[0];
    const month = parts[1];
    const year = parts[2];
    return `${year}-${month}-${day}`;
  }
  return 'Invalid Date';
}

// $("#cantidadKids").change(function(){
  
//   if(valor > max){
//     $(this).val(0)    
//     // $(this).trigger('click');
//   }
// })

$('#cantidadKids').on('keydown', function(e) {
  // Permitir flechas arriba (38) y abajo (40), tab (9)
  if (e.which !== 38 && e.which !== 40 && e.which !== 9) {
      e.preventDefault();
  }
});

/*=============================================
FUNCIÓN PARA GENERAR COOKIES
=============================================*/

function crearCookie(nombre, valor, diasExpedicion){

  var hoy = new Date();

  hoy.setTime(hoy.getTime() + (diasExpedicion * 24 * 60 * 60 * 1000));

  var fechaExpedicion = "expires=" + hoy.toUTCString();

  document.cookie = nombre + "=" + valor + "; " + fechaExpedicion;

}

// Función reutilizable para disparar el evento change
function triggerChangeAndUpdate(input) {
  $(input).trigger('change');
}

// Eventos de los botones
document.getElementById('plusBtn').addEventListener('click', () => {
  const input = document.getElementById('cantidadKids');
  const max = parseInt(input.max) || 1000;
  if (parseInt(input.value) < max) {
    input.stepUp();
    triggerChangeAndUpdate(input);
  }
});

document.getElementById('minusBtn').addEventListener('click', () => {
  const input = document.getElementById('cantidadKids');
  const min = parseInt(input.min) || 0;
  if (parseInt(input.value) > min) {
    input.stepDown();
    triggerChangeAndUpdate(input);
  }
});

document.querySelectorAll('input[name="hospedaje_hotel"]').forEach(function(radio) {
  radio.addEventListener('change', function () {
    const hotelInput = document.getElementById('hotel_hospedado');
    if (this.value === 'si') {
      hotelInput.closest('.hotel').style.display = 'block';
      hotelInput.required = true;
    } else {
      hotelInput.closest('.hotel').style.display = 'none';
      hotelInput.required = false;
    }
  });
});

function manejarRequired(id) {
  const campo = document.getElementById(id);
  if (campo) {
    const visible = campo.offsetParent !== null; // true si es visible
    campo.required = visible;
  }
}