<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../extensiones/vendor/autoload.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/PHPMailer.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/SMTP.php";
require_once "../extensiones/vendor/phpmailer/phpmailer/src/Exception.php";
require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";
require_once "../controladores/ruta.controlador.php";

$reserva = ControladorReservas::ctrMostrarCodigoReserva($_POST["codigoReserva"]);

// ==== 1. Recibir parámetros ====

$correoCliente = $reserva['correo'] ?? '';
$codigoReserva = $reserva['codigo_reserva'] ?? '';
$nombreCliente = $reserva['firstName'].' '.$reserva['lastName'] ?? '';

if (!$correoCliente || !$codigoReserva || !$nombreCliente) {
    http_response_code(400);
    echo "Parámetros faltantes";
    exit;
}

$ruta = ControladorRuta::ctrRuta();

// ==== 2. Crear PDF ====

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Simular $_GET['codigo'] para reserva_pdf.php
$_GET['codigo'] = $codigoReserva; // <- aquí pasas el código de la reserva
// Capturar el HTML de la plantilla
ob_start();
include __DIR__ . '/../vistas/paginas/reserva_pdf.php'; 
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

/*$url_pdf = $ruta . "?pagina=reserva_pdf&codigo=" . $codigoReserva;
$dompdf->loadHtml(file_get_contents($url_pdf));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();*/

// ==== 3. Guardar PDF temporal ====

$carpetaDestino = __DIR__ . '/../extensiones';
if (!file_exists($carpetaDestino)) {
    mkdir($carpetaDestino, 0777, true);
}

$nombrePDF = 'reserva_' . $codigoReserva . '.pdf';
$rutaPDF = $carpetaDestino . '/' . $nombrePDF;
file_put_contents($rutaPDF, $dompdf->output());

// ==== 4. Enviar correo con PHPMailer ====

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'reservas.marinatours@gmail.com';
    $mail->Password = 'odwy xigx wbjp jgzo'; // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('reservas.marinatours@gmail.com', 'Hotel Isla Palma');
    $mail->addAddress($correoCliente, $nombreCliente);

    if (file_exists($rutaPDF)) {
        $mail->addAttachment($rutaPDF, $nombrePDF);
    }

    $mail->isHTML(true);
    $mail->Subject = 'Confirmación de tu reserva #' . $codigoReserva;
    $mail->Body = '
    <html>
        <head><meta charset="UTF-8"></head>
        <body>
           <p>
           <strong>Estimado cliente,</strong><br><br>
           <h2>Gracias por reservar con Hotel Isla Palma – Reserva Natural</h2>

            <p>Nos complace informarle que la empresa <strong>Marina Tour Cartagena</strong> será la encargada de realizar su transporte correspondiente al servicio <strong>'.$reserva["descripcion_reserva"].'</strong>, programado para el <strong>'.$reserva["fecha_ingreso"].'</strong>.</p>

            <p>Por favor, lea detenidamente la siguiente información para garantizar una experiencia segura, puntual y sin contratiempos.</p>

            <h3>DETALLES COMPLETOS SEGÚN EL SERVICIO CONTRATADO</h3>

            <h4>PASADÍA ISLA PALMA</h4>
            <ul>
                <li><strong>Recogida en hotel:</strong> Aplica para las zonas de <b>Bocagrande, El Laguito, Castillo Grande y Marbella</b>, a partir de las <b>5:30 a.m.</b> Por favor, permanezca en la recepción o lobby desde esa hora. El guía podrá esperar máximo <b>5 minutos.</b> Cualquier inconveniente en la recogida comuníquese de inmediato al <b>+57 322 577 1081.</b></li>
                <li><strong>Si su alojamiento está fuera de esas zonas:</strong> Preséntese directamente en el <b>Muelle La Bodeguita – Puerta 1</b>, a más tardar a las <b>5:45 a.m.</b></li>
                <li><strong>Regreso:</strong> El retorno desde <b>Isla Palma</b> se realiza entre las <b>2:00 p.m.</b> y <b>2:20 p.m.</b> desde el muelle del <b>Hotel Isla Palma – Reserva Natural.</b> De no estar en el horario indicado corre por su cuenta el regreso.</li>
            </ul>

            <p><strong>Incluye:</strong></p>
            <ul>
                <li>Transporte marítimo ida y regreso.</li>
                <li>Almuerzo tipo buffet (carne, pollo o pescado + ensalada + jugo + postre típico)</li>
                <li>Uso de las instalaciones del Hotel Isla Palma – Reserva Natural.</li>
                <li>Seguro de viaje, guía acompañante y snack de frutas</li>
            </ul>

            <p><strong>No incluye:</strong></p>
            <ul>
                <li>Tasa portuaria ($29.000 COP por persona).</li>
                <li>Uso de toallas.</li>
                <li>Entrada al bioparque.</li>
                <li>Traslado de regreso al hotel.</li>
            </ul>

            <h4>PASADÍA ISLA MÚCURA – TINTIPÁN – ISLOTE</h4>
            <ul>
                <li><strong>Recogida en hotel:</strong> Aplica para las zonas de <b>Bocagrande, El Laguito, Castillo Grande y Marbella</b>, desde las <b>5:30 a.m.</b> Por favor, permanezca en la recepción o lobby desde esa hora. El guía podrá esperar máximo <b>5 minutos.</b> Cualquier inconveniente en la recogida comuníquese de inmediato al <b>+57 322 577 1081.</b></li>
                <li><strong>Si su alojamiento se encuentra en otra zona:</strong> Deberá presentarse en el <b>Muelle La Bodeguita – Puerta 1</b> a las <b>5:45 a.m.</b></li>
                <li><strong>Regreso:</strong> La lancha de retorno parte desde el muelle público de <b>Isla Múcura</b>, entre las <b>1:30 p.m.</b> y <b>1:50 p.m.</b>, con llegada estimada a Cartagena entre <b>4:30 p.m.</b> y <b>5:00 p.m.</b> De no estar en el horario indicado corre por su cuenta el regreso.</li>
            </ul>

            <p><strong>Incluye:</strong></p>
            <ul>
                <li>Transporte marítimo ida y regreso.</li>
                <li>Almuerzo típico.</li>
                <li>Seguro de viaje, guía acompañante y snack de frutas.</li>
            </ul>

            <p><strong>No incluye:</strong></p>
            <ul>
                <li>Tasa portuaria ($29.000 COP por persona).</li>
                <li>Entrada al islote.</li>
                <li>Carpas y sillas.</li>
                <li>Traslado de regreso al hotel.</li>
            </ul>

            <h4>TRASLADOS DE IDA (Isla Palma, Isla Múcura o Isla Tintipán)</h4>
            <ul>
                <li><strong>Recogida en hotel:</strong> No aplica. Todos los pasajeros deben presentarse directamente en el <b>Muelle La Bodeguita – Puerta 1</b> a las <b>6:00 a.m.</b> para el registro y embarque.</li>
                <li><strong>Duración del trayecto marítimo:</strong> Entre 1 hora y 30 minutos a 2 horas, aproximadamente dependiendo de las condiciones climáticas.</li>
            </ul>

            <p><strong>Incluye:</strong></p>
            <ul>
                <li>Seguro de viaje, guía acompañante y snack de frutas.</li>
            </ul>

            <p><strong>No incluye:</strong></p>
            <ul>
                <li>Tasa portuaria ($29.000 COP por persona).</li>
                <li>Equipaje adicional (límite máximo permitido: 8 kg por persona).</li>
            </ul>

            <p><strong>Importante:</strong> Si se excede el peso de equipaje permitido, debe informarse con anticipación y pagar el costo adicional correspondiente.</p>

            <h4>TRASLADOS DE REGRESO (Isla Palma, Isla Múcura o Isla Tintipán)</h4>
            <p><strong>Encuentro:</strong></p>
            <ul>
                <li><strong>Isla Palma:</strong> El punto de encuentro es el muelle principal del <b>Hotel Isla Palma – Reserva Natural.</b> La salida hacia Cartagena se realiza entre las <b>2:00 p.m.</b> y <b>2:20 p.m.</b>, con llegada estimada entre <b>4:30 p.m.</b> y <b>5:00 p.m.</b></li>
                <li><strong>Isla Múcura:</strong> El punto de encuentro es el muelle público de <b>Isla Múcura.</b> El embarque inicia entre las <b>1:30 p.m.</b> y <b>1:50 p.m.</b></li>
                <li><strong>Isla Tintipán:</strong> El punto de encuentro es el muelle público de <b>Isla Tintipán</b>, donde el embarque se realiza entre las <b>1:30 p.m.</b> y <b>1:50 p.m.</b></li>
            </ul>

            <p><strong>Incluye:</strong></p>
            <ul>
                <li>Seguro de viaje y guía acompañante.</li>
            </ul>

            <p><strong>No incluye:</strong></p>
            <ul>
                <li>Equipaje adicional (límite máximo permitido: 8 kg por persona).</li>
            </ul>

            <h4>PAGOS Y TASAS</h4>
            <ul>
                <li>La tasa portuaria de $29.000 COP por persona no está incluida. Se paga directamente en el muelle antes del embarque.</li>
                <li>Si su reserva tiene saldo pendiente, podrá cancelarlo en nuestro punto de atención del muelle.</li>
                <li><strong>Formas de pago aceptadas:</strong></li>
                <ul>
                <li>Efectivo.</li>
                <li>Tarjeta débito/crédito mediante link de pago (aplica recargo del 5% sobre el valor total).</li>
                </ul>
            </ul>

            <h4>RECOMENDACIONES GENERALES</h4>
            <ul>
                <li>Llevar ropa cómoda, traje de baño, bloqueador solar y zapatillas de playa.</li>
                <li>Presentar el código QR o confirmación de reserva (en físico o digital) al ingresar al muelle.</li>
                <li>Llegar con suficiente antelación para el proceso de registro y embarque.</li>
                <li>Niños menores de 4 años no pagan traslado y deben viajar en las piernas de su representante. Desde los 5 años, pagan tarifa completa.</li>
                <li>Recomendamos no programar vuelos con salida antes de las <b>7:00 p.m.</b>, ya que los horarios marítimos pueden verse afectados por las condiciones del mar o del clima.</li>
            </ul>

            <h4>CONTACTO Y ASISTENCIA</h4>
            <p>Para cualquier duda o coordinación adicional, puede comunicarse con nosotros:</p>
            <ul>
                <li>+57 304 375 2759</li>
                <li>+57 302 320 0353</li>
            </ul>

            <p>Gracias por confiar en nosotros.<br><br><strong>Hotel Isla Palma – Reserva Natural</strong> y <strong>Marina Tour Cartagena</strong> le desean una experiencia inolvidable en el Caribe colombiano.</p>

            <p><em>(Este correo es únicamente informativo; por favor, no responder directamente a este mensaje.)</em></p>

























        </body>
    </html>';

    if ($mail->send()) {
        unlink($rutaPDF); // Eliminar PDF temporal

        // Eliminar cookies relacionadas a la reserva
        $cookies = [
            "idHabitacion", "id_user", "imgHabitacion", "infoHabitacion", "pagoReserva",
            "codigoReserva", "fechaIngreso", "fechaSalida", "firstName", "lastName",
            "tipo_identificacion", "numero_identificacion", "celular", "correo", "hospedaje",
            "abono", "cuotas", "montoPagar", "valorCuotas", "pagoCuotas"
        ];

        foreach ($cookies as $cookieName) {
            setcookie($cookieName, "", time() - 3600, $ruta);
            setcookie($cookieName, "", time() - 3600, "/");
        }
    } else {
        echo "ok";
    }

} catch (Exception $e) {
    http_response_code(500);
    echo "Error al enviar el correo: " . $mail->ErrorInfo;
} finally {
    if (file_exists($rutaPDF)) unlink($rutaPDF);
}
