<?php 

$categorias = ControladorCategorias::ctrMostrarCategorias(null, null);

?>
<div class="search">
        
    <!-- Search Contents -->
    
    <div class="container fill_height">
        <div class="row fill_height">
            <div class="col fill_height">

                <!-- Search Tabs -->

                <div class="search_tabs_container">
                    <div class="search_tabs d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
                        <?php foreach ($categorias as $key => $value): ?>
                            <div class="search_tab d-flex flex-row align-items-center justify-content-lg-center justify-content-start <?php if($key == 0){ echo'active'; } ?>">
                                <!-- <img src="images/cruise.png" alt=""> -->
                                <?php echo $value["tipo"]; ?>
                            </div>
                        <?php endforeach ?>
                    </div>		
                </div>

                <?php foreach ($categorias as $key => $value): ?>	

                    <div class="search_panel <?php if($key == 0){ echo'active'; } ?>">
                        <form action="<?php echo $ruta; ?>reservas" method="post" id="search_form_2" class="search_panel_content d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
                            
                            <div class="search_item">
                                <div>Paquete</div>
                                
                                <select name="id-habitacion" id="adults_2" class="dropdown_item_select search_input" required>
                                    <option value="">--Seleccione--</option>
                                    
                                    <!-- traer los servicios de la categoria -->
                                    
                                    <?php 
                                    
                                    $servicios = ControladorHabitaciones::ctrMostrarHabitaciones(null, null);

                                    foreach ($servicios as $row => $item2):                                        

                                        $precios = json_decode($item2["precio"], true);   	
                
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

                                        if($item2["tipo_h"] == $value["id"] && $visibilidad == "true"):
                                     
                                    ?>

                                    <option value="<?php echo $item2["id_h"]; ?>"><?php echo $item2["estilo"]; ?></option>

                                    <?php endif; endforeach ?>

                                </select>
                            </div>
                            <div class="search_item">
                                <div>Fecha</div>
                                <input type="text" class="form-control datepicker entrada" name="fecha-ingreso" placeholder="Fecha" required>
                            </div>                            
                            <div class="search_item">
                                <div>Personas</div>
                                <input type="number" class="check_in search_input" name="cantidad-personas" value="1" min="1">
                            </div>                            
                            <button type="submit" class="button search_button">Buscar<span></span><span></span><span></span></button>
                        </form>
                    </div>	

                <?php endforeach ?>		

            </div>
        </div>
    </div>		
</div>