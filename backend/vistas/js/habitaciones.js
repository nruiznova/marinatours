/*=============================================
360 GRADOS
=============================================*/

$(".360Antiguo").pano({
	img: $(".360Antiguo").attr("back")
});

/*=============================================
Plugin ckEditor
=============================================*/

ClassicEditor.create(document.querySelector('#descripcionHabitacion'), {

   toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', '|', 'undo', 'redo']

}).then(function (editor) {
  
    $(".ck-content").css({"height":"400px"})

}).catch(function (error) {

	// console.log("error", error);

})

/*=============================================
Tabla Habitaciones
=============================================*/

// $.ajax({

//     "url":"ajax/tablaHabitaciones.ajax.php",
//     success: function(respuesta){
      
//      console.log("respuesta", respuesta);

//     }

// })

$(".tablaHabitaciones").DataTable({
  "ajax":"ajax/tablaHabitaciones.ajax.php",
  "deferRender": true,
  "retrieve": true,
  "processing": true,
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

   }

})


/*=============================================
ARRASTRAR VARIAS IMAGENES GALERÍA
=============================================*/ 

var archivosTemporales = [];

$(".subirGaleria").on("dragenter", function(e){

	e.preventDefault();
  	e.stopPropagation();

  	$(".subirGaleria").css({"background":"url(vistas/img/plantilla/pattern.jpg)"})

})

$(".subirGaleria").on("dragleave", function(e){

  e.preventDefault();
  e.stopPropagation();

  $(".subirGaleria").css({"background":""})

})

$(".subirGaleria").on("dragover", function(e){

  e.preventDefault();
  e.stopPropagation();

})

$("#galeria").change(function(){

	var archivos = this.files;

	multiplesArchivos(archivos);

})

$(".subirGaleria").on("drop", function(e){

  e.preventDefault();
  e.stopPropagation();

  $(".subirGaleria").css({"background":""})

  var archivos = e.originalEvent.dataTransfer.files;
  
  multiplesArchivos(archivos);

})

$("#banner").change(function(){

	var archivos = this.files;

	multiplesArchivosBanner(archivos);

})

function multiplesArchivosBanner(archivos){

	for(var i = 0; i < archivos.length; i++){

		var imagen = archivos[i];

		console.log(imagen["type"])
		
		if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png" && imagen["type"] != "video/mp4"){

			swal({
	          title: "Error al subir el archivo",
	          text: "¡El archivo debe estar en formato JPG, PNG o MP4!",
	          type: "error",
	          confirmButtonText: "¡Cerrar!"
	        });

	        return;

		
		// else if(imagen["size"] > 2000000){

		// 	swal({
	    //       title: "Error al subir la imagen",
	    //       text: "¡La imagen no debe pesar más de 2MB!",
	    //       type: "error",
	    //       confirmButtonText: "¡Cerrar!"
	    //     });

	    //     return;

		}else{
		
			$(".quitarFotoNuevaBanner").click()

			var datosImagen = new FileReader;
      		datosImagen.readAsDataURL(imagen);

      		$(datosImagen).on("load", function(event){

      			  var rutaImagen = event.target.result;

				  $(".bannerServicio").val(event.target.result);

				  if(imagen["type"] != "video/mp4"){

					$(".vistaBanner").append(`

						<li class="col-12 col-md-6 col-lg-12 card px-3 rounded-0 shadow-none">
						  
							<img class="card-img-top" src="`+rutaImagen+`">
	
							<div class="card-img-overlay p-0 pr-3">
							  
							   <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNuevaBanner" temporal>
								 
								 <i class="fas fa-times"></i>
	
							   </button>
	
							</div>
	
						</li>
	
					  `)

				  }else{

					$(".vistaBanner").append(`

						<li class="col-12 col-md-6 col-lg-12 card px-3 rounded-0 shadow-none">
						  
							<video loop muted autoplay>
								<source src="`+rutaImagen+`" type="video/mp4">								
								Your browser does not support the video tag.
							</video>
	
							<div class="card-img-overlay p-0 pr-3">
							  
							   <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNuevaBanner" temporal>
								 
								 <i class="fas fa-times"></i>
	
							   </button>
	
							</div>
	
						</li>
	
					  `)

				  }      			


        		// if(archivosTemporales.length != 0){

        		// 	archivosTemporales = JSON.parse($(".inputNuevaGaleria").val());

        		// }

        		// archivosTemporales.push(rutaImagen);    

        		// $(".inputNuevaGaleria").val(JSON.stringify(archivosTemporales)) 		

      		})

		}	

	}	

}

function multiplesArchivos(archivos){

	for(var i = 0; i < archivos.length; i++){

		var imagen = archivos[i];
		
		if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png" && imagen["type"] != "video/mp4"){

			swal({
	          title: "Error al subir la imagen",
	          text: "¡La imagen debe estar en formato JPG, PNG o MP4!",
	          type: "error",
	          confirmButtonText: "¡Cerrar!"
	        });

	        return;

		}
		// else if(imagen["size"] > 2000000){

		// 	swal({
	    //       title: "Error al subir la imagen",
	    //       text: "¡La imagen no debe pesar más de 2MB!",
	    //       type: "error",
	    //       confirmButtonText: "¡Cerrar!"
	    //     });

	    //     return;

		// }
		else{

			var datosImagen = new FileReader;
      		datosImagen.readAsDataURL(imagen);

      		$(datosImagen).on("load", function(event){

      			var rutaImagen = event.target.result;

      			// $(".vistaGaleria").append(`

				// 	<li class="col-12 col-md-6 col-lg-3 card px-3 rounded-0 shadow-none">
                      
	            //         <img class="card-img-top" src="`+rutaImagen+`">

	            //         <div class="card-img-overlay p-0 pr-3">
	                      
	            //            <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNueva" temporal>
	                         
	            //              <i class="fas fa-times"></i>

	            //            </button>

	            //         </div>

	            //     </li>

      			// `)

				  if(imagen["type"] != "video/mp4"){

					$(".vistaGaleria").append(`
	
						<li class="col-12 col-md-6 col-lg-3 card px-3 rounded-0 shadow-none">
							
							<img class="card-img-top" src="`+rutaImagen+`">
	
							<div class="card-img-overlay p-0 pr-3">
								
								<button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNueva" temporal>
									
									<i class="fas fa-times"></i>
	
								</button>
	
							</div>
	
						</li>
	
						`)
	
					}else{
	
					$(".vistaGaleria").append(`
	
						<li class="col-12 col-md-6 col-lg-3 card px-3 rounded-0 shadow-none">
							
							<video loop muted autoplay>
								<source src="`+rutaImagen+`" type="video/mp4">								
								Your browser does not support the video tag.
							</video>
	
							<div class="card-img-overlay p-0 pr-3">
								
								<button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNueva" temporal>
									
									<i class="fas fa-times"></i>
	
								</button>
	
							</div>
	
						</li>
	
						`)
	
					} 


        		if(archivosTemporales.length != 0){

        			archivosTemporales = JSON.parse($(".inputNuevaGaleria").val());

        		}

        		archivosTemporales.push(rutaImagen);    

        		$(".inputNuevaGaleria").val(JSON.stringify(archivosTemporales)) 		

      		})

		}	

	}	

}

/*=============================================
QUITAR IMAGEN DE LA GALERÍA
=============================================*/

$(document).on("click", ".quitarFotoNueva", function(){

	var listaFotosNuevas = $(".quitarFotoNueva"); 
	
	var listaTemporales = JSON.parse($(".inputNuevaGaleria").val());

	for(var i = 0; i < listaFotosNuevas.length; i++){

		$(listaFotosNuevas[i]).attr("temporal", listaTemporales[i]);

		var quitarImagen = $(this).attr("temporal");

		if(quitarImagen == listaTemporales[i]){

			listaTemporales.splice(i, 1);

			$(".inputNuevaGaleria").val(JSON.stringify(listaTemporales));

			 $(this).parent().parent().remove();

		}

	}

})

$(document).on("click", ".quitarFotoNuevaBanner", function(){

	$(this).parent().parent().remove();

})


/*=============================================
AGREGAR VIDEO
=============================================*/

$(".agregarVideo").change(function(){

	var codigoVideo = $(this).val();

	$(".vistaVideo").html(
    
    `<iframe width="100%" height="320" src="https://www.youtube.com/embed/`+codigoVideo+`" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`

  )


})

/*=============================================
AGREGAR IMAGEN 360
=============================================*/

$("#imagen360").change(function(){

	var imagen = this.files[0];

	/*=============================================
	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
	=============================================*/

	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

		$("#imagen360").val("");

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen debe estar en formato JPG o PNG!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});

	}else if(imagen["size"] > 2000000){

		$("#imagen360").val("");

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen no debe pesar más de 2MB!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});

	}else{

		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event){

			var rutaImagen = event.target.result;

			 $(".ver360").html(

			 	`<div class="pano 360Nuevo" back="`+rutaImagen+`">

                    <div class="controls">
                      <a href="#" class="left">&laquo;</a>
                      <a href="#" class="right">&raquo;</a>
                    </div>

                  </div>`

			)

			$(".360Nuevo").pano({
		        img: $(".360Nuevo").attr("back")
		    });

		})

	}

})

/*=============================================
QUITAR IMAGEN VIEJA GALERÍA
=============================================*/

$(document).on("click", ".quitarFotoAntigua", function(){

	var listaFotosAntiguas = $(".quitarFotoAntigua"); 

	var listaTemporales = $(".inputAntiguaGaleria").val().split(",");

	for(var i = 0; i < listaFotosAntiguas.length; i++){

		quitarImagen = $(this).attr("temporal");

		if(quitarImagen == listaTemporales[i]){

			listaTemporales.splice(i, 1);

			$(".inputAntiguaGaleria").val(listaTemporales.toString());

			$(this).parent().parent().remove();

		}

	}
})

/*=============================================
GUARDAR HABITACIÓN
=============================================*/

$(".guardarHabitacion").click(function(){

	listarItinerario()
	listarCaracteristicas()
	listarPrecios()
	allInclude()
	allNoInclude()

	var idHabitacion = $(".idHabitacion").val();

	var tipo = $(".seleccionarTipo").val().split(",")[1];
	var tipo_h = $(".seleccionarTipo").val().split(",")[0];

	var estilo = $(".seleccionarEstilo").val();

	var ruta = $(".rutaCategoria").val()

	var banner = $(".bannerServicio").val() 

	var cupos = $(".cuposServicio").val()

	var serviciosEnlazados = $(".serviciosEnlazados").val().join(';')

	var precio = $(".precioServicio").val()

	var caracteristicas = $("#caracteristicas").val()

	var descripcion = $("#descripcion").val()

	var lugarSalida = $("#lugarSalida").val()

	var horaSalida = $("#horaSalida").val()

	var incluye = $("#allIncludes").val()

	var noIncluye = $("#allNoIncludes").val()

	var recomendaciones = $("#recomendaciones").val()

	var itinerario = $("#itinerario").val()

	var galeria = $(".inputNuevaGaleria").val();	
	 
	var galeriaAntigua = $(".inputAntiguaGaleria").val();	

	//console.log(serviciosEnlazados)

	var disabled = 0;

	$(".priceValue").each(function(){
		if($(this).val() == ''){
			disabled++
		}
	})	

	if(cupos == 0 || cupos == ''){

		swal({
	        title: "Error al guardar",
	        text: "Tiene que definir los cupos disponibles del servicio del servicio",
	        type: "error",
	        confirmButtonText: "¡Cerrar!"
	      });

    	return;

	}
	// else if(disabled == 3){

	// 	swal({
	//         title: "Error al guardar",
	//         text: "Tiene que definir la visibilidad y el precio del servicio",
	//         type: "error",
	//         confirmButtonText: "¡Cerrar!"
	//       });

    // 	return;

	// }
	else if(tipo == "" || tipo_h == ""){

		swal({
	        title: "Error al guardar",
	        text: "El campo 'Elija Categoría' no puede ir vacío",
	        type: "error",
	        confirmButtonText: "¡Cerrar!"
	      });

    	return;

	}else if(estilo == ""){

	    swal({
	        title: "Error al guardar",
	        text: "El campo 'Nombre del servicio' no puede ir vacío",
	        type: "error",
	        confirmButtonText: "¡Cerrar!"
	      });

	    return;

	}else if($(".vistaBanner li").length == 0 ||
		precio == '' ||
		caracteristicas == '' ||
		descripcion == '' ||
		lugarSalida == '' ||
		horaSalida == '' ||
		incluye == '' ||
		noIncluye == '' ||
		recomendaciones == '' ||
		itinerario == ''){

	    swal({
	        title: "Error al guardar",
	        text: "Complete todos los campos",
	        type: "error",
	        confirmButtonText: "¡Cerrar!"
	      });

	    return;

	}else{

    	var datos = new FormData();
    	datos.append("idHabitacion", idHabitacion);
    	datos.append("tipo_h", tipo_h);
    	datos.append("tipo", tipo);
    	datos.append("estilo", estilo);
		datos.append("ruta", ruta);
		datos.append("banner", banner);
		datos.append("cupos", cupos);
		datos.append("serviciosEnlazados", serviciosEnlazados);
		datos.append("precio", precio);
		datos.append("caracteristicas", caracteristicas);
		datos.append("descripcion", descripcion);
		datos.append("lugarSalida", lugarSalida);
		datos.append("horaSalida", horaSalida);
		datos.append("incluye", incluye);
		datos.append("noIncluye", noIncluye);
		datos.append("recomendaciones", recomendaciones);
		datos.append("itinerario", itinerario);
    	datos.append("galeria", galeria);
    	datos.append("galeriaAntigua", galeriaAntigua);

    	 $.ajax({

		    url:"ajax/habitaciones.ajax.php",
		    method: "POST",
		    data: datos,
		    cache: false,
		    contentType: false,
		    processData: false,
		    xhr: function(){
	        
		    	var xhr = $.ajaxSettings.xhr();

		    	xhr.onprogress = function(evt){ 

		    		var porcentaje = Math.floor((evt.loaded/evt.total*100));

		    		$(".preload").before(`

		    			<div class="progress mt-3" style="height:2px">
		    			<div class="progress-bar" style="width: `+porcentaje+`%;"></div>
		    			</div>`
		    			)

		    	};

		    	return xhr;
		          
		    },
	      	success:function(respuesta){

      			if(respuesta == "ok"){

      				swal({
		                type:"success",
		                  title: "¡CORRECTO!",
		                  text: "¡El servicio ha sido guardado exitosamente!",
		                  showConfirmButton: true,
		                confirmButtonText: "Cerrar"
		                
		              }).then(function(result){

		                  if(result.value){

		                    window.location = "servicios";

		                  }

		              });

      			}

      		}

      	})

        
    }


})

/*=============================================
Eliminar Habitacion
=============================================*/

$(document).on("click", ".eliminarHabitacion", function(){

  var idEliminar = $(this).attr("idEliminar");

  var galeriaHabitacion = $(this).attr("galeriaHabitacion");

//   var recorridoHabitacion = $(this).attr("recorridoHabitacion");

  swal({
    title: '¿Está seguro de eliminar este servicio?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, eliminar servicio!'
  }).then(function(result){

    if(result.value){

        var datos = new FormData();
        datos.append("idEliminar", idEliminar);
        datos.append("galeriaHabitacion", galeriaHabitacion);
        // datos.append("recorridoHabitacion", recorridoHabitacion);

        $.ajax({

          url:"ajax/habitaciones.ajax.php",
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
                  text: "El servicio ha sido borrado correctamente",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar"
                 }).then(function(result){

                    if(result.value){

                      window.location = "servicios";

                    }
                })

             }

          }

        })
    }
  
  })

})



$('[class*="_icon"]').change(function(){
	var icon = $(this).val()
	$("#previewIcon").attr('class', '');
	$("#previewIcon").addClass("fas "+icon)
})

var allArray = [];

$("#addInclude").click(function(){	
	var include = $("#incluye").val()	
	if(include != ''){
		$(this).parent().parent().after('<div class="input-group"><div class="input-group-prepend"><div class="input-group-text">-</div></div><input type="text" class="form-control tempInclude" id="" value="'+include+'"><div class="input-group-addon"><div class="input-group-text bg-danger btn deleteInclude">-</div></div></div>')
		$("#incluye").val('')
		allInclude()
	}	
})

$(document).on("click", ".deleteInclude", function(){
	$(this).parent().parent().remove()
	allInclude()
})

function allInclude(){
	allArray = []
	$(".tempInclude").each(function(){
		var el = $(this)
		allArray.push(el.val())
	})
	$("#allIncludes").val(allArray.join(";"))	
}

// no incluye
var allNoArray = [];

$("#addNoInclude").click(function(){	
	var include = $("#noIncluye").val()	
	if(include != ''){
		$(this).parent().parent().after('<div class="input-group"><div class="input-group-prepend"><div class="input-group-text">-</div></div><input type="text" class="form-control tempNoInclude" id="" value="'+include+'"><div class="input-group-addon"><div class="input-group-text bg-danger btn deleteInclude">-</div></div></div>')
		$("#noIncluye").val('')
		allNoInclude()
	}	
})

$(document).on("click", ".deleteInclude", function(){
	$(this).parent().parent().remove()
	allNoInclude()
})

function allNoInclude(){
	allNoArray = []
	$(".tempNoInclude").each(function(){
		var el = $(this)
		allNoArray.push(el.val())
	})
	$("#allNoIncludes").val(allNoArray.join(";"))
	//console.log(allArray)
}

function listarItinerario(){

	var listaItinerario = [];

	var hora = $('[id*="hora_itinerario_"]')
	var titulo = $('[id*="titulo_itinerario_"]')
	var descripcion = $('[id*="desc_itinerario_"]')

	for(var i = 0; i < descripcion.length; i++){

		listaItinerario.push({ "hora" : $(hora[i]).val(), 
							  "descripcion" : $(descripcion[i]).val(),
							  "titulo" : $(titulo[i]).val()})

	}

	$("#itinerario").val(JSON.stringify(listaItinerario));

}

function listarCaracteristicas(){

	var listaCaracteristicas = [];

	var icon =  $(".feature_icon")
	var title =  $(".feature_title")
	var description =  $(".feature_description")

	for(var i = 0; i < description.length; i++){

		listaCaracteristicas.push({ "icono" : $(icon[i]).val(), 
							  "descripcion" : $(description[i]).val(),
							  "titulo" : $(title[i]).val()})

	}

	//console.log(JSON.stringify(listaCaracteristicas))
	$("#caracteristicas").val(JSON.stringify(listaCaracteristicas));

}

function listarPrecios(){

	var listaPrecios = [];

	var usuario =  $(".priceUser")
	var visibilidad =  $(".priceVisible")
	var precio =  $(".priceValue")
	var precioKids = $(".priceValueKids")
	var credito = $(".priceCredit")
	var abono = $(".priceAbono")

	for(var i = 0; i < usuario.length; i++){

		listaPrecios.push({ "usuario" : $(usuario[i]).val(), 
							"visibilidad" : $(visibilidad[i]).is(':checked'),
							"precio" : $(precio[i]).val(),
							"precioKids" : $(precioKids[i]).val(),
							"credito" : $(credito[i]).is(':checked'),
							"abono" : $(abono[i]).is(':checked') })

	}

	console.log(JSON.stringify(listaPrecios))
	$(".precioServicio").val(JSON.stringify(listaPrecios));

}

function limpiarUrl(texto){

	var texto = texto.toLowerCase();
	texto = texto.replace(/[á]/g, 'a');
	texto = texto.replace(/[é]/g, 'e');
	texto = texto.replace(/[í]/g, 'i');
	texto = texto.replace(/[ó]/g, 'o');
	texto = texto.replace(/[ú]/g, 'u');
	texto = texto.replace(/[ñ]/g, 'n');
	texto = texto.replace(/ /g, '-');

	return texto;

}

$(".seleccionarEstilo").on("keyup", function(){
	var valor = $(this).val()
	$(".rutaCategoria").val(limpiarUrl(valor))
})

$('.priceVisible').on("ifChecked", function(){
	$(this).closest(".form-group").next().find(".priceValue").removeAttr("readonly")
	$(this).closest(".form-group").next().next().find(".priceValueKids").removeAttr("readonly")
});
$('.priceVisible').on("ifUnchecked", function(){
	$(this).closest(".form-group").next().find(".priceValue").attr("readonly", "true")
	$(this).closest(".form-group").next().next().find(".priceValueKids").attr("readonly", "true")
});

$(".editarGaleria").click(function(){

	var idGaleria = $(this).attr("idGaleria")
	window.location = "index.php?pagina=galeria&idGaleria="+idGaleria

})

$("#guardarGaleria").click(function(){

	var galeria = $(".inputNuevaGaleria").val();		 
	var galeriaAntigua = $(".inputAntiguaGaleria").val();
	var nombre = $("#nombreGaleria").val()
	var idGaleria = $("#idGaleria").val()

	var datos = new FormData()
	datos.append("galeria", galeria)
	datos.append("galeriaAntigua", galeriaAntigua)
	datos.append("nombre", nombre)
	datos.append("idGaleria", idGaleria)

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
					title: "Correcto",
					text: "Se guardaron los cambios correctamente",
					type: "success",
					confirmButtonText: "OK"
				  }).then(function(result){

					if(result.value){

					  window.location = "galeria";

					}

				});
		
				return;

			}

		}

	})

})

$("#crearNuevaSeccion").click(function(){

	var nombre = $("#nombreSeccion").val()

	var datos = new FormData()
	datos.append("nombreSeccion", nombre)

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
					title: "Correcto",
					text: "Se guardaron los cambios correctamente",
					type: "success",
					confirmButtonText: "OK"
				  }).then(function(result){

					if(result.value){

					  window.location = "galeria";

					}

				});
		
				return;

			}

		}

	})

})