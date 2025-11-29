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

          <h1>Administradores</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Administradores</li>

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

          <!-- Default box -->
          <div class="card card-info card-outline">

            <div class="card-header">

              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearAdministrador">Crear nuevo administrador</button>

              <!-- <div class="card-header"> -->

              <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modalBloquearFechas">Bloquear fechas</a>
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                    </li> -->
                  </ul>
                </div>

            <!-- </div> -->

            </div>
            <!-- /.card-header -->

            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive tablaAdministradores" width="100%">
                
                <thead>
                  
                  <tr>
                    
                    <th style="width:10px">#</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                    <th>Acciones</th>

                  </tr>

                </thead>

                <tbody>
                  
                 <!--  <tr>
                    
                    <td>1</td>
                    <td>Heaven Tours</td>
                    <td>portobelo</td>
                    <td>Administrador</td>
                    <td><button class="btn btn-info btn-sm">Activo</button></td>
                    <td>

                      <div class='btn-group'>
                      
                        <button class="btn btn-warning btn-sm">
                          <i class="fas fa-pencil-alt text-white"></i>
                        </button>  

                        <button class="btn btn-danger btn-sm">
                          <i class="fas fa-trash-alt"></i>
                        </button> 

                      </div> 

                    </td>

                  </tr> -->

                </tbody>

              </table>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
       
            </div>
            <!-- /.card-footer-->

          </div>
          <!-- /.card -->

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->

</div>


<!--=====================================
Modal Crear Administrador
======================================-->

<div class="modal" id="crearAdministrador">

  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post">
      
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Crear Administrador</h4>

           <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          <!-- input nombre -->
          
          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-user"></span>

            </div>

            <input type="text" class="form-control" name="registroNombre" placeholder="Ingresa el nombre" required>   

          </div>

          <!-- input usuario -->

          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-user-lock"></span>

            </div>

            <input type="text" class="form-control" name="registroUsuario" placeholder="Ingresa el usuario" required>   

          </div>

          <!-- input password -->

          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-lock"></span>

            </div>

            <input type="password" class="form-control" name="registroPassword" placeholder="Ingresa la contraseña" required>   

          </div>

           <!-- seleccionar el perfil -->

          <input type="hidden" name="registroPerfil" value="Admin">

          <div class="input-group mb-3 d-none">

            <div class="input-group-append input-group-text">
              
              <span class="fas fa-key"></span>
            
            </div>             

            <select class="form-control" name="">

              <option value="">Seleccione perfil</option>

              <option value="Administrador">Administrador</option>

              <option value="Editor">Editor</option>

            </select>     

          </div>

          <input type="hidden" name="listaPermisos" id="listaPermisos">

          <div class="table-responsive">

            <table class="table table-sm table-bordered text-center">

              <thead class="">
                <tr>
                  <th class="pb-4">Módulo</th>
                  <th>Mostrar
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input checkAllVis" type="checkbox"> 
                      <!-- <label class="form-check-label">Todos</label>                     -->
                    </div>
                  </th>
                  <th>Editar
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input checkAllEdit" type="checkbox">   
                      <!-- <label class="form-check-label">Todos</label>                   -->
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="inicio" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="inicio-v2" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="administradores" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="banner" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="categorias" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="servicios" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="reservas" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="testimonios" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="usuarios" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="galeria" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>
                
              </tbody>

            </table>

          </div>

           <?php 

             $registroAdministrador = new ControladorAdministradores();
             $registroAdministrador -> ctrRegistroAdministrador();

           ?>

        </div>

        <div class="modal-footer d-flex justify-content-between">
          
          <div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>

          <div>
             <button type="submit" class="btn btn-primary">Guardar</button>
          </div>

        </div>

      </form>

    </div>

  </div>

</div>

<!--=====================================
Modal Editar Administrador
======================================-->

<div class="modal" id="editarAdministrador">

  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post">
      
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Editar Administrador</h4>

           <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          <input type="hidden" name="editarId">

          <!-- input nombre -->
          
          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-user"></span>

            </div>

            <input type="text" class="form-control" name="editarNombre" value required>   

          </div>

          <!-- input usuario -->

          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-user-lock"></span>

            </div>

            <input type="text" class="form-control" name="editarUsuario" value required>   

          </div>

          <!-- input password -->

          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-lock"></span>

            </div>

            <input type="password" class="form-control" name="editarPassword" placeholder="Cambie la contraseña"> 
            <input type="hidden" name="passwordActual">     

          </div>

           <!-- seleccionar el perfil -->

          <div class="input-group mb-3 d-none">

            <div class="input-group-append input-group-text">
              
              <span class="fas fa-key"></span>
            
            </div>

            <select class="form-control" name="editarPerfil">

              <option class="editarPerfilOption"></option>

              <option value="">Seleccione perfil</option>

              <option value="Administrador">Administrador</option>

              <option value="Editor">Editor</option>

            </select>     

          </div>

          <!-- permisos -->

          <input type="hidden" name="listaPermisosEditar" id="listaPermisosEditar">

          <div class="table-responsive">

            <table class="table table-sm table-bordered text-center">

              <thead class="">
                <tr>
                  <th class="pb-4">Módulo</th>
                  <th>Mostrar
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input checkAllVis" type="checkbox"> 
                      <!-- <label class="form-check-label">Todos</label>                     -->
                    </div>
                  </th>
                  <th>Editar
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input checkAllEdit" type="checkbox">   
                      <!-- <label class="form-check-label">Todos</label>                   -->
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="inicio" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="inicio-v2" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="administradores" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="banner" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="categorias" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="servicios" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="reservas" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="testimonios" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="usuarios" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="text" class="form-control form-control-sm permissionMod" value="galeria" disabled style="width: 50%">
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input visibleMod" type="checkbox">                     
                    </div>
                  </td>
                  <td>
                    <div class="form-check" style="padding-left: 0">
                      <input class="form-check-input editableMod" type="checkbox">                      
                    </div>
                  </td>
                </tr>
                
              </tbody>

            </table>

          </div>

           <?php 

             $editarAdministrador = new ControladorAdministradores();
             $editarAdministrador -> ctrEditarAdministrador();

           ?>

        </div>

        <div class="modal-footer d-flex justify-content-between">
          
          <div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>

          <div>
             <button type="submit" class="btn btn-primary">Guardar</button>
          </div>

        </div>

      </form>

    </div>

  </div>

</div>


<!--=====================================
Modal bloquear fechas
======================================-->

<div class="modal" id="modalBloquearFechas">

  <div class="modal-dialog">

    <div class="modal-content">

    <form method="post" id="formBloquearFechas">

     <!-- Modal Header -->
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Bloquear fechas: <span class="small"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

       <!-- Modal body -->
      <div class="modal-body">                 

      <table class="table">
        <thead>
          <tr>
            <th>Fecha inicial</th>
            <th>Fecha final</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php 

            $fechas = ModeloCategorias::mdlMostrarCategorias("fechas_bloqueadas", null, null);

            foreach ($fechas as $key => $value) {
              
              echo'<tr>
            
                <td>'.$value["fecha_inicial"].'</td>
                <td>'.$value["fecha_final"].'</td>
                <td>
                
                  <button type="button" class="btn btn-sm btn-info editRange" idRango="'.$value["id"].'" fechaInicial="'.date("m-d-Y", strtotime($value["fecha_inicial"])).'" fechaFinal="'.date("m-d-Y", strtotime($value["fecha_final"])).'"><i class="fas fa-pencil-alt"></i></button>
                  <button type="button" class="btn btn-sm btn-danger delRange" idRango="'.$value["id"].'"><i class="fas fa-trash"></i></button>
                
                </td>

            <tr> ';

            }            
      
          ?>

          <tr>
            
            <!-- <td><i class="fas fa-plus"></i></td> -->
            <!-- <td></td> -->
            <td colspan="3">

              <button type="button" class="btn btn-default addRange"> Bloquear nuevo rango de fechas</button>
            
            </td>
          
          </tr>

        </tbody>
      </table>    
      
      <div class="form-group" id="seleccionar-rango" style="display: none; margin-left: 15px">
        
        <label id="tilte-action"></label>

        <div class="input-group">
          <button type="button" class="btn btn-default float-right" id="daterange-btn">
            <i class="far fa-calendar-alt"></i> Seleccione un rango de fechas <i class="fas fa-caret-down"></i>
          </button>
        </div>
      </div>

      <input type="hidden" name="typeAction" id="typeAction" value="add">
      <input type="hidden" name="idRango" id="idRango">
      <input type="hidden" name="fecha_inicial" id="fecha_inicial">
      <input type="hidden" name="fecha_final" id="fecha_final">

      </div>

       <!-- Modal footer -->
      <div class="modal-footer d-flex justify-content-between">  

        <div>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>

        <div>
          <button type="submit" class="btn btn-primary bloquearFechas" id="bloquearFechas" >Guardar</button>
        </div>

      </div>

        <?php

            $bloquearFechas = new ControladorReservas();
            $bloquearFechas -> ctrBloquearFechas();

        ?>

    </form>

    </div> 

  </div>

</div>