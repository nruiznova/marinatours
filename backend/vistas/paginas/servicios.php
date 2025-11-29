<div class="content-wrapper" style="min-height: 717px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Servicios</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Servicios</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <!--=====================================
        Listado de habitaciones
        ======================================-->

        <div class="col-12 col-xl-5">

           <div class="card card-primary card-outline">
             
            <!-- header-card -->

            <div class="card-header pl-2 pl-sm-3">
          
              <a href="servicios" class="btn btn-primary btn-sm">Agregar nuevo servicio</a>
              <br><a href="#" class="btn btn-secondary btn-sm mt-1" data-toggle="modal" data-target="#modalAjustarCupos">Ajustar cupos disponibles por fecha</a>

              <div class="card-tools">
                
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>

              </div>      

            </div>

            <!-- body-card -->

            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive tablaHabitaciones" width="100%">
                
                <thead>

                  <tr>

                    <th style="width:10px">#</th> 
                    <th>Categoría</th>
                    <th>Habitación</th>
                    <th style="width:10px">Acciones</th>          

                  </tr>   

                </thead>

                <tbody>
                  
                 <!--  <tr>
                    
                    <td>1</td>
                    <td>Suite</td>
                    <td>Oriental</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">
                        <i class="far fa-eye"></i>
                      </button>
                    </td> 

                  </tr> -->

                </tbody>

              </table>

            </div>

           </div>
          
        </div>

        <!--=====================================
        Editor de habitaciones
        ======================================-->


        <?php

        if(isset($_GET["id_h"])){

          $habitacion = ControladorHabitaciones::ctrMostrarhabitaciones($_GET["id_h"]);

          $caracteristicas = json_decode($habitacion["caracteristicas"], true);

          $itinerario = json_decode($habitacion["itinerario"], true);

        }else{

          $habitacion = null;

        }


        ?>

        <div class="col-12 col-xl-7">

          <div class="card card-primary card-outline">
            
            <!-- header-card -->

            <div class="card-header">

              <h5  class="card-title"><?php if($habitacion != null){ echo $habitacion["tipo"]; ?> / <?php echo $habitacion["estilo"]; } ?></h5>

              <div class="preload"></div>
  
              <div class="card-tools">
            
                <button type="button" class="btn btn-info btn-sm guardarHabitacion">
                  
                  <i class="fas fa-save"></i>
                
                </button>

                <?php 

                  if($habitacion != null){

                    $galeria = json_decode($habitacion["galeria"], true);

                    echo '<button type="button" class="btn btn-danger btn-sm eliminarHabitacion" idEliminar="'.$habitacion["id_h"].'" galeriaHabitacion="'.implode(",", $galeria).'">
                  
                          <i class="fas fa-trash"></i> 

                        </button>';

                  }

                ?>
              </div>

            </div>

            <!-- card-body -->

            <div class="card-body">

              <?php if($habitacion != null): ?>

                <input type="hidden" class="idHabitacion" value="<?php echo $habitacion["id_h"]?>">

              <?php else: ?>

                <input type="hidden" class="idHabitacion" value="">

              <?php endif ?>
              
              <!-- Categoría y nombre de la habitación -->

              <div class="d-flex flex-column flex-md-row justify-content-start mb-3">
                
                <div class="form-inline mx-3 px-3 border border-left-0 border-top-0 border-bottom-0">
                  
                  <p class="mr-sm-2">Elije la Categoría:</p>

                   <?php 

                    if($habitacion != null){

                       echo '<select class="form-control seleccionarTipo" readonly>
                        
                        <option value="'.$habitacion["id"].','.$habitacion["tipo"].'">'.$habitacion["tipo"].'</option>

                       </select>';

                    }else{

                       echo '<select class="form-control seleccionarTipo">

                         <option value="">Seleccione</option>';

                         $categorias = ControladorCategorias::ctrMostrarCategorias(null, null);

                         foreach ($categorias as $key => $value) {
                        
                          echo '<option value="'.$value["id"].','.$value["tipo"].'">'.$value["tipo"].'</option>';
                        
                        }

                       echo '</select>';    

                    }

                  ?>

                </div>

                <div class="form-inline">
                  
                   <p class="mr-sm-2">Escribe el nombre del servicio:</p>

                   <?php 

                    if($habitacion != null){

                      echo '<input type="text" class="form-control seleccionarEstilo" value="'.$habitacion["estilo"].'" readonly>';
                    
                    }else{

                      echo '<input type="text" class="form-control seleccionarEstilo">';

                    }

                  ?>             

                </div>

              </div>

              <!-- detalles -->

              <div class="card rounded-lg card-secondary card-outline">
                
                <div class="card-header pl-2 pl-sm-3">

                  <h5>Detalles:</h5>

                  <div class="card-tools">
                
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>

                  </div> 

                </div>

                <div class="card-body">

                  <!-- url de acceso -->

                  <div class="input-group mb-3">
            
                    <div class="input-group-append input-group-text">
                      <span class="fas fa-list-ul"></span>
                    </div>

                    <input type="text" class="form-control rutaCategoria" name="rutaCategoria" placeholder="Ruta servicio" required value="<?php if($habitacion != null){ echo $habitacion["ruta"]; } ?>" readonly>

                  </div>  
                  
                  <!-- cupos disponibles -->

                  <div class="row">

                  <div class="form-group col-lg-4">
                      <label for="inputCity">Cupos disponibles</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fas fa-users"></i></div>
                        </div>
                        <input type="number" class="form-control cuposServicio" id="" placeholder="0" value="<?php if($habitacion != null){ echo $habitacion["cupos"]; } ?>">
                      </div>
                  </div>

                  <div class="form-group col-lg-8">
                      <label for="inputCity">Enlazar cupos con otro servicio</label>
                      <div class="input-group">
                        <!-- <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fas fa-users"></i></div>
                        </div> -->
                        <select class="select2 serviciosEnlazados" multiple="multiple" data-placeholder="--Seleccione--" style="width: 100%;">
                            <!-- <option value="0">Ninguno</option> -->
                            <?php 
                            
                              $servicios = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

                              if($habitacion != null){
                                $enlazados = explode(";", $habitacion["serviciosEnlazados"]);
                              }

                              foreach ($servicios as $key => $value) {

                                if($value["id_h"] != $habitacion["id_h"]){
                                
                                  if($enlazados){
                                    if (($key = array_search($value["id_h"], $enlazados)) !== false) {
                                      echo '<option value="'.$value["id_h"].'" selected>'.$value["estilo"].'</option>';
                                    }else{
                                      echo '<option value="'.$value["id_h"].'">'.$value["estilo"].'</option>';
                                    }
                                  }else{
                                    echo '<option value="'.$value["id_h"].'">'.$value["estilo"].'</option>';
                                  }

                                }

                              }
                            
                            ?>
                        </select>
                      </div>
                  </div>

                  </div>

                  <!-- precio -->

                  <hr>

                  <label class="mb-3" for="descpcion">Visibilidad y precio</label> 

                  <?php 
                  
                  if($habitacion != null){

                    $precio = json_decode($habitacion["precio"], true);

                    $newPrices = array();

                    foreach ($precio as $p => $price) {
                      $newPrices[$price["usuario"]] = array("visibilidad" => $price["visibilidad"],
                                                            "precio" => $price["precio"],
                                                            "precioKids" => $price["precioKids"],
                                                            "credito" => $price["credito"],
                                                            "abono" => $price["abono"]);
                    }

                  }                  

                  // var_dump($newArray["Público en general"]["visibilidad"]);
                  
                  ?> 
                  
                  <input type="hidden" class="precioServicio" value="<?php if($habitacion != null){ echo $habitacion["precio"]; }?>">

                  <!-- establecer precios por usuarios -->

                  <?php 
                  
                  $usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);

                  foreach ($usuarios as $u => $user):

                    error_reporting(0);

                    // var_dump($newPrices[$user["nombre"]]["abono"]);
                  
                  ?>

                  <div class="form-row">                  
                    <div class="form-group col-md-3">
                      <?php if($u == 0){ echo '<label for="number">Tipo de usuario</label>'; } ?>
                      <input type="text" class="form-control priceUser" value="<?php echo $user["nombre"]; ?>" disabled>
                    </div>
                    <div class="form-group col-md-2 text-center">
                      <?php if($u == 0){ echo '<label for="">Visible?</label><br>'; } ?>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input priceVisible" id="" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $newPrices[$user["nombre"]]["visibilidad"] == "true"){ echo'checked'; } }?>>
                        <!-- <label class="form-check-label" for="">Check me out</label> -->
                      </div>
                    </div>
                    <div class="form-group col-md">
                      <?php if($u == 0){ echo '<label for="">Precio adultos</label>'; } ?>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">$</div> 
                        </div>
                        <input type="number" class="form-control priceValue" id="" value="<?php if($habitacion != null){ if($habitacion["precio"] != '' && $newPrices[$user["nombre"]]["visibilidad"] == "true"){ echo $newPrices[$user["nombre"]]["precio"]; } }?>" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $newPrices[$user["nombre"]]["visibilidad"] != "true"){ echo 'readonly'; } }else{ echo 'readonly'; }?>>
                      </div>
                    </div>
                    <div class="form-group col-md">
                      <?php if($u == 0){ echo '<label for="">Precio niños</label>'; } ?>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">$</div>
                        </div>
                        <input type="number" class="form-control priceValueKids" id="" value="<?php if($habitacion != null){ if($habitacion["precio"] != '' && $newPrices[$user["nombre"]]["visibilidad"] == "true"){ echo $newPrices[$user["nombre"]]["precioKids"]; } }?>" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $newPrices[$user["nombre"]]["visibilidad"] != "true"){ echo 'readonly'; } }else{ echo 'readonly'; }?>>
                      </div>
                    </div>
                    <div class="form-group col-md-1 text-center">
                      <?php if($u == 0){ echo '<label for="">Crédito?</label>'; } ?>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input priceCredit" id="" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $newPrices[$user["nombre"]]["credito"] == "true"){ echo'checked'; } }?>>
                        <!-- <label class="form-check-label" for="">Check me out</label> -->
                      </div>
                    </div>
                    <div class="form-group col-md-1 text-center">
                      <?php if($u == 0){ echo '<label for="">Abono 50%?</label>'; } ?>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input priceAbono" id="" <?php if($habitacion != null){ if($habitacion["precio"] != '' && $newPrices[$user["nombre"]]["abono"] == "true"){ echo'checked'; } }?>>
                        <!-- <label class="form-check-label" for="">Check me out</label> -->
                      </div>
                    </div>
                  </div>

                  <?php endforeach; ?>

                  <hr>

                  <!-- banner -->

                  <div class="form-group col-sm-12">

                  <label for="">Banner principal</label>

                  <ul class="row p-0 vistaBanner">

                  <?php 
                  
                  if($habitacion != null){

                    // var_dump($habitacion["banner"]);

                    if(strpos($habitacion["banner"], "mp4") !== false){ 
                      
                      echo'<li class="col-12 col-md-6 col-lg-12 card px-3 rounded-0 shadow-none">
						  
                            <video loop muted autoplay>
                              <source src="'.substr($habitacion["banner"], 3).'" type="video/mp4">								
                              Your browser does not support the video tag.
                            </video>
                
                            <div class="card-img-overlay p-0 pr-3">
                              
                              <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNuevaBanner" temporal>
                              
                              <i class="fas fa-times"></i>
                
                              </button>
                
                            </div>
                
                          </li>';

                    }else{

                      echo'<li class="col-12 col-md-6 col-lg-12 card px-3 rounded-0 shadow-none">
						  
                        <img class="card-img-top" src="'.substr($habitacion["banner"], 3).'">
            
                        <div class="card-img-overlay p-0 pr-3">
                          
                          <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNuevaBanner" temporal>
                          
                          <i class="fas fa-times"></i>
            
                          </button>
            
                        </div>
            
                      </li>';

                    }

                  }
                  
                  ?> 

                  </ul>   
                  
                  </div>

                  <input type="hidden" class="bannerServicio">
                  
                  <input type="file" id="banner" class="d-none">

                  <label for="banner" class="text-dark text-center py-5 border rounded bg-white w-100 subirbanner">

                     Haz clic aquí o arrastra la imágen o video <br>
                     <span class="help-block small">Puede cargar una imágen o un video</span>
                     
                  </label>                                  

                  <hr>
                  
                  <!-- caracteristicas principales -->

                  <label class="mb-3" for="descpcion">Caracteristicas principales</label>   
                  
                  <input type="hidden" id="caracteristicas">

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <label for="number">#</label>
                      <input type="text" class="form-control" id="number" value="1." disabled>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="feature_icon">Icono</label>
                        <select class="form-control feature_icon fonticons" id="feature_icon">
                          <?php 
                            if($habitacion != null){ 
                              echo '<option value="'.$caracteristicas[0]["icono"].'"></option>'; 
                            } 
                          ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="feature_title">Título</label>
                      <input type="text" class="form-control feature_title" id="feature_title" value="<?php if($habitacion != null){ echo $caracteristicas[0]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="feature_description">Descripción</label>
                      <input type="text" class="form-control feature_description" id="feature_description" value="<?php if($habitacion != null){ echo $caracteristicas[0]["descripcion"]; } ?>">
                    </div>
                  </div>                
                  
                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="number">#</label> -->
                      <input type="text" class="form-control" id="number" value="2." disabled>
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="feature_icon">Icono</label> -->
                      <select class="form-control feature_icon fonticons" id="feature_icon">
                        <?php 
                            if($habitacion != null){ 
                              echo '<option value="'.$caracteristicas[1]["icono"].'"></option>'; 
                            } 
                          ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="feature_title">Titulo</label> -->
                      <input type="text" class="form-control feature_title" id="feature_title" value="<?php if($habitacion != null){ echo $caracteristicas[1]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="feature_description">Titulo</label> -->
                      <input type="text" class="form-control feature_description" id="feature_description" value="<?php if($habitacion != null){ echo $caracteristicas[1]["descripcion"]; } ?>">
                    </div>
                  </div> 

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="number">#</label> -->
                      <input type="text" class="form-control" id="number" value="3." disabled>
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="feature_icon">Icono</label> -->
                      <select class="form-control feature_icon fonticons" id="feature_icon">
                        <?php 
                            if($habitacion != null){ 
                              echo '<option value="'.$caracteristicas[2]["icono"].'"></option>'; 
                            } 
                          ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="feature_title">Titulo</label> -->
                      <input type="text" class="form-control feature_title" id="feature_title" value="<?php if($habitacion != null){ echo $caracteristicas[2]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="feature_description">Titulo</label> -->
                      <input type="text" class="form-control feature_description" id="feature_description" value="<?php if($habitacion != null){ echo $caracteristicas[2]["descripcion"]; } ?>">
                    </div>
                  </div> 

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="number">#</label> -->
                      <input type="text" class="form-control" id="number" value="4." disabled>
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="feature_icon">Icono</label> -->
                      <select class="form-control feature_icon fonticons" id="feature_icon">
                        <?php 
                            if($habitacion != null){ 
                              echo '<option value="'.$caracteristicas[3]["icono"].'"></option>'; 
                            } 
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="feature_title">Titulo</label> -->
                      <input type="text" class="form-control feature_title" id="feature_title" value="<?php if($habitacion != null){ echo $caracteristicas[3]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="feature_description">Titulo</label> -->
                      <input type="text" class="form-control feature_description" id="feature_description" value="<?php if($habitacion != null){ echo $caracteristicas[3]["descripcion"]; } ?>">
                    </div>
                  </div> 

                  <!-- descripción -->

                  <hr>
                  <div class="form-group">
                    <label for="descripcion">Descripción general</label>
                    <textarea class="form-control descripcionServicio" id="descripcion" rows="3"><?php if($habitacion != null){ echo $habitacion["descripcion_h"]; } ?></textarea>
                  </div>

                  <!-- detalles adicionales -->

                  <hr>
                  <label class="mb-3" for="">Detalles adicionales</label> 

                  <div class="form-group row">
                    <label for="lugarSalida" class="col-sm-3 col-form-label">Punto de partida / retorno</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control lugarSalida" id="lugarSalida" value="<?php if($habitacion != null){ echo $habitacion["lugarSalida"]; } ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="horaSalida" class="col-sm-3 col-form-label">Hora de salida</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control horaSalida" id="horaSalida" value="<?php if($habitacion != null){ echo $habitacion["horaSalida"]; } ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="incluye" class="col-sm-3 col-form-label">Incluye</label>
                    <div class="col-sm-9">
                      <div class="input-group mb-2">                        
                        <input type="text" class="form-control incluye" id="incluye" placeholder="Ej: Almuerzo, Coctel, etc">
                        <input type="hidden" id="allIncludes">
                        <div class="input-group-addon">
                          <div class="input-group-text btn bg-success" id="addInclude">+</div>
                        </div>
                      </div>
                      
                      <!-- includes -->

                      <?php

                        if($habitacion != null){
                        
                          $includes = explode(";", $habitacion["incluye"]);

                          foreach ($includes as $key => $value) {
                            
                            echo'<div class="input-group"><div class="input-group-prepend"><div class="input-group-text">-</div></div><input type="text" class="form-control tempInclude" id="" value="'.$value.'"><div class="input-group-addon"><div class="input-group-text bg-danger btn deleteInclude">-</div></div></div>';

                          }

                        }
                      
                      ?>
                      
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="noIncluye" class="col-sm-3 col-form-label">No incluye</label>
                    <div class="col-sm-9">
                      <div class="input-group mb-2">                        
                        <input type="text" class="form-control noIncluye" id="noIncluye" placeholder="Ej: Lit snorkeling">
                        <input type="hidden" id="allNoIncludes">
                        <div class="input-group-addon">
                          <div class="input-group-text btn bg-success" id="addNoInclude">+</div>
                        </div>
                      </div> 
                      
                      <!-- includes -->
                       
                      <?php

                        if($habitacion != null){
                        
                          $includes = explode(";", $habitacion["noIncluye"]);

                          foreach ($includes as $key => $value) {
                            
                            echo'<div class="input-group"><div class="input-group-prepend"><div class="input-group-text">-</div></div><input type="text" class="form-control tempNoInclude" id="" value="'.$value.'"><div class="input-group-addon"><div class="input-group-text bg-danger btn deleteInclude">-</div></div></div>';

                          }

                        }
                      
                      ?>

                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="recomendaciones" class="col-sm-3 col-form-label">Recomendaciones</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="recomendaciones" value="<?php if($habitacion != null){ echo $habitacion["recomendaciones"]; } ?>">
                    </div>
                  </div>

                </div>

              </div>

              <!-- itinerario -->

              <div class="card rounded-lg card-secondary card-outline">
                
                <div class="card-header pl-2 pl-sm-3">

                  <h5>Itinerario:</h5>

                  <div class="card-tools">
                
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>

                  </div> 

                </div>

                <div class="card-body">
                  
                  <!-- caracteristicas principales -->

                  <!-- <label class="mb-3" for="descpcion">Caracteristicas principales</label>                   -->

                  <input type="hidden" id="itinerario">

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <label for="numberItineario">#</label>
                      <input type="text" class="form-control numberItineario" id="numberItineario" value="1." disabled>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="hora_itinerario_item_1">Hora</label>
                      <input type="time" class="form-control" id="hora_itinerario_item_1" value="<?php if($habitacion != null){ echo $itinerario[0]["hora"]; } ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="titulo_itinerario_item_1">Título</label>
                      <input type="text" class="form-control" id="titulo_itinerario_item_1" value="<?php if($habitacion != null){ echo $itinerario[0]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="desc_itinerario_item_1">Descripción</label>
                      <input type="text" class="form-control" id="desc_itinerario_item_1" value="<?php if($habitacion != null){ echo $itinerario[0]["descripcion"]; } ?>">
                    </div>
                    <!-- <div class="form-group col-md-1">
                      <label for="btn_itinerario_item_1">Acción</label>
                      <button type="button" class="btn btn-danger" id="btn_itinerario_item_1"><i class="fas fa-minus"></i></button>
                    </div> -->
                  </div> 

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="numberItineario">#</label> -->
                      <input type="text" class="form-control numberItineario" id="numberItineario" value="2." disabled>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="hora_itinerario_item_2">Hora</label> -->
                      <input type="time" class="form-control" id="hora_itinerario_item_2" value="<?php if($habitacion != null){ echo $itinerario[1]["hora"]; } ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="titulo_itinerario_item_2">Título</label> -->
                      <input type="text" class="form-control" id="titulo_itinerario_item_2" value="<?php if($habitacion != null){ echo $itinerario[1]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="desc_itinerario_item_2">Descripción</label> -->
                      <input type="text" class="form-control" id="desc_itinerario_item_2" value="<?php if($habitacion != null){ echo $itinerario[1]["descripcion"]; } ?>">
                    </div>
                    <!-- <div class="form-group col-md-1">
                      <label for="btn_itinerario_item_2">Acción</label>
                      <button type="button" class="btn btn-danger" id="btn_itinerario_item_2"><i class="fas fa-minus"></i></button>
                    </div> -->
                  </div> 

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="numberItineario">#</label> -->
                      <input type="text" class="form-control numberItineario" id="numberItineario" value="3." disabled>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="hora_itinerario_item_3">Hora</label> -->
                      <input type="time" class="form-control" id="hora_itinerario_item_3" value="<?php if($habitacion != null){ echo $itinerario[2]["hora"]; } ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="titulo_itinerario_item_3">Título</label> -->
                      <input type="text" class="form-control" id="titulo_itinerario_item_3" value="<?php if($habitacion != null){ echo $itinerario[2]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="desc_itinerario_item_3">Descripción</label> -->
                      <input type="text" class="form-control" id="desc_itinerario_item_3" value="<?php if($habitacion != null){ echo $itinerario[2]["descripcion"]; } ?>">
                    </div>
                    <!-- <div class="form-group col-md-1">
                      <label for="btn_itinerario_item_3">Acción</label>
                      <button type="button" class="btn btn-danger" id="btn_itinerario_item_3"><i class="fas fa-minus"></i></button>
                    </div> -->
                  </div> 

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="numberItineario">#</label> -->
                      <input type="text" class="form-control numberItineario" id="numberItineario" value="4." disabled>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="hora_itinerario_item_4">Hora</label> -->
                      <input type="time" class="form-control" id="hora_itinerario_item_4" value="<?php if($habitacion != null){ echo $itinerario[3]["hora"]; } ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="titulo_itinerario_item_4">Título</label> -->
                      <input type="text" class="form-control" id="titulo_itinerario_item_4" value="<?php if($habitacion != null){ echo $itinerario[3]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="desc_itinerario_item_4">Descripción</label> -->
                      <input type="text" class="form-control" id="desc_itinerario_item_4" value="<?php if($habitacion != null){ echo $itinerario[3]["descripcion"]; } ?>">
                    </div>
                    <!-- <div class="form-group col-md-1">
                      <label for="btn_itinerario_item_4">Acción</label>
                      <button type="button" class="btn btn-danger" id="btn_itinerario_item_4"><i class="fas fa-minus"></i></button>
                    </div> -->
                  </div> 

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="numberItineario">#</label> -->
                      <input type="text" class="form-control numberItineario" id="numberItineario" value="5." disabled>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="hora_itinerario_item_5">Hora</label> -->
                      <input type="time" class="form-control" id="hora_itinerario_item_5" value="<?php if($habitacion != null){ echo $itinerario[4]["hora"]; } ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="titulo_itinerario_item_5">Título</label> -->
                      <input type="text" class="form-control" id="titulo_itinerario_item_5" value="<?php if($habitacion != null){ echo $itinerario[4]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="desc_itinerario_item_5">Descripción</label> -->
                      <input type="text" class="form-control" id="desc_itinerario_item_5" value="<?php if($habitacion != null){ echo $itinerario[4]["descripcion"]; } ?>">
                    </div>
                    <!-- <div class="form-group col-md-1">
                      <label for="btn_itinerario_item_5">Acción</label>
                      <button type="button" class="btn btn-danger" id="btn_itinerario_item_5"><i class="fas fa-minus"></i></button>
                    </div> -->
                  </div> 

                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="numberItineario">#</label> -->
                      <input type="text" class="form-control numberItineario" id="numberItineario" value="6." disabled>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="hora_itinerario_item_6">Hora</label> -->
                      <input type="time" class="form-control" id="hora_itinerario_item_6" value="<?php if($habitacion != null){ echo $itinerario[5]["hora"]; } ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="titulo_itinerario_item_6">Título</label> -->
                      <input type="text" class="form-control" id="titulo_itinerario_item_6" value="<?php if($habitacion != null){ echo $itinerario[5]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="desc_itinerario_item_6">Descripción</label> -->
                      <input type="text" class="form-control" id="desc_itinerario_item_6" value="<?php if($habitacion != null){ echo $itinerario[5]["descripcion"]; } ?>">
                    </div>
                    <!-- <div class="form-group col-md-1">
                      <label for="btn_itinerario_item_6">Acción</label>
                      <button type="button" class="btn btn-danger" id="btn_itinerario_item_6"><i class="fas fa-minus"></i></button>
                    </div> -->
                  </div>
                  
                  <div class="form-row">                  
                    <div class="form-group col-md-1">
                      <!-- <label for="numberItineario">#</label> -->
                      <input type="text" class="form-control numberItineario" id="numberItineario" value="7." disabled>
                    </div>
                    <div class="form-group col-md-3">
                      <!-- <label for="hora_itinerario_item_7">Hora</label> -->
                      <input type="time" class="form-control" id="hora_itinerario_item_7" value="<?php if($habitacion != null){ echo $itinerario[6]["hora"]; } ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <!-- <label for="titulo_itinerario_item_7">Título</label> -->
                      <input type="text" class="form-control" id="titulo_itinerario_item_7" value="<?php if($habitacion != null){ echo $itinerario[6]["titulo"]; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                      <!-- <label for="desc_itinerario_item_7">Descripción</label> -->
                      <input type="text" class="form-control" id="desc_itinerario_item_7" value="<?php if($habitacion != null){ echo $itinerario[6]["descripcion"]; } ?>">
                    </div>
                    <!-- <div class="form-group col-md-1">
                      <label for="btn_itinerario_item_7">Acción</label>
                      <button type="button" class="btn btn-danger" id="btn_itinerario_item_7"><i class="fas fa-minus"></i></button>
                    </div> -->
                  </div> 

                </div>

              </div>
              
              <!-- Galería -->

              <div class="card rounded-lg card-secondary card-outline">
                
                <div class="card-header pl-2 pl-sm-3">

                  <h5>Galería:</h5>

                </div>

                <div class="card-body">  

                  <ul class="row p-0 vistaGaleria">

                    <?php 

                    if($habitacion != null){

                      $galeria = json_decode($habitacion["galeria"], true);

                      foreach ($galeria as $key => $value) {

                        echo '<li class="col-12 col-md-6 col-lg-3 card px-3 rounded-0 shadow-none">
                      
                                <img class="card-img-top" src="'.$value.'">

                                <div class="card-img-overlay p-0 pr-3">
                                  
                                   <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoAntigua" temporal="'.$value.'">
                                     
                                     <i class="fas fa-times"></i>

                                   </button>

                                </div>

                              </li>';

                      }

                    }

                   ?>
                    
                  
                  </ul>

                </div>

                <input type="hidden" class="inputNuevaGaleria">

                <?php if($habitacion != null): ?>

                <input type="hidden" class="inputAntiguaGaleria" value="<?php echo implode(",", $galeria); ?>">

                <?php else: ?>

                <input type="hidden" class="inputAntiguaGaleria" value="">

                <?php endif ?>                

                <div class="card-footer">
                  
                  <input type="file" multiple id="galeria" class="d-none">

                  <label for="galeria" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleria">

                     Haz clic aquí o arrastra las imágenes <br>
                     <span class="help-block small">Formato: JPG o PNG</span>
                     
                  </label>

                </div>

              </div>

            </div>

            <!-- footer-card -->

            <div class="card-footer">

              <div class="preload"></div>
              
              <div class="card-tools float-right">
            
                <button type="button" class="btn btn-info btn-sm guardarHabitacion">
                  
                  <i class="fas fa-save"></i>
                
                </button>

                <?php 

                  if($habitacion != null){

                    $galeria = json_decode($habitacion["galeria"], true);

                    echo '<button type="button" class="btn btn-danger btn-sm eliminarHabitacion" idEliminar="'.$habitacion["id_h"].'" galeriaHabitacion="'.implode(",", $galeria).'">
                  
                          <i class="fas fa-trash"></i> 

                        </button>';

                  }

                 ?>

               

              </div>

            </div>

          </div>
          
        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->

</div>

<!-- Modal -->
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
                      <!-- <div class="form-group"> -->
                        <!-- <label for="exampleFormControlSelect1">Example select</label> -->
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

                              // var_dump($new_array);         
                              
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
                      <!-- </div> -->
                    </td>
                  </tr>
                  <tr>
                    <th>Fecha</th>
                    <td >
                      <!-- <div class="form-group"> -->
                        <!-- <label for="exampleInputPassword1">Password</label> -->
                        <input type="date" class="form-control" id="fechaCuposModal" placeholder="">
                      <!-- </div> -->
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
                      <!-- <div class="form-group"> -->
                        <!-- <label for="test">Password</label> -->
                        <input type="number" class="form-control" id="cuposModal" placeholder="">
                      <!-- </div> -->
                    </td>
                  </tr>
                </tbody>
            </table>
            <div class="alert alert-secondary" role="alert" id="responseCuposModal">
              
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