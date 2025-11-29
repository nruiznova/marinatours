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

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reserva PDF</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>

         @page {
            /*background: url('<?php echo $ruta ?>vistas/images/bg.jpg') no-repeat center center;*/
            /*background-size: cover;*/
            margin: 0;
        } 

        body {
            background-color: rgba(255, 255, 255, 0.9);
            font-family: "Montserrat", sans-serif;
            padding: 25px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            margin: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Bebas Neue", sans-serif;
            text-transform: uppercase;
        }

        h2 {
            font-size: 2rem;
        }

        h4 {
            font-size: 1.5rem;
        }

        .table, .table th, .table td {
            background-color: transparent !important;
            border-color: rgba(0, 0, 0, 0.2) !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .noprint {
            display: none;
        }

        .print {
            display: block;
        }

        .main-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 0;">
        <img src="<?php echo $ruta ?>vistas/images/bg.jpg" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.2;">
    </div>

    <div class="main-content" style="position: relative; z-index: 1;">

        
    
    
    
        <!-- Contenido principal -->
        <div class="row mainCont">
            <div class="col-12">   
                <div class="container mb-5 text-center">      
                    <!-- Main content -->
                    <div class="">
                        <div class="d-flex justify-content-center" style="">
                            <div><img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> </div>
                            <!--<div><img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> </div>-->
                        </div>
                        <!-- title row -->
                        <div class="row">
                            <!--<div class="col-2">-->
                            <!--     <img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> -->
                            <!--</div>-->
                            <div class="col-12">

                                <h2 class="intro_title" style="font-family: 'Bebas Neue', sans-serif; font-size: 20px">
                                    <?php echo $titleArr[0]; ?>
                                </h2>

                                <h4 style="font-family: 'Bebas Neue', sans-serif; font-size: 15px">para<br>
                                
                                    <?php 
                                    
                                    if($reserva["fecha_ingreso"] == null){
                                        echo date("d-m-Y", strtotime($reserva["fecha_salida"]));
                                    }else{
                                        echo date("d-m-Y", strtotime($reserva["fecha_ingreso"]));
                                    }
                                    
                                    ?>
                            
                                </h4>

                                <h4 style="font-family: 'Bebas Neue', sans-serif; font-size: 15px"><?php if($adultos > 0){ echo $adultos; }else{ echo intval($titleArr[1]); } ?> adulto(s) <?php if($niños > 0){ echo' - '.$niños.' niños'; } ?></h4>

                            </div>
                            <!--<div class="col-2">-->
                            <!--     <img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> -->
                            <!--</div>-->
                            <!-- /.col --> 
                        </div>  
                        
                        <!-- <hr> -->

                        <div class="row">
                        <!-- accepted payments column -->            
                        <!-- /.col -->
                            <div class="col-12 pt-2">
                                <!-- echo $ruta."?pagina%3Dver-reserva%26codigo%3D". -->
                                <img id='barcode' src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo $infoReserva; ?>&amp;size=270x270" alt="" title="Escanea para ver la información de tu reserva" width="270" height="270" />
                                <p><i>Este QR solo puede ser validado por la transportadora MarinaTour</i></p>
                            </div>
                            <!-- <hr> -->
                            <div class="col-lg-6 offset-lg-3 p-0 mt-5">                        

                                <div class="d-flex justify-content-center">
                                    <table class="table table-sm text-center">
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
                        
                    </div>
                    <!-- /.invoice -->
                </div>
            </div>
        </div>






    </div>
</body>
</html>
