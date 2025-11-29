<?php 

if(isset($_GET["token"])){

	$reserva = ControladorReservas::ctrMostrarCodigoReserva($_GET["token"]);
	$cantidad_personas_arr = explode(" - ",$reserva["descripcion_reserva"]);

	$guests = json_decode($reserva["guests"], true);

	$adultos = 0;

	$niños = 0;

	$cantidad_personas_num = explode(" ",$cantidad_personas_arr[1]);

	foreach ($guests as $g => $gue) {

		if(isset($gue["tipo"])){

			if($gue["tipo"] == "adulto"){
				$adultos++;
			}else{
				$niños++;
			}

		}								

	}

	// taer datos reserva (precios)

	$valor = $reserva["id_habitacion"];

	$habitacion = ControladorHabitaciones::ctrMostrarHabitacion($reserva["id_habitacion"]);

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

}else{

	

}

?>

<div class="container pb-5 pt-5 mb-5" style="color: #333">

	<form class="needs-validation" novalidate>

		<input type="hidden" id="idReserva" value="<?php echo $reserva["id_reserva"]; ?>">
		<input type="hidden" id="codigoReserva" value="<?php echo $_GET["token"]; ?>">
		<input type="hidden" id="cantidadKids" value="<?php echo $niños; ?>">		

		<div class="bg-info p-3 text-white">
			<h5>Completar información de la reserva</h5>

			<p>Por favor complete la siguiente información sobre su reserva. Una vez completados los datos recibirá a su correo un documento PDF con la información de su reserva.</p>
		</div>

		<div class="p-3 mb-2" style="border: 1px solid rgba(0, 0, 0, .125);">

			<div class="row">

				<div class="col-12">
					<h5>Datos de las personas que tomarán el servicio</h5>
					<hr>
				</div>

				<!-- recorrer adultos -->

				<div class="col-12" id="containerAcompañantes">

					<!-- <h5>Adultos</h5> -->
																					
					<?php 

						$guests = json_decode($reserva["guests"], true);
						foreach ($guests as $i => $gue) {

							if($gue["tipo"] == "kid"){

								$type = '';

							}else{

								$type = '';

							}

							if($i == 0){

								$label1 = '<label>Nombre completo</label>';
								$label2 = '<label>Tipo identificación</label>';
								$label3 = '<label># identificación</label>';
								$label4 = '<label>Niño de 4-6 años</label>';
								$label5 = '<label>Nacionalidad</label>';
								$counter = '<label><b># <span class="d-sm-block d-md-none">'.($i + 1).'.</span></b></label>';

							}else{

								$label1 = '<label class="d-sm-block d-md-none">Nombre completo</label>';
								$label2 = '<label class="d-sm-block d-md-none">Tipo identificación</label>';
								$label3 = '<label class="d-sm-block d-md-none"># identificación</label>';
								$label4 = '<label class="d-sm-block d-md-none">Niño?</label>';
								$label5 = '<label class="d-sm-block d-md-none">Nacionalidad</label>';
								$counter = '<hr class="d-sm-block d-md-none"><label class="d-sm-block d-md-none"><b># '.($i + 1).'.</b></label>';

							}

							$nacionalidad = '';

							if($i == 0){

								$nacionalidad = 'nacionalidad';

							}
							
							echo'<div class="row">
							
								<div class="mt-2 col-sm-12 col-md-1">
									'.$counter.'
									<p class="d-none d-md-block">'.($i + 1).'.</p>
								</div>
								<div class="mt-2 col-sm-12 col-md">
									'.$label1.'
									<input type="text" class="form-control nameGuest" required>
									<div class="invalid-feedback">
										Este campo es obligatorio.
									</div>
								</div>
								<div class="mt-2 col-sm-12 col-md">
									'.$label2.'
									<select class="form-control typeDocGuest" required>
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
								<div class="mt-2 col-sm-12 col-md">
									'.$label3.'
									<input type="text" class="form-control docGuest" required>
									<div class="invalid-feedback">
										Este campo es obligatorio.
									</div>
								</div>
								<div class="mt-2 col-sm-12 col-md-2 text-center">
									'.$label4.'
									<div class="form-check-1 text-center">
										<input type="checkbox" class="form-check-input typeGuest" tipo="'.$gue["tipo"].'" '.$type.'>											
									</div>										
								</div>
								<div class="mt-2 col-sm-12 col-md">
									'.$label5.'
									<select class="form-control select2 '.$nacionalidad.' nacGuest" required>
										<option value="">-- Seleccione --</option>
										<option value="Afghanistan" data-tokens="Afghanistan">
											Afghanistan</option>
										<option value="Åland Islands" data-tokens="Åland Islands">
											Åland Islands</option>
										<option value="Albania" data-tokens="Albania">
											Albania</option>
										<option value="Algeria" data-tokens="Algeria">
											Algeria</option>
										<option value="American Samoa" data-tokens="American Samoa">
											American Samoa</option>
										<option value="Andorra" data-tokens="Andorra">
											Andorra</option>
										<option value="Angola" data-tokens="Angola">
											Angola</option>
										<option value="Anguilla" data-tokens="Anguilla">
											Anguilla</option>
										<option value="Antarctica" data-tokens="Antarctica">
											Antarctica</option>
										<option value="Antigua and Barbuda" data-tokens="Antigua and Barbuda">
											Antigua and Barbuda</option>
										<option value="Argentina" data-tokens="Argentina">
											Argentina</option>
										<option value="Armenia" data-tokens="Armenia">
											Armenia</option>
										<option value="Aruba" data-tokens="Aruba">
											Aruba</option>
										<option value="Australia" data-tokens="Australia">
											Australia</option>
										<option value="Austria" data-tokens="Austria">
											Austria</option>
										<option value="Azerbaijan" data-tokens="Azerbaijan">
											Azerbaijan</option>
										<option value="Bahamas" data-tokens="Bahamas">
											Bahamas</option>
										<option value="Bahrain" data-tokens="Bahrain">
											Bahrain</option>
										<option value="Bangladesh" data-tokens="Bangladesh">
											Bangladesh</option>
										<option value="Barbados" data-tokens="Barbados">
											Barbados</option>
										<option value="Belarus" data-tokens="Belarus">
											Belarus</option>
										<option value="Belgium" data-tokens="Belgium">
											Belgium</option>
										<option value="Belize" data-tokens="Belize">
											Belize</option>
										<option value="Benin" data-tokens="Benin">
											Benin</option>
										<option value="Bermuda" data-tokens="Bermuda">
											Bermuda</option>
										<option value="Bhutan" data-tokens="Bhutan">
											Bhutan</option>
										<option value="Bolivia" data-tokens="Bolivia">
											Bolivia</option>
										<option value="Bosnia and Herzegovina" data-tokens="Bosnia and Herzegovina">
											Bosnia and Herzegovina</option>
										<option value="Botswana" data-tokens="Botswana">
											Botswana</option>
										<option value="Bouvet Island" data-tokens="Bouvet Island">
											Bouvet Island</option>
										<option value="Brazil" data-tokens="Brazil">
											Brazil</option>
										<option value="British Indian Ocean Territory" data-tokens="British Indian Ocean Territory">
											British Indian Ocean Territory</option>
										<option value="Brunei Darussalam" data-tokens="Brunei Darussalam">
											Brunei Darussalam</option>
										<option value="Bulgaria" data-tokens="Bulgaria">
											Bulgaria</option>
										<option value="Burkina Faso" data-tokens="Burkina Faso">
											Burkina Faso</option>
										<option value="Burundi" data-tokens="Burundi">
											Burundi</option>
										<option value="Cambodia" data-tokens="Cambodia">
											Cambodia</option>
										<option value="Cameroon" data-tokens="Cameroon">
											Cameroon</option>
										<option value="Canada" data-tokens="Canada">
											Canada</option>
										<option value="Cape Verde" data-tokens="Cape Verde">
											Cape Verde</option>
										<option value="Cayman Islands" data-tokens="Cayman Islands">
											Cayman Islands</option>
										<option value="Central African Republic" data-tokens="Central African Republic">
											Central African Republic</option>
										<option value="Chad" data-tokens="Chad">
											Chad</option>
										<option value="Chile" data-tokens="Chile">
											Chile</option>
										<option value="China" data-tokens="China">
											China</option>
										<option value="Christmas Island" data-tokens="Christmas Island">
											Christmas Island</option>
										<option value="Cocos (Keeling) Islands" data-tokens="Cocos (Keeling) Islands">
											Cocos (Keeling) Islands</option>
										<option value="Colombia" data-tokens="Colombia">
											Colombia</option>
										<option value="Comoros" data-tokens="Comoros">
											Comoros</option>
										<option value="Congo" data-tokens="Congo">
											Congo</option>
										<option value="Congo, The Democratic Republic of The" data-tokens="Congo, The Democratic Republic of The">
											Congo, The Democratic Republic of The</option>
										<option value="Cook Islands" data-tokens="Cook Islands">
											Cook Islands</option>
										<option value="Costa Rica" data-tokens="Costa Rica">
											Costa Rica</option>
										<option value="Cote Divoire" data-tokens="Cote Divoire">
											Cote Divoire</option>
										<option value="Croatia" data-tokens="Croatia">
											Croatia</option>
										<option value="Cuba" data-tokens="Cuba">
											Cuba</option>
										<option value="Cyprus" data-tokens="Cyprus">
											Cyprus</option>
										<option value="Czech Republic" data-tokens="Czech Republic">
											Czech Republic</option>
										<option value="Denmark" data-tokens="Denmark">
											Denmark</option>
										<option value="Djibouti" data-tokens="Djibouti">
											Djibouti</option>
										<option value="Dominica" data-tokens="Dominica">
											Dominica</option>
										<option value="Dominican Republic" data-tokens="Dominican Republic">
											Dominican Republic</option>
										<option value="Ecuador" data-tokens="Ecuador">
											Ecuador</option>
										<option value="Egypt" data-tokens="Egypt">
											Egypt</option>
										<option value="El Salvador" data-tokens="El Salvador">
											El Salvador</option>
										<option value="Equatorial Guinea" data-tokens="Equatorial Guinea">
											Equatorial Guinea</option>
										<option value="Eritrea" data-tokens="Eritrea">
											Eritrea</option>
										<option value="Estonia" data-tokens="Estonia">
											Estonia</option>
										<option value="Ethiopia" data-tokens="Ethiopia">
											Ethiopia</option>
										<option value="Falkland Islands (Malvinas)" data-tokens="Falkland Islands (Malvinas)">
											Falkland Islands (Malvinas)</option>
										<option value="Faroe Islands" data-tokens="Faroe Islands">
											Faroe Islands</option>
										<option value="Fiji" data-tokens="Fiji">
											Fiji</option>
										<option value="Finland" data-tokens="Finland">
											Finland</option>
										<option value="France" data-tokens="France">
											France</option>
										<option value="French Guiana" data-tokens="French Guiana">
											French Guiana</option>
										<option value="French Polynesia" data-tokens="French Polynesia">
											French Polynesia</option>
										<option value="French Southern Territories" data-tokens="French Southern Territories">
											French Southern Territories</option>
										<option value="Gabon" data-tokens="Gabon">
											Gabon</option>
										<option value="Gambia" data-tokens="Gambia">
											Gambia</option>
										<option value="Georgia" data-tokens="Georgia">
											Georgia</option>
										<option value="Germany" data-tokens="Germany">
											Germany</option>
										<option value="Ghana" data-tokens="Ghana">
											Ghana</option>
										<option value="Gibraltar" data-tokens="Gibraltar">
											Gibraltar</option>
										<option value="Greece" data-tokens="Greece">
											Greece</option>
										<option value="Greenland" data-tokens="Greenland">
											Greenland</option>
										<option value="Grenada" data-tokens="Grenada">
											Grenada</option>
										<option value="Guadeloupe" data-tokens="Guadeloupe">
											Guadeloupe</option>
										<option value="Guam" data-tokens="Guam">
											Guam</option>
										<option value="Guatemala" data-tokens="Guatemala">
											Guatemala</option>
										<option value="Guernsey" data-tokens="Guernsey">
											Guernsey</option>
										<option value="Guinea" data-tokens="Guinea">
											Guinea</option>
										<option value="Guinea-bissau" data-tokens="Guinea-bissau">
											Guinea-bissau</option>
										<option value="Guyana" data-tokens="Guyana">
											Guyana</option>
										<option value="Haiti" data-tokens="Haiti">
											Haiti</option>
										<option value="Heard Island and Mcdonald Islands" data-tokens="Heard Island and Mcdonald Islands">
											Heard Island and Mcdonald Islands</option>
										<option value="Holy See (Vatican City State)" data-tokens="Holy See (Vatican City State)">
											Holy See (Vatican City State)</option>
										<option value="Honduras" data-tokens="Honduras">
											Honduras</option>
										<option value="Hong Kong" data-tokens="Hong Kong">
											Hong Kong</option>
										<option value="Hungary" data-tokens="Hungary">
											Hungary</option>
										<option value="Iceland" data-tokens="Iceland">
											Iceland</option>
										<option value="India" data-tokens="India">
											India</option>
										<option value="Indonesia" data-tokens="Indonesia">
											Indonesia</option>
										<option value="Iran, Islamic Republic of" data-tokens="Iran, Islamic Republic of">
											Iran, Islamic Republic of</option>
										<option value="Iraq" data-tokens="Iraq">
											Iraq</option>
										<option value="Ireland" data-tokens="Ireland">
											Ireland</option>
										<option value="Isle of Man" data-tokens="Isle of Man">
											Isle of Man</option>
										<option value="Israel" data-tokens="Israel">
											Israel</option>
										<option value="Italy" data-tokens="Italy">
											Italy</option>
										<option value="Jamaica" data-tokens="Jamaica">
											Jamaica</option>
										<option value="Japan" data-tokens="Japan">
											Japan</option>
										<option value="Jersey" data-tokens="Jersey">
											Jersey</option>
										<option value="Jordan" data-tokens="Jordan">
											Jordan</option>
										<option value="Kazakhstan" data-tokens="Kazakhstan">
											Kazakhstan</option>
										<option value="Kenya" data-tokens="Kenya">
											Kenya</option>
										<option value="Kiribati" data-tokens="Kiribati">
											Kiribati</option>
										<option value="Korea, Democratic Peoples Republic of" data-tokens="Korea, Democratic Peoples Republic of">
											Korea, Democratic Peoples Republic of</option>
										<option value="Korea, Republic of" data-tokens="Korea, Republic of">
											Korea, Republic of</option>
										<option value="Kuwait" data-tokens="Kuwait">
											Kuwait</option>
										<option value="Kyrgyzstan" data-tokens="Kyrgyzstan">
											Kyrgyzstan</option>
										<option value="Lao Peoples Democratic Republic" data-tokens="Lao Peoples Democratic Republic">
											Lao Peoples Democratic Republic</option>
										<option value="Latvia" data-tokens="Latvia">
											Latvia</option>
										<option value="Lebanon" data-tokens="Lebanon">
											Lebanon</option>
										<option value="Lesotho" data-tokens="Lesotho">
											Lesotho</option>
										<option value="Liberia" data-tokens="Liberia">
											Liberia</option>
										<option value="Libyan Arab Jamahiriya" data-tokens="Libyan Arab Jamahiriya">
											Libyan Arab Jamahiriya</option>
										<option value="Liechtenstein" data-tokens="Liechtenstein">
											Liechtenstein</option>
										<option value="Lithuania" data-tokens="Lithuania">
											Lithuania</option>
										<option value="Luxembourg" data-tokens="Luxembourg">
											Luxembourg</option>
										<option value="Macao" data-tokens="Macao">
											Macao</option>
										<option value="Macedonia, The Former Yugoslav Republic of" data-tokens="Macedonia, The Former Yugoslav Republic of">
											Macedonia, The Former Yugoslav Republic of</option>
										<option value="Madagascar" data-tokens="Madagascar">
											Madagascar</option>
										<option value="Malawi" data-tokens="Malawi">
											Malawi</option>
										<option value="Malaysia" data-tokens="Malaysia">
											Malaysia</option>
										<option value="Maldives" data-tokens="Maldives">
											Maldives</option>
										<option value="Mali" data-tokens="Mali">
											Mali</option>
										<option value="Malta" data-tokens="Malta">
											Malta</option>
										<option value="Marshall Islands" data-tokens="Marshall Islands">
											Marshall Islands</option>
										<option value="Martinique" data-tokens="Martinique">
											Martinique</option>
										<option value="Mauritania" data-tokens="Mauritania">
											Mauritania</option>
										<option value="Mauritius" data-tokens="Mauritius">
											Mauritius</option>
										<option value="Mayotte" data-tokens="Mayotte">
											Mayotte</option>
										<option value="Mexico" data-tokens="Mexico">
											Mexico</option>
										<option value="Micronesia, Federated States of" data-tokens="Micronesia, Federated States of">
											Micronesia, Federated States of</option>
										<option value="Moldova, Republic of" data-tokens="Moldova, Republic of">
											Moldova, Republic of</option>
										<option value="Monaco" data-tokens="Monaco">
											Monaco</option>
										<option value="Mongolia" data-tokens="Mongolia">
											Mongolia</option>
										<option value="Montenegro" data-tokens="Montenegro">
											Montenegro</option>
										<option value="Montserrat" data-tokens="Montserrat">
											Montserrat</option>
										<option value="Morocco" data-tokens="Morocco">
											Morocco</option>
										<option value="Mozambique" data-tokens="Mozambique">
											Mozambique</option>
										<option value="Myanmar" data-tokens="Myanmar">
											Myanmar</option>
										<option value="Namibia" data-tokens="Namibia">
											Namibia</option>
										<option value="Nauru" data-tokens="Nauru">
											Nauru</option>
										<option value="Nepal" data-tokens="Nepal">
											Nepal</option>
										<option value="Netherlands" data-tokens="Netherlands">
											Netherlands</option>
										<option value="Netherlands Antilles" data-tokens="Netherlands Antilles">
											Netherlands Antilles</option>
										<option value="New Caledonia" data-tokens="New Caledonia">
											New Caledonia</option>
										<option value="New Zealand" data-tokens="New Zealand">
											New Zealand</option>
										<option value="Nicaragua" data-tokens="Nicaragua">
											Nicaragua</option>
										<option value="Niger" data-tokens="Niger">
											Niger</option>
										<option value="Nigeria" data-tokens="Nigeria">
											Nigeria</option>
										<option value="Niue" data-tokens="Niue">
											Niue</option>
										<option value="Norfolk Island" data-tokens="Norfolk Island">
											Norfolk Island</option>
										<option value="Northern Mariana Islands" data-tokens="Northern Mariana Islands">
											Northern Mariana Islands</option>
										<option value="Norway" data-tokens="Norway">
											Norway</option>
										<option value="Oman" data-tokens="Oman">
											Oman</option>
										<option value="Pakistan" data-tokens="Pakistan">
											Pakistan</option>
										<option value="Palau" data-tokens="Palau">
											Palau</option>
										<option value="Palestinian Territory, Occupied" data-tokens="Palestinian Territory, Occupied">
											Palestinian Territory, Occupied</option>
										<option value="Panama" data-tokens="Panama">
											Panama</option>
										<option value="Papua New Guinea" data-tokens="Papua New Guinea">
											Papua New Guinea</option>
										<option value="Paraguay" data-tokens="Paraguay">
											Paraguay</option>
										<option value="Peru" data-tokens="Peru">
											Peru</option>
										<option value="Philippines" data-tokens="Philippines">
											Philippines</option>
										<option value="Pitcairn" data-tokens="Pitcairn">
											Pitcairn</option>
										<option value="Poland" data-tokens="Poland">
											Poland</option>
										<option value="Portugal" data-tokens="Portugal">
											Portugal</option>
										<option value="Puerto Rico" data-tokens="Puerto Rico">
											Puerto Rico</option>
										<option value="Qatar" data-tokens="Qatar">
											Qatar</option>
										<option value="Reunion" data-tokens="Reunion">
											Reunion</option>
										<option value="Romania" data-tokens="Romania">
											Romania</option>
										<option value="Russian Federation" data-tokens="Russian Federation">
											Russian Federation</option>
										<option value="Rwanda" data-tokens="Rwanda">
											Rwanda</option>
										<option value="Saint Helena" data-tokens="Saint Helena">
											Saint Helena</option>
										<option value="Saint Kitts and Nevis" data-tokens="Saint Kitts and Nevis">
											Saint Kitts and Nevis</option>
										<option value="Saint Lucia" data-tokens="Saint Lucia">
											Saint Lucia</option>
										<option value="Saint Pierre and Miquelon" data-tokens="Saint Pierre and Miquelon">
											Saint Pierre and Miquelon</option>
										<option value="Saint Vincent and The Grenadines" data-tokens="Saint Vincent and The Grenadines">
											Saint Vincent and The Grenadines</option>
										<option value="Samoa" data-tokens="Samoa">
											Samoa</option>
										<option value="San Marino" data-tokens="San Marino">
											San Marino</option>
										<option value="Sao Tome and Principe" data-tokens="Sao Tome and Principe">
											Sao Tome and Principe</option>
										<option value="Saudi Arabia" data-tokens="Saudi Arabia">
											Saudi Arabia</option>
										<option value="Senegal" data-tokens="Senegal">
											Senegal</option>
										<option value="Serbia" data-tokens="Serbia">
											Serbia</option>
										<option value="Seychelles" data-tokens="Seychelles">
											Seychelles</option>
										<option value="Sierra Leone" data-tokens="Sierra Leone">
											Sierra Leone</option>
										<option value="Singapore" data-tokens="Singapore">
											Singapore</option>
										<option value="Slovakia" data-tokens="Slovakia">
											Slovakia</option>
										<option value="Slovenia" data-tokens="Slovenia">
											Slovenia</option>
										<option value="Solomon Islands" data-tokens="Solomon Islands">
											Solomon Islands</option>
										<option value="Somalia" data-tokens="Somalia">
											Somalia</option>
										<option value="South Africa" data-tokens="South Africa">
											South Africa</option>
										<option value="South Georgia and The South Sandwich Islands" data-tokens="South Georgia and The South Sandwich Islands">
											South Georgia and The South Sandwich Islands</option>
										<option value="Spain" data-tokens="Spain">
											Spain</option>
										<option value="Sri Lanka" data-tokens="Sri Lanka">
											Sri Lanka</option>
										<option value="Sudan" data-tokens="Sudan">
											Sudan</option>
										<option value="Suriname" data-tokens="Suriname">
											Suriname</option>
										<option value="Svalbard and Jan Mayen" data-tokens="Svalbard and Jan Mayen">
											Svalbard and Jan Mayen</option>
										<option value="Swaziland" data-tokens="Swaziland">
											Swaziland</option>
										<option value="Sweden" data-tokens="Sweden">
											Sweden</option>
										<option value="Switzerland" data-tokens="Switzerland">
											Switzerland</option>
										<option value="Syrian Arab Republic" data-tokens="Syrian Arab Republic">
											Syrian Arab Republic</option>
										<option value="Taiwan" data-tokens="Taiwan">
											Taiwan</option>
										<option value="Tajikistan" data-tokens="Tajikistan">
											Tajikistan</option>
										<option value="Tanzania, United Republic of" data-tokens="Tanzania, United Republic of">
											Tanzania, United Republic of</option>
										<option value="Thailand" data-tokens="Thailand">
											Thailand</option>
										<option value="Timor-leste" data-tokens="Timor-leste">
											Timor-leste</option>
										<option value="Togo" data-tokens="Togo">
											Togo</option>
										<option value="Tokelau" data-tokens="Tokelau">
											Tokelau</option>
										<option value="Tonga" data-tokens="Tonga">
											Tonga</option>
										<option value="Trinidad and Tobago" data-tokens="Trinidad and Tobago">
											Trinidad and Tobago</option>
										<option value="Tunisia" data-tokens="Tunisia">
											Tunisia</option>
										<option value="Turkey" data-tokens="Turkey">
											Turkey</option>
										<option value="Turkmenistan" data-tokens="Turkmenistan">
											Turkmenistan</option>
										<option value="Turks and Caicos Islands" data-tokens="Turks and Caicos Islands">
											Turks and Caicos Islands</option>
										<option value="Tuvalu" data-tokens="Tuvalu">
											Tuvalu</option>
										<option value="Uganda" data-tokens="Uganda">
											Uganda</option>
										<option value="Ukraine" data-tokens="Ukraine">
											Ukraine</option>
										<option value="United Arab Emirates" data-tokens="United Arab Emirates">
											United Arab Emirates</option>
										<option value="United Kingdom" data-tokens="United Kingdom">
											United Kingdom</option>
										<option value="United States" data-tokens="United States">
											United States</option>
										<option value="United States Minor Outlying Islands" data-tokens="United States Minor Outlying Islands">
											United States Minor Outlying Islands</option>
										<option value="Uruguay" data-tokens="Uruguay">
											Uruguay</option>
										<option value="Uzbekistan" data-tokens="Uzbekistan">
											Uzbekistan</option>
										<option value="Vanuatu" data-tokens="Vanuatu">
											Vanuatu</option>
										<option value="Venezuela" data-tokens="Venezuela">
											Venezuela</option>
										<option value="Viet Nam" data-tokens="Viet Nam">
											Viet Nam</option>
										<option value="Virgin Islands, British" data-tokens="Virgin Islands, British">
											Virgin Islands, British</option>
										<option value="Virgin Islands, U.S." data-tokens="Virgin Islands, U.S.">
											Virgin Islands, U.S.</option>
										<option value="Wallis and Futuna" data-tokens="Wallis and Futuna">
											Wallis and Futuna</option>
										<option value="Western Sahara" data-tokens="Western Sahara">
											Western Sahara</option>
										<option value="Yemen" data-tokens="Yemen">
											Yemen</option>
										<option value="Zambia" data-tokens="Zambia">
											Zambia</option>
										<option value="Zimbabwe" data-tokens="Zimbabwe">
											Zimbabwe</option>
									</select>
									<div class="invalid-feedback">
										Este campo es obligatorio.
									</div>
								</div>

							</div>';

						}

					?>						
					
				</div>

				<div class="col-12">
					<hr>
					<small class="text-muted">** El precio para los <b>niños</b> con el rango de edad de 4-6 años es de <b>$<?php echo number_format($precioKids); ?> COP</b></small>
					<br><small class="text-muted">** Mujeres con embarazo superior a 5 meses no puden tomar este servicio</b></small>
				</div>

				<input type="hidden" class="acompañantesReserva">

				<!-- recorrer niños -->

			</div>

		</div>

		<button type="button" class="btn call-to-action-btn-gold btn-lg float-right" id="completarDatosReserva">Enviar</button> 

	</form>

</div>

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