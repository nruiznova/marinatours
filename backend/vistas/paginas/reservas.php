<?php

  if (strtolower($admin["perfil"]) != "administrador" && strtolower($admin["perfil"]) != "admin") {
     echo '<script>window.location = "banner";</script>';
     return;
  }

  if(isset($_GET["not"])){
    $respuesta = ControladorInicio::ctrActualizarNotificaciones("reservas", 0);
  }
 ?>

 <div class="content-wrapper" style="min-height: 717px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Reservas</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Reservas</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->
  </section>

  <!--=====================================
  Módulo de gráfico de ventas
  ======================================-->

  <?php 

    // include "modulos/ventas.php";
    
  ?>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

          <!-- Default box -->
          <div class="card card-info card-outline">      
            
            <div class="card-header">

                <button type="button" class="btn btn-outline-secondary" id="descargarReservas"><i class="fas fa-file-archive mr-2"></i> Descargar reservas</button>

            </div>

            <div class="card-body">

                <!-- filtros -->

                <label>Selecciona la información que deseas ver</label>

                <div class="row">
                  <div class="col-lg-3">
                    <select class="form-control" id="filterBy">
                      <option>--Seleccione--</option>
                      <option value="reservas">Reservas</option>
                      <option value="beneficiarios">Beneficiarios</option>                      
                    </select>
                  </div>
                                     
                </div>

                <div class="mt-3" id="filtrosOpt1" style="display:none;">

                  <label>Filtrar por ...</label>

                  <div class="row">
                    <div class="col-lg-3">
                      <select class="form-control searchBy">
                        <option>--Seleccione--</option>
                        <option value="hospedaje">Hotel recogida</option>
                        <option value="firstName">Nombres</option>
                        <option value="lastName">Apellidos</option>
                        <option value="descripcion_reserva">Servicio</option>
                        <option value="id_usuario">Vendedor</option>
                        <option value="fecha_ingreso">Fecha</option>
                      </select>
                    </div>
                    <div class="col-lg-3">
                      <!-- <label></label> -->
                      <div class="input-group mb-3">                      
                        <input type="text" class="form-control valueSearch">
                        <div class="input-group-append">
                          <span class="input-group-text btn btn-info searchBtn" table="1"><i class="fas fa-search"></i></span>
                        </div>
                      </div>
                    </div>                   
                  </div> 

                </div>

                <div class="mt-3" id="filtrosOpt2" style="display:none;">

                  <label>Seleccione la fecha</label>

                  <div class="row">
                    <div>
                      <input type="hidden" class="searchBy" value="fecha_ingreso">
                    </div>
                    <div class="col-lg-3">                      
                      <div class="input-group mb-3">                      
                        <input type="text" class="form-control valueSearch">
                        <div class="input-group-append">
                          <span class="input-group-text btn btn-info searchBtn" table="2"><i class="fas fa-search"></i></span>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>

                <hr>

                <div class="table-responsive" id="containertable1" style="display:none">

                  <table class="table table-bordered table-striped dt-responsive tablaReservas" id="example1" width="100%">
                    
                    <thead>

                      <tr>

                        <!-- <th style="width:10px">#</th>  -->
                        <th style="width:100px">Acciones</th>                            
                        <th>Asistencia</th>    
                        <th>Hotel de recogida</th>
                        <th>Cliente</th> 
                        <th>Celular</th>
                        <th># Adultos</th>
                        <th># Niños</th>
                        <th>Total reserva</th> 
                        <th>Saldo cliente</th>                         
                        <th>Servicio</th>
                        <th>Vendedor</th>
                        <!-- <th>Medio de pago</th> -->
                        <th>Código</th>
                        <th>Fecha Reserva</th>  
                        <th>Bancolombia</th>
                        <th>Efectivo</th>
                        <th>Davivienda</th>
                        <th>Nequi</th>
                        <th>Isla Palma</th>
                        <th>Mercadopago</th>
                        <th>Cortesia</th>                                           
                        <th>PSE</th>                                           

                      </tr>   

                    </thead>

                    <tbody> </tbody>

                  </table>

                </div>

                <div id="containertable2" style="display:none">

                  <table class="table table-bordered table-striped dt-responsive tablaBeneficiarios" id="example2" width="100%">
                    
                    <thead>

                      <tr>

                        <!-- <th style="width:10px">#</th>  -->
                        <th>Código reserva</th>
                        <th>Nombre completo</th> 
                        <th>Tipo de documento</th>
                        <th>Número de documento</th>
                        <th>Tipo de usuario</th>  
                        <th>Asiento</th> 
                        <th>Nacionalidad</th>    
                        <th>Asistencia</th>     

                      </tr>   

                    </thead>

                    <tbody> </tbody>

                  </table>

                </div>
              
            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->

</div>

<!--=====================================
Modal Editar Reserva
======================================-->

<div class="modal" id="editarReserva">

  <div class="modal-dialog">

    <div class="modal-content">

     <!-- Modal Header -->
      <div class="modal-header bg-info">
        <h4 class="modal-title">Editar Reserva <span class="small"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

       <!-- Modal body -->
      <div class="modal-body">

        <!-- <h6 class="lead pt-4 pb-2">Puede modificar la fecha de acuerdo a los días disponibles:</h6> -->

        <input type="hidden" id="urlPrincipal" value="<?php echo $ruta; ?>" >

        <!-- <h5><b>Datos del cliente</b></h5> -->
        <div class="table table-responsive">
          <table class="table table-sm table-bordered">
            <tbody>
              <tr>
                <th style="width: 40%">Servicio vinculado</th>
                <td id="servicioModalEditar"></td>
              </tr>
            </tbody>
          </table>
        <!-- </div>
        <div class="table table-responsive"> -->
          <table class="table table-sm table-bordered">
            <thead>
              <tr class="table-active">
                <th colspan="2">Consultar disponibilidad en otra fecha</th>
              </tr>
              <tr>
                <th colspan="2">
                  <small class="infoDisponibilidad"></small>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th style="width: 40%">Fecha</th>
                <td>
                  <input type="text" class="form-control datepicker entrada" autocomplete="off" name="fecha-ingreso" id="fecha_ingreso" antDate="">
                </td> 
              </tr>
              <tr>
                <th>Personas</th>
                <td><input type="number" class="form-control" id="personas" name="cantidad-personas" readonly></td>
              </tr>
              <tr>
                <td></td>
                <td><button type="button" class="btn btn-outline-info btn-block verDisponibilidad"><i class="fas fa-search mr-2"></i> Consultar</button></td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-bordered">
            <thead>
              <tr class="table-active">
                <th colspan="2">Editar datos del titular de la reserva</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th style="width: 40%">Nombre</th>
                <td>
                  <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    Este campo es obligatorio.
                  </div>
                </td>
              </tr>
              <tr>
                <th>Apellidos</th>
                <td>
                  <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    Este campo es obligatorio.
                  </div>
                </td>
              </tr>
              <tr>
                <th>Tipo de identificación</th>
                <td>
                  <input type="text" class="form-control" id="tipo_identificacion" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    Este campo es obligatorio.
                  </div>
                </td>
              </tr> 
              <tr>
                <th>Número de identificación</th>
                <td>
                  <input type="text" class="form-control" id="numero_identificacion" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    Este campo es obligatorio.
                  </div>
                </td>
              </tr> 
              <tr>
                <th>Número de celular (con indicativo)</th>
                <td>
                  <input type="text" class="form-control" id="celular" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    Este campo es obligatorio.
                  </div>
                </td>
              </tr> 
              <tr>
                <th>Correo electrónico</th>
                <td>
                  <input type="email" class="form-control" id="correo" placeholder="" required>
                  <div class="invalid-feedback">
                    Este campo es obligatorio.
                  </div>
                </td>
              </tr> 

            </tbody>
          </table>

          <table class="table table-sm table-bordered">             
            <tbody>
              <tr>
                <th style="width: 40%">Descargar QR</th>
                <td>
                  <button type="button" class="btn btn-outline-info btn-block float-right" id="descargarQr" codigoReserva>
                    <i class="fas fa-qrcode mr-2"></i> Descargar
                  </button>
                </td>
              </tr>
              <tr>
                <th>Copiar enlace para diligenciar información de los beneficiarios</th>
                <td>
                  <button type="button" class="btn btn-outline-info btn-block float-right" id="copiarEnlaceDatos" codigoReserva>
                    <i class="fas fa-link mr-2"></i> Copiar
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

        </div>
                

      </div>

       <!-- Modal footer -->
      <div class="modal-footer d-flex justify-content-between"> 

        <div>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>

        <div> 
          <button type="button" class="btn btn-primary guardarNuevaReserva" fechaIngreso fechaSalida idReserva>Guardar</button>
        </div>

      </div>

    </div>

  </div>

</div>

<!--=====================================
Modal registrarPago
======================================--> 

<div class="modal" id="registrarPago">

  <div class="modal-dialog">

    <div class="modal-content">

     <!-- Modal Header -->
      <div class="modal-header bg-info">
        <h4 class="modal-title">Registrar pagos a la reserva</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

       <!-- Modal body -->
      <div class="modal-body">


        <div class="table-responsive">
          <table class="table table-sm table-bordered">
            <thead>
              <tr class="table-active">
                <th style="width: 40%">Nombre del cliente</th>
                <th class="text-right">Servicio vinculado</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td id="titularReservaModal"></td>
                <td id="servicioReservaModal" class="text-right"></td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-bordered">
            <!-- <thead>
              <tr>
                <th>Bancolombia</th>
                <th>Efectivo</th>  
                <th>Davivienda</th>
                <th>Nequi</th>
                <th>Daviplata</th>
                <th>Mercadopago</th>
                <th>Payu</th>
              </tr>
            </thead> -->
            <tbody>
              <tr class="table-active">
                <th>Medio de pago</th>
                <th colspan="3" class="text-right">Monto pagado</th>
              </tr>
              <tr>
                <th style="width: 40%">Bancolombia</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment1" metodo="Bancolombia" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>                
              </tr>
              <tr>
                <th>Efectivo</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment2" metodo="Efectivo" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>                
              </tr>
              <tr>
                <th>Davivienda</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment3" metodo="Davivienda" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>
              <tr>
                <th>Nequi</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment4" metodo="Nequi" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>
              <tr>
                <th>Isla Palma</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment5" metodo="Daviplata" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>
              <tr>
                <th>Mercadopago</th>
                <td colspan="3">
                <input type="text" class="form-control inputNumberModal" id="payment6" metodo="Mercadopago" placeholder="0" style="text-align: right; border: 0 !important;" disabled>
                </td>
              </tr>
              <tr>
                <th>Generar link de Mercadopago</th>
                <td colspan="2">
                  <input type="text" class="form-control inputNumberModal" id="montoLinkModal" placeholder="Ingrese el monto" min="10000" style="text-align: right;">
                </td>
                <td><button type="button" class="btn btn-secondary" id="btnLinkPago"><i class="fas fa-copy"></i> Copiar link</button></td>
              </tr>
              
              <tr>
                <th>Cortesia</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment7" metodo="Payu" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>

              <tr>
                <th>PSE</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="payment8" metodo="Payu" placeholder="0" style="text-align: right; border: 0 !important;">
                </td>
              </tr>
              </tbody>
          </table>
          <table class="table table-sm">
            <tbody>              
              <tr class="table-light">
                <th style="width: 40%;">Total pagos</th>
                <td colspan="3">
                  <input type="text" class="form-control inputNumberModal" id="totalSumaModal" placeholder="0" style="text-align: right; border: 0 !important;" disabled>
                </td>
              </tr>
              <tr class="table-light">
                <th>Total reserva</th>
                <td colspan="3" id="">
                  <input type="text" class="form-control inputNumberModal" id="totalReservaModal" placeholder="0" style="text-align: right; border: 0 !important;" disabled>
                </td>
              </tr>
            </tbody>
          </table>
        </div>        

        <!-- <div> -->

        <input type="hidden" id="user" value="<?php echo $_SESSION["idBackend"]; ?>">

        <!-- </div> -->

      </div>

       <!-- Modal footer -->
      <div class="modal-footer d-flex justify-content-between">  

        <div>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>

        <div>
          <button type="button" class="btn btn-primary registrarPagoReserva" id="registrarPagoReserva" >Guardar</button>
        </div>

      </div>

    </div> 

  </div>

</div>

