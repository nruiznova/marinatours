/*=============================================
GESTIÓN DE PRECIOS POR TEMPORADA
=============================================*/

var idServicioTemporadaActual = null;

// Cuando se selecciona un servicio
$(document).on('click', '.servicio-temporada-item', function(e){
	e.preventDefault();
	
	// Remover clase activa de todos
	$('.servicio-temporada-item').removeClass('active');
	$(this).addClass('active');
	
	var idServicio = $(this).attr('data-id-servicio');
	idServicioTemporadaActual = idServicio;
	
	cargarTemporadasServicio(idServicio);
});

// Cargar temporadas de un servicio
function cargarTemporadasServicio(idServicio){
	
	var datos = new FormData();
	datos.append("idServicioTemporada", idServicio);
	
	$.ajax({
		url: "ajax/preciosTemporada.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			var html = '<div class="d-flex justify-content-between align-items-center mb-3">';
			html += '<h6 class="mb-0">Temporadas configuradas</h6>';
			html += '<button type="button" class="btn btn-success btn-sm" id="btnNuevaTemporada">';
			html += '<i class="fas fa-plus mr-1"></i>Nueva Temporada</button></div>';
			
			if(respuesta && respuesta.length > 0){
				
				html += '<div class="table-responsive">';
				html += '<table class="table table-sm table-hover">';
				html += '<thead class="thead-light">';
				html += '<tr><th>Temporada</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estado</th><th>Acciones</th></tr>';
				html += '</thead><tbody>';
				
				respuesta.forEach(function(temporada){
					
					var estado = temporada.activo == 1 ? '<span class="badge badge-success">Activa</span>' : '<span class="badge badge-secondary">Inactiva</span>';
					
					// CORREGIDO: Parsear fecha correctamente sin desfase de zona horaria
					// Agregar 'T00:00:00' para forzar interpretación local
					var fechaInicio = new Date(temporada.fecha_inicio + 'T00:00:00').toLocaleDateString('es-CO');
					var fechaFin = new Date(temporada.fecha_fin + 'T00:00:00').toLocaleDateString('es-CO');
					
					html += '<tr>';
					html += '<td><strong>'+temporada.nombre_temporada+'</strong></td>';
					html += '<td>'+fechaInicio+'</td>';
					html += '<td>'+fechaFin+'</td>';
					html += '<td>'+estado+'</td>';
					html += '<td>';
					html += '<button class="btn btn-warning btn-xs mr-1 editarTemporada" data-id="'+temporada.id_precio_temporada+'" title="Editar">';
					html += '<i class="fas fa-edit"></i></button>';
					html += '<button class="btn btn-danger btn-xs eliminarTemporada" data-id="'+temporada.id_precio_temporada+'" title="Eliminar">';
					html += '<i class="fas fa-trash"></i></button>';
					html += '</td></tr>';
					
				});
				
				html += '</tbody></table></div>';
				
			} else {
				html += '<div class="alert alert-warning">';
				html += '<i class="fas fa-exclamation-triangle mr-2"></i>';
				html += 'No hay temporadas configuradas para este servicio. Haga clic en "Nueva Temporada" para agregar una.';
				html += '</div>';
			}
			
			$('#contenidoTemporadasServicio').html(html);
		},
		error: function(jqXHR, textStatus, errorThrown){
			console.error("Error:", textStatus, errorThrown);
			$('#contenidoTemporadasServicio').html('<div class="alert alert-danger">Error al cargar las temporadas</div>');
		}
	});
}

// Botón nueva temporada
$(document).on('click', '#btnNuevaTemporada', function(){
	
	if(idServicioTemporadaActual == null){
		swal({
			type: "warning",
			title: "Atención",
			text: "Debe seleccionar un servicio primero"
		});
		return;
	}
	
	// Limpiar formulario completamente para CREAR nueva temporada
	$('#formTemporada')[0].reset();
	
	// Asegurar que el campo de ID esté completamente vacío (CRÍTICO)
	$('#id_precio_temporada_editar').val('');
	$('#id_precio_temporada_editar').removeAttr('value');
	
	// Establecer valores para nueva temporada
	$('#id_servicio_temporada').val(idServicioTemporadaActual);
	$('#nombre_temporada').val('');
	$('#fecha_inicio_temporada').val('');
	$('#fecha_fin_temporada').val('');
	$('#tituloFormTemporada').text('Nueva Temporada');
	$('#activo_temporada').prop('checked', true);
	
	// Limpiar precios y asegurar que los campos estén bloqueados
	$('#contenedorPreciosTemporada tr').each(function(){
		$(this).find('.precio-temp-visible').prop('checked', false);
		$(this).find('.precio-temp-adultos, .precio-temp-ninos').val('').attr('readonly', 'readonly');
		$(this).find('.precio-temp-credito, .precio-temp-abono').prop('checked', false);
	});
	
	console.log('✓ Nueva temporada iniciada');
	console.log('✓ ID editar:', $('#id_precio_temporada_editar').val(), '(debe estar vacío)');
	console.log('✓ ID servicio:', $('#id_servicio_temporada').val());
	
	$('#modalFormTemporada').modal('show');
});

// Control de visibility de precios - Usar eventos nativos (sin iCheck)
$(document).on('change', '.precio-temp-visible', function(){
	console.log('✓ Checkbox visible changed'); // Debug
	console.log('Checkbox element:', this); // Debug
	
	var $row = $(this).closest('tr');
	var isChecked = $(this).is(':checked');
	
	console.log('✓ Checkbox state:', isChecked); // Debug
	console.log('✓ Row found:', $row.length); // Debug
	
	if(isChecked){
		// HABILITAR campos de precio
		$row.find('.precio-temp-adultos').removeAttr('readonly');
		$row.find('.precio-temp-ninos').removeAttr('readonly');
		console.log('✓ Campos habilitados'); // Debug
	} else {
		// DESHABILITAR y limpiar
		$row.find('.precio-temp-adultos').attr('readonly', 'readonly').val('');
		$row.find('.precio-temp-ninos').attr('readonly', 'readonly').val('');
		$row.find('.precio-temp-credito, .precio-temp-abono').prop('checked', false);
		console.log('✓ Campos deshabilitados'); // Debug
	}
});

// Guardar temporada
$('#formTemporada').on('submit', function(e){
	e.preventDefault();
	
	// Recopilar precios
	var precios = [];
	
	$('#contenedorPreciosTemporada tr').each(function(){
		
		var usuario = $(this).find('.precio-temp-usuario').val();
		var visible = $(this).find('.precio-temp-visible').is(':checked');
		var adultos = $(this).find('.precio-temp-adultos').val();
		var ninos = $(this).find('.precio-temp-ninos').val();
		var credito = $(this).find('.precio-temp-credito').is(':checked');
		var abono = $(this).find('.precio-temp-abono').is(':checked');
		
		precios.push({
			usuario: usuario,
			visibilidad: visible.toString(),
			precio: adultos || '0',
			precioKids: ninos || '0',
			credito: credito.toString(),
			abono: abono.toString()
		});
	});
	
	$('#precios_temporada').val(JSON.stringify(precios));
	
	// Validar fechas
	var fechaInicio = new Date($('#fecha_inicio_temporada').val());
	var fechaFin = new Date($('#fecha_fin_temporada').val());
	
	if(fechaFin < fechaInicio){
		swal({
			type: "error",
			title: "Error",
			text: "La fecha de fin no puede ser anterior a la fecha de inicio"
		});
		return false;
	}
	
	// Enviar formulario (no es necesario renombrar campos, el controlador usa los mismos nombres)
	console.log('Enviando formulario...');
	console.log('ID para editar:', $('#id_precio_temporada_editar').val());
	console.log('Precios:', $('#precios_temporada').val());
	
	this.submit();
});

// Editar temporada
$(document).on('click', '.editarTemporada', function(){
	
	var idTemporada = $(this).attr('data-id');
	
	console.log('Editando temporada ID:', idTemporada);
	
	var datos = new FormData();
	datos.append("idPrecioTemporada", idTemporada);
	
	$.ajax({
		url: "ajax/preciosTemporada.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(temporada){
			
			console.log('Respuesta recibida:', temporada);
			
			// Verificar si hay error
			if(temporada.error){
				swal({
					type: "error",
					title: "Error",
					text: temporada.error
				});
				return;
			}
			
			// Llenar formulario
			$('#id_precio_temporada_editar').val(temporada.id_precio_temporada);
			$('#id_servicio_temporada').val(temporada.id_servicio);
			$('#nombre_temporada').val(temporada.nombre_temporada);
			$('#fecha_inicio_temporada').val(temporada.fecha_inicio);
			$('#fecha_fin_temporada').val(temporada.fecha_fin);
			$('#activo_temporada').prop('checked', temporada.activo == 1);
			$('#tituloFormTemporada').text('Editar Temporada');
			
			// Cargar precios
			var precios = JSON.parse(temporada.precios);
			
			$('#contenedorPreciosTemporada tr').each(function(index){
				
				if(precios[index]){
					
					var precio = precios[index];
					var row = $(this);
					
					row.find('.precio-temp-visible').prop('checked', precio.visibilidad === 'true');
					row.find('.precio-temp-adultos').val(precio.precio).prop('readonly', precio.visibilidad !== 'true');
					row.find('.precio-temp-ninos').val(precio.precioKids).prop('readonly', precio.visibilidad !== 'true');
					row.find('.precio-temp-credito').prop('checked', precio.credito === 'true');
					row.find('.precio-temp-abono').prop('checked', precio.abono === 'true');
				}
			});
			
			$('#modalFormTemporada').modal('show');
		},
		error: function(jqXHR, textStatus, errorThrown){
			console.error('Error AJAX:', textStatus, errorThrown);
			console.error('Respuesta:', jqXHR.responseText);
			
			swal({
				type: "error",
				title: "Error",
				text: "No se pudo cargar la información de la temporada. Revise la consola (F12) para más detalles."
			});
		}
	});
});

// Eliminar temporada
$(document).on('click', '.eliminarTemporada', function(){
	
	var idTemporada = $(this).attr('data-id');
	
	console.log('Eliminando temporada ID:', idTemporada);
	
	swal({
		title: '¿Está seguro de eliminar esta temporada?',
		text: "¡Esta acción no se podrá revertir!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Sí, eliminar temporada!'
	}).then(function(result){
		
		if(result.value){
			
			var datos = new FormData();
			datos.append("idEliminarTemporada", idTemporada);
			
			$.ajax({
				url: "ajax/preciosTemporada.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					
					console.log('Respuesta eliminar:', respuesta);
					
					if(respuesta == "ok"){
						
						swal({
							type: "success",
							title: "¡CORRECTO!",
							text: "La temporada ha sido eliminada correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							
							if(result.value){
								// Recargar las temporadas del servicio actual
								if(idServicioTemporadaActual != null){
									cargarTemporadasServicio(idServicioTemporadaActual);
								}
							}
						});
						
					} else {
						
						swal({
							type: "error",
							title: "Error",
							text: "No se pudo eliminar la temporada"
						});
						
					}
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					console.error('Error AJAX eliminar:', textStatus, errorThrown);
					console.error('Respuesta:', jqXHR.responseText);
					
					swal({
						type: "error",
						title: "Error",
						text: "Hubo un problema al conectar con el servidor. Revise la consola (F12) para más detalles."
					});
				}
			});
			
		}
	});
});

// Limpiar modal al cerrar
$('#modalPreciosTemporada').on('hidden.bs.modal', function(){
	$('.servicio-temporada-item').removeClass('active');
	$('#contenidoTemporadasServicio').html('<div class="alert alert-info"><i class="fas fa-info-circle mr-2"></i>Seleccione un servicio para ver y gestionar sus temporadas</div>');
	idServicioTemporadaActual = null;
});

$('#modalFormTemporada').on('shown.bs.modal', function(){
	console.log('✓ Modal temporada mostrado'); // Debug
	
	// DESTRUIR iCheck en estos checkboxes (categorias.js los inicializa globalmente)
	$('#contenedorPreciosTemporada .precio-temp-visible, #contenedorPreciosTemporada .precio-temp-credito, #contenedorPreciosTemporada .precio-temp-abono').each(function(){
		if($(this).data('iCheck')){
			$(this).iCheck('destroy');
			console.log('✓ iCheck destruido en checkbox'); // Debug
		}
	});
	
	// Verificar que los checkboxes existen
	var checkboxes = $('.precio-temp-visible');
	console.log('✓ Checkboxes encontrados:', checkboxes.length); // Debug
	console.log('✓ Primer checkbox:', checkboxes.first()[0]); // Debug
	
	// Inicializar estado de campos (sin iCheck)
	$('#contenedorPreciosTemporada tr').each(function(){
		var row = $(this);
		var isChecked = row.find('.precio-temp-visible').prop('checked');
		
		if(isChecked){
			row.find('.precio-temp-adultos, .precio-temp-ninos').removeAttr('readonly');
		} else {
			row.find('.precio-temp-adultos, .precio-temp-ninos').attr('readonly', 'readonly');
		}
	});
});

$('#modalFormTemporada').on('hidden.bs.modal', function(){
	// Limpiar completamente el formulario al cerrar
	$('#formTemporada')[0].reset();
	$('#id_precio_temporada_editar').val('');
	$('#id_servicio_temporada').val('');
	
	console.log('✓ Modal cerrado - formulario limpiado');
});
