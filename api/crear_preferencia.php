<?php
require_once __DIR__ . '/../extensiones/vendor/autoload.php';
require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

// Establece tu Access Token real aquí
$accessToken = "APP_USR-1198270120630556-051516-34b830bb27d6a5120df88c6dabd7a187-1673855193"; // ⚠️ Reemplaza con el verdadero

if ($accessToken === "APP_USR-..." || str_contains($accessToken, "...")) {
    http_response_code(500);
    echo json_encode(["error" => "Access Token no configurado correctamente."]);
    exit;
}

SDK::setAccessToken($accessToken);

// Obtener los datos enviados desde JS
$input = json_decode(file_get_contents("php://input"), true);
$monto = floatval($input['montoPagar'] ?? 0);
$codigoReserva = $_COOKIE['codigoReserva'] ?? 'reserva_' . uniqid();

if ($monto <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Monto inválido para procesar el pago."]);
    exit;
}
$datosTemporales = ModeloReservas::mdlObtenerDatosTemporales($codigoReserva);
if($datosTemporales){
    $tx = $datosTemporales['numero_transaccion'] ?? null;
    $transactionState = $datosTemporales['transactionState'] ?? null;
    ModeloReservas::mdlBorrarReservaTemporal($codigoReserva);
}
//💾 Guardar reserva temporal en la base de datos
$reservaTemporal = [
    "id_habitacion"         => $input["id_habitacion"] ?? null,
    "id_usuario"            => $input["id_usuario"] ?? null,
    "pago_reserva"          => $input["pago_reserva"] ?? null,
    "numero_transaccion"    => $input["numero_transaccion"] ?? null,
    "codigo_reserva"        => $codigoReserva,
    "descripcion_reserva"   => $input["descripcion_reserva"] ?? null,
    "fecha_ingreso"         => $input["fecha_ingreso"] ?? null,
    "fecha_salida"          => $input["fecha_salida"] ?? null,
    "acompañantes"          => $input["acompañantes"] ?? null,
    "firstName"             => $input["firstName"] ?? null,
    "lastName"              => $input["lastName"] ?? null,
    "tipo_identificacion"   => $input["tipo_identificacion"] ?? null,
    "numero_identificacion" => $input["numero_identificacion"] ?? null,
    "celular"               => $input["celular"] ?? null,
    "correo"                => $input["correo"] ?? null,
    "hospedaje"             => $input["hospedaje"] ?? null,
    "abono"                 => (is_numeric($input["abono"] ?? null) ? $input["abono"] : 0),
    "cuotas"                => $input["cuotas"] ?? null,
    "montoPagar"            => $input["montoPagar"] ?? null,
    "valorCuotas"           => $input["valorCuotas"] ?? null,
    "pagoCuotas"            => $input["pagoCuotas"] ?? null,
    'numero_transaccion'    => $tx ?? null,
    'transactionState'      => $transactionState ?? null,
];

$respuesta = ControladorReservas::ctrGuardarReservaTemporal($reservaTemporal);

if ($respuesta === "error") {
    http_response_code(500);
    echo json_encode(["error" => "Error al guardar la reserva temporal."]);
    exit;
}

// ⚙️ Crear preferencia de pago
try {
    $preference = new Preference();

    $item = new Item();
    $item->title = "Reserva Marina Tours";
    $item->quantity = 1;
    $item->unit_price = $monto;

    $preference->items = [$item];
    $preference->notification_url = "https://marinatourscartagena.com.co/api/notificacion.php";
    $preference->external_reference = $codigoReserva;

    $preference->back_urls = [
        "success" => "https://marinatourscartagena.com.co/index.php?pagina=exito",
        "failure" => "https://marinatourscartagena.com.co/index.php?pagina=pendiente",
        "pending" => "https://marinatourscartagena.com.co/index.php?pagina=fallo"
    ];
    $preference->auto_return = "approved";

    $preference->save();

    if (!isset($preference->id) || empty($preference->id)) {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo generar el ID de la preferencia."]);
        exit;
    }

    echo json_encode(['preference_id' => $preference->id]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Excepción al crear la preferencia.", "detalle" => $e->getMessage()]);
    exit;
}
