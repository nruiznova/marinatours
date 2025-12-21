<?php 

$reservas = ControladorReservas::ctrMostrarReservas(null, null);

?>

<style>
  .reservation-item {
    border-left: 4px solid #343a40;
    transition: all 0.3s ease;
  }
  .reservation-item:hover {
    border-left-color: #007bff;
    background-color: #f8f9fa;
  }
  .reservation-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
  }
  .badge-agency {
    background-color: #17a2b8;
    color: white;
  }
  .badge-time {
    background-color: #6c757d;
    color: white;
  }
  .badge-date {
    background-color: #28a745;
    color: white;
  }
  .reservation-meta {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 8px;
  }
</style>

<div class="card card-dark card-outline">

  <div class="card-header">

    <h3 class="card-title">Últimas reservas</h3>

  </div>
  <!-- /.card-header -->

  <div class="card-body p-0">
    <ul class="products-list product-list-in-card pl-2 pr-2">

      <?php foreach (limit($reservas, 5) as $key => $value): ?>

        <?php 
        
        // Formatear fecha y hora
        $fechaReserva = date("d/m/Y", strtotime($value["fecha_reserva"]));
        $horaReserva = date("h:i A", strtotime($value["fecha_reserva"]));
        $nombreAgencia = $value["id_usuario"];
        
        ?>

       <li class="item reservation-item">
        <div class="product-img">
            <img src="vistas/img/usuarios/default/default.png" alt="Product Image" class="img-size-50 rounded-circle">
        </div>
        <div class="product-info">
          <h6 class="product-title mb-1"><?php echo $value["firstName"]." ".$value["lastName"] ?></h6>
          <span class="product-description d-block mb-2">
            <?php echo $value["descripcion_reserva"]; ?>
          </span>
          <div class="reservation-meta">
            <span class="reservation-badge badge-date">
              <i class="far fa-calendar"></i> <?php echo $fechaReserva; ?>
            </span>
            <span class="reservation-badge badge-time">
              <i class="far fa-clock"></i> <?php echo $horaReserva; ?>
            </span>
            <span class="reservation-badge badge-agency">
              <i class="fas fa-building"></i> <?php echo $nombreAgencia; ?>
            </span>
          </div>
        </div>
       </li>

      <?php endforeach ?>

      </ul>
  </div>
      <!-- /.card-body -->
  <div class="card-footer text-right">
    <a href="reservas" class="btn btn-dark mt-3">
      <i class="fas fa-list"></i> Ver todas las reservas
    </a>
  </div>
      <!-- /.card-footer -->
</div>