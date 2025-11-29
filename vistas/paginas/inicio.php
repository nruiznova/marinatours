

<!-- video principal --> 

<?php 

$banner = ControladorBanner::ctrMostrarBanner();

if(strpos($banner[0]["img"], "mp4") === false):

?>
 
<img src='<?php echo $servidor.$banner[0]["img"]; ?>' class='img-fluid' style='width: 100%'>

<?php else: ?>

<video width="100%" autoplay muted loop style="margin-bottom: 0">
    <source src="<?php echo $servidor.$banner[0]["img"]; ?>" type="video/mp4">
    <!-- <source src="images/movie.ogg" type="video/ogg"> -->
    Your browser does not support the video tag.
</video>

<?php endif; ?>

<div class="banner-main" style="margin-top: -10px">
    <div class="row">            
        <div class="col-md-7">
            <h2 class="title-main mb-2">HEAVEN TOUR CARTAGENA SAS</h2>
            <p class="text-justify">Es un operador turístico dedicado a ofrecer experiencias inolvidables en los destinos más paradisíacos de Cartagena y sus alrededores. Con un enfoque en la calidad, seguridad y sostenibilidad, nuestro equipo se compromete a brindar un servicio excepcional que supere las expectativas de nuestros clientes. 
            <br>
            <br>
            <b>¡Descubre con nosotros las maravillas de Isla Palma, Isla Múcura y más!</b>
            </p>
        </div>
        <div class="col-md-4 offset-md-1 d-flex justify-content-center align-items-center">
            <img src="images/logo.png" width="50%"> 
        </div>
    </div>
</div>

<?php include "modulos/habitaciones.php" ?>

<!-- galeria -->

<div class="section pt-5 pb-5" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
            url('images/galeria_general.JPG'); background-size: cover; background-position: center;">

    <div class="container mt-5 mb-5">

        <h1 class="title-main text-center pb-5">Disfruta de estas increibles experiencias</h1>        

        <h2 class="text-center border-main" style="color: #fff">Galeria general</h2>
        
        <div class="row">

        <?php 
           
            $galeria = ModeloHabitaciones::mdlMostrarHabitaciones("galeria", "id_galeria", "1");

            if($galeria){             
            
                $gallery = json_decode($galeria["galeria"]);
    
                foreach ($gallery as $key => $value) {
                        echo '<div class="col-4 col-md-2 mt-3">';
        
                        if (strpos($value, "mp4") !== false) {
                            $videoUrl = $servidor . $value;
                            $poster = $servidor . "vistas/img/plantilla/video.png";
        
                            echo '
                            <a 
                                data-fancybox="galeria" 
                                href="' . $videoUrl . '" 
                                data-type="video"
                            >
                                <img src="' . $poster . '" class="img-fluid" style="aspect-ratio:1/1; object-fit:cover;" />
                            </a>';
                        } else {
                            echo '
                            <a 
                                data-fancybox="galeria" 
                                href="' . $servidor . $value . '"
                            >
                                <img src="' . $servidor . $value . '" class="img-fluid" style="aspect-ratio:1/1; object-fit:cover;" />
                            </a>';
                        }
        
                        echo '</div>'; // cierre col
                    }
        
            }
        
        ?>
        
        <div class="col-sm-12 mt-5 text-center">
            <a type="button" class="btn btn-default btn-lg call-to-action-btn-gold" href="<?php echo $ruta; ?>galeria">Ver más</a>
        </div>

        </div>                    

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <div class="modal-body">
        <img src="" id="show-image" style="width: 100%">
        <video id="show-video" autoplay muted loop style="margin-bottom: 0; width: 100%;">
            
        </video>
        <a class="prev" prev onclick="showNimage($(this).attr('prev'))">&#10094;</a>
        <a class="next" next onclick="showNimage($(this).attr('next'))">&#10095;</a>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>