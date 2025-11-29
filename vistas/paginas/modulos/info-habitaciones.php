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
    
    $categoria = $habitacion["tipo_h"];
    $texto = $habitacion["descripcion_h"];
    
    // $partes = explode("**", $habitacion["descripcion_h"]);
    
    // // var_dump(trim($partes[1]));

    // $descripcion = isset($partes[0]) ? trim($partes[0]) : $habitacion["descripcion_h"];
    // $descripcion_larga = isset($partes[1]) ? trim($partes[1]) : $habitacion["descripcion_h"];
    // $abono_partes = explode("//", $descripcion);
    // $descripcion_corta = isset($abono_partes[1]) ? trim($abono_partes[1]) : '';
    // $abono_texto = isset($abono_partes[0]) ? trim($abono_partes[0]) : '';
    // $texto_abono_partes = explode(":", $abono_texto);
    // $text_abono = isset($texto_abono_partes[1]) ? trim($texto_abono_partes[1]) : '';
    
    // Inicializar las variables
    $abono = '';
    $descripcion_corta = '';
    $descripcion_larga = '';
    
    // Paso 1: Ver si hay **
    if (strpos($texto, '**') !== false) {
        [$parte1, $descripcion_larga] = explode('**', $texto, 2);
        $descripcion_larga = trim($descripcion_larga);
    } else {
        // Si no hay **, todo es descripción
        $parte1 = $texto;
        $descripcion_larga = trim($texto);
    }
    
    // Paso 2: Ver si parte1 contiene //
    if (strpos($parte1, '//') !== false) {
        [$posible_abono, $descripcion_corta] = explode('//', $parte1, 2);
        $descripcion_corta = trim($descripcion_corta);
    
        // Paso 3: Ver si el posible abono contiene :
        if (strpos($posible_abono, ':') !== false) {
            [, $abono] = explode(':', $posible_abono, 2);
            $abono = trim($abono);
        }
    } else {
        // Si no hay //, usar todo como descripción corta
        $descripcion_corta = trim($parte1);
    }

    
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

				if($item["visibilidad"] == "true"){

					$precio = $item["precio"];
					$precioKids = $item["precioKids"];
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

					// habilitar el if para solo permitir imagenes verticales

					// if ($width < $height) { 
					
						if (strpos($source, "mp4") !== false): ?>

							<!-- tratar de mostrar los videos -->

						<?php else: ?>

							<div class="mySlides1">

							<div class="images-gallery" style="background-image: url('<?php echo $servidor.$source; ?>'); background-position: center; background-size: cover; width: 100%;"></div>
								
							</div>

						<?php endif; ?>

					<!-- // } -->

				<?php } ?> 

			<!-- Next and previous buttons -->
			<a class="prev" onclick="plusSlides(-1, 0)"><i class="fas fa-chevron-left" style="color: #d6bd8d"></i></a>
			<a class="next" onclick="plusSlides(1, 0)"><i class="fas fa-chevron-right" style="color: #d6bd8d"></i></a>	

			</div>
			<br>
			
			<!-- The dots/circles -->
			<!-- <div style="text-align:center">
				<span class="dot" onclick="currentSlide(1)"></span>
				<span class="dot" onclick="currentSlide(2)"></span>
				<span class="dot" onclick="currentSlide(3)"></span>
			</div>                        -->

		</div> 
		<div class="col-md-6">

			<div class="p-3 container-info-servicio" style="border: 2px solid #d6bd8d; border-radius: 15px;">

				<h1 class="title-main"><?php echo $habitacion["estilo"]; ?></h1>
				<h2>COSTO $<?php echo number_format($precio); ?> COP / POR PERSONA</h2>				
				<small class="text-muted">** El precio para los <b>niños</b> con el rango de edad de 4-6 años es de <b>$<?php echo number_format($precioKids); ?> COP</b></small>
				<h4 class="mt-3">puedes reservar abonando:</h4>
				<h4 class="subtitle-main"><?php echo $abono; ?></h4>			

				<p class="description-service" style=""><p><?php echo nl2br(htmlspecialchars($descripcion_corta)); ?></p></p>

				<!-- <hr> -->

				<label class="label-main">Personaliza tu reserva</label>			

				<form id="form1" action="<?php echo $ruta; ?>reservas" method="post">

					<input type="hidden" name="id-habitacion" value="<?php echo $habitacion["id_h"]; ?>">

					<div class="row">
						<div class="col-sm-12 col-md-5">

							<h5>Cantidad de personas</h5>

							<input type="hidden" class="form-control" name="cantidad-child" placeholder="1" min="0" value="0">

							<div class="input-group mb-3">
								<input type="number" class="form-control" name="cantidad-personas" placeholder="1" min="1" value="1" unit="<?php echo $precio; ?>" id="cant" required>
								<div class="input-group-append">
									<span class="btn input-group-text btn-outline-gold" id="addPerson"><i class="fas fa-plus"></i></span>
								</div>
								<div class="input-group-append">
									<span class="btn input-group-text btn-outline-gold" id="delPerson"><i class="fas fa-minus"></i></span>
								</div>								
							</div>							

							<p id="calcularTotal" style="color: #000; display: none">1 x $<?php echo number_format($precio); ?> = $<?php echo number_format($precio); ?></p>

						</div>						
						<div class="col-sm-12 col-md p-lg-0">

							<h5>Fecha de tu reserva</h5>

							<div class="input-group mb-3">				
								<input type="text" class="form-control datepicker entrada" name="fecha-ingreso" placeholder="" required>
								<div class="input-group-append">
									<span class="btn input-group-text btn-outline-gold" id="showCalendar"><i class="fas fa-calendar"></i></span>
								</div>                    
							</div>						

						</div>
						<div class="col-sm-12 col-md">
							<h5 style="visibility: hidden;">Accion</h5>
							<button type="submit" class="btn btn-default btn-lg call-to-action-btn-gold">Reservar </button>
						</div>							

					</div>																	
					
				</form>

			</div>

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

<div class="row p-5" style="background-image: url('<?php echo $servidor ?>vistas/img/plantilla/back_general.jpg'); background-size: cover; background-position: center;">

	<div class="col-md-6 offset-md-3 p-5" style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9));">

		<h1 class="title-main pt-5"><?php echo $habitacion["estilo"]; ?></h1>
		<h2 class="subtitle-main">¡Ven a conocer nuestro paraíso!</h2>

		<br>

		<p><?php echo nl2br(htmlspecialchars($descripcion_larga)); ?></p>

		<hr class="mb-5" style="border: 2px solid #d6bd8d; width: 50%; margin: auto;">

	</div>        

</div>

<div class="row p-5 <?php if($categoria === 3){ echo 'd-none'; } ?>" style="background-color: #000;">

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

<div class="row <?php if($categoria === 3){ echo 'd-none'; } ?>">

	<div class="col-12 p-5" style="background-color: #d6bd8d;">

		<h2 class="subtitle-main text-center" style="color: #fff !important">ACTIVIDADES</h1>

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
