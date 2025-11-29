<?php

if(isset($_POST["id-habitacion"])):

	$valor = $_POST["id-habitacion"];

	$habitacion = ControladorHabitaciones::ctrMostrarHabitacion($_POST["id-habitacion"]);
	
	$categoria = $habitacion["tipo_h"];

	$galeria = json_decode($habitacion["galeria"], true);

	$precios = json_decode($habitacion["precio"], true);   	
                
	$visibilidad = "false";                                           

	if(isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok"){                                    

		foreach ($precios as $row => $item) {
			
			if($_SESSION["nombre"] == $item["usuario"]){
        
				if($item["visibilidad"] == "true"){

					$precio = $item["precio"];
					$precioKids = $item["precioKids"];
					$visibilidad = "true";

				}else{

					$visibilidad == "false";

				}

			}

		}
		
	}else{

		foreach ($precios as $row => $item) {

			if($item["usuario"] == "Público en general"){

				$precio = $item["precio"];
				$precioKids = $item["precioKids"];
				$visibilidad = "true";

			}

		}

	}

?>

<div class="infoReservas container" style="padding-top:50px; color: #333" idHabitacion="<?php echo $_POST["id-habitacion"]; ?>" fechaIngreso="<?php echo $_POST["fecha-ingreso"]; ?>" fechaSalida="<?php echo $_POST["fecha-ingreso"]; ?>" dias="1" personas="<?php echo $_POST["cantidad-personas"]; ?>" kids="<?php echo '0'; ?>" ruta="<?php echo $habitacion["ruta"]; ?>"> 	


	<?php if(!isset($_SESSION["validarSesion"])): ?>
		<div class="button book_button trans_200 noprint"><a href="<?php echo $ruta ?>">Regresar a la web<span></span><span></span><span></span></a></div>
	<?php else: ?>
		<div class="button book_button trans_200 noprint"><a href="<?php echo $ruta ?>reservas">Consultar otro servicio<span></span><span></span><span></span></a></div>
	<?php endif; ?>

	<div class="py-5 noprint formDataBooking">
		<!-- <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
		<h2 class="intro_title">Confirmar reserva</h2>
		<small class="text-danger infoDisponibilidad"></small> 
	</div>

	<div class="print">
		<!-- <img class="d-block mx-auto mb-4" src="images/logo.png" alt="" width="150px"> -->
		<h2 class="intro_title text-success">¡Reserva exitosa!</h2>
		<p>
		Guarde este PDF con toda la informacion de su reserva para presentarlo en la fecha que reservó
		</p> 
	</div>

	<div class="row mb-5 formDataBooking">
		<div class="col-md-3 order-md-2 mb-4">
			<!-- <h4 class="d-flex justify-content-between align-items-center mb-3">
				<span class="text-muted">Información de la reserva</span>
				<span class="badge badge-secondary badge-pill"></span>
			</h4> -->
			<ul class="list-group mb-3 noprint">
				<li class="list-group-item d-flex justify-content-between lh-condensed">
				<div>
					<h5 class="my-0">Consultar disponibilidad</h5>
					<!-- <small class="text-danger infoDisponibilidad"></small> -->
				</div>
				<span class="text-muted"></span>
				</li>
				<li class="list-group-item"> 

					<form action="<?php echo $ruta; ?>reservas" method="post" id="cambiarFechaForm">
					
						<input type="hidden" name="id-habitacion" value="<?php echo $_POST["id-habitacion"]; ?>">						
						<div class="form-row align-items-center">
							<div class="col-sm-7 my-1">
								<label class="" for="">Fecha</label>
								<input type="text" class="form-control datepicker entrada" autocomplete="off" name="fecha-ingreso" id="" value="<?php echo $_POST["fecha-ingreso"]; ?>"> 
							</div>
							<div class="col-sm-5 my-1">
								<label class="" for="">Personas</label>
								<input type="number" class="form-control" id="" name="cantidad-personas" precio="<?php echo $precio; ?>" min="1" value="<?php echo $_POST["cantidad-personas"]; ?>">
							</div> 
							<div class="col-sm-6 my-1 d-none">
								<label class="" for="">Niños</label>
								<input type="number" class="form-control" id="" name="cantidad-child" min="0" value="0">
							</div>    
							<div class="col-12 my-1 d-flex">
							<!-- <br> -->
							<button type="submit" class="btn btn-info btn-block"><i class="fas fa-search"></i></button>
							</div>
						</div>

					</form>	

				</li>	
			</ul>
			<ul class="list-group mb-3">
				<!-- <li class="list-group-item d-flex justify-content-between lh-condensed noprint">
				<div class="noprint d-none">
					<h5 class="my-0 responseBooking">Disponibilidad</h5>
					<small class="infoDisponibilidad"></small>
				</div>
				<span class="text-muted"></span> 
				</li> -->
				<li class="list-group-item d-none justify-content-center lh-condensed">
					<!-- <img id='barcode' src="" alt="" title="HELLO" width="150" height="150" /> -->
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed">
				<div>
					<h5 class="my-0">Nombre del servicio</h5>
					<a href="<?php echo $ruta.$habitacion["ruta"]; ?>" target="_blank"><small class="text-muted text-uppercase"><?php echo $habitacion["estilo"]; ?></small></a>
				</div>
				<span class="text-muted">
					<img width="50px" src="<?php echo $servidor.$galeria[0]; ?>">
				</span>
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed">
				<div>
					<h5 class="my-0">Fecha de la reserva</h5>
					<small class="text-muted"><?php echo $_POST["fecha-ingreso"]; ?></small>
				</div>
				<span class="text-muted"></span>
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed">
				<div>
					<h5 class="my-0">Número de personas</h5>
					<small class="text-muted"><?php echo $_POST["cantidad-personas"] + $_POST["cantidad-child"]; ?></small>
				</div>
				<span class="text-muted"></span>
				</li>			
				<li class="list-group-item d-none containerCodigoReserva">
				<div>
					<h5 class="my-0">Código de la reserva</h5>
					<small class="text-muted codigoReserva"></small>
				</div>
				<span class="text-muted">
					
				</span>
				</li>						 
				<li class="list-group-item d-flex justify-content-between lh-condensed">
				<div>
					<h5 class="my-0">Total adultos</h5>
					<small class="text-muted" id="cantTotalAdultos" totalInicial="<?php echo $_POST["cantidad-personas"]; ?>" total="<?php echo $_POST["cantidad-personas"]; ?>" valor="<?php echo $precio; ?>">X <?php echo $_POST["cantidad-personas"]; ?></small>
				</div>
				<span class="text-muted" id="valorTotalAdultos">$<?php echo number_format($precio * $_POST["cantidad-personas"]); ?> COP</span>
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed">
				<div>
					<h5 class="my-0">Total niños</h5>
					<small class="text-muted" id="cantTotalNiños" total="<?php echo '0'; ?>" valor="<?php echo $precioKids; ?>">X <?php echo '0'; ?></small>
				</div>
				<span class="text-muted" id="valorTotalNiños">$<?php echo number_format($precioKids * $_POST["cantidad-child"]); ?> COP</span>
				</li> 			            
				<li class="list-group-item d-flex justify-content-between align-items-center lh-condensed">
				<div>
					<h5 class="my-0 mb-2" >Total</h5>
					<small class="text-muted">X <?php echo $_POST["cantidad-personas"] + $_POST["cantidad-child"]; ?> PERSONAS</small>
				</div>
				<strong style="" id="precioTotal">$<?php echo number_format($precio * $_POST["cantidad-personas"] + $precioKids * $_POST["cantidad-child"]); ?> COP</strong>
				</li>
				<li class="list-group-item d-flex justify-content-between bg-light">
				<div class="text-muted">
					<h5 class="my-0">50% del valor total</h5>
					<small></small>
				</div>
				<span class="text-muted" id="fraccionTotal">$<?php echo number_format((($precio * $_POST["cantidad-personas"])/ 2) + (($precioKids * $_POST["cantidad-child"]) / 2) ); ?> COP</span>
				</li>
				
			</ul>		
		</div>

		<div class="col-md-9 order-md-1 noprint">
			<!-- <h4 class="mb-3">Billing address</h4> -->
			<form class="needs-validation" novalidate>

				<div class="p-3 mb-2" style="border: 1px solid rgba(0, 0, 0, .125);">
					
					<div class="row">				
						<div class="col-12">
							<h5>Datos del titular de la reserva</h5>
							<small class="text-muted">Si va a pagar con tarjeta se recomienda que el titular de la reserva sea el mismo titular de la tarjeta</small>
							<hr>
						</div>
						<div class="col-md-6 mb-3">
							<label for="firstName">Nombres</label>
							<input type="text" class="form-control" id="firstName" placeholder="" value="" required>
							<div class="invalid-feedback">
							Este campo es obligatorio.
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="lastName">Apellidos</label>
							<input type="text" class="form-control" id="lastName" placeholder="" value="" required>
							<div class="invalid-feedback">
							Este campo es obligatorio.
							</div>
						</div>
					</div>   
					
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="tipo_identificacion">Tipo de identificación</label>
							<select class="form-control" id="tipo_identificacion" required>
								<option value="">--Seleccione--</option>
								<option value="cc">Cédula de ciudadania</option>
								<option value="ti">Tarjeta de identidad</option>
								<option value="rc">Registro Civil</option>
								<option value="te">Tarjeta de Extranjería</option>
								<option value="ce">Cédula de Extranjería</option>
								<option value="nit">Número de identificación Tributaria</option>
								<option value="pa">Pasaporte</option>
								<option value="ppt">Permiso Protección Temporal</option>
								<option value="de">Doc. de identificación Extranjera</option>
								<option value="pep">Permiso especial de permanencia</option>								
							</select>
							<div class="invalid-feedback">
							Este campo es obligatorio.
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="numero_identificacion">Número de identificación</label>
							<input type="text" class="form-control" id="numero_identificacion" placeholder="" value="" required>
							<div class="invalid-feedback">
							Este campo es obligatorio.
							</div>
						</div>
					</div>              
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="celular">Número de celular (con indicativo)</label>
							<input type="text" class="form-control" id="celular" placeholder="" value="" required>
							<div class="invalid-feedback">
								Este campo es obligatorio.
							</div>
						</div>                
						<div class="col-md-6">
							<label for="correo">Correo electrónico</label>
							<input type="email" class="form-control" id="correo" placeholder="" required>
							<div class="invalid-feedback">
							Este campo es obligatorio.
							</div>
						</div>
					</div>
					<input type="hidden" name="nacionalidad" value="">	
					<input type="hidden" class="acompañantesReserva" value="">				

				</div>	
				
				<div class="p-3 mb-2" id="containerAcompañantes" style="border: 1px solid rgba(0, 0, 0, .125);">
					
					<div class="row">				
						<div class="col-12">
							<h5>Beneficiarios de la reserva</h5>
							<small class="text-muted">** El precio para los <b>niños</b> con el rango de edad de 4-6 años es de <b>$<?php echo number_format($precioKids); ?> COP</b></small>
							<br><small class="text-muted">** Mujeres con embarazo inferior a 5 meses no puden tomar este servicio</b></small>
						</div>

						<!-- <div class="row"> -->
						<div class="col-md-4">
							<h5 class="mt-4">Cantidad de niños</h5>							

							<div class="input-group mb-3">
								<div class="input-group number-spinner">
									<button class="btn btn-outline-secondary" type="button" id="minusBtn">-</button>
									<input type="number" class="form-control" id="cantidadKids" name="cantidad-child" value="0" min="0" max="<?php echo $_POST["cantidad-personas"]; ?>" required>
									<button class="btn btn-outline-secondary" type="button" id="plusBtn">+</button>
								</div>
								
								<!-- <div class="input-group-append">
									<span class="btn input-group-text btn-outline-gold" id="addChild"><i class="fas fa-plus"></i></span>
								</div>
								<div class="input-group-append">
									<span class="btn input-group-text btn-outline-gold" id="delChild"><i class="fas fa-minus"></i></span>
								</div>								 -->
							</div>
						</div>
						<!-- </div> -->


						<div class="table-responsive p-3 d-none">

							<table class="table table-sm table-bordered text-center">

								<thead>

									<tr>
										<th># usuario</th>
										<th>Es niño?</th>
									</tr>

								</thead>

								<tbody>

								<?php 
								
								for ($i=0; $i < $_POST["cantidad-personas"]; $i++) { 

									if($_POST["cantidad-personas"] == 1 || $i == 0){

										$disabled = "disabled='true'";

									}else{										

										$disabled = "";

									}
									
									echo'<tr>
									
										<th>'.($i + 1).')</th>
										<td>
											<div class="form-check-1 text-center">
												<input type="checkbox" class="form-check-input typeGuest">											
											</div>
										</td>

									<tr>';

								}
								
								?>

								</tbody>

							</table>

						</div>

					</div>
				</div>
				
				<hr class="mb-4">
				
				<div class="<?php if($categoria === 3){ echo 'd-none'; } ?>">
				<div>¿Se encuentra hospedado en los sectores de Bocagrande, Laguito, Castillo Grande o Marbella?</div>
					<div class="form-check form-check-inline">
						<input class="" type="radio" name="hospedaje_hotel" id="inlineRadio1" value="si" checked>
						<label class="" for="inlineRadio1">SI</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="" type="radio" name="hospedaje_hotel" id="inlineRadio2" value="Muelle" <?php if($categoria === 3){ echo 'checked'; } ?>>
						<label class="" for="inlineRadio2">NO</label>
					</div>
				</div>   
				<div class="hotel <?php if($categoria === 3){ echo 'd-none'; } ?>">
					<label for="recogida">Ingresa el nombre del hotel</label>
					<input type="text" class="form-control" id="hotel_hospedado" placeholder="Ej: Hilton Cartagena" required>					
					<small class="text-muted">** Te recogeremos en el hotel que nos indiques **</small>
					<div class="invalid-feedback">
						Este campo es obligatorio.
					</div>
				</div>   
				<div class="nohotel" style="display:none">
					<!-- <label for="celular">Ingresa el nombre del hotel</label> -->
					<small class="text-muted">** El punto de encuentro será el muelle La Bodeguita **</small>
				</div> 
				<?php if(isset($_SESSION["validarSesion"])): ?>                     

					<div class="mt-2">
						<label for="recogida">Ingrese el nombre de la agencia que realiza la reserva</label>
						<input type="text" class="form-control" id="agencia_reserva" required>					
						<div class="invalid-feedback">
							Este campo es obligatorio.
						</div>
					</div>

				<?php endif; ?>
				<hr class="mb-4">
				<div>
					
					<div>Forma de pago</div>

					<?php
					
					if(isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok"){

						$precios = json_decode($habitacion["precio"], true);

						//var_dump($habitacion);

						foreach ($precios as $key => $value) {

							if($_SESSION["nombre"] == $value["usuario"]){

								if($value["visibilidad"] == "true" && $value["abono"] == "true"){

									$price = ($precio*$_POST["cantidad-personas"]) / 2 + ($precioKids * $_POST["cantidad-child"]) / 2;

									echo '
									
									
									<div class="form-check form-check-inline">
										<input class="" type="radio" name="abono" id="total1" precio="'.$price.'" value="abono">
										<label class="" for="total1">Abono (50%)</label>
									</div>';

								}

							}

						}

					}
					
					?>
					<div class="form-check form-check-inline">
						<input class="" type="radio" name="abono" id="total2" value="total" precio="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>" checked>
						<label class="" for="total2">Pagar totalidad</label>
					</div>
					<?php
					
					if(isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok"){

						$precios = json_decode($habitacion["precio"], true);

						//var_dump($habitacion);

						foreach ($precios as $key => $value) {

							if($_SESSION["nombre"] == $value["usuario"]){

								if($value["visibilidad"] == "true" && $value["credito"] == "true"){

									echo '<div class="form-check form-check-inline">
											<input class="" type="radio" name="abono" id="total3" value="credito">
											<label class="" for="total3">Pagar a crédito</label>
										</div>';

								}

							}

						}

					}
					
					?>
				</div>   
				
				<div class="pagoaCreditoDiv" style="display:none">
				<div class="row">
				<div class="col-md-4 mb-3">
					<label for="cuotas">Número de cuotas</label>
					<input type="number" class="form-control" id="cuotas" value="1" precio="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>" required>
					<div class="invalid-feedback">
					Este campo es obligatorio.
					</div>
				</div>
				<div class="col-md-4 mb-3 montoEspecifico" style="display:none">
					<label for="cuotas">Monto a pagar inicialmente</label> 
					<input type="number" class="form-control" id="montoPagar" precio="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>">				
				</div>
				<div class="col-md-4 mb-3">
					<label for="cuotas">Valor de las cuotas</label> 
					<input type="number" class="form-control" id="valorCuotas" value="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>" readonly required>				
				</div>			
				</div>
				<div>
					<div>Define la manera en que harás el pago</div>
					<div class="form-check form-check-inline">
						<input class="" type="radio" name="cuotas" precio="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>" id="primera" value="primera">
						<label class="" for="primera" checked>Pagar primera cuota</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="" type="radio" name="cuotas" precio="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>" id="monto" value="monto">
						<label class="" for="monto">Pagar un valor diferente</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="" type="radio" name="cuotas" precio="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>" id="nopago" value="nopago">
						<label class="" for="nopago">No pagar cuota inicial</label>
					</div>
				</div>
				</div>

				<input type="hidden" id="id_user" value="<?php if(isset($_SESSION["validarSesion"])){ echo $_SESSION["id"]; }  ?>">

				<hr>

				<div class="form-check mt-2">
					<input class="" type="checkbox" name="terminos" value="terminos" id="defaultCheck1" required>	 														
					<label class="" for="defaultCheck1">
						Acepto los <a href="<?php  echo $ruta; ?>tyc" target="_blank">Términos y condiciones</a>
					</label>
					<div class="invalid-feedback">
						Este campo es obligatorio.
					</div>
				</div>
				<div class="form-check  mb-2">
					<input class="" type="checkbox" name="datos_personales" value="datos_personales" id="defaultCheck2" required>
					<label class="" for="defaultCheck2">
						Autorizo el uso de mis <a href="<?php  echo $ruta; ?>datos-personales" target="_blank">Datos personales</a>
					</label>
					<div class="invalid-feedback">
						Este campo es obligatorio.
					</div>
				</div>
				
				<hr>
				<!-- <div class="" id="btnPagar"> -->
					<!-- <div class="button_bcg"></div> -->
					<?php if (isset($_SESSION["validarSesion"])): ?>

					<?php if ($_SESSION["validarSesion"] == "ok"): ?>

						<a style="text-decoration: none; color: inherit" href="<?php echo $ruta;?>perfil" 
							class="btn btn-default btn-lg call-to-action-btn-gold pagarReserva" id="btnPagar"
							idHabitacion="<?php echo $habitacion["id_h"]; ?>"
							imgHabitacion="<?php echo $servidor.$galeria[0]; ?>"
							infoHabitacion="<?php echo $habitacion["estilo"]; ?>"
							pagoReserva="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>"
							pagoActual="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>"
							codigoReserva=""
							fechaIngreso="<?php echo $_POST["fecha-ingreso"];?>"
							fechaSalida="<?php echo $_POST["fecha-ingreso"];?>"
							plan="" 
							personas="<?php echo $_POST["cantidad-personas"];?>"
							kids="<?php echo '0';?>">
							Ir a pagar
							<!-- <span></span><span></span><span></span></a> -->


					<?php endif ?>
								
					<?php else: ?> 
	 
						<a style="text-decoration: none; color: inherit" href="<?php echo $ruta;?>perfil"  
							class="btn btn-default btn-lg call-to-action-btn-gold pagarReserva" id="btnPagar"
							idHabitacion="<?php echo $habitacion["id_h"]; ?>"
							imgHabitacion="<?php echo $servidor.$galeria[0]; ?>"
							infoHabitacion="<?php echo $habitacion["estilo"]; ?>"
							pagoReserva="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>"
							pagoActual="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>"
							codigoReserva=""
							fechaIngreso="<?php echo $_POST["fecha-ingreso"];?>"
							fechaSalida="<?php echo $_POST["fecha-ingreso"];?>"
							plan="" 
							personas="<?php echo $_POST["cantidad-personas"];?>"
							kids="<?php echo '0';?>">
							Ir a pagar
							<!-- <span></span><span></span><span></span></a>-->

					<?php endif ?>
				<!-- </div> --> 

				<!-- <div class="" style="display: none;"> -->
					<!-- <div class="button_bcg"></div> -->
					<a style="text-decoration: none; color: inherit; display: none;" class="btn btn-default btn-lg call-to-action-btn-gold reservarSinPagar" href="#"
						idHabitacion="<?php echo $habitacion["id_h"]; ?>"
						imgHabitacion="<?php echo $servidor.$galeria[0]; ?>"
						infoHabitacion="<?php echo $habitacion["estilo"]; ?>"
						pagoReserva="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>"
						pagoActual="<?php echo ($precio*$_POST["cantidad-personas"]) + ($precioKids * $_POST["cantidad-child"]);?>" 
						codigoReserva=""
						fechaIngreso="<?php echo $_POST["fecha-ingreso"];?>"
						fechaSalida="<?php echo $_POST["fecha-ingreso"];?>"
						plan="" 
						personas="<?php echo $_POST["cantidad-personas"];?>"
						kids="<?php echo '0';?>">
						Reservar
						<!-- <span></span><span></span><span></span> -->
					</a>
				<!-- </div> -->
				
			</form>
		</div>
	</div>

	<div class="row mb-5 resposeBookingAvailability noprint" style="display: none;">

		<div class="col-lg-8 offset-lg-2">							

			<div class="card">
				<div class="card-header">
					<div class="alert alert-danger" role="alert">
						No se puede reservar <b><?php echo $habitacion["estilo"]; ?></b> por disponibilidad de cupos
						<br>
						<small class="responsePlaces">Solo hay 20 cupos disponibles</small>
						<br>
						<small>Por favor cambia la fecha o el número de personas</small>
					</div>
				</div>
				<div class="card-body">
					<form action="<?php echo $ruta; ?>reservas" method="post" id="cambiarFechaForm">
					
						<input type="hidden" name="test" value="<?php echo $_POST["id-habitacion"]; ?>">	
											
						<div class="form-row align-items-center">
						    <div class="col-sm-12 my-1">
    							<label class="" for="">Selecciona el servicio que deseas contratar</label>
    							<select class="form-control" name="id-habitacion" required> 
    
    									<option value="">--Seleccione--</option>
    
    									<?php 
    									
    										$habitaciones = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);
    
    										foreach ($habitaciones as $key => $value) { 
    										    
    										    if($_SESSION["nombre"]){
    
        											$visibilidad;
        
        											$precios = json_decode($value["precio"], true); 
        
        											foreach ($precios as $row => $item) {
        
        												if($_SESSION["nombre"] == $item["usuario"]){
        			
        													if($item["visibilidad"] == "true"){
        												
        														echo'<option value="'.$value["id_h"].'">'.$value["estilo"].'</option>';
        
        													}
        
        												}
        
        											}	
        											
    										    }else{
        
													echo'<option value="'.$value["id_h"].'">'.$value["estilo"].'</option>';

												}
    
    										}
    									
    									?>
    
    								</select>
    						</div>
							<div class="col-sm-7 my-1">
								<label class="" for="">Fecha</label>
								<input type="text" class="form-control datepicker entrada" autocomplete="off" name="fecha-ingreso" id="" value="<?php echo $_POST["fecha-ingreso"]; ?>"> 
							</div>
							<div class="col-sm-5 my-1">
								<label class="" for="">Personas</label>
								<input type="number" class="form-control" id="" name="cantidad-personas" precio="<?php echo $precio; ?>" min="1" value="<?php echo $_POST["cantidad-personas"]; ?>">
							</div> 
							<div class="col-sm-6 my-1 d-none">
								<label class="" for="">Niños</label>
								<input type="number" class="form-control" id="" name="cantidad-child" min="0" value="0">
							</div>    
							<div class="col-12 my-1 d-flex">
							<!-- <br> -->
							<button type="submit" class="btn btn-info btn-block"><i class="fas fa-search"></i></button>
							</div>
						</div>

					</form>	
				</div>
			</div>			

		</div>

	</div>
		
</div>

<?php else: ?>

	<div class="container">

		<div class="row pt-3">

			<div class="col-md-6 offset-lg-3">

			<ul class="list-group mb-3 noprint">
				<li class="list-group-item d-flex justify-content-between lh-condensed">
				<div>
					<h5 class="my-0">Consultar disponibilidad</h5>
					<!-- <small class="text-danger infoDisponibilidad"></small> -->
				</div>
				<span class="text-muted"></span>
				</li>
				<li class="list-group-item">

					<form action="<?php echo $ruta; ?>reservas" method="post" id="cambiarFechaForm">
					
						<input type="hidden" name="id-habitacion" value="">						
						<div class="form-row align-items-center">
							<div class="col-sm-12 my-1">
								<label class="" for="">Selecciona el servicio que deseas contratar</label>
								<select class="form-control" name="id-habitacion" required> 

									<option value="">--Seleccione--</option>

									<?php 
									
										$habitaciones = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

										foreach ($habitaciones as $key => $value) { 

											$visibilidad;

											$precios = json_decode($value["precio"], true); 

											foreach ($precios as $row => $item) {

												if($_SESSION["nombre"] == $item["usuario"]){
			
													if($item["visibilidad"] == "true"){
												
														echo'<option value="'.$value["id_h"].'">'.$value["estilo"].'</option>';

													}

												}

											}											

										}
									
									?>

								</select>
							</div>
							<div class="col-sm-7 my-1">
								<label class="" for="">Fecha</label>
								<input type="text" class="form-control datepicker entrada" autocomplete="off" name="fecha-ingreso" id="" value=""> 
							</div>
							<div class="col-sm-5 my-1">
								<label class="" for="">Personas</label>
								<input type="number" class="form-control" id="" name="cantidad-personas" min="1" value="">
							</div> 
							<div class="col-sm-6 my-1 d-none">
								<label class="" for="">Niños</label>
								<input type="number" class="form-control" id="" name="cantidad-child" min="0" value="0">
							</div>    
							<div class="col-12 my-1 d-flex">
							<!-- <br> -->
							<button type="submit" class="btn btn-info btn-block"><i class="fas fa-search"></i></button>
							</div>
						</div>

					</form>	

				</li>	
			</ul>
				
			</div>	

		</div>

	</div>
	
<?php endif; ?>

<div id="loader" style="
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(255, 255, 255, 0.8);
  z-index: 9999;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  font-family: sans-serif;
  pointer-events: all;
">

  <div class="spinner" style="
    border: 6px solid #ccc;
    border-top: 6px solid #333;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
  "></div>

  <p style="margin-top: 15px; font-size: 18px; color: #444;">
    Procesando reserva...
  </p>

</div>

<style>
  #loader {
    display: flex; /* Este hace el centrado */
	pointer-events: all;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
