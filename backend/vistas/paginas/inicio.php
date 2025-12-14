<?php 

  // if($admin["perfil"] != "Administrador"){

  //   echo '<script>

  //     window.location = "banner";

  //   </script>';

  //   return;

  // }

 ?>

 <div class="content-wrapper" style="min-height: 717px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Analíticas generales</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Analíticas generales</li>

          </ol>

        </div>

      </div>

      <div class="row mt-3">
        <div class="col-12">
          <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalAjustarCupos">
            <i class="fas fa-calendar-check mr-2"></i>Ajustar cupos disponibles por fecha
          </a>
        </div>
      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content pb-5">

    <div class="container-fluid">

      <div class="row">

        <?php 

        include "modulos/top.php";

        ?>        

        <div class="col-12">

          <?php 

            include "modulos/ventas.php";

          ?>
          
        </div>

        <div class="col-8">

          <?php 

            include "modulos/calendario.php";

          ?>
          
        </div>

        <div class="col-4">

          <div class="col-12 d-none">

            <?php 

              include "modulos/ultimosUsuarios.php";

            ?>

          </div>

          <div class="col-12">

            <?php 

              include "modulos/ultimasReservas.php";

            ?>

          </div>
          
        </div>

      </div>     
      
    </div>

  </section>
  <!-- /.content -->
</div>

<!-- Modal Ajustar Cupos -->
<div class="modal fade" id="modalAjustarCupos" tabindex="-1" role="dialog" aria-labelledby="modalAjustarCuposLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="modalAjustarCuposLabel">Ajustar cupos disponibles por fecha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tbody>
                  <tr>
                    <th style="width: 50%">Servicios</th>
                    <td colspan="2">
                      <select class="form-control" id="servicioCuposModal">

                            <option value="">-- Seleccione --</option>

                            <?php
                            
                              $servicios = ControladorHabitaciones::ctrMostrarHabitaciones(null);

                              $servicios_enlazados = [];

                              foreach ($servicios as $key => $value) {
                                
                                $enlazados = $value["serviciosEnlazados"];

                                $enlazados .= ";".$value["id_h"];

                                $enlazados_arr = explode(";", $enlazados);

                                sort($enlazados_arr);

                                $enlazados_str = implode(";", $enlazados_arr);

                                array_push($servicios_enlazados, $enlazados_str);

                              }         
                              
                              $agrupaciones = array_unique($servicios_enlazados);

                              $new_array = array_values($agrupaciones);
                              
                              // recorrer agrupaciones
                              
                              for ($i=0; $i < count($new_array); $i++) { 

                                  $items = explode(";", $new_array[$i]);

                                  // recorrer servicios

                                  $desc = '';

                                  for ($j=0; $j < count($items); $j++) { 
                                    
                                    $item = ControladorHabitaciones::ctrMostrarHabitaciones($items[$j]);  
                                  
                                    $desc .= strtoupper($item["estilo"])." / ";

                                  } 
                                  
                                  echo '<option value="'.$new_array[$i].'">'.$desc.'</option>';

                              }                                                            
                            
                            ?>

                        </select>
                    </td>
                  </tr>
                  <tr>
                    <th>Fecha</th>
                    <td >
                        <input type="date" class="form-control" id="fechaCuposModal" placeholder="">
                    </td>
                    <td>
                      <button type="button" class="btn btn-outline-secondary btn-block" id="consultarCuposModal">
                        <i class="fas fa-search mr-2"></i> Consultar
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <th>Cupos</th>
                    <td colspan="2">
                        <input type="number" class="form-control" id="cuposModal" placeholder="Ingrese número de cupos" min="0" step="1">
                    </td>
                  </tr>
                </tbody>
            </table>
            <div class="alert alert-light border" role="alert" id="responseCuposModal" style="display:none;">
              
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="submitCuposModal">Guardar</button>
      </div>
    </div>
  </div>
</div>