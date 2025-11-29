<?php

$categorias = ControladorCategorias::ctrMostrarCategorias();

if(isset($_SESSION["validarSesion"])){

	if($_SESSION["validarSesion"] == "ok"){

		$item = "id_u";
		$valor = $_SESSION["id"];

		$usuario = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

	}

}

?>

<nav class="site-header py-1 bg-secondary-color noprint" style="border-bottom: 2px solid #d6bd8d">
	<div class="container d-flex flex-column flex-md-row justify-content-between navbar-top">        
		<a class="py-2" href="#"><i class="fas fa-mobile-screen-button"></i> + 57 304 375 27 59</a>
		
		<!-- selector de idiomas -->
		<div class="gtranslate_wrapper"></div>

	</div>
</nav>

<header class="blog-header py-3 bg-main-color noprint">
	<div class="container">
		<div class="row">   
			<div class="col-sm-12 col-md-4 d-flex align-items-end justify-content-center text-light" style="padding: 20px">
				<h2 style="margin-bottom: 0;">cartagena</h2>
			</div>             
			<div class="col-sm-12 col-md-4 text-center" style="padding-bottom: 30px">
				<?php if(!isset($_SESSION["validarSesion"])): ?>
					<a class="blog-header-logo text-dark" href="<?php  echo $ruta; ?>">
						<img src="images/logo.png" class="" width="50%">
					</a>
				<?php else: ?>
					<a class="blog-header-logo text-dark" href="<?php  echo $ruta; ?>reservas">
						<img src="images/logo.png" class="" width="50%">
					</a>
				<?php endif; ?>
			</div>
			<div class="col-sm-12 col-md-4 d-flex align-items-end justify-content-center text-light" style="padding: 20px">
				<img src="<?php  echo $ruta; ?>vistas/images/logo_isla_palma.png" width="30%">
			</div>
		</div>
	</div>
</header>

<?php if(!isset($_SESSION["validarSesion"])): ?>

<nav class="navbar navbar-expand-md fixed-top d-md-none d-sm-block noprint" style="background-color: #fff;">
	<a class="navbar-brand text-dark noprint" href="#"></a>
	<button class="navbar-toggler noprint" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon">
			<i class="fas fa-navicon" style="color:#000; font-size:28px;"></i>
		</span>
	</button>
	<div class="collapse navbar-collapse noprint" id="navbarCollapse" style="background-color: #fff;">
		<ul class="navbar-nav mr-auto pl-3 pt-3">
		<li class="nav-item p-3 active">
			<a class="nav-link text-dark" href="<?php  echo $ruta; ?>">INICIO</a>
		</li>
		<li class="nav-item p-3">
			<a class="nav-link text-dark" href="<?php echo $ruta.'pasadias'; ?>">PASADÍAS</a>
		</li> 
		<li class="nav-item p-3">
			<a class="nav-link text-dark" href="<?php echo $ruta.'transporte'; ?>">TRANSPORTE</a>
		</li> 
		<li class="nav-item p-3">
			<a class="nav-link text-dark" href="<?php echo $ruta.'galeria'; ?>">GALERíA</a>
		</li>
		<li class="nav-item p-3">
			<a class="nav-link text-dark" href="<?php echo $ruta.'comentarios'; ?>">COMENTARIOS</a>
		</li> 
		<li class="nav-item p-3">
			<a class="nav-link text-dark" href="<?php echo $ruta.'contactenos'; ?>">CONTÁCTANOS</a>
		</li> 		 		           
	</div>
</nav>

<!-- <div class="container"> -->

<div class="nav-scroller py-1 bg-secondary-color d-md-block d-none noprint">

	<div class="container header-links-container noprint">

		<nav class="nav d-flex justify-content-between">
			<a class="p-2 text-light" href="<?php  echo $ruta; ?>">INICIO</a>			
			<a class="p-2 text-light" href="<?php echo $ruta.'pasadias'; ?>">PASADÍAS</a>
			<a class="p-2 text-light" href="<?php echo $ruta.'transporte'; ?>">TRANSPORTE</a>			
			<a class="p-2 text-light" href="<?php echo $ruta.'galeria'; ?>">GALERÍA</a>			
			<a class="p-2 text-light" href="<?php echo $ruta.'comentarios'; ?>">COMENTARIOS</a>   
			<a class="p-2 text-light" href="<?php echo $ruta.'contactenos'; ?>">CONTÁCTANOS</a>             
		</nav>

	</div>    

</div>

<?php endif; ?>
