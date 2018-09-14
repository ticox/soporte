<?php


class Bootstrap
{
    public static function run(Request $peticion)
    {
        $controller = $peticion->getControlador() . 'Controller';
        $rutaControlador = ROOT . 'site'.DS.'controllers' . DS . $controller . '.php';
        $metodo = $peticion->getMetodo();
        $args = $peticion->getArgs();
        
        if(is_readable($rutaControlador)){
            require_once $rutaControlador;
            $controller = new $controller;
            
            if(is_callable(array($controller, $metodo))){
                $metodo = $peticion->getMetodo();
            }
            else{
                $metodo = 'index';
            }
            
            if(isset($args)){
                call_user_func_array(array($controller, $metodo), $args);
            }
            else{
                call_user_func(array($controller, $metodo));
            }
            
        } else {
            throw new Exception('<div class="col-sm-12">  <center> <img src="http://herbalife.ida.bg/404_page_not_found.png" class="img-responsive"> </center> </div> <div class="col-sm-12"> <center> <h3> <p style="color:green"> Lo sentimos esta pagina no ha sido encontrada</p> </h3> </center> </div>');
        }
    }
}

?>