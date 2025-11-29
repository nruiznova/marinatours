/*=============================================
Tabla Administradores
=============================================*/
// $.ajax({

// 	"url":"ajax/tablaAdministradores.ajax.php",
// 	success: function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

//Initialize Select2 Elements
$('.select2').select2()

$(".tablaAdministradores").DataTable({
	"ajax":"ajax/tablaAdministradores.ajax.php",
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0",
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

	}

});

/*=============================================
Editar Administrador
=============================================*/

$(document).on("click", ".editarAdministrador", function(){

	var idAdministrador = $(this).attr("idAdministrador");

	var datos = new FormData();
  	datos.append("idAdministrador", idAdministrador);

  	$.ajax({
  		url:"ajax/administradores.ajax.php",
  		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
    	success:function(respuesta){ 	

    		$('input[name="editarId"]').val(respuesta["id"]);
    		$('input[name="editarNombre"]').val(respuesta["nombre"]);
    		$('input[name="editarUsuario"]').val(respuesta["usuario"]);
    		$('input[name="passwordActual"]').val(respuesta["password"]);
    		$('.editarPerfilOption').val(respuesta["perfil"]);
    		$('.editarPerfilOption').html(respuesta["perfil"]);

			var permisos = JSON.parse(respuesta["permisos"]);	
			
			var mostrar = $("#editarAdministrador .visibleMod")
			var editar = $("#editarAdministrador .editableMod")
			
			for (let index = 0; index < permisos.length; index++) {							

				if(permisos[index]["mostrar"] == true){
					$(mostrar[index]).attr("checked", "checked").iCheck("update")
				}else{
					$(mostrar[index]).removeAttr("checked").iCheck("update")
				}				

				if(permisos[index]["editar"] == true){
					$(editar[index]).attr("checked", "checked").iCheck("update")
				}else{
					$(editar[index]).removeAttr("checked").iCheck("update")
				}								

			}

    	}

  	})

})

/*=============================================
Activar o desactivar administrador
=============================================*/

$(document).on("click", ".btnActivar", function(){

	var idAdmin = $(this).attr("idAdmin");
	var estadoAdmin = $(this).attr("estadoAdmin");
	var boton = $(this);

	var datos = new FormData();
  	datos.append("idAdmin", idAdmin);
  	datos.append("estadoAdmin", estadoAdmin);

  	 $.ajax({

      url:"ajax/administradores.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
      	
      	if(respuesta == "ok"){

      		if(estadoAdmin == 0){

      			 $(boton).removeClass('btn-info');
      			 $(boton).addClass('btn-dark');
      			 $(boton).html('Desactivado');
      			 $(boton).attr('estadoAdmin', 1);

      		}else{

	            $(boton).addClass('btn-info');
	            $(boton).removeClass('btn-dark');
	            $(boton).html('Activado');
	            $(boton).attr('estadoAdmin',0);

	        }

      	}

      }

    })  

})

/*=============================================
Eliminar Administrador
=============================================*/

$(document).on("click", ".eliminarAdministrador", function(){

	var idAdministrador = $(this).attr("idAdministrador");

	if(idAdministrador == 1){

		swal({
          title: "Error",
          text: "Este administrador no se puede eliminar",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

	}

	swal({
	    title: '¿Está seguro de eliminar este administrador?',
	    text: "¡Si no lo está puede cancelar la acción!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, eliminar administrador!'
	  }).then(function(result){

	    if(result.value){

	    	var datos = new FormData();
       		datos.append("idEliminar", idAdministrador);

       		$.ajax({

	          url:"ajax/administradores.ajax.php",
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
	                  text: "El administrador ha sido borrado correctamente",
	                  showConfirmButton: true,
	                  confirmButtonText: "Cerrar",
	                  closeOnConfirm: false
	                 }).then(function(result){

	                    if(result.value){

	                      window.location = "administradores";

	                    }
	                
	                })

	          	}

	          }

	        })  

	    }

	})

})

$(document).on("click", ".btnCopyLink", function(){

	var data = $(this)

	$(this).html('<i class="fas fa-check"></i> Enlace copiado')
	$(this).removeClass("btn-info")
	$(this).addClass("btn-success")

	copy(data)

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

// permisos

$(".form-check-input").on("ifChecked", function(){

	listarPermisos()
	listarPermisosEditar()

})

$(".form-check-input").on("ifUnchecked", function(){

	listarPermisos()
	listarPermisosEditar()

})

$(".checkAllVis").on("ifChecked", function(){	

	$(".visibleMod").attr('checked', 'checked').iCheck('update');	

})

$(".checkAllVis").on("ifUnchecked", function(){

	$(".visibleMod").removeAttr('checked').iCheck('update');

})

$(".checkAllEdit").on("ifChecked", function(){

	$(".editableMod").attr('checked', 'checked').iCheck('update');

})

$(".checkAllEdit").on("ifUnchecked", function(){

	$(".editableMod").removeAttr('checked').iCheck('update');

})

/*=============================================
LISTAR TODOS LOS PERMISOS
=============================================*/

function listarPermisos(){

	var listaPermisos = [];

	var modulo = $(".permissionMod");

	var mostrar = $(".visibleMod");

	var editar = $(".editableMod");

	for(var i = 0; i < modulo.length; i++){

		listaPermisos.push({ "modulo" : $(modulo[i]).val(),
							  "mostrar" : $(mostrar[i]).prop('checked'),							 							
							  "editar" : $(editar[i]).prop('checked')})

	}

	// console.log(listaPermisos)

	$("#listaPermisos").val(JSON.stringify(listaPermisos)); 

}

function listarPermisosEditar(){

	var listaPermisos = [];

	var modulo = $("#editarAdministrador .permissionMod");

	var mostrar = $("#editarAdministrador .visibleMod");

	var editar = $("#editarAdministrador .editableMod");

	for(var i = 0; i < modulo.length; i++){

		listaPermisos.push({ "modulo" : $(modulo[i]).val(),
							  "mostrar" : $(mostrar[i]).prop('checked'),							 							
							  "editar" : $(editar[i]).prop('checked')})

	}

	// console.log(listaPermisos)

	$("#listaPermisosEditar").val(JSON.stringify(listaPermisos)); 

}

/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btn').daterangepicker(
	{
	  ranges   : {
		'Hoy'       : [moment(), moment()],
		'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
		'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
		'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
		'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	  },
	  startDate: moment(),
	  endDate  : moment()
	},
	function (start, end) {

	  $('#daterange-btn').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  
	  var fechaInicial = start.format('YYYY-MM-DD');
  
	  var fechaFinal = end.format('YYYY-MM-DD');
  
	//   var capturarRango = $("#daterange-btn").html();

	  $("#fecha_inicial").val(fechaInicial)
	  $("#fecha_final").val(fechaFinal)

	//   console.log(start)
	 
		//  localStorage.setItem("capturarRango", capturarRango);
  
		//  window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  
	}
  
  )
  

  $(".editRange").click(function(){

	$("#typeAction").val("edit")

	$("#idRango").val($(this).attr("idRango"))

	$("#seleccionar-rango").show()

	// weekday: 'long',

	var options = { month: 'long', day: 'numeric', year: 'numeric' };	

	var fechaInicial = new Date($(this).attr("fechaInicial"));
	var fechaFinal = new Date($(this).attr("fechaFinal"));	

	$('#daterange-btn').html(fechaInicial.toLocaleDateString("es-ES", options) + ' - ' + fechaFinal.toLocaleDateString("es-ES", options))	

	// console.log(fechaInicial)

	$('#daterange-btn').daterangepicker({ 
			startDate: fechaInicial, // after open picker you'll see this dates as picked
			endDate: fechaFinal,
			locale: {
			   format: 'DD-MM-YYYY',
			}
		},function (start, end) {

			$('#daterange-btn').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		
			var fechaInicial = start.format('YYYY-MM-DD');
		
			var fechaFinal = end.format('YYYY-MM-DD');
		
		  //   var capturarRango = $("#daterange-btn").html();
	  
			$("#fecha_inicial").val(fechaInicial)
			$("#fecha_final").val(fechaFinal)
	  
		  //   console.log(start)
		   
			  //  localStorage.setItem("capturarRango", capturarRango);
		
			  //  window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
		
		  }
		  
		);

	$("#tilte-action").text("Editar rango de fechas bloqueadas")

  })

  $(".addRange").click(function(){

	$("#typeAction").val("add")

	$("#seleccionar-rango").show()
	$("#tilte-action").text("Seleccionar rango de fechas a bloquear")

	$('#daterange-btn').html('Seleccionar rango de fechas')

	$('#daterange-btn').daterangepicker('destroy');

	$('#daterange-btn').daterangepicker(
		{
		  ranges   : {
			'Hoy'       : [moment(), moment()],
			'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
			'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
			'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
			'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		  },
		  startDate: moment(),
		  endDate  : moment()
		},
		function (start, end) {
	
		  $('#daterange-btn').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	  
		  var fechaInicial = start.format('YYYY-MM-DD');
	  
		  var fechaFinal = end.format('YYYY-MM-DD');
	  
		//   var capturarRango = $("#daterange-btn").html();
	
		  $("#fecha_inicial").val(fechaInicial)
		  $("#fecha_final").val(fechaFinal)
	
		//   console.log(start)
		 
			//  localStorage.setItem("capturarRango", capturarRango);
	  
			//  window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
	  
		}
	  
	  )

	// $('#daterange-btn').datepicker('update');

  })

  $(".delRange").click(function(){

	$("#idRango").val($(this).attr("idRango"))
	$("#typeAction").val("del")

	swal({
		type: "info",
		title: "¿Está seguro de borrar?",
		text: "Esta acción no se puede retroceder",
		showConfirmButton: true,
		showCancelButton: true,
		confirmButtonText: "Si, borrar"
	   }).then(function(result){

		  if(result.value){

			$("#formBloquearFechas").submit()

		  }
	  })

  })

  $(".borrarGaleria").click(function(){

	var idGaleria = $(this).attr("idGaleria")

	// console.log(idGaleria)

	swal({
	    title: '¿Está seguro de eliminar la galeria?',
	    text: "¡Si no lo está puede cancelar la acción!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, eliminar galeria!'
	  }).then(function(result){

		if(result.value){			

			var datos = new FormData()
			datos.append("idDelGaleria", idGaleria)

			$.ajax({

				url:"ajax/administradores.ajax.php",
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
							text: "La galeria ha sido eliminada correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then(function(result){

							if(result.value){

								window.location = "galeria";

							}
						
						})

					}

				}

			})  

		}

	})

  })