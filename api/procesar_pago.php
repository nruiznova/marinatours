<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

require_once __DIR__ . '/../controladores/reservas.controlador.php';
require_once __DIR__ . '/../modelos/reservas.modelo.php';
require_once __DIR__ . '/../extensiones/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" &&
    strpos($_SERVER["CONTENT_TYPE"] ?? '', "application/json") !== false) {

    header("Content-Type: application/json");
    
    $input = file_get_contents("php://input");
    $formData = json_decode($input, true);
    $codigoReserva = $_COOKIE["codigoReserva"] ?? 'desconocido';
    
    // validar el metodo de pago
    $paymentMethod = $formData['payment_method_id'];
    
    if($paymentMethod === 'pse'){
        
        MercadoPago\SDK::setAccessToken("APP_USR-1198270120630556-051516-34b830bb27d6a5120df88c6dabd7a187-1673855193");
        
        $client = new PaymentClient();
        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key: <".$codigoReserva.">"]);
        
        $client = new PaymentClient();
        $createRequest = [
          "transaction_amount" => 5000,
          "description" => "Product description",
          "payment_method_id" => "pse",
          "callback_url" => "https://marinatourscartagena.com.co/",
          "notification_url" => "https://marinatourscartagena.com.co/api/notificacion.php",
          "additional_info" => [
            "ip_address" => "127.0.0.1"
          ],
          "transaction_details" => [
            "financial_institution" => $formData['transaction_details']['financial_institution']
          ],
          "payer" => [
            "email" => $_COOKIE["correo"],
            "entity_type" => "individual",
            "first_name" => $_COOKIE['firstName'],
            "last_name" => $_COOKIE['lastName'],
            "identification" => [
                "type" => $_COOKIE['tipo_identificacion'],
                "number" => $_COOKIE['numero_identificacion']
            ],
            "address" => [
                "zip_code" => $formData['payer']['address']['zip_code'],
                "street_name" => $formData['payer']['address']['street_name'],
                "street_number" => $formData['payer']['address']['street_number'],
                "neighborhood" => $formData['payer']['address']['neighborhood'],
                "city" => $formData['payer']['address']['city'],
                "federal_unit" => "1"
            ],
            "phone" => [
                "area_code" => $formData['payer']['phone']['area_code'],
                "number" => $formData['payer']['phone']['number']
            ],
          ],
        ];
        
        $payment = $client->create($createRequest, $request_options);
        
    }else{
        
        //inicializar el sdk
        MercadoPago\SDK::setAccessToken("APP_USR-1198270120630556-051516-34b830bb27d6a5120df88c6dabd7a187-1673855193");
        $payment = new MercadoPago\Payment();
        
        $isCard = in_array($paymentMethod, ['visa', 'master', 'amex', 'diners', 'debvisa', 'debmaster', 'argencard']); // puedes ampliarlo
        
        if ($isCard) {
    
            if (
                !isset($formData['token']) ||
                !isset($formData['payment_method_id']) ||
                !isset($formData['installments']) ||
                !isset($formData['issuer_id']) ||
                !isset($formData['transaction_amount'])
            ) {
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "Faltan datos para procesar el pago test.",
                    "redirect" => "no"
                ]);
                exit;
            }
            
            $payment->token = $formData["token"];
            $payment->installments = intval($formData["installments"]);
            $payment->payment_method_id = $formData["payment_method_id"];
            $payment->issuer_id = $formData["issuer_id"];
        
        }
        
        $payment->transaction_amount = floatval($formData["transaction_amount"]);
        $payment->transaction_details = [
            "financial_institution" => $formData['transaction_details']['financial_institution'],
        ];
        $payment->external_reference = $_COOKIE["codigoReserva"] ?? "reserva_sin_codigo";
        $payment->description = $_COOKIE["infoHabitacion"] ?? 'Reserva Marina Tours';
        $payment->statement_descriptor = "MARINA TOURS";
        $payment->payer = [
            "email" => $_COOKIE["correo"] ?? "cliente@ejemplo.com",
            "first_name" => $_COOKIE["firstName"] ?? '',
            "last_name" => $_COOKIE["lastName"] ?? '',
            "identification" => [
                "type" => strtoupper($_COOKIE["tipo_identificacion"]) ?? '',
                "number" => $_COOKIE["numero_identificacion"] ?? ''
            ],
            "entity_type" => "individual",
            "address" => [
                "zip_code" => $formData['payer']['address']['zip_code'],
                "street_name" => $formData['payer']['address']['street_name'],
                "street_number" => $formData['payer']['address']['street_number'],
                "neighborhood" => $formData['payer']['address']['neighborhood'],
                "city" => $formData['payer']['address']['city'],
                // "federal_unit" => $formData['payer']['address']['federal_unit']
            ],
            "phone" => [
                "area_code" => $formData['payer']['phone']['area_code'],
                "number" => $formData['payer']['phone']['number']
            ],
        ];
        $payment->additional_info = [
            "items" => [
                [
                    "id" => $_COOKIE["idHabitacion"] ?? "habitacion_default",
                    "title" => $_COOKIE["infoHabitacion"] ?? "Reserva Marina Tours",
                    "description" => "Reserva de alojamiento turístico",
                    "category_id" => "travel", // << AQUÍ está el campo importante
                    "quantity" => 1,
                    "unit_price" => floatval($formData["transaction_amount"])
                ]
            ],
            "ip_address" => $_SERVER['REMOTE_ADDR'],
        ];
        $payment->callback_url = "https://marinatourscartagena.com.co/";
        $payment->notification_url = "https://marinatourscartagena.com.co/api/notificacion.php";
        $payment->save();
        
    }

    if ($payment->status !== "approved") {
        http_response_code(400);
        echo json_encode([
            "status" => "rejected",
            "message" => "El pago fue rechazado. test",
            "payment_id" => $payment->id,
            "status_detail" => $payment->status_detail,
            "external_reference" => $codigoReserva
        ]);
        exit;
    }

    if (isset($_COOKIE["addPayment"])) {
        $datos = [
            "id_reserva" => $_COOKIE["idReserva"],
            "monto" => $_COOKIE["pagoActual"],
            "metodo_pago" => "Mercadopago",
            "usuario" => "Usuario mediante link de pago"
        ];

        $respuesta = ControladorReservas::ctrRegistrarPago($datos);

        if ($respuesta === "ok") {
            echo json_encode([
                "status" => "success",
                "tipo" => "pago",
                "codigo" => $codigoReserva,
                "payment_id" => $payment->id,
                "status_detail" => $payment->status_detail,
                "external_reference" => $codigoReserva,
                "message" => "Pago registrado correctamente."
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "No se pudo registrar el pago.",
                "payment_id" => $payment->id,
                "status_detail" => $payment->status_detail,
                "external_reference" => $codigoReserva
            ]);
        }
        exit;
    }

    $datos = array(
        "id_habitacion" => $_COOKIE["idHabitacion"],
        "id_usuario" => $_COOKIE["id_user"],
        "pago_reserva" => $_COOKIE["pagoReserva"],
        "numero_transaccion" => $payment->id,
        "codigo_reserva" => $codigoReserva,
        "descripcion_reserva" => $_COOKIE["infoHabitacion"],
        "fecha_ingreso" => $_COOKIE["fechaIngreso"],
        "fecha_salida" => $_COOKIE["fechaSalida"],
        "acompañantes" => $_COOKIE["acompañantes"],
        "firstName" => $_COOKIE["firstName"],
        "lastName" => $_COOKIE["lastName"],
        "tipo_identificacion" => $_COOKIE["tipo_identificacion"],
        "numero_identificacion" => $_COOKIE["numero_identificacion"],
        "celular" => $_COOKIE["celular"],
        "correo" => $_COOKIE["correo"],
        "hospedaje" => $_COOKIE["hospedaje"],
        "abono" => $_COOKIE["abono"],
        "cuotas" => $_COOKIE["cuotas"],
        "montoPagar" => $_COOKIE["montoPagar"],
        "valorCuotas" => $_COOKIE["valorCuotas"],
        "pagoCuotas" => $_COOKIE["pagoCuotas"]
    );

    $respuesta = ControladorReservas::ctrGuardarReserva($datos);

    if ($respuesta === "ok") {
        $correoCliente = $_COOKIE["correo"];
        $nombreCliente = ($_COOKIE["firstName"] ?? '') . ' ' . ($_COOKIE["lastName"] ?? '');
        $ruta = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
        $enlaceCompletar = $ruta . "index.php?pagina=completar-datos&token=" . $codigoReserva;

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
            $mail->Subject = 'Confirmación de tu reserva #' . $codigoReserva;
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
                echo json_encode([
                    "status" => "success",
                    "tipo" => "reserva",
                    "codigo" => $codigoReserva,
                    "payment_id" => $payment->id,
                    "status_detail" => $payment->status_detail,
                    "external_reference" => $codigoReserva,
                    "message" => "Reserva registrada y correo enviado"
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    "status" => "error",
                    "message" => "Reserva creada, pero no se pudo enviar el correo: " . $mail->ErrorInfo,
                    "payment_id" => $payment->id,
                    "status_detail" => $payment->status_detail,
                    "external_reference" => $codigoReserva
                ]);
                exit;
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Error al enviar el correo: " . $mail->ErrorInfo,
                "payment_id" => $payment->id,
                "status_detail" => $payment->status_detail,
                "external_reference" => $codigoReserva
            ]);
            exit;
        }

    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "No se pudo registrar la reserva.",
            "payment_id" => $payment->id,
            "status_detail" => $payment->status_detail,
            "external_reference" => $codigoReserva
        ]);
        exit;
    }
}

if (!headers_sent()) {
    header("Content-Type: application/json");
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Solicitud no válida.",
        "redirect" => "no"
    ]);
}
