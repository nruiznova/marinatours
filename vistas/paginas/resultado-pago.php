<?php

require_once __DIR__ . "/../../extensiones/vendor/pse/vendor/autoload.php";
require_once __DIR__ . "/../../modelos/reservas.modelo.php";
require_once __DIR__ . "/../../modelos/bank.modelo.php";
require_once __DIR__ . "/../../controladores/reservas.controlador.php";
require_once __DIR__ . "/../../controladores/tokenPSE.controlador.php";

use \PSEIntegration\PSEIntegration;
use \PSEIntegration\Models\TransactionInformationRequest;
use \PSEIntegration\Models\FinalizeTransactionPaymentRequest;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$id = $_GET['id'];
$status = '';
if(isset($id)){
  $reserva = ControladorReservas::ctrMostrarCodigoReserva($id);
  if(!$reserva){
    $reserva = ModeloReservas::mdlObtenerDatosTemporales($id);
  }

  if($reserva){
    $pagos = false;
    if(isset($reserva["id_reserva"])){
      $pagos =  ControladorReservas::ctrMostrarPagos("id_reserva", $reserva["id_reserva"]);	
    }
    if(isset($reserva["guests"])){
     $reserva["acompañantes"] = $reserva["guests"];
    }
    $guests = json_decode($reserva["acompañantes"], true);
    $adultos = 0;
    $niños = 0;
    if(isset($guests)){
      foreach ($guests as $g => $gue) {
        if(isset($gue["tipo"])){
          if($gue["tipo"] == "adulto"){
            $adultos++;
          }else{
            $niños++;
          }
        }        
      }
    }
    $titleArr = explode(" - ", $reserva["descripcion_reserva"]);
    if(!$pagos){    
      if(isset($reserva['numero_transaccion'])){
        $token = ControladorTokenPSE::obtenerToken();
        if($token && isset($token["access_token"])){
          $sdk = new PSEIntegration();
          $sdk->setCertificateIgnoreInvalid(true);
          $transactionInformationRequest = new TransactionInformationRequest('9012712671', $reserva['numero_transaccion']);
          $transactionInformationResponse = $sdk->getTransactionInformation($transactionInformationRequest, $token['access_token']);
          //var_dump($transactionInformationResponse); 
          if($transactionInformationResponse->returnCode == 'SUCCESS'){
            $res = ControladorReservas::ctrSaveTransactionState($transactionInformationResponse->transactionState, $reserva["codigo_reserva"]);
            if($transactionInformationResponse->transactionState == 'OK'){
              $finalizeTransactionPaymentRequest = new FinalizeTransactionPaymentRequest('9012712671', $reserva['numero_transaccion'], '');
              $finalizeTransactionPaymentResponse = $sdk->finalizeTransactionPayment($finalizeTransactionPaymentRequest, $token['access_token']);
              //var_dump($finalizeTransactionPaymentResponse);
              $status = 'approved';
              //175
              //213
              $reserva['abono'] = 'total';
              $respuesta = ControladorReservas::ctrGuardarReserva($reserva);
              $reserva = ControladorReservas::ctrMostrarCodigoReserva($reserva["codigo_reserva"]);
              $datosPago = [
                "id_reserva" => $reserva["id_reserva"],
                "monto" => $reserva["pago_reserva"],
                "metodo_pago" => "PSE",
                "usuario" => "Usuario mediante página web"
              ];
              $respuestaPago = ControladorReservas::ctrRegistrarPago($datosPago);

              if ($respuesta === "ok") {
                $correoCliente = $reserva["correo"];
                $nombreCliente = ($reserva["firstName"] ?? '') . ' ' . ($reserva["lastName"] ?? '');
                $ruta = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
                $enlaceCompletar = $ruta . "index.php?pagina=completar-datos&token=" . $reserva["codigo_reserva"];

                $mail = new PHPMailer(true);

                try {
                  $mail->isSMTP();
                  $mail->Host = 'smtp.gmail.com';
                  $mail->SMTPAuth = true;
                  $mail->Username = 'reservas.marinatours@gmail.com';
                  $mail->Password = 'odwy xigx wbjp jgzo';
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                  $mail->Port = 587;
                  $mail->CharSet = 'UTF-8';

                  $mail->setFrom('reservas.marinatours@gmail.com', 'Hotel Isla Palma');
                  $mail->addAddress($correoCliente, $nombreCliente);

                  $mail->isHTML(true);
                  $mail->Subject = 'Confirmación de tu reserva #' . $reserva["codigo_reserva"];
                  $mail->Body = "
                    <html>
                      <head><meta charset='UTF-8'></head>
                      <body>
                        <p>
                            
                        Estimado cliente,<br><br>
                        Nombre, apellido y número de documento de identidad de los pasajeros asociados a su
                        reserva.<br><br>
                        Diligenciar información en el siguiente link: '$enlaceCompletar'<br><br>
                        El requerimiento es de carácter obligatorio, ya que esta información es indispensable tanto
                        para los trámites de zarpe marítimo y aprobación, como para la emisión del seguro
                        asistencial diario, el cual garantiza la cobertura durante toda la operación.
                        Agradecemos su comprensión y apoyo.<br><br>
                        <strong>Este correo es únicamente informativo, por favor no responder a este mensaje.</strong>
                            
                        </p>
                      </body>
                    </html>
                  ";

                  if ($mail->send()) {
                    /*echo json_encode([
                      "status" => "success",
                      "tipo" => "reserva",
                      "codigo" => $codigoReserva,
                      "payment_id" => $payment->id,
                      "status_detail" => $payment->status_detail,
                      "external_reference" => $codigoReserva,
                      "message" => "Reserva registrada y correo enviado"
                    ]);*/
                  } else {
                    /*http_response_code(500);
                    echo json_encode([
                      "status" => "error",
                      "message" => "Reserva creada, pero no se pudo enviar el correo: " . $mail->ErrorInfo,
                      "payment_id" => $payment->id,
                      "status_detail" => $payment->status_detail,
                      "external_reference" => $codigoReserva
                    ]);*/
                  }
                } catch (Exception $e) {
                  /*http_response_code(500);
                  echo json_encode([
                    "status" => "error",
                    "message" => "Error al enviar el correo: " . $mail->ErrorInfo,
                    "payment_id" => $payment->id,
                    "status_detail" => $payment->status_detail,
                    "external_reference" => $codigoReserva
                  ]);*/
                }
              } else {
                /*http_response_code(500);
                echo json_encode([
                  "status" => "error",
                  "message" => "No se pudo registrar la reserva.",
                  "payment_id" => $payment->id,
                  "status_detail" => $payment->status_detail,
                  "external_reference" => $codigoReserva
                ]);*/
              }
            }
            else if($transactionInformationResponse->transactionState == 'PENDING'){
              $status = 'pending';
            }
            else{
              $status = 'rejected';
            }
          }
        }
      }
    }
    else{
      $status = 'approved';
    }
  }

  switch ($status) {
    case 'approved':
      $class = 'bg-info';
      $title = '¡Tu pago se ha procesado exitosamente!';
      $message = '<p>Para completar tu reserva, por favor revisa el correo electrónico que proporcionaste
        durante el proceso de compra. Allí encontrarás un enlace que debes abrir para
        diligenciar la información requerida. Una vez completes los datos solicitados, recibirás
        un documento en formato PDF con todos los detalles de tu reserva. Este archivo podrás
        descargarlo y presentarlo el día de tu servicio. Es muy importante que diligencies esta
        información lo antes posible, ya que omitir este paso podría generar inconvenientes que
        pongan en riesgo tu reserva.
        <br>Si no recibes el correo en los próximos minutos, no dudes en contactarnos por
        WhatsApp al <a href="https://wa.me/573043752759">+ 57 304 375 2759</a> para ayudarte.</p>';
      break;
    case 'pending':
      $class = 'bg-warning';
      $title = 'Tu pago se ha encuentra en verificación';
      $message = '<p>Si la transacción es aprobada te enviaremos un correo electrónico a la dirección que proporcionaste
        durante el proceso de compra. Allí encontrarás un enlace que debes abrir para
        diligenciar la información requerida. Una vez completes los datos solicitados, recibirás
        un documento en formato PDF con todos los detalles de tu reserva. Este archivo podrás
        descargarlo y presentarlo el día de tu servicio.';
      break;
    case 'rejected':
        $title = 'Tu pago no fue procesado.';
        $class = 'bg-danger';
        $message = 'Tu transacción fue cancelada o rechazada. Por favor realiza de nuevo la reserva e intenta un nuevo pago.';
      break;
    default:
      $title = 'Tu pago no pudo ser verificado.';
      $class = 'bg-danger';
      $message = 'No fue posible obtener información de la transacción. Si tu pago fue procesado por favor contactanos por WhatsApp al <a href="https://wa.me/573043752759">+ 57 304 375 2759</a> para ayudarte.';
  }
}
?>

<div class="row">
  <div class="col-12">   
    <div class="container  mt-5 mb-5"> 
      <div class="<?php echo($class)?> p-3 text-white">
        <h5><?php echo($title) ?></h5>
        <p>
          <?php echo($message)?>
        </p>
      </div>
    </div>
  </div>
</div>

<?php if (isset($transactionInformationResponse)) : ?>
  <?php if ($transactionInformationResponse->transactionState == 'PENDING') : ?>
    <div class="row">
      <div class="col-12">   
        <div class="container mb-5"> 
          <div class="<?php echo $class ?> p-3 text-white">
            <h5>Por favor verificar si el débito fue realizado en el banco</h5>
            <p>Si requieres más información sobre la transacción por favor comunicate a nuestras líneas de atención al cliente +57 3043752759</p>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php endif; ?>

<?php if($reserva) :?>
  <div class="row mainCont" style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('images/bg.jpg') !important; background-size: cover; background-position: center; ">
    <div class="col-12">   
      <div class="container mt-5 mb-5 text-center">     
        <div class="invoice p-3 mb-3">
        
          <?php if(isset($transactionInformationResponse)) :?>
            <div class="row">
              <div class="col-2">
                <img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> 
              </div>
              <div class="col-8">
                <h3 class="intro_title">
                  Comprobante de pago
                </h3>
              </div>
              <div class="col-2">
                <img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> 
              </div>
            </div>
            <h5 class="intro_title">
              Datos de la empresa
            </h5>
            <div class="row">
              <div class="col-lg-6 offset-lg-3 p-0 mt-2">
                <div class="d-flex justify-content-center">
                  <table class="table table-sm">
                    <tr>
                      <th style="width: 60%">NIT</th>
                      <td><?php echo ($transactionInformationResponse->serviceNIT); ?></td>
                    </tr>
                    <tr>
                      <th style="width: 60%">Razón social</th>
                      <td>HEAVEN TOURS CARTAGENA SAS</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <h5 class="intro_title">
              Datos de la transacción
            </h5>
            <div class="row">
              <div class="col-lg-6 offset-lg-3 p-0 mt-2">
                <div class="d-flex justify-content-center">
                  <table class="table table-sm">
                    <tr>
                      <th style="width: 60%">Estado de la transacción</th>
                      <td>
                        <?php 
                          $estados = [
                            'OK'      => 'Aprobada',
                            'PENDING' => 'Pendiente',
                            'FAILED'  => 'Transacción fallida',
                          ];

                          echo $estados[$transactionInformationResponse->transactionState] ?? 'Rechazada';
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th style="width: 60%">Banco</th>
                      <td>
                        <?php 
                          $bank = ModeloBanksPSE::obtenerBancosByID($transactionInformationResponse->financialInstitutionCode);
                          if($bank){
                            echo($bank["financial_institute_name"]);
                          }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th style="width: 60%">Código único de seguimiento (CUS)</th>
                      <td><?php echo ($transactionInformationResponse->trazabilityCode); ?></td>
                    </tr>
                    <tr>
                      <th style="width: 60%">Referencia de pago (TicketID)</th>
                      <td><?php echo ($transactionInformationResponse->ticketId); ?></td>
                    </tr>
                    <tr>
                      <th style="width: 60%">Fecha de creación de la transacción</th>
                      <td>
                        <?php 
                          $fecha = new DateTime($transactionInformationResponse->soliciteDate);
                          echo $fecha->format('d/m/Y');
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th style="width: 60%">Valor del pago</th>
                      <td>
                        <?php
                          $value = $transactionInformationResponse->transactionValue;
                          echo ('$' . number_format($value, 0, ',', '.')); 
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th style="width: 60%">Descripción del pago</th>
                      <td><?php echo ($transactionInformationResponse->paymentDescription); ?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-center mt-5"></div>
          <?php endif; ?>

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
              <h4>
                <?php if($adultos > 0){ echo $adultos; }else{ echo intval($titleArr[1]); } ?> 
                  adulto(s) 
                <?php if($niños > 0){ echo' - '.$niños.' niños'; } ?>
              </h4>
            </div>
            <div class="col-2">
              <img src="<?php echo $ruta ?>vistas/images/logo_isla_palma.png" width="80px"> 
            </div>
          </div>

          <div class="row">
            <?php if($class == 'bg-info') :?>
              <!--<div class="col-12 pt-2">
                <img id='barcode' src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo $id; ?>&amp;size=300x300" alt="" title="Escanea para ver la información de tu reserva" width="300" height="300" />
                <p><i>Este QR solo puede ser validado por la transportadora MarinaTour</i></p>
              </div>-->
            <?php endif; ?>
            <div class="col-lg-6 offset-lg-3 p-0 mt-2">
              <div class="d-flex justify-content-center mt-5">
                <table class="table table-sm">
                  <!--<tr>
                    <th>Código reserva</th>
                    <td><?php echo $reserva["codigo_reserva"]; ?></td>
                  </tr>-->
                  <tr>
                    <th style="width: 60%">Titular de la reserva</th>
                    <td><?php echo ($reserva["firstName"] . ' ' . $reserva["lastName"]); ?></td>
                  </tr>
                  <tr>
                    <th>Documento de identidad</th>
                    <td><?php echo $reserva["numero_identificacion"]; ?></td>
                  </tr>
                  <tr>
                    <th>Celular</th>
                    <td><?php echo $reserva["celular"]; ?></td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td><?php echo $reserva["correo"]; ?></td>
                  </tr>
                  <tr>
                    <th>Punto de encuentro</th>
                    <td><?php echo $reserva["hospedaje"]; ?></td>
                  </tr>
                  <tr>
                    <th>Valor</th>
                    <td><?php echo('$' . number_format($reserva['pago_reserva'], 0, ',', '.')); ?></td>
                  </tr>
                  <?php if($class == 'bg-info') :?>
                    <!--<tr>
                      <td colspan="2">El código QR solo podrá ser validado en punto de encuentro previo al inicio del servicio</td>
                    </tr>-->
                  <?php endif; ?>
                  <tr>
                    <td colspan="2">Si necesitas mas información puedes contactarnos +57 3043752759</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <?php if($class == 'bg-info') :?>
            <!--<div class="row noprint">
              <div class="col-lg-6 offset-lg-3 p-2">
                <hr>          
                <button type="button" class="btn btn-primary" style="margin-right: 5px;" onclick="window.print()">
                  <i class="fas fa-qrcode"></i> Descargar QR
                </button>
              </div>
            </div>-->
          <?php endif; ?>
          <div class="d-flex justify-content-center mt-5"></div>
          <a href="/" class="btn btn-default btn-lg call-to-action-btn-gold">Realizar otra reserva</a>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>