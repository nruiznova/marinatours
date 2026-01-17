<?php 

date_default_timezone_set('America/Bogota');

// servicios

$servicios = array();

$serviciosAll = ControladorHabitaciones::ctrMostrarHabitaciones(null);

foreach ($serviciosAll as $row => $item) {
    
    if (strpos($item["estilo"], 'ISLA PALMA') !== false || strpos($item["estilo"], 'isla palma') !== false) {

        array_push($servicios, $item);

    }

}

// fecha reservas cantidad

if(isset($_GET["fecha"])){

  $fecha = $_GET["fecha"];

}else{

  $fecha = date("Y-m-d", strtotime("+1 day"));

}

// var_dump($fecha);

// fechas total reservas

if(isset($_GET["fecha_total"])){

  $fecha_total = $_GET["fecha_total"];

}else{

  // si es mañana , strtotime("+1 day")

  $fecha_total = date("Y-m-d");

}

// servicio seleccionado 

if(isset($_GET["id_s"])){ 

  if(isset($servicios[$_GET["id_s"]])){

    $id_s = $servicios[$_GET["id_s"]]["id_h"];

  }else{

    $id_s = $servicios[0]["id_h"];

  }

}else{

  $id_s = $servicios[0]["id_h"];

}

/*=============================================
Sumar ventas
=============================================*/

$sumaVentas = ControladorInicio::ctrSumarVentas($fecha_total, $id_s); 

/*=============================================
Total Reservas
=============================================*/

// var_dump($fecha);
// var_dump($id_s);

$totalReservas = ControladorReservas::ctrMostrarReservas("fecha_ingreso", $fecha);

// var_dump($totalReservas);

$reservasTotal = 0;

foreach ($totalReservas as $r => $reserva) {

  if($id_s == $reserva["id_habitacion"]){

    // EXCLUIR reservas anuladas (estado=2) y con devolución (estado=3)
    if(isset($reserva["estado"]) && ($reserva["estado"] == 2 || $reserva["estado"] == 3)){
      continue; // Saltar esta reserva
    }

    $desc = $reserva["descripcion_reserva"];

    // Usar regex para extraer el número de personas de manera más confiable
    // Formato esperado: "Nombre - Plan - X personas"
    $numPersonas = 0;
    if(preg_match('/(\d+)\s*persona/i', $desc, $matches)){
      $numPersonas = intval($matches[1]);
    }

    $reservasTotal += $numPersonas;

  }

}

/*=============================================
Total Usuarios
=============================================*/

$totalUsuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);

/*=============================================
Total Testimonios
=============================================*/

$totalTestimonios = ControladorTestimonios::ctrMostrarTestimonios(null, null);

// si existen filtros de otro recuadro agregarlos

$get_ventas = '';

if(isset($_GET["typeFilter"])){

  $get_ventas .= '&typeFilter='.$_GET["typeFilter"].'&valueFilter='.$_GET["valueFilter"];

}else{

  // Mantener valor por defecto: todos los días del mes actual
  $mesActual = date("Y-m");
  $get_ventas .= '&typeFilter=month&valueFilter='.$mesActual;

}

if(isset($_GET["fecha"])){

  $get_ventas .= '&fecha='.$_GET["fecha"];

}

if(isset($_GET["fecha_total"])){

  $get_ventas .= '&fecha_total='.$_GET["fecha_total"];

}

?>

<!--=====================================
Sumar ventas
======================================-->

<div class="col-lg-6">

  <div class="card">
    <div class="card-header">

      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
          <a href="<?php 
    
          if(isset($_GET["id_s"])){ 

            if(isset($servicios[$_GET["id_s"] - 1])){
            
              echo 'index.php?pagina=inicio-v2'.$get_ventas.'&id_s='.($_GET["id_s"] - 1).'&fecha='.$fecha;

            }else{

              echo 'index.php?pagina=inicio-v2'.$get_ventas.'&id_s=0'.'&fecha='.$fecha;

            }
          
          }else{ 
            
            echo 'index.php?pagina=inicio-v2'.$get_ventas.'&id_s=0'.'&fecha='.$fecha;
          
          } 
          
          ?>">&laquo;</a>
          </span>
        </div>
        <input type="text" class="form-control text-uppercase text-center" value="<?php 
        
        if(isset($_GET["id_s"])){

          

          if(isset($servicios[$_GET["id_s"]])){

            echo $servicios[$_GET["id_s"]]["estilo"];

          }else{

            echo $servicios[0]["estilo"];

          }                

        }else{                

          echo $servicios[0]["estilo"];

        }
        
        ?>" disabled>
        <div class="input-group-append">
          <span class="input-group-text">
          <a class="" href="<?php 
    
          if(isset($_GET["id_s"])){ 
          
            if(isset($servicios[$_GET["id_s"] + 1])){
          
              echo 'index.php?pagina=inicio-v2'.$get_ventas.'&id_s='.($_GET["id_s"] + 1).'&fecha='.$fecha;

            }else{

              echo 'index.php?pagina=inicio-v2'.$get_ventas.'&id_s=0'.'&fecha='.$fecha;

            }
          
          }else{ 
            
            echo 'index.php?pagina=inicio-v2'.$get_ventas.'&id_s=0'.'&fecha='.$fecha;
            
          } 
            
        ?>">&raquo;</a>
          </span>
        </div>
      </div>

    </div>
    <div class="card-body">
      <div class="small-box bg-primary" style="margin-bottom: 0 !important">

        <div class="inner">

          <h3><?php echo $reservasTotal; ?></h3>

          <p class="text-uppercase">Reservas</p>

        </div>

        <div class="icon">

          <i class="far fa-calendar-alt"></i>

        </div>    

      </div>
    </div>
    <div class="card-footer">

      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
          <a class="" href="index.php?pagina=inicio-v2<?php echo $get_ventas; ?>&fecha=<?php if(isset($_GET["id_s"])){ $id = $_GET["id_s"]; }else{ $id = 0; } echo date('Y-m-d', strtotime('-1 day', strtotime($fecha))).'&id_s='.$id; ?>">&laquo;</a>
          </span>
        </div>
        <input type="text" class="form-control text-center" value="<?php echo date("d-m-Y", strtotime($fecha)); ?>" disabled>
        <div class="input-group-append">
          <span class="input-group-text"><a class="" href="index.php?pagina=inicio-v2<?php echo $get_ventas; ?>&fecha=<?php if(isset($_GET["id_s"])){ $id = $_GET["id_s"]; }else{ $id = 0; } echo date('Y-m-d', strtotime('+1 day', strtotime($fecha))).'&id_s='.$id; ?>">&raquo;</a></span>
        </div>
      </div>

    </div>
  </div>  

</div>

<div class="col-lg-6">

  <div class="card">
    <div class="card-header">
    <div class="input-group" style="visibility: hidden">
        <div class="input-group-prepend">
          <span class="input-group-text"></span>
        </div>
        <input type="text" class="form-control text-uppercase text-center" value="" disabled>
        <div class="input-group-append">
          <span class="input-group-text"></span>
        </div>
      </div>
    </div>
    <div class="card-body">

      <div class="small-box bg-primary" style="margin-bottom: 0 !important">

        <div class="inner">

          <h3>$ <span><?php if($sumaVentas["total"]){ echo number_format($sumaVentas["total"], 2, ",", "."); }else{ echo '0'; } ?></span></h3> 

          <p class="text-uppercase">Ventas Totales</p>

        </div>

        <div class="icon">

          <i class="fas fa-dollar-sign"></i>

        </div>    

        </div>

    </div>
    <div class="card-footer">

      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
          <a class="" href="index.php?pagina=inicio-v2<?php echo $get_ventas; ?>&fecha_total=<?php if(isset($_GET["id_s"])){ $id = $_GET["id_s"]; }else{ $id = 0; } echo date('Y-m-d', strtotime('-1 day', strtotime($fecha_total))).'&id_s='.$id; ?>">&laquo;</a>
          </span>
        </div>
        <input type="text" class="form-control text-center" value="<?php echo date("d-m-Y", strtotime($fecha_total)); ?>" disabled>
        <div class="input-group-append">
          <span class="input-group-text"><a class="" href="index.php?pagina=inicio-v2<?php echo $get_ventas; ?>&fecha_total=<?php if(isset($_GET["id_s"])){ $id = $_GET["id_s"]; }else{ $id = 0; } echo date('Y-m-d', strtotime('+1 day', strtotime($fecha_total))).'&id_s='.$id; ?>">&raquo;</a></span>
        </div>
      </div>

    </div>
  </div>

</div>

