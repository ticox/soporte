<?php




abstract class Controller
{
    protected $_view;
    protected $_modelo;
    protected $_ip;
    
    public function __construct()

    {
                $this->_view = new View(new Request);


                 //-----------------------carga de menu       
                        $rutaModelo = ROOT . 'site'.DS.'models' . DS .'appModel.php';
                        if(is_readable($rutaModelo)){
                            require_once $rutaModelo;
                            $this->_modelo = new appModel;
                         if (session::get('autenticado')){

                                $usuario=Session::get('id_usuario');
                             $this->_view->menu=$this->_modelo->menu(session::get('id_usuario'),session::get('role'));   
                         }else{
                            $usuario='NULL';
                            $this->_view->menu=$this->_modelo->menu(); 
                         }
                     }


                //-------------------------------bloqueo de la web

                        if ($this->_modelo->bloqueo() && $this->_view->_controlador!="ina" && $this->_view->_controlador!="login" && !Session::get('autenticado')) {
                           
                           $this->redireccionar("ina");
                        
                        }
                            
                //------------------------------log del sistema

                       /* if (!empty($_SERVER['HTTP_CLIENT_IP'])){
                                $ip=$_SERVER['HTTP_CLIENT_IP'];
                            }else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
                        }else{
                            $ip=$_SERVER['REMOTE_ADDR'];
                        }
                        $this->_ip=$ip;
                        $this->_modelo->log($ip,new Request,$usuario);*/
   
    }
    
    abstract public function index();
    
    protected function loadModel($modelo)
    {
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'site'.DS.'models' . DS . $modelo . '.php';
        
        if(is_readable($rutaModelo)){
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        }
        else {
            throw new Exception('Error de modelo '.$modelo);
        }
    }
     protected function includeModel($modelo)
    {
        
        $rutaModelo = ROOT . 'site'.DS.'models' . DS . $modelo . '.php';
        
        if(is_readable($rutaModelo)){
            require_once $rutaModelo;
        }
        else {
            throw new Exception('Error en inclucion de modelo '.$modelo);
        }
    }
    
    protected function getLibrary($libreria)
    {
        $rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';
        
        if(is_readable($rutaLibreria)){
            require_once $rutaLibreria;
        }
        else{
            throw new Exception('Error de libreria');
        }
    }
    
   
    
    protected function redireccionar($ruta = false)
    {
        if($ruta){
            header('location:' . BASE_URL . $ruta);
            exit;
        }
        else{
            header('location:' . BASE_URL);
            exit;
        }
    }

   
	

	
	
}

?>
