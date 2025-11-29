<!-- header -->

<!--=====================================
HEADER
======================================-->

<header class="container-fluid p-0 bg-white">
	
	<div class="container p-0">
		
		<div class="grid-container py-2">

			<!-- LOGO -->
			
			<div class="grid-item">

				<a href="<?php echo $ruta;  ?>">
				
					<img src="img/logoPortobelo.png" class="img-fluid">

				</a>

			</div>

			<div class="grid-item d-none d-lg-block"></div>

			<!-- CAMPANA Y RESERVA -->

			<div class="grid-item d-none d-lg-block bloqueReservas">
				
				<div class="py-2 campana-y-reserva mostrarBloqueReservas" modo="abajo">

					<i class="fas fa-concierge-bell lead mx-2"></i>

					<i class="fas fa-caret-up lead mx-2 flechaReserva"></i>

				</div>	

				<!--=====================================
				FORMULARIO DE RESERVAS
				======================================-->

				<form action="<?php echo $ruta; ?>reservas" method="post">

					<div class="formReservas py-1 py-lg-2 px-4">
						
						<div class="form-group my-4">

							<select class="form-control form-control-lg selectTipoHabitacion" required>

								<option value="">Tipo de habitación</option>

								<?php foreach ($categorias as $key => $value): ?>

								<option value="<?php echo $value["ruta"]; ?>"><?php echo $value["tipo"]; ?></option>
									
								<?php endforeach ?>
								
							</select>

						</div>

						<div class="form-group my-4">
							<select class="form-control form-control-lg selectTemaHabitacion" name="id-habitacion" required>

								<option value="">Temática de habitación</option>
								
							</select>
						</div>

						<input type="hidden" id="ruta" name="ruta">

						<div class="row">
							
							 <div class="col-6 input-group input-group-lg pr-1">
							
								<input type="text" class="form-control datepicker entrada" autocomplete="off" placeholder="Entrada" name="fecha-ingreso" required>

								<div class="input-group-append">
									
									<span class="input-group-text p-2">
										<i class="far fa-calendar-alt small text-gray-dark"></i>
									</span>
								
								</div>

							</div>

							<div class="col-6 input-group input-group-lg pl-1">
							
								<input type="text" class="form-control datepicker salida" autocomplete="off" placeholder="Salida" name="fecha-salida" readonly required>

								<div class="input-group-append">
									
									<span class="input-group-text p-2">
										<i class="far fa-calendar-alt small text-gray-dark"></i>
									</span>
								
								</div>

							</div>

						</div>

						<input type="submit" class="btn btn-block btn-lg my-4 text-white" value="Ver disponibilidad">			

					</div>

				</form>

			</div>

			<!-- INGRESO DE USUARIOS -->

			<div class="grid-item d-none d-lg-block mt-2">

			<?php if (isset($_SESSION["validarSesion"])): ?>

				<?php if ($_SESSION["validarSesion"] == "ok"): ?>

					<a href="<?php echo $ruta.'perfil'; ?>">

					<?php if ($usuario["foto"] == ""): ?>
					
						<i class="fas fa-user"></i>

					<?php else: ?>

						<?php if ($usuario["modo"] == "directo"): ?>

							<img src="<?php echo $servidor.$usuario["foto"]; ?>" class="img-fluid rounded-circle" style="width:30px">
						
						<?php else: ?>
							
							<img src="<?php echo $usuario["foto"]; ?>" class="img-fluid rounded-circle" style="width:30px">

						<?php endif ?>	

					<?php endif ?>	

					</a>

				<?php endif ?>	

			<?php else: ?>

				<a href="#modalIngreso" data-toggle="modal"><i class="fas fa-user"></i></a>

			<?php endif ?>

				

			</div>

			<!-- SELECCIÓN DE IDIOMA -->

			<div class="grid-item d-none d-lg-block mt-1 idiomas">
				
				<!-- <span class="border border-info float-left p-1 bg-info text-white idiomaEs">ES</span>

				<span class="border border-info float-left p-1 bg-white text-dark idiomaEn">EN</span> -->	

				<form method="post" action="<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  ?>">
					
					<input type="hidden" name="idioma" value="es">

					<input type="submit" value="ES" class="border border-info float-left p-1 bg-info text-white idiomaEs px-2" style="cursor:pointer">

				</form>

				<form method="post" action="<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  ?>">
					
					<input type="hidden" name="idioma" value="en">

					<input type="submit" value="EN" class="border border-info float-left p-1 bg-white text-dark idiomaEn px-2" style="cursor:pointer">

				</form>

			</div> 

			<!-- MENÚ HAMBURGUESA -->

			<div class="grid-item mt-1 mt-sm-3 mt-md-4 mt-lg-2 botonMenu">
				
				<i class="fas fa-bars lead"></i>

			</div>

		</div>

	</div>

</header>

<!--=====================================
MENÚ
======================================-->

<nav class="menu container-fluid p-0">
	
	<ul class="nav nav-justified py-2">
		
		<li class="nav-item">
			<a class="nav-link text-white" href="#planes">Planes</a>
		</li>

		<li class="nav-item">
			<a class="nav-link text-white" href="#habitaciones">Habitaciones</a>
		</li>

		<li class="nav-item">
			<a class="nav-link text-white" href="#pueblo">El pueblo</a>
		</li>

		<li class="nav-item">
			<a class="nav-link text-white" href="#restaurante">Restaurante</a>
		</li>

		<li class="nav-item">
			<a class="nav-link text-white" href="#contactenos">Contáctenos</a>
		</li>

		<li class="nav-item">
			
			<ul class="my-2 py-1">
				
				<li>
					<a href="#" target="_blank">
						<i class="fab fa-facebook-f text-white float-left mx-2"></i>
					</a>
				</li>

				<li>
					<a href="#" target="_blank">
						<i class="fab fa-twitter text-white float-left mx-2"></i>
					</a>
				</li>

				<li>
					<a href="#" target="_blank">
						<i class="fab fa-youtube text-white float-left mx-2"></i>
					</a>
				</li>

				<li>
					<a href="#" target="_blank">
						<i class="fab fa-instagram text-white float-left mx-2"></i>
					</a>
				</li>

			</ul>
			
		</li>

	</ul>


</nav>

<!--=====================================
MENÚ MÓVIL
======================================-->
<div class="menuMovil">
	
	<div class="row">
		
		<div class="col-6">
			
			<a href="#modalIngreso" data-toggle="modal">
				<i class="fas fa-user lead ml-3 mt-4"></i>
			</a>

		</div>	

		<div class="col-6">
			
			<div class="float-right mr-3 mt-3 mr-sm-5 mt-sm-4">
				
				<span class="border border-info float-left p-1 bg-info text-white idiomaEs">ES</span>
				<span class="border border-info float-left p-1 bg-white text-dark idiomaEn">EN</span>

			</div>	

		</div>	

	</div>

	<form action="<?php echo $ruta; ?>reservas" method="post">

		<div class="formReservas py-1 py-lg-2 px-4">
						
			<div class="form-group my-4">
				<select class="form-control form-control-lg selectTipoHabitacion" required>

					<option value="">Tipo de habitación</option>

					<?php foreach ($categorias as $key => $value): ?>

					<option value="<?php echo $value["ruta"]; ?>"><?php echo $value["tipo"]; ?></option>
						
					<?php endforeach ?>
					
				</select>
			</div>

			<div class="form-group my-4">
				<select class="form-control form-control-lg selectTemaHabitacion" name="id-habitacion" required>

					<option value="">Temática de habitación</option>
					
				</select>
			</div>

			<input type="hidden" id="ruta" name="ruta">

			<div class="row">
				
				 <div class="col-6 input-group input-group-lg pr-1">
				
					<input type="text" class="form-control datepicker entrada" name="fecha-ingreso" placeholder="Entrada" autocomplete="off" required>

					<div class="input-group-append">
						
						<span class="input-group-text p-2">
							<i class="far fa-calendar-alt small text-gray-dark"></i>
						</span>
					
					</div>

				</div>

				<div class="col-6 input-group input-group-lg pl-1">
				
					<input type="text" class="form-control datepicker salida" name="fecha-salida" placeholder="Salida" autocomplete="off" readonly required>

					<div class="input-group-append">
						
						<span class="input-group-text p-2">
							<i class="far fa-calendar-alt small text-gray-dark"></i>
						</span>
					
					</div>

				</div>

			</div>

			<input type="submit" class="btn btn-block btn-lg my-4 text-white" value="Ver disponibilidad" style="background:black">
			
		</div>

	</form>

	<ul class="nav flex-column mt-4 pl-4 mb-5">
		
		<li class="nav-item">
			<a class="nav-link text-white my-2" href="#planesMovil">Planes</a>
		</li>

		<li class="nav-item">
			<a class="nav-link text-white my-2" href="#habitaciones">Habitaciones</a>
		</li>

		<li class="nav-item">
			<a class="nav-link text-white my-2" href="#pueblo">Recorrido por el pueblo</a>
		</li>

		<li class="nav-item">
			<a class="nav-link text-white my-2" href="#restaurante">Restaurante</a>
		</li>

		<li class="nav-item">
			<a class="nav-link text-white my-2" href="#contactenos">Contáctenos</a>
		</li>

	</ul>

</div>

<!-- footer -->

<div class="contactenos container-fluid bg-white py-4" id="contactenos">
	
	<div class="container text-center">
		
		<h1 class="py-sm-4">CONTÁCTENOS</h1>

		<form method="post">

			<div class="input-group input-group-lg">
				
				<input type="text" class="form-control mb-3 mr-2 form-control-lg" placeholder="Nombre" name="nombreContactenos" required>

				<input type="text" class="form-control mb-3 ml-2 form-control-lg" placeholder="Apellido" name="apellidoContactenos" required>

			</div>

			<div class="input-group input-group-lg">
				
				<input type="text" class="form-control mb-3 mr-2 form-control-lg" placeholder="Móvil" name="movilContactenos" required>

				<input type="text" class="form-control mb-3 ml-2 form-control-lg" placeholder="Correo Electrónico" name="emailContactenos" required>

			</div>

			<textarea class="form-control" rows="6" placeholder="Escribe aquí tu mensaje" name="mensajeContactenos" required></textarea>

			<button type="submit" class="btn btn-dark my-4 btn-lg py-3 text-uppercase w-50">Enviar</button>
			
			<?php

				$contactenos = new ControladorUsuarios();
				$contactenos -> ctrFormularioContactenos();
			
			?>

		</form>

	</div>

</div>

<!--=====================================
MAPA
======================================-->
<div class="mapa container-fluid bg-white p-0">
	
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2181015083097!2d-75.16167268476889!3d6.2349559954867315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e441d2a2f90b049%3A0xe73c0a7060062903!2sHOTEL+PORTOBELO+GUATAPE!5e0!3m2!1ses!2sco!4v1544281019677" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

	<div class=" p-4 info"> 

		<h3 class="mt-4"><strong>Visítanos</strong></h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

		<p>
		Apple inc.<br>
		Infinte Loop.<br>
		Cupertino, CA 95014<br>
		408-996-1010
		</p>

		<p class="pb-4">Email: info@apple.com<br>
		Tel: 1-800-676-2775</p>

	</div>	

</div>

<!--=====================================
FOOTER
======================================-->

<footer class="container-fluid p-0">

	<div class="grid-container">
			
		<div class="grid-item d-none d-lg-block pt-2"></div>

		<div class="grid-item d-none d-lg-block pt-2">
			
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat.</p>

		</div>

		<div class="grid-item pt-2">
			
			<ul class="py-1">

				<li>
					<a href="#" target="_blank"><i class="fab fa-facebook-f lead text-white float-left mx-3"></i></a>
				</li>

				<li>
					<a href="#" target="_blank"><i class="fab fa-twitter lead text-white float-left mx-3"></i></a>
				</li>

				<li>
					<a href="#" target="_blank"><i class="fab fa-youtube lead text-white float-left mx-3"></i></a>
				</li>


				<li>
					<a href="#" target="_blank"><i class="fab fa-instagram lead text-white float-left mx-3"></i></a>
				</li>	
			
			</ul>	

		</div>

	</div>

</footer>

<!--=====================================
REDES SOCIALES MÓVIL
======================================-->

<ul class="redesMovil p-2 nav nav-justified">

	<li class="nav-item">
		<a href="#" target="_blank"><i class="fab fa-facebook-f lead text-white"></i></a>
	</li>

	<li class="nav-item">
		<a href="#" target="_blank"><i class="fab fa-twitter lead text-white"></i></a>
	</li>

	<li class="nav-item">
		<a href="#" target="_blank"><i class="fab fa-youtube lead text-white"></i></a>
	</li>

	<li class="nav-item">
		<a href="#" target="_blank"><i class="fab fa-instagram lead text-white"></i></a>
	</li>	

</ul>

<!-- inicio -->

<?php

include "modulos/banner.php";

include "modulos/planes.php";

include "modulos/habitaciones.php";

include "modulos/planes-movil.php";

include "modulos/recorrido-pueblo.php";

include "modulos/restaurante.php";

?>

<!-- banner -->

<div class="banner container-fluid p-0">
	
	<div class="jd-slider fade-slider">
		
		<div class="slide-inner">
			
			<ul class="slide-area">

                <?php foreach ($banner as $key => $value): ?>
                
        				
				 <li>					
                    <img src="<?php echo $servidor.$value["img"]; ?>" width="100%">
                </li>
  

               <?php endforeach ?>

			</ul>

		</div>

	 	<div class="controller d-none">
		 	
			<a class="auto" href="#">

                <i class="fas fa-play fa-xs"></i>
                <i class="fas fa-pause fa-xs"></i>

            </a>

            <div class="indicate-area"></div>

	 	</div>

	 	<div class="verMas text-center bg-white rounded-circle d-none d-lg-block" vinculo="#planes">
    
    		<i class="fas fa-chevron-down"></i>	

    	</div>

	</div>

</div>

<!-- habitaciones -->

<div class="habitaciones container-fluid bg-light" id="habitaciones">
	
	<div class="container">

		<h1 class="pt-4 text-center">HABITACIONES</h1>

		<div class="row p-4 text-center">

			<?php foreach ($categorias as $key => $value): ?>
				
			<div class="col-12 col-lg-4 pb-3 px-0 px-lg-3">

				<a href="<?php echo $ruta.$value["ruta"];  ?>">
					
					<figure class="text-center">
						
						<img src="<?php echo $servidor.$value["img"]; ?>" class="img-fluid" width="100%">

						<p class="small py-4 mb-0"><?php echo $value["descripcion"]; ?></p>

						<h3 class="py-2 text-gray-dark mb-0">DESDE $<?php echo number_format($value["continental_baja"]); ?> COP</h3>

						<h5 class="py-2 text-gray-dark border">Ver detalles <i class="fas fa-chevron-right ml-2"></i></h5>
						
						<h1 class="text-white p-3 mx-auto w-50 lead text-uppercase" style="background:<?php echo $value["color"]; ?>"><?php echo $value["tipo"]; ?></h1>

					</figure>

				</a>

			</div>

			<?php endforeach ?>

		</div>

	</div>

</div>

<!-- habitaciones -->

<?php

include "modulos/banner-interior.php";
include "modulos/info-habitaciones.php";
include "modulos/testimonios.php";
include "modulos/planes.php";
include "modulos/planes-movil.php";
include "modulos/recorrido-pueblo.php";
include "modulos/restaurante.php";

?>

<!-- info habitaciones -->

<div class="infoHabitacion container-fluid bg-white p-0 pb-5">
	
	<div class="container">
		
		<div class="row">

			<!--=====================================
			BLOQUE IZQ
			======================================-->
			
			<div class="col-12 col-lg-8 colIzqHabitaciones p-0">
				
				<!--=====================================
				CABECERA HABITACIONES
				======================================-->
				
				<div class="pt-4 cabeceraHabitacion">

					<a href="<?php echo $ruta;  ?>" class="float-left lead text-white pt-1 px-3">
						<h5><i class="fas fa-chevron-left"></i> Regresar</h5>
					</a>

					<h2 class="float-right text-white px-3 categoria text-uppercase"><?php echo $habitaciones[0]["tipo"]; ?></h2>

					<div class="clearfix"></div>

					<ul class="nav nav-justified mt-lg-4">	

						<?php foreach ($habitaciones as $key => $value): ?>

						<li class="nav-item">

							<a class="nav-link text-white" orden="<?php echo $key; ?>" ruta="<?php echo $_GET["pagina"]; ?>" href="#">
								 <?php echo $value["estilo"]; ?>
							</a>

						</li>
							
						<?php endforeach ?>

						
	
					</ul>

				</div>

				<!--=====================================
				MULTIMEDIA HABITACIONES
				======================================-->

				<!-- SLIDE  -->

				<section class="jd-slider mb-3 my-lg-3 slideHabitaciones">
		      	       
			        <div class="slide-inner">
			            
			            <ul class="slide-area">
 
			            <?php

			            $galeria = json_decode($habitaciones[0]["galeria"], true);
			           
			            ?>

			            <?php foreach ($galeria as $key => $value): ?>
			            	
		            	  	<li>	

								<img src="<?php echo $servidor.$value; ?>" class="img-fluid">

							</li>


			            <?php endforeach ?>

						</ul>

					</div>

				  	  	<a class="prev d-none d-lg-block" href="#">
				            <i class="fas fa-angle-left fa-2x"></i>
				        </a>

				        <a class="next d-none d-lg-block" href="#">
				            <i class="fas fa-angle-right fa-2x"></i>
				        </a>

				         <div class="controller d-block d-lg-none">

					        <div class="indicate-area"></div>

					    </div>
									   
				</section>

				<!-- VIDEO  -->

				<section class="mb-3 my-lg-3 videoHabitaciones d-none">
					
					<iframe width="100%" height="380" src="https://www.youtube.com/embed/<?php  echo $habitaciones[0]["video"]; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				
				</section>

				<!-- 360 GRADOS -->

				<section class="mb-3 my-lg-3 360Habitaciones d-none">

					<div id="myPano" class="pano" back="<?php  echo $servidor.$habitaciones[0]["recorrido_virtual"]; ?>">

						<div class="controls">
							<a href="#" class="left">&laquo;</a>
							<a href="#" class="right">&raquo;</a>
						</div>

					</div>
									
				</section>

				<!--=====================================
				DESCRIPCIÓN HABITACIONES
				======================================-->	

				<div class="descripcionHabitacion px-3">
					
					<h1 class="colorTitulos float-left"><?php echo $habitaciones[0]["estilo"]." ".$habitaciones[0]["tipo"] ?></h1>

					<div class="float-right pt-2">
						
						<button type="button" class="btn btn-default" vista="fotos"><i class="fas fa-camera"></i> Fotos</button>

						<button type="button" class="btn btn-default" vista="video"><i class="fab fa-youtube"></i> Video</button>
			
						<button type="button" class="btn btn-default" vista="360"><i class="fas fa-video"></i> 360°</button>
							
					</div>

					<div class="clearfix mb-4"></div>	

					<div class="d-habitacion">
						
						<?php echo $habitaciones[0]["descripcion_h"]; ?>

					</div> 

					<form action="<?php echo $ruta; ?>reservas" method="post">

						<input type="hidden" name="id-habitacion" value="<?php echo $habitaciones[0]["id_h"]; ?>">
					
						<!-- ESCENARIO 2 Y 3 DE RESERVAS -->
						<!-- <input type="hidden" name="id-habitacion" value="<?php echo $nuevoArrayHab; ?>"> -->

						<input type="hidden" name="ruta" value="<?php echo $habitaciones[0]["ruta"]; ?>">

						<div class="container">

							<div class="row py-2" style="background:#509CC3">

								 <div class="col-6 col-md-3 input-group pr-1">
								
									<input type="text" class="form-control datepicker entrada" placeholder="Entrada" autocomplete="off" name="fecha-ingreso"  required>

									<div class="input-group-append">
										
										<span class="input-group-text"><i class="far fa-calendar-alt small text-gray-dark"></i></span>
									
									</div>

								</div>

							 	<div class="col-6 col-md-3 input-group pl-1">
								
									<input type="text" class="form-control datepicker salida" placeholder="Salida" autocomplete="off" name="fecha-salida" readonly required>

									<div class="input-group-append">
										
										<span class="input-group-text"><i class="far fa-calendar-alt small text-gray-dark"></i></span>
									
									</div>

								</div>

								<div class="col-12 col-md-6 mt-2 mt-lg-0 input-group">
											
									<input type="submit" class="btn btn-block btn-md text-white" value="Ver disponibilidad" style="background:black">									
								</div>

							</div>

						</div>

					</form>

				</div>

			</div>
			
			<!--=====================================
			BLOQUE DER
			======================================-->

			<div class="col-12 col-lg-4 colDerHabitaciones">

				<h2 class="colorTitulos text-uppercase"><?php echo $habitaciones[0]["tipo"]; ?> INCLUYE:</h2>
				
				<ul>

				<?php

					$incluye = json_decode($habitaciones[0]["incluye"], true);

				?>

				<?php foreach ($incluye as $key => $value): ?>

					<li>
						<h5>
							<i class="<?php echo $value["icono"]; ?> w-25 colorTitulos"></i> 
							<span class="text-dark small"><?php echo $value["item"]; ?></span>
						</h5>
					</li>
					
				<?php endforeach ?>

				</ul>

				<!-- HABITACIONES -->

				<div class="habitaciones" id="habitaciones">

					<div class="container">

						<div class="row">


						<?php

							$categorias = ControladorCategorias::ctrMostrarCategorias();

						?>

						<?php foreach ($categorias as $key => $value): ?>

							<?php if ($_GET["pagina"] != $value["ruta"]): ?>
 
							<div class="col-12 pb-3 px-0 px-lg-3">

									<a href="<?php echo $ruta.$value["ruta"];  ?>">
					
									<figure class="text-center">
										
										<img src="<?php echo $servidor.$value["img"]; ?>" class="img-fluid" width="100%">

										<p class="small py-4 mb-0"><?php echo $value["descripcion"]; ?></p>

										<h3 class="py-2 text-gray-dark mb-0">DESDE $<?php echo number_format($value["continental_baja"]); ?> COP</h3>

										<h5 class="py-2 text-gray-dark border">Ver detalles <i class="fas fa-chevron-right ml-2"></i></h5>
										
										<h1 class="text-white p-3 mx-auto w-50 lead text-uppercase" style="background:<?php echo $value["color"]; ?>"><?php echo $value["tipo"]; ?></h1>

									</figure>

								</a>

							</div>

							<?php endif ?>		
							
						<?php endforeach ?>						

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<!-- checkout -->

<!--=====================================
INFO RESERVAS
======================================-->

<div class="infoReservas container-fluid bg-white p-0 pb-5" idHabitacion="<?php echo $_POST["id-habitacion"]; ?>" fechaIngreso="<?php echo $_POST["fecha-ingreso"]; ?>" fechaSalida="<?php echo $_POST["fecha-salida"]; ?>" dias="<?php echo $dias; ?>">
	
	<div class="container">
		
		<div class="row">

			<!--=====================================
			BLOQUE IZQ
			======================================-->
			
			<div class="col-12 col-lg-8 colIzqReservas p-0">
				
				<!--=====================================
				CABECERA RESERVAS
				======================================-->
				
				<div class="pt-4 cabeceraReservas">
					
					<a href="javascript:history.back()" class="float-left lead text-white pt-1 px-3">
						<h5><i class="fas fa-chevron-left"></i> Regresar</h5>
					</a>

					<div class="clearfix"></div>

					<h1 class="float-left text-white p-2 pb-lg-5">RESERVAS</h1>	

					<h6 class="float-right px-3">

					<?php if (isset($_SESSION["validarSesion"])): ?>

						<?php if ($_SESSION["validarSesion"] == "ok"): ?>

							<br>
							<a href="<?php echo $ruta;  ?>perfil" style="color:#FFCC29">Ver tus reservas</a>

						<?php endif ?>

					<?php else: ?>
						
						<br>
						<a href="#modalIngreso" data-toggle="modal" style="color:#FFCC29">Ver tus reservas</a>
						
					<?php endif ?>						

					</h6>

					<div class="clearfix"></div>

				</div>

				<!--=====================================
				CALENDARIO RESERVAS
				======================================	-->

				<div class="bg-white p-4 calendarioReservas">

				<?php if ($valor == $_POST["ruta"]): ?>

					<h1 class="pb-5 float-left">¡Está Disponible!</h1>

				<?php else: ?>

					<div class="infoDisponibilidad"></div>
					
				<?php endif ?>

					<div class="float-right pb-3">
							
						<ul>
							<li>
								<i class="fas fa-square-full" style="color:#847059"></i> No disponible
							</li>

							<li>
								<i class="fas fa-square-full" style="color:#eee"></i> Disponible
							</li>

							<li>
								<i class="fas fa-square-full" style="color:#FFCC29"></i> Tu reserva
							</li>
						</ul>

					</div>

					<div class="clearfix"></div>
			
					<div id="calendar"></div>

					<!--=====================================
					MODIFICAR FECHAS
					======================================	-->

					<h6 class="lead pt-4 pb-2">Puede modificar la fecha de acuerdo a los días disponibles:</h6>

					<form action="<?php echo $ruta; ?>reservas" method="post">

						<input type="hidden" name="id-habitacion" value="<?php echo $_POST["id-habitacion"]; ?>">

						<input type="hidden" name="ruta" value="<?php echo $_POST["ruta"]; ?>">

						<div class="container mb-3">

							<div class="row py-2" style="background:#509CC3">

								 <div class="col-6 col-md-3 input-group pr-1">
								
									<input type="text" class="form-control datepicker entrada" autocomplete="off" placeholder="Entrada" name="fecha-ingreso" value="<?php echo $_POST["fecha-ingreso"]; ?>"  required>

									<div class="input-group-append">
										
										<span class="input-group-text"><i class="far fa-calendar-alt small text-gray-dark"></i></span>
									
									</div>

								</div>

							 	<div class="col-6 col-md-3 input-group pl-1">
								
									<input type="text" class="form-control datepicker salida" autocomplete="off" placeholder="Salida" name="fecha-salida"  value="<?php echo $_POST["fecha-salida"]; ?>" readonly required>

									<div class="input-group-append">
										
										<span class="input-group-text"><i class="far fa-calendar-alt small text-gray-dark"></i></span>
									
									</div>

								</div>

								<div class="col-12 col-md-6 mt-2 mt-lg-0 input-group">
																
									<input type="submit" class="btn btn-block btn-md text-white" value="Ver disponibilidad" style="background:black">										
								</div>

							</div>

						</div>

				</div>

			</div>

			<!--=====================================
			BLOQUE DER
			======================================-->

			<div class="col-12 col-lg-4 colDerReservas" style="display:none">

				<h4 class="mt-lg-5">Código de la Reserva:</h4>
				<h2 class="colorTitulos"><strong class="codigoReserva"></strong></h2>

				<div class="form-group">
				  <label>Ingreso 3:00 pm:</label>
				  <input type="text" class="form-control" value="<?php echo $_POST["fecha-ingreso"];?>" readonly>
				</div>

				<div class="form-group">
				  <label>Salida 1:00 pm:</label>
				  <input type="text" class="form-control" value="<?php echo $_POST["fecha-salida"];?>"  readonly>
				</div>

				<div class="form-group">
				  <label>Habitación:</label>
			<input type="text" class="form-control" value="Habitación <?php echo $reservas[$indice]["tipo"]." ".$reservas[$indice]["estilo"]; ?>" readonly>

				  <?php

				  	$galeria = json_decode($reservas[$indice]["galeria"], true);
				  
				  ?>

				  <img src="<?php echo $servidor.$galeria[0]; ?>" class="img-fluid">

				   <!-- ESCENARIO 2 Y 3 DE RESERVAS -->
				   <!-- <input type="text" class="form-control tituloReserva" value="" readonly>   -->

				</div>

				<div class="form-group">
				  <label><a href="#infoPlanes" data-toggle="modal">Escoge tu Plan:</a> <small>(Precio sugerido para 2 personas)</small></label>
				  <select class="form-control elegirPlan">
				  	
					<option value="<?php echo $precioContinental;?>,Plan Continental">Plan Continental $<?php echo number_format($precioContinental); ?> 1 día 1 noche</option>
					<option value="<?php echo $precioAmericano;?>,Plan Americano">Plan Americano $<?php echo number_format($precioAmericano); ?> 1 día 1 noche</option>
					<option value="<?php echo $precioRomantico;?>,Plan Romantico">Plan Romántico $<?php echo number_format($precioRomantico); ?> 1 día 1 noche</option>
					<option value="<?php echo $precioLunaDeMiel;?>,Plan Luna de Miel">Plan Luna de Miel $<?php echo number_format($precioLunaDeMiel); ?> 1 día 1 noche</option>
					<option value="<?php echo $precioAventura;?>,Plan Aventura">Plan Aventura $<?php echo number_format($precioAventura); ?> 1 día 1 noche</option>
					<option value="<?php echo $precioSPA;?>,Plan SPA">Plan SPA $<?php echo number_format($precioSPA); ?> 1 día 1 noche</option>

				  </select>
				</div>
				
				<div class="form-group">
				  <label>Personas:</label>
				  <select class="form-control cantidadPersonas">
				  	
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>

				  </select>
				</div>

				<div class="row py-4">

					<div class="col-12 col-lg-6 col-xl-7 text-center text-lg-left">
						
						<h1 class="precioReserva">$<span><?php echo number_format($precioContinental*$dias);?></span> COP</h1>

					</div>
					
					<div class="col-12 col-lg-6 col-xl-5">


					<?php if (isset($_SESSION["validarSesion"])): ?>

						<?php if ($_SESSION["validarSesion"] == "ok"): ?>

							<a href="<?php echo $ruta;?>perfil" 
								class="pagarReserva" 
								idHabitacion="<?php echo $reservas[$indice]["id_h"]; ?>"
								imgHabitacion="<?php echo $servidor.$galeria[0]; ?>"
								infoHabitacion="Habitación <?php echo $reservas[$indice]["tipo"]." ".$reservas[$indice]["estilo"]; ?>"
								pagoReserva="<?php echo ($precioContinental*$dias);?>"
								codigoReserva=""
								fechaIngreso="<?php echo $_POST["fecha-ingreso"];?>"
								fechaSalida="<?php echo $_POST["fecha-salida"];?>"
								plan="Plan Continental" 
								personas="2">
									<button type="button" class="btn btn-dark btn-lg w-100">PAGAR <br> RESERVA</button>
							</a>	


						<?php endif ?>
									
					<?php else: ?>

							<a href="#modalIngreso" data-toggle="modal"  
								class="pagarReserva" 
								idHabitacion="<?php echo $reservas[$indice]["id_h"]; ?>"
								imgHabitacion="<?php echo $servidor.$galeria[0]; ?>"
								infoHabitacion="Habitación <?php echo $reservas[$indice]["tipo"]." ".$reservas[$indice]["estilo"]; ?>"
								pagoReserva="<?php echo ($precioContinental*$dias);?>"
								codigoReserva=""
								fechaIngreso="<?php echo $_POST["fecha-ingreso"];?>"
								fechaSalida="<?php echo $_POST["fecha-salida"];?>"
								plan="Plan Continental" 
								personas="2">
									<button type="button" class="btn btn-dark btn-lg w-100">PAGAR <br> RESERVA</button>
							</a>						

					<?php endif ?>

					</div>
			 
				</div>

			</div>

		</div>

	</div>

</div>


<!--=====================================
VENTANA MODAL PLANES
======================================-->

<div class="modal" id="infoPlanes">
	
	 <div class="modal-dialog modal-lg">
			
		<div class="modal-content">

			<div class="modal-header">
	        	<h4 class="modal-title text-uppercase">Habitación <?php echo $reservas[$indice]["tipo"].' '.$reservas[$indice]["estilo"]; ?></h4>
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	      	</div>

	      	<div class="modal-body">

				<figure class="text-center">

       				<img src="<?php echo $servidor.$galeria[$indice]; ?>" class="img-fluid">

       			</figure>

				<p class="px-2"><?php echo $reservas[$indice]["descripcion_h"]; ?></p>

				<hr>

       			<div class="row">

       			<?php foreach ($planes as $key => $value): ?>

					<div class="col-12 col-md-6">
						
						<h2 class="text-uppercase p-2">Plan <?php echo $value["tipo"]; ?></h2>

						<figure class="center">
	       					<img src="<?php echo $servidor.$value["img"]; ?>" class="img-fluid">
	       				</figure>

	       				<p class="p-2"><?php echo $value["descripcion"]; ?></p>

	       				<h4 class="px-2">Precio por pareja</h4>

       					<p class="px-2">

	       				Temporada Baja: Plan Americano + $ <?php echo number_format($value["precio_baja"]); ?> COP<br>

	       				Temporada Alta: Plan Americano + $ <?php echo number_format($value["precio_alta"]); ?> COP

	       				</p>


					</div>
       				
       			<?php endforeach ?>
       			
       			</div>

	      	</div>

	      	<div class="modal-footer">
        		<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      		</div>

		</div>

	</div>

</div>

<!-- infor perfil reservas -->

<!--=====================================
INFO PERFIL
======================================-->

<div class="infoPerfil container-fluid bg-white p-0 pb-5 pb-5">
	
	<div class="container">
		
		<div class="row"> 

			<!--=====================================
			BLOQUE IZQ
			======================================-->
			
			<div class="col-12 col-lg-4 colIzqPerfil p-0 px-lg-3">
				
				<div class="cabeceraPerfil pt-4">

				<?php if ($usuario["modo"] == "facebook"): ?>

					<a href="#" class="float-left lead text-white pt-1 px-3 mb-4 salir">
						<h5><i class="fas fa-chevron-left"></i> Salir</h5>
					</a>

				<?php else: ?>
					
					<a href="<?php echo $ruta;  ?>salir" class="float-left lead text-white pt-1 px-3 mb-4">
						<h5><i class="fas fa-chevron-left"></i> Salir</h5>
					</a>

				<?php endif ?>
					
					

					<div class="clearfix"></div>

					<h1 class="text-white p-2 pb-lg-5 text-center text-lg-left">MI PERFIL</h1>	
				</div>

				<!--=====================================
				PERFIL
				======================================-->

				<div class="descripcionPerfil">
					
					<figure class="text-center imgPerfil">

					<?php if ($usuario["foto"] == ""): ?>

						<img src="<?php echo $servidor; ?>vistas/img/usuarios/default/default.png" class="img-fluid rounded-circle">

					<?php else: ?>

						<?php if ($usuario["modo"] == "directo"): ?>

							<img src="<?php echo $servidor.$usuario["foto"]; ?>" class="img-fluid rounded-circle">
						
						<?php else: ?>	

							<img src="<?php echo $usuario["foto"]; ?>" class="img-fluid rounded-circle">
							
						<?php endif ?>
						
					<?php endif ?>
										
					</figure>

					<div id="accordion">

						<div class="card">

							<div class="card-header">
								<a class="card-link" data-toggle="collapse" href="#collapseOne">
									MIS RESERVAS
								</a>
							</div>

							<div id="collapseOne" class="collapse show" data-parent="#accordion">

								<ul class="card-body p-0">

									<li class="px-2 misReservas" style="background:#FFFDF4"> <?php echo $noVencidas; ?> Por vencerse</li>
									<li class="px-2 text-white misReservas" style="background:#CEC5B6"> <?php echo $vencidas; ?> vencidas</li>

								</ul>

								<!--=====================================
								TABLA RESERVAS MÓVIL
								======================================-->


								<?php

								 	if(!$reservas){

								     	echo ' <div class="d-lg-none d-flex py-2">Aún no tiene reservas realizadas</div>';

								     	return;

								     }
		   

								    foreach ($reservas as $key => $value) {
								    	
								    	$habitacion = ControladorHabitaciones::ctrMostrarHabitacion($value["id_habitacion"]);
						    			$categoria = ControladorCategorias::ctrMostrarCategoria($habitacion["tipo_h"]);	
						    			$testimonio = ControladorReservas::ctrMostrarTestimonios("id_res", $value["id_reserva"]);

						    			echo '<div class="d-lg-none d-flex py-2">
									
												<div class="p-2 flex-grow-1">

													<h5>'.$categoria["tipo"]." ".$habitacion["estilo"].'</h5>
													<h5 class="small text-gray-dark">Del '.$value["fecha_ingreso"].' al '.$value["fecha_salida"].'</h5>

												</div>

												<div class="p-2">

													  <button type="button" class="btn btn-dark text-white actualizarTestimonio" data-toggle="modal" data-target="#actualizarTestimonio" idTestimonio="'.$testimonio[0]["id_testimonio"].'"
													     verTestimonio="'.$testimonio[0]["testimonio"].'">

													  	<i class="fas fa-pencil-alt"></i>

													  </button>

													  <button type="button" class="btn btn-warning text-white verTestimonio" data-toggle="modal" data-target="#verTestimonio" verTestimonio="'.$testimonio[0]["testimonio"].'">

													  	<i class="fas fa-eye"></i>

													  </button>

												</div>

											</div>

											<hr class="my-0">';


						    		}

						    	?>

							</div>

						</div>

						<div class="card">

							<div class="card-header">
								<a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
									MIS DATOS
								</a>
							</div>

							<div id="collapseTwo" class="collapse" data-parent="#accordion">
								<div class="card-body p-0">

									<ul class="list-group">
										
										<li class="list-group-item small"><?php echo $usuario["nombre"]; ?></li>
										<li class="list-group-item small"><?php echo $usuario["email"]; ?></li>
										
										<?php if ($usuario["modo"] == "directo"): ?>											
										
										<li class="list-group-item small">

											<button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#cambiarPassword">Cambiar Contraseña</button>

										</li>

										<!--=====================================
										MODAL PARA CAMBIAR CONTRASEÑA
										======================================-->

										<div class="modal formulario" id="cambiarPassword">
											
											<div class="modal-dialog">

										 		<div class="modal-content">

										 			<form method="post">

										 				<div class="modal-header">

									 				 		<h4 class="modal-title">Cambiar Contraseña</h4>

        													<button type="button" class="close" data-dismiss="modal">&times;</button>

										 				</div>

										 				<div class="modal-body">
										 					
															<input type="hidden" name="idUsuarioPassword" value="<?php echo $usuario["id_u"]; ?>">

															<div class="form-group">

																<input type="password" class="form-control" placeholder="Nueva contraseña" name="editarPassword" required>

															</div>

										 				</div>

										 				<div class="modal-footer d-flex justify-content-between"> 

														 	<div>

													        	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

													        </div>

												         	<div>
         
												         		<button type="submit" class="btn btn-primary">Enviar</button>

											        	 	</div>

										 				</div>

									 				 	<?php

															$cambiarPassword = new ControladorUsuarios();
															$cambiarPassword -> ctrCambiarPassword();

														?>

										 			</form>

										 		</div>

											</div>

										</div>

										<?php endif ?>

										<li class="list-group-item small">
											<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#cambiarFotoPerfil">Cambiar Imagen</button>
										</li>

										<!--=====================================
										MODAL PARA CAMBIAR FOTO DE PERFIL
										======================================-->

										<div class="modal formulario" id="cambiarFotoPerfil">

											<div class="modal-dialog">

												<div class="modal-content">

													<form method="post" enctype="multipart/form-data">

														<div class="modal-header">

															 <h4 class="modal-title">Cambiar Imagen</h4>

															 <button type="button" class="close" data-dismiss="modal">&times;</button>

														</div>

														<div class="modal-body">

															<input type="hidden" name="idUsuarioFoto" value="<?php echo $usuario["id_u"]; ?>">

															<div class="form-group">

																<input type="file" class="form-control-file border" name="cambiarImagen" required>

																<input type="hidden" name="fotoActual" value="<?php echo $usuario["foto"]; ?>">

															</div>	

														</div>

														<div class="modal-footer d-flex justify-content-between">  

														 	<div>

												        		<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

												        	</div>

												        	<div>
         
													         	<button type="submit" class="btn btn-primary">Enviar</button>

													         </div>

														</div>

														<?php

															$cambiarImagen = new ControladorUsuarios();
															$cambiarImagen -> ctrCambiarFotoPerfil();


														?>

													</form>

												</div>

											</div>

										</div>

									</ul>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			<!--=====================================
			BLOQUE DER
			======================================-->

			<div class="col-12 col-lg-8 colDerPerfil">

				<div class="row">

					<div class="col-6 d-none d-lg-block">
						
						<h4 class="float-left">Hola <?php echo $usuario["nombre"]; ?></h4>

					</div>

					<!--=====================================
					MERCADO PAGO
					======================================-->					

					<div class="col-12">

					<?php if (isset($_COOKIE["codigoReserva"])): ?>

						
						<?php

							$validarPagoReserva = false;

							$hoy = date("Y-m-d");

							if($hoy >= $_COOKIE["fechaIngreso"] || $hoy >= $_COOKIE["fechaSalida"]){

								echo '<div class="alert alert-danger">Lo sentimos, las fechas de la reserva no pueden ser igual o inferiores al día de hoy, vuelve a intentarlo.</div>';

								$validarPagoReserva = false;

							}else{

								$validarPagoReserva = true;
							}


							/*=============================================
						 	CRUCE DE FECHAS
							=============================================*/

							$valor = $_COOKIE["idHabitacion"];

							$validarReserva = ControladorReservas::ctrMostrarReservas($valor);

							$opcion01 = array();
							$opcion02 = array();
							$opcion03 = array();
							
							if($validarReserva != 0){

								foreach ($validarReserva as $key => $value) {
									
									/* VALIDAR CRUCE DE FECHAS OPCIÓN 1 */     

									if($_COOKIE["fechaIngreso"] == $value["fecha_ingreso"]){

										array_push($opcion01, false);

									}else{

										array_push($opcion01, true);

									}

									 /* VALIDAR CRUCE DE FECHAS OPCIÓN 2 */

									 if($_COOKIE["fechaIngreso"] > $value["fecha_ingreso"] && $_COOKIE["fechaIngreso"] < $value["fecha_salida"]){

										array_push($opcion02, false);

									}else{

										array_push($opcion02, true);

									} 

									 /* VALIDAR CRUCE DE FECHAS OPCIÓN 3 */

									 if($_COOKIE["fechaIngreso"] < $value["fecha_ingreso"] && $_COOKIE["fechaSalida"] > $value["fecha_ingreso"]){

										array_push($opcion03, false);

									}else{

										array_push($opcion03, true);

									} 

									if($opcion01[$key] == false || $opcion02[$key] == false || $opcion03[$key] == false){

										$validarPagoReserva = false;

										echo 'Lo sentimos, las fechas de la reserva que habías seleccionado han sido ocupadas  
											<a href="'.$ruta.'" class="btn btn-danger btn-sm">vuelve a intentarlo </a>';

										break;	

									}else{

										$validarPagoReserva = true;

									}	        


								}

							}

						?>

					<?php if ($validarPagoReserva): ?>
													
							<div class="card">

								<div class="card-header">
									
									<h4>Tienes una reserva pendiente por pagar:</h4> 

								</div>
							 	
							 	<div class="card-body text-center">
							   
									<figure>

							  			<img src="<?php echo $_COOKIE["imgHabitacion"]; ?>" class="img-thumbnail w-50">

							  		</figure>

							  		<h5><strong><?php echo $_COOKIE["infoHabitacion"]; ?></strong></h5>

							  		<h6> Fechas <?php echo $_COOKIE["fechaIngreso"]; ?> - <?php echo $_COOKIE["fechaSalida"]; ?></h6>

							  		<h4>$<?php echo number_format($_COOKIE["pagoReserva"]); ?></h4>



							  	</div>

							  	<div class="card-footer d-flex bg-white">

							  		<figure>
								 			
							 			<img src="img/mercadopago.png" class="img-fluid w-50">
								 		
							 		</figure>

							 		<form action="<?php echo $ruta.'perfil'; ?>" method="POST" class="pt-3">
									  <script
									    src="https://www.mercadopago.com.co/integrations/v1/web-tokenize-checkout.js"
									    data-public-key="TEST-dd470a0c-d445-4451-a87f-6b19c6588bc3"
									    data-transaction-amount="<?php echo $_COOKIE["pagoReserva"]; ?>"
									    data-button-label="Pagar"
									    data-summary-product-label="<?php echo $_COOKIE["infoHabitacion"]; ?>"
									    data-summary-product="<?php echo $_COOKIE["pagoReserva"]; ?>">
									  </script>
									</form>
								
								</div>
							</div>
							
							<?php

							if(isset($_REQUEST["token"])){

							  	$token = $_REQUEST["token"];							
								$payment_method_id = $_REQUEST["payment_method_id"];		
								$installments = $_REQUEST["installments"];
								$issuer_id = $_REQUEST["issuer_id"];
						
							  	MercadoPago\SDK::setAccessToken("TEST-1682012079503888-040315-5125e5034ad3118592785c001ad47c70-184874455");
							    
							    $payment = new MercadoPago\Payment();
							    $payment->transaction_amount = $_COOKIE["pagoReserva"];
							    $payment->token = $token;
							    $payment->description = $_COOKIE["infoHabitacion"];
							    $payment->installments = $installments;
							    $payment->payment_method_id = $payment_method_id;
							    $payment->issuer_id = $issuer_id;
							    $payment->payer = array(
							    "email" => "junior@gmail.com"
							    );
							   
							    $payment->save();							  

							    if($payment->status == "approved"){

							    	$datos = array( "id_habitacion" => $_COOKIE["idHabitacion"],
													"id_usuario" => $usuario["id_u"],
													"pago_reserva" => $_COOKIE["pagoReserva"],
													"numero_transaccion" => $payment->id,
													"codigo_reserva" => $_COOKIE["codigoReserva"],
													"descripcion_reserva" => $_COOKIE["infoHabitacion"],
													"fecha_ingreso" => $_COOKIE["fechaIngreso"],
													"fecha_salida" => $_COOKIE["fechaSalida"]);

							    	$respuesta = ControladorReservas::ctrGuardarReserva($datos);
							    	
							    	if($respuesta == "ok"){

								    	echo '<script>
								    	
								    	document.cookie = "idHabitacion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='.$ruta.';";
								    	document.cookie = "imgHabitacion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='.$ruta.';";
								    	document.cookie = "infoHabitacion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='.$ruta.';";
								    	document.cookie = "pagoReserva=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='.$ruta.';";
								    	document.cookie = "codigoReserva=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='.$ruta.';";
								    	document.cookie = "fechaIngreso=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='.$ruta.';";
								    	document.cookie = "fechaSalida=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='.$ruta.';";
								    	
								    	swal({
											type:"success",
										  	title: "¡CORRECTO!",
										  	text: "¡La reserva ha sido creada con éxito!",
										  	showConfirmButton: true,
											confirmButtonText: "Cerrar"
										  
										}).then(function(result){

												if(result.value){   
												    history.back();
												  } 
										});

								    	</script>';								    	

								 	}

							   	}else{

								echo '<h1>¡Algo salió mal!</h1>
									<p>Ha ocurrido un error con el pago. Por favor vuelve a intentarlo.</p>';

								}

							}

							?>

						<?php endif ?>

					<?php endif ?>

					</div>

					<div class="col-6 d-none d-lg-block"></div>

					<div class="col-12 mt-3">
						
						<table class="table table-striped">
					    <thead>
					      <tr>
					      	<th>#</th>
					      	<th>Código</th>
					        <th>Habitación</th>
					        <th>Fecha de Ingreso</th>
					        <th>Fecha de Salida</th>
					        <th>Testimonios</th>
					      </tr>
					    </thead>
					    <tbody>
					     
					<?php

				     if(!$reservas){

				     	echo ' <tr><td colspan="5">Aún no tiene reservas realizadas</td></tr>';

				     	return;

				     }else{

					     foreach ($reservas as $key => $value) {

					     	$habitacion = ControladorHabitaciones::ctrMostrarHabitacion($value["id_habitacion"]);
					     	$categoria = ControladorCategorias::ctrMostrarCategoria($habitacion["tipo_h"]);
					     	$testimonio = ControladorReservas::ctrMostrarTestimonios("id_res", $value["id_reserva"]);

					     	if($value["fecha_ingreso"] != "0000-00-00"){
					     		     	
							     		echo '<tr>

							     		<td>'.($key+1).'</td>
							     		<td>'.$value["codigo_reserva"].'</td>
							     		<td class="text-uppercase">'.$categoria["tipo"]." ".$habitacion["estilo"].'</td>
							     		<td>'.$value["fecha_ingreso"].'</td>
							     		<td>'.$value["fecha_salida"].'</td>
							     		<td>
							     			
							     			<button type="button" class="btn btn-dark text-white actualizarTestimonio" data-toggle="modal" data-target="#actualizarTestimonio" idTestimonio="'.$testimonio[0]["id_testimonio"].'"
							     			verTestimonio="'.$testimonio[0]["testimonio"].'">

							     			<i class="fas fa-pencil-alt"></i>

							     		</button>

							     		<button type="button" class="btn btn-warning text-white verTestimonio" data-toggle="modal" data-target="#verTestimonio" verTestimonio="'.$testimonio[0]["testimonio"].'">

							     			<i class="fas fa-eye"></i>

							     		</button>
							     		
							     	</td>
							     	
							     </tr>';

							 }

					   }

					     echo '<p class="help-block small">

							Si necesita modificar o cancelar una reserva, favor escribirnos al WhatsApp 
							<a href="https://api.whatsapp.com/send?phone=573001112233&text=Hola Heaven Tours, necesito hacer un cambio en una reserva" target="_blank">+57 300 111 22 33</a>

					     </p>';

					 }



					     ?>

					    </tbody>
					  </table>

					</div>

				</div>
			
			</div>

		</div>

	</div>

</div>

<!--=====================================
MODAL PARA VER TESTIMONIO
======================================-->

<div class="modal" id="verTestimonio">
	
	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title">Testimonio</h4>

				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>

			<div class="modal-body visorTestimonios">

				<script>
					
				$(".verTestimonio").click(function(){

					var testimonio = $(this).attr("verTestimonio");

					if(testimonio != ""){

						$(".modal-body.visorTestimonios").html('<p>'+testimonio+'</p>')

					}else{

						$(".modal-body.visorTestimonios").html('<p>Aún no tiene testimonios de esta reserva</p>');

					}


				})

				</script>			

			</div>

		</div>

	</div>

</div>


<!--=====================================
MODAL PARA EDITAR TESTIMONIO
======================================-->

<div class="modal" id="actualizarTestimonio">
	
	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title">Testimonio</h4>

				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>

			<div class="modal-body">

			<script>

				$(".actualizarTestimonio").click(function(){

					var testimonio = $(this).attr("verTestimonio");
					var idTestimonio = $(this).attr("idTestimonio");

					if(testimonio != ""){

						$(".modal-body textarea").val(testimonio);

					}else{

						$(".modal-body textarea").val("");

					}

					$("input[name='idTestimonio']").val(idTestimonio);


				})


			</script>

				<form method="post">

					<input type="hidden" value="" name="idTestimonio">
				
					<textarea class="form-control" rows="3" name="actualizarTestimonio" required></textarea>

					<input class="btn btn-primary my-3 float-right" type="submit" value="Guardar testimonio">

					<?php

						$actualizarTestimonio = new ControladorReservas();
						$actualizarTestimonio -> ctrActualizarTestimonio();

					?>

				</form>

			</div>

		</div>

	</div>

</div>


<div class="col-6 d-none d-lg-block"></div>

<div class="col-12 mt-3">
	
	<table class="table table-striped">
		<thead>
		<tr>
			<th>#</th>
			<th>Código</th>
			<th>Habitación</th>
			<th>Fecha de Ingreso</th>
			<th>Fecha de Salida</th>
			<th>Testimonios</th>
		</tr>
		</thead>
		<tbody>
		
		<?php

		if(!$reservas){

			echo ' <tr>
				<td colspan="6">Aún no tiene reservas realizadas</td>
			</tr>';

			//return;

		}else{

			foreach ($reservas as $key => $value) {

				$habitacion = ControladorHabitaciones::ctrMostrarHabitacion($value["id_habitacion"]);
				$categoria = ControladorCategorias::ctrMostrarCategoria($habitacion["tipo_h"]);
				$testimonio = ControladorReservas::ctrMostrarTestimonios("id_res", $value["id_reserva"]);

				if($value["fecha_ingreso"] != "0000-00-00"){
							
							echo '<tr>

							<td>'.($key+1).'</td>
							<td>'.$value["codigo_reserva"].'</td>
							<td class="text-uppercase">'.$categoria["tipo"]." ".$habitacion["estilo"].'</td>
							<td>'.$value["fecha_ingreso"].'</td>
							<td>'.$value["fecha_salida"].'</td>
							<td>
								
								<button type="button" class="btn btn-dark text-white actualizarTestimonio" data-toggle="modal" data-target="#actualizarTestimonio" idTestimonio="'.$testimonio[0]["id_testimonio"].'"
								verTestimonio="'.$testimonio[0]["testimonio"].'">

								<i class="fas fa-pencil-alt"></i>

							</button>

							<button type="button" class="btn btn-warning text-white verTestimonio" data-toggle="modal" data-target="#verTestimonio" verTestimonio="'.$testimonio[0]["testimonio"].'">

								<i class="fas fa-eye"></i>

							</button>
							
						</td>
						
					</tr>';

				}

		}

		echo '<p class="help-block small">

			Si necesita modificar o cancelar una reserva, favor escribirnos al WhatsApp 
			<a href="https://api.whatsapp.com/send?phone=573001112233&text=Hola Heaven Tours, necesito hacer un cambio en una reserva" target="_blank">+57 300 111 22 33</a>

		</p>';

		}

		?>

		</tbody>

	</table>

</div>

<!-- lef right servicios -->

<div class="container p-lg-5" style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
            url('vistas/images/banner-1.jpg'); background-size: cover; background-position: center;">

        <div class="row">

            <div class="col-md-6 gallery-service">

                <!-- Slideshow container -->
                <div class="slideshow-container">

                    <!-- Full-width images with number and caption text -->

                    <?php 

                        foreach ($galeria as $row2 => $source) {

                            $path = str_replace(" ","%20", $servidor.$source);

                            list($width, $height, $type, $attr) = getimagesize($path);

                            if ($width > $height) {                                
                            
                                if (strpos($source, "mp4") !== false){

                                    echo'<div class="mySlides'.($key + 1).'">
                                        <div class="numbertext">'.($row2 + 1).' / '.count($galeria).'</div>
                                        <video width="100%" autoplay muted loop style="margin-bottom: 0">
                                            <source src="'.$servidor.$source.'" type="video/mp4" width="100%">                            
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class="text"></div>';

                                }else{

                                    echo'<div class="mySlides'.($key + 1).'">
                                        <div class="numbertext">'.($row2 + 1).' / '.count($galeria).'</div>
                                    <img src="'.$servidor.$source.'" style="width:100%">
                                    <div class="text"></div>
                                    </div>';

                                }

                            }

                        }
                    
                    ?>                   
                
                    <!-- Next and previous buttons -->
                    <a class="prev" onclick="plusSlides(-1, <?php echo $key; ?>)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1, <?php echo $key; ?>)">&#x276F;</a>
                </div>
                <br>                                

            </div>

            <div class="col-md-6 service-body-right">

                <h5>HEAVEN TOURS CARTAGENA SAS</h5>
                <h1><?php echo $value["estilo"] ?></h1>

                <p class="mt-3"><?php echo $value["descripcion_h"] ?></p>

                <a href="<?php echo $ruta.$value["ruta"]; ?>" type="button" class="btn btn-default btn-outline-gold mt-3" style="white-space: wrap;">Reservar hoy mismo este servicio</a>

            </div>

        </div>

    </div>

        <?php else: ?>

    <div class="container p-lg-5" style="background-color: #fef4e0">

        <div class="row">   
            
            <div class="col-md-6 service-body-left">

                <h5>HEAVEN TOURS CARTAGENA SAS</h5>
                <h1><?php echo $value["estilo"] ?></h1>

                <p class="mt-3"><?php echo $value["descripcion_h"] ?></p>

                <a href="<?php echo $ruta.$value["ruta"]; ?>" type="button" class="btn btn-default btn-outline-white mt-3" style="white-space: wrap;">Reservar hoy mismo este servicio</a>

            </div>

            <div class="col-md-6 gallery-service">

                <!-- Slideshow container -->
                <div class="slideshow-container">

                    <?php 

                    foreach ($galeria as $row2 => $source) {

                        $path = str_replace(" ","%20", $servidor.$source);

                        list($width, $height, $type, $attr) = getimagesize($path);

                        if ($width > $height) {  
                        
                            if (strpos($source, "mp4") !== false){

                                echo'<div class="mySlides'.($key + 1).'">
                                    <div class="numbertext">'.($row2 + 1).' / '.count($galeria).'</div>
                                    <video width="100%" autoplay muted loop style="margin-bottom: 0">
                                        <source src="'.$servidor.$source.'" type="video/mp4" width="100%">                            
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="text"></div>';

                            }else{

                                echo'<div class="mySlides'.($key + 1).'">
                                    <div class="numbertext">'.($row2 + 1).' / '.count($galeria).'</div>
                                <img src="'.$servidor.$source.'" style="width:100%">
                                <div class="text"></div>
                                </div>';

                            }

                        }

                    }

                    ?> 
                
                    <!-- Next and previous buttons -->
                    <a class="prev" onclick="plusSlides(-1, <?php echo $key; ?>)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1, <?php echo $key; ?>)">&#x276F;</a>
                </div>
                <br>
                
                <!-- The dots/circles -->
                <!-- <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                </div>                        -->

            </div>                                 

        </div>

    </div>

	<!-- tabla anteiror reservas -->

	$informacion_usuario = "<ul><li><b>Nombre:</b> ".$value["firstName"]."</li><li><b>Apellidos:</b> ".$value["lastName"]."</li><li><b>Tipo de identificación:</b> ".$value["tipo_identificacion"]."</li><li><b>Número de identificación:</b> ".$value["numero_identificacion"]."</li><li><b>Celular:</b> ".$value["celular"]."</li><li><b>Correo:</b> ".$value["correo"]."</li></ul>";

			$informacion_pago = "<ul><li><b>Forma de pago:</b> ".$value["abono"]."</li>";

if($value["abono"] == "abono"){

				$informacion_pago .= "<li><b>Monto pagado:</b> ".($value["pago_reserva"] / 2)."</li><li><b>Número de transacción:</b>".$value["numero_transaccion"]."</li><li class='text-danger'><b>Saldo pendiente: $</b>".($value["pago_reserva"] / 2)."</li>";

			}else if($value["abono"] == "total"){

				$informacion_pago .= "<li><b>Monto pagado:</b> ".$value["pago_reserva"]."</li><li><b>Número de transacción:</b>".$value["numero_transaccion"]."</li>";

			}else if($value["abono"] == "credito"){

				$informacion_pago .= "<li><b>Número de cuotas:</b> ".$value["cuotas"]."</li><li><b>Valor de las cuotas:</b> ".$value["valorCuotas"]."</li>";

				if($value["pagoCuotas"] == "primera"){

					$informacion_pago .= "<li><b>Monto pagado:</b> ".$value["valorCuotas"]."</li><li><b>Número de transacción:</b>".$value["numero_transaccion"]."</li><li class='text-danger'><b>Saldo pendiente: $</b>".(($value["pago_reserva"] / $value["cuotas"]) -  $value["valorCuotas"])."</li>";

				}else if($value["pagoCuotas"] == "monto"){

					$informacion_pago .= "<li><b>Monto pagado:</b> ".$value["montoPagar"]."</li><li><b>Número de transacción:</b>".$value["numero_transaccion"]."</li><li class='text-danger'><b>Saldo pendiente: $</b>".(($value["pago_reserva"] / $value["cuotas"]) -  $value["montoPagar"])."</li>";

				}else if($value["pagoCuotas"] == "nopago"){

					$informacion_pago .= "<li><b>No se realizó ningún abono inicial</li><li class='text-danger'><b>Saldo pendiente: $</b>".$value["pago_reserva"]."</li>";

				}
			
			}

			$informacion_pago .="</ul>";

			<!-- galeria info habitacion anterior -->

			<?php

$item = "ruta";
$valor = $_GET["pagina"];

$habitacion = ControladorHabitaciones::ctrMostrarHabitaciones($item, $valor);

if(!$habitacion){

	echo '<script>

	window.location = "'.$ruta .'";

	</script>';
 
	return;

}else{

	$precios = json_decode($habitacion["precio"], true);   	
                
	$visibilidad = "false";                                           

	if(isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok"){                                    

		foreach ($precios as $row => $item) {
			
			if($_SESSION["nombre"] == "Vendedor interno" && $item["usuario"] == "Vendedores internos"){

				if($item["visibilidad"] == "true"){

					$precio = $item["precio"];
					$visibilidad = "true";

				}else{

					$visibilidad == "false";

				}

			}else if($_SESSION["nombre"] == "Vendedor externo" && $item["usuario"] == "Vendedores externos"){

				if($item["visibilidad"] == "true"){

					$precio = $item["precio"];
					$visibilidad = "true";

				}else{

					$visibilidad == "false";

				}

			}

		}
		
	}else{

		foreach ($precios as $row => $item) {

			if($item["usuario"] == "Público en general"){

				if($item["visibilidad"] == "true"){

					$precio = $item["precio"];
					$visibilidad = "true";

				}else{

					$visibilidad == "false";

				}

			}

		}

	}

}

?>

<!--=====================================
INFO HABITACIÓN
======================================-->

<!-- content -->

<div class="container mt-5 mb-5">
	
	<div class="row">

		<div class="col-md-6 gallery-service">

			<!-- Slideshow container -->
			<div class="slideshow-container">

			<?php 

				$galeria = json_decode($habitacion["galeria"], true);

				foreach ($galeria as $row2 => $source) {

					$path = str_replace(" ","%20", $servidor.$source);

					list($width, $height, $type, $attr) = getimagesize($path);

					if ($width < $height) { 
					
						if (strpos($source, "mp4") !== false){

							echo'<div class="mySlides1">
								<div class="numbertext">'.($row2 + 1).' / '.count($galeria).'</div>
								<video width="100%" autoplay muted loop style="margin-bottom: 0">
									<source src="'.$servidor.$source.'" type="video/mp4" width="100%">                            
									Your browser does not support the video tag.
								</video>
								<div class="text"></div>';

						}else{

							echo'<div class="mySlides1">
								<div class="numbertext">'.($row2 + 1).' / '.count($galeria).'</div>
							<img src="'.$servidor.$source.'" style="width:100%">
							<div class="text"></div>
							</div>';

						}

					}

				}

			?> 

			<!-- Next and previous buttons -->
			<a class="prev" onclick="plusSlides(-1, 0)">&#x276E;</a>
			<a class="next" onclick="plusSlides(1, 0)">&#x276F;</a>	

			</div>
			<br>
			
			<!-- The dots/circles -->
			<!-- <div style="text-align:center">
				<span class="dot" onclick="currentSlide(1)"></span>
				<span class="dot" onclick="currentSlide(2)"></span>
				<span class="dot" onclick="currentSlide(3)"></span>
			</div>                        -->

		</div> 
		<div class="col-md-6 p-5" style="border: 2px solid #d6bd8d; border-radius: 15px;">

			<h1 class="title-main"><?php echo $habitacion["estilo"]; ?></h1>
			<h2>COSTO <?php echo number_format($precio); ?> / POR PERSONA</h2>
			<h4>puedes reservar abonando:</h4>
			<h4 class="subtitle-main">el 50% del valor total</h4>

			<br>

			<p><?php echo $habitacion["descripcion_h"]; ?></p>

			<hr>

			<label class="label-main">Personaliza tu reserva</label>

			<h5>Indicanos la cantidad de personas</h5>

			<form id="form1" action="<?php echo $ruta; ?>reservas" method="post">

				<input type="hidden" name="id-habitacion" value="<?php echo $habitacion["id_h"]; ?>">

				<div class="input-group mb-3">
					<input type="number" class="form-control" name="cantidad-personas" placeholder="1" min="1" value="1" unit="<?php echo $precio; ?>" id="cant" readonly>
					<div class="input-group-append">
						<span class="btn input-group-text btn-outline-gold" id="addPerson"><i class="fas fa-plus"></i></span>
					</div>
					<div class="input-group-append">
						<span class="btn input-group-text btn-outline-gold" id="delPerson"><i class="fas fa-minus"></i></span>
					</div>
				</div>

				<h5>Fecha de tu reserva</h5>

				<div class="input-group mb-3">				
					<input type="text" class="form-control datepicker entrada" name="fecha-ingreso" placeholder="" required>
					<div class="input-group-append">
						<span class="btn input-group-text btn-outline-gold"><i class="fas fa-calendar"></i></span>
					</div>                    
				</div>

				<p id="calcularTotal" style="color: #000">1 x $<?php echo number_format($precio); ?> = $<?php echo number_format($precio); ?></p>

				<hr class="mt-5"> 

				<button type="submit" class="btn btn-default btn-lg call-to-action-btn-gold">Reservar </button>

			</form>

		</div>

	</div>

</div>

<?php if(strpos($habitacion["banner"], "mp4") !== false): ?>
<video width="100%" autoplay muted loop>
	<source src="<?php echo $servidor.substr($habitacion["banner"], 3); ?>" type="video/mp4">                                    
	Your browser does not support the video tag.
</video>	
<?php else: ?>
<img width="100%" src="<?php echo $servidor.substr($habitacion["banner"], 3); ?>">
<?php endif ?>

<div class="row p-5" style="background-image: url('<?php echo $servidor.$galeria[0]; ?>'); background-size: cover; background-position: center;">

	<div class="col-md-7 p-5 text-center" style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9));">

		<h1 class="title-main pt-5"><?php echo $habitacion["estilo"]; ?></h1>
		<h2 class="subtitle-main">¡Ven a conocer nuestro paraíso!</h2>

		<br>

		<p><?php echo $habitacion["descripcion_h"]; ?></p>

		<hr class="mb-5" style="border: 2px solid #d6bd8d; width: 50%; margin: auto;">

	</div>        

</div>

<div class="row p-5" style="background-color: #000;">

	<div class="col-md-12 p-5" style="background-color: #fff;">

		<h2 class="subtitle-main text-center">Ten en cuenta estas observaciones:</h2>

		<hr class="mb-5" style="border: 2px solid #d6bd8d; width: 50%; margin: auto;">

		<br>

		<ul>
			
			<!-- caracteristicas principales -->

			<?php 
			
			$caracteristicas = json_decode($habitacion["caracteristicas"], true);

			foreach ($caracteristicas as $count_car => $car):

				if($car["titulo"] != ""):
			
			?>					

			<li><?php echo $car["titulo"]; ?>: <?php echo $car["descripcion"]; ?></li>
			
			<?php endif; endforeach; ?>

			<li>Punto de partida / retorno: <?php echo $habitacion["lugarSalida"]; ?></li>
			<li>Hora de salida: <?php echo $habitacion["horaSalida"]; ?></li>
			<li>Otras: <?php echo $habitacion["recomendaciones"]; ?></li>

		</ul>

		<hr class="mt-5">

		<h2 class="subtitle-main text-center">Esta reserva incluye:</h2>

		<!-- <hr class="mb-5" style="border: 2px solid #d6bd8d; width: 50%; margin: auto;"> -->

		<ul style="list-style-image: url('<?php echo $ruta; ?>/vistas/images/check-solid.svg'); ">						  
			<?php 
															
			$incluye = explode(";", $habitacion["incluye"]);

			for ($i=0; $i < count($incluye); $i++):						
				
			?>

			<li></i> <?php echo $incluye[$i]; ?> </li>
			
			<?php endfor ?>              
		</ul>

		<!-- <hr class="mt-5">

		<h2 class="subtitle-main text-center">Esta reserva no incluye:</h2> -->

		<!-- <hr class="mb-5" style="border: 2px solid #d6bd8d; width: 50%; margin: auto;"> -->

		<!-- <ul>
			<li><i class="fas fa-times" style="color: red;"></i> La Tasa Portuaria ($29.000 COP, sujeta a cambios por temporada) y el Seguro de Viaje ($5.000 COP por persona, con cobertura médica y traslado en ambulancia marítima) tienen un costo total de $34.000 COP por persona, pagadero solo en efectivo. </li>             
		</ul> -->

	</div>

</div>

<div class="row">

	<div class="col-12 p-5" style="background-color: #d6bd8d;">

		<h2 class="subtitle-main text-center" style="color: #fff !important">NUESTRO ITINERARIO</h1>

		<hr class="mb-5" style="border: 2px solid #fff; width: 50%; margin: auto;">

		<div class="row">

			<?php 
									
				$itinerario = json_decode($habitacion["itinerario"], true);

				foreach ($itinerario as $count_it => $it):	
					
					if($it["titulo"] != ""):
				
				?>				

				<div class="col text-center">

					<i class="fas fa-square-check fa-3x text-light"></i>
					<hr>
					<h3><?php echo $it["titulo"]; ?></h3>
					<h2><?php echo $it["hora"]; ?></h2>
					<p><?php echo $it["descripcion"]; ?></p>

				</div>

			<?php endif; endforeach ?>
						

		</div>

	</div>

	<div class="col-12 p-5" style="background-color: #000;">

		<div class="row text-light" style="border-bottom: 1px solid #d6bd8d">

			<!-- <div class="col-md-6 p-5">
				<h2 class="subtitle-main text-center">opcional</h2>
				<br><br>
				<ul>
					<li>Lorem ipsum</li>
					<li>Lorem ipsum</li>
				</ul>
			</div> -->

			<div class="col-md-12 p-5">
				<h2 class="subtitle-main text-center">La reserva no incluye</h2>
				<br><br>
				<ul style="list-style: none">
					<?php 
																
						$noincluye = explode(";", $habitacion["noIncluye"]);

						for ($i=0; $i < count($noincluye); $i++):						
						
						?>

						<li><i class="fas fa-times" style="color: red;"></i> <?php echo $noincluye[$i]; ?></li>
					
					<?php endfor ?> 
				</ul>
			</div>

		</div>

	</div>

</div>


<!-- input niños -->

<div class="col-md-6">

							<h5>Niños</h5>

							<div class="input-group mb-3">
								<input type="number" class="form-control" name="cantidad-child" placeholder="1" min="0" value="0" unit="<?php echo $precio; ?>" id="cant" readonly>
								<div class="input-group-append">
									<span class="btn input-group-text btn-outline-gold" id="addChild"><i class="fas fa-plus"></i></span>
								</div>
								<div class="input-group-append">
									<span class="btn input-group-text btn-outline-gold" id="delChild"><i class="fas fa-minus"></i></span>
								</div>								
							</div>							

							<p id="calcularTotal" style="color: #000; display: none">1 x $<?php echo number_format($precio); ?> = $<?php echo number_format($precio); ?></p>

						</div>

						<hr>
						<h5>Niños</h5>
																						
						<?php 

							for ($i=0; $i < $_POST["cantidad-child"]; $i++) { 

								if($i == 0){

									$label1 = '<label>Nombre completo</label>';
									$label2 = '<label>Tipo identificación</label>';
									$label3 = '<label>Número identificación</label>';
									$counter = '<label><b># <span class="d-sm-block d-md-none">'.($i + 1).'.</span></b></label>';

								}else{

									$label1 = '<label class="d-sm-block d-md-none">Nombre completo</label>';
									$label2 = '<label class="d-sm-block d-md-none">Tipo identificación</label>';
									$label3 = '<label class="d-sm-block d-md-none">Número identificación</label>';
									$counter = '<hr class="d-sm-block d-md-none"><label class="d-sm-block d-md-none"><b># '.($i + 1).'.</b></label>';

								}
								
								echo'<div class="row">
								
									<div class="mt-2 col-sm-12 col-md-1">
										'.$counter.'
										<p class="d-none d-md-block">'.($i + 1).'.</p>
									</div>
									<div class="mt-2 col-sm-12 col-md">
										'.$label1.'
										<input type="text" class="form-control nameGuestKid" user="kid" required>
										<div class="invalid-feedback">
											Este campo es obligatorio.
										</div>
									</div>
									<div class="mt-2 col-sm-12 col-md">
										'.$label2.'
										<select class="form-control typeDocGuestKid" required>
											<option value="">--Seleccione--</option>
											<option value="cc">Cédula de ciudadania</option>
										</select>
										<div class="invalid-feedback">
											Este campo es obligatorio.
										</div>
									</div>
									<div class="mt-2 col-sm-12 col-md">
										'.$label3.'
										<input type="text" class="form-control docGuestKid" required>
										<div class="invalid-feedback">
											Este campo es obligatorio.
										</div>
									</div>

								</div>';

							}

						?>

						<!-- registrar pago backend -->

						<div class="table-responsive">

        <table class="table table-sm d-none">

            <thead>

                <tr class="table-info">

                  <th colspan="4">Reserva</th>

                </tr>
              
                <tr class="table-info">

                    <th>Método de pago elegido</th>                  
                    <th>Cuotas</th>
                    <th>Valor abonado</th>
                    <th>Valor cuotas</th>
                    
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td id="metodoPago"></td>                  
                    <td id="cuotas"></td>
                    <td id="montoPagado"></td>
                    <td id="valorCuotas"></td>

                </tr>

            </tbody>

        </table>

          <table class="table table-sm d-none">

            <thead>

                <tr class="table-info">

                  <th colspan="4">Historial de pagos</th>

                </tr> 
              
                <tr class="table-info">

                    <th>Fecha</th>                  
                    <th>Método de pago</th>
                    <th>Registrado por</th>
                    <th>Monto</th>

                </tr>

            </thead>

            <tbody id="historialPagos">

                

            </tbody>

          </table>

          <table class="table table-sm">
            <thead>
              <tr class="table-success">
                <th colspan="4">Registrar nuevo pago</th>
              </tr>
              <tr>
                <!-- <th style="width: 100px;">Fecha</th> -->
                <th>Método de pago</th>                
                <th>Monto</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- <td>2025-14-03</td> -->
                <td>
                  <select class="form-control" id="seleccionarMetodoPago">
                    <option value="1">Bancolombia</option>
                    <option value="2">Efectivo</option>
                    <option value="3">Davivienda</option> 
                    <option value="4">Nequi</option>
                    <option value="5">Daviplata</option>                    
                    <option value="6">MercadoPago</option>
                    <option value="7">Payu</option>
                  </select>
                </td>                
                <td>
                  <input type="text" class="form-control" name="montoPago" id="montoPago" min="10000" placeholder="0" style="text-align: right">
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-secondary" style="display:none" id="btnLinkPago"><i class="fas fa-copy"></i> Copiar link</button> 
                </td>
              </tr>
            </tbody>
          </table>

        </div>

						<!-- </div>
						</div> -->

						<!-- modal editar reserva (backend) -->

						<div class="row">
          <div class="col-md-6 mb-3">
              <label for="firstName">Nombre del titular</label>
              <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Este campo es obligatorio.
              </div>
          </div>
          <div class="col-md-6 mb-3">
              <label for="lastName">Apellidos del titular</label>
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
          <div class="col-md-6 mb-3">
              <label for="correo">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" placeholder="" required>
              <div class="invalid-feedback">
                Este campo es obligatorio.
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                <label for="">Consultar disponibilidad en otra fecha</label>
                <br><small class="infoDisponibilidad"></small>
                <div class="form-row align-items-center"> 
                    <div class="col-sm-7 my-1">
                      <label class="" for="">Fecha</label>
                      <input type="text" class="form-control datepicker entrada" autocomplete="off" name="fecha-ingreso" id="fecha_ingreso"> 
                    </div>
                    <div class="col-sm-5 my-1">
                      <label class="" for="">Personas</label>
                      <input type="number" class="form-control" id="personas" name="cantidad-personas" readonly>
                    </div>
                    <div class="col-12 my-1 d-flex">
                      <!-- <br> -->
                      <button type="button" class="btn btn-info btn-block verDisponibilidad">Validar disponibilidad</button>
                    </div>
                </div>
              </div>
          </div>
        </div>
        <!-- <hr> -->

		<!-- usuarios ant -->

		<div class="form-row">                  
                    <div class="form-group col-md-3">
                      <label for="number">Tipo de usuario</label>
                      <input type="text" class="form-control priceUser" value="Público en general" disabled>
                    </div>
                    <div class="form-group col-md-2 text-center">
                      <label for="">Visible?</label><br>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input priceVisible" id="" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[0]["visibilidad"] == "true"){ echo'checked'; } }?>>
                        <!-- <label class="form-check-label" for="">Check me out</label> -->
                      </div>
                    </div>
                    <div class="form-group col">
                      <label for="">Precio adultos</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">$</div>
                        </div>
                        <input type="number" class="form-control priceValue" id="" value="<?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[0]["visibilidad"] == "true"){ echo $precio[0]["precio"]; } }?>" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[0]["visibilidad"] != "true"){ echo 'readonly'; } }else{ echo 'readonly'; }?>>
                      </div>
                    </div>
                    <div class="form-group col">
                      <label for="">Precio niños</label>
                      <div class="input-group"> 
                        <div class="input-group-prepend">
                          <div class="input-group-text">$</div>
                        </div>
                        <input type="number" class="form-control priceValueKids" id="" value="<?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[0]["visibilidad"] == "true"){ echo $precio[0]["precioKids"]; } }?>" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[0]["visibilidad"] != "true"){ echo 'readonly'; } }else{ echo 'readonly'; }?>>
                      </div>
                    </div>
                    <div class="form-group col-md-2 text-center">
                      <label for="">Crédito?</label>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input priceCredit" id="" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[0]["credito"] == "true"){ echo'checked'; } }?>>
                        <!-- <label class="form-check-label" for="">Check me out</label> -->
                      </div>
                    </div>
                  </div> 

                  <div class="form-row">                  
                    <div class="form-group col-md-3">
                      <!-- <label for="number">Tipo de usuario</label> -->
                      <input type="text" class="form-control priceUser" value="Vendedores internos" disabled>
                    </div>
                    <div class="form-group col-md-2 text-center">
                      <!-- <label for="">Visible?</label><br> -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input priceVisible" id="" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[1]["visibilidad"] == "true"){ echo'checked'; } }?>>
                        <!-- <label class="form-check-label" for="">Check me out</label> -->
                      </div>
                    </div>
                    <div class="form-group col">
                      <!-- <label for="">Precio</label> -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">$</div>
                        </div>
                        <input type="number" class="form-control priceValue" id="" value="<?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[1]["visibilidad"] == "true"){ echo $precio[1]["precio"]; } }?>" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[1]["visibilidad"] != "true"){ echo 'readonly'; } }else{ echo 'readonly'; }?>>
                      </div>
                    </div>
                    <div class="form-group col">
                      <!-- <label for="">Precio</label> -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">$</div>
                        </div>
                        <input type="number" class="form-control priceValueKids" id="" value="<?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[1]["visibilidad"] == "true"){ echo $precio[1]["precioKids"]; } }?>" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[1]["visibilidad"] != "true"){ echo 'readonly'; } }else{ echo 'readonly'; }?>>
                      </div>
                    </div>
                    <div class="form-group col-md-2 text-center">
                      <!-- <label for="">Permitir pago a crédito?</label> -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input priceCredit" id="" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $precio[1]["credito"] == "true"){ echo'checked'; } }?>>
                        <!-- <label class="form-check-label" for="">Check me out</label> -->
                      </div>
                    </div>
                  </div>            
				  
				  <!-- setear los precios por usuario -->
				  
				  if($_SESSION["nombre"] == "Vendedor interno" && $item["usuario"] == "Vendedores internos"){
        
		if($item["visibilidad"] == "true"){

			$precio = $item["precio"];
			$visibilidad = "true";

		}else{

			$visibilidad == "false";

		}

	}else if($_SESSION["nombre"] == "Vendedor externo" && $item["usuario"] == "Vendedores externos"){

		if($item["visibilidad"] == "true"){

			$precio = $item["precio"];
			$visibilidad = "true";

		}else{

			$visibilidad == "false";

		}

	}

	<!-- permitir credito finalizar la reserva -->

	if($_SESSION["nombre"] == "Vendedor interno" && $value["usuario"] == "Vendedores internos"){

if($value["visibilidad"] == "true" && $value["credito"] == "true"){

	echo '<div class="form-check form-check-inline">
			<input class="" type="radio" name="abono" id="total3" value="credito">
			<label class="" for="total3">Pagar a crédito</label>
		</div>';

}

}else if($_SESSION["nombre"] == "Vendedor externo" && $value["usuario"] == "Vendedores externos"){

if($value["visibilidad"] == "true" && $value["credito"] == "true"){

	echo '<div class="form-check form-check-inline">
			<input class="" type="radio" name="abono" id="total3" value="credito">
			<label class="" for="total3">Pagar a crédito</label>
		</div>';

}

}
                  

<!-- galeria ant -->

$dir = "vistas/images/galeria/";

$i = 0;

if (is_dir($dir)) {

	if ($dh = opendir($dir)) {

		while (($file = readdir($dh)) !== false) {                                          

			if($file === "." || $file === "..") {                                                            

			}else if (strpos($file, "mp4") !== false){

				$ruta1 = "'images/galeria/".$file."'";

				echo'<div class="col-4 col-md-1 mt-5">
				
					<video autoplay muted loop style="margin-bottom: 0; width: 100%; height: 70px" data-toggle="modal" data-target="#exampleModal" class="gallery'.$i.'" ruta="'.$ruta1.'" type="video" onclick="showVideo('.$ruta1.', '.$i.')">
						<source src="images/galeria/'.$file.'" type="video/mp4">
						<!-- <source src="images/movie.ogg" type="video/ogg"> -->
						Your browser does not support the video tag.
					</video>
				
				</div>';

			}else{

				$ruta1 = "'images/galeria/".$file."'";

				echo '<div class="col-4 col-md-1 mt-5">
				<!-- 1 -->
				<img src="images/galeria/'.$file.'" style="width: 100%; height: 70px" data-toggle="modal" data-target="#exampleModal" class="gallery'.$i.'" ruta='.$ruta1.' type="image" onclick="showImage('.$ruta1.', '.$i.')">                        
				</div>';

			}  
			
			$i++;
			
		}

		closedir($dh);

	}

}

<!-- servicios relacionados -->

<div class="card mt-3 d-none">
				<div class="card-header">
					<div class="alert alert-info" role="alert">
						Tambien tenemos los siguientes servicios disponibles para la fecha que seleccionaste
					</div>
				</div>
				<div class="card-body">

					<form action="<?php echo $ruta; ?>reservas" method="post" id="cambiarFechaForm">
						
						<!-- <input type="hidden" name="id-habitacion" value="">						 -->
						<div class="form-row align-items-center">
							<div class="col-sm-12 my-1">
								<label class="" for="">Selecciona el servicio que deseas contratar</label>
								<select class="form-control" name="id-habitacion" required> 

									<option value="">--Seleccione--</option>

									<?php 
									
										$habitaciones = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

										foreach ($habitaciones as $key => $value) { 

											echo'<option value="'.$value["id_h"].'">'.$value["estilo"].'</option>';											

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

					<table class="table text-center table-hover d-none">

						<thead>
							<tr>
								<th></th>
								<th>Servicio</th>
								<th>Cupos disponibles</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							
								$servicios = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

								foreach ($servicios as $s => $servicio) {

									$galeria = json_decode($servicio["galeria"], true);

									echo'<tr>
									
									<td><img src="'.$servidor.$galeria[0].'" width="150px"></td>
									<td>'.$servicio["estilo"].'</td>';
									
									// reservas									

									$reservas = ControladorReservas::ctrMostrarReservas($servicio["id_h"]);																		
									
									$totalReservas = 0;									
									$cuposDisponibles = 0; 
									$cuposTotales = $servicio["cupos"];

									foreach ($reservas as $r => $reserva) {																																																		

										/* VALIDAR CRUCE DE FECHAS OPCIÓN 1 */         

										if($_POST["fecha-ingreso"] == $reserva["fecha_ingreso"]){

											$personas = explode(" ", $reserva["descripcion_reserva"]);

											for ($index = 0; $index < count($personas); $index++) {
												$item = $personas[$index];
												if(is_nan($item) == false){

													$totalReservas += intVal($item);
												
												}
											}              

										}

										// VALIDAR SERVICIOS RELACIONADOS

										$relacionados = explode(";", $reserva["serviciosEnlazados"]);

										for ($index = 0; $index < count($relacionados); $index++) {
              
											$ser = $relacionados[$index];

											$reservas = ControladorReservas::ctrMostrarReservas("id_habitacion", $ser);

											foreach ($reservas as $resRel => $reservaRel) {
												
												/* VALIDAR CRUCE DE FECHAS OPCIÓN 1 */         
        
												if($_POST["fecha-ingreso"] == $reservaRel["fecha_ingreso"]){
        
													$totalReservas++;
									  
												  }

											}

										}

									}									

									$cuposDisponibles = $cuposTotales - $totalReservas;

									// si no está disponible

									if($cuposDisponibles < 1 || $cuposDisponibles < $_POST["cantidad-personas"]){

										echo'<td>'.$cuposDisponibles.'</td>
										<td>

										 Lo sentimos no tenemos disponibilidad para esa fecha
										
										</td>';

									}else{

										echo'<td>'.$cuposDisponibles.'</td>
										<td>
										
											<form id="form1" action="'.$ruta.'reservas" method="post">

												<input type="hidden" name="id-habitacion" value="'.$servicio["id_h"].'">

												<input type="hidden" name="fecha-ingreso" value="'.$_POST["fecha-ingreso"].'">

												<input type="hidden" name="cantidad-child" value="0">

												<div class="row">
													<div class="col-sm-12 col-lg-6 offset-lg-3">

														<h5>Cúantas personas?</h5>														

														<div class="input-group mb-3">
															<input type="number" class="form-control" name="cantidad-personas" placeholder="1" min="1" value="1" id="cant" required>																							
														</div>																				

													</div>																			
													<div class="col-sm-12 col-md-12">
														<!-- <h5 style="visibility: hidden;">Accion</h5> -->
														<button type="submit" class="btn btn-default btn-lg call-to-action-btn-gold">Reservar </button>
													</div>							

												</div>																	
												
											</form>
										
										</td>';

									}

									echo'</tr>';

								}
							
							?>
						</tbody>

					</table>

				</div>
			</div>

			var idHabitacion = $(".infoReservas").attr("idHabitacion");
  var fechaIngreso = $(".infoReservas").attr("fechaIngreso");
  var fechaSalida = $(".infoReservas").attr("fechaSalida");
  var adultos = $(".infoReservas").attr("personas")
  var kids = $(".infoReservas").attr("kids")
  var totalPersonas = Number(adultos) + Number(kids);   
  var ruta = $(".infoReservas").attr("ruta")
  
  var fechaEscogida = new Date(fechaIngreso);
  var nombreHabitacion = "";
  var dias = $(".infoReservas").attr("dias");

  var totalEventos = [];
  var opcion1 = [];
  var opcion2 = [];
  var opcion3 = [];
  var validarDisponibilidad = false;
  var totalReservas = 0;
  var cuposTotales = 3;
  var cuposDisponibles = 3;

  var datos = new FormData();
  datos.append("idHabitacion", idHabitacion);

  $.ajax({

    url:urlPrincipal+"ajax/reservas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    async: false,
    success:function(rta){       
      
        const key = 'fecha_ingreso';

        const respuesta = [...new Map(rta.map(item =>
          [item[key], item])).values()];

        if(respuesta.length == 0){                    

          colDerReservas();  

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

              // console.log(cupos)

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
        
                        var personas2 = info[i]["descripcion_reserva"].split(" ");
  
                        for (let index2 = 0; index2 < personas2.length; index2++) {
                          const item2 = personas2[index2];
                          if(isNaN(item2) == false){
  
                            totalReservas += Number(item2);
                            
                          }
                        }
          
                      }                                         
          
                    }                    

                  }

                })
                
              }

              // console.log(totalReservas)

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
              
              if(cuposDisponibles == 0){

                disabledDates.push()

              }
              
              if(!validarDisponibilidad){                                      
    
                  $(".infoDisponibilidad").text("LO SENTIMOS SOLO HAY "+cuposDisponibles+" CUPOS DISPONIBLES")
    
                  $(".containerCodigoReserva").removeClass("d-flex")
                  $(".containerCodigoReserva").addClass("d-none")
                  $(".infoDisponibilidad").addClass("text-danger")
                  $("#btnPagar").hide()    
                  
                  $(".formDataBooking").hide()
                  $(".resposeBookingAvailability").show()
                  $(".responsePlaces").html("Solo hay "+cuposDisponibles+" cupos disponibles")
    
                  //break;
    
              }else{                                      
    
                  if(cuposDisponibles <= 10){

                    $(".infoDisponibilidad").text("¡SOLO HAY "+cuposDisponibles+" CUPOS DISPONIBLES!") 
                    $(".infoDisponibilidad").addClass("text-success") 

                  }
                              
    
                  colDerReservas();
    
              }

            }

          })


        }else{         
                  
          // cuposTotales = respuesta[i]["cupos"]

          // consultar reservas de este servicio

          for(var i = 0; i < respuesta.length; i++){      
            
            // console.log(respuesta[i]["fecha_ingreso"])

            // cuposTotales = respuesta[i]["cupos"]

            var cuposTotales;

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

            // console.log(cuposTotales)

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

            // console.log(respuesta[i]["fecha_ingreso"])

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
                async:false,
                success:function(info){                   

                  for(var i = 0; i < info.length; i++){

                    // console.log(info[i]["id_habitacion"])

                    /* VALIDAR CRUCE DE FECHAS OPCIÓN 1 */         
        
                    if(formatDate(fechaIngreso) == info[i]["fecha_ingreso"]){
        
                      var personas2 = info[i]["descripcion_reserva"].split(" ");

                      for (let index2 = 0; index2 < personas2.length; index2++) {
                        const item2 = personas2[index2];
                        if(isNaN(item2) == false){

                          totalReservas += Number(item2);
                          
                        }
                      }
        
                    } 
                    
                    // console.log(totalReservas)
        
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

              $(".containerCodigoReserva").removeClass("d-flex")
              $(".containerCodigoReserva").addClass("d-none")
              $(".infoDisponibilidad").addClass("text-danger")
              $("#btnPagar").hide()     
              
              $(".formDataBooking").hide()
              $(".resposeBookingAvailability").show()
              $(".responsePlaces").html("Solo hay "+cuposDisponibles+" cupos disponibles")

              //break;

          }else{                                      

              if(cuposDisponibles <= 10){

                $(".infoDisponibilidad").text("¡SOLO HAY "+cuposDisponibles+" CUPOS DISPONIBLES!") 
                $(".infoDisponibilidad").addClass("text-success") 
                
              }          

              colDerReservas();

          } 

        }
      
    }

  })

  function validarDisponibilidadFechaServicio(idHabitacion, fechaIngreso){

  // alert("hola")

  var ruta = $(".infoReservas").attr("ruta")
  var opcion1 = [];

  var datos = new FormData();
  datos.append("idHabitacion", idHabitacion);

  $.ajax({

    url:urlPrincipal+"ajax/reservas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(rta){  
      
        const key = 'fecha_ingreso';

        const respuesta = [...new Map(rta.map(item =>
          [item[key], item])).values()];

        if(respuesta.length == 0){                    

          colDerReservas(); 

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

              // console.log(cupos)

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
        
                        var personas2 = info[i]["descripcion_reserva"].split(" ");
  
                        for (let index2 = 0; index2 < personas2.length; index2++) {
                          const item2 = personas2[index2];
                          if(isNaN(item2) == false){
  
                            totalReservas += Number(item2);
                            
                          }
                        }
          
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
              
              if(cuposDisponibles == 0){

                disabledDates.push()

              }
              
              if(!validarDisponibilidad){                                      
    
                  // deshabilitar

                  swal({
                      type:"error",
                      title: "Esta fecha ya no está disponible!",
                      text: "Por favor seleecione otra fecha",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"                  
                  })

                  $(".datepicker").val('')
    
              }else{                                      
    
                  // nada                  
    
              }

            }

          })


        }else{         
                  
          //cuposTotales = respuesta[i]["cupos"]

          // consultar reservas de este servicio

          for(var i = 0; i < respuesta.length; i++){

            var cuposTotales;

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

            // console.log(cuposTotales)

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
        
                      var personas2 = info[i]["descripcion_reserva"].split(" ");

                      for (let index2 = 0; index2 < personas2.length; index2++) {
                        const item2 = personas2[index2];
                        if(isNaN(item2) == false){

                          totalReservas += Number(item2);
                          
                        }
                      }
        
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

             // deshabilitar
             
             swal({
                type:"error",
                title: "Esta fecha ya no está disponible!",
                text: "Por favor seleecione otra fecha",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"                  
            })

            $(".datepicker").val('')             

          }else{                                                    

          } 

        }
      
    }

  })

}

<!-- ant enviar pdf y enlace -->

<?php

// 1. Configuraciones necesarias
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require_once "../extensiones/vendor/dompdf/autoload.inc.php"; // Ruta real a Dompdf
require_once "../extensiones/vendor/autoload.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/PHPMailer.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/SMTP.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/Exception.php";
require_once "../modelos/reservas.modelo.php";
require_once "../controladores/ruta.controlador.php";

// var_dump($_POST);

// 2. Recibir parámetros
$correoCliente = $_POST['correo'] ?? '';
$codigoReserva = $_POST['codigoReserva'] ?? '';
$nombreCliente = $_POST['nombreCliente'] ?? '';

if (!$correoCliente || !$codigoReserva || !$nombreCliente) {
    http_response_code(400);
    echo "Parámetros faltantes";
    exit;
}

$ruta = ControladorRuta::ctrRuta();

// Crear PDF con Dompdf
$options = new Options(); // ✅ Correcto
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$url_pdf = $ruta. "?pagina=reserva_pdf&codigo=$codigoReserva";
$dompdf->loadHtml(file_get_contents($url_pdf));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Guardar PDF
$carpetaDestino = __DIR__ . '/extensiones';
if (!file_exists($carpetaDestino)) {
    mkdir($carpetaDestino, 0777, true);
}

$nombrePDF = 'reserva_' . $codigoReserva . '.pdf';
$rutaPDF = $carpetaDestino . '/' . $nombrePDF;
file_put_contents($rutaPDF, $dompdf->output());

// Enviar correo
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'niadruma@gmail.com';
    $mail->Password = 'dqcl aose hgya zfrq';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('niadruma@gmail.com', 'Marina Tours Cartagena');
    $mail->addAddress($correoCliente, $nombreCliente);
    if (file_exists($rutaPDF)) {
        $mail->addAttachment($rutaPDF, $nombrePDF);
    }

    $enlaceCompletar = $ruta . "index.php?pagina=completar-datos&token=" . $codigoReserva;

    $mail->isHTML(true);
    $mail->Subject = 'Confirmación de tu reserva #' . $codigoReserva;
    $mail->Body = '
    <html>
        <head><meta charset="UTF-8"></head>
        <body>
            <h2>¡Gracias por tu reserva!</h2>
            <p>Adjunto encontrarás el comprobante de tu reserva.</p>
            <p>Por favor completa los datos adicionales en el siguiente enlace:</p>
            <p><a href="' . $enlaceCompletar . '">Completar datos de la reserva</a></p>
        </body>
    </html>';

    if ($mail->send()) {
        unlink($rutaPDF);

        // Eliminamos cookies después del envío exitoso
        $cookies = [
            "idHabitacion", "id_user", "imgHabitacion", "infoHabitacion", "pagoReserva",
            "codigoReserva", "fechaIngreso", "fechaSalida", "firstName", "lastName",
            "tipo_identificacion", "numero_identificacion", "celular", "correo", "hospedaje",
            "abono", "cuotas", "montoPagar", "valorCuotas", "pagoCuotas"
        ];

        foreach ($cookies as $cookieName) {
            setcookie($cookieName, "", time() - 3600, $ruta);
            setcookie($cookieName, "", time() - 3600, "/");
        }
        
    } else {
        echo "ok";
    }

} catch (Exception $e) {
    http_response_code(500);
    echo "Error al enviar el correo: " . $mail->ErrorInfo;
} finally {
    if (file_exists($rutaPDF)) unlink($rutaPDF); // Limpieza
    
    
    // boton de pago en el pdf agregar despues del ulktimo td
    $pagos =  ControladorReservas::ctrMostrarPagos("id_reserva", $reserva["id_reserva"]);	

                                    if($reserva["abono"] == "total"){  
                                        
                                        $button_pago = '';

                                    }else{

                                        $pagado = 0;	
                                        
                                        if($reserva["abono"] == "abono"){

                                            $pagado += $reserva["pago_reserva"] / 2;

                                        }
                                    
                                        foreach ($pagos as $row => $item) {
                                            
                                            $pagado += $item["monto"];

                                        }

                                        $saldo_p = $reserva["pago_reserva"] - $pagado;

                                        if($saldo_p > 0){

                                            if($reserva["estado"] == 2){

                                                $style = 'style="text-decoration: line-through;"';

                                                echo '
                                        
                                                    <tr>
                                                    
                                                        <th>Saldo pendiente</th>
                                                        <td '.$style.'>$ '.number_format($saldo_p, 2).' <span class="badge badge-warning ml-2">Anulada</span></td>
                                                    
                                                    </tr>
                                                
                                                ';

                                            }else if($reserva["estado"] == 3){

                                                $style = 'style="text-decoration: line-through;"';

                                                echo '
                                        
                                                    <tr>
                                                    
                                                        <th>Saldo pendiente</th>
                                                        <td '.$style.'>$ '.number_format($saldo_p, 2).' <span class="badge badge-danger ml-2">Devolución</span></td>
                                                    
                                                    </tr>
                                                
                                                ';

                                            }else{

                                                $style = '';

                                                echo '
                                        
                                                    <tr>
                                                    
                                                        <th>Saldo pendiente</th>
                                                        <td '.$style.'>$ '.number_format($saldo_p, 2).'</td>
                                                    
                                                    </tr>
                                                
                                                ';

                                            }                                            

                                            $info_habitacion = ControladorHabitaciones::ctrMostrarHabitaciones("id_h", $reserva["id_habitacion"]);
                                            $desc = $reserva["descripcion_reserva"];
                                            $descArr = explode("-", $desc);
                                            $personasArr = explode(" ", $descArr[1]);
                                            $galeria = json_decode($info_habitacion["galeria"], true);
                                            $imgHabitacion = ControladorRuta::ctrServidor().$galeria[0];
                                            $infoHabitacion = $reserva["descripcion_reserva"];
                                            $pagoReserva = $reserva["pago_reserva"];
                                            $pagoActual = $saldo_p;
                                            $codigoReserva = $reserva["codigo_reserva"];
                                            $fecha = $reserva["fecha_ingreso"];
                                            $plan = "";
                                            $personas = $personasArr[1];
                                            $firstName = $reserva["firstName"];
                                            $lastName = $reserva["lastName"];
                                            $tipo_identificacion = $reserva["tipo_identificacion"];
                                            $numero_identificacion = $reserva["numero_identificacion"];
                                            $celular = $reserva["celular"];
                                            $correo = $reserva["correo"];
                                            $hospedaje = $reserva["hospedaje"];
                                            $abono = $reserva["abono"];
                                            $cuotas = $reserva["cuotas"];
                                            $montoPagar = $reserva["montoPagar"];
                                            $valorCuotas = $reserva["valorCuotas"];
                                            $pagoCuotas = $reserva["pagoCuotas"];                                            

                                            $button_pago = "

                                            <a href='".ControladorRuta::ctrRuta()."index.php?addPayment=true&idHabitacion=".$info_habitacion["id_h"]."&imgHabitacion=".$imgHabitacion."&infoHabitacion=".$infoHabitacion."&pagoReserva=".$pagoReserva."&pagoActual=".$pagoActual."&idReserva=".$reserva["id_reserva"]."&codigoReserva=".$codigoReserva."&fechaIngreso=".$fecha."&fechaSalida=".$fecha."&plan=".$plan."&personas=".$personas."&firstName=".$firstName."&lastName=".$lastName."&tipo_identificacion=".$tipo_identificacion."&numero_identificacion=".$numero_identificacion."&celular=".$celular."&correo=".$correo."&hospedaje=".$hospedaje."&abono=".$abono."&cuotas=".$cuotas."&montoPagar=".$montoPagar."&valorCuotas=".$valorCuotas."&pagoCuotas=".$pagoCuotas."' class='btn btn-success'><i class='far fa-credit-card'></i> Pagar saldo pendiente
                                            </a>                                            
                                            
                                            ";

                                        }else{

                                            $button_pago = '';

                                        }

                                    }
}

// pagos reserva_pdf saldo pendiente

 $pagos =  ControladorReservas::ctrMostrarPagos("id_reserva", $reserva["id_reserva"]);	

                                                if($reserva["abono"] == "total"){  
                                                    
                                                    $button_pago = '';

                                                }else{

                                                    $pagado = 0;	
                                                    
                                                    if($reserva["abono"] == "abono"){

                                                        $pagado += $reserva["pago_reserva"] / 2;

                                                    }
                                                
                                                    foreach ($pagos as $row => $item) {
                                                        
                                                        $pagado += $item["monto"];

                                                    }

                                                    $saldo_p = $reserva["pago_reserva"] - $pagado;

                                                    if($saldo_p > 0){

                                                        if($reserva["estado"] == 2){

                                                            $style = 'style="text-decoration: line-through;"';

                                                            echo '
                                                    
                                                                <tr>
                                                                
                                                                    <th>Saldo pendiente</th>
                                                                    <td '.$style.'>$ '.number_format($saldo_p, 2).' <span class="badge badge-warning ml-2">Anulada</span></td>
                                                                
                                                                </tr>
                                                            
                                                            ';

                                                        }else if($reserva["estado"] == 3){

                                                            $style = 'style="text-decoration: line-through;"';

                                                            echo '
                                                    
                                                                <tr>
                                                                
                                                                    <th>Saldo pendiente</th>
                                                                    <td '.$style.'>$ '.number_format($saldo_p, 2).' <span class="badge badge-danger ml-2">Devolución</span></td>
                                                                
                                                                </tr>
                                                            
                                                            ';

                                                        }else{

                                                            $style = '';

                                                            echo '
                                                    
                                                                <tr>
                                                                
                                                                    <th>Saldo pendiente</th>
                                                                    <td '.$style.'>$ '.number_format($saldo_p, 2).'</td>
                                                                
                                                                </tr>
                                                            
                                                            ';

                                                        }                                            

                                                        $info_habitacion = ControladorHabitaciones::ctrMostrarHabitaciones("id_h", $reserva["id_habitacion"]);
                                                        $desc = $reserva["descripcion_reserva"];
                                                        $descArr = explode("-", $desc);
                                                        $personasArr = explode(" ", $descArr[1]);
                                                        $galeria = json_decode($info_habitacion["galeria"], true);
                                                        $imgHabitacion = ControladorRuta::ctrServidor().$galeria[0];
                                                        $infoHabitacion = $reserva["descripcion_reserva"];
                                                        $pagoReserva = $reserva["pago_reserva"];
                                                        $pagoActual = $saldo_p;
                                                        $codigoReserva = $reserva["codigo_reserva"];
                                                        $fecha = $reserva["fecha_ingreso"];
                                                        $plan = "";
                                                        $personas = $personasArr[1];
                                                        $firstName = $reserva["firstName"];
                                                        $lastName = $reserva["lastName"];
                                                        $tipo_identificacion = $reserva["tipo_identificacion"];
                                                        $numero_identificacion = $reserva["numero_identificacion"];
                                                        $celular = $reserva["celular"];
                                                        $correo = $reserva["correo"];
                                                        $hospedaje = $reserva["hospedaje"];
                                                        $abono = $reserva["abono"];
                                                        $cuotas = $reserva["cuotas"];
                                                        $montoPagar = $reserva["montoPagar"];
                                                        $valorCuotas = $reserva["valorCuotas"];
                                                        $pagoCuotas = $reserva["pagoCuotas"];                                            

                                                        $button_pago = "

                                                        <a href='".ControladorRuta::ctrRuta()."index.php?addPayment=true&idHabitacion=".$info_habitacion["id_h"]."&imgHabitacion=".$imgHabitacion."&infoHabitacion=".$infoHabitacion."&pagoReserva=".$pagoReserva."&pagoActual=".$pagoActual."&idReserva=".$reserva["id_reserva"]."&codigoReserva=".$codigoReserva."&fechaIngreso=".$fecha."&fechaSalida=".$fecha."&plan=".$plan."&personas=".$personas."&firstName=".$firstName."&lastName=".$lastName."&tipo_identificacion=".$tipo_identificacion."&numero_identificacion=".$numero_identificacion."&celular=".$celular."&correo=".$correo."&hospedaje=".$hospedaje."&abono=".$abono."&cuotas=".$cuotas."&montoPagar=".$montoPagar."&valorCuotas=".$valorCuotas."&pagoCuotas=".$pagoCuotas."' class='btn btn-success'><i class='far fa-credit-card'></i> Pagar saldo pendiente
                                                        </a>                                            
                                                        
                                                        ";

                                                    }else{

                                                        $button_pago = '';

                                                    }

                                                }
