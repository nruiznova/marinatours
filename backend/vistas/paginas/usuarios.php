<?php 

  // if($admin["perfil"] != "Administrador"){

  //   echo '<script>

  //     window.location = "banner";

  //   </script>';

  //   return;

  // }

 ?>

<div class="content-wrapper" style="min-height: 717px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Gestor Usuarios</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Gestor Usuarios</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
 <section class="content">

    <div class="card card-primary card-outline">

      <div class="card-header">

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Agregar usuario</button>

      </div>

      <div class="card-body">

        <table class="table table-bordered table-striped dt-responsive tablaUsuarios" width="100%">
        
          <thead>

            <tr>

              <!-- <th style="width:10px">#</th>
              <th>Foto</th> 
              <th>Nombre</th>  -->
              <th>Tipo de usuario</th> 
              <!-- <th>Reservas</th>  -->
              <th>Acciones</th>     

            </tr>   

          </thead>

          <tbody>

          <!--   <tr>
              
              <td>1</td>

              <td>
                <img src="vistas/img/usuarios/3/279.png" class="rounded-circle" width="50px">
              </td> 
              
              <td>
                Juan Fernando Urrego
              </td> 

              <td>
                correotutorialesatualcance@gmail.com
              </td>            

              <td>
                3
              </td> 

              <td>
                1
              </td> 

            </tr>  -->

          </tbody>

        </table>

      </div>

    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Agregar usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="table-responsive">

            <table class="table table-sm table-bordered">
              <tbody>
                <tr>
                  <th>Tipo de usuario</th>
                  <td colspan="2">
                    <input type="text" class="form-control" name="nombreUsuarioModal" required>
                  </td>
                </tr>                
              </tbody>
            </table>
            
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info" id="guardarUsuarioModal">Guardar</button>
        </div>

        <?php 
        
          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario(); 
        
        ?>

      </form>
    </div>
  </div>
</div>