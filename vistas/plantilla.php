<?php

session_start();

$ruta = ControladorRuta::ctrRuta();
$servidor = ControladorRuta::ctrServidor();

?>

<!doctype html>
<html lang="en">
  <head>
  	<base href="vistas/">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Travelix Project">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/icono.png">

    <title>Inicio | Heaven Tours Cartagena SAS</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/album/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template -->
    <link href="styles/styles.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/plugins/bootstrap-datepicker.standalone.min.css">
	<!-- datetimepicker -->
	<link rel="stylesheet" href="css/plugins/jquery.datetimepicker.css">

	<!-- iCheck -->
	<link rel="stylesheet" href="css/plugins/iCheck-flat-blue.css">	
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- si hay algun error de visualizacion en alguna seccion revisar este enlace -->

	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
	
	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css"> -->
	 <!-- Select2 -->
	<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
  	<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  	
  	<!-- CSS -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css" />-->
    
    <!--galerias-->
    <!-- Fancybox 5 CSS -->
    <!-- En el <head> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    
    <!-- Antes del cierre de </body> -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>


	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.2.1.min.js"></script>
	<script src="styles/bootstrap4/popper.js"></script>
	<script src="styles/bootstrap4/bootstrap.min.js"></script>

	<!-- datetimepicker -->
	<!-- https://xdsoft.net/jqplugins/datetimepicker/ -->
	<script src="js/plugins/jquery.datetimepicker.full.min.js"></script>
	<!-- bootstrap datepicker -->
	<!-- https://bootstrap-datepicker.readthedocs.io/en/latest/ -->
	<script src="js/plugins/bootstrap-datepicker.min.js"></script>
	<!-- SWEET ALERT 2 -->	
	<!-- https://sweetalert2.github.io/ -->
	<!--<script src="js/plugins/sweetalert2.all.js"></script>-->
	
	<!-- SweetAlert2 CSS (opcional, pero recomendado) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<!-- iCheck -->
	<!-- http://icheck.fronteed.com/ -->
	<script src="js/plugins/icheck.min.js"></script>	

	<!-- Latest compiled and minified JavaScript -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script> -->

	<!-- Select2 -->
	<script src="https://adminlte.io/themes/v3/plugins/select2/js/select2.full.min.js"></script>

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/vader/jquery-ui.css" rel="stylesheet"/> -->
	<!-- JS -->

	<style>
	
	    .float{
        	position:fixed;
        	width:60px;
        	height:60px;
        	bottom:40px;
        	right:40px;
        	background-color:#25d366;
        	color:#FFF;
        	border-radius:50px;
        	text-align:center;
          font-size:30px;
        	box-shadow: 2px 2px 3px #999;
          z-index:100;
        }
        
        .my-float{
        	margin-top:16px;
        }
	
		th.next{
			color: black !important;
			position: absolute;
			top: 25px;
			right: 10px;
		}

		th.prev{
			color: black !important;
			position: absolute;
			top: 25px;
			left: 10px;
		}

		button, .btn{
			cursor: pointer !important;
		}

		.print{
			display: none;
		}

		#container-info-perfil{
			margin-top: 50px; margin-bottom: 150px
		}

		/* Next & previous buttons */
		.prev, .next {
			cursor: pointer;
			position: absolute;
			top: 50%;
			width: auto;
			margin-top: -22px;
			padding: 16px;
			color: white;
			font-weight: bold;
			font-size: 18px;
			transition: 0.6s ease;
			border-radius: 0 3px 3px 0;
			user-select: none;
		}

		/* Position the "next button" to the right */
		.next {
			right: 0;
			border-radius: 3px 0 0 3px;
		}
		.prev {
			left: 0;
			border-radius: 3px 0 0 3px;
		}

		/* On hover, add a black background color with a little bit see-through */
		.prev:hover, .next:hover {
		background-color: rgba(0,0,0,0.8);
		}

		@media print {
			.noprint {
				display: none;
			}
			.print{
				display: block;
			}
			#container-info-perfil{
				margin-top: 0; margin-bottom: 0;
			}
		}

	</style>

	<script>

		$('.prev i').removeClass();
		$('.prev i').addClass("fa fa-chevron-left");

		$('.next i').removeClass();
		$('.next i').addClass("fa fa-chevron-right");

		function showImage(archivo, iterador){

			// console.log(iterador)

			var max = $("[class*='gallery']:last")			

			if(Number(iterador) == max){

				$(".next").attr("next", 2)

			}else{

				$(".next").attr("next", (Number(iterador) + 1))

			}

			if(Number(iterador) == 2){

				$(".prev").attr("prev", max)

			}else{

				$(".prev").attr("prev", (Number(iterador) - 1))

			}
			
			$("#show-video").hide()

			$("#show-image").show()

			$("#show-image").attr("src", archivo)

		}

		function showVideo(archivo, iterador){

			if(Number(iterador) == 25){

			$(".next").attr("next", 2)

			}else{

			$(".next").attr("next", (Number(iterador) + 1))

			}

			if(Number(iterador) == 2){

			$(".prev").attr("prev", 25)

			}else{

			$(".prev").attr("prev", (Number(iterador) - 1))

			}

			$("#show-image").hide()

			$("#show-video").show()			

			$("#show-video").attr("src", archivo)

		}

		function showNimage(n){

			var archivo = $("[class*='gallery"+n+"']").attr("ruta")			

			var type = $("[class*='gallery"+n+"']").attr("type")	

			if(type == "image"){
				showImage(archivo, n)
			}else{
				showVideo(archivo, n)
			}

			

		}

	</script>

  </head>

  <body>

<?php 

if(isset($_GET["user_access"])){	

	$tabla = "usuarios";
	$item = "email";
	$valor = $_GET["user_access"];

	$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor); 

	if($respuesta == 0){

		echo'<script>
		
		console.log("'.$respuesta.'");

		</script>';

	}else{

		$_SESSION["validarSesion"] = "ok";
		$_SESSION["id"] = $respuesta["id_u"];
		$_SESSION["nombre"] = $respuesta["nombre"];
		$_SESSION["foto"] = $respuesta["foto"];
		$_SESSION["email"] = $respuesta["email"];
		$_SESSION["modo"] = $respuesta["modo"];	

		$ruta = ControladorRuta::ctrRuta();

		echo '<script>		
	
			window.location = "'.$ruta.'reservas";		 		

			// ".$ruta."perfil

		</script>';

	}

}

// validar si viene un link de pago

if(isset($_GET["addPayment"])){

	echo'<script>

	// alert("hola")

	/*=============================================
	FUNCIÓN PARA GENERAR COOKIES
	=============================================*/

	function crearCookie(nombre, valor, diasExpedicion){

	var hoy = new Date();

	hoy.setTime(hoy.getTime() + (diasExpedicion * 24 * 60 * 60 * 1000));

	var fechaExpedicion = "expires=" + hoy.toUTCString();

	document.cookie = nombre + "=" + valor + "; " + fechaExpedicion;

	}
	
	crearCookie("addPayment", "true", 1);
	crearCookie("idReserva", "'.$_GET["idReserva"].'", 1);
	crearCookie("idHabitacion", "'.$_GET["idHabitacion"].'", 1);
    crearCookie("imgHabitacion", "'.$_GET["imgHabitacion"].'", 1);
    crearCookie("infoHabitacion", "'.$_GET["infoHabitacion"].'", 1);
    crearCookie("pagoReserva", "'.$_GET["pagoReserva"].'", 1);
    crearCookie("pagoActual", "'.$_GET["pagoActual"].'", 1);
    crearCookie("codigoReserva", "'.$_GET["codigoReserva"].'", 1);
    crearCookie("fechaIngreso", "'.$_GET["fechaIngreso"].'", 1); 
    crearCookie("fechaSalida", "'.$_GET["fechaSalida"].'", 1);
    crearCookie("firstName", "'.$_GET["firstName"].'", 1);
    crearCookie("lastName", "'.$_GET["lastName"].'", 1);
    crearCookie("tipo_identificacion", "'.$_GET["tipo_identificacion"].'", 1);
    crearCookie("numero_identificacion", "'.$_GET["numero_identificacion"].'", 1); 
    crearCookie("celular", "'.$_GET["celular"].'", 1);
    crearCookie("correo", "'.$_GET["correo"].'", 1);    
    crearCookie("hospedaje", "'.$_GET["hospedaje"].'", 1);
    crearCookie("abono", "'.$_GET["abono"].'", 1);
    crearCookie("cuotas", "'.$_GET["cuotas"].'", 1); 
    crearCookie("montoPagar", "'.$_GET["montoPagar"].'", 1); 
    crearCookie("valorCuotas", "'.$_GET["valorCuotas"].'", 1); 
    crearCookie("pagoCuotas", "'.$_GET["pagoCuotas"].'", 1);     

    window.location = "'.$ruta.'perfil";	

	</script>';

}

?>

<?php

if(isset($_POST["idioma"])){

	// if($_POST["idioma"] == "es"){

	// 	include "paginas/modulos/header.php";

	// }else{

	// 	include "paginas/modulos/header_en.php";

	// }


}else{

	include "paginas/modulos/header.php";

}

// include "paginas/modulos/modal.php";

/*=============================================
PÁGINAS
=============================================*/

if(isset($_GET["pagina"])){
	

	$rutasHabitaciones = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

	//$validarRuta = "habitaciones";

	foreach ($rutasHabitaciones as $key => $value) {

		if($_GET["pagina"] == $value["ruta"]){

			$validarRuta = "habitaciones";

		} 
		
	}
	

	/*=============================================
	VALIDAR CORREO
	=============================================*/

	$item = "email_encriptado";
	$valor = $_GET["pagina"];

	$validarCorreo = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

	if($validarCorreo && $validarCorreo["email_encriptado"] == $_GET["pagina"]){

		$id = $validarCorreo["id_u"];
		$item = "verificacion";
		$valor = 1;

		$verificarUsuario = ControladorUsuarios::ctrActualizarUsuario($id, $item, $valor);

		if($verificarUsuario == "ok"){

			echo'<script>

					swal({
							type:"success",
						  	title: "¡CORRECTO!",
						  	text: "¡Su cuenta ha sido verificada, ya puede ingresar al sistema!",
						  	showConfirmButton: true,
							confirmButtonText: "Cerrar"
						  
					}).then(function(result){

							if(result.value){   
							    history.back();
							  } 
					});

				</script>';

			return;

		}


	}

	/*=============================================
	LISTA BLANCA DE PÁGINAS INTERNAS
	=============================================*/

	    if($_GET["pagina"] == "reservas" 
		|| $_GET["pagina"] == "perfil" 
		|| $_GET["pagina"] == "salir"
		|| $_GET["pagina"] == "pasadias"
		|| $_GET["pagina"] == "transporte"
		|| $_GET["pagina"] == "contactenos"
		|| $_GET["pagina"] == "galeria"
		|| $_GET["pagina"] == "reserva-exitosa"
		|| $_GET["pagina"] == "ver-reserva"
		|| $_GET["pagina"] == "completar-datos"
		|| $_GET["pagina"] == "tyc"
		|| $_GET["pagina"] == "datos-personales"
		|| $_GET["pagina"] == "reserva_pdf"
		|| $_GET["pagina"] == "procesar_pago"
		|| $_GET["pagina"] == "exito"
		|| $_GET["pagina"] == "pendiente"
		|| $_GET["pagina"] == "fallo"
		|| $_GET["pagina"] == "comentarios"
		|| $_GET["pagina"] == "resultado-pago"){

		include "paginas/".$_GET["pagina"].".php";
		
	}else if($validarRuta != ""){

		include "paginas/habitaciones.php";

	}else{

		echo '<script>

		window.location = "'.$ruta.'";

		</script>';
	}

}else{

	include "paginas/inicio.php";

}


/*=============================================
PÁGINAS
=============================================*/

// get all locked days

$fechas_bloqueadas = ModeloCategorias::mdlMostrarCategorias("fechas_bloqueadas", null, null);

$array_dates = [];

foreach ($fechas_bloqueadas as $key => $value) {

	$fechaFinal = new DateTime($value["fecha_final"]);
	$fechaFinal ->add(new DateInterval("P1D"));
	
	$period = new DatePeriod(
		new DateTime($value["fecha_inicial"]),
		new DateInterval('P1D'),
		$fechaFinal
	);

	foreach ($period as $key => $value) {
		
		$date = $value->format('d-m-Y');
		array_push($array_dates, $date);

	}	

}

date_default_timezone_set("America/Bogota");

$horaActual = date("H"); // Obtiene la hora actual en formato de 24 horas

if ($horaActual > 5) {

	array_push($array_dates, date("d-m-Y"));

}

// $array_dates .= ']';

// var_dump(json_encode($array_dates));

// echo '';

include "paginas/modulos/footer.php";

?>

<a href="https://api.whatsapp.com/send?phone=573043752759&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20." class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i>
</a>

</div>

<input type="hidden" id="arrayDates" value="<?php echo implode(";", $array_dates); ?>">
<input type="hidden" value="<?php echo $ruta; ?>" id="urlPrincipal"> 
<input type="hidden" value="<?php echo $servidor; ?>" id="urlServidor">

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script src="js/custom.js"></script>
<script src="js/brick.js"></script>
<script src="js/idiomas.js"></script>
<!-- <script src="js/plantilla.js"></script> -->
<!-- <script src="js/menu.js"></script> -->
<!-- <script src="js/idiomas.js"></script> -->
<!-- <script src="js/habitaciones.js"></script> -->
<!-- <script src="js/agendas.js"></script> -->
<script src="js/reservas.js"></script>
<!-- <script src="js/reservas2.js"></script> -->

<!-- <script src="js/agendas2.js"></script> -->


<!-- <div class="gtranslate_wrapper"></div> -->
<!-- <div class="gtranslate_wrapper"></div> -->
<script>

	$('.select2').select2();

</script>
<script>window.gtranslateSettings = {"default_language":"es","languages":["es","en", "pt"],"wrapper_selector":".gtranslate_wrapper"}</script>
<script src="https://cdn.gtranslate.net/widgets/latest/fc.js" defer></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '2180677115313399',
      xfbml      : true,
      version    : 'v3.3'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<script>
	<?php $habitaciones = ControladorHabitaciones::ctrMostrarHabitaciones(null, null); ?>
	let slideIndex = [<?php foreach ($habitaciones as $key => $value) {
		echo '1, ';
	} ?>];
	
	let slideId = [<?php foreach ($habitaciones as $key => $value) {
		echo '"mySlides'.($key + 1).'",';
	} ?>]

	<?php foreach ($habitaciones as $key => $value) {
		echo 'showSlides(1, '.$key.');';
	} ?>                

	function plusSlides(n, no) {
	showSlides(slideIndex[no] += n, no);
	}

	function showSlides(n, no) {
	let i;
	let x = document.getElementsByClassName(slideId[no]);
	if (n > x.length) {slideIndex[no] = 1}    
	if (n < 1) {slideIndex[no] = x.length}
	for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";  
	}
	x[slideIndex[no]-1].style.display = "block";  
	}	

	// $("#arrayDates").val()

</script>
<!-- Fancybox 5 UMD JS -->
<!--<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox.umd.js"></script>-->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const videos = document.querySelectorAll("video");

    videos.forEach((video) => {
      video.autoplay = false;
      video.removeAttribute("autoplay");
      video.pause();
    });
  });
</script>

  </body>
</html>