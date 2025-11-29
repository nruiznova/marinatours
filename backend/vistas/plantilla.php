<?php 
session_start();
$ruta = ControladorRuta::ctrRuta();
$rutaBackend = ControladorRuta::ctrRutaBackend();

if(isset($_SESSION["idBackend"])){

	$admin = ControladorAdministradores::ctrMostrarAdministradores("id", $_SESSION["idBackend"]);

	$permisos = json_decode($_SESSION["permisos"], true);
	
	// var_dump($permisos);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="x-ua-compatible" content="ie=edge">
 
	<title>Heaven Tours | Backend</title>

	<link rel="icon" href="vistas/img/plantilla/icono.png">

	<!--=====================================
	VÍNCULOS CSS
	======================================-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" >

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" integrity="zmfNZmXoNWBMemUOo1XUGFfc0ihGGLYdgtJS3KCr/l0=">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	 <!-- Google Font: Source Sans Pro -->
  	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	<!-- Theme style AdmninLTE -->
  	<link rel="stylesheet" href="vistas/css/plugins/adminlte.min.css">

	<!-- Select2 -->
	<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
  	<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  	<!-- DataTables -->
	<link rel="stylesheet" href="vistas/css/plugins/dataTables.bootstrap4.min.css">	
	<link rel="stylesheet" href="vistas/css/plugins/responsive.bootstrap.min.css">

	<!-- Bootstrap Color Picker -->
	 <link rel="stylesheet" href="vistas/css/plugins/bootstrap-colorpicker.min.css">

	<!-- iCheck -->
  	<link rel="stylesheet" href="vistas/css/plugins/iCheck-flat-blue.css">	

  	<!-- Pano -->
	<link rel="stylesheet" href="vistas/css/plugins/jquery.pano.css">

	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="vistas/css/plugins/bootstrap-datepicker.standalone.min.css">

	 <!-- fullCalendar -->
	<link rel="stylesheet" href="vistas/css/plugins/fullcalendar.min.css">

	<!-- Morris chart -->
  	<link rel="stylesheet" href="vistas/css/plugins/morris.css">
	<!-- daterange -->
	<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/daterangepicker/daterangepicker.css">	

	<!--=====================================
	VÍNCULOS JAVASCRIPT
	======================================-->

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	
	<!-- AdminLTE App -->
	<script src="vistas/js/plugins/adminlte.min.js"></script>

	<!-- Select2 -->
	<script src="https://adminlte.io/themes/v3/plugins/select2/js/select2.full.min.js"></script>

	<!-- DataTables 
	https://datatables.net/-->
	<script src="https://adminlte.io/themes/v3/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/jszip/jszip.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  	<!-- SWEET ALERT 2 -->	
	<!-- https://sweetalert2.github.io/ -->
	<script src="vistas/js/plugins/sweetalert2.all.js"></script>

	<!-- CKEDITOR -->
	<!-- https://ckeditor.com/ckeditor-5/#classic -->
	<script src="vistas/js/plugins/ckeditor.js"></script>

	<!-- bootstrap color picker 
	https://farbelous.github.io/bootstrap-colorpicker/v2/-->
  	<script src="vistas/js/plugins/bootstrap-colorpicker.min.js"></script>

  	<!-- iCheck -->
	<!-- http://icheck.fronteed.com/ -->
	<script src="vistas/js/plugins/icheck.min.js"></script>

	<!-- Pano -->
	<!-- https://www.jqueryscript.net/other/360-Degree-Panoramic-Image-Viewer-with-jQuery-Pano.html -->
	<script src="vistas/js/plugins/jquery.pano.js"></script>

	<!-- bootstrap datepicker -->
	<!-- https://bootstrap-datepicker.readthedocs.io/en/latest/ -->
	<script src="vistas/js/plugins/bootstrap-datepicker.min.js"></script>

	<!-- fullCalendar -->
	<!-- https://momentjs.com/ -->
	<script src="vistas/js/plugins/moment.js"></script>
	<!-- https://fullcalendar.io/docs/background-events-demo -->	
	<script src="vistas/js/plugins/fullcalendar.min.js"></script>

	<!-- Morris.js charts -->
	<!-- https://morrisjs.github.io/morris.js/ -->
	<script src="vistas/js/plugins/raphael-min.js"></script>
	<script src="vistas/js/plugins/morris.min.js"></script>	
	
	<!-- date-range-picker -->
	<script src="https://adminlte.io/themes/v3/plugins/daterangepicker/daterangepicker.js"></script>
	
	<!-- ChartJS -->
	<script src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>

	<style>
		
	.fc-today{
		background:rgba(255,255,255,0) !important;
	}
	.fonticons{
		font-family: 'FontAwesome';
	}

	#my-qr-reader {
		padding: 20px !important;
		border: 1.5px solid #b2b2b2 !important;
		border-radius: 8px;
	}

	#my-qr-reader img[alt="Info icon"] {
		display: none;
	}

	#my-qr-reader img[alt="Camera based scan"] {
		width: 100px !important;
		height: 100px !important;
	}

	#my-qr-reader button {
		padding: 10px 20px;
		border: 1px solid #b2b2b2;
		outline: none;
		border-radius: 0.25em;
		color: white;
		font-size: 15px;
		cursor: pointer;
		margin-top: 15px;
		margin-bottom: 10px;
		background-color: #008000ad;
		transition: 0.3s background-color;
	}

	#my-qr-reader button:hover {
		background-color: #008000;
	}

	#html5-qrcode-anchor-scan-type-change {
		text-decoration: none !important;
		color: #1d9bf0;
	}	

	.card-primary.card-outline-tabs>.card-header a.active, .card-primary.card-outline-tabs>.card-header a.active:hover {
		border-top: 3px solid #007bff;
	}

	.card-primary.card-outline {
		border-top: 0;
	}

	</style>	

</head>

<?php if (!isset($_SESSION["validarSesionBackend"])): 

	include "paginas/login.php";

?>

<?php else: ?>

<body class="hold-transition sidebar-mini sidebar-collapse">

	<div class="wrapper">

		<?php 

		include "paginas/modulos/header.php";

		include "paginas/modulos/menu.php";

		/*=============================================
		Navagación de páginas
		=============================================*/
		
		if(isset($_GET["pagina"])){

			if($_GET["pagina"] == "inicio" ||
			   $_GET["pagina"] == "inicio-v2" ||
			   $_GET["pagina"] == "administradores" ||
			   $_GET["pagina"] == "banner" ||
			//    $_GET["pagina"] == "planes" ||
			   $_GET["pagina"] == "categorias" ||
			   $_GET["pagina"] == "servicios" ||
			   $_GET["pagina"] == "reservas" ||
			   $_GET["pagina"] == "verificar-reserva" ||
			   $_GET["pagina"] == "testimonios" ||
			   $_GET["pagina"] == "usuarios" ||
			//    $_GET["pagina"] == "recorrido" ||
			//    $_GET["pagina"] == "restaurante" ||
			   $_GET["pagina"] == "galeria" ||
			   $_GET["pagina"] == "salir"){

				include "paginas/".$_GET["pagina"].".php";

			}else{

				include "paginas/error404.php";

			}


		}else{

			include "paginas/inicio.php";

		}

		include "paginas/modulos/footer.php";


		?>


	</div>

	<input type="hidden" value="<?php echo $ruta; ?>" id="urlPrincipal">
	<input type="hidden" value="<?php echo $rutaBackend; ?>" id="urlServidor">

	<script src="https://unpkg.com/html5-qrcode"></script>
	<script src="vistas/js/administradores.js"></script>
	<script src="vistas/js/jqueryNumber.min.js"></script>
	<script src="vistas/js/banner.js"></script>
	<script src="vistas/js/planes.js"></script>
	<script src="vistas/js/categorias.js"></script>
	<script src="vistas/js/habitaciones.js"></script>
	<script src="vistas/js/reservas.js"></script>
	<script src="vistas/js/testimonios.js"></script>
	<script src="vistas/js/usuarios.js"></script>
	<script src="vistas/js/recorrido.js"></script>
	<script src="vistas/js/restaurante.js"></script>
	<script src="vistas/js/icons.js"></script>
	
</body>

<?php endif ?>

</html>