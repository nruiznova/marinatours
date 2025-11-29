<!--=====================================
FOOTER
======================================-->

<div style=" background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
	url('images/isla-palma/IMG-20250203-WA0037.jpg');
	background-size: cover;
	background-position: center;" class="noprint">

	<div class="container">

		<footer class="pt-5">
			<div class="row">


				<div class="col-12">

					<div class="d-lg-flex justify-content-around text-center">

						<h2>+ 57 304 375 27 59</h2> 
						<h2>HEAVEN TOURS CARTAGENA SAS</h2>
						<h2>Cartagena, Colombia</h2>                    

					</div>                                                

				</div>
								
			</div>

			<hr style="border: 1px solid #fff;">

			<div class="row pt-5 pb-5">

				<?php if(!isset($_SESSION["validarSesion"])): ?>

				<div class="col-md-4 text-center">
					<h5>Accesos rápidos</h5>
					<ul class="nav flex-column">
					<li class="nav-item mb-2"><a href="<?php  echo $ruta; ?>" class="nav-link p-0 text-light">Inicio</a></li>
					<li class="nav-item mb-2"><a href="<?php echo $ruta.'pasadias'; ?>" class="nav-link p-0 text-light">Pasadías</a></li>
					<li class="nav-item mb-2"><a href="<?php echo $ruta.'transporte'; ?>" class="nav-link p-0 text-light">Transporte</a></li>					
					<li class="nav-item mb-2"><a href="<?php echo $ruta.'galeria'; ?>" class="nav-link p-0 text-light">Galería</a></li>
					<li class="nav-item mb-2"><a href="<?php echo $ruta.'comentarios'; ?>" class="nav-link p-0 text-light">Contáctenos</a></li>
					<li class="nav-item mb-2"><a href="<?php echo $ruta.'contactenos'; ?>" class="nav-link p-0 text-light">Comentarios</a></li>
					</ul>
				</div>

				<?php endif; ?>
			
				<div class="col-md-4 text-center">
					<h5>Redes sociales</h5>
					<ul class="nav flex-column">
					<li class="nav-item mb-2"><a target="_blank" href="https://www.instagram.com/marinatour.cartagena?igsh=MzdiY2RuNDNseTR6&utm_source=qr" class="nav-link p-0 text-light">Instagram</a></li>
					<li class="nav-item mb-2"><a target="_blank" href="https://www.facebook.com/share/1Sajr8rEJH/?mibextid=wwXIfr" class="nav-link p-0 text-light">Facebook</a></li>
					<li class="nav-item mb-2"><a target="_blank" href="https://www.tiktok.com/@marinatourcartagena?_t=ZS-8wb7ojHjES8&_r=1" class="nav-link p-0 text-light">Tiktok</a></li>
					<!-- <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">FAQs</a></li>
					<li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">About</a></li> -->
					</ul>
				</div>

				<div class="col-md-4">
				    
				    <div class="text-center">
						<img src="images/pse-logo.webp" width="60%" style="border-radius: 10px;">
					</div>

					<div class="text-center mt-5">
						<img src="images/mercadopago.png" width="60%" style="border-radius: 10px;">
					</div>
					
					<div class="text-center mt-5">
						<img src="images/logo_isla_palma.png" width="40%" style="border-radius: 10px;">
					</div>

				</div>                                   

			</div>
		
			<div class="d-flex justify-content-center border-top pt-3">
			<p>&copy; 2021 Company, Inc. All rights reserved.</p>                
			</div>
		</footer>

	</div>

</div>
	
