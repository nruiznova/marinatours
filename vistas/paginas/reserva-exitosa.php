<?php 

$infoReserva = $_GET["codigo"];
$reserva = ControladorReservas::ctrMostrarCodigoReserva($infoReserva);

$guests = json_decode($reserva["guests"], true);

$adultos = 0;

$niños = 0;

$asientos = '';

foreach ($guests as $g => $gue) {

    if(isset($gue["tipo"])){

        if($gue["tipo"] == "adulto"){
            $adultos++;
        }else{
            $niños++;
        }

        $asientos .= $gue["asiento"].", ";

    }        

}

$titleArr = explode(" - ", $reserva["descripcion_reserva"]);

if(isset($_GET["type"])){

    if($_GET["type"] == "reserva"){

        $title = '

        <h2 class="intro_title text-success">¡La reserva se ha realizado con éxito!</h2>
        <p>La boleta de reserva se ha enviado al correo registrado del titular</p>
        
        ';

    }else if($_GET["type"] == "pago"){

        $title = '

        <h2 class="intro_title text-success">¡Pago realizado con éxito!</h2>        
        
        ';

    }

}

?>

<style> 

@media print {
    /* .invoice:before {
        content:url('images/bg.jpg');
        position: absolute;
        z-index: -1;
      } */

      body{
        background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
            url('images/bg.jpg') !important; 
            background-size: cover; 
            background-position: center; 
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
      }
      .table, .table th, .table td {
        background-color: transparent !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* Elimina bordes si también afectan visualmente */
    .table th, .table td {
        border-color: rgba(0, 0, 0, 0.2) !important; /* bordes opcionales y sutiles */
    }

    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}

</style>

<!-- <section class="content"> -->
<!-- <div class="container mt-5 mb-5 noprint"> -->
    <?php if($_GET["estado"] == "pagada"): ?>
 
        <div class="row">
            <div class="col-12">   
                <div class="container  mt-5 mb-5"> 

                    <div class="bg-info p-3 text-white">
                        <h5>¡Tu pago se ha procesado exitosamente!</h5>

                        <p>Para completar tu reserva, por favor revisa el correo electrónico que proporcionaste
                        durante el proceso de compra. Allí encontrarás un enlace que debes abrir para
                        diligenciar la información requerida. Una vez completes los datos solicitados, recibirás
                        un documento en formato PDF con todos los detalles de tu reserva. Este archivo podrás
                        descargarlo y presentarlo el día de tu servicio. Es muy importante que diligencies esta
                        información lo antes posible, ya que omitir este paso podría generar inconvenientes que
                        pongan en riesgo tu reserva.
                        <br>Si no recibes el correo en los próximos minutos, no dudes en contactarnos por
                        WhatsApp al <a href="https://wa.me/573043752759">+ 57 304 375 2759</a> para ayudarte.</p>
                    </div>

                </div>
            </div>
        </div>

    <?php else: ?>
    <div class="row mainCont" style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
            url('images/bg.jpg') !important; background-size: cover; background-position: center; ">
        <div class="col-12">   
            <div class="container mt-5 mb-5 text-center">     
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-2">
                            <img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> 
                        </div>
                        <div class="col-8">

                            <h2 class="intro_title">
                                <?php echo $titleArr[0]; ?>
                            </h2>

                            <h4>para<br>
                            
                                <?php 
                                
                                if($reserva["fecha_ingreso"] == null){
                                    echo date("d-m-Y", strtotime($reserva["fecha_salida"]));
                                }else{
                                    echo date("d-m-Y", strtotime($reserva["fecha_ingreso"]));
                                }
                                  
                                ?>
                        
                            </h4>

                            <h4><?php if($adultos > 0){ echo $adultos; }else{ echo intval($titleArr[1]); } ?> adulto(s) <?php if($niños > 0){ echo' - '.$niños.' niños'; } ?></h4>

                        </div>
                         <div class="col-2">
                            <img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> 
                        </div>
                        <!-- /.col --> 
                    </div>  
                    
                    <!-- <hr> -->

                    <div class="row">
                    <!-- accepted payments column -->            
                    <!-- /.col --> 
                    <div class="col-12 pt-2">
                        <!-- echo $ruta."?pagina%3Dver-reserva%26codigo%3D". -->
                        <img id='barcode' src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo $infoReserva; ?>&amp;size=300x300" alt="" title="Escanea para ver la información de tu reserva" width="300" height="300" />
                        <p><i>Este QR solo puede ser validado por la transportadora MarinaTour</i></p>
                    </div>
                    <!-- <hr> -->
                    <div class="col-lg-6 offset-lg-3 p-0 mt-2">

                    <!-- <hr> -->
                        
                        <!-- <p class="lead">Amount Due 2/22/2014</p> -->

                        

                        <!-- <hr> -->

                        <div class="d-flex justify-content-center mt-5">
                        <table class="table table-sm">
                            <!-- <tr> -->
                                <?php 
                                
                                    

                                    echo'  
                                    
                                        <tr>

                                            <th>Código reserva</th>
                                            <td>

                                                '.$reserva["codigo_reserva"].'
                                            
                                            </td>
                                        
                                        </tr>

                                        <tr>

                                            <th style="width: 60%">Titular de la reserva</th>
                                            <td>'.$reserva["firstName"]." ".$reserva["lastName"].'</td>

                                        </tr>

                                        <tr>

                                            <th>Documento de identidad</th>
                                            <td>'.$reserva["numero_identificacion"].'</td>

                                        </tr>
                                    
                                    ';
                                    
                                    // pegar aca codigo de agregar boton de ser necesario
                                
                                ?>
                                <tr>

                                    <th>Punto de encuentro</th>
                                    <td><?php echo $reserva["hospedaje"]; ?></td>

                                </tr>
                                <tr>

                                    <th>Asientos</th>
                                    <td><?php echo $asientos; ?></td>

                                </tr>
                                <tr>

                                    <td colspan="2">El código QR solo podrá ser validado en punto de encuentro previo al inicio del servicio</td>

                                </tr>
                                <tr>

                                    <!-- <th>Más información</th> -->
                                    <td colspan="2">Si necesitas mas información puedes contactarnos +57 3043752759</td>

                                </tr>
                                
                            <!-- </tr> -->
                        </table>
                        </div>


                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->                    

                    <!-- this row will not appear when printing -->
                    <div class="row noprint">
                    <div class="col-lg-6 offset-lg-3 p-2">
                        <hr>
                        <!-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> -->           
                        <?php // echo $button_pago; ?>             
                        <button type="button" class="btn btn-primary" style="margin-right: 5px;" onclick="window.print()">
                        <i class="fas fa-qrcode"></i> Descargar QR
                        </button>
                    </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <?php endif; ?>
<!-- </div> -->
<!-- /.container-fluid -->
<!-- </section> -->
<!-- /.content -->