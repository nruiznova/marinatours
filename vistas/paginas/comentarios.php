<section style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
            url('images/banner-1.jpg'); background-size: cover; background-position: center;">
  <div class="container pt-5 pb-5 text-body">
    <div class="row d-flex justify-content-center">
      <div class="col-md-11 col-lg-9 col-xl-7">


        <?php 
        
            $testimonios = ModeloReservas::mdlMostrarTestimoniosCompletos("testimonios");

            foreach ($testimonios as $key => $value):

              if($value["aprobado"] == 1):                    

        ?>

        <div class="mb-4">            
            <div class="card w-100">
            <div class="card-body p-4">
                <div class="gallery-service">

                <!-- Slideshow container -->
                <div class="slideshow-container">

                <?php 

                    $galeria = json_decode($value["galeria"], true);
                    
                    if($galeria){

                        foreach ($galeria as $row2 => $source) {

                            //var_dump($source);                        
    
                            // $path = str_replace(" ","%20", $ruta.$source);
    
                            // list($width, $height, $type, $attr) = getimagesize($path);
    
                            if (strpos($source, "mp4") !== false){
    
                                echo'<div class="mySlides'.($key+1).'">
                                    <div class="numbertext">'.($row2 + 1).' / '.count($galeria).'</div>
                                    <video width="100%" autoplay muted loop style="margin-bottom: 0">
                                        <source src="'.$source.'" type="video/mp4" width="100%">                            
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="text"></div>';
    
                            }else{
    
                                echo'<div class="mySlides'.($key+1).'">
                                    <div class="numbertext">'.($row2 + 1).' / '.count($galeria).'</div>
                                <img src="'.$ruta.$source.'" style="width:100%">
                                <div class="text"></div>
                                </div>';
    
                            }
    
                        }
                        
                        echo'<!-- Next and previous buttons -->
                        <a class="prev" onclick="plusSlides(-1, '.$key.')"><i class="fas fa-chevron-left"></i></a>
                        <a class="next" onclick="plusSlides(1, '.$key.')"><i class="fas fa-chevron-right"></i></a>';
                    
                    }

                ?> 

                </div>
                <br>            

                </div> 
              <div class="">
                <h5><?php echo $value["nombre"] ?> (<?php echo $value["pais"] ?>)</h5>
                <p class="small"><?php echo $value["fecha"] ?></p>
                <p>
                    <?php echo $value["testimonio"] ?>
                </p>

                <!-- <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <a href="#!" class="link-muted me-2"><i class="fas fa-thumbs-up me-1"></i>132</a>
                    <a href="#!" class="link-muted"><i class="fas fa-thumbs-down me-1"></i>15</a>
                  </div>
                  <a href="#!" class="link-muted"><i class="fas fa-reply me-1"></i> Reply</a>
                </div> -->
              </div>
            </div>
          </div>
        </div>

        <?php endif; ?>

        <?php endforeach; ?>

      </div>
    </div>
  </div>
<!-- </section> -->

  <div class="container pt-5 pb-5 text-body">
    <div class="row d-flex justify-content-center">
      <div class="col-md-11 col-lg-9 col-xl-7">
        <div class="card w-100">
          <div class="card-body p-4">
            <div class="d-flex flex-start">
              <!-- <img class="rounded-circle shadow-1-strong me-3"
                src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(21).webp" alt="avatar" width="65"
                height="65" /> -->
              <div class="w-100">

                <form method="post">

                    <h5>Agregar una reseña</h5>   
                    <hr>
                    <div data-mdb-input-init class="form-outline mb-3">
                      <label class="form-label" for="nameComment">Indicanos tu nombre</label>
                      <input class="form-control" id="nameComment" name="nombre" required>                    
                    </div>
                    <div data-mdb-input-init class="form-outline mb-3">
                      <label class="form-label" for="countryComment">De que país nos visitas</label>
                      <input class="form-control" id="countryComment" name="pais" required>                    
                    </div>             
                    <div data-mdb-input-init class="form-outline mb-3">
                      <label class="form-label" for="textAreaExample">Deja tu reseña</label>
                      <textarea class="form-control" id="textAreaExample" name="testimonio" rows="4" required></textarea>                    
                    </div>
                    <ul class="row p-0 vistaGaleria">
                    </ul>
                    <input type="hidden" class="inputNuevaGaleria" name="galeria">
                    <input type="file" multiple id="galeria" class="d-none">

                    <label for="galeria" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleria">

                        Haz clic aquí o arrastra las imágenes para agregarlas a tu reseña <br>
                        <span class="help-block small">Dimensiones: 940px * 480px | Peso Max. 2MB | Formato: JPG o PNG</span>
                        
                    </label>

                    <div class="d-flex justify-content-between mt-3">
                    <!-- <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-success">Danger</button> -->
                    <button type="submit" class="btn btn-default btn-lg call-to-action-btn-gold" href="#">Enviar </button>
                    </div>

                </form>

                    <?php

                        $registroTestimonio = new ControladorReservas();
                        $registroTestimonio -> ctrCrearTestimonio();

                    ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>