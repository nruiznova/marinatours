<?php 

$reservas = array();

$reservasAll = ControladorReservas::ctrMostrarReservas(null, null);

foreach ($reservasAll as $key => $value) {
    
    if (strpos($value["descripcion_reserva"], 'ISLA PALMA') !== false || strpos($value["descripcion_reserva"], 'isla palma') !== false) {

        array_push($reservas, $value);

    }

}


?>


<div class="card card-dark card-outline">

  <div class="card-header">

    <h3 class="card-title">Últimas reservas</h3>

  </div>
  <!-- /.card-header -->

  <div class="card-body p-0">
    <ul class="products-list product-list-in-card pl-2 pr-2">

      <?php foreach (limit($reservas, 5) as $key => $value): ?>

        <?php if ($value["foto"] != ""){

          $foto = $value["foto"];

        }else{

          $foto = "vistas/img/usuarios/default/default.png";

        }

        ?>

       <li class="item">
        <div class="product-img">
            <img src="vistas/img/usuarios/default/default.png" alt="Product Image" class="img-size-50 rounded-circle">
        </div>
        <div class="product-info">
          <h6 class="product-title"><?php echo $value["firstName"]." ".$value["lastName"] ?></h6>
            <span class="product-description">
              <?php echo $value["descripcion_reserva"]; ?>
            </span>
          </div>
        </li>

      <?php endforeach ?>

      </ul>
  </div>
      <!-- /.card-body -->
  <div class="card-footer text-right">
    <a href="reservas" class="btn btn-dark mt-3">Ver reservas</a>
  </div>
      <!-- /.card-footer -->
</div>