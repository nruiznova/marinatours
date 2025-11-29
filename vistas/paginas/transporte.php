<?php

$habitaciones = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

$cat = ControladorCategorias::ctrMostrarCategoria("3"); 

//var_dump($cat);

?>
<!-- recorrer las categorias -->    

<div class="section pt-5 pb-5" style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
            url('images/banner-1.jpg'); background-size: cover; background-position: center;">

    <div class="container" >
            
            <h2 class="text-center border-main"><?php echo $cat["tipo"]; ?></h2>
            <div class="row mb-5">
            
                <?php 
                
                foreach($habitaciones as $key => $value):                         
    
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
        
                                    if($item["visibilidad"] == "true"){
        
                                        $precio = $item["precio"];
                                        $visibilidad = "true";
        
                                    }else{
        
                                        $visibilidad == "false";
        
                                    }
        
                                }
        
                            }
        
                        }                    
        
                        if($visibilidad == "true" && $value["tipo_h"] == $cat["id"]):
        
                        $galeria = json_decode($value["galeria"], true);
                
                ?>

                <div class="col-12 col-lg-6 col-md-6">
                    
                    <div class="card mb-4 box-shadow container-categories" style="cursor: pointer;" onclick="window.location = '<?php echo $ruta.$value["ruta"]; ?>'">
                        <div class="card-body categories-body" style="background-image: url('<?php echo $servidor.$galeria[0]; ?>'); background-size: cover;background-position: center;">

                        </div>
                        <div class="card-footer categories-footer" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('<?php echo $servidor.$galeria[0]; ?>'); background-size: 200%; background-position: bottom;">
                            <h4><?php echo $value["estilo"] ?></h4>
                            <!-- <hr style="border: 1px solid #fff"> -->
                            <p style="display: -webkit-box;
                            max-width: 100%;
                            -webkit-line-clamp: 4;
                            -webkit-box-orient: vertical;
                            overflow: hidden; display: none"><?php echo $value["descripcion_h"] ?></p>
                            <hr style="border: 1px solid #fff">
                            <div class="row">
                                <div class="col-xl-8 d-flex align-items-center">
                                    <h2 class="subtitle-main">$ <?php echo number_format($precio) ?> / por persona</h2>                                    
                                </div>
                                <div class="col-xl-4">
                                    <a type="button" class="btn btn-default btn-lg call-to-action-btn-gold" href="<?php echo $ruta.$value["ruta"]; ?>">Reservar </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <?php endif; endforeach; ?>            

                </div>

            </div>

            

        </div>
        
    </div>    

</div>
