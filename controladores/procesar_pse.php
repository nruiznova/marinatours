<?php

header('Content-Type: application/json');

// Forzar que se muestren todos los errores (solo para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Capturar cualquier excepción no atrapada
set_exception_handler(function($e) {
    echo json_encode([
        'returnCode' => 'FAIL_EXCEPTION',
        'errorDetails' => $e->getMessage()
    ]);
    exit;
});
// Capturar errores fatales
register_shutdown_function(function() {
  $error = error_get_last();
  if ($error) {
    echo json_encode([
      'returnCode' => 'FAIL_FATAL',
      'errorDetails' => $error['message']
    ]);
    exit;
  }
});

require_once __DIR__ . "/../extensiones/vendor/pse/vendor/autoload.php";
require_once __DIR__ . "/tokenPSE.controlador.php"; 
require_once __DIR__ . "/reservas.controlador.php";

use \PSEIntegration\PSEIntegration;
use \PSEIntegration\Models\CreateTransactionPaymentRequest;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $recaptchaResponse = $_POST['g-recaptcha-response'];
  $secretKey = "6Lf-FtArAAAAANcTBXtk8FIOEVOQhxo2C83tYIr8";
  // Validar con Google
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $data = [
    'secret' => $secretKey,
    'response' => $recaptchaResponse,
    'remoteip' => $_SERVER['REMOTE_ADDR']
  ];
  $options = [
    'http' => [
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data),
    ],
  ];
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  $response = json_decode($result);

  if ($response->success) {
    // CAPTCHA correcto → procesar pago
  } else {

    echo json_encode([
      'returnCode' => 'FAIL_CAPTCHA',
      'errorDetails' => 'Por favor, verifica el reCAPTCHA.'
    ]);
    exit;
  }
  
  $token = ControladorTokenPSE::obtenerToken();
  if ($token && isset($token["access_token"])) {
    $sdk = new PSEIntegration();
    $sdk->setCertificateIgnoreInvalid(true);
  
    // Datos recibidos del formulario
    $bank = $_POST['bank'] ?? '';
    $name = $_POST['name'] ?? '';
    $identification_type = $_POST['identification_type'] ?? '';
    $identification_number = $_POST['identification_number'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $total_value = $_POST['total_value'] ?? '';
    $user_type = $_POST['user_type'] ?? '';
    $service_name = $_POST['service_name'] ?? ''; //descripcion_reserva

    $dt = new DateTime("now", new DateTimeZone("America/Bogota")); // hora Colombia
    $milis = (int)($dt->format('v')); // milisegundos
    $date = $dt->format("Y-m-d\TH:i:s") . '.' . sprintf("%03d", $milis) . 'Z';

    $codigoReserva = $_POST['codigo_reserva'] ?? 'reserva_' . uniqid();
    $entityurl = "https://marinatourscartagena.com.co/resultado-pago?id=" .  $codigoReserva; //comprobante pago

    $datosTemporales = ModeloReservas::mdlObtenerDatosTemporales($codigoReserva);
  
    try {
      $createTransactionPaymentRequest = new CreateTransactionPaymentRequest(
        '9012712671', //entityCode,
        $bank, //financialInstitutionCode
        '1001', //$serviceCode,
        $total_value,
        0, //$vat,
        $datosTemporales['id'],//ticketId poner id de la reserva temporal
        $entityurl,
        $user_type,
        $identification_type, //"ReferenceNumber1",
        $identification_number, //"ReferenceNumber2",
        $_SERVER['SERVER_ADDR'], //"ReferenceNumber3",
        $date,
        $service_name,
        $identification_type,
        $identification_number,
        $name,
        $phone,
        $address,
        $email,
        $identification_type,//beneficiaryIdentificationType
        $identification_number,//beneficiaryIdentification
        'NIT',//beneficiaryEntityIdentificationType,
        '9012712671',//beneficiaryEntityIdentification,
        'HEAVEN TOURS CARTAGENA S.A.S', //beneficiaryEntityName,
        '5011',//beneficiaryEntityCIIUCategory
      );

      $createTransactionPaymentResponse = $sdk->createTransactionPayment($createTransactionPaymentRequest, $token['access_token']);
     
      if($createTransactionPaymentResponse->returnCode == 'SUCCESS'){
        ControladorReservas::ctrSaveTrazabilityCode($createTransactionPaymentResponse->trazabilityCode, $codigoReserva);
      }
      echo json_encode($createTransactionPaymentResponse);
    } catch (Exception $e) {
      echo json_encode([
        'returnCode' => 'FAIL_GENERAL',
        'errorDetails' => $e->getMessage(),
      ]);
    }
  } 
  else {
    echo json_encode([
      'returnCode' => 'FAIL_TOKEN',
      'errorDetails' => 'No se pudo obtener token válido'
    ]);
  }

  exit;
}
