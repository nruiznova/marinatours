<?php 

$servicios = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

?>

<!-- Offers Item -->

<div class="container pt-5 mb-5 noprint">

    <div class="row">
        <div class="col">
            <h2 class="section_title">Otros servicios</h2>
        </div>
    </div>

    <!-- Rooms -->

    <?php 
    
    foreach ($servicios as $key => $value):

        $precios = json_decode($value["precio"], true);   	
                
	    $visibilidad = "false";                                           

        if(isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok"){                                    

            foreach ($precios as $row => $item) {
                
                if($_SESSION["nombre"] == $item["usuario"]){
        
                    if($item["visibilidad"] == "true"){

                        $precio = $item["precio"];
                        $precioKids = $item["precioKids"];
                        $visibilidad = "true";

                    }else{

                        $visibilidad == "false";

                    }

                }

            }
            
        }else{

            foreach ($precios as $row => $item) {

                if($item["usuario"] == "Público en general"){

                    $precio = $item["precio"];
                    
                    if($item["visibilidad"] == "true"){
                        $visibilidad = "true";
                    }else{
                        $visibilidad = "false";
                    }

                }

            }

        }

        if(isset($_POST["id-habitacion"]) && $visibilidad == "true"):

        $galeria = json_decode($value["galeria"], true);
    
    ?>

        <?php if($_POST["id-habitacion"] != $value["id_h"]): ?>

        <div class="rooms">

            <!-- Room -->
            <div class="room">

                <!-- Room -->
                <div class="row">
                    <div class="col-lg-2">
                        <div class="room_image"><img src="<?php echo $servidor.$galeria[0]; ?>" alt="https://unsplash.com/@grovemade"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="room_content">
                            <div class="room_title"><?php echo $value["estilo"] ?></div>
                            <div class="room_price">$<?php echo number_format($precio) ?> COP / por persona</div>
                            <!-- <div class="room_text">FREE cancellation before 23:59 on 20 December 2017</div>
                            <div class="room_extra">Breakfast $7.50</div> -->
                        </div>
                    </div>
                    <div class="col-lg-3 text-lg-right">
                        <div class="room_button">
                            <div class="button book_button trans_200"><a href="<?php echo $ruta.$value["ruta"]; ?>">Reservar<span></span><span></span><span></span></a></div>
                        </div>
                    </div>
                </div>	
            </div>			

        </div>	

        <?php endif; ?>     


    <?php 
            
    elseif($value["ruta"] != $_GET["pagina"] && $visibilidad == "true"): 
        
    $galeria = json_decode($value["galeria"], true);
        
    ?>

        <div class="rooms">

            <!-- Room -->
            <div class="room">

                <!-- Room -->
                <div class="row">
                    <div class="col-lg-2">
                        <div class="room_image"><img src="<?php echo $servidor.$galeria[0]; ?>" alt="https://unsplash.com/@grovemade"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="room_content">
                            <div class="room_title text-uppercase"><?php echo $value["estilo"] ?></div>
                            <div class="room_price">$<?php echo number_format($precio) ?> COP / por persona</div>
                            <!-- <div class="room_text">FREE cancellation before 23:59 on 20 December 2017</div>
                            <div class="room_extra">Breakfast $7.50</div> -->
                        </div>
                    </div>
                    <div class="col-lg-3 text-lg-right">
                        <div class="room_button">
                            <div class="button book_button trans_200"><a href="<?php echo $ruta.$value["ruta"]; ?>">Reservar<span></span><span></span><span></span></a></div>
                        </div>
                    </div>
                </div>	
            </div>			

        </div>	
    
    <?php endif ?>    
    
    <?php endforeach ?>

</div>