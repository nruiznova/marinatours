<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método no permitido";
    exit;
}

require_once __DIR__ . '/../extensiones/vendor/autoload.php';
require_once __DIR__ . '/../controladores/reservas.controlador.php';
require_once __DIR__ . '/../modelos/reservas.modelo.php';

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

file_put_contents(__DIR__ . "/webhook.log", date('Y-m-d H:i:s') . " - Entrada: " . $rawData . PHP_EOL, FILE_APPEND);

$paymentId = $data['data']['id'] ?? null;
$type = $data['type'] ?? null;

if ($type === 'payment' && $paymentId) {
    MercadoPago\SDK::setAccessToken("APP_USR-1198270120630556-051516-34b830bb27d6a5120df88c6dabd7a187-1673855193");

    try {
        $payment = MercadoPago\Payment::find_by_id($paymentId);

        if ($payment && $payment->status === 'approved') {
            $codigoReserva = $payment->external_reference;
            $correoCliente = $payment->payer->email ?? '';
            $nombreCliente = trim(($payment->payer->first_name ?? '') . ' ' . ($payment->payer->last_name ?? ''));

            file_put_contents(__DIR__ . "/webhook.log", "Pago aprobado - ID: $paymentId - Referencia: $codigoReserva" . PHP_EOL, FILE_APPEND);

            $reservaExistente = ControladorReservas::ctrBuscarReservaPorCodigo($codigoReserva);

            if (!$reservaExistente) {
                $datos = ModeloReservas::mdlObtenerDatosTemporales($codigoReserva); // ⚠️ Asegúrate de tener esta función

                if (!$datos) {
                    file_put_contents(__DIR__ . "/webhook.log", "No se encontraron datos temporales para la reserva $codigoReserva" . PHP_EOL, FILE_APPEND);
                    http_response_code(500);
                    exit;
                }

                // Agregamos el número de transacción del pago de MercadoPago
                $datos['numero_transaccion'] = $payment->id;

                $respuesta = ControladorReservas::ctrGuardarReserva($datos);

                if ($respuesta !== "ok") {
                    file_put_contents(__DIR__ . "/webhook.log", "Error al guardar la reserva $codigoReserva" . PHP_EOL, FILE_APPEND);
                    http_response_code(500);
                    exit;
                }

                // Si hay un pago adicional (pago parcial/cuota)
                if (isset($_COOKIE["addPayment"])) {
                    $datosPago = [
                        "id_reserva" => $_COOKIE["idReserva"],
                        "monto" => $_COOKIE["pagoActual"],
                        "metodo_pago" => "Mercadopago",
                        "usuario" => "Usuario mediante link de pago"
                    ];

                    $respuestaPago = ControladorReservas::ctrRegistrarPago($datosPago);

                    if ($respuestaPago !== "ok") {
                        file_put_contents(__DIR__ . "/webhook.log", "Error al registrar el pago adicional para $codigoReserva" . PHP_EOL, FILE_APPEND);
                    } else {
                        file_put_contents(__DIR__ . "/webhook.log", "Pago adicional registrado correctamente para $codigoReserva" . PHP_EOL, FILE_APPEND);
                    }
                }

                // Enviar correo al cliente
                try {
                    $ruta = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
                    $enlaceCompletar = $ruta . "index.php?pagina=completar-datos&token=" . $codigoReserva;

                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'reservas.marinatours@gmail.com';
                    $mail->Password = 'odwy xigx wbjp jgzo'; // ⚠️ Mejor usar variable segura
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->CharSet = 'UTF-8';

                    $mail->setFrom('reservas.marinatours@gmail.com', 'Marina Tours Cartagena');
                    $mail->addAddress($correoCliente, $nombreCliente);
                    $mail->isHTML(true);
                    $mail->Subject = 'Confirmación de tu reserva #' . $codigoReserva;
                    $mail->Body = "
                        <html>
                            <head><meta charset='UTF-8'></head>
                            <body>
                                <h2>¡Gracias por tu reserva!</h2>
                                <p>Por favor completa los datos adicionales en el siguiente enlace:</p>
                                <p><a href='$enlaceCompletar'>Completar datos de la reserva</a></p>
                            </body>
                        </html>
                    ";

                    $mail->send();
                    file_put_contents(__DIR__ . "/webhook.log", "Correo enviado para reserva $codigoReserva" . PHP_EOL, FILE_APPEND);
                } catch (Exception $e) {
                    file_put_contents(__DIR__ . "/webhook.log", "Error al enviar correo: " . $mail->ErrorInfo . PHP_EOL, FILE_APPEND);
                }

                limpiarCookies(); // Esta función debe existir o puedes definirla en este archivo si lo prefieres

            } else {
                file_put_contents(__DIR__ . "/webhook.log", "Reserva $codigoReserva ya existente, se ignora creación." . PHP_EOL, FILE_APPEND);
            }

        } else {
            file_put_contents(__DIR__ . "/webhook.log", "Pago no aprobado o no encontrado: ID $paymentId" . PHP_EOL, FILE_APPEND);
        }

    } catch (Exception $e) {
        file_put_contents(__DIR__ . "/webhook.log", "Excepción: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
        http_response_code(500);
        exit;
    }
}

http_response_code(200);
echo "OK";
