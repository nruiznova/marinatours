<div class="content-wrapper">

    <section class="content-header">

        <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">

            <h1>Verificar reserva</h1>

            </div>

            <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

                <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Verificar reserva</li>

            </ol>

            </div>

        </div>

        </div><!-- /.container-fluid -->

    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="callout callout-info">                
                
                <div class="row">
                    
                    <div class="col-lg">
                        
                        <button class="btn btn-lg btn-secondary" id="searchQrBtn"> Escanear QR <hr><i class="fas fa-qrcode fa-2x"></i></button>                            

                    </div>

                    <div class="col-lg">
                                                    
                        <button class="btn btn-lg btn-secondary" id="searchManualBtn"> Código reserva <hr><i class="fas fa-search fa-2x"></i></button>

                    </div>

                    <div class="col-lg-9"></div>

                    <div class="col-lg-3" id="searchManual" style="display: none">
                      <hr>
                      <div class="input-group mb-3">                      
                        <input type="text" class="form-control" id="valueSearchBooking">
                        <div class="input-group-append">
                          <span class="input-group-text btn btn-info searchBookingBtn" table="1"><i class="fas fa-search"></i></span>
                        </div>
                      </div>
                    </div> 

                    <div class="col-lg-3 pt-2" id="searchQr" style="display: none">
                        <div id="my-qr-reader"></div>
                    </div>
                    
                </div>

            </div>

            <!-- content -->

            <?php 
        
                if(isset($_GET["reserva"])):

                    $reservaInfo = ControladorReservas::ctrMostrarReservas("codigo_reserva", $_GET["reserva"]);
                    
                    // var_dump($reservaInfo[0]);

                    if($reservaInfo[0]):   
                        
                    // foreach ($reservaInfo[0] as $key => $reserva):

                        $pagos =  ControladorReservas::ctrMostrarPagos("id_reserva", $reservaInfo[0]["id_reserva"]);	

                        if($reservaInfo[0]["abono"] == "total"){

                            $saldo = "Pagada";

                        }else{

                            $pagado = 0;			
                        
                            foreach ($pagos as $row => $item) {
                                
                                $pagado += $item["monto"];

                            }

                            $saldo_p = $reservaInfo[0]["pago_reserva"] - $pagado;

                            $saldo = number_format($saldo_p);

                        }								
                        
                        $guests = json_decode($reservaInfo[0]["guests"], true);

                        $adultos = 0;

                        $niños = 0;

                        foreach ($guests as $g => $gue) {
                            
                            if(isset($gue["tipo"])){

                              if($gue["tipo"] == "adulto"){
                                $adultos++;
                              }else{
                                  $niños++;
                              }

                            }

                        }
        
            ?>            

            <div class="row">                

                <div class="col-12">            

                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">                        

                        <div class="col-12 text-uppercase d-none">
                            <h4>
                            <!-- <i class="fas fa-globe"></i> AdminLTE, Inc. -->
                            <small class="float-right"><b>Fecha: </b> <?php echo date("d-m-Y", strtotime($reservaInfo[0]["fecha_ingreso"])) ?></small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col mb-2 text-uppercase">                                                                  
                        <p class="">

                            <b>Estado:</b>

                            <?php 

                              if($reservaInfo[0]["fecha_ingreso"] == null && $reservaInfo[0]["estado"] == 3){

                                echo'<span class="btn btn-xs text-bold btn-danger">Devolución</span>';

                              }else if($reservaInfo[0]["fecha_ingreso"] < date("Y-m-d")){

                                echo'<span class="btn btn-xs text-bold btn-warning">Marcada automaticamente como anulada por fecha</span>';

                              }else{

                                if($reservaInfo[0]["estado"] == 0){

                                  echo'<span class="btn btn-xs text-bold btn-info">No se ha marcado ningún estado</span>';

                                }else if($reservaInfo[0]["estado"] == 1){

                                  echo'<span class="btn btn-xs text-bold btn-success">Presente</span>';

                                }else if($reservaInfo[0]["estado"] == 2){

                                  echo'<span class="btn btn-xs text-bold btn-warning">Anulada</span>';

                                }

                              }
                            
                            ?>
                            <br>

                            <b>Saldo pendiente:</b> $ <?php echo $saldo; ?><br>
                            <b>Fecha</b> 
                            <?php 
                            
                              if($reservaInfo[0]["fecha_ingreso"] != null){ 

                                echo date("d-m-Y", strtotime($reservaInfo[0]["fecha_ingreso"])); 

                              }else{ 

                                echo date("d-m-Y", strtotime($reservaInfo[0]["fecha_salida"]));  

                              } 
                            ?>
                            <br>
                            <?php echo $reservaInfo[0]["descripcion_reserva"] ?><br>
                            <b>Adultos: </b> <?php echo $adultos ?><br>
                            <b>Niños: </b> <?php echo $niños ?><br>                          
                            <b>Titular: </b> <?php echo $reservaInfo[0]["firstName"]." ".$reservaInfo[0]["lastName"] ?><br>
                            <b>Documento:</b><?php echo $reservaInfo[0]["tipo_identificacion"]." ".$reservaInfo[0]["numero_identificacion"] ?><br>
                            
                            <b>Vendedor: </b> <?php if($reservaInfo[0]["id_usuario"] == "undefined"){ echo 'Público en general'; }else{ echo $reservaInfo[0]["id_usuario"]; } ?><br>
                            <!-- <b>Medio de pago: </b> <?php // echo $reservaInfo[0]["abono"] ?><br> -->
                        </p>
                    </div>                               
                    <!-- /.col -->
                    </div>
                    <!-- /.row --> 

                    <!-- Table row -->
                    <div class="row">
                    <div class="col-12 table-responsive text-uppercase">
                        <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nombre completo</th>
                            <!-- <th>Tipo de documento</th> -->
                            <th>Documento</th>
                            <th>Tipo de usuario</th>
                            <th>Asiento</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php 
                            
                                foreach ($guests as $g => $gue) {

                                  if(isset($gue["tipo"])){

                                    $tipo = '';

                                    if($gue["tipo"] == 'kid'){
                                        $tipo = "Niño";
                                    }else{
                                        $tipo = "Adulto";
                                    }
                                    
                                    $asiento = '';
                                    
                                    if(isset($gue["asiento"])){
                                            
                                        $asiento = $gue["asiento"];
                                        
                                    }

                                    $nombre = '';

                                    if(isset($gue["nombre"])){

                                      $nombre = $gue["nombre"];

                                    }

                                    $tipo_documento = '';

                                    if(isset($gue["tipo_documento"])){

                                      $tipo_documento = $gue["tipo_documento"];

                                    }

                                    $documento = '';

                                    if(isset($gue["documento"])){

                                      $documento = $gue["documento"];

                                    }

                                    echo'<tr>
                                    
                                        <td>'.$nombre.'</td>                                        
                                        <td>'.$tipo_documento.' '.$documento.'</td>
                                        <td>'.$tipo.'</td>
                                        <td>'.$asiento.'</td>

                                    </tr>';

                                  }

                                }
                            
                            ?>

                        </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                    <!-- accepted payments column -->                
                    <!-- /.col -->
                    <div class="col-lg-6 offset-lg-6">
                        
                        <!-- <p class="lead">Amount Due 2/22/2014</p> -->

                        <div class="table-responsive">
                        <table class="table d-none">
                            <!-- <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>$250.30</td>
                            </tr>
                            <tr>
                            <th>Tax (9.3%)</th>
                            <td>$10.34</td>
                            </tr>
                            <tr>
                            <th>Shipping:</th>
                            <td>$5.80</td>
                            </tr> -->
                            <tr>
                            <th>Saldo a pagar:</th>
                            <td>$ <?php echo $saldo; ?></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <!-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default">
                                <i class="fas fa-print"></i> 
                                Print
                            </a> -->
                            <hr>
                            <div class="btn-group-vertical float-right">
                                <?php if($reservaInfo[0]["estado"] == 0): ?>
                                    <button type="button" class="btn btn-sm btn-outline-success" id="changeStatus" status="1" idReserva="<?php echo $reservaInfo[0]["id_reserva"]; ?>">
                                        <i class="fas fa-check-square fa-2x"></i> 
                                        <br>MARCAR COMO PRESENTE
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info btnPagoReserva" data-toggle='modal' data-target='#registrarPago' idReserva="<?php echo $reservaInfo[0]["id_reserva"]; ?>" idHabitacion="<?php echo $reservaInfo[0]["id_habitacion"]; ?>" style="margin-right: 5px;">
                                        <i class="fas fa-dollar-sign fa-2x"></i> 
                                        <br>REGISTRAR PAGO
                                    </button>
                                <?php elseif($reservaInfo[0]["estado"] == 1): ?>
                                    <button type="button" class="btn btn-sm btn-outline-info" id="changeStatus" status="0" idReserva="<?php echo $reservaInfo[0]["id_reserva"]; ?>">
                                        <i class="fas fa-minus-square fa-2x"></i> 
                                        <br>DESMARCAR COMO PRESENTE
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info btnPagoReserva" data-toggle='modal' data-target='#registrarPago' idReserva="<?php echo $reservaInfo[0]["id_reserva"]; ?>" idHabitacion="<?php echo $reservaInfo[0]["id_habitacion"]; ?>" style="margin-right: 5px;">
                                        <i class="fas fa-dollar-sign fa-2x"></i> 
                                        <br>REGISTRAR PAGO
                                    </button>
                                <?php elseif($reservaInfo[0]["estado"] == 2): ?>
                                    <button type="button" class="btn btn-sm btn-outline-success" id="changeStatus" status="1" idReserva="<?php echo $reservaInfo[0]["id_reserva"]; ?>">
                                        <i class="fas fa-check-square fa-2x"></i> 
                                        <br>MARCAR COMO PRESENTE
                                    </button>                                    
                                <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->

            <?php else: ?>

                <div class="card">

                    <!-- validar estado de la reserva -->

                    <!-- <div class="card-header">
                        <h5 class="card-title">Estado de la reserva</h5>
                    </div> -->

                    <div class="card-body bg-danger">
                       
                        <h5><i class="icon fas fa-ban mr-3"></i> Reserva no encontrada!</h5>
                        <p>El código de reserva que ingresó no corresponde con ningúna reserva del sistema, por favor verifique los datos.</p>
                       
                    </div>                    

                </div>

            <?php endif; endif; ?>                    

            <!-- content -->
        
        </div>
        <!-- /.container-fluid -->
    </section>

</div>

<!--=====================================
Modal registrarPago
======================================-->

<div class="modal" id="registrarPago">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

     <!-- Modal Header -->
      <div class="modal-header bg-info">
        <h4 class="modal-title">Registrar pagos a la reserva</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

       <!-- Modal body -->
      <div class="modal-body">


        <div class="table-responsive">
          <table class="table table-sm table-bordered">
            <thead>
              <tr class="table-active">
                <th style="width: 30%">Nombre del cliente</th>
                <th class="text-right">Servicio vinculado</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td id="titularReservaModal"></td>
                <td id="servicioReservaModal" class="text-right"></td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-bordered">
            <!-- <thead>
              <tr>
                <th>Bancolombia</th>
                <th>Efectivo</th>  
                <th>Davivienda</th>
                <th>Nequi</th>
                <th>Daviplata</th>
                <th>Mercadopago</th>
                <th>Payu</th>
              </tr>
            </thead> -->
            <tbody>
              <tr class="table-active">
                <th>Medio de pago</th>
                <th colspan="3" class="text-right">Monto pagado</th>
              </tr>
              <tr>
                <th style="width: 30%">Bancolombia</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment1" metodo="Bancolombia" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>                
              </tr>
              <tr>
                <th>Efectivo</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment2" metodo="Efectivo" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>                
              </tr>
              <tr>
                <th>Davivienda</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment3" metodo="Davivienda" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>
              <tr>
                <th>Nequi</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment4" metodo="Nequi" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>
              <tr>
                <th>Daviplata</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment5" metodo="Daviplata" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>
              <tr>
                <th rowspan="2" style="vertical-align: bottom;">Mercadopago</th>               
                <th colspan="2" class="text-center">Generar link de pago</th>
                <td rowspan="2"  style="vertical-align: bottom;">
                  <input type="text" class="form-control inputNumberModal" id="payment6" metodo="Mercadopago" placeholder="0" style="text-align: right; border: 0 !important;" disabled>
                </td>
              </tr>
              <tr>                                
                <td>
                  <input type="text" class="form-control inputNumberModal" id="montoLinkModal" placeholder="Ingrese el monto" min="10000" style="text-align: right;">
                </td>
                <td>
                  <button type="button" class="btn btn-secondary" id="btnLinkPago"><i class="fas fa-copy"></i> Copiar link</button>
                </td>               
              </tr>
              <tr>
                <th>Payu</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment7" metodo="Payu" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>
              </tbody>
          </table>
          <table class="table table-sm">
            <tbody>              
              <tr class="table-light">
                <th style="width: 30%;">Total pagos</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="totalSumaModal" placeholder="0" style="text-align: right; border: 0 !important;" disabled>
                </td>
              </tr>
              <tr class="table-light">
                <th>Total reserva</th>
                <td colspan="3" id="">
                  <input type="text" class="form-control inputNumberModal" id="totalReservaModal" placeholder="0" style="text-align: right; border: 0 !important;" disabled>
                </td>
              </tr>
            </tbody>
          </table>
        </div>        

        <!-- <div> -->

        <input type="hidden" id="user" value="<?php echo $_SESSION["idBackend"]; ?>">

        <!-- </div> -->

      </div>

       <!-- Modal footer -->
      <div class="modal-footer d-flex justify-content-between">  

        <div>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>

        <div>
          <button type="button" class="btn btn-primary registrarPagoReserva" id="registrarPagoReserva" >Guardar</button>
        </div>

      </div>

    </div> 

  </div>

</div>

