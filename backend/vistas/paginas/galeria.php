<div class="content-wrapper" style="min-height: 717px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Galeria</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Galeria</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

            <?php if(!isset($_GET["idGaleria"])): ?>

            <div class="card">

                <div class="card-header">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Agregar sección de galeria</button>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>Sección</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 

                                    $galerias = ModeloAdministradores::mdlMostrarAdministradores("galeria", null, null);

                                    foreach ($galerias as $key => $value) {

                                      if($key == 0){

                                        echo'<tr>
                                        
                                        <td>'.$value["nombre"].'</td>
                                        <td>

                                            <button type="button" class="btn btn-info editarGaleria" idGaleria="'.$value["id_galeria"].'"><i class="fas fa-edit"></i></button>                                            
                                        
                                        </td>
                                        
                                        <tr>';

                                      }else{

                                        echo'<tr>
                                        
                                        <td>'.$value["nombre"].'</td>
                                        <td>

                                            <button type="button" class="btn btn-info editarGaleria" idGaleria="'.$value["id_galeria"].'"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger borrarGaleria" idGaleria="'.$value["id_galeria"].'"><i class="fas fa-trash"></i></button>
                                        
                                        </td>
                                        
                                        <tr>';

                                      }                                                                                

                                    }
                                
                                ?>
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>   
            
            <?php else: ?>

            <div class="card rounded-lg card-secondary card-outline">

                <?php 

                    $gallery = ModeloUsuarios::mdlMostrarUsuarios("galeria", "id_galeria", $_GET["idGaleria"]);
                
                    $galeria = json_decode($gallery["galeria"], true);
                
                ?>
                
                <div class="card-header pl-2 pl-sm-3">

                    <h5>Sección: </h5>
                        
                    <input type="text" class="form-control" value="<?php echo $gallery["nombre"]; ?>" id="nombreGaleria" style="width: 40%">     
                    <input type="hidden" id="idGaleria" value="<?php echo $_GET["idGaleria"]; ?>">               

                </div>                

                <div class="card-body">  

                    <ul class="row p-0 vistaGaleria">

                    <?php 

                    // if($habitacion != null){

                        // $galeria = json_decode($habitacion["galeria"], true);

                        foreach ($galeria as $key => $value) {

                            if (strpos($value, 'mp4') !== false) {

                                echo'<li class="col-12 col-md-6 col-lg-3 card px-3 rounded-0 shadow-none">
							
                                        <video loop muted autoplay>
                                            <source src="'.$value.'" type="video/mp4">								
                                            Your browser does not support the video tag.
                                        </video>
                
                                        <div class="card-img-overlay p-0 pr-3">
                                            
                                            <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNueva" temporal="'.$value.'">
                                                
                                                <i class="fas fa-times"></i>
                
                                            </button>
                
                                        </div>
                
                                    </li>';

                            }else{

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

                    // }

                    ?>
                    
                    
                    </ul>

                </div>                

                <input type="hidden" class="inputNuevaGaleria">               

                <input type="hidden" class="inputAntiguaGaleria" value="<?php echo implode(",", $galeria); ?>">                             

                <div class="card-footer">
                    
                    <input type="file" multiple id="galeria" class="d-none">

                    <label for="galeria" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleria">

                        Haz clic aquí o arrastra las imágenes <br>
                        <span class="help-block small">Formato: JPG, PNG o MP4</span>
                        
                    </label>

                    <div class="preload"></div>
              
                    <div class="card-tools float-right">
                    
                        <button type="button" class="btn btn-info btn-sm" id="guardarGaleria">
                        
                        <i class="fas fa-save"></i>
                        
                        </button>

                    </div>

                </div>

            </div>

            <?php endif; ?>

        </div>

      </div>

    </div>

  </section>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar sección de galeria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
            <label for="nombreSeccion">Nombre de la nueva sección</label>
            <input type="email" class="form-control" id="nombreSeccion">
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="crearNuevaSeccion">Guardar</button>
      </div>
    </div>
  </div>
</div>