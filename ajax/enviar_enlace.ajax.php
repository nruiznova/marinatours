<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../extensiones/vendor/autoload.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/PHPMailer.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/SMTP.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/Exception.php";
require_once "../controladores/ruta.controlador.php";

// Recibir datos POST
$correoCliente = $_POST['correo'] ?? '';
$codigoReserva = $_POST['codigoReserva'] ?? '';
$nombreCliente = $_POST['nombreCliente'] ?? '';

if (!$correoCliente || !$codigoReserva || !$nombreCliente) {
    http_response_code(400);
    echo "Parámetros faltantes";
    exit;
}

$ruta = ControladorRuta::ctrRuta();
$enlaceCompletar = $ruta . "index.php?pagina=completar-datos&token=" . $codigoReserva;

// Enviar correo sin adjunto
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
    $mail->Subject = 'Datos adicionales para tu reserva #' . $codigoReserva;
    $mail->Body = '
    <html>
        <head><meta charset="UTF-8"></head>
        <body>
            <p>
                
            Estimado cliente,<br><br>
            Nombre, apellido y número de documento de identidad de los pasajeros asociados a su
            reserva.<br><br>
            Diligenciar información en el siguiente link: '.$enlaceCompletar.'<br><br>
            El requerimiento es de carácter obligatorio, ya que esta información es indispensable tanto
            para los trámites de zarpe marítimo y aprobación, como para la emisión del seguro
            asistencial diario, el cual garantiza la cobertura durante toda la operación.
            Agradecemos su comprensión y apoyo.<br><br>
            <strong>Este correo es únicamente informativo, por favor no responder a este mensaje.</strong>
                
            </p>
        </body>
    </html>';

    $mail->send();
    echo "Correo enviado con éxito.";

} catch (Exception $e) {
    http_response_code(500);
    echo "Error al enviar el correo: " . $mail->ErrorInfo;
}
