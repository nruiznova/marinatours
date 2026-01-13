<?php

session_start();

require_once "controladores/ruta.controlador.php";
require_once "controladores/habitaciones.controlador.php";
require_once "modelos/habitaciones.modelo.php";

require_once "controladores/reservas.controlador.php";
require_once "modelos/reservas.modelo.php";

require_once "modelos/conexion.php";

date_default_timezone_set('America/Bogota');

// Definir rutas necesarias
$ruta = ControladorRuta::ctrRuta();
$servidor = ControladorRuta::ctrServidor();

// Obtener fecha del parámetro GET o usar la fecha de mañana por defecto
if(isset($_GET["fecha"])){
    $fecha = $_GET["fecha"];
}else{
    $fecha = date("Y-m-d", strtotime("+1 day"));
}

// Obtener todos los servicios
$servicios = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

// Arrays para clasificar servicios
$serviciosIda = array();
$serviciosPasadia = array();
$serviciosVuelta = array();

foreach ($servicios as $servicio) {
    $nombre = strtoupper($servicio["estilo"]);
    
    if(strpos($nombre, 'TRASLADO IDA') !== false || strpos($nombre, 'IDA') !== false && strpos($nombre, 'TRASLADO') !== false){
        $serviciosIda[] = $servicio;
    }elseif(strpos($nombre, 'TRASLADO VUELTA') !== false || strpos($nombre, 'VUELTA') !== false && strpos($nombre, 'TRASLADO') !== false){
        $serviciosVuelta[] = $servicio;
    }elseif(strpos($nombre, 'PASADIA') !== false || strpos($nombre, 'PASADÍA') !== false){
        $serviciosPasadia[] = $servicio;
    }
}

// Función para calcular cupos disponibles
function calcularCuposDisponibles($servicio, $fecha){
    
    // Usar la misma validación que en info-reservas.php
    $resultado = ControladorReservas::ctrVerificarDisponibilidad($servicio["id_h"], $fecha);
    
    return array(
        'total' => isset($resultado['cupos_totales']) ? $resultado['cupos_totales'] : 0,
        'reservados' => isset($resultado['personas_reservadas']) ? $resultado['personas_reservadas'] : 0,
        'disponibles' => isset($resultado['disponibles']) ? $resultado['disponibles'] : 0
    );
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disponibilidad de Cupos - Marina Tours</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .header {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .header h1 {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 2.5rem;
        }
        
        .header p {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        
        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .date-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        
        .date-navigation .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .date-navigation .current-date {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.2rem;
            min-width: 250px;
            text-align: center;
        }
        
        .date-picker-container {
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .date-picker-container .form-control {
            border-radius: 8px;
            border: 2px solid #667eea;
            padding: 8px 15px;
            font-weight: 500;
        }
        
        .date-picker-container .form-control:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .date-picker-container .btn-primary {
            background: #667eea;
            border-color: #667eea;
            padding: 8px 20px;
            border-radius: 8px;
        }
        
        .date-picker-container .btn-primary:hover {
            background: #764ba2;
            border-color: #764ba2;
        }
        
        .services-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .service-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
        }
        
        .service-card.ida {
            border-top: 5px solid #28a745;
        }
        
        .service-card.pasadia {
            border-top: 5px solid #007bff;
        }
        
        .service-card.vuelta {
            border-top: 5px solid #ffc107;
        }
        
        .service-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .service-card.ida h3 {
            color: #28a745;
        }
        
        .service-card.pasadia h3 {
            color: #007bff;
        }
        
        .service-card.vuelta h3 {
            color: #ffc107;
        }
        
        .service-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #dee2e6;
        }
        
        .service-item.disponible {
            border-left-color: #28a745;
            background: #d4edda;
        }
        
        .service-item.limitado {
            border-left-color: #ffc107;
            background: #fff3cd;
        }
        
        .service-item.agotado {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
        
        .service-name {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
            font-size: 1rem;
        }
        
        .cupos-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        
        .cupos-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .cupos-badge.disponible {
            background: #28a745;
            color: white;
        }
        
        .cupos-badge.limitado {
            background: #ffc107;
            color: #333;
        }
        
        .cupos-badge.agotado {
            background: #dc3545;
            color: white;
        }
        
        .progress-bar-custom {
            height: 10px;
            border-radius: 5px;
            background: #e9ecef;
            overflow: hidden;
            margin-top: 10px;
        }
        
        .progress-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8rem;
            }
            
            .services-container {
                grid-template-columns: 1fr;
            }
            
            .date-navigation {
                flex-direction: column;
            }
            
            .date-navigation .current-date {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    
    <div class="main-container">
        
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-ship mr-2"></i>Disponibilidad de Cupos</h1>
            <p>Consulta en tiempo real la disponibilidad de nuestros servicios</p>
        </div>
        
        <!-- Filtro de Fecha -->
        <div class="filter-section">
            <div class="date-navigation">
                <a href="?fecha=<?php echo date('Y-m-d', strtotime($fecha . ' -1 day')); ?>" class="btn btn-outline-primary">
                    <i class="fas fa-chevron-left"></i> Día Anterior
                </a>
                
                <div class="current-date">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <?php echo date("d/m/Y", strtotime($fecha)); ?>
                </div>
                
                <a href="?fecha=<?php echo date('Y-m-d', strtotime($fecha . ' +1 day')); ?>" class="btn btn-outline-primary">
                    Día Siguiente <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            
            <!-- Selector de fecha específica -->
            <div class="date-picker-container mt-3">
                <form method="GET" action="" class="d-flex justify-content-center align-items-center gap-2">
                    <label for="fecha" class="mb-0 mr-2" style="font-weight: 600; color: #495057;">
                        <i class="fas fa-search mr-1"></i>
                        Buscar fecha:
                    </label>
                    <input 
                        type="date" 
                        id="fecha" 
                        name="fecha" 
                        class="form-control" 
                        style="max-width: 200px; display: inline-block;"
                        value="<?php echo $fecha; ?>"
                        onchange="this.form.submit()"
                    >
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Consultar
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Servicios -->
        <div class="services-container">
            
            <!-- Servicios de IDA -->
            <div class="service-card ida">
                <h3><i class="fas fa-arrow-right mr-2"></i>Servicios de Ida</h3>
                
                <?php if(count($serviciosIda) > 0): ?>
                    <?php foreach($serviciosIda as $servicio): ?>
                        <?php 
                            $cupos = calcularCuposDisponibles($servicio, $fecha);
                            $porcentaje = ($cupos['reservados'] / $cupos['total']) * 100;
                            
                            if($cupos['disponibles'] == 0){
                                $clase = 'agotado';
                                $badgeClase = 'agotado';
                            }elseif($cupos['disponibles'] <= ($cupos['total'] * 0.3)){
                                $clase = 'limitado';
                                $badgeClase = 'limitado';
                            }else{
                                $clase = 'disponible';
                                $badgeClase = 'disponible';
                            }
                        ?>
                        
                        <div class="service-item <?php echo $clase; ?>">
                            <div class="service-name">
                                <?php echo strtoupper($servicio["estilo"]); ?>
                            </div>
                            
                            <div class="cupos-info">
                                <span style="color: #6c757d;">
                                    <i class="fas fa-users mr-1"></i>
                                    <?php echo $cupos['reservados']; ?> / <?php echo $cupos['total']; ?> reservados
                                </span>
                                <span class="cupos-badge <?php echo $badgeClase; ?>">
                                    <?php echo $cupos['disponibles']; ?> disponibles
                                </span>
                            </div>
                            
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: <?php echo $porcentaje; ?>%; background: <?php echo $cupos['disponibles'] == 0 ? '#dc3545' : ($cupos['disponibles'] <= ($cupos['total'] * 0.3) ? '#ffc107' : '#28a745'); ?>;"></div>
                            </div>
                        </div>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-message">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>No hay servicios de ida disponibles</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Servicios de PASADÍA -->
            <div class="service-card pasadia">
                <h3><i class="fas fa-umbrella-beach mr-2"></i>Servicios de Pasadía</h3>
                
                <?php if(count($serviciosPasadia) > 0): ?>
                    <?php foreach($serviciosPasadia as $servicio): ?>
                        <?php 
                            $cupos = calcularCuposDisponibles($servicio, $fecha);
                            $porcentaje = ($cupos['reservados'] / $cupos['total']) * 100;
                            
                            if($cupos['disponibles'] == 0){
                                $clase = 'agotado';
                                $badgeClase = 'agotado';
                            }elseif($cupos['disponibles'] <= ($cupos['total'] * 0.3)){
                                $clase = 'limitado';
                                $badgeClase = 'limitado';
                            }else{
                                $clase = 'disponible';
                                $badgeClase = 'disponible';
                            }
                        ?>
                        
                        <div class="service-item <?php echo $clase; ?>">
                            <div class="service-name">
                                <?php echo strtoupper($servicio["estilo"]); ?>
                            </div>
                            
                            <div class="cupos-info">
                                <span style="color: #6c757d;">
                                    <i class="fas fa-users mr-1"></i>
                                    <?php echo $cupos['reservados']; ?> / <?php echo $cupos['total']; ?> reservados
                                </span>
                                <span class="cupos-badge <?php echo $badgeClase; ?>">
                                    <?php echo $cupos['disponibles']; ?> disponibles
                                </span>
                            </div>
                            
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: <?php echo $porcentaje; ?>%; background: <?php echo $cupos['disponibles'] == 0 ? '#dc3545' : ($cupos['disponibles'] <= ($cupos['total'] * 0.3) ? '#ffc107' : '#28a745'); ?>;"></div>
                            </div>
                        </div>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-message">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>No hay servicios de pasadía disponibles</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Servicios de VUELTA -->
            <div class="service-card vuelta">
                <h3><i class="fas fa-arrow-left mr-2"></i>Servicios de Vuelta</h3>
                
                <?php if(count($serviciosVuelta) > 0): ?>
                    <?php foreach($serviciosVuelta as $servicio): ?>
                        <?php 
                            $cupos = calcularCuposDisponibles($servicio, $fecha);
                            $porcentaje = ($cupos['reservados'] / $cupos['total']) * 100;
                            
                            if($cupos['disponibles'] == 0){
                                $clase = 'agotado';
                                $badgeClase = 'agotado';
                            }elseif($cupos['disponibles'] <= ($cupos['total'] * 0.3)){
                                $clase = 'limitado';
                                $badgeClase = 'limitado';
                            }else{
                                $clase = 'disponible';
                                $badgeClase = 'disponible';
                            }
                        ?>
                        
                        <div class="service-item <?php echo $clase; ?>">
                            <div class="service-name">
                                <?php echo strtoupper($servicio["estilo"]); ?>
                            </div>
                            
                            <div class="cupos-info">
                                <span style="color: #6c757d;">
                                    <i class="fas fa-users mr-1"></i>
                                    <?php echo $cupos['reservados']; ?> / <?php echo $cupos['total']; ?> reservados
                                </span>
                                <span class="cupos-badge <?php echo $badgeClase; ?>">
                                    <?php echo $cupos['disponibles']; ?> disponibles
                                </span>
                            </div>
                            
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: <?php echo $porcentaje; ?>%; background: <?php echo $cupos['disponibles'] == 0 ? '#dc3545' : ($cupos['disponibles'] <= ($cupos['total'] * 0.3) ? '#ffc107' : '#28a745'); ?>;"></div>
                            </div>
                        </div>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-message">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>No hay servicios de vuelta disponibles</p>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
        
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
