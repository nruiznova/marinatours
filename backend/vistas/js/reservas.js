/*=============================================
Tabla Reservas
=============================================*/

var urlServidor = $("#urlServidor").val()

var urlPrincipal = $("#urlPrincipal").val()

var item = null;
var valor = null;

$(".searchBtn").click(function(){	

	item = $(this).parent().parent().parent().prev().children().val()
	valor = $(this).parent().prev().val()
	var table = $(this).attr("table")

	if(item == '' || valor == ''){

		alert("seleccione los datos para filtrar") 

	}else{

		if(table == 1){
			iniciarTabla(item, valor)
		}else{
			iniciarTabla2(item, valor)
		}

	}

})

function iniciarTabla(item, valor){

	// iniciar tabla reservas

	$('#example1').DataTable().destroy();

	table = $(".tablaReservas").DataTable({
		"ajax":"ajax/tablaReservas.ajax.php?item="+item+"&valor="+valor,
		"deferRender": true,
		"retrieve": true,
		"processing": true,
		dom: 'Bfrtip',
		responsive: false,
		// pageLength: 5,
		buttons: [{ extend: 'excel', text: 'Exportar en Excel' }, { extend: 'pdf', text: 'Exportar en PDF' }],
		"language": { 
	  
		   "sProcessing":     "Procesando...",
		  "sLengthMenu":     "Mostrar _MENU_ registros",
		  "sZeroRecords":    "No se encontraron resultados",
		  "sEmptyTable":     "Ningún dato disponible en esta tabla",
		  "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		  "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		  "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		  "sInfoPostFix":    "",
		  "sSearch":         "Buscar:",
		  "sUrl":            "",
		  "sInfoThousands":  ",",
		  "sLoadingRecords": "Cargando...",
		  "oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Ãšltimo",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		  },
		  "oAria": {
			  "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		  }
	  
		 }

	}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');	

}

function iniciarTabla2(item, valor){

	// iniciar tabla beneficiarios

	var groupColumn = 0;

	$('#example2').DataTable().destroy();

	table2 = $(".tablaBeneficiarios").DataTable({
		"ajax":"ajax/tablaBeneficiarios.ajax.php?item="+item+"&valor="+valor,
		"deferRender": true,
		"retrieve": true,
		"processing": true,
		dom: 'Bfrtip', 
		columnDefs: [{ visible: false, targets: groupColumn }],
		order: [[groupColumn, 'asc']],
		buttons: [{ extend: 'excel', text: 'Exportar en Excel' }, { extend: 'pdf', text: 'Exportar en PDF' }],
		"language": {
	  
		   "sProcessing":     "Procesando...",
		  "sLengthMenu":     "Mostrar _MENU_ registros",
		  "sZeroRecords":    "No se encontraron resultados",
		  "sEmptyTable":     "Ningún dato disponible en esta tabla",
		  "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		  "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		  "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		  "sInfoPostFix":    "",
		  "sSearch":         "Buscar:",
		  "sUrl":            "",
		  "sInfoThousands":  ",",
		  "sLoadingRecords": "Cargando...",
		  "oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		  },
		  "oAria": {
			  "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		  }
	  
		},
		drawCallback: function (settings) {
			var api = this.api();
			var rows = api.rows({ page: 'current' }).nodes();
			var last = null;
	 
			api.column(groupColumn, { page: 'current' })
				.data()
				.each(function (group, i) {
					if (last !== group) {
						$(rows)
							.eq(i)
							.before(
								''
							);
	 
						last = group;
					}
				});
		}

	}).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

	//  fila del grupo en el before <tr class="group"><td colspan="5"><b>CÓDIGO: ' + group + '</b></td></tr>

}

iniciarTabla(item, valor)
iniciarTabla2(item, valor)

/*=============================================
FECHAS RESERVA
=============================================*/

$('.datepicker.entrada').datepicker({
  startDate: '0d',
  datesDisabled: '0d', 
  format: 'dd-mm-yyyy',
  todayHighlight:true
});


/*=============================================
EDITAR RESERVA
=============================================*/

$(document).on("click", ".editarReserva", function(){

	var descripcion = $(this).attr("descripcion");
	var idHabitacion = $(this).attr("idHabitacion");
	var fechaIngreso = $(this).attr("fechaIngreso");
	var fechaSalida = $(this).attr("fechaSalida");
	var idReserva = $(this).attr("idReserva");
	$("#fecha_ingreso").attr("antDate", fechaIngreso)	
	
	//$(".agregarCalendario").html('<div id="calendar"></div>');

	// Agregar descripción al título del modal  
	$("#servicioModalEditar").text(descripcion);

	 // Agregar las fechas de reserva al formulario
	$(".datepicker.entrada").val(fechaIngreso);
    $(".datepicker.salida").val(fechaSalida);

    // Agregar id de la habitación al botón ver disponibilidad
  	$(".verDisponibilidad").attr("idHabitacion", idHabitacion);

  	//Agregar id de la reserva al botón guardar
  	$(".guardarNuevaReserva").attr("idReserva", idReserva);

  	//Traer las resertvas existentes de la habitación
  	//var totalEventos = [];
  	var datos = new FormData();
  	datos.append("idHabitacion", idHabitacion);

  	$.ajax({

	    url:"ajax/reservas.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	for(var i = 0; i < respuesta.length; i++){

				console.log(respuesta[i]["id_reserva"])

				if(respuesta[i]["id_reserva"] == idReserva){

					$("#copiarEnlaceDatos").attr("codigoReserva", respuesta[i]["codigo_reserva"])
					$("#descargarQr").attr("codigoReserva", respuesta[i]["codigo_reserva"])				

					var des = respuesta[i]["descripcion_reserva"];

					var descArr = des.split("-");

					var personas = descArr[1].split(" ");

					// console.log(personas[1])

					if(respuesta[i]["id_reserva"] == Number(idReserva)){

						$("#personas").val(personas[1])
						$("#firstName").val(respuesta[i]["firstName"])
						$("#lastName").val(respuesta[i]["lastName"])
						$("#tipo_identificacion").val(respuesta[i]["tipo_identificacion"])
						$("#numero_identificacion").val(respuesta[i]["numero_identificacion"])
						$("#celular").val(respuesta[i]["celular"])
						$("#correo").val(respuesta[i]["correo"])
						
					}	
					
				}

	    	}

		}

	})	

})


/*=============================================
VER DISPONIBILIDAD NUEVA RESERVA
=============================================*/

$(document).on("click",".verDisponibilidad", function(){

	var fechaIngreso = $(".datepicker.entrada").val();
  	var fechaSalida = $(".datepicker.salida").val();
  	var idHabitacion = $(this).attr("idHabitacion");
	var totalPersonas = $(this).attr("personas");
	var ruta = $(this).attr("ruta")

  	// Reiniciar Calendario cada vez que busque disponibilidad
  	$(".agregarCalendario").html('<div id="calendar"></div>');

  	var totalEventos = [];
  	var opcion1 = [];
  	var opcion2 = [];
  	var opcion3 = [];
  	var validarDisponibilidad = false;
	var totalReservas = 0;

	var datos = new FormData();
	datos.append("idHabitacion", idHabitacion);

	console.log(urlPrincipal)
  
	$.ajax({
  
	  url:urlPrincipal+"ajax/reservas.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
	  contentType: false,
	  processData: false,
	  dataType:"json",
	  success:function(respuesta){        
  
		  if(respuesta.length == 0){                    
  
			// colDerReservas(); 
  
			// llamar al servicio y verificar los cupos
			
			var datos2 = new FormData();
			datos2.append("ruta", ruta);
  
			$.ajax({
  
			  url:urlPrincipal+"ajax/habitaciones.ajax.php",
			  method: "POST",
			  data: datos2,
			  cache: false, 
			  contentType: false,
			  processData: false,
			  dataType:"json",
			  success:function(response){
  
				// cupos iniciales
  
				var cupos;

				// consultar si se establecio una cantidad diferente de cupos para esta fecha

				// consultar si se establecio una cantidad diferente de cupos para esta fecha              

				var serviciosEnlazadosCuposStr = response["serviciosEnlazados"]+";"+response["id_h"]
				var serviciosEnlazadosCuposArr = serviciosEnlazadosCuposStr.split(";")
				var serviciosCupos = serviciosEnlazadosCuposArr.sort()   
							
				var fechaCupos = formatDate(fechaIngreso)                                

				var datosCupos = new FormData();
				datosCupos.append("serviciosCupos", serviciosCupos.join(";"))
				datosCupos.append("fechaCupos", fechaCupos)  

				$.ajax({

					url:urlServidor+"ajax/reservas.ajax.php",
					method: "POST",
					data: datosCupos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					async: false,
					success:function(respuestaCupos){

					if(!respuestaCupos){

						cupos = response["cupos"]; 
						
					}else{

						cupos = respuestaCupos["cupos"]

					}

					}

				})
  
				// teaer servicios relacionados
  
				var relacionados = response["serviciosEnlazados"].split(";");
  
				for (let index = 0; index < relacionados.length; index++) {
				  
				  const s = relacionados[index];
  
				  // consultar reservas de los servicios relacionados
  
				  var datos3 = new FormData();
				  datos3.append("idHabitacion", s);
  
				  $.ajax({
  
					url:urlPrincipal+"ajax/reservas.ajax.php",
					method: "POST",
					data: datos3,
					cache: false,
					contentType: false,
					processData: false,
					dataType:"json",
					success:function(info){ 
  
					  for(var i = 0; i < info.length; i++){
  
						/* VALIDAR CRUCE DE FECHAS OPCIÓN 1 */         
			
						if(formatDate(fechaIngreso) == info[i]["fecha_ingreso"]){
			
						  totalReservas++;
			
						}
										  
			
					  }                    
  
					}
  
				  })
				  
				}
  
				//console.log(totalReservas)
  
				cuposDisponibles = cupos - totalReservas
  
				if(cuposDisponibles < 1 || cuposDisponibles < totalPersonas){
  
				  opcion1[i] = false;            
	  
				}else{
	  
				  opcion1[i] = true;
	  
				}
	  
				/* VALIDAR DISPONIBILIDAD */    
	  
				if(opcion1[i] == false){
	  
				  validarDisponibilidad = false;
				
				}else{
	  
				  validarDisponibilidad = true;
				 
				}               
				
				if(!validarDisponibilidad){                
	  
					$(".infoDisponibilidad").text("LO SENTIMOS SOLO HAY "+cuposDisponibles+" CUPOS DISPONIBLES")
	  
					// $(".containerCodigoReserva").removeClass("d-flex")
					// $(".containerCodigoReserva").addClass("d-none")
					$(".infoDisponibilidad").addClass("text-danger")
					// $("#btnPagar").hide()              
	  
					//break;
	  
				}else{             
	  
					$(".infoDisponibilidad").text("¡HAY "+cuposDisponibles+" CUPOS DISPONIBLES!") 
					$(".infoDisponibilidad").addClass("text-success")             
	  
					// colDerReservas();
	  
				}
  
			  }
  
			})
  
  
		  }else{         
					
			//cuposTotales = respuesta[i]["cupos"]
  
			// consultar reservas de este servicio
  
			for(var i = 0; i < respuesta.length; i++){
  
				var cuposTotales;

				// consultar si se establecio una cantidad diferente de cupos para esta fecha

				// consultar si se establecio una cantidad diferente de cupos para esta fecha              

				var serviciosEnlazadosCuposStr = respuesta[i]["serviciosEnlazados"]+";"+respuesta[i]["id_h"]
				var serviciosEnlazadosCuposArr = serviciosEnlazadosCuposStr.split(";")
				var serviciosCupos = serviciosEnlazadosCuposArr.sort()   
								
				var fechaCupos = formatDate(fechaIngreso)                                

				var datosCupos = new FormData();
				datosCupos.append("serviciosCupos", serviciosCupos.join(";"))
				datosCupos.append("fechaCupos", fechaCupos)  

				$.ajax({

					url:urlServidor+"ajax/reservas.ajax.php",
					method: "POST",
					data: datosCupos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					async: false,
					success:function(respuestaCupos){

					if(!respuestaCupos){

						cuposTotales = respuesta[i]["cupos"]; 
						
					}else{

						cuposTotales = respuestaCupos["cupos"]

					}

					}

				})
  
			  /* VALIDAR CRUCE DE FECHAS OPCIÓN 1 */         
  
			  if(formatDate(fechaIngreso) == respuesta[i]["fecha_ingreso"]){
  
				var personas = respuesta[i]["descripcion_reserva"].split(" ");
  
				for (let index = 0; index < personas.length; index++) {
				  const item = personas[index];
				  if(isNaN(item) == false){
  
					totalReservas += Number(item);
					
				  }
				}              
  
			  }
  
			  //console.log(totalReservas)
  
			  // consultar reservas de los servicios relacionados
  
			  var relacionados = respuesta[i]["serviciosEnlazados"].split(";");
  
			  for (let index = 0; index < relacionados.length; index++) {
				
				const s = relacionados[index];
  
				// consultar reservas de los servicios relacionados
  
				var datos3 = new FormData();
				datos3.append("idHabitacion", s);
  
				$.ajax({
  
				  url:urlPrincipal+"ajax/reservas.ajax.php",
				  method: "POST",
				  data: datos3,
				  cache: false,
				  contentType: false,
				  processData: false,
				  dataType:"json",
				  success:function(info){ 
  
					for(var i = 0; i < info.length; i++){
  
					  /* VALIDAR CRUCE DE FECHAS OPCIÓN 1 */         
		  
					  if(formatDate(fechaIngreso) == info[i]["fecha_ingreso"]){
		  
						totalReservas++;
		  
					  }
										
		  
					}                    
  
				  }
  
				})
				
			  }
								
  
			}                      
  
			cuposDisponibles = cuposTotales - totalReservas          
  
			if(cuposDisponibles < 1 || cuposDisponibles < totalPersonas){
  
			  opcion1[i] = false;            
  
			}else{
  
			  opcion1[i] = true;
  
			}
  
			/* VALIDAR DISPONIBILIDAD */    
  
			if(opcion1[i] == false){
  
			  validarDisponibilidad = false;
			
			}else{
  
			  validarDisponibilidad = true;
			 
			} 
			
			
			if(!validarDisponibilidad){                
  
				$(".infoDisponibilidad").text("LO SENTIMOS SOLO HAY "+cuposDisponibles+" CUPOS DISPONIBLES")
  
				// $(".containerCodigoReserva").removeClass("d-flex")
				// $(".containerCodigoReserva").addClass("d-none")
				$(".infoDisponibilidad").addClass("text-danger")
				// $("#btnPagar").hide()              
  
				//break;
  
			}else{             
  
				$(".infoDisponibilidad").text("¡HAY "+cuposDisponibles+" CUPOS DISPONIBLES!") 
				$(".infoDisponibilidad").addClass("text-success")             
  
				// colDerReservas();
  
			} 
  
		  }
		
	  }
  
	})

})

/*=============================================
Guardar nueva reserva
=============================================*/

$(document).on("click",".guardarNuevaReserva", function(){ 
	
  	var idReserva = $(this).attr("idReserva");	
	var fecha_ingreso = $("#fecha_ingreso").val()
	var personas = $("#personas").val()
	var firstName = $("#firstName").val()
	var lastName = $("#lastName").val()
	var tipo_identificacion = $("#tipo_identificacion").val()
	var numero_identificacion = $("#numero_identificacion").val()
	var celular = $("#celular").val()
	var correo = $("#correo").val()
	var antDate = $("#fecha_ingreso").attr("antDate")

	var disponibilidad = $(".infoDisponibilidad").text();

  	if(fecha_ingreso == ""){

	     swal({
	          title: "Error al guardar",
	          text: "¡No ha seleccionado una fecha válidas!",
	          type: "error",
	          confirmButtonText: "¡Cerrar!"
	        });

	     return;

  	}else if(fecha_ingreso != antDate){

		if(disponibilidad == ''){

			swal({
				title: "Error al guardar",
				text: "¡No ha validado la disponibilidad de la fecha!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			  });
	
		   return;

		}else if(disponibilidad.indexOf("SENTIMOS") > -1){

			swal({
				title: "Error al guardar",
				text: "¡No hay disponibilidad para la fecha que seleccionó!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			  });
	
		   return;

		}

	}

  	var datos = new FormData();
    datos.append("idReserva", idReserva);
	datos.append("fecha_ingreso", fecha_ingreso);
	datos.append("personas", personas);
	datos.append("firstName", firstName);
	datos.append("lastName", lastName);
	datos.append("tipo_identificacion", tipo_identificacion);
	datos.append("numero_identificacion", numero_identificacion);
	datos.append("celular", celular);
	datos.append("correo", correo);

    $.ajax({

	    url:"ajax/reservas.ajax.php",
	    method: "POST",
	    data: datos, 
	    cache: false,
	    contentType: false,
	    processData: false,
	    success:function(respuesta){

	    	 if(respuesta == "ok"){
	    	 	swal({
	    	 		type: "success",
	    	 		title: "¡CORRECTO!",
	    	 		text: "La reserva ha sido modificada correctamente",
	    	 		showConfirmButton: true,
	    	 		confirmButtonText: "Cerrar"
	    	 	}).then(function(result){

	    	 		if(result.value){

						$("#editarReserva").modal('hide');
						// $("#registrarPago input").val('')
						iniciarTabla(item, valor)

	    	 		}
	    	 	})

	    	 }

	    }

	})

})

/*=============================================
Cancelar reserva
=============================================*/

$(document).on("click",".eliminarReserva", function(){

	var idReserva = $(this).attr("idReserva");

	swal({
		title: '¿Está seguro de devolver esta reserva?',
		text: "¡Si no lo está puede devolver la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, devolver reserva!'
	}).then(function(result){

		if(result.value){

			var datos = new FormData();
			datos.append("idReservaStatus", idReserva);
			datos.append("status", "3");

			$.ajax({

				url:"ajax/reservas.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success:function(respuesta){

					// console.log(respuesta == "'ok'")

					if(respuesta == "ok"){ 
						swal({
							type: "success",
							title: "¡CORRECTO!",
							text: "La reserva ha sido devuelta correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){

							if(result.value){

								iniciarTabla(item, valor)

							}
						})

					}

				}

			})	

		}

	})

})

/*=============================================
Anular reserva
=============================================*/

$(document).on("click",".anularReserva", function(){

	var idReserva = $(this).attr("idReserva");

	swal({
		title: '¿Está seguro de anular esta reserva?',
		text: "¡Si no lo está puede anular la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, anular reserva!'
	}).then(function(result){

		if(result.value){

			var datos = new FormData();
			datos.append("idReservaStatus", idReserva);
			datos.append("status", "2");

			$.ajax({

				url:"ajax/reservas.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success:function(respuesta){

					console.log(respuesta)

					if(respuesta == "ok"){
						swal({
							type: "success",
							title: "¡CORRECTO!",
							text: "La reserva ha sido anulada correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){

							if(result.value){

								iniciarTabla(item, valor)

							}
						})

					}

				}

			})	

		}

	})

})


$(".entrada").on("change", function(){
	$(".infoDisponibilidad").text('')
})

// get payment information

$(document).on("click", ".btnPagoReserva", function(){	 

	// generar el link de pago

	var data = $(this).attr("data")	

	$("#btnLinkPago").attr("data", data)

	// traer informacion de la reserva

	var idHabitacion = $(this).attr("idHabitacion");	
	var idReserva = $(this).attr("idReserva");

	$("#registrarPagoReserva").attr("idReserva", idReserva)

	console.log(idHabitacion)

	var totalAPagar = 0;
	
  	var datos = new FormData();
  	datos.append("idHabitacion", idHabitacion);

  	$.ajax({

	    url:"ajax/reservas.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
		async: false,
	    success:function(respuesta){
	    	
	    	for(var i = 0; i < respuesta.length; i++){

				if(respuesta[i]["id_reserva"] == Number(idReserva)){

					// setear datos reserva

					$("#titularReservaModal").text(respuesta[i]["firstName"]+" "+respuesta[i]["lastName"])
					$("#servicioReservaModal").text(respuesta[i]["descripcion_reserva"])
					$("#totalReservaModal").val(respuesta[i]["pago_reserva"])
					if(respuesta[i]["montoPagar"] != ''){
						$("#payment6").val(Number(respuesta[i]["montoPagar"]))
					}

					$(".inputNumberModal").number(true, 2)

					// $("#registrarPago .modal-title").text(respuesta[i]["firstName"]+" "+respuesta[i]["lastName"]+" - "+respuesta[i]["descripcion_reserva"])
					// $("#metodoPago").text(respuesta[i]["abono"])
					// $("#cuotas").text(respuesta[i]["cuotas"])
					// $("#montoPagado").text(respuesta[i]["montoPagar"])
					// $("#valorCuotas").text(respuesta[i]["valorCuotas"])
					// totalAPagar = respuesta[i]["pago_reserva"]

				}

			}

		}

	})

	// buscar informacion de los pagos	

	var datos = new FormData();
  	datos.append("idReservaPago", idReserva);

  	$.ajax({

	    url:"ajax/reservas.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
		async: false,
	    success:function(respuesta){

			// console.log(respuesta)

			// var totalPagado = 0;

			// if(respuesta.length == 0){

			// 	$("#historialPagos").append('<tr><td colspan="4" class="font-italic">No hay pagos registrados</td></tr>');

			// }

			// 	totalPagado += Number(respuesta[i]["monto"])

			// 	var datos2 = new FormData();
			// 	datos2.append("idAdministrador", respuesta[i]["usuario"]);				

			// 	var tr = '<tr><td>'+respuesta[i]["fecha"]+'</td><td>'+respuesta[i]["metodo_pago"]+'</td>';

			// 	// traer informacion del usuario que registró el pago

			// 	$.ajax({

			// 		url:"ajax/administradores.ajax.php",
			// 		method: "POST",
			// 		data: datos2,
			// 		cache: false,
			// 		contentType: false,
			// 		processData: false,
			// 		dataType: "json",
			// 		async: false,
			// 		success:function(respuesta){

			// 			var usuario = respuesta["usuario"];
						
			// 			tr += '<td>'+usuario+'</td>';

			// 		}

			// 	})

			// 	// console.log(tr)

			// 	tr += '<td class="text-right">'+respuesta[i]["monto"]+'</td></tr>';

			// 	$("#historialPagos").append(tr) 

			// setTimeout(() => {

			// 	//console.log(totalAPagar)

			// 	var saldo = Number(totalAPagar) - Number(totalPagado)

			// 	$("#montoPago").attr("max", saldo)

			// 	$("#historialPagos").append('<tr class="font-italic"><td colspan="3" class="text-right">Total pagado</td><td class="text-right">'+totalPagado+'</td></tr>')
			// 	$("#historialPagos").append('<tr class="text-bold"><td colspan="3" class="text-right">Saldo pendiente</td><td class="text-right">'+saldo+'</td></tr>')
				
			// }, 100);	

			// agrupar pagos por metodos

			var type1 = 0;
			var type2 = 0;
			var type3 = 0;
			var type4 = 0;
			var type5 = 0;
			var type6 = Number($("#payment6").val());
			var type7 = 0;
			var type8 = 0;
			var total = Number($("#payment6").val());

			for(var i = 0; i < respuesta.length; i++){

				if(respuesta[i]["metodo_pago"] == "Bancolombia"){

					type1 += Number(respuesta[i]["monto"])
					total += Number(respuesta[i]["monto"])

				}else if(respuesta[i]["metodo_pago"] == "Efectivo"){

					type2 += Number(respuesta[i]["monto"])
					total += Number(respuesta[i]["monto"])

				}else if(respuesta[i]["metodo_pago"] == "Davivienda"){

					type3 += Number(respuesta[i]["monto"])
					total += Number(respuesta[i]["monto"])

				}else if(respuesta[i]["metodo_pago"] == "Nequi"){

					type4 += Number(respuesta[i]["monto"])
					total += Number(respuesta[i]["monto"])

				}else if(respuesta[i]["metodo_pago"] == "Daviplata"){

					type5 += Number(respuesta[i]["monto"])
					total += Number(respuesta[i]["monto"])

				}else if(respuesta[i]["metodo_pago"] == "Mercadopago"){

					type6 += Number(respuesta[i]["monto"])
					total += Number(respuesta[i]["monto"])

				}else if(respuesta[i]["metodo_pago"] == "Payu"){

					type7 += Number(respuesta[i]["monto"])
					total += Number(respuesta[i]["monto"])

				}
				else if(respuesta[i]["metodo_pago"] == "PSE"){

					type8 += Number(respuesta[i]["monto"])
					total += Number(respuesta[i]["monto"])

				}							

			}
			
			// asignar los valores agrupados a la tabla del modal

			console.log($("#payment6").val())

			$("#payment1").val(type1)
			$("#payment2").val(type2)
			$("#payment3").val(type3)
			$("#payment4").val(type4)
			$("#payment5").val(type5)
			$("#payment6").val(type6)
			$("#payment7").val(type7)
			$("#payment8").val(type8)
			$("#totalSumaModal").val(total)

			$(".inputNumberModal").number(true, 2)
					
		}

	})

})

$("#seleccionarMetodoPago").change(function(){

	var valor = $(this).val()

	if(valor != 6){

		$("#registrarPagoReserva").show()
		$("#btnLinkPago").hide()

	}else if(valor == 6){

		$("#registrarPagoReserva").hide()
		$("#btnLinkPago").show();

	}

})

$('#registrarPago').on('hidden.bs.modal', function () {
    
	$("#historialPagos").html('')

});

// $("#montoPago").change(function(){

// 	var valor = $(this).val()

// 	var max = $(this).attr("max")

// 	if(Number(valor) > Number(max)){

// 		swal({
// 			title: "Error",
// 			text: "¡El valor a cobrar es mayor que el saldo pendiente!",
// 			type: "error",
// 			confirmButtonText: "¡Cerrar!"
// 		});

// 		$("#montoPago").val(0)

// 	}

// })

$("#btnLinkPago").click(function(){

	var valor = $("#montoLinkModal").val()	

	// console.log(parseInt(valor))

	var min = $("#montoLinkModal").attr("min")	

	if(Number(valor) == '' || Number(valor) < Number(min)){

		swal({
			title: "Error al generar el link de pago",
			text: "¡El valor debe ser minimo $ 10.000 COP!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});

	}else{

		var data = $(this).attr("data")		

		var url = new URL(data);

		var search_params = url.searchParams;

		// new value of "id" is set to "101"
		search_params.set('pagoActual', parseInt(valor));

		// change the search property of the main url
		url.search = search_params.toString();

		// the new url string
		var new_url = url.toString();		
		
		$(this).html('<i class="fas fa-check"></i> Enlace copiado')
		$(this).removeClass("btn-info")
		$(this).addClass("btn-success")

		$(this).attr("data", new_url)
	
		copy($(this))     

	}

})

function copy(selector){
	var $temp = $("<div>");
	$("body").append($temp);
	$temp.attr("contenteditable", true)
		.html($(selector).attr("data")).select()
		.on("focus", function() { document.execCommand('selectAll',false,null); })
		.focus();
	document.execCommand("copy");
	$temp.remove();
}

// registrar abono

$("#registrarPagoReserva").click(function(){

	// var monto = $("#montoPago").val()

	// if(monto == 0 || monto == ''){

	// 	swal({
	// 		title: "Error al registrar el pago",
	// 		text: "¡Ingrese un monto válido!",
	// 		type: "error",
	// 		confirmButtonText: "¡Cerrar!"
	// 	});

	// }else{

		var idReserva = $("#registrarPagoReserva").attr("idReserva")	

		console.log(idReserva)

		// eliminar pagos anteriores

		var datos2 = new FormData();
		datos2.append("idEliminarPagos", idReserva);

		$.ajax({

			url:"ajax/pagos.ajax.php",
			method: "POST",
			data: datos2,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			async: false,
			success:function(respuesta){

			}

		})
		
		// registrar nuevos pagos

		var pagos = $('[id*="payment"]')					
		var correctos = 0;

		for (let index = 0; index < pagos.length; index++) {
			// var element = pagos[index];
			var metodo = $(pagos[index]).attr("metodo")
			var monto = $(pagos[index]).val()

			var datos = new FormData();
			datos.append("idReserva", idReserva);
			datos.append("monto", monto);
			datos.append("metodo_pago", metodo);
			datos.append("usuario", $("#user").val());

			$.ajax({

				url:"ajax/pagos.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				async: false,
				success:function(respuesta){

					//console.log(respuesta)

					if(respuesta == "ok"){

						correctos++;

					}

				}

			})
			
		}		

		if(correctos == pagos.length){

			swal({
				type: "success",
				title: "¡CORRECTO!",
				text: "Se guardaron los cambios correctamente",
				showConfirmButton: true,
				confirmButtonText: "Cerrar"
			}).then(function(result){

				if(result.value){

					$("#registrarPago").modal('hide');
					$("#registrarPago input").val('')

					const urlString = window.location.href;
					const url = new URL(urlString);
					const params = new URLSearchParams(url.search);

					const paramValue = params.get('pagina');

					if (paramValue == "verificar-reserva") {

						window.location.reload();
					
					} else {

						iniciarTabla(item, valor)
					
					}										

				}
			})

		}

	// }

})

$("#filterBy").change(function(){

	iniciarTabla(null, null)
	iniciarTabla2(null, null)

	var opt = $(this).val()

	if(opt == "reservas"){

		$("#filtrosOpt1, #containertable1").show()
		$("#filtrosOpt2, #containertable2").hide()	
		
		$(".valueSearch").datepicker("destroy")

	}else{

		$("#filtrosOpt1, #containertable1").hide()
		$("#filtrosOpt2, #containertable2").show()

		$(".valueSearch").datepicker({
			// startDate: '0d',
			// datesDisabled: '0d',
			format: 'dd-mm-yyyy',
			todayHighlight:true,
			autoclose: true
		});

	}

})

$(".searchBookingBtn").click(function(){

	var codigo = $("#valueSearchBooking").val()	

	// var datos = new FormData();
	// datos.append("idReservaMostrar", codigo);

	// $.ajax({

	// 	url:"ajax/reservas.ajax.php",
	// 	method: "POST",
	// 	data: datos,
	// 	cache: false,
	// 	contentType: false,
	// 	processData: false,
	// 	dataType: "json",
	// 	success:function(respuesta){

	// 		console.log(respuesta)

	// 	}

	// })

	console.log(urlServidor)

	window.location = urlServidor+"?pagina=verificar-reserva&reserva="+codigo

})

$("#searchManualBtn").click(function(){

	$("#searchManual").show()
	$("#searchQr").hide()

})

$("#searchQrBtn").click(function(){

	$("#searchQr").show()
	$("#searchManual").hide()

	function domReady(fn) {
		if (
			document.readyState === "complete" ||
			document.readyState === "interactive"
		) {
			setTimeout(fn, 1000);
		} else {
			document.addEventListener("DOMContentLoaded", fn);
		}
	}
	
	domReady(function () {
	
		// If found you qr code
		function onScanSuccess(decodeText, decodeResult) {
			
			window.location = urlServidor+"?pagina=verificar-reserva&reserva="+decodeText

		}
	
		let htmlscanner = new Html5QrcodeScanner(
			"my-qr-reader",
			{ fps: 10, qrbos: 250 }
		);
		htmlscanner.render(onScanSuccess);
	});

})

$(".inputNumberModal").number(true, 2)

$(".searchBy").change(function(){

	// console.log($(this).val())

	if($(this).val() == 'fecha_ingreso'){

		$(".valueSearch").datepicker({
			// startDate: '0d',
			// datesDisabled: '0d',
			format: 'dd-mm-yyyy',
			todayHighlight:true,
			autoclose: true
		});

	}else{

		$(".valueSearch").datepicker("destroy")

	}

})

// validar que los montos de los pagos del modal no superen el saldo pendiente

$('[id*="payment"]').on("change", function(){

	var pagos = $('[id*="payment"]')
	var total = 0;
	var pagoReserva = Number($("#totalReservaModal").val())

	for (let index = 0; index < pagos.length; index++) {
		var valor = $(pagos[index]).val()
		total += Number(valor)
	}

	$("#totalSumaModal").val(total)
	$(".inputNumberModal").number(true, 2)

// 	if(total > pagoReserva){

// 		swal({
// 			title: "Error",
// 			text: "¡La suma de los pagos supera el saldo pendiente!",
// 			type: "error",
// 			confirmButtonText: "¡Cerrar!"
// 		});

// 		$("#registrarPagoReserva").attr("disabled", true)

// 	}else{

		$("#registrarPagoReserva").removeAttr("disabled")

// 	}

})

// validar que el monto del link de pago no supere el saldo pendiente

$("#montoLinkModal").on("change", function(){

	var pago = Number($(this).val())
	var pagado = Number($("#totalSumaModal").val())
	var pagoReserva = Number($("#totalReservaModal").val())
	var saldo = pagoReserva - pagado

	if(pago > saldo){

		swal({
			title: "Error",
			text: "¡El monto supera el saldo pendiente!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});

		$("#montoLinkModal").val(0)

	}

})

// marcar asistencia

$("#changeStatus").click(function(){

	var status = $(this).attr("status")
	var idReserva = $(this).attr("idReserva")

	// console.log(status, idReserva)

	var datos = new FormData();
	datos.append("idReservaStatus", idReserva);
	datos.append("status", status);	

	$.ajax({

		url:"ajax/reservas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		// dataType: "json",
		async: false,
		success:function(respuesta){ 

			console.log(respuesta)

			if(status == "1"){

				var newStatus = 2
				var removeClass = "btn-outline-success"
				var addClass = "btn-outline-info"
				var content = '<i class="fas fa-minus-square fa-2x"></i><br>DESMARCAR COMO PRESENTE'

			}else{

				var newStatus = 1
				var removeClass = "btn-outline-info"
				var addClass = "btn-outline-success"
				var content = '<i class="fas fa-check-square fa-2x"></i><br>MARCAR COMO PRESENTE'

			}			

			if(respuesta == "ok"){ 

				$("#changeStatus").removeClass(removeClass)
				$("#changeStatus").addClass(addClass)
				$("#changeStatus").attr("status", newStatus)
				$("#changeStatus").html(content)

				window.location.reload();

			}

		}

	})

})

$("#consultarCuposModal").click(function(){

	var servicios = $("#servicioCuposModal").val()
	var fecha = $("#fechaCuposModal").val()

	console.log(servicios, fecha)

	if(servicios == '' || fecha == ''){

		$("#responseCuposModal").text("Seleccione una agrupacion de servicios y una fecha")

	}else{

		var datos = new FormData();
		datos.append("serviciosCupos", servicios)
		datos.append("fechaCupos", fecha)

		$.ajax({

			url:"ajax/reservas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			async: false,
			success:function(respuesta){

				if(!respuesta){

					$("#responseCuposModal").text("No se han ajustado los cupos para esta fecha")
					$("#cuposModal").val('')

				}else{

					$("#responseCuposModal").text("")
					$("#cuposModal").val(respuesta["cupos"])

				}

			}

		})

	}	

})

$("#submitCuposModal").click(function(){

	var servicios = $("#servicioCuposModal").val()
	var fecha = $("#fechaCuposModal").val()
	var cupos = $("#cuposModal").val()

	if(servicios == '' || fecha == '' || cupos == ''){

		$("#responseCuposModal").text("Seleccione una agrupacion de servicios y una fecha")

	}else{

		var datos = new FormData();
		datos.append("ajustarServicioCupos", servicios)
		datos.append("ajustarFechaCupos", fecha)
		datos.append("ajustarCupos", cupos)

		$.ajax({

			url:"ajax/reservas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			async: false,
			success:function(respuesta){

				if(respuesta == "ok"){

					swal({
						type: "success",
						title: "¡CORRECTO!",
						text: "Se ajustaron los cupos correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){

						if(result.value){
   
						   $("#modalAjustarCupos").modal("hide")
						   $("#modalAjustarCupos input,select").val('')
						   $("#responseCuposModal").text("")
   
						}
					})

				}

			}

		})

	}

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

  $("#descargarReservas").click(function(){

	// $("#containertable1").hide()
	// $("#containertable2").hide()

	iniciarTabla2("all", "all")	
	iniciarTabla("all", "all")		
	
	setTimeout(() => {
		
		$(".buttons-excel").each(function(){

			$(this).click()

		})

		// iniciarTabla(null, null)
		// iniciarTabla2(null, null)

	}, 5000);

  })

  $("#editarReserva").on('hide.bs.modal', function(){

	$("#copiarEnlaceDatos").attr("data", '')
	$("#copiarEnlaceDatos").html('<i class="fas fa-link"></i> Copiar enlace')
	$("#copiarEnlaceDatos").addClass("btn-outline-info")
	$("#copiarEnlaceDatos").removeClass("btn-outline-success")

  })
 
  $("#copiarEnlaceDatos").click(function(){

	var codigoReserva = $(this).attr("codigoReserva")
	var data = urlPrincipal+"index.php?pagina=completar-datos&token="+codigoReserva

	$(this).attr("data", data)

	$(this).html('<i class="fas fa-check"></i> Enlace copiado')
	$(this).removeClass("btn-outline-info")
	$(this).addClass("btn-outline-success")

	copy($(this))

  })

  $("#descargarQr").click(function(){

	var codigoReserva = $(this).attr("codigoReserva")

	window.open(urlPrincipal+"?pagina=reserva-exitosa&type=reserva&codigo="+codigoReserva+"&estado=completada", "_blank")

  })

  function copy(selector){
	var $temp = $("<div>");
	$("body").append($temp);
	$temp.attr("contenteditable", true)
		 .html($(selector).attr("data")).select()
		 .on("focus", function() { document.execCommand('selectAll',false,null); })
		 .focus();
	document.execCommand("copy");
	$temp.remove();
  }

//   $(".desmarcarEstado").click(function(){
$(document).on("click",".desmarcarEstado", function(){

	var idReserva = $(this).attr("idReserva");
	var fechaIngreso = $(this).attr("fecha");	

	var datos = new FormData();
	datos.append("idDesmarcarStatus", idReserva);
	datos.append("fechaStatus", formatDate(fechaIngreso));
	datos.append("desmarcarStatus", "0");

	// console.log(fechaIngreso)

	$.ajax({

		url:"ajax/reservas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(respuesta){

			// console.log(respuesta == "'ok'")

			if(respuesta == "ok"){
				swal({
					type: "success",
					title: "¡CORRECTO!",
					text: "Se desmarcó el estado correctamente",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"
				}).then(function(result){

					if(result.value){

						iniciarTabla(item, valor)

					}
				})

			}

		}

	})	

  })