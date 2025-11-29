<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// $item = "id_u";
// $valor = $_SESSION["id"];

// $usuario = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
// $reservas = ControladorReservas::ctrMostrarReservasUsuario($valor);

// $hoy = date("Y-m-d");
// $noVencidas = 0;
// $vencidas = 0;

// foreach ($reservas as $key => $value) {
	
// 	if($hoy >= $value["fecha_ingreso"]){

// 		++$vencidas;		
	
// 	}else{

// 		++$noVencidas;

// 	}

// }
if (isset($_COOKIE["firstName"])){ 
	
	$nombre = $_COOKIE["firstName"]; 

// 	MercadoPago\SDK::setAccessToken("APP_USR-1198270120630556-051516-34b830bb27d6a5120df88c6dabd7a187-1673855193");

// 	$preference = new MercadoPago\Preference();

// 	// Crear un ítem (producto o servicio)
// 	$item = new MercadoPago\Item();
// 	$item->title = $_COOKIE["infoHabitacion"];
// 	$item->quantity = 1;
// 	$item->unit_price = $_COOKIE["pagoActual"];  // Precio del producto (en tu moneda)

// 	$preference->items = array($item);

// 	// Configura las URLs de retorno
// 	// $preference->back_urls = array(
// 	// 	"success" => "https://www.tusitio.com/success",   // URL de éxito
// 	// 	"failure" => "https://www.tusitio.com/failure",   // URL de error
// 	// 	"pending" => "https://www.tusitio.com/pending"    // URL de pago pendiente
// 	// );

// 	// Configura el retorno automático a la URL de éxito si el pago es aprobado
// 	// $preference->auto_return = "approved";

// 	// Guarda la preferencia
// 	$preference->save();

// 	$preferenceId = $preference->id;

}else{

	if(isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok"){ 

		$nombre = $_SESSION["nombre"];
       
	}

}
?>

<!--=====================================
BLOQUE DER
======================================-->

<!--<input type="hidden" id="preferenceId" value="<?php echo $preferenceId; ?>"> -->
<head>
    <script>
        function mostrarMetodo() {
            const seleccion = document.getElementById('metodo_pago').value;
            const divs = document.querySelectorAll('.metodo-div');
            divs.forEach(d => d.style.display = 'none'); // ocultar todos
            if (seleccion) {
                document.getElementById(seleccion).style.display = 'block'; // mostrar el seleccionado
            }
        }
        window.addEventListener('DOMContentLoaded', () => {
            mostrarMetodo(); // para que se muestre si viene preseleccionado
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userType = document.getElementById('user_type');
            const identificationType = document.getElementById('identification_type');

            // Guardar todas las opciones originales
            const allOptions = Array.from(identificationType.options);

            function actualizarOpciones() {
                const tipo = userType.value;

                // Limpiar opciones actuales
                identificationType.innerHTML = '';

                if (tipo === 'company') {
                    // Mostrar solo NIT
                    const nitOption = allOptions.find(opt => opt.value === 'NIT');
                    const empty = allOptions.find(opt => opt.value === '');
                    identificationType.appendChild(empty);
                    identificationType.appendChild(nitOption);
                } else if (tipo === 'person') {
                    // Mostrar todas las opciones excepto NIT
                    allOptions.forEach(opt => {
                        if (opt.value !== 'NIT') { // opcional: mantener el placeholder
                            identificationType.appendChild(opt);
                        }
                    });
                    // Agregar placeholder
                    const placeholder = allOptions.find(opt => opt.value === '');
                    identificationType.insertBefore(placeholder, identificationType.firstChild);
                } else {
                    // Si no se selecciona nada, mostrar solo placeholder
                    const placeholder = allOptions.find(opt => opt.value === '');
                    identificationType.appendChild(placeholder);
                }

                // Reiniciar valor
                identificationType.value = '';
            }

            // Ejecutar al cargar
            actualizarOpciones();

            // Ejecutar al cambiar
            userType.addEventListener('change', actualizarOpciones);
        });
        </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit(token) {
            document.getElementById("formPSE").submit();
        }
    </script>
</head>

<div class="container" id="container-info-perfil">

	<div class="row">

		<div class="col-12 colDerPerfil">

			<div class="row">

				<div class="col-12 d-none d-lg-block">					

					<input type="hidden" id="rutaOculta" value="<?php echo $ruta;  ?>">

					<?php if(isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok"):  ?>

					<?php else: ?>

					<div class="button book_button trans_200"><a href="<?php echo $ruta ?>">Regresar a la web<span></span><span></span><span></span></a></div>

					<?php endif; ?>

					<hr>
					
					<h4 class="mt-4">Hola, <?php echo $nombre; ?>					

					<?php if (!isset($_COOKIE["codigoReserva"])): ?>

						, no tienes reservas pendientes por pagar

					<?php endif ?>

					</h4>

				</div>

				<!--=====================================
				MERCADO PAGO
				======================================-->					

				<div class="col-12">

					<?php if (isset($_COOKIE["codigoReserva"])): ?>

					
					<?php

						$validarPagoReserva = true;

						$hoy = date("Y-m-d");						

					?>

					<?php if ($validarPagoReserva): ?>
												
						<div class="card">

							<div class="card-header noprint">
								
								<h4>Tienes una reserva pendiente por pagar:</h4> 

							</div>
							
							<div class="card-body">								

								<ul class="list-group mb-3">
									<!-- <li class="list-group-item d-flex justify-content-center lh-condensed">
										<img id='barcode' src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo $_COOKIE["codigoReserva"]; ?>&amp;size=150x150" alt="" title="HELLO" width="150" height="150" />
									</li>									 -->
									<li class="list-group-item d-flex justify-content-between lh-condensed">
										<div>
											<h6 class="my-0">Nombre del servicio</h6>
											<small class="text-muted text-uppercase"><?php echo $_COOKIE["infoHabitacion"]; ?></small>
										</div>
										<span class="text-muted">
											<img width="50px" src="<?php echo $_COOKIE["imgHabitacion"]; ?>">
										</span>
									</li>
									<li class="list-group-item d-flex justify-content-between lh-condensed">
									<div> 
										<h6 class="my-0">Fecha de la reserva</h6>
										<small class="text-muted"><?php echo $_COOKIE["fechaIngreso"]; ?></small>
									</div>
									<span class="text-muted"></span>
									</li>												
									<li class="list-group-item d-flex justify-content-between lh-condensed containerCodigoReserva">
									<div>
										<h6 class="my-0">Código de la reserva</h6>
										<small class="text-muted codigoReserva"><?php echo $_COOKIE["codigoReserva"]; ?></small>
									</div>									
									</li>	
									<li class="list-group-item d-flex justify-content-between align-items-center lh-condensed">
									<div>
										<h6 class="my-0 mb-2" >Total de la reserva</h6>
										<!-- <small class="text-muted"></small> -->
									</div>
									<span style="" id="precioTotal">$<?php echo number_format($_COOKIE["pagoReserva"]); ?> COP</span>
									</li>					 
									<li class="list-group-item d-flex justify-content-between lh-condensed">
									<div>
                                        <h6 class="my-0">Total a pagar</h6>
                                    </div>
                                    
                                    <?php
                                        $pagoActual = isset($_COOKIE["pagoActual"]) ? floatval($_COOKIE["pagoActual"]) : 0;
                                        $pagoConRecargo = $pagoActual * 1.05;
                                    ?>
                                    
                                    <span class="text-right"><strong id="precioTotal">$<?php echo number_format($pagoActual); ?> COP</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i>Al pagar con tarjeta débito o crédito se aplica un recargo del 5%. Total: <strong>$<?php echo number_format($pagoConRecargo); ?> COP</strong></i>
                                    </small>
                                    </span>
									</li> 			            
								</ul>													
							</div>

							<div class="card-footer noprint">
                                <label for="metodo_pago">Elige un método de pago:</label>
                                <select id="metodo_pago" name="metodo_pago" onchange="mostrarMetodo()">
                                    <option value="">--Selecciona--</option>
                                    <option value="tarjeta" <?php if(!empty($metodo_pago) && $metodo_pago=='tarjeta') echo 'selected'; ?>>Tarjeta de crédito / débito</option>
                                    <option value="pse" <?php if(!empty($metodo_pago) && $metodo_pago=='pse') echo 'selected'; ?>>PSE</option>
                                </select>
								<!-- <figure>
										
									<img src="img/mercadopago.png" class="img-fluid w-50">
									
								</figure> -->
                                <div id="tarjeta" class="metodo-div">
								    <div id="paymentBrick_container" class="noprint" style="width: 100%"></div>
								    <div id="statusScreenBrick_container" style="width: 100%"></div>
                                </div>
                                
								<div id="pse" class="metodo-div">
                                    <form id="formPSE" class="needs-validation" method="POST">
                                        <input type="hidden" name="total_value" value="<?php echo $pagoActual; ?>">
                                        <input type="hidden" name="service_name" value="<?php echo $_COOKIE["infoHabitacion"]; ?>">
                                        <input type="hidden" name="codigo_reserva" value="<?php echo $_COOKIE["codigoReserva"]; ?>">

                                        <div class="p-3 mb-2" style="border: 1px solid rgba(0, 0, 0, .125);">
                                            <div class="row">				
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <h5>Débito bancario PSE<h5>
                                                        <img src="images/pse.png" width="150px" style="border-radius: 10px;">
                                                    </div>
                                                    <hr>
                                                </div>
                                               <div class="col-md-6 mb-3">
                                                    <label for="bank">Banco</label>
                                                    <select class="form-control" id="bank" name="bank" required>
                                                        <option value="">--Seleccione--</option>
                                                        <?php
                                                            require_once __DIR__ . "/../../../modelos/bank.modelo.php";
                                                            $bancos = ModeloBanksPSE::obtenerBancos();
                                                            if (!empty($bancos)) {
                                                                foreach ($bancos as $banco) {
                                                                    echo '<option value="' . htmlspecialchars($banco["financial_institute_code"]) . '">' . htmlspecialchars($banco["financial_institute_name"]) . '</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Este campo es obligatorio.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="name">Nombre del titular</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?php echo $_COOKIE['firstName'] . ' ' .  $_COOKIE['lastName']; ?>" required>
                                                    <div class="invalid-feedback">
                                                    Este campo es obligatorio.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="user_type">Tipo de persona</label>
                                                    <select class="form-control" id="user_type" name="user_type" required>
                                                        <option value="">--Seleccione--</option>
                                                        <option value="person">Natural</option>
                                                        <option value="company">Jurídica</option>							
                                                    </select>
                                                    <div class="invalid-feedback">
                                                    Este campo es obligatorio.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="identification_type">Tipo de documento</label>
                                                    <select class="form-control" id="identification_type" name="identification_type" required>
                                                        <option value="">--Seleccione--</option>
                                                        <option value="CedulaDeCiudadania">Cédula de ciudadanía</option>
                                                        <option value="NIT">Número de Identificación Tributaria (Empresas)</option>							
                                                        <option value="CedulaDeExtranjeria">Cédula de extranjería</option>							
                                                        <option value="TarjetaDeExtranjeria">Tarjeta de extranjería</option>							
                                                        <option value="TarjetaDeIdentidad">Tarjeta de identidad</option>							
                                                        <option value="Pasaporte">Pasaporte</option>							
                                                        <option value="RegistroCivilDeNacimiento">Registro civil de nacimiento</option>							
                                                        <option value="DocumentoDeIdentificacionExtranjero">Documento de identificación extranjero</option>							
                                                    </select>
                                                    <div class="invalid-feedback">
                                                    Este campo es obligatorio.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="identification_number">Número de documento</label>
                                                    <input type="text" class="form-control" id="identification_number" name="identification_number" placeholder="" value="<?php echo $_COOKIE['numero_identificacion']; ?>" required>
                                                    <div class="invalid-feedback">
                                                    Este campo es obligatorio.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="email">Correo electrónico</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="" value="<?php echo $_COOKIE['correo']; ?>" required>
                                                    <div class="invalid-feedback">
                                                    Este campo es obligatorio.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="phone">Número telefónico</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="" value="<?php echo $_COOKIE['celular']; ?>" required>
                                                    <div class="invalid-feedback">
                                                    Este campo es obligatorio.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="address">Dirección</label>
                                                    <input type="text" class="form-control" id="address" name="address" placeholder="" value="" required>
                                                    <div class="invalid-feedback">
                                                    Este campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="g-recaptcha" data-sitekey="6Lf-FtArAAAAAFgxXH0rQBQ39vA-n4dIXh6KhGAL"></div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-default btn-lg call-to-action-btn-gold">Pagar</button>
                                        </div>
                                        
                                    </form>
                                </div>
                                <div id="campos_adicionales" class="container mt-3 d-none">
                                    <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                        <label for="streetName" class="form-label">Calle</label>
                                        <input id="form-checkout__streetName" name="streetName" id="streetName" type="text" class="form-control" placeholder="Ej: Calle 5 / Carrera 8">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="streetNumber" class="form-label">Número</label>
                                        <input id="form-checkout__streetNumber" name="streetNumber" id="streetNumber" type="text" class="form-control" placeholder="# 4-44">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="neighborhood" class="form-label">Barrio</label>
                                        <input id="form-checkout__neighborhood" name="neighborhood" id="neighborhood" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">Ciudad</label>
                                        <input id="form-checkout__city" name="city" id="city" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-6 offset-lg-6 mb-3">
                                        <label for="zipCode" class="form-label">Codigo Postal</label>
                                        <input id="form-checkout__zipCode" name="zipCode" id="zipCode" type="text" class="form-control">
                                        </div>
                                        <!--<div class="col-md-6 mb-3">-->
                                        <!--  <label for="federalUnit" class="form-label">Unidad Federal</label>-->
                                        <!--  <input id="form-checkout__federalUnit" name="federalUnit" id="federalUnit" type="text" class="form-control">-->
                                        <!--</div>-->
                                        <div class="col-md-6 mb-3">
                                        <label for="phoneAreaCode" class="form-label">Código de área</label>
                                        <input id="form-checkout__phoneAreaCode" name="phoneAreaCode" id="phoneAreaCode" type="text" class="form-control" placeholder="Ej: + 57">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="phoneNumber" class="form-label">Teléfono</label>
                                        <input id="form-checkout__phoneNumber" name="phoneNumber" id="phoneNumber" type="text" class="form-control">
                                        </div>
                                    </div>
                                
                                    <input type="hidden" name="transactionAmount" id="transactionAmount" value="100">
                                    <input type="hidden" name="description" id="description" value="Nombre del Producto">
                                
                                    </form>
                                </div>
							</div>
						</div>

					<?php endif; ?>

					<?php endif; ?>

				</div>				

			</div>

		</div>
	
	</div>

</div>
	
<div id="loader" style="position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(255, 255, 255, 0.8);
  z-index: 9999;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  font-family: sans-serif;
  pointer-events: all;">

  <div class="spinner" style="
    border: 6px solid #ccc;
    border-top: 6px solid #333;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;"></div>

  <p style="margin-top: 15px; font-size: 18px; color: #444;">
    Procesando pago...
  </p>

</div>
<script src="js/PSE.js"></script>
<style>
  #loader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    display: none;         
    justify-content: center; 
    align-items: center;    
    flex-direction: column;
    font-family: sans-serif;
  }
  .metodo-div { 
    display: none; 
    margin-top: 10px;
    background:#FFF 
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>