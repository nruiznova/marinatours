<!-- galeria -->

<div class="section pt-5 pb-5" style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
            url('images/bg.jpg'); background-size: cover; background-position: center;">

    <div class="container">

        <!-- <h1 class="title-main text-center">galeria heaven tours cartagena sas</h1> -->
        
        <?php 
        $galeria = ModeloHabitaciones::mdlMostrarHabitaciones("galeria", null, null);
        
        if ($galeria) {
            foreach ($galeria as $g => $gal) {
                if ($g != 0) {
                    if ($g != 1) {
                        echo '<div style="min-height: 150px"></div>';
                    }
        
                    echo '<h2 class="text-center border-main" style="color: black">' . $gal["nombre"] . '</h2>';
        
                    echo '<div class="row">';
        
                    $gallery = json_decode($gal["galeria"]);
        
                    foreach ($gallery as $key => $value) {
                        echo '<div class="col-4 col-md-2 mt-3">';
        
                        if (strpos($value, "mp4") !== false) {
                            $videoUrl = $servidor . $value;
                            $poster = $servidor . "vistas/img/plantilla/video.png";
        
                            echo '
                            <a 
                                data-fancybox="galeria-' . $g . '" 
                                href="' . $videoUrl . '" 
                                data-type="video"
                            >
                                <img src="' . $poster . '" class="img-fluid" style="aspect-ratio:1/1; object-fit:cover;" />
                            </a>';
                        } else {
                            echo '
                            <a 
                                data-fancybox="galeria-' . $g . '" 
                                href="' . $servidor . $value . '"
                            >
                                <img src="' . $servidor . $value . '" class="img-fluid" style="aspect-ratio:1/1; object-fit:cover;" />
                            </a>';
                        }
        
                        echo '</div>'; // cierre col
                    }
        
                    echo '</div>'; // cierre row
                }
            }
        }
        ?>
        
        <!-- Contenedor de PhotoSwipe -->
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true"></div>

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