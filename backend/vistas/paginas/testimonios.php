<?php 

if(isset($_GET["not"])){

  $respuesta = ControladorInicio::ctrActualizarNotificaciones("testimonios", 0);

}

?>

<div class="content-wrapper" style="min-height: 717px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Gestor Testimonios</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Gestor Testimonios</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
 <section class="content">

    <div class="card card-primary card-outline">

      <div class="card-body">

        <table class="table table-bordered table-striped dt-responsive tablaTestimonios" width="100%">
         
          <thead>

            <tr>

              <th style="width:10px">#</th>
              <th>Nombre</th>
              <th>Pais</th>               
              <th>Testimonio</th> 
              <th>Estado</th>
              <th style="width:80px">Fecha</th>     

            </tr>   

          </thead>

          <tbody>

           <!--  <tr>
              
              <td>1</td>

              <td>
                ZLMAOP6C0
              </td> 

              <td>
                Juan Fernando Urrego
              </td>           

              <td>
                Habitación Suite Oriental - Plan Americano - 2 personas
              </td>            

              <td>
                Fue una experiencia maravillosa
              </td> 

              <td>
                <button class="btn btn-dark btn-sm">Aprobar</button>
              </td> 

              <td>
                2019-05-14 19:35:52
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