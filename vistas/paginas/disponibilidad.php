<?php

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

<style>
    .main-container-disponibilidad {
        max-width: 1400px;
        margin: 50px auto;
        padding: 0 15px;
    }
    
    .header-disponibilidad {
        background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        border: 2px solid #d6bd8d;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(214, 189, 141, 0.3);
        text-align: center;
    }
    
    .header-disponibilidad h1 {
        color: #d6bd8d;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 2.5rem;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    
    .header-disponibilidad p {
        color: #ffffff;
        font-size: 1.1rem;
        margin-bottom: 0;
    }
    
    .filter-section {
        background: #ffffff;
        border: 2px solid #d6bd8d;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .date-navigation {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .date-navigation .btn {
        border-radius: 5px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .date-navigation .btn-outline-primary {
        background: #000000;
        border: 2px solid #d6bd8d;
        color: #d6bd8d;
    }
    
    .date-navigation .btn-outline-primary:hover {
        background: #d6bd8d;
        border-color: #d6bd8d;
        color: #000000;
    }
    
    .date-navigation .current-date {
        background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        border: 2px solid #d6bd8d;
        color: #d6bd8d;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 700;
        font-size: 1.2rem;
        min-width: 250px;
        text-align: center;
    }
    
    .date-picker-container {
        padding-top: 20px;
        border-top: 2px solid #d6bd8d;
        margin-top: 20px;
    }
    
    .date-picker-container label {
        color: #000000;
        font-weight: 600;
    }
    
    .date-picker-container .form-control {
        border-radius: 5px;
        border: 2px solid #d6bd8d;
        padding: 10px 15px;
        font-weight: 500;
    }
    
    .date-picker-container .form-control:focus {
        border-color: #000000;
        box-shadow: 0 0 0 0.2rem rgba(214, 189, 141, 0.25);
    }
    
    .date-picker-container .btn-primary {
        background: #000000;
        border: 2px solid #d6bd8d;
        color: #d6bd8d;
        padding: 10px 25px;
        border-radius: 5px;
        font-weight: 600;
    }
    
    .date-picker-container .btn-primary:hover {
        background: #d6bd8d;
        border-color: #d6bd8d;
        color: #000000;
    }
    
    .services-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .service-card {
        background: #ffffff;
        border: 2px solid #d6bd8d;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(214, 189, 141, 0.4);
    }
    
    .service-card h3 {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
        padding-bottom: 15px;
        border-bottom: 2px solid #d6bd8d;
        text-transform: uppercase;
        letter-spacing: 1px;
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
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 4px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .service-item:hover {
        transform: translateX(5px);
    }
    
    .service-item.disponible {
        border-left-color: #28a745;
        background: linear-gradient(to right, #d4edda 0%, #f8f9fa 100%);
    }
    
    .service-item.limitado {
        border-left-color: #ffc107;
        background: linear-gradient(to right, #fff3cd 0%, #f8f9fa 100%);
    }
    
    .service-item.agotado {
        border-left-color: #dc3545;
        background: linear-gradient(to right, #f8d7da 0%, #f8f9fa 100%);
    }
    
    .service-name {
        font-weight: 600;
        color: #000000;
        margin-bottom: 10px;
        font-size: 1rem;
    }
    
    .cupos-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .cupos-badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .cupos-badge.disponible {
        background: #28a745;
        color: white;
    }
    
    .cupos-badge.limitado {
        background: #ffc107;
        color: #000000;
    }
    
    .cupos-badge.agotado {
        background: #dc3545;
        color: white;
    }
    
    .progress-bar-custom {
        height: 12px;
        border-radius: 6px;
        background: #e9ecef;
        overflow: hidden;
        margin-top: 10px;
        border: 1px solid #dee2e6;
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
        .header-disponibilidad h1 {
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
        
        .cupos-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="main-container-disponibilidad">
    
    <!-- Header -->
    <div class="header-disponibilidad">
        <h1><i class="fas fa-ship mr-2"></i>Disponibilidad de Cupos</h1>
        <p>Consulta en tiempo real la disponibilidad de nuestros servicios</p>
    </div>
    
    <!-- Filtro de Fecha -->
    <div class="filter-section">
        <div class="date-navigation">
            <a href="<?php echo $ruta; ?>disponibilidad?fecha=<?php echo date('Y-m-d', strtotime($fecha . ' -1 day')); ?>" class="btn btn-outline-primary">
                <i class="fas fa-chevron-left"></i> Día Anterior
            </a>
            
            <div class="current-date">
                <i class="far fa-calendar-alt mr-2"></i>
                <?php echo date("d/m/Y", strtotime($fecha)); ?>
            </div>
            
            <a href="<?php echo $ruta; ?>disponibilidad?fecha=<?php echo date('Y-m-d', strtotime($fecha . ' +1 day')); ?>" class="btn btn-outline-primary">
                Día Siguiente <i class="fas fa-chevron-right"></i>
            </a>
        </div>
        
        <!-- Selector de fecha específica -->
        <div class="date-picker-container mt-3">
            <form method="GET" action="<?php echo $ruta; ?>disponibilidad" class="d-flex justify-content-center align-items-center gap-2">
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
                        $porcentaje = $cupos['total'] > 0 ? ($cupos['reservados'] / $cupos['total']) * 100 : 0;
                        
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
                        $porcentaje = $cupos['total'] > 0 ? ($cupos['reservados'] / $cupos['total']) * 100 : 0;
                        
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
                        $porcentaje = $cupos['total'] > 0 ? ($cupos['reservados'] / $cupos['total']) * 100 : 0;
                        
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
