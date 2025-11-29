<?php 

$infoReserva = $_GET["codigo"];

?>

<!-- <section class="content"> -->
<!-- <div class="container mt-5 mb-5 noprint"> -->
<div class="row">
        <div class="col-12">   
            <div class="container  mt-5 mb-5">     
                <!-- Main content -->
                <div class="invoice p-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h2 class="intro_title text-info">Información de la reserva</h2>
                            <!-- <p>La boleta de reserva se ha enviado al correo registrado del titular</p> -->
                        </div>
                        <!-- /.col -->
                    </div> 

                    <div class="row">

                    <div class="col-lg-6 p-2 mt-3">

                    <!-- <hr> -->
                        
                        <!-- <p class="lead">Amount Due 2/22/2014</p> -->

                        

                        <!-- <hr> -->

                        <div class="table-responsive mt-2">
                        <table class="table">
                            <!-- <tr> -->
                                <?php 
                                
                                    $reserva = ControladorReservas::ctrMostrarCodigoReserva($infoReserva);

                                    echo'
                                    
                                        <tr>

                                            <th>Servicio</th>
                                            <td>'.$reserva["descripcion_reserva"].'</td>

                                        </tr>

                                        <tr>

                                            <th>Titular de la reserva</th>
                                            <td>'.$reserva["firstName"]." ".$reserva["lastName"].'</td>

                                        </tr>

                                        <tr>

                                            <th>Tipo de documento</th>
                                            <td>'.$reserva["tipo_identificacion"].'</td>

                                        </tr>

                                        <tr>

                                            <th>Número de documento</th>
                                            <td>'.$reserva["numero_identificacion"].'</td>

                                        </tr>
                                    
                                    ';

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

                                            // echo '
                                        
                                            //     <tr>
                                                
                                            //         <th>Saldo pendiente</th>
                                            //         <td>$ '.number_format($saldo_p, 2).'</td>
                                                
                                            //     </tr>
                                            
                                            // ';

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
                                
                                ?>
                                <tr>

                                <!-- <th>Más información</th>
                                <td>Si necesitas mas información puedes contactarnos +57 3043752759</td> -->

                                </tr>
                            <!-- </tr> -->
                        </table>
                        </div>
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    </div>
                <!-- /.invoice -->
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
<!-- </div> -->
<!-- /.container-fluid -->
<!-- </section> -->
<!-- /.content -->