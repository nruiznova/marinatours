<?php
require_once __DIR__ . "/../extensiones/vendor/pse/vendor/autoload.php";
require_once __DIR__ . "/../modelos/reservas.modelo.php";
require_once __DIR__ . "/tokenPSE.controlador.php";
require_once __DIR__ . "/reservas.controlador.php";

use \PSEIntegration\PSEIntegration;
use \PSEIntegration\Models\TransactionInformationRequest;
use \PSEIntegration\Models\FinalizeTransactionPaymentRequest;

class ControladorReservasPendientes {
  static public function obtenerReservas() {
    $pending = ModeloReservas::mdlObtenerReservasPendientes();

    if(!empty($pending)){
      $token = ControladorTokenPSE::obtenerToken();
      if($token && isset($token["access_token"])){
        $sdk = new PSEIntegration();
        $sdk->setCertificateIgnoreInvalid(true);
        foreach($pending as $reserva){
          $transactionInformationRequest = new TransactionInformationRequest('9012712671', $reserva['numero_transaccion']);
          $transactionInformationResponse = $sdk->getTransactionInformation($transactionInformationRequest, $token['access_token']);
          if($transactionInformationResponse->returnCode == 'SUCCESS'){
            $res = ControladorReservas::ctrSaveTransactionState($transactionInformationResponse->transactionState, $reserva["codigo_reserva"]);
            if($transactionInformationResponse->transactionState == 'OK'){
              $finalizeTransactionPaymentRequest = new FinalizeTransactionPaymentRequest('9012712671', $reserva['numero_transaccion'], '');
              $finalizeTransactionPaymentResponse = $sdk->finalizeTransactionPayment($finalizeTransactionPaymentRequest, $token['access_token']);
              //var_dump($finalizeTransactionPaymentResponse);
              $status = 'approved';
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

                  
                } catch (Exception $e) {
        
                }
              }
            }
          }
        }
      }
    }
  }
}