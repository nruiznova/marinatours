<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!--=====================================
  LOGO
  ======================================-->
  <a href="inicio" class="brand-link pl-0">
  
    <img src="vistas/img/plantilla/icono.png" class="brand-image img-circle elevation-3 ml-0" style="opacity: .8;">

    <span class="brand-text font-weight-light">Heaven Tours</span>

  </a>

  <!--=====================================
  MENÚ
  ======================================-->

  <div class="sidebar">

    <nav class="mt-2">
      
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- botón Ver sitio -->

        <li class="nav-item">
          
          <a href="<?php echo $ruta; ?>" class="nav-link active" target="_blank">
            
            <i class="nav-icon fas fa-globe"></i>
            
            <p>Ver sitio</p>

          </a>

        </li>

        <?php if ($permisos[0]["mostrar"] == true || $permisos[1]["mostrar"] == true): ?>

        <!-- Botón página inicio -->

        <li class="nav-item">

            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Inicio
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">


            <?php if ($permisos[0]["mostrar"] == true): ?>

              <li class="nav-item">

                <a href="inicio" class="nav-link">

                  <i class="fas fa-circle nav-icon"></i>

                  <p>Analíticas generales</p>

                </a>

              </li>

              <?php endif; if ($permisos[1]["mostrar"] == true): ?>

              <li class="nav-item">

                <a href="inicio-v2" class="nav-link">

                  <i class="fas fa-circle nav-icon"></i>

                  <p>Analíticas isla palma</p>

                </a>

              </li>

              <?php endif; ?>

            </ul>

          </li>

        <?php endif ?>

        <?php if ($permisos[2]["mostrar"] == true): ?>

        <!-- Botón página administradores -->
                 
        <li class="nav-item">

          <a href="administradores" class="nav-link">

            <i class="nav-icon fas fa-users-cog"></i>

            <p>Administradores</p>

          </a>

        </li>   
        
        <?php endif ?>

        <?php if ($permisos[3]["mostrar"] == true): ?>

        <!-- Botón página banner -->

        <li class="nav-item">
          <a href="banner" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Banner
            </p>
          </a>
        </li>

        <?php endif ?>        

        <!-- Botón página planes -->

        <!-- <li class="nav-item">
          
          <a href="planes" class="nav-link">
            
            <i class="nav-icon fas fa-shopping-bag"></i>
            
            <p>Planes</p>
          
          </a>

        </li> -->

        <?php if ($permisos[4]["mostrar"] == true): ?>

        <!-- Botón página categorías -->

        <li class="nav-item">
          
          <a href="categorias" class="nav-link">
            
            <i class="nav-icon fas fa-list-ul"></i>
            
            <p>Categorías</p>
          
          </a>

        </li>

        <?php endif ?>

        <?php if ($permisos[5]["mostrar"] == true): ?>

        <!-- Botón página servicios -->

        <li class="nav-item">

          <a href="servicios" class="nav-link">

            <i class="nav-icon fas fa-umbrella-beach"></i>
            
            <p>Servicios</p>

          </a>

        </li>

        <?php endif ?>

        <?php if ($permisos[6]["mostrar"] == true): ?>

        <!-- Botón página reservas -->
      
          <li class="nav-item">

            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Reservas
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="verificar-reserva" class="nav-link">
                  <i class="fas fa-qrcode nav-icon"></i>
                  <p>Comprobar reserva</p>
                </a>
              </li>

              <li class="nav-item">

                <a href="reservas" class="nav-link">

                  <i class="fas fa-list nav-icon"></i>

                  <p>Ver todas</p>

                </a>

              </li>

            </ul>

          </li>

          <?php endif ?>

        <?php if ($permisos[7]["mostrar"] == true): ?>

        <!-- Botón página testimonios -->

        <li class="nav-item">

          <a href="testimonios" class="nav-link">

            <i class="nav-icon fas fa-user-check"></i>

            <p>Testimonios</p>

          </a>

        </li>

        <?php endif ?>

        <?php if ($permisos[8]["mostrar"] == true): ?>

        <!-- Botón página usuarios -->                

         <li class="nav-item">
          
          <a href="usuarios" class="nav-link">
            
            <i class="nav-icon fas fa-users"></i>
            
            <p> Usuarios</p>

          </a>

        </li>

        <?php endif ?>  
        
        <?php if ($permisos[9]["mostrar"] == true): ?>

        <!-- Botón página banner -->

        <li class="nav-item">
          <a href="galeria" class="nav-link">
            <i class="nav-icon far fa-images"></i>
            <p>
              Galeria
            </p>
          </a>
        </li>

        <?php endif ?>

        <!-- Botón página recorrido -->

         <!-- <li class="nav-item">

          <a href="recorrido" class="nav-link">

            <i class="nav-icon fas fa-bus"></i>

            <p>Recorrido</p>

          </a>

        </li> -->

        <!-- Botón página restaurante -->

        <!-- <li class="nav-item">
          
          <a href="restaurante" class="nav-link">
            
            <i class="nav-icon fas fa-utensils"></i>
            
            <p>Restaurante</p>

          </a>

        </li> -->

      </ul>

    </nav>
  
  </div>

</aside>